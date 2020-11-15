@extends('layouts.app')

@section('content')
<div class="title-block">
    <h3 class="title float-left"> Categorias </h3>
    <a class="float-right btn btn-primary" href="{{ route('categories.create') }}">
        <i class="fa fa-plus"></i> Categoria
    </a>
</div>
<section class="section">
    <div class="row justify-content-center sameheight-container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categories.index') }}" method="GET" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control col-6 mr-2" name="querysearch" value="{{ $query }}" placeholder="Search">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="myDatatable" class="tablecontainer table table-striped table-condensed table-hover table-bordered text-center" cellspacing="0" width="100%">
                            <thead class="thead-primary">
                                <tr>
                                    <th width="10px">Id</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('ProductsCount') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $item)
                                <tr>
                                    <form action="{{ route('categories.update', $item->id) }}" method="POST" class="needs-validation" novalidate="novalidate">
                                        @csrf
                                        @method('PUT')
                                    <td scope="row">{{ $item->id }}</td>
                                    <td>
                                        <span style="display:none;">{{ $item->description }}</span>
                                        <input class="form-control" type="text" name="description" id="description{{ $item->id }}" value="{{ $item->description }}">
                                    </td>
                                    <td>{{ count($item->products) }}</td>
                                    <td style="text-align: center;">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button class='btn btn-warning' type="submit">
                                                    <i class="fa fa-save"></i> {{ __('ButtonSave') }}
                                            </button>
                                        </form>
                                            <a class="deleteItem btn btn-danger"
                                                    data-id="{{ $item->id }}"
                                                    data-url="categories/"
                                                    style="color: #fff;">
                                                <i class="fa fa-trash"></i> {{ __('ButtonDelete') }}
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $list->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/delete-active-table.js') }}"></script>
@endsection
