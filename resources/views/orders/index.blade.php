@extends('layouts.app')

@section('content')
<div class="title-block">
    <h3 class="title float-left"> Ordenes </h3>
    <a class="float-right btn btn-primary" href="{{ route('orders.create') }}">
        <i class="fa fa-plus"></i> Orden
    </a>
</div>
<section class="section">
    <div class="row justify-content-center sameheight-container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('orders.index') }}" method="GET" role="search">
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
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('BillNumber') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('ProductsCount') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $item)
                                <tr>
                                    <td scope="row">{{ $item->id }}</td>
                                    <td>{{ $item->created_at->toFormattedDateString() }}</td>
                                    <td>{{ $item->bill_number }}</td>
                                    <td> {{ number_format($item->total, 0) }} </td>
                                    <td> {{ number_format(count($item->orderDetails), 0) }} </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('orders.show', $item->id) }}" class='btn btn-info' type="submit">
                                            <i class="fa fa-eye"></i> {{ __('ButtonShow') }}
                                        </a>
                                        <a href="{{ route('orders.edit', $item->id) }}" class='btn btn-warning' type="submit">
                                            <i class="fa fa-pencil"></i> {{ __('ButtonEdit') }}
                                        </a>
                                        <a class="deleteItem btn btn-danger"
                                                data-id="{{ $item->id }}"
                                                data-url="orders/"
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
@endsection
