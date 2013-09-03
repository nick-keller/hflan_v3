$(function(){
    $('tr[data-href] td').dblclick(function(e){
        window.location = $(this).parent().attr('data-href');
        e.stopPropagation();
    })
})