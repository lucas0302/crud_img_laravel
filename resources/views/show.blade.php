@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Visualizar Produto</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ url('/') }}">Volta</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nome:</strong>
                {{ $product->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Detalhes:</strong>
                {{ $product->detail }}
            </div>
        </div>

        @if ($product->productImage)
            <strong>Imagem:</strong>
            @foreach ($product->productImage as $item)
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <img src="{{ asset($item->image) }}" width="100px">
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
