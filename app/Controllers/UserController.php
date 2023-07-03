<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $user;
    function __construct()
    {
        helper('form');
        $this->user = new userModel();
    }
    public function index()
    {
        // Mengambil daftar pengguna dari database
        $userModel = new UserModel();
        $users = $userModel->where('is_aktif', 'false')->findAll();

        // Menampilkan halaman manajemen pengguna kepada admin
        return view('pages/usermanajemen_view', ['users' => $users]);
    }
    public function update($userId)
    {
        // Periksa apakah pengguna yang sedang login memiliki peran admin
        if (session()->get('role') === 'admin') {
            // Dapatkan pengguna berdasarkan ID
            $userModel = new UserModel();
            $user = $userModel->find($userId);
    
            if ($user) {
                $userStatus = $user['is_aktif'];
    
                if ($userStatus == false) {
                    // Perbarui nilai is_aktif menjadi true
                    $userModel->update($userId, ['is_aktif' => true]);
                    return redirect()->back()->with('message', 'User status updated successfully.');
                } else {
                    return redirect()->back()->with('failed', 'User is already active.');
                }
            } else {
                return redirect()->back()->with('failed', 'User not found.');
            }
        } else {
            return redirect()->back()->with('failed', 'You do not have permission to perform this action.');
        }
    }
        
    public function destroy($id)
    {
        $userModel = new UserModel();
        $userModel->where('id', $id)->delete();
        // Redirect to another page or return a response
        return redirect()->back()->with('message', 'User deleted successfully');
    }
}