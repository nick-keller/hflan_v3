$(function(){
    $('.carousel .nav-next').click(function(){
        var $prev = $(this).nextAll('.current');
        var $current = $(this).nextAll('.next');

        $(this).nextAll('article').removeClass();
        $prev.addClass('prev');
        $current.addClass('current');

        var $next = $current.next('article');
        if(!$next.length)
            $next = $current.parent().find('article:first');
        $next.addClass('next');
    });

    $('.carousel .nav-prev').click(function(){
        var $next = $(this).nextAll('.current');
        var $current = $(this).nextAll('.prev');

        $(this).nextAll('article').removeClass();
        $next.addClass('next');
        $current.addClass('current');

        var $prev = $current.prev('article');
        if(!$prev.length)
            $prev = $current.parent().find('article:last');
        $prev.addClass('prev');
    });
})