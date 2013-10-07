$(function(){
    $('.tabs .tab').click(function(e){
        var $this = $(this);
        $this.siblings().removeClass('active');
        $this.addClass('active');

        e.preventDefault();

        var target = $($this.attr('href'));
        target.attr('id','');
        window.location.hash = $this.attr('href');
        target.attr('id',$this.attr('href').replace('#', ""));
        target.siblings().removeClass('active');
        target.addClass('active');
    });

    if(window.location.hash.replace('#', '') == ''){
        $('.tabs .tab:first').addClass('active');
        $('.tab-content .tab-container:first').addClass('active');
    }
    else{
        $('.tabs .tab[href='+window.location.hash+']').addClass('active');
    }
})