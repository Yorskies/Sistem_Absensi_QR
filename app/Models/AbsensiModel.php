<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object'; // Mengembalikan objek
    protected $useAutoIncrement = true;
    protected $allowedFields    = 
        ['siswa_nis', 'guru_nomor_induk', 'keterangan_waktu', 'status']; // Kolom yang dapat diisi

    // Dates
    protected $useTimestamps    = true; // Set true jika tabel Anda memiliki kolom `created_at` dan `updated_at`

    // Validation
    protected $skipValidation   = true; // Set true jika tidak ingin menggunakan validasi

    // Fungsi tambahan jika diperlukan

    // Fungsi untuk mendapatkan absensi berdasarkan siswa_id dan tanggal
    public function getAbsensi($siswa_nis, $tanggal)
    {
        return $this->where('siswa_nis', $siswa_nis)
                    ->where('keterangan_waktu', $tanggal)
                    ->first();
    }

    // Fungsi untuk mendapatkan semua absensi berdasarkan siswa_nis
    public function getAbsensiBySiswaId($siswa_nis)
    {
        return $this->where('siswa_nis', $siswa_nis)
                    ->orderBy('keterangan_waktu', 'DESC')
                    ->findAll();
    }

    public function getMenu($user_level_id){
        $this->builder()->select('menu.*');
        return $this->builder()->join('level', 'level.id = menu.user_level_id')
            ->where('menu.user_level_id', $user_level_id)->orderBy('urutan ASC')->get();
    }
}
