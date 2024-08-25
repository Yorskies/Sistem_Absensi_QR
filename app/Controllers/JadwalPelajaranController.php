<?php

namespace App\Controllers;

use App\Models\JadwalPelajaranModel;
use App\Models\GuruModel;
use App\Models\MataPelajaranModel;

class JadwalPelajaranController extends BaseController
{
    protected $jadwal;
    protected $guru;
    protected $mataPelajaran;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->jadwal = new JadwalPelajaranModel();
        $this->guru = new GuruModel();
        $this->mataPelajaran = new MataPelajaranModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $jadwalList = $this->jadwal->findAll();
        foreach ($jadwalList as $jadwal) {
            $jadwal->nama_guru = $this->guru->getNamaGuruById($jadwal->guru_id)->nama;
            $jadwal->mata_pelajaran_name = $this->mataPelajaran->getMataPelajaranNameById($jadwal->mata_pelajaran_id);
        }
    
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Jadwal Pelajaran',
            'nama_submenu' => '',
            'title' => 'List Jadwal Pelajaran',
            'jadwal' => $jadwalList,
        ];
        
        return view('jadwal_pelajaran/index', $data);
    }
}
