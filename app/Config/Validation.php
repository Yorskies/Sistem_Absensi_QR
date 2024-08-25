<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $roleCustomer = [
        'nama' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'harus disi',
                'min_length' => 'nama minimal harus 3 karakter',
            ]
        ],
        'alamat' => [
            'rules' => 'required|min_length[5]',
            'errors' => [
                'required' => 'harus diisi',
                'min_length' => '{field} minimal 5 karakter'
            ]
        ],
        'telp' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'harus diisi',
                'min_length' => '{field} minimal 8 karakter'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'harus diisi',
                'valid_email' => 'email tidak valid'
            ]
        ],
        'pic' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'harus diisi',
                'min_length' => '{field} minimal 3 karakter'
            ]
        ],
    ];

    public $roleInvoice = [
        'no_inv' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'harus disi',
                'min_length' => 'nama minimal harus 3 karakter',
            ]
        ],
        'tgl' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'harus diisi',
            ]
        ],
        'customer_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'harus diisi',
            ]
        ],
        'keterangan' => [
            'rules' => 'required|min_length[5]',
            'errors' => [
                'required' => 'harus diisi',
                'min_length' => '{field} minimal 5 karakter'
            ]
        ],
        'nominal' => [
            'rules' => 'required|is_natural',
            'errors' => [
                'required' => 'harus diisi',
                'is_natural' => 'harus angka bulat'
            ]
        ],
    ];

    public $siswa = [
        'nomor_induk' => [
            'rules' => 'required|min_length[3]|max_length[20]',
            'errors' => [
                'required' => 'nomor induk harus diisi',
                'min_length' => 'nomor induk minimal 3 karakter',
                'max_length' => 'nomor induk maksimal 20 karakter'
            ]
        ],
        'nama' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => 'nama harus diisi',
                'min_length' => 'nama minimal 3 karakter',
                'max_length' => 'nama maksimal 100 karakter'
            ]
        ],
        'kelas' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'kelas harus diisi'
            ]
        ]
    ];

    public $mata_pelajaran = [
        'nama' => [
            'rules' => 'required|min_length[3]|max_length[100]',
            'errors' => [
                'required' => 'nama harus diisi',
                'min_length' => 'nama minimal 3 karakter',
                'max_length' => 'nama maksimal 100 karakter'
            ]
        ]
    ];
}
