<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class RegisterController extends BaseController
{
    protected $user;
    function __construct()
    {
        helper('form');
        $this->user = new userModel();
    }
    public function index()
    {
        return view('Views/register_view');
    }
    public function register()
    {
        // Mengambil data yang dikirim melalui POST
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
    
        // Validasi data yang diterima
        $validationRules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[user.username]',
            'password' => 'required|min_length[6]',
        ];
    
        if (!$this->validate($validationRules)) {
            // Jika validasi gagal, tampilkan kembali form register dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Simpan pengguna ke database
        $userModel = new UserModel();
        $userModel->save([
            'username' => $username,
            'role' => 'user',
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'is_aktif' => 'false',
        ]);
    
        // Redirect ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('message', 'Registration successful! Please wait for admin verification.');
    }
}