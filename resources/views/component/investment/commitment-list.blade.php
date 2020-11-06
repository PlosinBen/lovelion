<div class="row py-2 d-none d-md-flex border-bottom text-center">
    <div class="col">
        <strong>期別</strong>
    </div>
    <div class="col">
        <strong>損益</strong>
    </div>
    <div class="col">
        <strong>權益</strong>
    </div>
    <div class="col">
        <strong>入金</strong>
    </div>
    <div class="col">
        <strong>出金</strong>
    </div>
    <div class="col">
        <strong>費用</strong>
    </div>
</div>
@foreach($CommitmentList as $investmentEntity)
    <div class="row pt-3 pb-2 border-bottom">
        <div class="col-12 col-sm-6 col-md-2 mb-2 text-center">
            {{ $investmentEntity->period }}
            @if(isset($detailBtn) && $detailBtn === true)
                <a href="{{ route('investment.commitment.show', $investmentEntity->period) }}"
                   class="btn btn-xs btn-success ml-2">View</a>
            @endif
        </div>
        <div class="col-4 col-sm-2 d-md-none text-center">
            <strong>損益</strong>
        </div>
        <div class="col-7 col-sm-4 col-md-2 mb-2 text-right">
            {{ number_format($investmentEntity->profit) }}
        </div>
        <div class="col-4 col-sm-2 d-md-none text-center">
            <strong>權益</strong>
        </div>
        <div class="col-7 col-sm-4 col-md-2 mb-2 text-right">
            {{ number_format($investmentEntity->commitment + $investmentEntity->transfer) }}
        </div>
        <div class="col-4 col-sm-2 d-md-none text-center">
            <strong>入金</strong>
        </div>
        <div class="col-7 col-sm-4 col-md-2 mb-2 text-right">
            {{ number_format($investmentEntity->dispost) }}
        </div>
        <div class="col-4 col-sm-2 d-md-none text-center">
            <strong>出金</strong>
        </div>
        <div class="col-7 col-sm-4 col-md-2 mb-2 text-right">
            {{ number_format($investmentEntity->withdraw) }}
        </div>
        <div class="col-4 col-sm-2 d-md-none text-center">
            <strong>費用</strong>
        </div>
        <div class="col-7 col-sm-4 col-md-2 mb-2 text-right">
            {{ number_format($investmentEntity->expense) }}
        </div>
    </div>
@endforeach
