<div class="alert alert-{{Session::has('type') ? Session::get('type') : ' hidden' }}" id="alert-notification">
    <button type="button" class="close" data-dismiss="alert">x</button>
    {!!Session::get('message')!!}
</div>