<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $fillable = ['nome', 'cnpj', 'email', 'telefone', 'status'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'fornecedor_produto', 'fornecedor_id', 'produto_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'fornecedor_id');
    }
}
