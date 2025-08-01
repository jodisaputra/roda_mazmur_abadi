<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories - create them if they don't exist
        $categories = Category::all();

        if ($categories->isEmpty()) {
            // Run CategorySeeder if no categories exist
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        // Get specific categories for better product assignment
        $smartphoneCategory = Category::where('name', 'Smartphones')->first();
        $laptopCategory = Category::where('name', 'Laptops & Computers')->first();
        $audioCategory = Category::where('name', 'Headphones')->first();
        $tvCategory = Category::where('name', 'Smart TV')->first();
        $tabletCategory = Category::where('name', 'Tablets')->first();
        $gamingCategory = Category::where('name', 'Gaming')->first();
        $electronicsCategory = Category::where('name', 'Electronics')->first();

        $products = [
            // Smartphones
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Smartphone flagship terbaru dari Samsung dengan teknologi AI canggih, kamera 200MP, dan performa tinggi untuk segala kebutuhan.',
                'price' => 18999000,
                'stock_quantity' => 25,
                'sku' => 'SAM-S24U-001',
                'product_code' => 'SAMSUNG001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $smartphoneCategory ? $smartphoneCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'iPhone terbaru dengan chip A17 Pro, kamera yang powerful, dan desain titanium yang premium.',
                'price' => 22999000,
                'stock_quantity' => 15,
                'sku' => 'APL-I15PM-001',
                'product_code' => 'APPLE001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $smartphoneCategory ? $smartphoneCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Smartphone Google dengan AI photography yang revolusioner dan pengalaman Android murni.',
                'price' => 14999000,
                'stock_quantity' => 20,
                'sku' => 'GOO-P8P-001',
                'product_code' => 'GOOGLE001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $smartphoneCategory ? $smartphoneCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'OnePlus 12',
                'description' => 'Flagship killer dengan performa tinggi, charging super cepat, dan harga yang kompetitif.',
                'price' => 11999000,
                'stock_quantity' => 30,
                'sku' => 'ONP-12-001',
                'product_code' => 'ONEPLUS001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $smartphoneCategory ? $smartphoneCategory->id : $electronicsCategory->id,
            ],

            // Laptops & Computers
            [
                'name' => 'MacBook Air M3',
                'description' => 'Laptop ultraportable dengan chip M3 yang revolusioner, perfect untuk produktivitas dan kreativitas.',
                'price' => 18999000,
                'stock_quantity' => 8,
                'sku' => 'APL-MBA-M3-001',
                'product_code' => 'APPLE002',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $laptopCategory ? $laptopCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Dell XPS 13 Plus',
                'description' => 'Laptop premium dengan desain minimalis, performa tinggi, dan layar InfinityEdge yang memukau.',
                'price' => 23999000,
                'stock_quantity' => 5,
                'sku' => 'DEL-XPS13P-001',
                'product_code' => 'DELL001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $laptopCategory ? $laptopCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'ASUS ROG Zephyrus G16',
                'description' => 'Gaming laptop premium dengan RTX 4070, Intel Core i9, dan desain yang portabel.',
                'price' => 35999000,
                'stock_quantity' => 3,
                'sku' => 'ASU-ROGZ16-001',
                'product_code' => 'ASUS001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $laptopCategory ? $laptopCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Lenovo ThinkPad X1 Carbon',
                'description' => 'Business laptop premium dengan daya tahan tinggi, keyboard terbaik, dan performa handal.',
                'price' => 28999000,
                'stock_quantity' => 6,
                'sku' => 'LEN-TPX1C-001',
                'product_code' => 'LENOVO001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $laptopCategory ? $laptopCategory->id : $electronicsCategory->id,
            ],

            // Audio & Headphones
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Headphone wireless premium dengan teknologi noise canceling terdepan untuk pengalaman audio terbaik.',
                'price' => 4999000,
                'stock_quantity' => 35,
                'sku' => 'SNY-WH1000XM5-001',
                'product_code' => 'SONY001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $audioCategory ? $audioCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Apple AirPods Pro 2',
                'description' => 'Earbuds premium dengan spatial audio, adaptive transparency, dan noise cancellation yang canggih.',
                'price' => 3999000,
                'stock_quantity' => 50,
                'sku' => 'APL-APP2-001',
                'product_code' => 'APPLE004',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $audioCategory ? $audioCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Bose QuietComfort Ultra',
                'description' => 'Headphone dengan noise cancellation terbaik di kelasnya dan kualitas audio yang superior.',
                'price' => 5499000,
                'stock_quantity' => 25,
                'sku' => 'BOS-QCU-001',
                'product_code' => 'BOSE001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $audioCategory ? $audioCategory->id : $electronicsCategory->id,
            ],

            // Tablets
            [
                'name' => 'iPad Pro 12.9" M2',
                'description' => 'Tablet pro dengan chip M2 yang powerful, Perfect untuk digital art, produktivitas, dan entertainment.',
                'price' => 16999000,
                'stock_quantity' => 12,
                'sku' => 'APL-IPP129-M2-001',
                'product_code' => 'APPLE003',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $tabletCategory ? $tabletCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'description' => 'Tablet Android premium dengan S Pen, layar AMOLED besar, dan performa flagship.',
                'price' => 15999000,
                'stock_quantity' => 8,
                'sku' => 'SAM-GTS9U-001',
                'product_code' => 'SAMSUNG003',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $tabletCategory ? $tabletCategory->id : $electronicsCategory->id,
            ],

            // Gaming
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Gaming console hybrid dengan layar OLED yang vibrant untuk gaming di rumah maupun portable.',
                'price' => 4299000,
                'stock_quantity' => 0,
                'sku' => 'NIN-SW-OLED-001',
                'product_code' => 'NINTENDO001',
                'status' => 'active',
                'in_stock' => false,
                'category_id' => $gamingCategory ? $gamingCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'PlayStation 5 Slim',
                'description' => 'Console gaming next-gen dengan performa tinggi dan library game eksklusif yang menawan.',
                'price' => 7999000,
                'stock_quantity' => 5,
                'sku' => 'SNY-PS5S-001',
                'product_code' => 'SONY002',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $gamingCategory ? $gamingCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Xbox Series X',
                'description' => 'Console gaming Microsoft dengan backward compatibility dan Game Pass yang comprehensive.',
                'price' => 7499000,
                'stock_quantity' => 7,
                'sku' => 'MIC-XSX-001',
                'product_code' => 'MICROSOFT001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $gamingCategory ? $gamingCategory->id : $electronicsCategory->id,
            ],

            // Smart TV
            [
                'name' => 'Samsung 4K Smart TV 55"',
                'description' => 'Smart TV 4K dengan teknologi QLED, HDR10+, dan berbagai fitur smart untuk hiburan keluarga.',
                'price' => 12999000,
                'stock_quantity' => 18,
                'sku' => 'SAM-TV55-4K-001',
                'product_code' => 'SAMSUNG002',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $tvCategory ? $tvCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'LG OLED C3 65"',
                'description' => 'OLED TV premium dengan perfect black, Dolby Vision, dan gaming features untuk konsol next-gen.',
                'price' => 24999000,
                'stock_quantity' => 4,
                'sku' => 'LG-OLEDC3-65-001',
                'product_code' => 'LG001',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $tvCategory ? $tvCategory->id : $electronicsCategory->id,
            ],
            [
                'name' => 'Sony Bravia XR A80L 55"',
                'description' => 'OLED TV dengan Cognitive Processor XR dan perfect untuk movie watching dan gaming.',
                'price' => 21999000,
                'stock_quantity' => 6,
                'sku' => 'SNY-XRA80L-55-001',
                'product_code' => 'SONY003',
                'status' => 'active',
                'in_stock' => true,
                'category_id' => $tvCategory ? $tvCategory->id : $electronicsCategory->id,
            ],
        ];

        // Create initial products
        foreach ($products as $productData) {
            // If category_id is not set, assign random category
            if (!isset($productData['category_id']) || !$productData['category_id']) {
                $productData['category_id'] = $categories->random()->id;
            }

            Product::updateOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );
        }

        // Generate additional products for testing infinite scroll
        $this->generateAdditionalProducts($categories, $audioCategory, $smartphoneCategory, $laptopCategory, $tvCategory, $gamingCategory, $electronicsCategory);
    }

    /**
     * Generate additional products for testing infinite scroll
     */
    private function generateAdditionalProducts($categories, $audioCategory, $smartphoneCategory, $laptopCategory, $tvCategory, $gamingCategory, $electronicsCategory)
    {
        // Audio & Video products (50 additional products)
        $audioProducts = [
            'Apple AirPods Pro 2', 'Sony WH-1000XM5', 'Bose QuietComfort Ultra', 'Sennheiser HD 660S2',
            'Audio-Technica ATH-M50x', 'Beyerdynamic DT 770 Pro', 'AKG K701', 'Focal Utopia',
            'Audeze LCD-X', 'HiFiMan Arya', 'Grado SR325x', 'Shure SM7B', 'Blue Yeti', 'Rode PodMic',
            'Elgato Wave:3', 'Audio-Technica AT2020', 'Shure SM58', 'AKG C414', 'Neumann U87',
            'Focusrite Scarlett 2i2', 'PreSonus AudioBox USB 96', 'Zoom PodTrak P4', 'Tascam DR-40X',
            'Marshall Acton III', 'JBL Charge 5', 'Bose SoundLink Revolve+', 'Sony SRS-XB43',
            'Harman Kardon Onyx Studio 7', 'Ultimate Ears BOOM 3', 'Anker Soundcore Motion+',
            'Bang & Olufsen Beosound A1', 'Klipsch The One II', 'Audio Pro Addon C5A',
            'KEF LS50 Meta', 'Yamaha HS8', 'KRK Rokit 5 G4', 'JBL 305P MkII', 'Adam Audio T7V',
            'Mackie CR3-X', 'Edifier R1280T', 'Audioengine A2+', 'Bose Companion 2 Series III',
            'Logitech Z623', 'Creative Pebble V3', 'Razer Nommo Pro', 'SteelSeries Arena 7',
            'HyperX Cloud Alpha', 'Corsair Virtuoso RGB', 'Astro A50', 'Turtle Beach Elite Pro 2',
            'Plantronics Voyager Focus UC', 'Jabra Elite 85h'
        ];

        foreach ($audioProducts as $index => $productName) {
            Product::updateOrCreate(
                ['sku' => 'AUD-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => $productName,
                    'description' => 'High-quality audio equipment perfect for music lovers, content creators, and professional use.',
                    'price' => rand(299000, 15999000),
                    'stock_quantity' => rand(0, 50),
                    'sku' => 'AUD-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'product_code' => 'AUDIO' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'status' => 'active',
                    'in_stock' => rand(0, 1) == 1,
                    'category_id' => $audioCategory ? $audioCategory->id : $categories->random()->id,
                ]
            );
        }

        // Smartphones (30 additional products)
        $smartphoneProducts = [
            'Samsung Galaxy S23 Ultra', 'Samsung Galaxy S23+', 'Samsung Galaxy S23', 'Samsung Galaxy Z Fold5',
            'Samsung Galaxy Z Flip5', 'iPhone 15 Pro', 'iPhone 15', 'iPhone 14 Pro Max', 'iPhone 14 Pro',
            'iPhone 14', 'iPhone 13 Pro Max', 'iPhone 13', 'Google Pixel 8 Pro', 'Google Pixel 8',
            'Google Pixel 7a', 'OnePlus 11', 'OnePlus Nord 3', 'Xiaomi 13 Pro', 'Xiaomi 13',
            'Xiaomi Redmi Note 12 Pro', 'OPPO Find X6 Pro', 'OPPO Reno 10 Pro', 'Vivo X90 Pro',
            'Vivo V29', 'Realme GT 3', 'Nothing Phone (2)', 'Asus ROG Phone 7', 'Sony Xperia 1 V',
            'Motorola Edge 40 Pro', 'Honor Magic5 Pro'
        ];

        foreach ($smartphoneProducts as $index => $productName) {
            Product::updateOrCreate(
                ['sku' => 'PHONE-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => $productName,
                    'description' => 'Latest smartphone technology with advanced cameras, powerful processors, and premium design.',
                    'price' => rand(2999000, 25999000),
                    'stock_quantity' => rand(0, 30),
                    'sku' => 'PHONE-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'product_code' => 'PHONE' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'status' => 'active',
                    'in_stock' => rand(0, 1) == 1,
                    'category_id' => $smartphoneCategory ? $smartphoneCategory->id : $categories->random()->id,
                ]
            );
        }

        // Laptops & Computers (40 additional products)
        $laptopProducts = [
            'MacBook Pro 16" M3 Max', 'MacBook Pro 14" M3 Pro', 'MacBook Air 15" M2', 'MacBook Air 13" M2',
            'Dell XPS 13 Plus', 'Dell XPS 15', 'Dell XPS 17', 'ThinkPad X1 Carbon Gen 11', 'ThinkPad T14s',
            'HP Spectre x360 14', 'HP Envy 13', 'HP EliteBook 840 G10', 'Asus ZenBook 14 OLED',
            'Asus ROG Zephyrus G14', 'Asus TUF Gaming A15', 'MSI Creator Z17', 'MSI GE78 Raider',
            'Razer Blade 15', 'Razer Book 13', 'Surface Laptop 5', 'Surface Pro 9', 'Surface Studio 2+',
            'Alienware m15 R7', 'Alienware Aurora R15', 'iMac 24" M3', 'Mac Studio M2 Max', 'Mac Pro M2 Ultra',
            'Intel NUC 13 Pro', 'ASUS Mini PC PN64', 'HP Elite Mini 800 G9', 'Dell OptiPlex 7000',
            'Corsair One i300', 'Origin PC Millennium', 'NZXT BLD H1', 'Falcon Northwest Talon',
            'Digital Storm Lynx', 'Maingear Vybe', 'CyberpowerPC Luxe', 'iBuyPower Gaming PC', 'ASUS ROG Strix GT35', 'MSI Aegis RS 13'
        ];

        foreach ($laptopProducts as $index => $productName) {
            Product::updateOrCreate(
                ['sku' => 'COMP-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => $productName,
                    'description' => 'High-performance computers and laptops for work, gaming, and creative professionals.',
                    'price' => rand(8999000, 89999000),
                    'stock_quantity' => rand(0, 20),
                    'sku' => 'COMP-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'product_code' => 'COMP' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'status' => 'active',
                    'in_stock' => rand(0, 1) == 1,
                    'category_id' => $laptopCategory ? $laptopCategory->id : $categories->random()->id,
                ]
            );
        }

        // Smart TVs (25 additional products)
        $tvProducts = [
            'Samsung QN95C Neo QLED 65"', 'Samsung QN90C Neo QLED 55"', 'Samsung The Frame 55"',
            'LG C3 OLED 65"', 'LG C3 OLED 55"', 'LG G3 OLED 77"', 'Sony A95L QD-OLED 65"',
            'Sony X95L Mini LED 75"', 'Sony X90L LED 55"', 'TCL C845 Mini LED 65"', 'TCL C735 QLED 55"',
            'Hisense U8K Mini LED 65"', 'Philips OLED808 55"', 'Panasonic MZ2000 OLED 65"',
            'Sharp AQUOS XLED 70"', 'Toshiba C350 Fire TV 43"', 'Xiaomi TV A2 50"', 'Realme Smart TV 43"',
            'Coocaa 55S3U Pro', 'Polytron Cinemax Soundbar TV 50"', 'Changhong Google TV 55"',
            'Samsung Crystal UHD 43"', 'LG UQ75 4K 50"', 'Sony X75WL 50"', 'TCL P635 4K 43"'
        ];

        foreach ($tvProducts as $index => $productName) {
            Product::updateOrCreate(
                ['sku' => 'TV-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => $productName,
                    'description' => 'Smart TV with 4K resolution, HDR support, and smart features for the ultimate viewing experience.',
                    'price' => rand(3999000, 49999000),
                    'stock_quantity' => rand(0, 15),
                    'sku' => 'TV-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'product_code' => 'TV' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'status' => 'active',
                    'in_stock' => rand(0, 1) == 1,
                    'category_id' => $tvCategory ? $tvCategory->id : $categories->random()->id,
                ]
            );
        }

        // Gaming products (35 additional products)
        $gamingProducts = [
            'PlayStation 5', 'PlayStation 5 Digital', 'Xbox Series X', 'Xbox Series S', 'Nintendo Switch OLED',
            'Nintendo Switch Lite', 'Steam Deck', 'ASUS ROG Ally', 'Logitech G Pro X Superlight 2',
            'Razer DeathAdder V3 Pro', 'SteelSeries Rival 650', 'Corsair M65 RGB Elite', 'Glorious Model O',
            'Logitech G915 TKL', 'Razer Huntsman V3 Pro', 'Corsair K95 RGB Platinum', 'SteelSeries Apex Pro',
            'ASUS ROG Strix Scope II', 'Ducky One 3', 'Keychron K8', 'NZXT Capsule', 'Blue Yeti X',
            'Elgato HD60 X', 'OBS Studio Capture Card', 'Razer Kiyo Pro Ultra', 'Logitech C920s Pro',
            'ASUS TUF Gaming VG27AQ', 'Samsung Odyssey G7', 'LG 27GP950-B', 'AOC AGON AG274QXM',
            'Alienware AW3423DWF', 'MSI MAG274QRF-QD', 'ViewSonic Elite XG270QG', 'BenQ ZOWIE XL2566K',
            'ASUS VG248QE'
        ];

        foreach ($gamingProducts as $index => $productName) {
            Product::updateOrCreate(
                ['sku' => 'GAME-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT)],
                [
                    'name' => $productName,
                    'description' => 'Gaming equipment and accessories for the ultimate gaming experience.',
                    'price' => rand(599000, 15999000),
                    'stock_quantity' => rand(0, 25),
                    'sku' => 'GAME-' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'product_code' => 'GAME' . str_pad($index + 100, 3, '0', STR_PAD_LEFT),
                    'status' => 'active',
                    'in_stock' => rand(0, 1) == 1,
                    'category_id' => $gamingCategory ? $gamingCategory->id : $categories->random()->id,
                ]
            );
        }

        echo "Generated " . (count($audioProducts) + count($smartphoneProducts) + count($laptopProducts) + count($tvProducts) + count($gamingProducts)) . " additional products for testing infinite scroll.\n";
    }
}
