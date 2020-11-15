@extends('layouts.app')

@section('content')
<div class="title-block">
    <h3 class="title float-left"> Purchases </h3>
    <a class="float-right btn btn-primary" href="{{ route('purchases.create') }}">
        <i class="fa fa-plus"></i> Purchase
    </a>
</div>
<section class="section">
    <div class="row justify-content-center sameheight-container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('purchases.index') }}" method="GET" role="search">
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
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Comments') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $item)
                                <tr>
                                    <td scope="row">{{ $item->id }}</td>
                                    <td>
                                        {!! html_entity_decode($item->description) !!}
                                    </td>
                                    <td> {{ number_format($item->price, 0) }} </td>
                                    <td>
                                        {!! html_entity_decode($item->comments) !!}
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('purchases.edit', $item->id) }}" class='btn btn-warning' type="submit">
                                            <i class="fa fa-pencil"></i> {{ __('ButtonEdit') }}
                                        </a>
                                        <a class="deleteItem btn btn-danger"
                                                data-id="{{ $item->id }}"
                                                data-url="purchases/"
                                                style="color: #fff;">
                                            <i class="fa fa-trash"></i> {{ __('ButtonDelete') }}
                                        </a>
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
<script>

</script>
@endsection
