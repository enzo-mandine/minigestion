<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produits extends Migration
{
    public function up()
    {
        $this->forge->addColumn('produits', [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('produits', 'deleted_at');
    }
}
