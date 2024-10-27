<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateComodoTable extends Migration
{
    public function up() {
        $this->forge->addField([
            'COD_COMODO' => [ // Chave primária da tabela
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'NOME' => [ // Alias do Comodo
                'type' => 'VARCHAR',
                'constraint' => 125,
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('COD_COMODO');

        $this->forge->createTable('COMODO', true);
    }

    public function down() {
        $this->forge->dropTable('COMODO', true);
    }
}
