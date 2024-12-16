<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComodoModel;
use App\Models\RedeModel;
use App\Models\SinalModel;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index($section = null) {
        if ($this->session->logged_in) {
            $redeModel = new RedeModel();
            $redes = $redeModel->simpleGetRedes();

            $comodoModel = new ComodoModel();
            $comodos = $comodoModel->simpleGetComodos();

            $data = [
                "redes" => $redes,
                "comodos" => $comodos
            ];

            return view('home', $data);
        }
        else {
            return redirect()->to(base_url('login'));
        }
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
        $cols = ['COMODO', 'REDE', 'FREQUENCIA', 'VELOCIDADE', 'NIVEL_SINAL', 'INTERFERENCIA', 'DT_ANALISE'];

        // log_message('info', json_encode($vars, JSON_PRETTY_PRINT));

        # Inicialização da variável array4json como array vazio:
        $array4json = array(); // Abriga os dados retornados pela query
        $sinalModel = new SinalModel();
        $array4json['draw'] = $vars['draw'];
        $array4json['recordsTotal'] = $sinalModel->builder()->countAllResults();
        [$array4json['data'], $array4json['recordsFiltered']] = $sinalModel->complexGetSinais($vars, $cols);

        return json_encode($array4json, JSON_PRETTY_PRINT);

    }
    
}
