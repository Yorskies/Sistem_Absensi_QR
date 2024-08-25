<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Invoice extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'no_inv' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'tgl' => [
                'type' => 'DATE',
            ],
            'customer_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'nominal' => [
                'type' => 'BIGINT',
                'constraint' => 11,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Open', 'Lunas'],
                'default' => 'Open'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('invoice');
    }

    public function down()
    {
        $this->forge->dropTable('invoice');
    }
}
