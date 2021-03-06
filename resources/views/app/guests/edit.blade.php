@extends('layouts.panel')

@section('breadcrumbs')
    {{ Breadcrumbs::render('guest', $guest) }}
@endsection

@section('content')

    <div id="page-wrapper">
        @include('partials.page-header', [
            'title' => trans('guests.title'),
            'url' => route('guests.index'),
            'options' => [
                [
                    'option' => trans('common.back'),
                    'url' => url()->previous()
                ],
            ]
        ])

        <div class="row">
            <div class="col-md-12">
                @include('partials.form', [
                    'title' => [
                        'title' => trans('common.editionOf') . ' ' . trans('guests.title'),
                        'align' => 'text-center'
                    ],
                    'url' => route('guests.update', ['id' => id_encode($guest->id)]),
                    'method' => 'PUT',
                    'fields' => [
                        'app.guests.edit-fields',
                    ],
                    'btn' => trans('common.update'),
                    'link' => [
                        'name' => trans('common.back'),
                        'href' => url()->previous()
                    ]
                ])
            </div>
        </div>

        @include('partials.spacer', ['size' => 'md'])
    </div>

@endsection