<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'tenant';

    protected $primaryKey = 'id';

    protected $fillable =
        [
            'nome',
            'cpf',
            'email',
            'data_nascimento',
            'status',
        ];

    protected $dates =
        [
            'deleted_at',
        ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];
}
