@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="font-weight-bold">Pedidos de Compra</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNovoPedido">
        <i class="fas fa-plus mr-2"></i> Novo Pedido
    </button>
</div>

<!-- Modal Novo Pedido -->
<div class="modal fade" id="modalNovoPedido" tabindex="-1" role="dialog" aria-labelledby="modalNovoPedidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalNovoPedidoLabel">Cadastrar Novo Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-header bg-white font-weight-bold">Informações Básicas</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="fornecedor_id">Fornecedor <span class="text-danger">*</span></label>
                                    <select name="fornecedor_id" id="fornecedor_id" class="form-control" required>
                                        <option value="">Selecione um fornecedor</option>
                                        @foreach($fornecedores as $fornecedor)
                                            <option value="{{ $fornecedor->id }}">{{ $fornecedor->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="data_pedido">Data do Pedido <span class="text-danger">*</span></label>
                                    <input type="date" name="data_pedido" id="data_pedido" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Aberto">Aberto</option>
                                        <option value="Processando">Processando</option>
                                        <option value="Concluído">Concluído</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label for="observacoes">Observações</label>
                                <textarea name="observacoes" id="observacoes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-0">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Itens do Pedido</span>
                            <button type="button" class="btn btn-sm btn-success" id="addItem">
                                <i class="fas fa-plus mr-1"></i> Adicionar Item
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table mb-0" id="itemsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 40%">Produto</th>
                                        <th>Quantidade</th>
                                        <th>Vl. Unitário</th>
                                        <th>Total</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody"></tbody>
                                <tfoot>
                                    <tr class="bg-light font-weight-bold">
                                        <td colspan="3" class="text-right">Total Geral:</td>
                                        <td id="grandTotal">R$ 0,00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="itemTemplate">
    <tr class="item-row">
        <td>
            <select name="itens[{index}][produto_id]" class="form-control" required>
                <option value="">Selecione</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="itens[{index}][quantidade]" class="form-control qty" min="1" value="1" required>
        </td>
        <td>
            <input type="number" name="itens[{index}][valor_unitario]" class="form-control unit-price" step="0.01" min="0" value="0.00" required>
        </td>
        <td class="item-total pt-3">R$ 0,00</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger removeItem"><i class="fas fa-times"></i></button>
        </td>
    </tr>
</template>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Fornecedor</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                    <tr>
                        <td class="font-weight-bold">#{{ $pedido->id }}</td>
                        <td>{{ $pedido->fornecedor->nome }}</td>
                        <td>{{ date('d/m/Y', strtotime($pedido->data_pedido)) }}</td>
                        <td>
                            @php
                                $badgeClass = [
                                    'Aberto' => 'info',
                                    'Processando' => 'warning',
                                    'Concluído' => 'success',
                                    'Cancelado' => 'danger'
                                ][$pedido->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $badgeClass }}">
                                {{ $pedido->status }}
                            </span>
                        </td>
                        <td class="text-right text-nowrap">
                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-outline-primary mr-1" title="Ver Detalhes">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('pedidos.destroy', $pedido) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Pedido" onclick="return confirm('Tem certeza que deseja excluir este pedido?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Nenhum pedido cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
