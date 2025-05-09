<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublishersTableSeeder extends Seeder
{
    public function run()
    {
        $publishers = [
            ['name' => 'Penguin Random House', 'address' => 'New York, USA'],
            ['name' => 'HarperCollins', 'address' => 'New York, USA'],
            ['name' => 'Simon & Schuster', 'address' => 'New York, USA'],
            ['name' => 'Hachette Livre', 'address' => 'Paris, France'],
            ['name' => 'Macmillan Publishers', 'address' => 'London, UK'],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }
    }
}