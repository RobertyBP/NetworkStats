<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRedeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'COD_REDE' => [ // Chave primária da tabela
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'PACOTE_DADOS' => [ // Velocidade de transferência contratada na operadora
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'NOME' => [ // Alias da Rede
                'type' => 'VARCHAR',
                'constraint' => 125,
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('COD_REDE');

        $this->forge->createTable('REDE', true);
    }

    public function down() {
        $this->forge->dropTable('REDE', true);
    }
}
