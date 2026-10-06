@extends('adminlte::page')

@section('title_prefix', 'Puskestren | ')

@section('title', 'Dashboard')

@section('content_header')
    @hasSection('page_title')
        <div class="mb-3">
            <h3 class="mb-1">
                @yield('page_title')
            </h3>

            @hasSection('page_description')
                <p class="text-muted mb-0">
                    @yield('page_description')
                </p>
            @endif
        </div>
    @endif
@stop

@section('footer')
    <div class="float-end d-none d-sm-inline">
        Sistem Informasi Pelayanan Puskestren
    </div>

    <strong>
        Copyright &copy; {{ date('Y') }} Puskestren.
    </strong>
    All rights reserved.
@stop