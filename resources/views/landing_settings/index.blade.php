@extends('dashboard.master')

@section('title', 'Landing settings')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection

@section('page-title', 'Landing settings')
@section('page', 'Landing settings')

@section('main')
    @include('dashboard.main')

    <div class="container-fluid pb-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header py-2">
                        <h5 class="text-center font-weight-bold">Landing setting</h5>
                    </div>
                    <div class="card-body p-2">
                        @if ($landingSetting)
                            <form action="{{ route('landing-settings.update', $landingSetting->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Banner settings -->
                                <div class="mb-3">
                                    <label for="banner_image" class="form-label">Banner Image</label>
                                    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image">
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_h1_text" class="form-label">Banner H1 Text</label>
                                    <input type="text" class="form-control @error('banner_h1_text') is-invalid @enderror" id="banner_h1_text" name="banner_h1_text" value="{{ old('banner_h1_text', $landingSetting->banner_h1_text) }}">
                                    @error('banner_h1_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="banner_h1_color" class="form-label">H1 Paragraph Color</label>
                                    <input type="color" class="form-control @error('banner_h1_color') is-invalid @enderror" id="banner_h1_color" name="banner_h1_color" value="{{ old('banner_h1_color', $landingSetting->banner_h1_color) }}">
                                    @error('banner_h1_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_p_text" class="form-label">Banner Paragraph Text</label>
                                    <textarea name="banner_p_text" id="banner_p_text" class="form-control @error('banner_p_text') is-invalid @enderror" rows="3">{{ old('banner_p_text', $landingSetting->banner_p_text) }}</textarea>
                                    @error('banner_p_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="banner_p_color" class="form-label">Text Paragraph Color</label>
                                    <input type="color" class="form-control @error('banner_p_color') is-invalid @enderror" id="banner_p_color" name="banner_p_color" value="{{ old('banner_p_color', $landingSetting->button_p_color) }}">
                                    @error('banner_p_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_button_text" class="form-label">Banner Button Text</label>
                                    <input type="text" class="form-control @error('banner_button_text') is-invalid @enderror" id="banner_button_text" name="banner_button_text" value="{{ old('banner_button_text', $landingSetting->banner_button_text) }}">
                                    @error('banner_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_button_color" class="form-label">Banner Button Color</label>
                                    <input type="color" class="form-control @error('banner_button_color') is-invalid @enderror" id="banner_button_color" name="banner_button_color" value="{{ old('banner_button_color', $landingSetting->banner_button_color) }}">
                                    @error('banner_button_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_button_bg_color" class="form-label">Banner Button Bg Color</label>
                                    <input type="color" class="form-control @error('banner_button_bg_color') is-invalid @enderror" id="banner_button_bg_color" name="banner_button_bg_color" value="{{ old('banner_button_bg_color', $landingSetting->banner_button_bg_color) }}">
                                    @error('banner_button_bg_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- About Us Section -->
                                <div class="mb-3">
                                    <label for="about_us_text" class="form-label">About Us Text</label>
                                    <textarea name="about_us_text" id="about_us_text" class="form-control @error('about_us_text') is-invalid @enderror" rows="3">{{ old('about_us_text', $landingSetting->about_us_text) }}</textarea>
                                    @error('about_us_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="about_us_text_color" class="form-label">About Us Color</label>
                                    <input type="color" class="form-control @error('about_us_text_color') is-invalid @enderror" id="about_us_text_color" name="about_us_text_color" value="{{ old('about_us_text_color', $landingSetting->about_us_text_color) }}">
                                    @error('about_us_text_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Product Section -->
                                    <h5>Product</h5>

                                    <div class="mb-3">
                                        <label for="product_image_1" class="form-label">Product Image </label>
                                        <input type="file" class="form-control @error('product_image_1') is-invalid @enderror" id="product_image_1" name="product_image_1">
                                        @error('product_image_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_text_1" class="form-label">Product H1 Text </label>
                                        <input type="text" class="form-control @error('product_h1_text_1') is-invalid @enderror" id="product_h1_text_1" name="product_h1_text_1" value="{{ old('product_h1_text_1', $landingSetting->{'product_h1_text_1'}) }}">
                                        @error('product_h1_text_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_color_1" class="form-label">Product H1 Color</label>
                                        <input type="color" class="form-control @error('product_h1_color_1') is-invalid @enderror" id="product_h1_color_1" name="product_h1_color_1" value="{{ old('product_h1_color_1', $landingSetting->product_h1_color_1) }}">
                                        @error('product_h1_color_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_text_1" class="form-label">Product Paragraph Text </label>
                                        <textarea name="product_p_text_1" id="product_p_text_1" class="form-control @error('product_p_text_1') is-invalid @enderror" rows="3">{{ old('product_p_text_1', $landingSetting->{'product_p_text_1'}) }}</textarea>
                                        @error('product_p_text_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_color_1" class="form-label">Product Paragraph Color</label>
                                        <input type="color" class="form-control @error('product_p_color_1') is-invalid @enderror" id="product_p_color_1" name="product_p_color_1" value="{{ old('product_p_color_1', $landingSetting->product_p_color_1) }}">
                                        @error('product_p_color_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_1" class="form-label">Product Link </label>
                                        <input type="text" class="form-control @error('product_link_1') is-invalid @enderror" id="product_link_1" name="product_link_1" value="{{ old('product_link_1', $landingSetting->{'product_link_1'}) }}">
                                        @error('product_link_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_color_1" class="form-label">Product Link Color</label>
                                        <input type="color" class="form-control @error('product_link_color_1') is-invalid @enderror" id="product_link_color_1" name="product_link_color_1" value="{{ old('product_link_color_1', $landingSetting->product_link_color_1) }}">
                                        @error('product_link_color_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <!-- 2 -->
                                    <div class="mb-3">
                                        <label for="product_image_2" class="form-label">Product Image </label>
                                        <input type="file" class="form-control @error('product_image_2') is-invalid @enderror" id="product_image_2" name="product_image_2">
                                        @error('product_image_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_text_2" class="form-label">Product H1 Text </label>
                                        <input type="text" class="form-control @error('product_h1_text_2') is-invalid @enderror" id="product_h1_text_2" name="product_h1_text_2" value="{{ old('product_h1_text_2', $landingSetting->{'product_h1_text_2'}) }}">
                                        @error('product_h1_text_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_color_2" class="form-label">Product H1 Color</label>
                                        <input type="color" class="form-control @error('product_h1_color_2') is-invalid @enderror" id="product_h1_color_2" name="product_h1_color_2" value="{{ old('product_h1_color_2', $landingSetting->product_h1_color_2) }}">
                                        @error('product_h1_color_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_text_2" class="form-label">Product Paragraph Text </label>
                                        <textarea name="product_p_text" id="product_p_text_2" class="form-control @error('product_p_text_2') is-invalid @enderror" rows="3">{{ old('product_p_text_2', $landingSetting->{'product_p_text_2'}) }}</textarea>
                                        @error('product_p_text_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_color_2" class="form-label">Product Paragraph Color</label>
                                        <input type="color" class="form-control @error('product_p_color_2') is-invalid @enderror" id="product_p_color_2" name="product_p_color_2" value="{{ old('product_p_color_2', $landingSetting->product_p_color_2) }}">
                                        @error('product_p_color_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_2" class="form-label">Product Link </label>
                                        <input type="text" class="form-control @error('product_link_2') is-invalid @enderror" id="product_link_2" name="product_link_2" value="{{ old('product_link_2', $landingSetting->{'product_link_2'}) }}">
                                        @error('product_link_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="product_link_color_2" class="form-label">Product Link Color</label>
                                        <input type="color" class="form-control @error('product_link_color_2') is-invalid @enderror" id="product_link_color_2" name="product_link_color_2" value="{{ old('product_link_color_2', $landingSetting->product_link_color_2) }}">
                                        @error('product_link_color_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <!-- 3 -->
                                    <div class="mb-3">
                                        <label for="product_image_3" class="form-label">Product Image </label>
                                        <input type="file" class="form-control @error('product_image_3') is-invalid @enderror" id="product_image_3" name="product_image_3">
                                        @error('product_image_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_text_3" class="form-label">Product H1 Text </label>
                                        <input type="text" class="form-control @error('product_h1_text_3') is-invalid @enderror" id="product_h1_text_3" name="product_h1_text_3" value="{{ old('product_h1_text_3', $landingSetting->{'product_h1_text_3'}) }}">
                                        @error('product_h1_text_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_color_3" class="form-label">Product H1 Color</label>
                                        <input type="color" class="form-control @error('product_h1_color_3') is-invalid @enderror" id="product_h1_color_3" name="product_h1_color_3" value="{{ old('product_h1_color_3', $landingSetting->product_h1_color_) }}">
                                        @error('product_h1_color_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_text_3" class="form-label">Product Paragraph Text </label>
                                        <textarea name="product_p_text_3" id="product_p_text_3" class="form-control @error('product_p_text_3') is-invalid @enderror" rows="3">{{ old('product_p_text_3', $landingSetting->{'product_p_text_3'}) }}</textarea>
                                        @error('product_p_text_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_color_3" class="form-label">Product Paragraph Color</label>
                                        <input type="color" class="form-control @error('product_p_color_3') is-invalid @enderror" id="product_p_color_3" name="product_p_color_3" value="{{ old('product_p_color_3', $landingSetting->product_p_color_3) }}">
                                        @error('product_p_color_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_3" class="form-label">Product Link </label>
                                        <input type="text" class="form-control @error('product_link_3') is-invalid @enderror" id="product_link_3" name="product_link_3" value="{{ old('product_link_3', $landingSetting->{'product_link_3'}) }}">
                                        @error('product_link_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_color_3" class="form-label">Product Link Color</label>
                                        <input type="color" class="form-control @error('product_link_color_3') is-invalid @enderror" id="product_link_color_3" name="product_link_color_3" value="{{ old('product_link_color_3', $landingSetting->product_link_color_3) }}">
                                        @error('product_link_color_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                <!-- Footer settings -->
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $landingSetting->phone_number) }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $landingSetting->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook', $landingSetting->facebook) }}">
                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter" name="twitter" value="{{ old('twitter', $landingSetting->twitter) }}">
                                    @error('twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram', $landingSetting->instagram) }}">
                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mb-3">Update</button>
                            </form>
                        @else
                            <p class="mb-3">No settings available. Please add settings first.</p>
                            <form action="{{ route('landing-settings.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="banner_image" class="form-label">Banner Image</label>
                                    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" id="banner_image" name="banner_image">
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_h1_text" class="form-label">Banner H1 Text</label>

                                    <input type="text" class="form-control @error('banner_h1_text') is-invalid @enderror" id="banner_h1_text" name="banner_h1_text">

                                    @error('banner_h1_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="banner_h1_color" class="form-label">H1 Paragraph Color</label>

                                    <input type="color" class="form-control @error('banner_h1_color') is-invalid @enderror" id="banner_h1_color" name="banner_h1_color">

                                    @error('banner_h1_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_p_text" class="form-label">Banner Paragraph Text</label>

                                    <textarea name="banner_p_text" id="banner_p_text" class="form-control @error('banner_p_text') is-invalid @enderror" rows="3"></textarea>

                                    @error('banner_p_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="banner_p_color" class="form-label">Text Paragraph Color</label>

                                    <input type="color" class="form-control @error('banner_p_color') is-invalid @enderror" id="banner_p_color" name="banner_p_color">

                                    @error('banner_p_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_button_text" class="form-label">Banner Button Text</label>

                                    <input type="text" class="form-control @error('banner_button_text') is-invalid @enderror" id="banner_button_text" name="banner_button_text">

                                    @error('banner_button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_button_color" class="form-label">Banner Button Color</label>

                                    <input type="color" class="form-control @error('banner_button_color') is-invalid @enderror" id="banner_button_color" name="banner_button_color">

                                    @error('banner_button_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="banner_button_bg_color" class="form-label">Banner Button Bg Color</label>

                                    <input type="color" class="form-control @error('banner_button_bg_color') is-invalid @enderror" id="banner_button_bg_color" name="banner_button_bg_color">

                                    @error('banner_button_bg_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- About Us Section -->
                                <div class="mb-3">
                                    <label for="about_us_text" class="form-label">About Us Text</label>

                                    <textarea name="about_us_text" id="about_us_text" class="form-control @error('about_us_text') is-invalid @enderror" rows="3"></textarea>

                                    @error('about_us_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="about_us_text_color" class="form-label">About Us Color</label>

                                    <input type="color" class="form-control @error('about_us_text_color') is-invalid @enderror" id="about_us_text_color" name="about_us_text_color">

                                    @error('about_us_text_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Product Section -->
                                    <h5>Product</h5>

                                    <div class="mb-3">
                                        <label for="product_image_1" class="form-label">Product Image </label>
                                        <input type="file" class="form-control @error('product_image_1') is-invalid @enderror" id="product_image_1" name="product_image_1">
                                        @error('product_image_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_text_1" class="form-label">Product H1 Text </label>

                                        <input type="text" class="form-control @error('product_h1_text_1') is-invalid @enderror" id="product_h1_text_1" name="product_h1_text_1">

                                        @error('product_h1_text_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_color_1" class="form-label">Product H1 Color</label>

                                        <input type="color" class="form-control @error('product_h1_color_1') is-invalid @enderror" id="product_h1_color_1" name="product_h1_color_1">

                                        @error('product_h1_color_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_text_1" class="form-label">Product Paragraph Text </label>

                                        <textarea name="product_p_text_1" id="product_p_text_1" class="form-control @error('product_p_text_1') is-invalid @enderror" rows="3"></textarea>

                                        @error('product_p_text_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_color_1" class="form-label">Product Paragraph Color</label>

                                        <input type="color" class="form-control @error('product_p_color_1') is-invalid @enderror" id="product_p_color_1" name="product_p_color_1">

                                        @error('product_p_color_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_1" class="form-label">Product Link </label>

                                        <input type="text" class="form-control @error('product_link_1') is-invalid @enderror" id="product_link_1" name="product_link_1">

                                        @error('product_link_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_color_1" class="form-label">Product Link Color</label>

                                        <input type="color" class="form-control @error('product_link_color_1') is-invalid @enderror" id="product_link_color_1" name="product_link_color_1">

                                        @error('product_link_color_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <!-- 2 -->
                                    <div class="mb-3">
                                        <label for="product_image_2" class="form-label">Product Image </label>
                                        <input type="file" class="form-control @error('product_image_2') is-invalid @enderror" id="product_image_2" name="product_image_2">
                                        @error('product_image_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_text_2" class="form-label">Product H1 Text </label>

                                        <input type="text" class="form-control @error('product_h1_text_2') is-invalid @enderror" id="product_h1_text_2" name="product_h1_text_2" >

                                        @error('product_h1_text_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_color_2" class="form-label">Product H1 Color</label>

                                        <input type="color" class="form-control @error('product_h1_color_2') is-invalid @enderror" id="product_h1_color_2" name="product_h1_color_2">

                                        @error('product_h1_color_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_text_2" class="form-label">Product Paragraph Text </label>

                                        <textarea name="product_p_text" id="product_p_text_2" class="form-control @error('product_p_text_2') is-invalid @enderror" rows="3"></textarea>

                                        @error('product_p_text_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_color_2" class="form-label">Product Paragraph Color</label>

                                        <input type="color" class="form-control @error('product_p_color_2') is-invalid @enderror" id="product_p_color_2" name="product_p_color_2">

                                        @error('product_p_color_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_2" class="form-label">Product Link </label>

                                        <input type="text" class="form-control @error('product_link_2') is-invalid @enderror" id="product_link_2" name="product_link_2" >

                                        @error('product_link_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="product_link_color_2" class="form-label">Product Link Color</label>
                                        <input type="color" class="form-control @error('product_link_color_2') is-invalid @enderror" id="product_link_color_2" name="product_link_color_2" value="{{ old('product_link_color_2', $landingSetting->product_link_color_2) }}">
                                        @error('product_link_color_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                
                                    <!-- 3 -->
                                    <div class="mb-3">
                                        <label for="product_image_3" class="form-label">Product Image </label>
                                        <input type="file" class="form-control @error('product_image_3') is-invalid @enderror" id="product_image_3" name="product_image_3">
                                        @error('product_image_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_text_3" class="form-label">Product H1 Text </label>

                                        <input type="text" class="form-control @error('product_h1_text_3') is-invalid @enderror" id="product_h1_text_3" name="product_h1_text_3">

                                        @error('product_h1_text_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_h1_color_3" class="form-label">Product H1 Color</label>

                                        <input type="color" class="form-control @error('product_h1_color_3') is-invalid @enderror" id="product_h1_color_3" name="product_h1_color_3">

                                        @error('product_h1_color_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_text_3" class="form-label">Product Paragraph Text </label>

                                        <textarea name="product_p_text_3" id="product_p_text_3" class="form-control @error('product_p_text_3') is-invalid @enderror" rows="3"></textarea>

                                        @error('product_p_text_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_p_color_3" class="form-label">Product Paragraph Color</label>

                                        <input type="color" class="form-control @error('product_p_color_3') is-invalid @enderror" id="product_p_color_3" name="product_p_color_3" >

                                        @error('product_p_color_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="product_link_3" class="form-label">Product Link </label>

                                        <input type="text" class="form-control @error('product_link_3') is-invalid @enderror" id="product_link_3" name="product_link_3">

                                        @error('product_link_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="product_link_color_3" class="form-label">Product Link Color</label>
                                        <input type="color" class="form-control @error('product_link_color_3') is-invalid @enderror" id="product_link_color_3" name="product_link_color_3" value="{{ old('product_link_color_3', $landingSetting->product_link_color_3) }}">
                                        @error('product_link_color_3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                <!-- Footer settings -->
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>

                                    <input type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number">

                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>

                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" >

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>

                                    <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook">

                                    @error('facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>

                                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitter" name="twitter" >

                                    @error('twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>

                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram">

                                    @error('instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mb-3">Create</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('setting-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ Session::get('success') }}',
            })
        @endif
    </script>
    @endsection
@endsection
