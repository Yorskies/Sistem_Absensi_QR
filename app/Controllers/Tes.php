<?php

namespace App\Controllers;

class Tes extends BaseController
{
    public function index(): string
    {
        $data = service('uuid')->uuid4()->toString();
        dd($data);
    }
}
