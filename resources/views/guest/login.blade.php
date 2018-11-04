@extends('layouts.base')
@section('additional-css')
<link href="{{ asset('css/signin.css') }}" rel="stylesheet">
@endsection

@section('sub_template')
<form class="form-signin" method="POST" action="{{ route('post-login') }}">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="sr-only">Email address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    @if(Session::has('message'))
      @if(Session::get('type') === 'danger')
          <div class="alert alert-danger text-center">{{ Session::get('message') }}</div>
      @elseif(Session::get('type') === 'success')
          <div class="alert alert-success text-center">{{ Session::get('message') }}</div>
      @endif
    @endif
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy;  thusithavipula - 2018</p>
</form>
@endsection