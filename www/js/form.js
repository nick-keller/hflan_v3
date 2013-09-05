$(function(){
    $('tr[data-href] td').dblclick(function(e){
        window.location = $(this).parent().attr('data-href');
        e.stopPropagation();
    })

    $( "input[name*=date]" ).datepicker({dateFormat:"dd/mm/yy", showOtherMonths: true, selectOtherMonths: true, dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ], firstDay: 1});
    $( "input[name*=birthday]" ).datepicker({dateFormat:"dd/mm/yy", changeMonth: true, changeYear: true, maxDate: "-10y", yearRange: "-40:-10", dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ], firstDay: 1});

    // extra fields
    var main_container = $('#hflan_lanbundle_tournament_extraFields');
    var add_btn = $('<button type="button" class="btn"><i class="icon-plus"></i> Ajouter un champ</button>');
    var index = main_container.find('.control-group').length;

    main_container.append(add_btn);
    add_btn.click(add_form);

    function add_form(){
        var html = main_container.attr('data-prototype')
            .replace('<label class="control-label required">__name__label__</label>', '')
            .replace(/__name__/g, index);
        var $prototype = $(html);

        add_btn.before($prototype);
    }
})