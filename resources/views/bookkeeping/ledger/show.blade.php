@extends('basic')

@section('Content')
    <section class="container">
        <div class="card">
            <div class="card-body border-bottom">
                <div class="row">

                </div>
            </div>
            <div class="card-body">
                <caption>
                    {{ $ledgerRecords->withQueryString()->links() }}
                </caption>
                <div class="table-responsive-sm">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                        <tr class="text-center">
                            <th>id</th>
                            <th>日期</th>
                            <th>名稱</th>
                            <th>地點</th>
                            <th>金額</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ledgerRecords as $ledgerRecord)
                            <tr role="button" onclick="location.href='{{ route('bookkeeping.ledgerRecord.show', $ledgerRecord->id) }}'">
                                <td>{{ $ledgerRecord->id }}</td>
                                <td>{{ $ledgerRecord->date->format('m-d') }}</td>
                                <td>{{ $ledgerRecord->name }}</td>
                                <td>{{ $ledgerRecord->locate }}</td>
                                <td class="text-right">{{ number_format($ledgerRecord->total) }}</td>
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

@section('AfterContent')
    <!-- Modal -->
    <div class="modal fade" id="createLedgerRecordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        </div>
    </div>
@endsection

@section('Script')
    <script>
        $('table').on('click', 'tr', function() {

            console.log( this.dataset.id )
        })
    </script>
@endsection
