@extends('layouts.panel')

@section('breadcrumbs')
    {{ Breadcrumbs::render('dining') }}
@endsection

@section('content')

    <div id="page-wrapper">
        @include('partials.page-header', [
            'title' => trans('dining.title'),
            'url' => route('dining.index'),
            'options' => [
                [
                    'option' => trans('common.back'),
                    'url' => route('dining.index')
                ],
            ]
        ])

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2 class="text-center">@lang('common.report.of') @lang('dining.title')</h2>

                <form action="{{ route('dining.report.export') }}" method="POST">
                    @csrf()

                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label for="pwd">@lang('reports.type'):</label>
                        <select class="form-control selectpicker" title="{{ trans('common.chooseOption') }}" name="type" id="type" required>
                            <option value="all" selected>@lang('hotels.all')</option>
                            <option value="one">@lang('hotels.one')</option>
                        </select>

                        @if ($errors->has('type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('hotel') ? ' has-error' : '' }}" id="hotel-select" style="display:none;">
                        <label for="pwd">@lang('hotels.title'):</label>
                        <select class="form-control selectpicker" title="{{ trans('hotels.choose') }}" name="hotel" id="hotel">
                            @foreach ($hotels as $hotel)
                                <option value="{{ id_encode($hotel->id) }}">{{ $hotel->business_name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('hotel'))
                            <span class="help-block">
                                <strong>{{ $errors->first('hotel') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                        <label for="start">@lang('common.startDate'):</label>
                        <input type="text" class="form-control datepicker" name="start" id="start" value="{{ old('start') }}" required>

                        @if ($errors->has('start'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('end') ? ' has-error' : '' }}">
                        <label for="end">@lang('common.endDate'):</label>
                        <input type="text" class="form-control datepicker" name="end" id="end" value="{{ old('end') }}" required>

                        @if ($errors->has('end'))
                            <span class="help-block">
                                <strong>{{ $errors->first('end') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">@lang('common.query')</button>
                    <a href="{{ route('dining.index') }}" class="btn btn-default">
                        @lang('common.back')
                    </a>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $('#type').change(function () {
            if (this.value === 'one') {
                if ($('#hotel-select').is(':hidden')) {
                    $('#hotel-select').fadeIn()
                }
            } else {
                if ($('#hotel-select').is(':visible')) {
                    $('#hotel-select').fadeOut()
                }
            }
        })
    </script>
@endsection