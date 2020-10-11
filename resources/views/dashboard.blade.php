@extends('basic')

@section('Title', 'Dashboard - Ledger')

@section('Content')
    <section class="container">
        <h5 class="h3">
            近期帳本清單
            <a id="createLedger" href="{{ route('bookkeeping.create') }}" class="btn btn-sm btn-success">新增</a>
        </h5>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="#">
                    <div class="card">
                        <img src="{{ asset('img/blank.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="ledger-card p-2">
                                <div class="name">
                                    <label>名稱：</label>
                                    <span class="float-right">2020</span>
                                </div>
                                <div class="currency">
                                    <label>幣別：</label>
                                    <span class="float-right">TWD</span>
                                </div>
                                <div class="expenses">
                                    <label>總支出：</label>
                                    <span class="float-right">{{ number_format(123345, 2) }}</span>
                                </div>
                                <div class="option">
                                    <button class="btn btn-sm btn-outline-danger float-right">delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </a>
            </div>
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

        $('#createLedgerModal form').on('submit', function() {
            if( $(this).find('input[name="name"]').val().length === 0 ) {
                return false
            }

            return true
        })
    </script>
@endsection
