<?php

namespace App\Http\Controllers;

use App\Models\Product_categorie;
use Illuminate\Http\Request;

class ProductCategorieController extends Controller
{
    public function index()
    {
        return view('productcategories.index',[
            'productcat' => Product_categorie::all()
        ]);
    }

    public function create()
    {
        return view('productcategories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'cycle' => 'required',
            'visit' => 'required',
        ]);

        $productcat = new Product_categorie();
        $productcat->category_name = $request->category_name;
        $productcat->cycle = $request->cycle;
        $productcat->visit = $request->visit;
        $productcat->save();

        return redirect()->route('productcategories.index')->with('success', 'productcat created successfully.');
    }

<<<<<<< HEAD
=======
   
>>>>>>> 3f1ebcbe8f0b41244807d3af2deadef49167a6ed
    public function edit(Product_categorie $product_categorie, $id)
    {
        $productcat = Product_categorie::findOrFail($id);
        return view('productcategories.edit', compact('productcat'));
    }

<<<<<<< HEAD
    public function update(Request $request, $id, Product_categorie $product_categorie)
=======
    public function update(Request $request,$id, Product_categorie $product_categorie)
>>>>>>> 3f1ebcbe8f0b41244807d3af2deadef49167a6ed
    {
        $request->validate([
            'category_name' => 'required',
            'cycle' => 'required',
            'visit' => 'required',
        ]);

        $productcat = Product_categorie::findOrFail($id);
        $productcat->category_name = $request->category_name;
        $productcat->cycle = $request->cycle;
        $productcat->visit = $request->visit;
        $productcat->save();

        return redirect()->route('productcategories.index')->with('success', 'productcat created successfully.');
    }

    public function destroy(Product_categorie $product_categorie, $id)
    {
        $productcat = product_categorie::findOrFail($id);
        $productcat->delete();
        return redirect()->route('productcategories.index')->with('success', 'productcategories berhasil dihapus.');
    }

    public function member()
    {
        $members = Member::with('customer', 'product_categorie')->get();
        return view('membercash.membercashier', 'member.index', compact('members'));
    }
}
