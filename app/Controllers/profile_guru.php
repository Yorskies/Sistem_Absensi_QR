<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;

class Profile_guru extends BaseController
{
    protected $guru;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->guru = new GuruModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $username = $this->session->get('username');
        $guruData = $this->guru->getGuru($username)->getRow();

        $data = [
            'guru' => $guruData,
            'level_akses' => $this->session->get('nama_level'),
            'dtmenu' => $this->tampil_menu($this->session->get('level')),
            'dtsubmenu' => $this->tampil_submenu($this->session->get('level')),
            'hari' => $this->nama_hari(date('D')),
            'tgl' => date('d-M-Y'),
            'nama_menu' => 'Profile Guru',
            'nama_submenu' => '',
            'title' => 'Data Profile Guru',
        ];

        return view('profile_guru', $data);
    }

    public function ubahpss()
    {
        $data = [
            'level_akses' => $this->session->get('nama_level'),
            'nama_menu' => 'Ganti Password',
            'nama_submenu' => '',
            'title' => 'Form Ganti Password Guru',
        ];

        return view('ubah_password_guru', $data);
    }

    public function submit_pssbaru()
    {
        if ($this->request->getPost('pss1') == $this->request->getPost('pss2')) {
            $username = $this->session->get('username');
            $guru = $this->guru->getGuru($username)->getRow();

            if ($guru) {
                $pssbaru = $this->request->getVar('pss1');
                $pssbaru = password_hash($pssbaru, PASSWORD_BCRYPT);
                
                $this->guru->update($guru->id, ['password' => $pssbaru]);

                session()->setFlashdata('success', 'Password berhasil diubah');
                return redirect()->to('/profile_guru');
            } else {
                session()->setFlashdata('error', 'Guru tidak ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Password & konfirmasinya tidak sama');
            return redirect()->back();
        }
    }
}
