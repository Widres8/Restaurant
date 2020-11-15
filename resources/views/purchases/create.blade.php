@extends('layouts.app')

@section('content')
<div class="title-block">
    <h3 class="title"> {{ __('Create') }} </h3>
</div>
<section class="section">
    <div class="row justify-content-center sameheight-container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                <form action="{{ route('purchases.store') }}" method="post" class="needs-validation" novalidate="novalidate">
                    @csrf
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <input type="text" name="price" id="price" class="form-control" required>
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comments">{{ __('Comments') }}</label>
                        <textarea class="form-control" name="comments" id="comments" cols="30" rows="5"></textarea>
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('ButtonSave') }}</button>
                        <a href="{{ route('purchases.index') }}" class="btn btn-dark">{{ __('ButtonBack') }}</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    $("textarea").tinymce({
        script_url: '/plugins/tinymce/tinymce.min.js',
        language: 'en',
        plugins: "lists",
        branding: false,
        toolbar: "numlist bullist alignleft aligncenter alignright",
    });
</script>
@endsection

