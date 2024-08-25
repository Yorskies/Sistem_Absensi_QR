<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\SiswaModel;
use App\Models\LevelModel;

class Login extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();
        $this->siswaModel = new SiswaModel();
        $this->levelModel = new LevelModel();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        return view('login');
    }

    public function ceklogin()
    {
        $dataLogin = $this->request->getPost();

        if (empty($dataLogin['username']) || empty($dataLogin['pss'])) {
            $this->session->setFlashdata('pesan', 'Isi form belum lengkap');
            log_message('error', 'Form login tidak lengkap: ' . print_r($dataLogin, true));
            return redirect()->to('/logindulu');
        }

        // Check in UserModel
        $user = $this->userModel->getUser($dataLogin['username'])->getRow();
        if ($user) {
            $validUser = $this->validateUser($user, $dataLogin['pss']);
            if ($validUser) {
                return $this->handleSuccessfulLogin($user);
            } else {
                log_message('error', 'Password salah atau akun tidak aktif untuk username: ' . $dataLogin['username']);
            }
        }

        // Check in GuruModel
        $guru = $this->guruModel->getGuru($dataLogin['username'])->getRow();
        if ($guru) {
            $validGuru = $this->validateUser($guru, $dataLogin['pss']);
            if ($validGuru) {
                return $this->handleSuccessfulLogin($guru);
            } else {
                log_message('error', 'Password salah atau akun tidak aktif untuk username: ' . $dataLogin['username']);
            }
        }

        // Check in SiswaModel
        $siswa = $this->siswaModel->getSiswa($dataLogin['username'])->getRow();
        if ($siswa) {
            $validSiswa = $this->validateUser($siswa, $dataLogin['pss']);
            if ($validSiswa) {
                return $this->handleSuccessfulLogin($siswa);
            } else {
                log_message('error', 'Password salah atau akun tidak aktif untuk username: ' . $dataLogin['username']);
            }
        }

        // If no user is found
        $this->session->setFlashdata('pesan', 'Username atau password tidak benar');
        log_message('error', 'Username tidak ditemukan atau password salah: ' . $dataLogin['username']);
        return redirect()->to('/logindulu');
    }
   
    private function validateUser($user, $password)
    {
        // Cek apakah password valid dan akun aktif berdasarkan format status yang berbeda
        if (isset($user->password)) {
            return password_verify($password, $user->password) && ($user->status === 'Aktif' || $user->status == 1);
        }
        return false;
    }
    

    private function handleSuccessfulLogin($user)
    {
        $dtuser = [
            'nama'        => $user->nama,
            'id'          => $user->id,
            'nomor_induk' => $user->nomor_induk,
            'username'    => $user->username,
            'level'       => $user->level,
            'nama_level'  => $user->nama_level,
            'sdh_login'   => true
        ];
        $this->session->set($dtuser);
        $this->session->setFlashdata('success', 'Login Berhasil');
        
        // Redirect berdasarkan level
        switch ($user->nama_level) {
            case 'Guru':
                return redirect()->to('/profile_guru/');
            case 'Siswa':
                return redirect()->to('/profile_siswa/');
            case 'Admin':
                return redirect()->to('/profile/');
            default:
                // Jika nama_level tidak dikenali, redirect ke halaman default
                return redirect()->to('/profile');
        }
    }
    

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/logindulu');
    }
}
