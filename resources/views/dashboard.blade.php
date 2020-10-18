@extends('basic')

@section('Title', 'Dashboard - Ledger')

@section('Content')
    <section class="container">
        <h4 class="h3">
            近期帳本清單
            <a id="createLedger" href="{{ route('bookkeeping.create') }}" class="btn btn-sm btn-success">新增</a>
        </h4>

        <div class="row">
            @foreach($ledgerEntities as $ledgerEntity)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <a href="#">
                        <div class="card ledger-card">
                            <div class="card-header">
                                {{ $ledgerEntity->name }}
                            </div>
                        <!--
                            <img src="{{ asset('img/blank.jpg') }}" class="card-img-top" alt="...">
                        -->
                            <div class="card-body">
                                <div class="p-2">
                                    <div class="currency">
                                        <label>幣別：</label>
                                        <span class="float-right">{{ $ledgerEntity->currency_code }}</span>
                                    </div>
                                    <div class="expenses">
                                        <label>總支出：</label>
                                        <span class="float-right">
                                            {{ number_format($ledgerEntity->expenses, config("currency.{$ledgerEntity->currency_code}.places")) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('AfterContent')
    @include('bookkeeping.createModal')
@endsection

@section('Script')
    <script>
        $('#createLedger').on('click', (e) => {
            e.preventDefault()
            $('#createLedgerModal').modal()
        })

        $('#createLedgerModal form').on('submit', function () {
            if ($(this).find('input[name="name"]').val().length === 0) {
                return false
            }

            return true
        })
    </script>
@endsection
