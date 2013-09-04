$(function(){
    $('tr[data-href] td').dblclick(function(e){
        window.location = $(this).parent().attr('data-href');
        e.stopPropagation();
    })

    $( "input[name*=date]" ).datepicker({dateFormat:"dd/mm/yy", showOtherMonths: true, selectOtherMonths: true, dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ], firstDay: 1});
    $( "input[name*=birthday]" ).datepicker({dateFormat:"dd/mm/yy", changeMonth: true, changeYear: true, maxDate: "-10y", yearRange: "-40:-10", dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ], firstDay: 1});
})