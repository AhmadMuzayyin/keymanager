<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use App\Models\ProductRequirement;
use App\Models\ProductVersion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private array $androidApps = [
        'POS Kasir', 'Inventory Management', 'Absensi Karyawan', 'E-Wallet', 'Food Delivery',
        'Toko Online', 'Perpustakaan Digital', 'Rental Kendaraan', 'Booking Hotel', 'Travel App',
        'Chat Messenger', 'Social Media', 'News Portal', 'Video Streaming', 'Music Player',
        'Fitness Tracker', 'Diet Planner', 'Medical Records', 'Pharmacy Store', 'Clinic Management',
        'School Management', 'LMS Learning', 'Quiz Online', 'Exam System', 'Student Portal',
        'HR Management', 'Payroll System', 'Project Management', 'Task Manager', 'CRM System',
        'Restaurant POS', 'Laundry App', 'Salon Booking', 'Parking System', 'Warehouse Management',
        'Real Estate', 'Property Listing', 'Car Dealer', 'Job Portal', 'Freelancer App',
        'Marketplace', 'Auction App', 'Donation Platform', 'Crowdfunding', 'Invoice Generator',
        'Expense Tracker', 'Budget Planner', 'Stock Trading', 'Crypto Wallet', 'Banking App',
    ];

    private array $desktopApps = [
        'Accounting System', 'Point of Sale', 'Inventory Control', 'Billing Software', 'Invoice Manager',
        'HR Information System', 'Payroll Management', 'Employee Attendance', 'Leave Management', 'Recruitment System',
        'School Admin', 'Library System', 'Exam Management', 'Student Information', 'Grade Book',
        'Hospital Management', 'Clinic Software', 'Pharmacy System', 'Lab Management', 'Patient Records',
        'Hotel Booking', 'Restaurant Management', 'Cafe POS', 'Gym Management', 'Spa Booking',
        'Real Estate CRM', 'Property Management', 'Rental System', 'Asset Tracking', 'Fleet Management',
        'Warehouse System', 'Supply Chain', 'Manufacturing ERP', 'Quality Control', 'Production Planning',
        'Document Management', 'File Archiver', 'Report Generator', 'Data Analytics', 'Business Intelligence',
        'Project Tracker', 'Time Management', 'Resource Planning', 'Budget Control', 'Financial Report',
        'Customer Support', 'Helpdesk System', 'Ticket Management', 'Knowledge Base', 'Live Chat',
    ];

    private array $webApps = [
        'E-Commerce Platform', 'Multi Vendor Marketplace', 'Online Store', 'Digital Product Store', 'Subscription Box',
        'Learning Management', 'Online Course', 'Virtual Classroom', 'Tutoring Platform', 'Certification System',
        'Job Board', 'Freelance Marketplace', 'Recruitment Portal', 'Resume Builder', 'Career Platform',
        'Social Network', 'Community Forum', 'Blog Platform', 'News Website', 'Magazine CMS',
        'Booking System', 'Appointment Scheduler', 'Event Management', 'Ticket Booking', 'Reservation System',
        'CRM Application', 'Sales Pipeline', 'Lead Management', 'Marketing Automation', 'Email Campaign',
        'Project Management', 'Task Board', 'Team Collaboration', 'Document Sharing', 'Video Conference',
        'Healthcare Portal', 'Telemedicine', 'Appointment Booking', 'Medical Records', 'Pharmacy Online',
        'Real Estate Portal', 'Property Listing', 'Agent Directory', 'Mortgage Calculator', 'Virtual Tour',
        'Food Delivery', 'Restaurant Ordering', 'Table Reservation', 'Menu Management', 'Kitchen Display',
    ];

    private array $adjectives = [
        'Pro', 'Premium', 'Ultimate', 'Advanced', 'Smart', 'Modern', 'Elite', 'Super', 'Mega', 'Ultra',
        'Complete', 'Full', 'Total', 'Perfect', 'Best', 'Top', 'Prime', 'Max', 'Plus', 'Express',
    ];

    private array $versions = ['1.0.0', '1.0.1', '1.1.0', '1.2.0', '2.0.0', '2.1.0', '2.2.0', '3.0.0'];

    public function run(): void
    {
        $categories = ProductCategory::all();

        if ($categories->isEmpty()) {
            $this->command->info('Running ProductCategorySeeder first...');
            $this->call(ProductCategorySeeder::class);
            $categories = ProductCategory::all();
        }

        $this->command->info('Creating 500 products...');

        $productNames = [];

        for ($i = 0; $i < 500; $i++) {
            $type = $this->getRandomType();
            $baseName = $this->getBaseName($type);
            $adjective = $this->adjectives[array_rand($this->adjectives)];

            $name = "{$baseName} {$adjective}";
            $counter = 1;
            while (in_array($name, $productNames)) {
                $name = "{$baseName} {$adjective} ".($counter > 1 ? "V{$counter}" : Str::random(3));
                $counter++;
            }
            $productNames[] = $name;

            $product = Product::create([
                'name' => $name,
                'slug' => Str::slug($name).'-'.Str::random(5),
                'description' => $this->generateDescription($name, $type),
                'long_description' => $this->generateLongDescription($name, $type),
                'type' => $type,
                'thumbnail' => $this->getRandomThumbnail($type),
                'demo_url' => rand(0, 1) ? 'https://demo.example.com/'.Str::slug($name) : null,
                'is_active' => rand(1, 10) <= 9,
                'is_featured' => rand(1, 10) <= 2,
            ]);

            $this->attachCategories($product, $categories, $type);
            $this->createPrices($product);
            $this->createVersion($product);
            $this->createRequirements($product, $type);

            if ($i % 50 === 0) {
                $this->command->info("Created {$i} products...");
            }
        }

        $this->command->info('500 products created successfully!');
    }

    private function getRandomType(): string
    {
        $types = ['android', 'desktop', 'web'];

        return $types[array_rand($types)];
    }

    private function getBaseName(string $type): string
    {
        return match ($type) {
            'android' => $this->androidApps[array_rand($this->androidApps)],
            'desktop' => $this->desktopApps[array_rand($this->desktopApps)],
            'web' => $this->webApps[array_rand($this->webApps)],
        };
    }

    private function getRandomThumbnail(string $type): ?string
    {
        if (rand(1, 10) <= 3) {
            return null;
        }

        $colors = ['3B82F6', '10B981', '8B5CF6', 'F59E0B', 'EF4444', '06B6D4', 'EC4899', '6366F1'];
        $color = $colors[array_rand($colors)];

        return "https://placehold.co/400x400/{$color}/white?text=".urlencode(ucfirst($type));
    }

    private function generateDescription(string $name, string $type): string
    {
        $templates = [
            "Aplikasi {$name} adalah solusi {$type} terbaik untuk bisnis Anda. Dilengkapi dengan fitur lengkap dan mudah digunakan.",
            "{$name} - Solusi {$type} modern dengan antarmuka yang intuitif dan performa tinggi untuk kebutuhan profesional.",
            "Dapatkan {$name}, aplikasi {$type} canggih dengan teknologi terkini. Cocok untuk skala kecil hingga enterprise.",
            "{$name} hadir sebagai aplikasi {$type} all-in-one yang akan meningkatkan produktivitas dan efisiensi kerja Anda.",
            "Aplikasi {$type} {$name} dengan desain modern, fitur premium, dan dukungan teknis profesional 24/7.",
        ];

        return $templates[array_rand($templates)];
    }

    private function generateLongDescription(string $name, string $type): string
    {
        $features = [
            'Dashboard interaktif dengan statistik real-time',
            'Multi-user dengan role management',
            'Laporan lengkap dalam format PDF dan Excel',
            'Backup otomatis dan restore data',
            'Notifikasi push dan email',
            'API integration siap pakai',
            'Multi-bahasa (Indonesia & English)',
            'Dark mode dan light mode',
            'Responsive design untuk semua device',
            'Enkripsi data tingkat tinggi',
        ];

        shuffle($features);
        $selectedFeatures = array_slice($features, 0, rand(5, 8));
        $featureList = implode("</li>\n<li>", $selectedFeatures);

        return "<h2>Tentang {$name}</h2>
<p>{$name} adalah aplikasi {$type} profesional yang dirancang untuk memenuhi kebutuhan bisnis modern. Dengan antarmuka yang intuitif dan fitur yang komprehensif, aplikasi ini akan membantu meningkatkan efisiensi dan produktivitas tim Anda.</p>

<h3>Fitur Utama:</h3>
<ul>
<li>{$featureList}</li>
</ul>

<h3>Keunggulan:</h3>
<p>Aplikasi ini dibangun dengan teknologi terkini dan telah diuji secara menyeluruh untuk memastikan stabilitas dan keamanan.</p>

<h3>Garansi:</h3>
<p>Setiap pembelian dilengkapi dengan garansi update gratis selamanya, source code full, dan support teknis selama 6 bulan.</p>";
    }

    private function attachCategories(Product $product, $categories, string $type): void
    {
        $typeCategory = $categories->firstWhere('slug', $type);
        $otherCategories = $categories->where('slug', '!=', $type)->random(rand(1, 2));

        $categoryIds = collect([$typeCategory?->id])
            ->merge($otherCategories->pluck('id'))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $product->categories()->attach($categoryIds);
    }

    private function createPrices(Product $product): void
    {
        $priceTypes = [
            [
                'name' => 'Single License',
                'base_price' => rand(15, 50) * 10000,
                'features' => ['1 Domain/Device', 'Source Code', 'Dokumentasi', 'Support 3 Bulan'],
            ],
            [
                'name' => 'Multi License',
                'base_price' => rand(30, 80) * 10000,
                'features' => ['5 Domain/Device', 'Source Code', 'Dokumentasi', 'Support 6 Bulan', 'Priority Support'],
            ],
            [
                'name' => 'Unlimited License',
                'base_price' => rand(60, 150) * 10000,
                'features' => ['Unlimited Domain/Device', 'Source Code', 'Dokumentasi', 'Support 12 Bulan', 'Priority Support', 'Custom Branding'],
            ],
        ];

        $hasDiscount = rand(1, 10) <= 3;
        $sortOrder = 1;

        foreach ($priceTypes as $priceType) {
            if (rand(1, 10) <= 8 || $sortOrder === 1) {
                $price = $priceType['base_price'];
                $originalPrice = $hasDiscount ? $price + (rand(10, 30) * 10000) : null;

                ProductPrice::create([
                    'product_id' => $product->id,
                    'name' => $priceType['name'],
                    'price' => $price,
                    'original_price' => $originalPrice,
                    'features' => $priceType['features'],
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }
    }

    private function createVersion(Product $product): void
    {
        $version = $this->versions[array_rand($this->versions)];

        ProductVersion::create([
            'product_id' => $product->id,
            'version' => $version,
            'changelog' => "- Initial release\n- Bug fixes and improvements\n- Performance optimization",
            'file_path' => null,
            'file_size' => null,
            'checksum' => null,
            'is_latest' => true,
            'released_at' => now()->subDays(rand(1, 180)),
        ]);
    }

    private function createRequirements(Product $product, string $type): void
    {
        $requirements = match ($type) {
            'android' => [
                ['runtime_type' => 'kotlin', 'min_version' => '1.8', 'recommended_version' => '1.9', 'additional_requirements' => ['Android SDK 33', 'Gradle 8.0']],
            ],
            'desktop' => [
                ['runtime_type' => 'electron', 'min_version' => '25.0', 'recommended_version' => '28.0', 'additional_requirements' => ['Node.js 18', 'npm 9']],
            ],
            'web' => [
                ['runtime_type' => 'php', 'min_version' => '8.1', 'recommended_version' => '8.3', 'additional_requirements' => ['MySQL 8.0', 'Composer 2.x']],
            ],
        };

        foreach ($requirements as $req) {
            ProductRequirement::create([
                'product_id' => $product->id,
                'runtime_type' => $req['runtime_type'],
                'min_version' => $req['min_version'],
                'recommended_version' => $req['recommended_version'],
                'additional_requirements' => $req['additional_requirements'],
            ]);
        }
    }
}
