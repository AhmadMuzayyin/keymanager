<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\License;
use App\Models\LicenseLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLicenses = License::count();
        $activeLicenses = License::where('status', 'active')->count();
        $suspendedLicenses = License::where('status', 'suspended')->count();
        $revokedLicenses = License::where('status', 'revoked')->count();
        
        $totalCustomers = Customer::count();
        
        $todayLogs = LicenseLog::whereDate('checked_at', now())->count();
        $validLogsToday = LicenseLog::whereDate('checked_at', now())->where('status', 'valid')->count();
        $invalidLogsToday = LicenseLog::whereDate('checked_at', now())->where('status', 'invalid')->count();
        
        $recentLogs = LicenseLog::orderBy('checked_at', 'desc')->take(10)->get();
        
        $expiringLicenses = License::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addDays(30))
            ->orderBy('expires_at', 'asc')
            ->take(5)
            ->get();

        $chartData = $this->getChartData();

        $recentCustomers = Customer::withCount('licenses')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('Dashboard.index', compact(
            'totalLicenses',
            'activeLicenses',
            'suspendedLicenses',
            'revokedLicenses',
            'totalCustomers',
            'todayLogs',
            'validLogsToday',
            'invalidLogsToday',
            'recentLogs',
            'expiringLicenses',
            'chartData',
            'recentCustomers'
        ));
    }

    private function getChartData()
    {
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = LicenseLog::whereDate('checked_at', $date)->count();
            $validCount = LicenseLog::whereDate('checked_at', $date)->where('status', 'valid')->count();
            $invalidCount = LicenseLog::whereDate('checked_at', $date)->where('status', 'invalid')->count();
            
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('D'),
                'day' => $date->format('d M'),
                'count' => $count,
                'valid' => $validCount,
                'invalid' => $invalidCount,
                'percentage' => 0,
            ];
        }

        $maxCount = max(array_column($data, 'count'));
        if ($maxCount > 0) {
            foreach ($data as &$day) {
                $day['percentage'] = round(($day['count'] / $maxCount) * 100);
            }
        }

        return $data;
    }
}
