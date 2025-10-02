<?php

namespace Financas\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model {

    protected $table = 'usuario';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'nome', 'telefone', 'email', 'token', 'ativo', 'senha', 'foto'];

    protected $dates = ['created_at', 'updated_at'];
}
