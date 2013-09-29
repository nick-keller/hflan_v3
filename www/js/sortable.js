$(function(){
    $('*[data-sortable]').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var $row = $this.parent().parent();
        var dir = $this.attr('data-sortable');

        $.get($this.attr('href'));

        if(dir == 'up'){
            if(!$row.prev().find('th').length)
                $row.after($row.prev());
        }
        else
            $row.before($row.next());
    })
})