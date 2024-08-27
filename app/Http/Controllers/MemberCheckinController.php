<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MemberCheckin;
use App\Models\Product_categorie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberCheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
        {
            $membercheckin = MemberCheckin::with('members')->get();
            return view('cashier.membercheckin', compact('membercheckin'));
        }
        
        public function members()
        {
            return $this->belongsTo(Member::class, 'member_id');
        }


        public function customer()
        {
            return $this->belongsTo(Customer::class, 'user_id');
        }

        public function qrcheckin($qr_token)
        {
            $qr_token = $request->input('qr_token');
            $checkin = MemberCekin::where('qr_token', $qr_token)->first();
        
            if ($checkin && $checkin->status === 'use') {
                $checkin->status = 'used';
                $checkin->save();
    
                return redirect()->route('cashier.membercheckin')->with('success', 'Check-in successful.');
            }
    
            return redirect()->route('cashier.membercheckin')->with('error', 'QR Code is invalid or has already been used.');
        }

        public function qrcheck($qr_token)
        {
            $member = MemberCheckin::where('qr_token', $qr_token)->first();
        
            if (!$membercheckin) {
                return redirect()->route('cashier.membercheckin')->with('error', 'Member not found');
            }
        
            return view('cashier.show', compact('membercheckin'));
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
        public function show(MemberCheckin $member)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(MemberCheckin $member)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, MemberCheckin $member)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(MemberCheckin $member)
        {
            //
        }

    }
