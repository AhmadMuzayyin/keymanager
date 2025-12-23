<?php

namespace App\Http\Controllers;

use App\Models\LicenseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LisenseLogController extends Controller
{
    public function index(Request $request)
    {
        $query = LicenseLog::select(
            'ip_address',
            'request_domain',
            'user_agent',
            DB::raw('COUNT(*) as total_requests'),
            DB::raw('SUM(CASE WHEN status = "valid" THEN 1 ELSE 0 END) as valid_count'),
            DB::raw('SUM(CASE WHEN status = "invalid" THEN 1 ELSE 0 END) as invalid_count'),
            DB::raw('MAX(checked_at) as last_activity')
        )
        ->groupBy('ip_address', 'request_domain', 'user_agent')
        ->orderBy('last_activity', 'desc');

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['valid', 'invalid'])) {
            $query->having(DB::raw('SUM(CASE WHEN status = "' . $request->status . '" THEN 1 ELSE 0 END)'), '>', 0);
        }

        $logs = $query->paginate(15);

        return view('log.index', compact('logs'));
    }

    public function show(Request $request, $ip)
    {
        $query = LicenseLog::where('ip_address', $ip)
            ->orderBy('checked_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['valid', 'invalid'])) {
            $query->where('status', $request->status);
        }

        $logs = $query->paginate(20);
        
        // Get summary
        $summary = LicenseLog::where('ip_address', $ip)
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "valid" THEN 1 ELSE 0 END) as valid'),
                DB::raw('SUM(CASE WHEN status = "invalid" THEN 1 ELSE 0 END) as invalid'),
                'request_domain',
                'user_agent'
            )
            ->groupBy('request_domain', 'user_agent')
            ->first();

        return view('log.show', compact('logs', 'ip', 'summary'));
    }
}
