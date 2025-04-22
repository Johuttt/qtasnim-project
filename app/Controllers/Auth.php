<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('pages/login/signin');
    }
    public function login()
    {
        $data = [];
    
        if ($this->request->getPost()) {
            // Validasi input
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];
    
            if ($this->validate($rules)) {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');
    
                // Buat instance model UserModel
                $userModel = new UserModel();
    
                // Cari user berdasarkan username
                $user = $userModel->where('username', $username)->first();
    
                // Periksa apakah login sebagai user berhasil
                if ($user && password_verify($password, $user['password'])) {
                    session()->set('user_nama', $user['username']);
                    session()->set('user_id', $user['id_user']);
                    session()->set('nama', $user['nama']);
                    return redirect()->to(base_url('/dashboard'));
                } else {
                    session()->setFlashdata('gagal', 'Username atau password salah.');
                    return redirect()->to(base_url('/'));
                }
            } else {
                session()->setFlashdata('gagal', 'Silakan isi semua data yang diperlukan.');
                return redirect()->to(base_url('/'));
            }
        }
    
        return view('pages/login/signin', $data);
    }
    


    public function register()
    {
        return view('pages/login/signup'); // Ganti 'auth/register' dengan nama view registrasi yang sesuai
    }

    public function register_action()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $nama = $this->request->getPost('nama');
        $npk = $this->request->getPost('npk');

        // Validasi input
        if (empty($username) || empty($password) || empty($nama) || empty($npk)) {
            session()->setFlashdata('gagal', 'Isi semua data!');
            return redirect()->to(base_url('register'));
        }

        // Cek apakah username sudah terdaftar
        if ($userModel->where('username', $username)->countAllResults() > 0) {
            session()->setFlashdata('gagal', 'Username sudah terdaftar, gunakan username lain.');
            return redirect()->to(base_url('register'));
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Menyimpan data pengguna ke database
        $userData = [
            'username' => $username,
            'password' => $hashedPassword,
            'nama' => $nama,
            'npk' => $npk,
        ];

        $userModel->insert($userData);

        session()->setFlashdata('sukses', 'Registrasi berhasil! Silakan login.');
        return redirect()->to(base_url('/')); // Arahkan ke halaman login
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
