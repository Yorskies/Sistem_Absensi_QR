<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MataPelajaranModel;

class MataPelajaranController extends BaseController
{
    public function __construct()
    {
        $this->mataPelajaran = new MataPelajaranModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Kelola Data Mata Pelajaran',
            'nama_submenu' => '',
            'title' => 'List Data Mata Pelajaran',
            'mataPelajaran' => $this->mataPelajaran->findAll(),
        ];
        return view('mata_pelajaran/index', $data);
    }

    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $hasil = view('mata_pelajaran/fadd');
        echo json_encode($hasil);
    }

    public function simpan()
    {
        $data = $this->request->getPost();
        $validated = $this->validation->run($data, 'mata_pelajaran'); // Pastikan ada validasi untuk mata_pelajaran
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            if ($this->mataPelajaran->save($data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data mata pelajaran berhasil disimpan']);
            }
        }
    }

    public function fedit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'mataPelajaran' => $this->mataPelajaran->find($this->request->getVar('id')),
        ];
        $hasil = view('mata_pelajaran/fedit', $data);
        echo json_encode($hasil);
    }

    public function update()
    {
        $data = $this->request->getPost();
        $validated = $this->validation->run($data, 'mata_pelajaran'); // Pastikan ada validasi untuk mata_pelajaran
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            if ($this->mataPelajaran->update($data['id'], $data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data mata pelajaran berhasil diupdate']);
            }
        }
    }

    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $id = $this->request->getPost('id');
        if ($this->mataPelajaran->delete($id)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data mata pelajaran berhasil dihapus']);
        }
    }
}
