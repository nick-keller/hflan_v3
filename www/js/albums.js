$(function(){
    $.getJSON('https://graph.facebook.com/hf.lan.esiee?fields=albums.fields(name,type,count,id,photos.limit(3).fields(picture))', function(data){
        $('#photo-albums').html('');
        $.each(data.albums.data, function(i, e){
            if(e.type == 'normal' && e.count > 20){
                var album = $('<a class="photo-album" href="'+window.location+ e.id+'">'+ e.name+'</a>');
                $('#photo-albums').append(album);

                $.each(e.photos.data, function(j, photo){
                    var img = $('<img src="'+photo.picture+'">');
                    album.prepend(img);
                })
            }
        })
    })
})