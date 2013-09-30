$(function(){
    var carouselNext = function($carousel){
        var $prev = $carousel.find('.current');
        var $current = $carousel.find('.next');

        $carousel.find('article').removeClass();
        $prev.addClass('prev');
        $current.addClass('current');

        var $next = $current.next('article');
        if(!$next.length)
            $next = $carousel.find('article:first');
        $next.addClass('next');
    }

    var autoPlay = function(){
        $('.carousel').each(function(){
            if($(this).attr('data-autoplay') == 'true' && $(this).attr('data-paused') == 'false'){
                carouselNext($(this));
                setTimeout(autoPlay, 4000);
            }
        });
    }
    setTimeout(autoPlay, 4000);

    $('.carousel .nav-next').click(function(){
        carouselNext($(this).parent());
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

    $('.carousel').mouseenter(function(){
        $(this).attr('data-paused', 'true');
    })

    $('.carousel').mouseleave(function(){
        $(this).attr('data-paused', 'false');
        setTimeout(autoPlay, 4000);
    })
})