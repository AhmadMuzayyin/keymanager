<?php

namespace Database\Seeders;

use App\Models\LicenseLog;
use Illuminate\Database\Seeder;

class TestLicenseLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ips = [
            '192.168.1.100',
            '203.0.113.45',
            '198.51.100.23',
        ];

        $domains = [
            'example.com',
            'demo.com',
            'test.com',
        ];

        $licenses = [
            [
                'key' => 'ABC-123-XYZ',
                'product' => 'WordPress Theme Pro',
                'status' => 'active',
                'domain' => null,
                'expires_at' => null,
            ],
            [
                'key' => 'DEF-456-UVW',
                'product' => 'Plugin SEO Master',
                'status' => 'suspended',
                'domain' => 'example.com',
                'expires_at' => now()->addMonths(6),
            ],
            [
                'key' => 'GHI-789-RST',
                'product' => 'WooCommerce Extension',
                'status' => 'active',
                'domain' => null,
                'expires_at' => now()->subDays(10),
            ],
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/605.1.15',
            'Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0',
        ];

        // Generate test logs
        foreach ($ips as $index => $ip) {
            $domain = $domains[$index];
            $userAgent = $userAgents[$index];

            // Create multiple logs for each IP
            for ($i = 0; $i < rand(5, 20); $i++) {
                $license = $licenses[array_rand($licenses)];
                
                // Determine if valid or invalid
                $isValid = true;
                $invalidReason = null;

                if ($license['status'] !== 'active') {
                    $isValid = false;
                    $invalidReason = 'license_' . $license['status'];
                } elseif ($license['expires_at'] && $license['expires_at']->isPast()) {
                    $isValid = false;
                    $invalidReason = 'license_expired';
                } elseif ($license['domain'] && $license['domain'] !== $domain) {
                    $isValid = false;
                    $invalidReason = 'domain_mismatch';
                }

                LicenseLog::create([
                    'license_key' => $license['key'],
                    'license_product_name' => $license['product'],
                    'license_status' => $license['status'],
                    'license_domain' => $license['domain'],
                    'license_expires_at' => $license['expires_at'],
                    'request_domain' => $domain,
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'status' => $isValid ? 'valid' : 'invalid',
                    'invalid_reason' => $invalidReason,
                    'checked_at' => now()->subMinutes(rand(1, 1440)),
                ]);
            }
        }
    }
}
