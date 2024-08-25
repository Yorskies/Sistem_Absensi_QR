<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\MataPelajaranModel;
use App\Models\JadwalPelajaranModel; // Pastikan model ini sudah ada

class JadwalController extends BaseController
{
    protected $jadwal;
    protected $guru;
    protected $mataPelajaran;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->jadwal = new JadwalPelajaranModel(); // Inisialisasi model Jadwal
        $this->guru = new GuruModel(); // Inisialisasi model Guru
        $this->mataPelajaran = new MataPelajaranModel(); // Inisialisasi model MataPelajaran
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
            'nama_menu' => 'Kelola Jadwal Pelajaran',
            'nama_submenu' => '',
            'title' => 'List Jadwal Pelajaran',
            'jadwal' => $jadwalList,
        ];
        return view('jadwal/index', $data);
    }
    
    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }

        // Contoh data hari, bisa disesuaikan dengan kebutuhan
        $hariOptions = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu'
        ];

        $data = [
            'guru' => $this->guru->findAll(), // Ambil semua guru
            'mataPelajaran' => $this->mataPelajaran->findAll(), // Ambil semua mata pelajaran
            'hariOptions' => $hariOptions // Tambahkan opsi hari untuk form tambah
        ];
        $hasil = view('jadwal/fadd', $data);
        echo json_encode($hasil);
    }

    public function simpan()
    {
        $data = $this->request->getPost();
    
        // Debug log untuk melihat data yang diterima
        log_message('debug', 'Data yang diterima: ' . print_r($data, true));
    
        if ($this->jadwal->save($data)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Jadwal pelajaran berhasil disimpan']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan
            $errors = $this->jadwal->errors(); // Ambil kesalahan dari model
            log_message('error', 'Kesalahan model: ' . print_r($errors, true));
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal menyimpan jadwal pelajaran']);
        }
    }
    
    public function fedit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $jadwalId = $this->request->getVar('id');
        
        // Data hari untuk dropdown
        $hariOptions = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu'
        ];

        $data = [
            'jadwal' => $this->jadwal->find($jadwalId),
            'guru' => $this->guru->findAll(), // Ambil semua guru
            'mataPelajaran' => $this->mataPelajaran->findAll(), // Ambil semua mata pelajaran
            'hariOptions' => $hariOptions // Tambahkan opsi hari untuk form edit
        ];
        $hasil = view('jadwal/fedit', $data);
        echo json_encode($hasil);
    }

    public function update()
    {
        $data = $this->request->getPost();
        
        // Update data jadwal
        if ($this->jadwal->update($data['id'], $data)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Jadwal pelajaran berhasil diupdate']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan dan log error
            $errors = $this->jadwal->errors(); // Ambil kesalahan dari model
            log_message('error', 'Kesalahan saat update data jadwal pelajaran: ' . print_r($errors, true));
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal mengupdate jadwal pelajaran']);
        }
    }
    
    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $id = $this->request->getPost('id');
        if ($this->jadwal->delete($id)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Jadwal pelajaran berhasil dihapus']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal menghapus jadwal pelajaran']);
        }
    }

    public function getGuru($mataPelajaranId)
    {
        $guruModel = new GuruModel();
        
        // Misalnya, metode ini mendapatkan guru berdasarkan mata pelajaran
        $guruList = $guruModel->where('mata_pelajaran', $mataPelajaranId)->findAll();

        $data = [
            'status' => true,
            'guru' => $guruList
        ];

        return $this->response->setJSON($data);
    }

}
