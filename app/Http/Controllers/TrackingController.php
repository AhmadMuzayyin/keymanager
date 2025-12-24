<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseLog;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function show(Request $request, string $code)
    {
        $order = Order::with(['customer', 'items', 'licenses'])
            ->where('order_number', $code)
            ->first();

        if (!$order) {
            $license = License::with('customer')
                ->where('purchase_code', $code)
                ->first();

            if ($license) {
                $recentLogs = LicenseLog::where('license_key', $license->key)
                    ->orderBy('checked_at', 'desc')
                    ->limit(5)
                    ->get();

                return view('tracking.show-license', compact('license', 'recentLogs'));
            }

            return view('tracking.not-found', ['code' => $code]);
        }

        return view('tracking.show-order', compact('order'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        return redirect()->route('tracking.show', $request->code);
    }
}
