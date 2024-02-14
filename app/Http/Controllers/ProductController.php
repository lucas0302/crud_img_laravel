<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(4);//latest() serve para ordenar os registros em ordem decrescente paginate(5) é aplicado para dividir os resultados em conjuntos de 5 registros por página
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

    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();
        $uploadImages = 'images/';

        $products = new Product;

        $products->name = $validatedData['name'];
        $products->detail = $validatedData['detail'];

        // upload do arquivo
        if($request->hasFile('image')){                                  // se tiver uma img ele retorna booleano

            $count = 1;
            foreach($request->file('image') as $requestImg){                       //pega a img no campo
                $ext = $requestImg->getClientOriginalExtension();                //pega o arquivo original
                $filename = time() .$count++ .'.'. $ext;                            //gera o nome unico
                $requestImg->move($uploadImages , $filename);                       // mover o diretorio
                $requestImg2 = $uploadImages . $filename;                    //guarda um array de img com a chave 'image' e validando

                $product->productImage()->create([
                    'product_id' => $product->id,
                    'image_path' =>$requestiImg2
                ]);

            }
        }
        // try {
             //$products
        // } catch (Exception $teste) {
             //
        // }

        return redirect('/')->with('success', 'Produto criado com sucesso.');   //redirecionando para a route('index') e retornado uma msg de prod criado
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
