<?php

namespace App\Models;

use CodeIgniter\Model;

class SinalModel extends Model
{
    protected $table            = 'SINAL';
    protected $primaryKey       = 'COD_SINAL';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['FREQUENCIA', 'VELOCIDADE', 'NIVEL_SINAL', 'INTERFERENCIA', 'COD_REDE', 'COD_COMODO', 'DT_ANALISE'];

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

    public function complexGetSinais($vars, $cols) {

        $sql_select = "SELECT SINAL.COD_SINAL,
                              SINAL.COD_COMODO,
                              SINAL.COD_REDE,
                              COMODO.NOME AS COMODO,
                              REDE.NOME AS REDE,
                              SINAL.FREQUENCIA,
                              SINAL.VELOCIDADE,
                              SINAL.NIVEL_SINAL,
                              SINAL.INTERFERENCIA,
                              SINAL.DT_ANALISE";

        $sql_from = "\nFROM SINAL 
                      INNER JOIN COMODO ON SINAL.COD_COMODO = COMODO.COD_COMODO 
                      INNER JOIN REDE ON SINAL.COD_REDE = REDE.COD_REDE";

        # Verifica se existem filtros presentes na view para o DataTables:
        $found_where = false;
        $where_params = array();
        if(!empty($vars['rede'])) {
            $where_params[] = "SINAL.COD_REDE = :rede:";
            $found_where = true;
        }
        if(!empty($vars['comodo'])) {
            $where_params[] = "SINAL.COD_COMODO = :comodo:";
            $found_where = true;
        }
        if(!empty($vars['frequencia'])) {
            $where_params[] = "SINAL.FREQUENCIA = :frequencia:";
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

        // $last = $this->db->getLastQuery();
        // log_message("info", $last);

        return [
            $results,
            $query_count
        ];

    }

    public function findSinalBySimmilarData($data) {
        $sql_query = "SELECT COUNT(*) AS TOTAL 
                      FROM SINAL
                      WHERE SINAL.COD_REDE = :rede:
                      AND SINAL.COD_COMODO = :comodo:
                      AND SINAL.FREQUENCIA = :frequencia:";

        $sinal = $this->query($sql_query, ['rede' => $data['COD_REDE'], 'comodo' => $data['COD_COMODO'], 'frequencia' => $data['FREQUENCIA']])->getRowArray()['TOTAL'];

        # Caso não exista, retorna true. O contrario, retorna false.
        return empty($sinal) ? true : false;
    }

    public function findSinalByID($id) {
        # Busca o sinal com o ID especificado.
        $sql_query = "SELECT SINAL.COD_REDE,
                             SINAL.FREQUENCIA,
                             SINAL.COD_COMODO,
                             SINAL.VELOCIDADE,
                             SINAL.NIVEL_SINAL,
                             SINAL.INTERFERENCIA
                      FROM SINAL
                      WHERE COD_SINAL = :id:";
        
        $sinal = $this->query($sql_query, ['id' => $id])->getResultArray()[0];
        # Caso exista, retorna o sinal. O contrario, retorna null.
        return !empty($sinal) ? $sinal : null;
    }

    public function inserirSinal($data) {
        # Se o insert for bem-sucedido
        if($this->insert($data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function editarSinal($id, $data) {
        # Se o update for bem-sucedido
        if($this->update($id, $data))
            return true;

        # Caso contrário, retorna false.
        return false;
    }

    public function deletarSinal($id) {
        
        # Se o delete for bem-sucedido
        if($this->where('COD_SINAL', $id)->delete())
            return true;

        # Caso contrário, retorna false.
        return false;
    }

}
