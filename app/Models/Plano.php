<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'tenant';
    
    protected $primaryKey = 'id';

    protected $table = 'planos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'duracao_dias',
        'ativo',
    ];

    protected $casts = [
        'preco' => 'float',
        'ativo' => 'boolean',
    ];

    public function alunos()
    {
        return $this->hasMany(Aluno::class, 'plano_id');
    }
}
