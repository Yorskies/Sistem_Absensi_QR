<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $user;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $username = $this->session->get('username');
        $userData = $this->user->getUser($username)->getRow();

        $data = [
            'user' => $userData,
            'level_akses' => $this->session->get('nama_level'),
            'dtmenu' => $this->tampil_menu($this->session->get('level')),
            'dtsubmenu' => $this->tampil_submenu($this->session->get('level')),
            'hari' => $this->nama_hari(date('D')),
            'tgl' => date('d-M-Y'),
            'nama_menu' => 'Profile',
            'nama_submenu' => '',
            'title' => 'Data Profile',
        ];

        return view('profile', $data);
    }

    public function ubahpss()
    {
        $data = [
            'level_akses' => $this->session->get('nama_level'),
            'dtmenu' => $this->tampil_menu($this->session->get('level')),
            'dtsubmenu' => $this->tampil_submenu($this->session->get('level')),
            'nama_menu' => 'Ganti Password',
            'nama_submenu' => '',
            'title' => 'Form Ganti Data Profile',
        ];

        return view('ubah_password', $data);
    }

    public function submit_pssbaru()
    {
        if ($this->request->getPost('pss1') == $this->request->getPost('pss2')) {
            $username = $this->session->get('username');
            $user = $this->user->getUser($username)->getRow();

            if ($user) {
                $pssbaru = $this->request->getVar('pss1');
                $pssbaru = password_hash($pssbaru, PASSWORD_BCRYPT);
                
                $this->user->update($user->id, ['password' => $pssbaru]);

                session()->setFlashdata('success', 'Password berhasil diubah');
                return redirect()->to('/profile');
            } else {
                session()->setFlashdata('error', 'User tidak ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Password & konfirmasinya tidak sama');
            return redirect()->back();
        }
    }
}
