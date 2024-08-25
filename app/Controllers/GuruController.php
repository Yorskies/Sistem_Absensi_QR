<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\MataPelajaranModel;

class GuruController extends BaseController
{
    protected $guru;
    protected $mataPelajaran;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->guru = new GuruModel();
        $this->mataPelajaran = new MataPelajaranModel(); // Inisialisasi model MataPelajaran
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $guruList = $this->guru->findAll();
        foreach ($guruList as $guru) {
            $guru->mata_pelajaran_name = $this->mataPelajaran->getMataPelajaranNameById($guru->mata_pelajaran);
        }
    
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Kelola Data Guru',
            'nama_submenu' => '',
            'title' => 'List Data Guru',
            'guru' => $guruList,
        ];
        return view('guru/index', $data);
    }
    

    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'mataPelajaran' => $this->mataPelajaran->findAll() // Ambil semua mata pelajaran
        ];
        $hasil = view('guru/fadd', $data);
        echo json_encode($hasil);
    }

    public function simpan()
    {
        $data = $this->request->getPost();
    
        // Tetapkan nilai level secara default
        $data['level'] = 2;
    
        // Debug log untuk melihat data yang diterima
        log_message('debug', 'Data yang diterima: ' . print_r($data, true));
    
        // Hash password sebelum disimpan
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
        if ($this->guru->save($data)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data guru berhasil disimpan']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan
            $errors = $this->guru->errors(); // Ambil kesalahan dari model
            log_message('error', 'Kesalahan model: ' . print_r($errors, true));
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal menyimpan data guru']);
        }
    }
    
    
    
    public function fedit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $guruId = $this->request->getVar('id');
        $data = [
            'guru' => $this->guru->find($guruId),
            'mataPelajaran' => $this->mataPelajaran->findAll() // Ambil semua mata pelajaran
        ];
        $hasil = view('guru/fedit', $data);
        echo json_encode($hasil);
    }
    

    public function update()
    {
        $data = $this->request->getPost();
        
        // Jika ada input password baru, hash password dan update
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Jangan update password jika kosong
            unset($data['password']);
        }
        
        // Update data guru
        if ($this->guru->update($data['id'], $data)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data guru berhasil diupdate']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan dan log error
            $errors = $this->guru->errors(); // Ambil kesalahan dari model
            log_message('error', 'Kesalahan saat update data guru: ' . print_r($errors, true));
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal mengupdate data guru']);
        }
    }
    
    
    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $id = $this->request->getPost('id');
        if ($this->guru->delete($id)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data guru berhasil dihapus']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal menghapus data guru']);
        }
    }
}
