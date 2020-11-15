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
                <form action="{{ route('categories.store') }}" method="post" class="needs-validation" novalidate="novalidate">
                    @csrf
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <input type="text" name="description" id="description" class="form-control" required>
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('ButtonSave') }}</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-dark">{{ __('ButtonBack') }}</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
