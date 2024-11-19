<?php

namespace App\Database\Migrations;

use App\Models\UserModel;
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

        # Criação de usuário padrão
        $userModel = new UserModel();

        $this->db->table('USER')->insert([
            'UUID' => $userModel->generateUUID(),
            'EMAIL' => 'admin@networkstats.com',
            'NOME' => 'SYS ADMIN',
            'SENHA' => password_hash('adminroot', PASSWORD_BCRYPT),
            'PERMISSAO' => 1
        ]);

    }

    public function down()
    {
        $this->forge->dropTable('USER', true);
    }
}
