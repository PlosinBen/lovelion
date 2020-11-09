<!-- Modal -->
<div class="modal fade" id="createLedgerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('bookkeeping.ledger.store') }}" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增帳本</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>名稱</label>
                        <input name="name" type="text" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>幣別</label>
                        <select name="currency_code" class="form-control">
                            @foreach(config('currency') as $code => $conf)
                                <option value="{{ $code }}">{{ $conf['name'] }}({{ $code  }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">取消</button>
                    <button class="btn btn-primary">新增</button>
                </div>
            </div>
        </form>
    </div>
</div>
