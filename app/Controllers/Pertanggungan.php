<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PertanggunganModel;
use CodeIgniter\HTTP\ResponseInterface;

class Pertanggungan extends BaseController
{
    public function dashboard()
    {
        if (session()->get('user_nama') == '') {
            session()->setFlashdata('gagal', 'Anda belum login');
            return redirect()->to(base_url('/'));
        }

        return view('pages/user/dashboard');
    }
}
