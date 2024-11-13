<?php

namespace App\Http\Controllers;

use App\Models\Product_categorie;
use App\Models\Member;
use Illuminate\Http\Request;

class ProductCategorieController extends Controller
{
    public function index(Request $request)
    { 
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $productcat = Product_categorie::where(function($query) use ($search) {
            $query->where('category_name', 'like', '%' . $search . '%')
                ->orWhere('cycle', 'like', '%' . $search . '%')
                ->orWhere('visit', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
        return view('Productcategories.index', compact('productcat'));
    }

    public function create()
    {
        return view('Productcategories.create');
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

        return redirect()->route('Productcategories.index')->with('success', 'productcat created successfully.');
    }

    public function edit(Product_categorie $product_categorie, $id)
    {
        $productcat = Product_categorie::findOrFail($id);
        return view('Productcategories.edit', compact('productcat'));
    }

    public function update(Request $request, $id, Product_categorie $product_categorie)
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

        return redirect()->route('Productcategories.index')->with('success', 'productcat created successfully.');
    }

    public function destroy(Product_categorie $product_categorie, $id)
    {
        $productcat = product_categorie::findOrFail($id);
        $productcat->delete();
        return redirect()->route('Productcategories.index')->with('success', 'productcategories berhasil dihapus.');
    }

    public function member()
    {
        $members = Member::with('customer', 'product_categorie')->get();
        return view('membercash.membercashier', 'member.index', compact('members'));
    }
}
