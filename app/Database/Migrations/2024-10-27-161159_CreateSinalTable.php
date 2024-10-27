<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSinalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'COD_SINAL' => [ // Chave primária da tabela
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'FREQUENCIA' => [ // Frequencia da rede (2.4 | 5Ghz)
                'type' => 'VARCHAR',
                'constraint' => 8,
                'null' => false,
            ],
            'VELOCIDADE' => [ // Velocidade da rede na medição
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'NIVEL_SINAL' => [ // dBm
                'type' => 'INT',
                'constraint' => 20,
                'null' => false,
            ],
            'INTERFERENCIA' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'COD_REDE' => [ // Chave estrangeira - References REDE Table
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'COD_COMODO' => [ // Chave estrangeira - References COMODO Table
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'DT_ANALISE' => [ // Data da medição - Auto_Generated
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('COD_SINAL');
        $this->forge->addForeignKey('COD_REDE', 'REDE', 'COD_REDE', 'CASCADE', 'RESTRICT' );
        $this->forge->addForeignKey('COD_COMODO', 'COMODO', 'COD_COMODO', 'CASCADE', 'RESTRICT' );

        $this->forge->createTable('SINAL', true);
    }

    public function down() {
        $this->forge->dropTable('SINAL', true);
    }
}
