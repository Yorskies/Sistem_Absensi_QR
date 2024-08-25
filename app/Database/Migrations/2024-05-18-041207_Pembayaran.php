<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
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
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'nominal' => [
                'type' => 'BIGINT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}
