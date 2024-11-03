<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Index extends BaseController
{
    public $session;

    public function __construct() {
        $this->session = session();
    }

    public function index($section = null) {
        if ($this->session->logged_in)
            return view('home');
        else
            return redirect()->to(base_url('login'));
    }

    
}
