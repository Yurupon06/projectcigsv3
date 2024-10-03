@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Complement' : 'Complement')
@section('main')
<style>
		.container{
			padding-top: 100px;
		}
        .isotope-item {
            width: 50%; 
            padding-bottom: 20px;
        }

        .block2-pic {
            height: auto; 
        }

        .block2-txt-child1 {
            text-align: center;
        }

        .block2-btn {
            font-size: 12px;
            padding: 10px 15px;
        }

		@media only screen and (max-width: 768px) {
			.flex-w {
				flex-wrap: nowrap; 
				overflow-x: auto; 
			}

			.flex-w a {
				margin-right: 5px; /* Mengurangi jarak antar elemen */
				padding: 5px 5px;  /* Menyesuaikan padding untuk tampilan yang lebih kecil */
			}
		}
</style>
<body class="animsition">
	
	<div class="">
		<div class="container">
			<div class="">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <a href="{{ route('f&b.index') }}" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ !$category ? 'how-active1' : '' }}" data-filter="*">
                        All Complements
                    </a>
					<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="bi bi-funnel-fill"></i>
						</button>
						<ul class="dropdown-menu">
						<li>
							<a href="{{ route('f&b.index', ['category' => 'food']) }}" class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'food' ? 'how-active1' : '' }}" data-filter=".food">
								Food
							</a>
						</li>
						<li>
							<a href="{{ route('f&b.index', ['category' => 'drink']) }}" class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'drink' ? 'how-active1' : '' }}" data-filter=".drink">
								Drink
							</a>
						</li>
						<li>
							<a href="{{ route('f&b.index', ['category' => 'suplement']) }}" class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'suplement' ? 'how-active1' : '' }}" data-filter=".suplement">
								Suplement
							</a>
						</li>
						<li>
							<a href="{{ route('f&b.index', ['category' => 'other']) }}" class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'other' ? 'how-active1' : '' }}" data-filter=".other">
								Other
							</a>
						</li>
						</ul>
					  </div>
                    
                </div>
            </div>
            <div class="row">
                @forelse($complement as $dt)
                    <div class="col-6 mb-4">
                        <div>
                            <div class="block2-pic hov-img0">

                                <a href="{{ route('complement.detail', $dt->id) }}">
                                    <img src="storage/{{ $dt->image }}" alt="{{ $dt->name }}">
                                </a>
                            </div>
                            <div>
                                <div class="d-flex flex-column text-center">
                                    <a href="{{ route('complement.detail', $dt->id) }}" style="color:rgb(0, 0, 0);">
                                    <span>
                                        {{ $dt->name }}
                                    </span>
                                    </a>
                                    <span class="stext-105 cl3">
                                        Rp. {{ number_format($dt->price) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No Complement found.</p>
                @endforelse
            </div>
        </div>

        <!-- Back to top -->
        <div class="btn-back-to-top" id="myBtn">
            <span class="symbol-btn-back-to-top">
                <i class="zmdi zmdi-chevron-up"></i>
            </span>
        </div>

    </body>
@endsection