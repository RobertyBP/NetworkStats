<?php

namespace App\Models;

use CodeIgniter\Model;

class RedeModel extends Model
{
    protected $table            = 'REDE';
    protected $primaryKey       = 'COD_REDE';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['NOME', 'PACOTE_DADOS'];

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

    public function simpleGetRedes() {
        $sql_query = "SELECT REDE.COD_REDE AS cod_rede,
                             REDE.NOME AS rede
                      FROM REDE 
                      ORDER BY REDE.NOME ASC";
        $redes = $this->query($sql_query)->getResultArray();

        return $redes;
    }

    public function complexGetRedes($vars, $cols) {

        $sql_select = "SELECT REDE.COD_REDE,
                              REDE.NOME,
                              REDE.PACOTE_DADOS";

        $sql_from = "\nFROM REDE";

        # Verifica se existem filtros presentes referentes ao nome (alias) da rede:
        $found_where = false;
        $where_params = array();
        if(!empty($vars['nome'])) {
            $where_params[] = "REDE.NOME LIKE :nome:";
            $vars['nome'] = "%" . $vars['nome'] . "%";
            $found_where = true;
        }

        $sql_where = "";
        if($found_where)
            $sql_where = "\nWHERE " . implode(' AND ', $where_params);

        # Verifica se existe alguma ordenação especificada na tabela e constrói a cláusula ORDER BY:
        $order = $vars['order'];
        unset($vars['order']);
        $sql_orderBy = "";
        if(!empty($order)) {
            $sort_col = $order[0]['column'];
            $sort_dir = strtoupper($order[0]['dir']);
            $sort_dir = in_array($sort_dir, ['ASC', 'DESC']) ? $sort_dir : '';
            $sql_orderBy = "\nORDER BY " . $cols[$sort_col] . " " . $sort_dir . " ";
        }

        # Ajustes de limit e offset para a paginação:
        $limit = (int)$vars['length'];
        $offset = (int)$vars['start'];
        $sql_page = "\nLIMIT {$limit} OFFSET {$offset}";

        $sql_count = "SELECT COUNT(*) AS TOTAL " . $sql_from . $sql_where; // Maximo de linhas sem a paginação
        $sql_data = $sql_select . $sql_from . $sql_where . $sql_orderBy . $sql_page; // Tuplas retornadas

        # Execução das queries:
        $query_count = $this->query($sql_count, $vars)->getRowArray()['TOTAL'];
        $results = $this->query($sql_data, $vars)->getResultArray();

        return [
            $results,
            $query_count
        ];

    }

    public function findRedeByNome($nome) {
        # Verifica se existem redes com o nome especificado.
        $rede = $this->db->table('REDE')->where('NOME', $nome)->get()->getRowArray();
        # Caso não exista, retorna true. O contrario, retorna false.
        return empty($rede) ? true : false;
    }

    public function findRedeByID($id) {
        # Busca a rede com o ID especificado.
        $sql_query = "SELECT REDE.NOME,
                             REDE.PACOTE_DADOS
                      FROM REDE
                      WHERE COD_REDE = :id:";
        
        $rede = $this->query($sql_query, ['id' => $id])->getRowArray();
        # Caso exista, retorna a rede. O contrario, retorna null.
        return !empty($rede) ? $rede : null;
    }

    public function inserirRede($data) {
        # Se o insert for bem-sucedido
        if($this->insert($data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function editarRede($id, $data) {
        # Se o update for bem-sucedido
        if($this->update($id, $data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function deletarRede($id) {
        
        # Se o delete for bem-sucedido
        if($this->where('COD_REDE', $id)->delete())
            return true;

        # Caso contrário, retorna false.
        return false;
    }
}
