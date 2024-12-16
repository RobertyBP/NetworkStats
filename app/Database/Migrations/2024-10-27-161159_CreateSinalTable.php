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
            'DT_ANALISE' => [ // Data da medição - Auto Generated
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('COD_SINAL');
        $this->forge->addForeignKey('COD_REDE', 'REDE', 'COD_REDE', 'CASCADE', 'CASCADE' );
        $this->forge->addForeignKey('COD_COMODO', 'COMODO', 'COD_COMODO', 'CASCADE', 'CASCADE' );

        $this->forge->createTable('SINAL', true);


        # Insercao de dados padrao
        $dataArray = [
            [ # banheiro
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 1,
                "VELOCIDADE" => "255Mbps",
                "NIVEL_SINAL" => -58,
                "INTERFERENCIA" => "VIVOFIBRA - 4C62-5G (-56 dBm)"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 1,
                "VELOCIDADE" => "315Mbps",
                "NIVEL_SINAL" => -59,
                "INTERFERENCIA" => "VIVOFIBRA - 4C62-5G (-56 dBm)"
            ],
            [ # copa
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 2,
                "VELOCIDADE" => "425Mbps",
                "NIVEL_SINAL" => -49,
                "INTERFERENCIA" => "VIVOFIBRA - 4C62-5G (-44 dBm)"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 2,
                "VELOCIDADE" => "425Mbps",
                "NIVEL_SINAL" => -46,
                "INTERFERENCIA" => "VIVOFIBRA - 4C62-5G (-44 dBm)"
            ],
            [ # cozinha
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 3,
                "VELOCIDADE" => "345Mbps",
                "NIVEL_SINAL" => -65,
                "INTERFERENCIA" => "N/A"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 3,
                "VELOCIDADE" => "255Mbps",
                "NIVEL_SINAL" => -57,
                "INTERFERENCIA" => "N/A"
            ],
            [ # sala
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 4,
                "VELOCIDADE" => "255Mbps",
                "NIVEL_SINAL" => -58,
                "INTERFERENCIA" => "VIVOFIBRA - B578 (87 dBm), VIVOFIBRA - 4C62-5G (-48 dBm)"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 4,
                "VELOCIDADE" => "315Mbps",
                "NIVEL_SINAL" => -57,
                "INTERFERENCIA" => "VIVOFIBRA - B578 (87 dBm), VIVOFIBRA - 4C62-5G (-48 dBm)"
            ],
            [ # quarto 1
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 5,
                "VELOCIDADE" => "255Mbps",
                "NIVEL_SINAL" => -62,
                "INTERFERENCIA" => "VIVOFIBRA - B578 (83 dBm), MHNET_ROSILDA (85 dBm)"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 5,
                "VELOCIDADE" => "315Mbps",
                "NIVEL_SINAL" => -60,
                "INTERFERENCIA" => "VIVOFIBRA - B578 (83 dBm), MHNET_ROSILDA (85 dBm)"
            ],
            [ # quarto 3
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 6,
                "VELOCIDADE" => "315Mbps",
                "NIVEL_SINAL" => -58,
                "INTERFERENCIA" => "N/A"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 6,
                "VELOCIDADE" => "315Mbps",
                "NIVEL_SINAL" => -57,
                "INTERFERENCIA" => "N/A"
            ],
            [ # quarto ap
                "COD_REDE" => 1,
                "FREQUENCIA" => "2.4Ghz",
                "COD_COMODO" => 7,
                "VELOCIDADE" => "425Mbps",
                "NIVEL_SINAL" => -24,
                "INTERFERENCIA" => "N/A"
            ],
            [
                "COD_REDE" => 1,
                "FREQUENCIA" => "5Ghz",
                "COD_COMODO" => 7,
                "VELOCIDADE" => "425Mbps",
                "NIVEL_SINAL" => -21,
                "INTERFERENCIA" => "N/A"
            ],
        ];

        foreach ($dataArray as $index) {
            $this->db->table('SINAL')->insert($index);
        }
    }

    public function down() {
        $this->forge->dropTable('SINAL', true);
    }
}
