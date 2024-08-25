<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_level_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'urutan' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'punya_submenu' => [
                'type' => 'ENUM',
                'constraint' => ['1', '0'],
                'default' => '0'
            ],
            'submenu' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
                'default' => null
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('menu');
    }

    public function down()
    {
        $this->forge->dropTable('menu');
    }
}
