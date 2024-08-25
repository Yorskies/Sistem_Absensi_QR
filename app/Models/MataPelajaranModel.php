<?php

namespace App\Models;

use CodeIgniter\Model;

class MataPelajaranModel extends Model
{
    // Nama tabel di database
    protected $table = 'mata_pelajaran';

    // Primary key tabel
    protected $primaryKey = 'id';

    // List kolom yang dapat diisi
    protected $allowedFields = ['nama', 'status', 'created_at', 'updated_at'];

    // Menetapkan format tanggal dan waktu jika diperlukan
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Menetapkan tipe data untuk setiap kolom
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    // Jika Anda menggunakan soft delete, tentukan kolom soft delete
    // protected $deletedField  = 'deleted_at';

    /**
     * Mendapatkan nama mata pelajaran berdasarkan ID.
     *
     * @param int $id ID mata pelajaran
     * @return string Nama mata pelajaran
     */
    public function getMataPelajaranNameById($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('nama');
        $builder->where('id', $id);
        $query = $builder->get()->getRow();

        return $query ? $query->nama : null;
    }
}
