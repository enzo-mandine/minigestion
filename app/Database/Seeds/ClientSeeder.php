<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('fr_FR');
        $now = date('Y-m-d H:i:s');
        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'nom' => $faker->lastName,
                'prenom' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'telephone' => $faker->phoneNumber,
                'ville' => $faker->city,
                'entreprise' => $faker->company,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->db->table('clients')->insertBatch($data);
    }
}
