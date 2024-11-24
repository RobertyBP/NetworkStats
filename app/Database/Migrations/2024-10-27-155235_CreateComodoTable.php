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

        # Insercao de dados padrao\
        $dataArray = [
            "BANHEIRO",
            "COPA",
            "COZINHA",
            "SALA",
            "QUARTO 1",
            "QUARTO 3",
            "QUARTO AP",
        ];

        foreach ($dataArray as $value) {
            $this->db->table('COMODO')->insert(['NOME' => $value,]);
        }
        
    }

    public function down() {
        $this->forge->dropTable('COMODO', true);
    }
}
