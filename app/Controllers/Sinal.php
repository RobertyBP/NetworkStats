<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SinalModel;
use App\Models\ComodoModel;
use App\Models\RedeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Sinal extends BaseController
{
    protected $helpers = ['misc_helper'];

    # Regras de validação de formulário do CodeIgniter
    protected $rules = [
        'COD_REDE' => 'required',
        'FREQUENCIA' => 'required|in_list[2.4Ghz,5Ghz]',
        'COD_COMODO' => 'required',
        'VELOCIDADE' => 'required|max_length[20]',
        'NIVEL_SINAL' => 'required|numeric',
        'INTERFERENCIA' => 'permit_empty|max_length[255]',
    ];

    public function index()
    {
        $redeModel = new RedeModel();
        $redes = $redeModel->simpleGetRedes();

        $comodoModel = new ComodoModel();
        $comodos = $comodoModel->simpleGetComodos();

        $data = [
            "redes" => $redes,
            "comodos" => $comodos
        ];

        return view("sinal", $data);
    }

    public function json_list() {
        # Se o request não for o esperado, retorna vazio.
        if(!$this->request->is('AJAX'))
            return;

        $vars = array(); // Inicialização do array de VARS como array vazio.
        
        # Parâmetros default do DataTables:
        $vars['draw'] = strval($this->request->getPost('draw'));
        $vars['start'] = strval($this->request->getPost('start'));
        $vars['length'] = strval($this->request->getPost('length'));
        $vars['order'] = $this->request->getPost('order');

        # Filtros customizados
        $vars['rede'] = strval($this->request->getPost('filtroRede'));
        $vars['comodo'] = strval($this->request->getPost('filtroComodo'));
        $vars['frequencia'] = strval($this->request->getPost('filtroFrequencia'));

        # Definição da ordem lógica dos índices presentes no DataTables:
        $cols = ['COD_SINAL', 'COD_COMODO', 'COD_REDE', 'COMODO', 'REDE', 'FREQUENCIA', 'VELOCIDADE', 'NIVEL_SINAL', 'INTERFERENCIA', 'DT_ANALISE', 'ACOES'];

        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));

        # Inicialização da variável array4json como array vazio:
        $array4json = array(); // Abriga os dados retornados pela query
        $sinalModel = new SinalModel();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $sinalModel->builder()->countAllResults();
        [$array4json['data'], $array4json['recordsFiltered']] = $sinalModel->complexGetSinais($vars, $cols);

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }

    # Sinal Update & Insert
    public function upsert($operacao, $id = null) {

        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));
    
        $data = $this->request->getJSON(true);

        $newData = [
            'COD_REDE'      => $data['rede'],
            'FREQUENCIA'    => $data['frequencia'],
            'COD_COMODO'    => $data['comodo'],
            'VELOCIDADE'    => uniformiza_espacos($data['velocidade']),
            'NIVEL_SINAL'   => uniformiza_espacos($data['dbm']),
            'INTERFERENCIA' => uniformiza_espacos($data['interferencia']),
        ];

        // log_message("info", json_encode($newData, JSON_PRETTY_PRINT));

        # CodeIgniter Validation
        $errors = [];
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->rules);
        $validated = $validation->run($newData);
        if (!$validated)
            $errors = $validation->getErrors();
    
        if(!empty($errors)) {
            # Erros retornados
            $errorMsg = "<ul>";
    
            foreach($errors as $key => $value) 
                $errorMsg .= "<li>" . $value . "</li>";
    
            $errorMsg .= "</ul>";
    
            return $this->response->setJSON(['status' => 'error', 'message' => $errorMsg]);
        } 

        # Se o campo INTERFERENCIA estiver vazio, atribui o valor N/A
        if(empty($newData['INTERFERENCIA']))
            $newData['INTERFERENCIA'] = 'N/A';
    
        $sinalModel = new SinalModel();

        switch($operacao) {
        # Start
            case 'add' :

                # Valida os principais atributos das relacoes envolvidas para se assegurar que não exista nenhum outro registro identico.
                if(!$sinalModel->findSinalBySimmilarData($newData))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Outro sinal com caracteristicas identicas foi encontrado.']);
    
                $res = $sinalModel->inserirSinal($newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao inserir o Sinal. Por favor, tente novamente em alguns instantes.']);
                
                return $this->response->setJSON(['status' => 'success']);
    
            #############

            case 'edit' :

                # Valida se os novos dados são iguais aos antigos
                $oldData = $sinalModel->findSinalByID($id);
                // log_message('info', json_encode($oldData, JSON_PRETTY_PRINT));
                
                # Verifica se o registro existe na relacao
                if(empty($oldData))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'O Sinal especificado não existe.']);

                $found_diff = false;

                foreach($oldData as $key => $value) {
                    if($newData[$key] != $value) {
                        $found_diff = true;
                    }
                }

                if(!$found_diff) // Se não houver diferença, retorna uma mensagem informando o usuário
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Os novos dados não podem ser iguais aos existentes.']);

                # Valida os principais atributos das relacoes envolvidas para se assegurar que não exista nenhum outro registro identico.
                if(!$sinalModel->findSinalBySimmilarData($newData))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Outro sinal com caracteristicas identicas foi encontrado.']);
                
                # Zera o campo de data para re-atribuicao na tabela.
                $newData['DT_ANALISE'] = null;

                $res = $sinalModel->editarSinal($id, $newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao editar o Sinal. Por favor, tente novamente em alguns instantes.']);

                return $this->response->setJSON(['status' => 'success']);

            #############

            default:
                return redirect()->to(base_url('home'));

        } # End switch Case;
    }

    # Deletar sinal
    public function sinalDelete($id) {
        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));

        $sinalModel = new SinalModel();

        // Verifica se o cômodo existe
        $sinal = $sinalModel->findSinalByID($id);
        if(empty($sinal))
            return $this->response->setJSON(['status' => 'error', 'message' => 'O Sinal especificado não existe.']);
        
        $res = $sinalModel->deletarSinal($id);
        if(!$res)
            return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao excluir o Sinal. Por favor, tente novamente em alguns instantes.']);

        return $this->response->setJSON(['status' => 'success']);
    }
}
