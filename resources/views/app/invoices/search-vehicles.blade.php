@extends('layouts.panel')

@section('breadcrumbs')
    {{ Breadcrumbs::render('invoice', $invoice) }}
@endsection

@section('content')

    <div id="page-wrapper">
        @include('partials.page-header', [
            'title' => trans('invoices.title'),
            'url' => route('invoices.index'),
            'options' => [
                [
                    'option' => trans('common.new') . ' ' . trans('vehicles.vehicle'),
                    'url' => route('invoices.vehicles.create', ['id' => Hashids::encode($invoice->id)])
                ],
                [
                    'option' => 'Agregar empresa',
                    'url' => route('invoices.companies.search', [
                        'id' => Hashids::encode($invoice->id)
                    ])
                ],
                [
                    'option' => 'Volver al recibo',
                    'url' => route('invoices.show', [
                        'id' => Hashids::encode($invoice->id)
                    ])
                ]
            ]
        ])

        @include('app.invoices.info')

        <div class="form-group{{ $errors->has('guest') ? ' has-error' : '' }}">
            <label for="pwd">@lang('guests.guest'):</label>
            <select class="form-control selectpicker" title="{{ trans('common.chooseOption') }}" name="guest" id="guest" required>
                @foreach ($invoice->guests as $guest)
                    <option value="{{ Hashids::encode($guest->id) }}">{{ $guest->full_name }}</option>
                @endforeach
            </select>

            @if ($errors->has('guest'))
                <span class="help-block">
                    <strong>{{ $errors->first('guest') }}</strong>
                </span>
            @endif
        </div>

        <div class="row mt-4" id="search-input" style="display:none;">
            <div class="col-md-12">
                @include('partials.form', [
                    'title' => [
                        'title' => trans('common.search') . ' ' . trans('vehicles.title'),
                        'align' => 'text-center',
                        'size' => 'h3'
                    ],
                    'url' => '#',
                    'method' => 'GET',
                    'fields' => [
                        'app.invoices.search-field',
                    ],
                    'csrf' => false
                ])
            </div>
        </div>

        <div class="crud-list" id="list" style="display:none;">
            <div class="crud-list-heading">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <h5>@lang('vehicles.registration')</h5>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <h5>@lang('common.brand')</h5>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                        <h5>Color</h5>
                    </div>
                </div>
            </div>
            <div class="crud-list-items" id="item-search">

            </div>
        </div>

        @include('partials.spacer', ['size' => 'md'])
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#guest').change(function () {
            if ($('#guest').val()) {
                if ($('#search-input').is(':hidden')) {
                    $('#search-input').fadeIn();
                }
            } else {
                $('#search-input').fadeOut();
            }
        });

        function attachVehicle(e, url) {
            e.preventDefault();

            Swal.fire({
                title: translator.trans('common.attention'),
                text: translator.trans('common.confirmAction'),
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: translator.trans('common.continue'),
                cancelButtonText: translator.trans('common.cancel')
            }).then(result => {
                if (result.value) {
                    window.location.href = url + $('#guest').val();
                }
            });
        }

        function render(vehicle) {
            return `
            <a href="#" onclick="attachVehicle(event, '/invoices/{{ Hashids::encode($invoice->id) }}/vehicles/${vehicle.hash}/guests/')">
                <div class="crud-list-row">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <p>${vehicle.registration}</p>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <p>${vehicle.brand}</p>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <p>${vehicle.color}</p>
                        </div>
                    </div>
                </div>
            </a>
        `}

        const params = {
            url: '/vehicles/search',
            list_id: 'list',
            item_container: 'item-search',
            render: render
        };

        function search(query, event) {
            std_search(event, query, params);
        }
    </script>
@endsection