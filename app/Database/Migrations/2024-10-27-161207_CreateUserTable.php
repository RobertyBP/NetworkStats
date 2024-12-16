<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'COD_USER' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'UUID' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'unique' => true,
            ],
            'EMAIL' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
                'unique' => true,
            ],
            'NOME' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'SENHA' => [
                'type' => 'VARCHAR',
                'constraint' => 256,
                'null' => false,
            ],
            'PERMISSAO' => [
                'type' => 'INT',
                'constraint' => 1,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('COD_USER');

        $this->forge->createTable('USER', true);
    }

    public function down()
    {
        $this->db->table('USER')->insert($defaultUser);
        
        $userModel = new UserModel();

        $defaultUser = [
            'UUID' => $userModel->generateUUID(),
            'EMAIL' => 'admin@admin.com',
            'NOME' => 'SYS ADMIN',
            'SENHA' => password_hash('adminroot', PASSWORD_DEFAULT),
            'PERMISSAO' => '1',
        ];

        $userModel->inserirUsuario($defaultUser);
    }

   
}
