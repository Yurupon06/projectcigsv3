<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product = Product::with('productcat')->get();

        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $productcat = Product_categorie::all();
        return view('product.create', compact('productcat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        
        $product = new product();
        $product->product_category_id = $request->product_category_id;
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
    
        return redirect()->route('product.index')->with('success', 'product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);
        $productcat = Product_categorie::all();
        return view('product.edit', compact('product', 'productcat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'product_category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        
        $product = product::findOrFail($id);
        $product->product_category_id = $request->product_category_id;
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
    
        return redirect()->route('product.index')->with('success', 'product created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        //
        $product = product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'product berhasil dihapus.');
    }
}
