<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::latest()->paginate(4);//latest() serve para ordenar os registros em ordem decrescente paginate(5) é aplicado para dividir os resultados em conjuntos de 5 registros por página
        return view('index', compact('products'))->with('i',(request()->input('page', 1) -1) *5);
        //request() = requisicão http recebida pelo cliente
    }

    public function create()
    {
        return view('create');
    }

    public function store(ProductFormRequest $request)
    {

        $validatedData = $request->validated();
        $products = new Product;

        $products->name = $validatedData['name'];
        $products->detail = $validatedData['detail'];

        $products->save();

        // upload do arquivo
        if($request->hasFile('image'))
        {  // se tiver uma img ele retorna booleano
            $uploadImages = 'images';

            $i = 1;
            foreach($request->file('image') as $images){                           //pega a img no campo
                $ext = $images->getClientOriginalExtension();                     //pega o arquivo original
                $filename = time() .$i++ .'.'. $ext;                         //gera o nome unico
                $images->move($uploadImages , $filename);                       // mover o diretorio
                $imagePath = $uploadImages.$filename;                          //guarda um array de img com a chave 'image' e validando

                $products->productImage()->create([
                    'product_id' => $products->id,
                    'image' => $imagePath

                ]);
            }
        }

        return redirect('/')->with('success', 'Produto criado com sucesso.');//redirecionando para a route('index') e retornado uma msg de prod criado
    }

    public function show(Product $product)
    {
        return view('show', compact('product'));                          // visualiza a pag show e com os dados savo na tabela $product
    }

    public function edit(Product $product)
    {
        return view('edit',compact('product'));                            // visualiza a pag edit e com os dados savo na tabela $product
    }

    public function update(ProductFormRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        // upload do arquivo
        if($request->hasFile('image')){                                             // se tiver uma img ele retorna booleano
            $destination = $product->image;                                        //pega image da models Product que esta ligada com o BD
            if(File::exists($destination)){                                       //verifica se existe uma img em um local específico
                File::delete($destination);                                      //deleta a img do local em específico
            }

            $file = $request->file('image');                                    //pega a img no campo
            $ext = $file->getClientOriginalExtension();                        //pega o arquivo original
            $filename = time() .'.'. $ext;                                    //gera o nome unico
            $file->move('images/', $filename);                               // mover o diretorio
            $validatedData['image'] = $filename;                            //guarda um array de img com a chave 'image' e validando

        }
        $product->update($validatedData);                                // atualizar o bd
        return redirect('/')->with('success','Produto atualizado com sucesso');//redirecionar e retornar um msg
    }

    public function destroy(Product $product)
    {
        if($product->count() > 0){
        $destination = $product->image;                                      //pega image da models Product que esta ligada com o BD
            if(File::exists($destination)){                                 //verifica se existe uma img em um local específico
                File::delete($destination);
            }
        $product->delete(); //apaga os dados do bd
        return redirect()->route('index')->with('success', 'Produto apagado com sucesso.');         //redirecionar e retornar um msg
        }

        return redirect()->route('index')->with('message', 'Algo deu Errado.');                   //redirecionar e retornar um msg de erro
    }
}
