<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Asin',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Atab',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Atok Trail',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Aurora Hill',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Campo Filipino',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'City Camp',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Engineers Hill',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Irisan',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Loakan',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Lucban',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Mines View',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Pacdal',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Pinsao',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Quezon Hill',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Quirino Hill',
            'type' => 'Health Center',
        ]);
        Facility::create([
            'name' => 'City Health Center',
            'address' => 'Scout Barrio',
            'type' => 'Health Center',
        ]);

    }
}
