@extends('landing.master')
@section('main')
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

	<div class="animsition">

		<!-- Slider -->
		<section class="section-slide">
			<div class="wrap-slick1 rs1-slick1">
				<div class="slick1">
					<div class="item-slick1" style="background-image: url(../../assets/images/banner/banner.png);">
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
							<form action="{{ route('beforeorder.index') }}" method="GET">
								<input type="hidden" name="product_id" value="{{ $dt->id }}">
								<input type="hidden" name="product_name" value="{{ $dt->product_name }}">
								<input type="hidden" name="description" value="{{ $dt->description }}">
								<input type="hidden" name="price" value="{{ $dt->price }}">
								<button type="submit" class="boxed-btn3">Join Now</button>
							</form>
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
	</div>
@endsection
