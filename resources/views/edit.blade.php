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

    <form action="{{ route('update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                        placeholder="Nome">
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
                    <input type="file" name="image[]" class="form-control" multiple>
                    @error('image')
                        <small class="text-danger">{{ $message }}<br></small>
                    @enderror

                    @if ($message = Session::get('success'))
                        <div id="success-message" class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($product->productImage)
                        @foreach ($product->productImage as $item)
                            <div class="image-container" style="display: inline-block; position: relative;">
                                <img src="{{ asset($item->image) }}" width="100px">
                                <a href="{{ route('deleteImage', $item->id) }}" class="btn btn-danger"
                                    style="position: absolute; top: 0; right: 0; border-radius: 50%; width: 15px; height: 15px; display: flex; align-items: center; justify-content: center; font-size: 10px; padding: 0;"
                                    onclick="return confirm('Tem certeza que deseja apagar esta imagem?')">x</a>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>

    </form>

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
