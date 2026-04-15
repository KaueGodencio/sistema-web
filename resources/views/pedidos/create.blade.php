@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2 class="font-weight-bold">Novo Pedido</h2>
    </div>

    <form action="{{ route('pedidos.store') }}" method="POST" id="orderForm">
        @csrf
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
                        <input type="date" name="data_pedido" id="data_pedido" class="form-control"
                            value="{{ date('Y-m-d') }}" required>
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
                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea name="observacoes" id="observacoes" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4">
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
                    <tbody id="itemsBody">
                        <!-- dinamica tabela -->
                    </tbody>
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

        <div class="mt-4 pb-5">
            <button type="submit" class="btn btn-primary px-5">Salvar Pedido</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-light px-4 ml-2">Cancelar</a>
        </div>
    </form>

    <template id="itemTemplate">
        <tr class="item-row">
            <td>
                <select name="itens[{index}][produto_id]" class="form-control select-product" required>
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
                <input type="number" name="itens[{index}][valor_unitario]" class="form-control unit-price" step="0.01"
                    min="0" value="0.00" required>
            </td>
            <td class="item-total pt-3">
                R$ 0,00
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger removeItem">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    </template>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            let itemIndex = 0;

            function addItem() {
                let template = $('#itemTemplate').html();
                template = template.replace(/{index}/g, itemIndex);
                $('#itemsBody').append(template);
                itemIndex++;
                calculateTotals();
            }

            function calculateTotals() {
                let grandTotal = 0;
                $('.item-row').each(function () {
                    let qty = parseFloat($(this).find('.qty').val()) || 0;
                    let unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
                    let total = qty * unitPrice;
                    $(this).find('.item-total').text('R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
                    grandTotal += total;
                });
                $('#grandTotal').text('R$ ' + grandTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
            }

            $('#addItem').on('click', function () {
                addItem();
            });

            $(document).on('click', '.removeItem', function () {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            $(document).on('input', '.qty, .unit-price', function () {
                calculateTotals();
            });


            addItem();
        });
    </script>
@endsection