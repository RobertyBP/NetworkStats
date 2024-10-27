<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UserModel extends Model
{
    protected $table            = 'USER';
    protected $primaryKey       = 'COD_USER';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['UUID', 'USERNAME', 'NOME', 'SENHA', 'PERMISSAO'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function generateUUID() {
        $uuid = Uuid::uuid4()->toString(); // Gera um UUID único e aleatório para cada usuário criado

        $sql = "SELECT COUNT(UUID) AS TOTAL FROM USER WHERE UUID = :UUID:"; // Verifica se o UUID já existe
        $validUUID = $this->query($sql, ['UUID' => $uuid])->getResultArray()[0]['TOTAL'];

        while(!empty($validUUID)) { // Enquanto o UUID gerado for inválido, tenta gerar novamente
            $uuid = Uuid::uuid4()->toString();
            $validUUID = $this->query($sql, ['UUID' => $uuid])->getResultArray()[0]['TOTAL'];
        }

        return $uuid;
    }


    public function passwordGenerator() {
        /* 
            Esse método gera uma senha de primeiro acesso aleatória.
            A senha será usada para o primeiro login do usuário, e deve ser alterada no primeiro acesso.
        */

        $upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerChars = strtolower($upperChars);
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        // Une todos os caracteres em uma string única.
        $allChars = $upperChars . $lowerChars . $numbers . $specialChars;

        // Certifica-se de que a senha tenha ao menos um de cada tipo de caractere.
        $password = [
            $upperChars[random_int(0, strlen($upperChars) - 1)],
            $lowerChars[random_int(0, strlen($lowerChars) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specialChars[random_int(0, strlen($specialChars) - 1)],
        ];

        // Preenche o restante da senha com caracteres aleatórios.
        // 12 is the maximum length of the password
        for ($i = 4; $i < 12; $i++) {
            $password[] = $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Embaralha os caracteres da senha.
        shuffle($password);

        return implode('', $password);

    }


    public function buscaUsuario($username) {

        $sql_query = "SELECT USER.COD_USER,
                             USER.UUID,
                             USER.USERNAME,
                             USER.NOME,
                             USER.SENHA,
                             USER.PERMISSAO
                      FROM USER
                      WHERE USERNAME = :username:";

        return $this->query($sql_query, ['username' => $username])->getResultArray();

    }

    public function verificaSenha($password) {

        $sql_query = "SELECT USER.SENHA
                      FROM USER
                      WHERE USER.UUID = :uuid:";
        $currPassword = $this->query($sql_query, ['uuid' => session()->get('uuid')])->getResultArray()[0]['SENHA'];

        return password_verify($password, $currPassword);

    }


    

}
