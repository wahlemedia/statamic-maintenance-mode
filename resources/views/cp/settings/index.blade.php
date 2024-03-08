@extends('statamic::layout')
@section('title', $title, Statamic::crumb(__('statamic-maintenance-mode::messages.cp.maintenance_title'),
    __('Utilities')))

    @php
        $breadcrumbs = [
            [
                'url' => cp_route('utilities.index'),
                'text' => __('Utilities'),
            ],
        ];
    @endphp

@section('content')
    <publish-form class="publish-form" title="{{ $title }}" action="{{ $action }}"
        :blueprint='@json($blueprint)' :meta='@json($meta)'
        :values='@json($values)' :breadcrumbs='@json($breadcrumbs)' />
@endsection
