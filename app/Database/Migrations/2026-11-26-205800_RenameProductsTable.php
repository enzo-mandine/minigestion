<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameProductsTable extends Migration
{
    public function up()
    {
        $this->forge->renameTable('products', 'produits');
    }

    public function down()
    {
        $this->forge->renameTable('produits', 'products');
    }
}
