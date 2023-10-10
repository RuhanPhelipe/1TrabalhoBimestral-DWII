<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Integrante extends Model{
    use HasFactory, softDeletes;

    public function atividade(){
        return $this->belongsToMany('\App\Models\Atividade', 'atividade_integrates');
    }
}
