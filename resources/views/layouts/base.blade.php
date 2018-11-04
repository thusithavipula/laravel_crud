<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../../../favicon.ico">

        <title>@yield('title')</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom styles for this template -->
        @yield('additional-css')
    </head>
    <body>
        @yield('sub_template')
        <script src="{{ asset('/js/jquery.min.js')}}"></script>
        <script src="{{ asset('/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        
         <!--Font Awesome JS--> 
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
        
        
        @yield('additional-scripts')
    </body>
</html>