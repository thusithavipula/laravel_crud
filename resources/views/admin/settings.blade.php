@extends('admin.templates.restricted')
@section('additional-css')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    @include('common.alert_box')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Settings : Add user</h1>
    </div>
    <div class="block-center">
        <div class="row" id="add_user">
            <div class="col-lg-1 col-md-1 col-sm-1"></div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <form method="POST" action="{{ route('admin-register') }}" class="form-horizontal form-centered">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('name') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('name') ? $errors->first('name') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="name">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Months" value="{{ old('email') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('email') ? $errors->first('email') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="name">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Months" value="{{ old('password') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('password') ? $errors->first('password') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('password_confirmation') ? ' invalid' : '' }} row">
                        <label class="control-label col-sm-2" for="name">Confirm Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Months" value="{{ old('password_confirmation') }}">
                            <div class="invalid-feedback">
                                {{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="role">Role</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="role" name="role" placeholder="Admin" value="admin" readonly>
                        </div>
                    </div>
                    <div class="form-group">        
                        <div class="col-lg-offset-2 col-lg-10 col-md-offset-2 col-md-10 col-sm-offset-2 col-sm-10">
                            <div class="form-btn-wrapper">
                                <button type="submit" class="btn btn-primary ali">Submit</button>
                                <button type="reset" class="btn btn-default ali reset-form">Reset</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</main>



@endsection
@section('additional-scripts')
<script src="{{ asset('/js/dashboard.js')}}"></script>
<script type="text/javascript">
function resetForm() {
    $('#add_user .form-group').removeClass('invalid');
    $('#add_user input:not([name=_token])').val('');
    $('#add_user textarea').html();
    $('#add_user #is_active').prop('checked', false);
    $('#add_user #category').val('');
}

$('.reset-form').click(function () {
    resetForm();
});

$(document).ready(function () {
    if (!$("#alert-notification").hasClass('hidden')) {
        setTimeout(function () {
            $("#alert-notification").slideUp(500, function () {
                $("#alert-notification").slideUp(500);
            });
        }, 2000);
    }


});
</script>
@endsection