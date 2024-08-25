<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'daftar_siswa';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object'; // Mengembalikan objek
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'nomor_induk', 
        'nama', 
        'kelas', 
        'status', 
        'username', 
        'password', 
        'level', 
        'qr_code_url'
    ];

    // Dates
    protected $useTimestamps    = false; // Set true jika tabel Anda memiliki kolom `created_at` dan `updated_at`
    protected $createdField     = null;   // Set null jika tidak menggunakan timestamps
    protected $updatedField     = null;   // Set null jika tidak menggunakan timestamps
    protected $deletedField     = null;   // Set null jika tidak menggunakan soft deletes

    // Validation
    protected $skipValidation   = true; // Set true jika tidak ingin menggunakan validasi

    // Fungsi untuk mendapatkan siswa dengan level
    public function getSiswa($username = false)
    {
        $builder = $this->builder();
        $builder->select('daftar_siswa.*, level.nama as nama_level')
                ->join('level', 'level.id = daftar_siswa.level');
        
        if ($username) {
            $builder->where('daftar_siswa.username', $username);
            return $builder->get();
        } else {
            return $builder->orderBy('id', 'DESC')->get();
        }
    }

    // Fungsi untuk mendapatkan siswa berdasarkan username
    public function getSiswaByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Fungsi untuk mendapatkan nama siswa berdasarkan id
    public function getSiswaNamabyId($id)
    {
        $builder = $this->builder();
        $builder->select('nama')
                ->where('id', $id);
        $result = $builder->get()->getRow();
        return $result ? $result->nama : null;
    }

    public function getSiswaByQrCodeUrl($qrCodeUrl)
    {
        $qrCodeUrl = 'uploads/' . $qrCodeUrl;
        return $this->where('qr_code_url', $qrCodeUrl)->first();
    }

    public function findByNomorInduk($nomorInduk)
    {
        return $this->where('nomor_induk', $nomorInduk)->first();
    }

    public function getSiswaNamaByNis($nomorInduk)
    {
        $builder = $this->builder();
        $builder->select('nama, kelas')
                ->where('nomor_induk', $nomorInduk);
        $result = $builder->get()->getRow();
        
        if ($result) {
            return [
                'nama'  => $result->nama,
                'kelas' => $result->kelas
        ];
    }

    return null; // Jika tidak ada hasil ditemukan
}


}
