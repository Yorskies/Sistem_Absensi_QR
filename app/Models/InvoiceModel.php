<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'invoice';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'no_inv', 'tgl', 'customer_id', 'keterangan', 'nominal', 'status'];

    // menampilkan spesifik invoice 
    public function getInvoice($id = false)
    {
        $this->builder()->select('invoice.*, customer.nama as nama_customer');
        if ($id) {
            return $this->builder()->join('customer', 'customer.id = invoice.customer_id')
                ->where('invoice.id', $id)->get();
        } else {
            return $this->builder()->join('customer', 'customer.id = invoice.customer_id')
                ->orderBy('customer.nama', 'ASC')->get();
        }
    }
    // menampilkan spesifik invoice 
    public function getInvoiceByNumber($no_inv)
    {
        $this->builder()->select('invoice.*, customer.nama as nama_customer, customer.alamat as alamat_customer, customer.telp as telp_customer');
        return $this->builder()->join('customer', 'customer.id = invoice.customer_id')
            ->where('invoice.no_inv', $no_inv)->get();
    }
}
