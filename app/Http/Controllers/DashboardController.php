<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseLog;

class DashboardController extends Controller
{
    public function index()
    {
        $activeLicenses = License::where('status', 'active')->count();
        $totalLicenses = License::count();
        $suspendedLicenses = License::where('status', 'suspended')->count();
        $recentLogs = LicenseLog::orderBy('checked_at', 'desc')->take(5)->get();
        $expiringLicenses = License::where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addDays(7))
            ->orderBy('expires_at', 'asc')
            ->get();
        $todayLogs = LicenseLog::whereDate('checked_at', now())->count();

        return view('Dashboard.index', compact('activeLicenses', 'totalLicenses', 'suspendedLicenses', 'recentLogs', 'expiringLicenses', 'todayLogs'));
    }
}
