<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product_categorie;
use App\Models\Customer;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
        {
            $members = Member::with('customer')->get();
            return view('member.index', compact('members'));
        }
        
        public function product_categorie()
        {
            return $this->belongsTo(Product_categorie::class, 'category_id');
        }

        public function customer()
        {
            return $this->belongsTo(Customer::class, 'user_id');
        }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }

}
