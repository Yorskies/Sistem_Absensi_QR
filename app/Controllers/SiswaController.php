<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaModel;

class SiswaController extends BaseController
{
    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Kelola Data Siswa',
            'nama_submenu' => '',
            'title' => 'List Data Siswa',
            'siswa' => $this->siswa->findAll(),
        ];
        return view('siswa/index', $data);
    }

    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $hasil = view('siswa/fadd');
        echo json_encode($hasil);
    }

    public function simpan()
    {
        $data = $this->request->getPost();
        
        // Tetapkan nilai level secara default menjadi 3 untuk siswa
        $data['level'] = 3;
    
        // Hash password sebelum disimpan
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    
        $validated = $this->validation->run($data, 'siswa');
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            if ($this->siswa->save($data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data siswa berhasil disimpan']);
            }
        }
    }
    
    

    public function fedit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'siswa' => $this->siswa->find($this->request->getVar('id')),
        ];
        $hasil = view('siswa/fedit', $data);
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
    
        $validated = $this->validation->run($data, 'siswa');
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            if ($this->siswa->update($data['id'], $data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data siswa berhasil diupdate']);
            }
        }
    }
    

    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $id = $this->request->getPost('id');
        if ($this->siswa->delete($id)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data siswa berhasil dihapus']);
        }
    }
}
