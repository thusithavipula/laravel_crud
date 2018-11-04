@extends('layouts.base')
@section('sub_template')
@include('common.nav_bar')
<div class="container-fluid">
    <div class="row">
        @include('admin.includes.admin_menu')
        <div id="overlay"></div>
        @yield('content')
    </div>
</div>
@endsection