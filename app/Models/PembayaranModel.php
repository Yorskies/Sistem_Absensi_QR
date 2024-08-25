<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'no_inv', 'tgl', 'keterangan', 'nominal'];
}
