<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class User extends BaseController
{
    protected $helpers = ['misc_helper'];

    # Regras de validação de formulário do CodeIgniter
    protected $rules = [
        'NOME' => 'required|max_length[255]',
        'EMAIL' => 'valid_email|min_length[8]|max_length[150]',
        'PERMISSAO' => 'required|in_list[0, 1]',
    ];

    # Regras de validação de senha
    protected $passwordRules = [
        'SENHA_ATUAL' => [
            'rules' => 'required|min_length[8]|max_length[256]',
            'errors' => [
                'required' => 'A senha atual é obrigatória.',
                'max_length' => 'A senha atual é muito longa.',
            ]
        ],
        'NOVA_SENHA' => [
            'rules' => 'required|min_length[8]|max_length[256]|differs[SENHA_ATUAL]',
            'errors' => [
                'required' => 'Por favor, insira sua nova senha.',
                'min_length' => 'Sua nova senha é muito curta.',
                'max_length' => 'Sua nova senha é muito longa.',
                'differs' => 'Sua nova senha não pode ser igual a atual.',
            ]
        ],
        'CONFIRMA_SENHA' => [
            'rules' => 'required|matches[NOVA_SENHA]',
            'errors' => [
                'required' => 'A confirmação da sua nova senha é obrigatória.',
                'matches' => 'A sua nova senha e a confirmação da mesma devem ser idênticas.',
            ]
        ]
    ];

    public function index()
    {
        if(!$this->request->is('POST'))
            return view('users');
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
        $vars['nome'] = uniformiza_string($this->request->getPost('filtroNome'));
        $vars['email'] = mb_strtolower(uniformiza_string($this->request->getPost('filtroEmail')));

        # Definição da ordem lógica dos índices presentes no DataTables:
        $cols = ['COD_USER', 'UUID', 'NOME', 'EMAIL', 'PERMISSAO', 'ACOES'];

        # Inicialização da variável array4json como array vazio:
        $array4json = array(); // Abriga os dados retornados pela query
        $userModel = new UserModel();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $userModel->builder()->countAllResults();
        [$array4json['data'], $array4json['recordsFiltered']] = $userModel->complexGetUsers($vars, $cols);

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }

    # Usuário Update & Insert
    public function upsert($operacao, $id = null) {

        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));
    
        $data = $this->request->getJSON(true);

        $newData = [
            'NOME'      => uniformiza_string($data['nome']),
            'EMAIL'     => mb_strtolower(uniformiza_string($data['email'])),
            'PERMISSAO' => normaliza_status($data['permissao']),
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
    
        $userModel = new UserModel();

        switch($operacao) {
        # Start
            case 'add' :

                # Verifica se o e-mail recebido do formulário já existe no banco:
                $validEmail = $userModel->findUserByEmail($newData['EMAIL']);
                if(!empty($validEmail[0]))
                    return $this->response->setJSON(['status' => 'error', 'message' => 'O E-mail informado já possui cadastro.']);

                $tempPassword = $userModel->passwordGenerator();
                $newData['UUID'] = $userModel->generateUUID();
                $newData['SENHA'] = password_hash($tempPassword, PASSWORD_BCRYPT);
    
                $res = $userModel->inserirUsuario($newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao inserir o usuário. Por favor, tente novamente em alguns instantes.']);
                
                return $this->response->setJSON(['status' => 'success', 'data' => $tempPassword]);
    
            #############

            case 'edit' :

                // Valida se os novos dados são iguais aos antigos
                $oldData = $userModel->findUserByID($id);
                $found_diff = false;

                foreach($oldData as $key => $value) {
                    if($newData[$key] != $value) {
                        $found_diff = true;
                    }
                }

                if(!$found_diff) // Se não houver diferença, retorna uma mensagem informando o usuário
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Os novos dados não podem ser iguais aos existentes.']);
                
                $res = $userModel->editarUsuario($id, $newData);
                if(!$res) 
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao editar o usuário. Por favor, tente novamente em alguns instantes.']);

                return $this->response->setJSON(['status' => 'success']);

            #############

            default:
                return redirect()->to(base_url('home'));

        } # End switch Case;
    }

    # Delete user
    public function userDelete($id) {
        if(!$this->request->is('POST'))
            return redirect()->to(base_url('home'));

        $userModel = new UserModel();

        // Verifica se o usuário existe
        $user = $userModel->findUserByID($id);
        if(empty($user))
            return $this->response->setJSON(['status' => 'error', 'message' => 'O usuário especificado não existe.']);
        
        $res = $userModel->deletarUsuario($id);
        if(!$res)
            return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao excluir o usuário. Por favor, tente novamente em alguns instantes.']);

        return $this->response->setJSON(['status' => 'success']);
    }

    # Alteração de senha:
    public function alterarSenha($uuid) {

        # Se for get:
        if(!$this->request->is('POST')) {
            # Verifica se o UUID do usuário corresponde a sessão atual.
            if(!empty(session('uuid')) && session('uuid') == $uuid) {
                return view('passwordChange');
            } else {
                return redirect()->to(base_url('home'));
            }
        }
            
        # Se for post, verifica as regras de validação
        $fields = $this->request->getJSON(true); # Recupera os campos do formulário como array associativo
    
        $data = [
            'SENHA_ATUAL' => uniformiza_espacos($fields['senhaAtual']),
            'NOVA_SENHA' => uniformiza_espacos($fields['novaSenha']),
            'CONFIRMA_SENHA' => uniformiza_espacos($fields['confirmaSenha']),
        ];

        # Validação do CodeIgniter
        $errors = array();
        $validation = \Config\Services::validation();
        $validation->reset();
        $validation->setRules($this->passwordRules);
        $validated = $validation->run($data);
        if (!$validated)
            $errors = $validation->getErrors();
    
        if(!empty($errors)) {
            // Return errors
            $errorMsg = "<ul>";
    
            foreach($errors as $key => $value) 
                $errorMsg .= "<li>" . $value . "</li>";
    
            $errorMsg .= "</ul>";
    
            return $this->response->setJSON(['status' => 'error', 'message' => $errorMsg]);
        }

        $userModel = new UserModel();

        

        # Verifica se o usuário existe
        $user = $userModel->findUserByUUID($uuid);
        # Caso não seja encontrado no banco, destrói a sessão ativa
        if(empty($user))
            return redirect()->to(base_url('logout'));

        # Verifica se a senha atual é compatível
        $senhaValida = $userModel->verificaSenha($data['SENHA_ATUAL']);

        if(!$senhaValida) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'A senha atual está incorreta.']);
        }
        
        # Reforça a coerência da sessão com o UUID recebido
        if(!empty(session('uuid')) && session('uuid') == $uuid) {

            $userID = session('id');

            $res = $userModel->changePassword($userID, $data['NOVA_SENHA']);
            if(!$res)
                return $this->response->setJSON(['status' => 'error', 'message' => 'Um erro inesperado ocorreu ao alterar a senha. Por favor, tente novamente em alguns instantes.']);

            return $this->response->setJSON(['status' => 'success']);
            
        } 
        else {
            return redirect()->to(base_url('home'));
        }
    }

}
