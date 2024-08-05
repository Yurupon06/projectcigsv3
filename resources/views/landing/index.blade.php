
@extends('landing.master')
@include('landing.header')

<style>
	.boxed-btn3 {
		display: inline-block;
		padding: 10px 20px;
		background-color: #842cff;
		color: #fff;
		border-radius: 5px;
		text-decoration: none;
	}
	.boxed-btn3:hover {
		background-color: #842cff;
	}
	html {
		scroll-behavior: smooth;
	}
	
</style>
<body class="animsition">




	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1 rs1-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: url(../../assets/images/banner/banner.png);">
					{{-- <div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30">
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="0">
								<a href="{{ route('register') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Join Now
								</a>
							</div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</section>



	<!-- Product -->
	<div id="product-section" class="container mt-5">
		<div class="d-flex justify-content-center flex-wrap">
			@foreach ($products as $dt)
			<div class="col-lg-4 col-md-6 mb-4">
				
				<div class="card text-center mx-auto">
					<div class="card-header">
						<h3>{{$dt->product_name}}</h3>
						<span>Rp.{{$dt->price}}</span>
					</div>
					<div class="card-body">
						<ul>
							<li>{{$dt->description}}</li>
						</ul>
					</div>
					<div class="card-footer">
						<a href="#" class="boxed-btn3">Join Now</a>
					</div>
				</div>
				
			</div>
			@endforeach
		</div>
	</div>



	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

