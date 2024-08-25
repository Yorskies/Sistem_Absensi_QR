<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class DaftarSiswaController extends BaseController
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
        $siswaList = $this->siswa->findAll();
        
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Daftar Siswa',
            'nama_submenu' => '',
            'title' => 'List Daftar Siswa',
            'siswa' => $siswaList,
        ];

        return view('daftar_siswa/index', $data);
    }
}
