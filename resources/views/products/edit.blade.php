@extends('layouts.app')

@section('content')
<div class="title-block">
    <h3 class="title"> {{ __('Edit') }} </h3>
</div>
<section class="section">
    <div class="row justify-content-center sameheight-container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                <form action="{{ route('products.update', $itemToEdit->id) }}" method="post" class="needs-validation" novalidate="novalidate">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class="form-group">
                          <label for="category_id">{{ __('Category') }}</label>
                          <select class="form-control" name="category_id" id="category_id">
                            <option value="">{{ __('SelectAny') }}</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ $item->id == $itemToEdit->category_id ? 'selected' : '' }}>{{ $item->description }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <input type="text" name="description" id="description" class="form-control" required value="{{ $itemToEdit->description }}">
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="measurenment_unit">{{ __('MeasurenmentUnit') }}</label>
                        <input type="text" name="measurenment_unit" id="measurenment_unit" class="form-control" required value="{{ $itemToEdit->measurenment_unit }}">
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <input type="text" name="price" id="price" class="form-control" required value="{{ $itemToEdit->price }}">
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock">{{ __('Stock') }}</label>
                        <input type="text" name="stock" id="stock" class="form-control" required value="{{ $itemToEdit->stock }}">
                        <div class="invalid-tooltip" style="position: relative;">
                            {{ __('Required') }}
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ __('ButtonSave') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-dark">{{ __('ButtonBack') }}</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
