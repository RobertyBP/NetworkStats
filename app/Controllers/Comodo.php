<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComodoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Comodo extends BaseController
{
    protected $helpers = ['misc_helper'];

    # Regras de validação de formulário do CodeIgniter
    protected $rules = [
        'NOME' => 'required|max_length[125]',
    ];

    public function index()
    {
        return view('comodo');
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
        $vars['nome'] = uniformiza_string($this->request->getPost('filtroComodo'));

        # Definição da ordem lógica dos índices presentes no DataTables:
        $cols = ['COD_COMODO', 'NOME', 'ACOES'];

        # Inicialização da variável array4json como array vazio:
        $array4json = array(); // Abriga os dados retornados pela query
        $comodoModel = new ComodoModel();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $comodoModel->builder()->countAllResults();
        [$array4json['data'], $array4json['recordsFiltered']] = $comodoModel->complexGetComodos($vars, $cols);

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }

    # Cômodo Update & Insert
    public function upsert($operacao, $id = null) {

        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));
    
        $data = $this->request->getJSON(true);

        $newData = [
            'NOME'         => uniformiza_string($data['nome']),
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
    
        $comodoModel = new ComodoModel();

        switch($operacao) {
        # Start
            case 'add' :

                # Verifica se o nome do comodo recebido do formulário já existe no banco:
                if(!$comodoModel->findComodoByNome($newData['NOME']))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Outro Cômodo de mesmo nome já possui cadastro.']);
    
                $res = $comodoModel->inserirComodo($newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao inserir o Cômodo. Por favor, tente novamente em alguns instantes.']);
                
                return $this->response->setJSON(['status' => 'success']);
    
            #############

            case 'edit' :

                # Valida se os novos dados são iguais aos antigos
                $oldData = $comodoModel->findComodoByID($id);
                // log_message('info', json_encode($oldData, JSON_PRETTY_PRINT));
                
                if(empty($oldData))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'O cômodo especificado não existe.']);

                $found_diff = false;

                foreach($oldData as $key => $value) {
                    if($newData[$key] != $value) {
                        $found_diff = true;
                    }
                }

                if(!$found_diff) // Se não houver diferença, retorna uma mensagem informando o usuário
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Os novos dados não podem ser iguais aos existentes.']);
                
                $res = $comodoModel->editarComodo($id, $newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao editar o Cômodo. Por favor, tente novamente em alguns instantes.']);

                return $this->response->setJSON(['status' => 'success']);

            #############

            default:
                return redirect()->to(base_url('home'));

        } # End switch Case;
    }

    # Deletar cômodo
    public function comodoDelete($id) {
        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));

        $comodoModel = new ComodoModel();

        // Verifica se o cômodo existe
        $comodo = $comodoModel->findComodoByID($id);
        if(empty($comodo))
            return $this->response->setJSON(['status' => 'error', 'message' => 'O Cômodo especificado não existe.']);
        
        $res = $comodoModel->deletarComodo($id);
        if(!$res)
            return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao excluir o Cômodo. Por favor, tente novamente em alguns instantes.']);

        return $this->response->setJSON(['status' => 'success']);
    }
}

