@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel CRUD com Imagem</h2>
            </div>
            <div class="pull-right" style="margin-bottom:10px;">
                <a class="btn btn-success" href="{{ url('create') }}"> Novo Produto</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div id="success-message" class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Detalhe</th>
            <th width="280px">Ação</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    <img src="{{ $product->productImage[0]->image }}" width="100px" alt="image">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->detail }}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('show', $product->id) }}">Visualizar</a>
                    <a class="btn btn-primary" href="{{ route('edit', $product->id) }}">Editar</a>
                    <a href="{{ route('destroy', $product->id) }}"
                        onclick="return confirm('Tem Certeza que Deseja Deletar esse Item?')" class="btn btn-danger">
                        Deletar</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{-- script js para tirar a msg deccess --}}
    <script>
        window.onload = function() {
            if (document.getElementById("success-message")) {
                setTimeout(function() {
                    document.getElementById("success-message").style.display = 'none';
                }, 2000);
            }
        }
    </script>
@endsection
