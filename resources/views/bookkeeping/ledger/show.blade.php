@extends('basic')

@section('Content')
    <section class="container">
        <div class="card">
            <div class="card-body">
                <caption>
                    {{ $ledgerRecords->withQueryString()->links() }}
                </caption>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr class="text-center">
                            <th>日期</th>
                            <th>名稱</th>
                            <th>地點</th>
                            <th>金額</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ledgerRecords as $ledgerRecord)
                            <tr>
                                <td>{{ $ledgerRecord->date->toDateString() }}</td>
                                <td>{{ $ledgerRecord->name }}</td>
                                <td>{{ $ledgerRecord->locate }}</td>
                                <td class="text-right">{{ number_format($ledgerRecord->total) }}</td>
                                <td>
                                    <div class="btn-group-sm">
                                        <button class="btn btn-success" data-id="{{ $ledgerRecord->id }}">View</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <caption>
                    {{ $ledgerRecords->withQueryString()->links() }}
                </caption>
            </div>
        </div>

    </section>
@endsection

@section('Script')
    <script>
        $('table').on('click', 'button', function() {
            console.log( this.dataset.id )
        })
    </script>
@endsection
