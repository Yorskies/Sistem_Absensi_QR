<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['id', 'username', 'password', 'level', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // menampilkan spesifik user 
    public function getUser($username = false)
    {
        $this->builder()->select('user.*, level.nama as nama_level');
        if ($username) {
            return $this->builder()->join('level', 'level.id = user.level')
                ->where('username', $username)->get();
        } else {
            return $this->builder()->join('level', 'level.id = user.level')
                ->orderBy('created_at', 'DESC')->get();
        }
    }
}
