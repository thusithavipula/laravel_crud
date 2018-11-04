@extends('admin.templates.restricted')
@section('additional-css')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
<style type="text/css">
    .tile {
        width:160px;
        height:180px;
        border-radius:4px;
        box-shadow: 2px 2px 4px 0 rgba(0,0,0,0.15);
        margin-top:20px;
        margin-left:20px;
        float:left;
    }

    .tile.wide {
        width: 340px;
    }

    .tile .header {
        height:120px;
        background-color:#f4f4f4;
        border-radius: 4px 4px 0 0;
        color:white;
        font-weight:300;
    }

    .tile.wide .header .left, .tile.wide .header .right {
        width:160px;
        float:left;
    }

    .tile .header .count {
        font-size: 48px;
        text-align:center;
        padding:10px 0 0;
    }

    .tile .header .title {
        font-size: 20px;
        text-align:center;
    }

    .tile .body {
        height:60px;
        border-radius: 0 0 4px 4px;
        color:#333333;
        background-color:white;
    }

    .tile .body .title {
        text-align:center;
        font-size:20px;
        padding-top:2%;
    }

    .tile.wide .body .title {
        padding:4%;
    }

    .tile.job .header {
        background: linear-gradient(to bottom right, #609931, #87bc27);
    }

    .tile.job  .body {
        color: #609931;
    }

    .tile.resource .header {
        background: linear-gradient(to bottom right, #ef7f00, #f7b200);
    }

    .tile.resource  .body {
        color: #ef7f00;
    }

    .tile.quote .header {
        background: linear-gradient(to bottom right, #1f6abb, #4f9cf2);
    }

    .tile.quote  .body {
        color: #1f6abb;
    }

    .tile.invoice .header {
        background: linear-gradient(to bottom right, #0aa361, #1adc88);
    }

    .tile.invoice  .body {
        color: #0aa361;
    }
</style>
@endsection

@section('content')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <div class="container">
        <div class="tile wide resource">
            <div class="header">
                <div class="left">
                    <div class="count">{{$student_summary['active']}}</div>
                    <div class="title">Active</div>
                </div>
                <div class="right">
                    <div class="count">{{$student_summary['inactive']}}</div>
                    <div class="title">Inactive</div>
                </div>
            </div>
            <div class="body">
                <div class="title">Student Count</div>
            </div>
        </div>
        <div class="tile wide quote">
            <div class="header">
                <div class="left">
                    <div class="count">{{$instructor_summary['active']}}</div>
                    <div class="title">Active</div>
                </div>
                <div class="right">
                    <div class="count">{{$instructor_summary['inactive']}}</div>
                    <div class="title">Inactive</div>
                </div>
            </div>
            <div class="body">
                <div class="title">Instructor Count</div>
            </div>
        </div>
        <div class="tile wide invoice">
            <div class="header">
                <div class="left">
                    <div class="count">{{$subject_summary['active']}}</div>
                    <div class="title">Active</div>
                </div>
                <div class="right">
                    <div class="count">{{$subject_summary['inactive']}}</div>
                    <div class="title">Inactive</div>
                </div>
            </div>
            <div class="body">
                <div class="title">Subject Count</div>
            </div>
        </div>
    </div>
</main>



@endsection
@section('additional-scripts')
<script src="{{ asset('/js/dashboard.js')}}"></script>
@endsection