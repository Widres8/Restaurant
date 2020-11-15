@extends('layouts.app')

@section('content')
<style>
    .card-stats{
        border-radius: 12px;
        box-shadow: 0 6px 10px -4px rgba(128,128,128,.8) !important;
        background-color: rgba(128,128,128,.2);
        color: #252422;
        margin-bottom: 20px;
        position: relative;
        border: 0 none;
        transition: transform 300ms cubic-bezier(0.34, 2, 0.6, 1), box-shadow 200ms ease;
    }
    .card-stats .card-body {
        padding: 15px 15px 0px;
    }
    .card-stats .card-body .numbers {
        text-align: right;
        font-size: 1.2em;
    }
</style>
<div class="title-block">
    <h3 class="title float-left"> <strong>Dashboard</strong></h3>
</div>
<section class="section">
    <div class="row justify-content-center sameheight-container">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-3 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-3">
                                            <div class="text-center text-success">
                                                <i class="far fa-money-bill-alt fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-9">
                                            <div class="numbers">
                                                <p class="card-category">Total Sales</p>
                                                <p class="card-title text-success">
                                                    $ {{ number_format($data['totalsales'], 2) }}
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-3">
                                            <div class="text-center text-danger">
                                                <i class="far fa-money-bill-alt fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-9">
                                            <div class="numbers">
                                                <p class="card-category">Total Sales by Year {{ \Carbon\Carbon::now()->year }}</p>
                                                <p class="card-title text-danger">
                                                    $ {{ number_format($data['totalsalesyear'], 2) }}
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-3">
                                            <div class="text-center text-danger">
                                                <i class="far fa-money-bill-alt fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-9">
                                            <div class="numbers">
                                                <p class="card-category">Total Sales {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                                                <p class="card-title text-danger">
                                                    $ {{ number_format($data['totalsalesday'], 2) }}
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-3">
                                            <div class="text-center text-info">
                                                <i class="far fa-money-bill-alt fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-9">
                                            <div class="numbers">
                                                <p class="card-category">Total Purchases</p>
                                                <p class="card-title text-info">
                                                    $ {{ number_format($data['totalpurchases'], 2) }}
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-3">
                                            <div class="text-center text-secondary">
                                                <i class="far fa-money-bill-alt fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-9">
                                            <div class="numbers">
                                                <p class="card-category">Total Purchases by Year {{ \Carbon\Carbon::now()->year }}</p>
                                                <p class="card-title text-secondary">
                                                    $ {{ number_format($data['totalpurchasesyear'], 2) }}
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-5 col-md-3">
                                            <div class="text-center text-secondary">
                                                <i class="far fa-money-bill-alt fa-3x"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-9">
                                            <div class="numbers">
                                                <p class="card-category">Total Purchases {{ \Carbon\Carbon::today()->toFormattedDateString() }}</p>
                                                <p class="card-title text-secondary">
                                                    $ {{ number_format($data['totalpurchasesday'], 2) }}
                                                <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

@endsection
