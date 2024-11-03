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
    protected $allowedFields    = ['UUID', 'EMAIL', 'NOME', 'SENHA', 'PERMISSAO', 'ATIVO'];

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


    public function findUserByEmail($email) {

        $sql_query = "SELECT USER.COD_USER,
                             USER.UUID,
                             USER.EMAIL,
                             USER.NOME,
                             USER.SENHA,
                             USER.PERMISSAO
                      FROM USER
                      WHERE EMAIL = :email:";

        return $this->query($sql_query, ['email' => $email])->getResultArray();

    }

    public function findUserByID($id) {

        $sql_query = "SELECT USER.COD_USER,
                             USER.UUID,
                             USER.EMAIL,
                             USER.NOME,
                             USER.SENHA,
                             USER.PERMISSAO
                      FROM USER
                      WHERE COD_USER = :id:";

        return $this->query($sql_query, ['id' => $id])->getResultArray();

    }

    public function verificaSenha($password) {

        $sql_query = "SELECT USER.SENHA
                      FROM USER
                      WHERE USER.UUID = :uuid:";
        $currPassword = $this->query($sql_query, ['uuid' => session()->get('uuid')])->getResultArray()[0]['SENHA'];

        return password_verify($password, $currPassword);

    }


    public function complexGetUsers($vars, $cols) { // Tratamento dos dados vindos do DataTables para a tabela de usuários

        $sql_select = "SELECT USER.COD_USER,
                              USER.UUID,
                              USER.EMAIL,
                              USER.NOME,
                              USER.SENHA,
                              USER.PERMISSAO,
                              USER.ATIVO";
                        
        $sql_from = "\nFROM USER";

        // Verifica se existem filtros presentes referentes ao nome ou e-mail do usuário:
        $found_where = false;
        $where_params = array();
        if(!empty($vars['nome'])) {
            $where_params[] = "USER.NOME LIKE :nome:";
            $vars['nome'] = "%" . $vars['nome'] . "%";
            $found_where = true;
        }
        if(!empty($vars['email'])) {
            $where_params[] = "USER.EMAIL LIKE :email:";
            $vars['email'] = "%" . $vars['email'] . "%";
            $found_where = true;
        }
        
        $sql_where = "";
        if ($found_where)
            $sql_where = "\nWHERE " . implode(' AND ', $where_params);

        // Verifica se existe alguma ordenação especificada na tabela e constrói a cláusula ORDER BY:
        $order = $vars['order'];
        unset($vars['order']);
        $sql_orderBy = "";
        if(!empty($order)) {
            $sort_col = $order[0]['column'];
            $sort_dir = strtoupper($order[0]['dir']);
            $sort_dir = in_array($sort_dir, ['ASC', 'DESC']) ? $sort_dir : '';
            $sql_orderBy = "\nORDER BY " . $cols[$sort_col] . " " . $sort_dir . " ";
        }

        // Ajustes de limit e offset para a paginação:
        $limit = (int)$vars['length'];
        $offset = (int)$vars['start'];
        $sql_page = "\nLIMIT {$limit} OFFSET {$offset}";

        $sql_count = "SELECT COUNT(*) AS TOTAL " . $sql_from . $sql_where; // Máximo de linhas sem a paginação
        $sql_data = $sql_select . $sql_from . $sql_where . $sql_orderBy . $sql_page; // Tuplas retornadas

        // Execução das queries:
        $query_count = $this->query($sql_count, $vars)->getRowArray()['TOTAL'];
        $results = $this->query($sql_data, $vars)-> getResultArray();

        return [
            $results,
            $query_count
        ];
 
    }


    public function inserirUsuario($data) {
        # Se a inserção for bem-sucedida
        if($this->insert($data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function editarUsuario($id, $data) {
        # Se o update for bem-sucedido
        if($this->update($id, $data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

}
