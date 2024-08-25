<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    public function __construct()
    {
        $this->customer = new CustomerModel();
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
            'customer' => $this->customer->findAll(),
        ];
        return view('customer/index', $data);
    }
    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $hasil = view('customer/fadd');
        echo json_encode($hasil);
    }
    public function simpan()
    {
        $data = $this->request->getPost();
        $validated = $this->validation->run($data, 'roleCustomer');
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            $additional = [
                'id' => service('uuid')->uuid4()->toString(),
                'status' => 1,
            ];
            $data = array_merge($data, $additional);
            if ($this->customer->save($data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data customer berhasil disimpan']);
            };
        }
    }
    public function fedit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'customer' => $this->customer->find($this->request->getVar('id')),
        ];
        $hasil = view('customer/fedit', $data);
        echo json_encode($hasil);
    }
    public function update()
    {
        $data = $this->request->getPost();
        $validated = $this->validation->run($data, 'roleCustomer');
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            if ($this->customer->update($data['id'], $data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data customer berhasil diupdate']);
            };
        }
    }
    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $id = $this->request->getPost('id');
        if ($this->customer->delete($id)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data customer berhasil dihapus']);
        };
    }
}
