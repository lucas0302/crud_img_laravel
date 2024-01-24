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
        $products = Product::latest()->paginate(5);

        return view('index', compact('products'))->with('i',(request()->input('page', 1) -1) *5);
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
        $request->validate([
            'name' =>'required',
            'detail'=>'required',
            'image'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // upload do arquivo
        $input = $request->all();

        if($image = $request->file('image')){
        $destinationPath = 'images/';
        $profileImage = date("YmdHis") . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $input['image'] = "$profileImage";
        }

        $product = Product::create($input);
        return redirect()->route('index')->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
