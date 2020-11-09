@extends('basic')

@section('Content')
    <section class="container">
        <div class="card row-table">
            <div class="card-body pt-0">
                <div class="row py-2 text-center border-bottom justify-content-center">
                    <div class="col d-none d-xl-block">
                        <strong>期別</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>期末權益</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>未平倉損益</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>沖銷損益</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>海期權益</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>實質權益</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>權益差額</strong>
                    </div>
                    <div class="col d-none d-xl-block">
                        <strong>分配總額</strong>
                    </div>
                    <div class="col-3 col-sm-2 d-xl-none">
                        <strong>操作</strong>
                    </div>
                    <div class="col-3 col-sm-2 col-xl">
                        <button data-target="#createStatementModal" data-toggle="modal" class="btn btn-xs btn-info">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-xs btn-primary">
                            <i class="fa fa-sync"></i>
                        </button>
                    </div>
                </div>
                @foreach($FuturesStatements as $futuresStatement)
                    <div class="row pt-2 text-right border-bottom">
                        <div class="col-12 col-xl pb-2 text-center">
                            {{ $futuresStatement->period->format('Y-m') }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>期末權益</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->commitment) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>未平倉損益</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->open_interest) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>沖銷損益</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->profit) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>海期權益</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->oversea_commitment) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>實質權益</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->real_commitment) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>權益差額</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->net_commitment) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>分配總額</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl">
                            {{ number_format($futuresStatement->distribution) }}
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 d-xl-none pb-2 text-center">
                            <strong>操作</strong>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl pb-2">
                            <button class="btn btn-warning btn-xs">
                                <i class="fas fa-calculator"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('AfterContent')
    <!-- Modal -->
    <div class="modal fade" id="createStatementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('investment.statement.store') }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">新增對帳單</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            @if (count($errors->AddStatement))
                                <div class="form-group">
                                    <div class=" alert alert-danger">
                                    @foreach ($errors->AddStatement->all() as $error)
                                        <div>
                                            <i class="fa fa-exclamation"></i>
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label>Period</label>
                                <input type="text" class="form-control datetimepicker" name="period"
                                       value="{{ old('period') }}"
                                       autocomplete="off" readonly="readonly">
                            </div>
                            <div class="form-group">
                                <label>期末權益</label>
                                <input type="number" class="form-control" name="commitment"
                                       value="{{ old('commitment') }}"
                                       autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>未平倉損益</label>
                                <input type="number" class="form-control" name="open_interest"
                                       value="{{ old('open_interest') }}"
                                       autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>沖銷損益</label>
                                <input type="number" class="form-control" name="profit"
                                       value="{{ old('profit') }}"
                                       autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>海外權益</label>
                                <input type="number" class="form-control" name="oversea_commitment"
                                       value="{{ old('oversea_commitment') }}"
                                       autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>備註</label>
                                <input type="text" class="form-control" name="note"
                                       value="{{ old('note') }}"
                                       autocomplete="off">
                            </div>
                        </div>
                        @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">取消</button>
                        <button class="btn btn-primary">新增</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('StyleSheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('Script')
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.zh-TW.min.js"></script>

    <script>
        $(function () {
            $('input.datetimepicker').datepicker({
                language: "zh-TW",
                format: "yyyy-mm",
                startView: 1,
                minViewMode: 1,
                todayHighlight: true,
                autoclose: true,
                weekStart: 0,
                daysOfWeekHighlighted: "0",
                endDate: new Date(),
            });

            $('form').on('submit', function () {

            });

            @if (count($errors->AddStatement))
            $('#createStatementModal').modal()
            @endif
        });

    </script>
@endsection
