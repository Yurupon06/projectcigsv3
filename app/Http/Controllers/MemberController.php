<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product_categorie;
use App\Models\Customer;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $members = Member::with('customer')->when($search, function ($query) use ($search) {
            $query->whereHas('customer.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
        });
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
        
        return view('member.index', compact('members'));
    }
}
