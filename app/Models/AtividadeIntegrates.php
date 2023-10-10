<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AtividadeIntegrates extends Model{
    use HasFactory, SoftDeletes;
    public function integrante(){
        return $this->belongsTo('\App\Models\Integrante');
    }
    public function atividade(){
        return $this->belongsTo('\App\Models\Atividade');
    }
}
