<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('fr_FR');
        $now = date('Y-m-d H:i:s');
        $data = [];

        for ($i = 0; $i < 30; $i++) {
            $data[] = [
                'nom' => ucfirst($faker->words(2, true)),
                'reference' => $faker->unique()->numerify('PRD-####'),
                'description' => $faker->text,
                'prix_ht' => $faker->randomFloat(2, 5, 2000),
                'taux_tva' => $faker->randomElement([0, 5.5, 10, 20]),
                'stock' => $faker->numberBetween(0, 50),
                'actif' => $faker->boolean,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->db->table('products')->insertBatch($data);
    }
}
