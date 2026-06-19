<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@rentcar.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@rentcar.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        $catSuv = \App\Models\Category::create(['name' => 'SUV', 'description' => 'Sport Utility Vehicle']);
        $catSedan = \App\Models\Category::create(['name' => 'Sedan', 'description' => 'Sedan car']);
        $catMpv = \App\Models\Category::create(['name' => 'MPV', 'description' => 'Multi Purpose Vehicle']);
        $catHatchback = \App\Models\Category::create(['name' => 'Hatchback', 'description' => 'Hatchback car']);
        $catLuxury = \App\Models\Category::create(['name' => 'Luxury', 'description' => 'Luxury / Premium car']);

        $vehicles = [
            ['brand' => 'Toyota', 'model' => 'Avanza', 'cat' => $catMpv->id, 'price' => 350000, 'img' => 'vehicles/avanza.jpg', 'year' => 2022],
            ['brand' => 'Toyota', 'model' => 'Innova', 'cat' => $catMpv->id, 'price' => 500000, 'img' => 'vehicles/innova.jpg', 'year' => 2021],
            ['brand' => 'Honda', 'model' => 'Brio', 'cat' => $catHatchback->id, 'price' => 250000, 'img' => 'vehicles/brio.jpg', 'year' => 2023],
            ['brand' => 'Mitsubishi', 'model' => 'Xpander', 'cat' => $catMpv->id, 'price' => 450000, 'img' => 'vehicles/xpander.jpg', 'year' => 2022],
            ['brand' => 'Toyota', 'model' => 'Fortuner', 'cat' => $catSuv->id, 'price' => 800000, 'img' => 'vehicles/fortuner.jpg', 'year' => 2022],
            ['brand' => 'Honda', 'model' => 'CR-V', 'cat' => $catSuv->id, 'price' => 750000, 'img' => 'vehicles/crv.jpg', 'year' => 2021],
            ['brand' => 'Toyota', 'model' => 'Alphard', 'cat' => $catLuxury->id, 'price' => 1500000, 'img' => 'vehicles/alphard.jpg', 'year' => 2023],
            ['brand' => 'Suzuki', 'model' => 'Ertiga', 'cat' => $catMpv->id, 'price' => 350000, 'img' => 'vehicles/ertiga.jpg', 'year' => 2020],
            ['brand' => 'Daihatsu', 'model' => 'Xenia', 'cat' => $catMpv->id, 'price' => 300000, 'img' => 'vehicles/xenia.jpg', 'year' => 2022],
            ['brand' => 'Honda', 'model' => 'HR-V', 'cat' => $catSuv->id, 'price' => 600000, 'img' => 'vehicles/hrv.jpg', 'year' => 2022],
            ['brand' => 'Toyota', 'model' => 'Rush', 'cat' => $catSuv->id, 'price' => 400000, 'img' => 'vehicles/rush.jpg', 'year' => 2021],
            ['brand' => 'Daihatsu', 'model' => 'Terios', 'cat' => $catSuv->id, 'price' => 380000, 'img' => 'vehicles/terios.jpg', 'year' => 2022],
            ['brand' => 'Suzuki', 'model' => 'Ignis', 'cat' => $catHatchback->id, 'price' => 280000, 'img' => 'vehicles/ignis.jpg', 'year' => 2021],
            ['brand' => 'Honda', 'model' => 'Civic', 'cat' => $catSedan->id, 'price' => 700000, 'img' => 'vehicles/civic.jpg', 'year' => 2022],
            ['brand' => 'Toyota', 'model' => 'Camry', 'cat' => $catSedan->id, 'price' => 900000, 'img' => 'vehicles/camry.jpg', 'year' => 2021],
            ['brand' => 'Mitsubishi', 'model' => 'Pajero Sport', 'cat' => $catSuv->id, 'price' => 850000, 'img' => 'vehicles/pajero.jpg', 'year' => 2022],
            ['brand' => 'Nissan', 'model' => 'Livina', 'cat' => $catMpv->id, 'price' => 350000, 'img' => 'vehicles/livina.jpg', 'year' => 2020],
            ['brand' => 'Wuling', 'model' => 'Confero', 'cat' => $catMpv->id, 'price' => 250000, 'img' => 'vehicles/confero.jpg', 'year' => 2022],
            ['brand' => 'Hyundai', 'model' => 'Creta', 'cat' => $catSuv->id, 'price' => 500000, 'img' => 'vehicles/creta.jpg', 'year' => 2023],
            ['brand' => 'Toyota', 'model' => 'Raize', 'cat' => $catSuv->id, 'price' => 400000, 'img' => 'vehicles/raize.jpg', 'year' => 2022],
        ];

        foreach ($vehicles as $index => $v) {
            \App\Models\Vehicle::create([
                'category_id' => $v['cat'],
                'brand' => $v['brand'],
                'model' => $v['model'],
                'license_plate' => 'B ' . rand(1000, 9999) . ' ABC',
                'year' => $v['year'],
                'price_per_day' => $v['price'],
                'status' => 'available',
                'description' => 'Comfortable and reliable ' . $v['model'] . ' ready for rent.',
                'image_path' => $v['img']
            ]);
        }
    }
}
