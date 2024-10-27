<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Sobre extends BaseController
{
    public function index()
    {
        return view('sobre');
    }
}
