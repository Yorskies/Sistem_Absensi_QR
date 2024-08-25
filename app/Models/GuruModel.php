<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table            = 'daftar_guru';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'nomor_induk',
        'nama',
        'mata_pelajaran',
        'status',
        'level',
        'username',
        'password'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'nomor_induk' => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        'nama'        => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
        'mata_pelajaran' => 'required|integer',
        'status'      => 'required|in_list[Aktif,Tidak Aktif]',
        'username'    => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        'password'    => 'required|min_length[8]'
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan, silakan pilih username yang lain.'
        ]
    ];

    protected $skipValidation = false;

    // Fungsi untuk mendapatkan guru dengan level
    public function getGuru($username = false)
    {
        $builder = $this->builder();
        $builder->select('daftar_guru.*, level.nama as nama_level')
                ->join('level', 'level.id = daftar_guru.level');
        
        if ($username) {
            $builder->where('daftar_guru.username', $username);
            return $builder->get();
        } else {
            return $builder->orderBy('created_at', 'DESC')->get();
        }
    }

    // Fungsi untuk mendapatkan nama guru berdasarkan ID
    public function getNamaGuruById($id)
    {
        return $this->select('nama')
                    ->where('id', $id)
                    ->first();
    }

    public function getNamaGuruByNip($nomorInduk)
    {
        return $this->select('nama')
                    ->where('nomor_induk', $nomorInduk)
                    ->first();
    }

    // Fungsi untuk mendapatkan guru berdasarkan username
    public function getGuruByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function findByGuruId($guruId)
    {
        return $this->where('id', $guruId)->first();
    }
}
