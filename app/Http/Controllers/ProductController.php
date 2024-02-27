<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\File;
use App\Models\ProductImage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();//latest() serve para ordenar os registros em ordem decrescente paginate(5) é aplicado para dividir os resultados em conjuntos de 5 registros por página
        return view('index', compact('products'));
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
            $uploadImages = 'images/';
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

        // Atualiza os dados do produto
        $product->name = $validatedData['name'];
        $product->detail = $validatedData['detail'];
        $product->save();

        // Trata o upload das novas imagens
        if ($request->hasFile('image')) {
            $uploadImagesDir = 'images/'; // Diretório de upload
            $i = 1;
            foreach ($request->file('image') as $image) {
                $ext = $image->getClientOriginalExtension(); // Pega a extensão do arquivo
                $filename = time() . $i++ . '.' . $ext; // Gera um nome único
                $image->move($uploadImagesDir, $filename); // Move para o diretório
                $imagePath = $uploadImagesDir.$filename;

                // Cria uma nova entrada para cada imagem
                $product->productImage()->create([
                    'product_id' => $product->id,
                    'image' => $imagePath
                ]);

            }
        }

        return redirect('/')->with('success', 'Produto atualizado com sucesso.');
    }

    public function deleteImage($imageId)
    {
        $image = ProductImage::findOrFail($imageId);// findOrFail para mostrar um erro 404
        if ($image) {
            $imagePath = $image->image;
            if (File::exists($imagePath)) {
                File::delete($imagePath); // Remove a imagem do disco
            }
            $image->delete();

            return back()->with('success', 'Imagem removida com sucesso.');
        }
        return back()->with('error', 'Imagem não encontrada.');
    }

    public function destroy(Product $product)
    {
        if ($product->productImage()->count() > 0) {
            foreach ($product->productImage as $image) {
                $imagePath = $image->image; // Constrói o caminho completo da imagem
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $image->delete(); // Exclui a imagem no bd
            }
        }
        $product->delete(); // exclui o produto

        return redirect()->route('index')->with('success', 'Produto apagado com sucesso.');
}
}
