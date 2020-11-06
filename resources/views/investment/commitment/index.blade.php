@extends('basic')

@section('Content')
    <section class="container">
        <div class="card">
            <div class="card-body">
                {{ $CommitmentList->withQueryString()->links() }}
            </div>
            <div class="card-body pt-0">
                @include('component.investment.commitment-list',['CommitmentList' => $CommitmentList, 'detailBtn' => true])
            </div>
            <div class="card-body">
                {{ $CommitmentList->withQueryString()->links() }}
            </div>
        </div>
    </section>
@endsection

@section('StyleSheet')
    <style>
        div.card-body div.row:nth-child(even) {
            background-color: #f8f9fa
        }
    </style>
@endsection
