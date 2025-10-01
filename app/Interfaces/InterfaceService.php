<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface InterfaceService
{
    public function model(): Model;
}
