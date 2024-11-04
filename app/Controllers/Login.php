<?php namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController {

    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index() {

        // Se já está logado, exibe a view 'home'
        if ($this->session->logged_in)
            return redirect()->to(base_url('start'));

        // Se a requisição não é POST
        if (!$this->request->is('post'))
            return view('login', ['no_banner' => true]);

        $email = strval($this->request->getPost('email'));
        $senha = strval($this->request->getPost('senha'));

        $email = substr($email, 0, 125);
        $senha = substr($senha, 0, 256);       

        $data = array();
        $data['email'] = $email;

        // Campos de login incompletos
        if (trim($email) == '' || trim($senha) == '') {

            $data['msg'] = 'Usuário e/ou senha ausente(s)';
            return view('login', $data + ['no_banner' => true]);

        }

        $userModel = new UserModel();
        $usuario = $userModel->findUserByEmail($email);
        // Realiza login se existir usuário cadastrado e se a senha for compatível
        if (!empty($usuario)) {
            $name_tokens = strpos($usuario[0]['NOME'], ' ') ? explode(' ', $usuario[0]['NOME']) : null;

            if(!password_verify($senha, $usuario[0]['SENHA'])) {
                $data['msg'] = 'Usuário e/ou senha inválidos';
                return view('login', $data + ['no_banner' => true]);
            }

            $nome_tokens = explode(' ', $usuario[0]['NOME']);
            $newdata = [
                'email'         => $usuario[0]['EMAIL'],
                'uuid'          => $usuario[0]['UUID'],
                'id'            => $usuario[0]['COD_USER'],
                'nome'          => $usuario[0]['NOME'],
                'nome_reduzido' => !empty($name_tokens) ? $nome_tokens[0] . ' ' . $nome_tokens[count($nome_tokens)-1] : $usuario[0]['NOME'],
                'is_admin'      => $usuario[0]['PERMISSAO'] === '1' ? true : false,
                'logged_in'     => true,
            ];

            $this->session->set($newdata);
            return redirect()->to(base_url('home'));

        } 
        else {
            $data['msg'] = 'Usuário e/ou senha inválidos';
        }

        return view('login', $data + ['no_banner' => true]);

    }

    function logout() {

        $this->session->destroy();
        return redirect()->to(base_url('login'));

    }

}

