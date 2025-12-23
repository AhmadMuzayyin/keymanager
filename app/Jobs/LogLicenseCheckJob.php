<?php

namespace App\Jobs;

use App\Models\License;
use App\Models\LicenseLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogLicenseCheckJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $licenseKey,
        public string $domain,
        public string $ip,
        public string $userAgent,
        public bool $valid,
        public ?string $invalidReason = null)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ambil data lisensi untuk snapshot
        $license = License::where('key', $this->licenseKey)->first();

        LicenseLog::create([
            'license_key' => $this->licenseKey,
            'license_product_name' => $license?->product_name,
            'license_status' => $license?->status,
            'license_domain' => $license?->domain,
            'license_expires_at' => $license?->expires_at,
            'request_domain' => $this->domain,
            'ip_address' => $this->ip,
            'user_agent' => $this->userAgent,
            'status' => $this->valid ? 'valid' : 'invalid',
            'invalid_reason' => $this->invalidReason,
            'checked_at' => now(),
        ]);
    }
}
