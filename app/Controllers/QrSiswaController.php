<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


class QrSiswaController extends BaseController
{
    protected $siswa;
    protected $menu;
    protected $submenu;
    protected $session;

    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->menu = new MenuModel(); // Inisialisasi model menu
        $this->submenu = new SubmenuModel(); // Inisialisasi model submenu
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Mengambil data siswa
        $siswaList = $this->siswa->findAll();

        // Mendapatkan data menu dan submenu berdasarkan level akses
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'QR Siswa',
            'nama_submenu' => '',
            'title' => 'Daftar QR Siswa',
            'siswa' => $siswaList,
        ];

        return view('qrsiswa/index', $data);
    }

    public function indexAbsensiSiswa()
    {
        // Ambil ID siswa yang login dari session
        $siswaId = $this->session->get('id'); // Pastikan 'id' adalah nama key session yang menyimpan ID siswa
    
        // Ambil data siswa berdasarkan ID yang diambil dari session
        $siswa = $this->siswa->find($siswaId);
    
        // Cek apakah data siswa ditemukan
        if (!$siswa) {
            return $this->response->setJSON([
                'status' => false,
                'data' => null,
                'message' => 'Siswa tidak ditemukan.'
            ]);
        }
    
        // Cek apakah qr_code_url kosong
        if (empty($siswa->qr_code_url)) {
            return $this->response->setJSON([
                'status' => false,
                'data' => null,
                'message' => 'QR Code belum dibuat.'
            ]);
        }
    
        // Data menu dan submenu berdasarkan level akses
        $data = [
            'level_akses' => $this->session->get('nama_level'),
            'dtmenu' => $this->tampil_menu($this->session->get('level')),
            'dtsubmenu' => $this->tampil_submenu($this->session->get('level')),
            'nama_menu' => 'Absensi Siswa',
            'nama_submenu' => '',
            'title' => 'Daftar Absensi Siswa',
            'siswa' => $siswa,  // Menggunakan data siswa yang diambil berdasarkan ID dari session
            'qr_code_url' => $siswa->qr_code_url,
        ];
    
        // Menampilkan halaman absensi siswa dengan data yang sudah disiapkan
        return view('absensi_siswa/index', $data);
    }
    


    public function generateQrCodesForAll()
    {
        $siswaList = $this->siswa->findAll();
        $writer = new PngWriter();
        $uploadPath = FCPATH . 'uploads'; // Path ke direktori uploads
    
        // Buat direktori uploads jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
    
        $successCount = 0;
        $errorCount = 0;
        $errorMessages = [];
    
        foreach ($siswaList as $siswa) {
            try {
                // Gunakan nomor_induk untuk QR code
                $qrCodeData = $siswa->nomor_induk;
    
                // Buat QR code
                $qrCode = QrCode::create($qrCodeData)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                    ->setSize(300)
                    ->setMargin(10)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(0, 0, 0))
                    ->setBackgroundColor(new Color(255, 255, 255));
    
                // Buat logo
                $logo = Logo::create(FCPATH . 'assets/images/logo/logo2.png')
                    ->setResizeToWidth(50);
    
                // Buat label
                $label = Label::create('Nomor Induk Siswa: ' . $siswa->nomor_induk)
                    ->setTextColor(new Color(255, 0, 0));
    
                // Generate QR code
                $result = $writer->write($qrCode, $logo, $label);
    
                $qrCodeUrl = 'uploads/qr_code_' . $siswa->id . '.png'; // Path relatif ke uploads
                $result->saveToFile(FCPATH . $qrCodeUrl);
    
                // Update URL QR Code di database
                $this->siswa->update($siswa->id, ['qr_code_url' => $qrCodeUrl]);
    
                $successCount++;
            } catch (ValidationException $e) {
                // Tangani exception jika perlu
                $errorMessages[] = 'QR Code validation failed for Siswa ID: ' . $siswa->id . ' - ' . $e->getMessage();
                $errorCount++;
            } catch (\Exception $e) {
                // Tangani exception umum
                $errorMessages[] = 'An error occurred while generating QR Code for Siswa ID: ' . $siswa->id . ' - ' . $e->getMessage();
                $errorCount++;
            }
        }
    
        if ($successCount > 0) {
            return $this->response->setJSON([
                'status' => true,
                'psn' => "$successCount QR Code(s) Berhasil Dibuat.",
                'errors' => $errorMessages
            ]);
        } else {
            return $this->response->setJSON([
                'status' => false,
                'psn' => 'Gagal membuat QR Codes.',
                'errors' => $errorMessages
            ]);
        }
    }

    // Fungsi fshow untuk menampilkan detail QR Code siswa
    public function fshow($id)
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }

        // Ambil data siswa berdasarkan ID
        $siswa = $this->siswa->find($id);

        // Cek apakah siswa ditemukan
        if ($siswa) {
            // Kirim data siswa sebagai respons JSON
            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'id' => $siswa->id,
                    'nomor_induk' => $siswa->nomor_induk,
                    'nama' => $siswa->nama,
                    'kelas' => $siswa->kelas,
                    'status' => $siswa->status,
                    'username' => $siswa->username,
                    'qr_code_url' => $siswa->qr_code_url
                ]
            ]);
        } else {
            // Kirim respons JSON jika siswa tidak ditemukan
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Siswa tidak ditemukan.'
            ]);
        }
    }
    public function showImage()
    {        
        // Periksa jika data ditemukan
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'siswa' => $this->siswa->find($this->request->getVar('id')),
        ];
        $hasil = view('qrsiswa/fshow', $data);
        echo json_encode($hasil);
        
    }
}
