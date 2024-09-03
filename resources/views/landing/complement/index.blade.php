@extends('landing.master')
@section('main')
    @include('landing.header')
<style>
    /* Adjust grid items for smaller screens */
    @media (max-width: 576px) {
        .isotope-item {
            width: 50%; /* Two items side by side */
            padding-bottom: 20px; /* Space between items */
        }

        .block2-pic {
            height: auto; /* Auto height for images */
        }

        .block2-txt-child1 {
            text-align: center; /* Center text for smaller screens */
        }

        .block2-btn {
            font-size: 12px; /* Adjust button text size */
            padding: 10px 15px;
        }
    }

    /* Adjust image sizes for different screen sizes */
    @media (max-width: 768px) {
        .block2-pic {
            width: 100%;
            height: auto;
        }
    }
</style>
<body class="animsition">
	
	<div class="bg0 m-t-23 p-b-140">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <a href="{{ route('f&b.index') }}" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ !$category ? 'how-active1' : '' }}" data-filter="*">
                        All Complements
                    </a>
                    <a href="{{ route('f&b.index', ['category' => 'food']) }}" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'food' ? 'how-active1' : '' }}" data-filter=".food">
                        Food
                    </a>
                    <a href="{{ route('f&b.index', ['category' => 'drink']) }}" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'drink' ? 'how-active1' : '' }}" data-filter=".drink">
                        Drink
                    </a>
                    <a href="{{ route('f&b.index', ['category' => 'suplement']) }}" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'suplement' ? 'how-active1' : '' }}" data-filter=".suplement">
                        Supplement
                    </a>
                </div>

			</div>
			<div class="bg0 m-t-23 p-b-140">
				<div class="container">
					<div class="row isotope-grid">
						@foreach($complement as $dt)
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">
							<div class="block2">
								<div class="block2-pic hov-img0" style="width: 15rem !important; height: 15rem;">
									<img style="width: 100%" src="storage/{{ $dt->image }}" alt="{{ $dt->name }}">
									<a href="{{route('f&b.detail', $dt->id)}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
										Quick View
									</a>
								</div>
								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l ">
										<a href="" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
											{{ $dt->name }}
										</a>
										<span class="stext-105 cl3">
												Rp. {{ number_format($dt->price) }}
										</span>
					
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
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

