<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ItemPedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('fornecedor')->latest()->get();
        $fornecedores = Fornecedor::where('status', 'Ativo')->get();
        $produtos = Produto::where('status', 'Ativo')->get();
        
        return view('pedidos.index', compact('pedidos', 'fornecedores', 'produtos'));
    }

    public function create()
    {
        $fornecedores = Fornecedor::where('status', 'Ativo')->get();
        $produtos = Produto::where('status', 'Ativo')->get();
        return view('pedidos.create', compact('fornecedores', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'data_pedido' => 'required|date',
            'status' => 'required|in:Aberto,Processando,Concluído,Cancelado',
            'itens' => 'required|array|min:1',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $pedido = Pedido::create([
                'fornecedor_id' => $request->fornecedor_id,
                'data_pedido' => $request->data_pedido,
                'status' => $request->status,
                'observacoes' => $request->observacoes,
            ]);

            foreach ($request->itens as $item) {
                $pedido->itens()->create([
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['valor_unitario'],
                    'valor_total' => $item['quantidade'] * $item['valor_unitario'],
                ]);
            }
        });

        return redirect()->route('pedidos.index')->with('success', 'Pedido criado com sucesso!');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['fornecedor', 'itens.produto']);
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $fornecedores = Fornecedor::where('status', 'Ativo')->get();
        return view('pedidos.edit', compact('pedido', 'fornecedores'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'status' => 'required|in:Aberto,Processando,Concluído,Cancelado',
            'observacoes' => 'nullable|string',
        ]);

        $pedido->update($request->only(['status', 'observacoes']));

        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso!');
    }
}
