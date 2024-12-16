<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RedeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Rede extends BaseController
{
    protected $helpers = ['misc_helper'];

    # Regras de validação de formulário do CodeIgniter
    protected $rules = [
        'NOME' => 'required|max_length[125]',
        'PACOTE_DADOS' => 'required|max_length[20]',
    ];

    public function index()
    {
        return view('rede');
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
        $vars['nome'] = uniformiza_string($this->request->getPost('filtroRede'));

        # Definição da ordem lógica dos índices presentes no DataTables:
        $cols = ['COD_REDE', 'NOME', 'PACOTE_DADOS', 'ACOES'];

        # Inicialização da variável array4json como array vazio:
        $array4json = array(); // Abriga os dados retornados pela query
        $redeModel = new RedeModel();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $redeModel->builder()->countAllResults();
        [$array4json['data'], $array4json['recordsFiltered']] = $redeModel->complexGetRedes($vars, $cols);

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }

    # Rede Update & Insert
    public function upsert($operacao, $id = null) {

        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));
    
        $data = $this->request->getJSON(true);

        $newData = [
            'NOME'         => uniformiza_string($data['nome']),
            'PACOTE_DADOS' => remove_acentos($data['velocidade']),
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
    
        $redeModel = new RedeModel();

        switch($operacao) {
        # Start
            case 'add' :

                # Verifica se o nome da rede recebido do formulário já existe no banco:
                if(!$redeModel->findRedeByNome($newData['NOME']))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Outra rede de mesmo nome já possui cadastro.']);
    
                $res = $redeModel->inserirRede($newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao inserir a Rede. Por favor, tente novamente em alguns instantes.']);
                
                return $this->response->setJSON(['status' => 'success']);
    
            #############

            case 'edit' :

                # Valida se os novos dados são iguais aos antigos
                $oldData = $redeModel->findRedeByID($id);
                // log_message('info', json_encode($oldData, JSON_PRETTY_PRINT));
                
                if(empty($oldData))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'A Rede especificada não existe.']);

                $found_diff = false;

                foreach($oldData as $key => $value) {
                    if($newData[$key] != $value) {
                        $found_diff = true;
                    }
                }

                if(!$found_diff) // Se não houver diferença, retorna uma mensagem informando o usuário
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Os novos dados não podem ser iguais aos existentes.']);
                
                $res = $redeModel->editarRede($id, $newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao editar a Rede. Por favor, tente novamente em alguns instantes.']);

                return $this->response->setJSON(['status' => 'success']);

            #############

            default:
                return redirect()->to(base_url('home'));

        } # End switch Case;
    }

    # Deletar rede
    public function redeDelete($id) {
        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));

        $redeModel = new RedeModel();

        // Verifica se a rede existe
        $rede = $redeModel->findRedeByID($id);
        if(empty($rede))
            return $this->response->setJSON(['status' => 'error', 'message' => 'A Rede especificada não existe.']);
        
        $res = $redeModel->deletarRede($id);
        if(!$res)
            return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao excluir a Rede. Por favor, tente novamente em alguns instantes.']);

        return $this->response->setJSON(['status' => 'success']);
    }
}
