@extends('dashboard.master')

@section('title', 'Landing Setting')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection

@section('page-title', 'Landing Setting')
@section('page', 'Landing Setting')

@section('main')
    @include('dashboard.main')

    <div class="container-fluid pb-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header py-2">
                        <h5 class="text-center font-weight-bold">Landing Setting</h5>
                    </div>
                    <div class="card-body p-2">
                        @if ($setting)
                            <form action="{{ route('application-setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="banner_text" class="form-label">Banner Text</label>
                                    <input type="text" class="form-control @error('banner_text') is-invalid @enderror" id="banner_text" name="banner_text" value="{{ old('banner_text', $setting->banner_text) }}">
                                    @error('banner_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text', $setting->button_text) }}">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="about_us_text" class="form-label">About Us Text</label>
                                    <textarea name="about_us_text" id="about_us_text" class="form-control @error('about_us_text') is-invalid @enderror" rows="3">{{ old('about_us_text', $setting->about_us_text) }}</textarea>
                                    @error('about_us_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="product_images" class="form-label">Product Images (3)</label>
                                    <input type="file" class="form-control @error('product_images.*') is-invalid @enderror" id="product_images" name="product_images[]" multiple>
                                    @error('product_images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="product_descriptions" class="form-label">Product Descriptions</label>
                                    <textarea name="product_descriptions" id="product_descriptions" class="form-control @error('product_descriptions') is-invalid @enderror" rows="3">{{ old('product_descriptions', $setting->product_descriptions) }}</textarea>
                                    @error('product_descriptions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mb-3">Update</button>
                            </form>
                        @else
                            <p class="mb-3">No settings available. Please add settings first.</p>
                            <form action="{{ route('application-setting.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Similar input fields as above for creating new settings -->
                                <!-- ... -->
                                <button type="submit" class="btn btn-primary mb-3">Create</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('setting-script')
    <script>
        @if (Session::has('success'))
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ Session::get('success') }}',
                })
            }
        @endif
    </script>
    @endsection
@endsection
