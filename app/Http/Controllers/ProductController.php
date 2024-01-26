<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(2);//latest() serve para ordenar os registros em ordem decrescente paginate(5) é aplicado para dividir os resultados em conjuntos de 5 registros por página
        return view('index', compact('products'))->with('i',(request()->input('page', 1) -1) *5);
        //request() = requisicão http recebida pelo cliente
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ // validaçao dos capos todos tem que ser obrigatorio
            'name' =>'required',
            'detail'=>'required',
            'image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',//o campo e do tipo img e os tipos de arquivos que o campo pode receber e o tamnho max da img.
        ]);

        // upload do arquivo
        $input = $request->all(); // pegando tudo do campo

        if($image = $request->file('image')){// Ele faz uma verificaçao usando o método $request->file('image'). Se um arquivo 'image' for encontrado na solicitação, ele entra no bloco if.
        $destinationPath = 'images/';// pasta de destino para onde a imagem será movida após o upload.
        $profileImage = date("YmdHis") . "." . $image->getClientOriginalExtension();//está sendo gerado um nome de arquivo único para img sendo concatenando a data e hora atual no formato "YmdHis" (ano, mês, dia, hora, minuto e segundo) com a extensão original do arquivo da imagem.
        $image->move($destinationPath, $profileImage);// Esta linha move o arquivo de imagem para o destino especificado "images/"
        $input['image'] = $profileImage;//att os dados de entrada (array associativo) para incluir o nome do arquivo da imagem que foi gerado.
        }

        Product::create($input); // iserção dos inputs na table Product do BD
        return redirect()->route('index')->with('success', 'Produto criado com sucesso.');//redirecionando para a route('index') e retornado uma msg de prod criado
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('show', compact('product'));// visualiza a pag show e com os dados savo na tabela $product
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('edit',compact('product'));// visualiza a pag edit e com os dados savo na tabela $product
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([ //faz a verificaçao se os campos tem algo
            'name' =>'required', // tem que tem argo no campo para continuar
            'detail'=>'required',
        ]);

        $input = $request->all(); // pega todos os dados do campo

        if($image = $request->file('image')){ //Ele faz uma verificaçao usando o método $request->file('image'). Se um arquivo 'image' for encontrado na solicitação, ele entra no bloco if.
            $destinationPath = 'images/';// destino que a img vai ser add
            $profileImage = date("YmdHis") . "." . $image->getClientOriginalExtension();//está sendo gerado um nome de arquivo único para img sendo concatenando a data e hora atual no formato "YmdHis" (ano, mês, dia, hora, minuto e segundo) com a extensão original do arquivo da imagem.
            $image->move($destinationPath, $profileImage);// Esta linha move o arquivo de imagem para o destino especificado "images/"
            $input['image'] = $profileImage;//att os dados de entrada (array associativo) para incluir o nome do arquivo da imagem que foi gerado.

            }
            $product->update($input); // att a tabela product no bd
            return redirect()->route('index')->with('success','Produto atualizado com sucesso');//redirecionar e retornar um msg
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete(); //apaga os dados do bd
        return redirect()->route('index')->with('success', 'Produto apagado com sucesso.');//redirecionar e retornar um msg
    }
}
