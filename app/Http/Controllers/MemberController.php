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
        $members = Member::with('customer')->orderBy('created_at', 'desc')->get();
        return view('member.index', compact('members'));
    }
}
