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
                    <form id="form" method="post" class="needs-validation" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 col-offset-md-1">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="product_id">{{ __('Product') }}</label>
                                        <select class="form-control" name="product_id" id="product_id">
                                            <option value="">{{ __('SelectAny') }}</option>
                                            @foreach ($products as $item)
                                                <option value="{{ $item->id }}">{{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-tooltip" style="position: relative;">
                                        {{ __('Required') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="quantity">{{ __('Quantity') }}</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" required step="0.1" min="0" value="1">
                                    <div class="invalid-tooltip" style="position: relative;">
                                        {{ __('Required') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex">
                                <div class="form-group my-auto">
                                    <button type="button" id="add" class="btn btn-primary disabled">{{ __('ButtonAdd') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table id="myDatatable" class="tablecontainer table table-striped table-condensed table-hover table-bordered text-center" cellspacing="0" width="100%">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"> Total</td>
                                        <td class="text-right font-weight-bold" id="total"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="send" class="btn btn-primary disabled">{{ __('ButtonSave') }}</button>
                            <a id="back" href="{{ route('orders.index') }}" class="btn btn-dark">{{ __('ButtonBack') }}</a>
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
    var products = {!! $products !!};
    var details = [];
    var total = 0;

    $().ready(() => {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#product_id').change(() => {
            $('#product_id').val() > 0 ?  $('#add').removeClass('disabled') : $('#add').addClass('disabled');
        });

        $('#add').click(() => {
            addProduct($('#product_id').val(), $('#quantity').val());
            $('#quantity').val(1)
            $('#product_id').val('').change().focus();
        });

        $('#quantity').keydown(function(event){
            if(event.keyCode == 13) {
                $('#add').click();
            }
        });

        $('#form').submit((event) => {
            event.preventDefault();
            $.ajax({
                url: '/orders',
                method: 'POST',
                data: { details, total },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: (data) => {
                    if (data.status) {
                        swal("Ok", data.Message, "success");
                        setInterval(location.href='/orders', 2000);
                    } else {
                        swal("¡Error!", data.Message, "error");
                        setInterval(location.reload(), 2000);
                    }
                }
            });
        });

    });

    function deleteProduct(id) {
        details = details.filter(x => x.id != id);
        fillTable();
    }

    function addProduct(id, quantity) {
        if (id > 0) {
            quantity = parseInt(quantity);
            var product = products.find(x => x.id == id);
            var detailsExits = details.find(x => x.id == id);
            if(detailsExits) {
                detailsExits.quantity = detailsExits.quantity + quantity;
                detailsExits.total = quantity * detailsExits.price;

            } else {
                details.push({
                    id: product.id,
                    description: product.description,
                    quantity,
                    price: product.price,
                    total: quantity * product.price
                });
            }
            fillTable();
        }
    }

    function fillTable() {
        $('#myDatatable tbody').empty();
        $('#total').empty();
        var html = '';
        details.forEach(item => {
            html += `
            <tr>
                <td>${item.description}</td>
                <td>${item.quantity}</td>
                <td>${new Intl.NumberFormat().format(item.price)}</td>
                <td>${new Intl.NumberFormat().format(item.total)}</td>
                <td><button type="button" onclick="deleteProduct(${item.id})" class="btn btn-danger">{{ __('Remove') }}</button></td>
            </tr>`;
        });
        $('#myDatatable tbody').append(html);
        total = details.reduce((total, item) => total + (item.price * item.quantity), 0);
        $('#total').append(`${new Intl.NumberFormat().format(total)}`);
        details.length > 0 ? $('#send').removeClass('disabled') : $('#send').addClass('disabled');
    }
</script>
@endsection
