<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\InvoiceModel;

class Pembayaran extends BaseController
{
    public function __construct()
    {
        $this->pembayaran = new PembayaranModel();
        $this->invoice = new invoiceModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $data = [
            'level_akses' => $this->session->nama_level,
            'dtmenu' => $this->tampil_menu($this->session->level),
            'dtsubmenu' => $this->tampil_submenu($this->session->level),
            'nama_menu' => 'Laporan Absensi',
            'nama_submenu' => '',
            'title' => 'List Laporan Absensi',
            'pembayaran' => $this->pembayaran->findAll(),
        ];
        return view('pembayaran/index', $data);
    }
    public function cetakinv($no_inv)
    {
        $data = [
            'datainv' => $this->invoice->getInvoiceByNumber($no_inv)->getResult()[0],
        ];
        return view('pembayaran/cetakinv', $data);
    }
}
