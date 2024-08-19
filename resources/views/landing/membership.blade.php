@extends('landing.master')
@include('landing.header')

<style>
    .iphone-SE {
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        width: 100%;
        height: 100vh;
        align-items: center;
    }

    .iphone-SE .div {
        background-color: #ffffff;
        width: 90%;
        max-width: 320px;
        height: auto;
        position: relative;
        padding: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .iphone-SE .group {
        width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    .iphone-SE .overlap-group {
        width: 100%;
        height: auto;
        border-radius: 10px;
        background: linear-gradient(180deg, rgb(0, 0, 0) 0.82%, rgb(53, 34, 0) 30.15%, rgb(104, 68, 0) 68.63%, rgb(132, 86, 0) 87.22%, rgb(195, 127, 0) 94.98%, rgb(255, 165, 0) 100%);
        padding: 20px;
        color: #ffffff;
    }
    .iphone-SE .logo-gym {
        width: 20%;
        max-width: 68px;
        height: auto;
        float: right;
    }

    .iphone-SE .text-wrapper,
    .iphone-SE .text-wrapper-2,
    .iphone-SE .text-wrapper-3,
    .iphone-SE .text-wrapper-4 {
        font-family: "Inria Sans-Bold", Helvetica;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 10px;
        font-size: 3vw;
        max-width: 100%;
        white-space: nowrap;
    }

    .iphone-SE .text-wrapper-3,
    .iphone-SE .text-wrapper-4 {
        font-size: 3vw;
    }

    .iphone-SE .overlap-wrapper {
        width: 100%;
        height: auto;
        text-align: center;
        margin-top: 30px;
    }

    .iphone-SE .overlap {
        display: inline-block;
        width: 70%;
        height: auto;
        padding: 10px 0;
        background-color: #ffffff;
        border-radius: 23px;
        border: 5px solid #000000;
        font-family: "Inria Sans-Bold", Helvetica;
        font-weight: 700;
        color: #000000;
        font-size: 6vw;
    }

    .iphone-SE .overlap-2 {
        position: absolute;
        width: 100%;
        height: 50px;
        top: 0;
        left: 0;
        background-color: #ffffff;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        text-align: right;
        padding: 15px 20px;
    }

    .iphone-SE .group-2 {
        position: absolute;
        width: 20px;
        height: 9px;
        top: 22px;
        left: 25px;
    }

    .iphone-SE .text-wrapper-6 {
        font-family: "Inria Sans-Bold", Helvetica;
        font-weight: 700;
        color: #0019ff;
        font-size: 14px;
    }

    @media (min-width: 768px) {
        .iphone-SE .div {
            max-width: 600px; /* Increase the width of the card on desktop */
            padding: 40px; /* Increase padding on desktop */
        }

        .iphone-SE .group {
            margin-bottom: 30px; /* Increase spacing at the bottom of the group */
        }

        .iphone-SE .overlap-group {
            padding: 30px; /* Increase padding within the group */
        }

        .iphone-SE .text-wrapper,
        .iphone-SE .text-wrapper-2,
        .iphone-SE .text-wrapper-3,
        .iphone-SE .text-wrapper-4 {
            font-size: 24px; /* Increase font size on desktop */
        }

        .iphone-SE .overlap {
            font-size: 20px; /* Adjust the font size of the button */
        }
    }
</style>

<div class="iphone-SE">
    <div class="div">
        <div class="group">
            <div class="overlap-group">
                <img class="logo-gym" src="../../assets/images/logo_gym.png" alt="Gym Logo" />
                @if ($member->status == 'inactive')
                
                <div class="text-wrapper">
                    NAME : 
                    <span title="{{ $member->customer->user->name }}">
                        {{ Str::limit($member->customer->user->name, 9, '...') }}
                    </span>
                </div>
                
                <div class="text-wrapper-2">MEMBER ID : {{ $member->id }}</div>
                <div class="text-wrapper-3" style="color: 
                {{ $member->status === 'active' ? 'green' : ($member->status === 'expired' ? 'red' : 'white') }}">
                {{ $member->status }}
                </div>

                @else
                <div class="text-wrapper" style="color: 
                    {{ $member->status === 'active' ? 'green' : ($member->status === 'expired' ? 'red' : 'white') }}">
                    {{ $member->status }}
                </div>
                <div class="text-wrapper-2">
                    NAME : 
                    <span title="{{ $member->customer->user->name }}">
                        {{ Str::limit($member->customer->user->name, 9, '...') }}
                    </span>
                </div>
                
                <div class="text-wrapper-3">MEMBER ID : {{ $member->id }}</div>
                <div class="text-wrapper-4">EXPIRED : {{ \Carbon\Carbon::parse($member->end_date)->translatedFormat('d/M/Y') }}</div>
                @endif
                
                
            </div>
        </div>
        @if ($member->status == 'active')
        <div class="overlap-wrapper">
            <div class="overlap">
                <div class="text-wrapper-6">
                    <button>GET IN</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
