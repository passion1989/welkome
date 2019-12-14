<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('invoices.invoice')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ config('app.url') . '/css/pdf.css' }}">
    <style>
        h1, .h1, h2, .h2, h3, .h3 {
            margin-top: 10px !important;
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
        }
        .mt-2 {
            margin-top: 10px;
        }
        .mt-4 {
            margin-top: 20px;
        }

        .mb-2 {
            margin-bottom: 20px;
        }
        .mb-4 {
            margin-bottom: 20px;
        }

        .my-2 {
            margin: 0 10px;
        }

        .my-4 {
            margin: 0 20px;
        }

        .mx-2 {
            margin: 10px 0;
        }

        .mx-4 {
            margin: 20px 0;
        }

        .py-2 {
            padding: 0 10px;
        }

        .py-4 {
            padding: 0 20px;
        }

        .d-block {
            display: block;
        }

        .font-weight-light {
            font-weight: 100;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .line {
            border-bottom: 2px solid #000;
            width: 100%;
        }

        .line-light {
            width: 100%;
            border-bottom: 1px solid #949597;
        }

        .line-end {
            width: 100%;
            border-bottom: 2px solid #f0c29e;
        }

        .data {
            background-color: #dcdddf;
        }

        .data .data-box {
            margin-top: 60px;
        }

        .data .data-box .data-separator {
            border-top: 1px solid #949597;
            width: 10%;
        }

        .content {
            background-color: #f1f1f1;
        }

        .without-margin {
            margin: 0 !important;
        }

        .qr-code {
            margin: 0 auto;
            display: block;
        }

        /* To break in pages, please use this class */
        .page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }

        .row-equal {
            display: table;
        }

        .row-equal .col-equal {
            float: none;
            display: table-cell;
            vertical-align: top;
        }

        .spacer-lg {
            margin: 20px;
            display: block;
        }
    </style>
</head>
<body>
    @foreach ($pages as $page)
        <div id="app" class="container invoice page">
            <div class="row row-equal">
                <!-- data -->
                @include('app.invoices.exports.data')
                <!-- end data -->

                <!-- content -->
                <div class="col-xs-8 content py-4 col-equal">
                    @if ($loop->first)
                        <!-- header -->
                        @include('app.invoices.exports.header')
                        <!-- end header -->
                    @endif

                    <!-- items -->
                    <div class="items">
                        @foreach ($page as $item)
                            @if ($item instanceof \App\Welkome\Room)
                                <div class="row mt-2 list-content">
                                    <div class="col-xs-6">
                                        <p class="without-margin">@lang('rooms.room') {{ $item->number }}</p>
                                        <p class="without-margin text-muted">
                                            <small>@lang('common.date'): {{ $item->pivot->start }} - {{ $item->pivot->end }}</small>
                                        </p>
                                    </div>
                                    <div class="col-xs-2 text-center">$ {{ number_format($item->pivot->subvalue, 0, '.', ',') }}</div>
                                    <div class="col-xs-2 text-center">{{ $item->pivot->quantity }}</div>
                                    <div class="col-xs-2 text-right">$ {{ number_format($item->pivot->subvalue, 0, '.', ',') }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 mx-2">
                                        <div class="line-light"></div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- end items -->

                    @if ($loop->last)
                        <!-- values -->
                        @include('app.invoices.exports.values')
                        <!-- end values -->

                        <!-- signature -->
                        @include('app.invoices.exports.signature')
                        <!-- end signature -->

                        <!-- gratitude -->
                        @include('app.invoices.exports.questions')
                        <!-- end gratitude -->
                    @endif

                    <!-- pagination -->
                    <div class="invoice-pagination text-right">
                        <p class="text-muted text-right">Page 1 of 1</p>
                    </div>
                    <!-- end pagination -->
                </div>
                <!-- end content -->
            </div>
        </div>
    @endforeach

    <!-- Scripts -->
    <script src="{{ config('app.url') . '/js/app.js' }} "></script>
</body>
</html>
