@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="font-weight-bold">Detalhes do Pedido #{{ $pedido->id }}</h2>
    <a href="{{ route('pedidos.index') }}" class="btn btn-light">
        <i class="fas fa-arrow-left mr-2"></i> Voltar
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h6 class="text-muted text-uppercase small font-weight-bold mb-0">Informações do Fornecedor</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <h5 class="text-primary font-weight-bold mb-3">{{ $pedido->fornecedor->nome }}</h5>
                <div class="d-flex flex-column gap-2">
                    <p class="mb-2 text-muted d-flex align-items-center"><i class="fas fa-id-card mr-3 text-primary opacity-50"></i> {{ $pedido->fornecedor->cnpj ?? 'Sem CNPJ' }}</p>
                    <p class="mb-2 text-muted d-flex align-items-center"><i class="fas fa-envelope mr-3 text-primary opacity-50"></i> {{ $pedido->fornecedor->email ?? 'Sem E-mail' }}</p>
                    <p class="mb-0 text-muted d-flex align-items-center"><i class="fas fa-phone mr-3 text-primary opacity-50"></i> {{ $pedido->fornecedor->telefone ?? 'Sem Telefone' }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h6 class="text-muted text-uppercase small font-weight-bold mb-0">Resumo do Pedido</h6>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Data da Emissão</span>
                    <span class="font-weight-bold">{{ date('d/m/Y', strtotime($pedido->data_pedido)) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Situação</span>
                    @php
                        $badgeClass = [
                            'Aberto' => 'info',
                            'Processando' => 'warning',
                            'Concluído' => 'success',
                            'Cancelado' => 'danger'
                        ][$pedido->status] ?? 'secondary';
                    @endphp
                    <span class="badge badge-{{ $badgeClass }} px-3 py-2">{{ $pedido->status }}</span>
                </div>
                <hr class="my-3 opacity-5">
                <div class="form-group mb-0">
                    <label class="text-muted small font-weight-bold text-uppercase">Observações Internas</label>
                    <div class="p-3 bg-light rounded-lg small text-muted">
                        {{ $pedido->observacoes ?: 'Nenhuma observação registrada para este pedido.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="text-muted text-uppercase small font-weight-bold mb-0">Itens dos Itens Solicitados</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4">Produto</th>
                                <th class="text-center border-0">Qtd.</th>
                                <th class="text-right border-0 px-4">Vl. Unitário</th>
                                <th class="text-right border-0 px-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalGeral = 0; @endphp
                            @foreach($pedido->itens as $item)
                            <tr>
                                <td class="px-4 font-weight-bold text-dark">{{ $item->produto->nome }}</td>
                                <td class="text-center">{{ $item->quantidade }}</td>
                                <td class="text-right">R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                                <td class="text-right font-weight-bold text-dark px-4">R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                            </tr>
                            @php $totalGeral += $item->valor_total; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold px-4 py-4">Valor Total Geral:</td>
                                <td class="text-right font-weight-bold text-primary h4 px-4 py-4">R$ {{ number_format($totalGeral, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
