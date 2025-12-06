<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = 
    [
        'nome', 
        'cpf', 
        'email', 
        'data_nascimento', 
        'status'
    ];
    
    protected $casts = [
        'data_nascimento' => 'date',
    ];
}