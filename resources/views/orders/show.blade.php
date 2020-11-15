@extends('layouts.app')

@section('content')
<a id="back" href="{{ route('orders.index') }}" class="btn btn-dark">{{ __('ButtonBack') }}</a>
    <div style="width: 800px;" class="container mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="container mx-auto">
            <div class="mt-0 mb-2">
                <table class="table" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td colspan="3" style="font-size:16px; text-align: right; color: #a7a7a7;"></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 20px;">
                                {{-- <div class="text-center">
                                    <img src="{{ asset('img/'.config('custom.logo_filename')) }}" alt="XEN" width="126px">
                                </div> --}}
                            </td>
                            <td class="text-left" style="vertical-align: baseline;">
                                <p style="font-size:18px;"><strong>{{ strtoupper('Orden de Compra') }}</strong></p>
                                <p style="font-size:14px;">{{ strtoupper(__('Date')) }}: {{ date_format($order->created_at, 'Y-m-d') }}</p>
                            </td>
                            <td class="text-right">
                                <p style="font-size:18px; margin-bottom: 15px;"><strong># : <span style="color: red;">{{ $order->bill_number }}</span></strong></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div style="width:100%; border-bottom: 1px solid black; margin-top: 15px; margin-bottom: 15px;">
        </div>
        <div class="container mx-auto">
            <div class="mb-5">
                <div class="pb-5">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="border text-sm font-semibold text-gray-700 p-2 bg-gray-200">#</th>
                                <th colspan="2" class="border text-sm font-semibold text-gray-700 p-2 bg-gray-200">{{ __('Description') }}</th>
                                <th class="border text-sm font-semibold text-gray-700 p-2 bg-gray-200">{{ __('Quantity') }}</th>
                                <th class="border text-sm font-semibold text-gray-700 p-2 bg-gray-200">{{ __('Price') }}</th>
                                <th class="border text-sm font-semibold text-gray-700 p-2 bg-gray-200">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody class="align-baseline">
                            <?php $i = 1; ?>
                            @foreach ($order->orderDetails as $item)
                                <tr>
                                    <td class="p-2 border border-gray-300 text-sm text-center">{{ $i }}</td>
                                    <td colspan="2" class="p-2 border border-gray-300 text-sm text-center">{{ $item->product->description }}</td>
                                    <td class="p-2 border border-gray-300 text-sm text-center">{{ $item->quantity }}</td>
                                    <td class="p-2 border border-gray-300 text-sm text-right">{{ number_format($item->price, 2) }}</td>
                                    <td class="p-2 border border-gray-300 text-sm text-right">{{ number_format($item->quantity * $item->price, 2)  }}</td>
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td class="border text-left text-sm font-semibold text-right" style="width: 150px">{{ __('Total') }}</td>
                                <td class="p-2 border border-gray-300 text-sm text-right">{{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
