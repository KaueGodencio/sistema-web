@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="font-weight-bold">Produtos</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalNovoProduto">
        <i class="fas fa-plus mr-2"></i> Novo Produto
    </button>
</div>

<!-- Modal Novo Produto -->
<div class="modal fade" id="modalNovoProduto" tabindex="-1" role="dialog" aria-labelledby="modalNovoProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalNovoProdutoLabel">Cadastrar Novo Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('produtos.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <label for="nome">Nome do Produto <span class="text-danger">*</span></label>
                            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="codigo_interno">Código Interno <span class="text-danger">*</span></label>
                            <input type="text" name="codigo_interno" id="codigo_interno" class="form-control @error('codigo_interno') is-invalid @enderror" value="{{ old('codigo_interno') }}" required>
                            @error('codigo_interno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" rows="3" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Ativo" {{ old('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ old('status') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 datatable">
                <thead class="thead-light">
                    <tr>
                        <th>Código Interno</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produtos as $produto)
                    <tr>
                        <td class="font-weight-bold text-primary">{{ $produto->codigo_interno }}</td>
                        <td>{{ $produto->nome }}</td>
                        <td>{{ Str::limit($produto->descricao, 50) ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $produto->status == 'Ativo' ? 'success' : 'secondary' }}">
                                {{ $produto->status }}
                            </span>
                        </td>
                        <td class="text-right text-nowrap">
                            <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-primary mr-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Nenhum produto cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
