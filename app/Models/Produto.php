<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'descricao', 'codigo_interno', 'status'];

    public function fornecedores()
    {
        return $this->belongsToMany(Fornecedor::class, 'fornecedor_produto', 'produto_id', 'fornecedor_id');
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class, 'produto_id');
    }
}
