@extends('app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edite o Produto</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('index') }}"> Volta</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Houve alguns problemas com sua input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('update',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Nome">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Detalhes:</strong>
                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Detalhes">{{ $product->detail }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Imagem:</strong>
                    <input type="file" name="image" class="form-control" placeholder="imagem">
                    <img src="/images/{{ $product->image }}" width="100px">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>

    </form>
@endsection
