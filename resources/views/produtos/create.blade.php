@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2 class="font-weight-bold">Novo Produto</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('produtos.store') }}" method="POST">
            @csrf
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

            <div class="mt-4">
                <button type="submit" class="btn btn-primary px-4">Cadastrar</button>
                <a href="{{ route('produtos.index') }}" class="btn btn-light px-4 ml-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
