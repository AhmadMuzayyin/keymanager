<?php

namespace App\Services;

use App\Models\License;

class LicenseService
{
    public function validate(string $key, string $domain): array
    {
        $license = License::where('key', $key)->first();

        if (! $license) {
            return [
                'valid' => false,
                'reason' => 'license_not_found'
            ];
        }

        if ($license->status !== 'active') {
            return [
                'valid' => false,
                'reason' => 'license_' . $license->status
            ];
        }

        if ($license->expires_at && $license->expires_at->isPast()) {
            return [
                'valid' => false,
                'reason' => 'license_expired'
            ];
        }

        // Validasi domain jika license memiliki domain spesifik
        if ($license->domain && $license->domain !== $domain) {
            return [
                'valid' => false,
                'reason' => 'domain_mismatch'
            ];
        }

        return [
            'valid' => true,
            'reason' => null
        ];
    }

    public function getLicenseByKey(string $key): ?License
    {
        return License::where('key', $key)->first();
    }

    public function generateKey()
    {
        return strtoupper(bin2hex(random_bytes(4)).'-'.bin2hex(random_bytes(2)).'-'.bin2hex(random_bytes(2)).'-'.bin2hex(random_bytes(2)).'-'.bin2hex(random_bytes(6)));
    }
}
