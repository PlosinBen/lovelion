<form action="">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>名稱</label>
                        <input name="name" type="text" class="form-control" value="{{ $ledgerRecord->name }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>地點</label>
                        <input name="locate" type="text" class="form-control" value="{{ $ledgerRecord->locate }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>備註</label>
                        <input name="note" type="text" class="form-control" value="{{ $ledgerRecord->note }}" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">取消</button>
            <button class="btn btn-primary">新增</button>
        </div>
    </div>

</form>
