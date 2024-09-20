<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $product = Product::with(['productcat'])
            ->where(function($query) use ($search) {
                $query->whereHas('productcat', function($q) use ($search) {
                    $q->where('category_name', 'like', '%' . $search . '%');
                })
                ->orWhere('product_name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

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

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'product berhasil dihapus.');
    }
}
