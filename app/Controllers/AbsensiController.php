<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbsensiModel;
use App\Models\SiswaModel;
use App\Models\GuruModel;

class AbsensiController extends BaseController
{
    protected $absensiModel;
    protected $siswaModel;
    protected $guruModel;
    protected $session;

    public function __construct()
    {
        $this->absensiModel = new AbsensiModel();
        $this->siswaModel = new SiswaModel();
        $this->guruModel = new GuruModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Mendapatkan tanggal hari ini dalam format 'Y-m-d'
        $today = date('Y-m-d');
    
        // Ambil data absensi dengan tanggal hari ini pada kolom created_at
        $absensiList = $this->absensiModel->where("DATE(created_at)", $today)->findAll();
        
        foreach ($absensiList as $absensi) {
            $absensi->nama_guru = $this->guruModel->getNamaGuruByNip($absensi->guru_nomor_induk)->nama;
            $absensi->nama_siswa = $this->siswaModel->getSiswaNamaByNis($absensi->siswa_nis);
        }
    
        // Mendapatkan data menu dan submenu berdasarkan level akses
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Daftar Absensi',
            'nama_submenu' => '',
            'title' => 'List Daftar Absensi',
            'absensi' => $absensiList
        ];
    
        return view('absensi_guru/index', $data);
    }
    

    public function fscan()
    {
        // Mendapatkan data menu dan submenu berdasarkan level akses
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Scan QR Code / Barcode',
            'nama_submenu' => '',
            'title' => 'Scan QR Code / Barcode',
        ];

        return view('absensi_guru/fscan', $data);
    }

    public function tambahDataAbsensi($data)
    {
        return $this->absensiModel->insert($data) ?
            redirect()->to('/success') :
            redirect()->to('/failure');
    }

    public function statusAbsensi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggalHariIni = date('Y-m-d');
        $waktuMasuk = date('Y-m-d h:i:s') . ' WIB';
        $waktuAwal = $tanggalHariIni . ' 07:00:00';
        $waktuAkhir = $tanggalHariIni . ' 08:00:00';

        // Mengonversi waktu ke objek DateTime
        $waktuMasukObj = new \DateTime($waktuMasuk);
        $waktuAwalObj = new \DateTime($waktuAwal);
        $waktuAkhirObj = new \DateTime($waktuAkhir);

        $status = '';

        // Periksa apakah waktu masuk berada dalam rentang waktu batas
        if ($waktuMasukObj <= $waktuAkhirObj) {
            $status = "Hadir";
        } else {
            $status = "Absen";
        }
        return $status;
    }

    public function keteranganAbsensi()
    {
        $nis = $this->request->getGet('nis');
        $guruId = $this->request->getGet('guruId');
        // Periksa jika data ditemukan
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'siswa' => $this->siswaModel->findByNomorInduk($nis),
            'guru' => $this->guruModel->findByGuruId($guruId),
            'status' => $this->statusAbsensi(),
        ];

        $inputData = [
            'siswa_nis' => $data['siswa']->nomor_induk,
            'guru_nomor_induk' => $data['guru']->nomor_induk,
            'keterangan_waktu' => date('Y-m-d h:i:s'),
            'status' => $data['status']
        ];

        $hasil = view('absensi_guru/modalKeteranganQrAbsen', $data);
        echo json_encode($hasil);
        return $this->absensiModel->insert($inputData);
    }

    function order_summary_insert()
    {
        $OrderLines = $this->input->post('orderlines');
        $CustomerName = $this->input->post('customer');
        $data = array(
            'OrderLines' => $OrderLines,
            'CustomerName' => $CustomerName
        );

        $this->db->insert('Customer_Orders', $data);
    }

    // Menambahkan absensi baru
    public function create()
    {
        // Ambil data dari request
        $siswaNis = $this->request->getPost('siswa_nis');
        $tanggal = $this->request->getPost('tanggal');
        $status = $this->request->getPost('status');
        $keterangan = $this->request->getPost('keterangan');

        // Validasi data
        if (empty($siswaNis) || empty($tanggal) || empty($status)) {
            return redirect()->back()->with('error', 'Semua field harus diisi');
        }

        // Simpan data absensi
        $this->absensiModel->save([
            'siswa_nis' => $siswaNis,
            'tanggal' => $tanggal,
            'status' => $status,
            'keterangan' => $keterangan
        ]);

        return redirect()->to('/absensi')->with('success', 'Absensi berhasil ditambahkan');
    }

    // Menampilkan detail absensi berdasarkan ID
    public function show($id)
    {
        // Ambil data absensi berdasarkan ID
        $absensi = $this->absensiModel->find($id);

        if (!$absensi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Absensi tidak ditemukan');
        }

        // Mendapatkan data menu dan submenu berdasarkan level akses
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Detail Absensi',
            'nama_submenu' => '',
            'title' => 'Detail Absensi',
            'absensi' => $absensi
        ];

        return view('absensi_guru/show', $data);
    }

    // Form untuk menambah data absensi
    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }

        $data = [
            'siswa' => $this->siswaModel->findAll(), // Ambil semua siswa
            'guru' => $this->guruModel->findAll(), // Ambil semua guru
        ];
        $hasil = view('absensi_guru/fadd', $data);
        echo json_encode($hasil);
    }

    public function tambah()
    {
        // Mengatur zona waktu
        date_default_timezone_set('Asia/Jakarta');
    
        // Ambil data dari request
        $data = $this->request->getPost();  
        $data['guru_nomor_induk'] = $this->session->nomor_induk;
        
        // Mengambil waktu saat ini
        $waktuMasuk = date('Y-m-d H:i:s');
        $tanggalHariIni = date('Y-m-d');
        $waktuAwal = $tanggalHariIni . ' 07:00:00';
        $waktuAkhir = $tanggalHariIni . ' 08:00:00';
    
        // Mengonversi waktu ke objek DateTime
        $waktuMasukObj = new \DateTime($waktuMasuk);
        $waktuAwalObj = new \DateTime($waktuAwal);
        $waktuAkhirObj = new \DateTime($waktuAkhir);
        
        $data['keterangan_waktu'] = $waktuMasuk; // Tanggal saat ini
    
        // Debug log untuk melihat data yang diterima
        log_message('debug', 'Data yang diterima: ' . print_r($data, true));
        
        // Simpan data menggunakan model
        if ($this->absensiModel->save($data)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data absensi berhasil disimpan']);
        } else {
            // Jika ada kesalahan dari model, tampilkan pesan
            $errors = $this->absensiModel->errors(); // Ambil kesalahan dari model
            log_message('error', 'Kesalahan model: ' . print_r($errors, true));
            echo json_encode(['status' => FALSE, 'psn' => 'Gagal menyimpan data absensi']);
        }
    }
    
    
    
}
