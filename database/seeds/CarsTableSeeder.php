<?php

use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $car = new \App\Models\Car();
        $car->create([
            'type'        => 'sedan',
            'title'       => 'Maruti Suzuki Baleno',
            'description' => 'Maruti Suzuki Baleno',
            'location'    => 'CG Road, Swastik Society, Navrangpura, Ahmedabad, Gujarat, India',
            'latitude'    => 23.0383257,
            'longitude'   => 72.5623483,
            'is_active'   => 1,
            'added_by'    => 1
        ]);

        $car->create([
            'type'        => 'hatchback',
            'title'       => 'Grand i20',
            'description' => 'Grand i20',
            'location'    => 'Iskcon Cross Road, Ramdev Nagar, Ahmedabad, Gujarat, India',
            'latitude'    => 23.0245301,
            'longitude'   => 72.5069698,
            'is_active'   => 1,
            'added_by'    => 1
        ]);
    }
}
