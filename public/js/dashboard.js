$(document).ready(function () {
    $('.sidebar-menu a').each(function () {
        var href = $(this).attr('href');
        var current = window.location.href;
        if (current === href) {
            $(this).addClass('active');
        }
    })

    $('#sidebar_toggle').on('click', function () {
        $('#sidebar').toggleClass('active');
        $("#overlay").toggleClass('active');
    });
    
    feather.replace();

});

