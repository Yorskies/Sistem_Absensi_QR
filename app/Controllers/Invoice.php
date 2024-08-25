<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\CustomerModel;
use App\Models\PembayaranModel;

class Invoice extends BaseController
{
    public function __construct()
    {
        $this->invoice = new InvoiceModel();
        $this->pembayaran = new PembayaranModel();
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
            'nama_menu' => 'Kelola Data Guru',
            'nama_submenu' => '',
            'title' => 'List Data Guru',
            'invoice' => $this->invoice->getInvoice()->getResult(),
        ];
        // dd($data['invoice']);
        return view('invoice/index', $data);
    }
    public function fadd()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'customer' => $this->customer->findAll(),
        ];
        $hasil = view('invoice/fadd', $data);
        echo json_encode($hasil);
    }
    public function simpan()
    {
        $data = $this->request->getPost();
        $validated = $this->validation->run($data, 'roleInvoice');
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
                'status' => 'Open',
            ];
            $data = array_merge($data, $additional);
            if ($this->invoice->save($data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data invoice berhasil disimpan']);
            };
        }
    }
    public function fedit()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $data = [
            'invoice' => $this->invoice->getInvoice($this->request->getVar('id'))->getResult()[0],
            'customer' => $this->customer->findAll(),
        ];
        $hasil = view('invoice/fedit', $data);
        echo json_encode($hasil);
    }
    public function update()
    {
        $data = $this->request->getPost();
        $validated = $this->validation->run($data, 'roleInvoice');
        if (!$validated) {
            $errors = $this->validation->getErrors();
            $output = [
                'status' => FALSE,
                'errors' => $errors
            ];
            echo json_encode($output);
        } else {
            if ($this->invoice->update($data['id'], $data)) {
                echo json_encode(['status' => TRUE, 'psn' => 'Data invoice berhasil diupdate']);
            };
        }
    }
    public function delete()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $id = $this->request->getPost('id');
        if ($this->invoice->delete($id)) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data invoice berhasil dihapus']);
        };
    }
    public function pay()
    {
        if (!$this->request->isAJAX()) {
            throw \CodeIgniter\Exceptions\PageNotfoundException::forPageNotFound('Maaf Halaman Tidak Ditemukan');
        }
        $dataInv = $this->invoice->find($this->request->getPost('id'));
        $this->pembayaran->save([
            'id' => service('uuid')->uuid4()->toString(),
            'no_inv' => $dataInv->no_inv,
            'tgl' => date('Y-m-d'),
            'nominal' => $dataInv->nominal
        ]);
        $berhasil = $this->invoice->update($this->request->getPost('id'), [
            'status' => 'Lunas'
        ]);
        if ($berhasil) {
            echo json_encode(['status' => TRUE, 'psn' => 'Data invoice berhasil dilunasi']);
        }
    }
}
