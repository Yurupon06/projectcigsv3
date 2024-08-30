<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with('productcat')->get();
        return view('product.index', compact('product'));
    }

    public function create()
    {
        $productcat = Product_categorie::all();
        return view('product.create', compact('productcat'));
    }

    public function store(Request $request)
    {
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

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $productcat = Product_categorie::all();
        return view('product.edit', compact('product', 'productcat'));
    }

    public function update(Request $request,$id)
    {
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

<<<<<<< HEAD
=======

>>>>>>> 3f1ebcbe8f0b41244807d3af2deadef49167a6ed
    public function destroy(Product $product, $id)
    {
        $product = product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'product berhasil dihapus.');
    }
}
