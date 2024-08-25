<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class Profile_siswa extends BaseController
{
    protected $siswa;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $username = $this->session->get('username');
        $siswaData = $this->siswa->getSiswa($username)->getRow();

        $data = [
            'siswa' => $siswaData,
            'level_akses' => $this->session->get('nama_level'),
            'nama_menu' => 'Profile Siswa',
            'dtmenu' => $this->tampil_menu($this->session->get('level')),
            'dtsubmenu' => $this->tampil_submenu($this->session->get('level')),
            'hari' => $this->nama_hari(date('D')),
            'tgl' => date('d-M-Y'),
            'nama_submenu' => '',
            'title' => 'Data Profile Siswa',
        ];

        return view('profile_siswa', $data);
    }

    public function ubahpss()
    {
        $data = [
            'level_akses' => $this->session->get('nama_level'),
            'nama_menu' => 'Ganti Password',
            'nama_submenu' => '',
            'title' => 'Form Ganti Password Siswa',
        ];

        return view('ubah_password_siswa', $data);
    }

    public function submit_pssbaru()
    {
        if ($this->request->getPost('pss1') == $this->request->getPost('pss2')) {
            $username = $this->session->get('username');
            $siswa = $this->siswa->getSiswa($username)->getRow();

            if ($siswa) {
                $pssbaru = $this->request->getVar('pss1');
                $pssbaru = password_hash($pssbaru, PASSWORD_BCRYPT);
                
                $this->siswa->update($siswa->id, ['password' => $pssbaru]);

                session()->setFlashdata('success', 'Password berhasil diubah');
                return redirect()->to('/profile_siswa');
            } else {
                session()->setFlashdata('error', 'Siswa tidak ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Password & konfirmasinya tidak sama');
            return redirect()->back();
        }
    }
}
