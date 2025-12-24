<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\LicenseLog;
use App\Services\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LisenseController extends Controller
{
    public function index()
    {
        $licenses = License::with('customer')->orderBy('created_at', 'desc')->paginate(10);

        return view('license.index', compact('licenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'product' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'license_plan' => 'required|in:starter,pro,unlimited,custom',
            'custom_duration' => 'required_if:license_plan,custom|nullable|integer|min:1',
            'custom_type' => 'required_if:license_plan,custom|nullable|in:days,months,years',
            'max_activation' => 'required|integer|min:1',
            'status' => 'required|in:active,suspended,revoked',
        ]);

        $expiresAt = $this->calculateExpiresAt(
            $request->license_plan,
            $request->custom_duration,
            $request->custom_type
        );

        try {
            DB::beginTransaction();
            License::create([
                'customer_id' => $request->customer_id,
                'key' => (new LicenseService)->generateKey(),
                'product_name' => $request->product,
                'domain' => $request->domain,
                'expires_at' => $expiresAt,
                'max_activations' => $request->max_activation,
                'status' => $request->status,
            ]);
            DB::commit();

            return redirect()->route('licenses.index')->with('success', 'License created successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to create license.'])->withInput();
        }
    }

    private function calculateExpiresAt(string $plan, ?int $duration = null, ?string $type = null)
    {
        return match ($plan) {
            'starter' => now()->addYear(),
            'pro' => now()->addYears(2),
            'unlimited' => null,
            'custom' => match ($type) {
                'days' => now()->addDays($duration),
                'months' => now()->addMonths($duration),
                'years' => now()->addYears($duration),
                default => now()->addMonths($duration),
            },
            default => null,
        };
    }

    public function update(Request $request, License $license)
    {
        $request->validate([
            'product' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
            'license_plan' => 'required|in:starter,pro,unlimited,custom',
            'custom_duration' => 'nullable|integer|min:1',
            'custom_type' => 'nullable|in:days,months,years',
            'max_activation' => 'required|integer|min:1',
            'status' => 'required|in:active,suspended,revoked',
        ]);
        try {
            DB::beginTransaction();

            $expiresAt = $this->calculateExpiresAt(
                $request->license_plan,
                $request->custom_duration,
                $request->custom_type
            );

            $license->update([
                'product_name' => $request->product,
                'domain' => $request->domain,
                'expires_at' => $expiresAt,
                'max_activations' => $request->max_activation,
                'status' => $request->status,
            ]);
            DB::commit();

            return redirect()->route('licenses.index')->with('success', 'License updated successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to update license.'])->withInput();
        }
    }

    public function destroy(License $license)
    {
        try {
            DB::beginTransaction();
            $license->delete();
            DB::commit();

            return redirect()->route('licenses.index')->with('success', 'License deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to delete license.']);
        }
    }

    public function check(Request $request, LicenseService $service)
    {
        $credentials = Validator::make($request->all(), [
            'key' => 'required|string',
            'domain' => 'required|string',
        ]);
        if ($credentials->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request parameters',
                'errors' => $credentials->errors(),
            ], 422);
        }
        $result = $service->validate(
            $request->key,
            $request->domain
        );
        $license = $service->getLicenseByKey($request->key);
        LicenseLog::create([
            'license_key' => $request->key,
            'license_product_name' => $license ? $license->product_name : null,
            'license_status' => $license ? $license->status : null,
            'license_domain' => $license ? $license->domain : null,
            'license_expires_at' => $license ? $license->expires_at : null,
            'request_domain' => $request->domain,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent() ?? 'Unknown',
            'status' => $result['valid'] ? 'valid' : 'invalid',
            'invalid_reason' => $result['reason'],
            'checked_at' => now(),
        ]);
        if ($result['valid']) {
            return response()->json([
                'status' => true,
                'message' => 'License is valid',
                'data' => [
                    'product_name' => $license->product_name,
                    'domain' => $license->domain,
                    'expires_at' => $license->expires_at,
                    'max_activations' => $license->max_activations,
                    'status' => $license->status,
                ],
            ]);
        }

        return response()->json([
            'status' => $result['valid'],
            'message' => $result['valid'] ? 'License is valid' : 'License is invalid or expired',
        ]);
    }
}
