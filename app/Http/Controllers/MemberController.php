<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product_categorie;
use App\Models\Customer;
use Illuminate\Http\Request;

class MemberController extends Controller
{
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

}
