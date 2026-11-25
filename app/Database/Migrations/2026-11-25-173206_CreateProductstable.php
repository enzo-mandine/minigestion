<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductstable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'reference' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'prix_ht' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'taux_tva' => [
                'type' => 'DECIMAL',
                'constraint' => '4,2',
                'default' => '20.00'
            ],
            'stock' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'actif' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('reference');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
