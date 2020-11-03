@extends('basic')

@section('Content')
    <section class="container">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2 py-2 d-none d-sm-flex border-bottom text-center font-weight-bold bg-dark text-light">
                    <div class="col-sm-12 col-md">
                        帳本名稱
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-1">
                        幣別
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        建立日期
                    </div>
                </div>
                @foreach($ledgerEntities as $ledgerEntity)
                    <div class="row mb-2 border-bottom">
                        <div class="col-12 col-md pb-2">
                            {{ $ledgerEntity->name }}
                        </div>
                        <div class="col-4 mb-3 d-sm-none text-center">
                            <strong>幣別</strong>
                        </div>
                        <div class="col-8 col-sm-6 col-md-2 col-lg-1 pb-2 text-center">
                            {{ $ledgerEntity->currency_code }}
                        </div>
                        <div class="col-4 mb-3 d-sm-none text-center">
                            <strong>建立日期</strong>
                        </div>
                        <div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2 text-center">
                            {{ $ledgerEntity->created_at }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
