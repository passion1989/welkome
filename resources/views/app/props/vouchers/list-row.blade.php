<div class="crud-list-row">
    <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 align-self-center">
            <p>
                {{ $row->created_at->format('Y-m-d') }}
            </p>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 align-self-center">
            <p>
                <a href="{{ route('vouchers.show', ['id' => id_encode($row->id)]) }}">
                    {{ $row->number }}
                </a>
            </p>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 align-self-center dont-break-out">
            <p>
                {{ trans('transactions.' . $row->type) }}
            </p>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 align-self-center">
            <p>
                {{ $row->comments ? str_limit($row->comments, 100) : trans('common.noData') }}
            </p>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 align-self-center">
            <p>
                {{ number_format($row->pivot->value, 2, ',', '.') }}
            </p>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 align-self-center">
            <p>
                {{ $row->pivot->quantity }}
            </p>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 align-self-center">
            <p>
                {{ $row->made_by }}
            </p>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 align-self-center">
            <a href="{{ route('vouchers.show', ['id' => id_encode($row->id)]) }}" class="btn btn-link">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</div>