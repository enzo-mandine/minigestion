<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'nom' => 'Admin',
            'email' => 'admin@minigestion.local',
            'password_hash' => password_hash('admin1234', PASSWORD_DEFAULT),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
