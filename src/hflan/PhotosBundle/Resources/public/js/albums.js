$(function(){
    $.getJSON('https://graph.facebook.com/hf.lan.esiee?fields=albums.fields(name,type,count,id,photos.limit(3).fields(picture))&access_token=CAAOwtDcpVY8BAEYZBmZBG7UYOPlACddJSquCsDrvoHwnawgZAlysweLsPbBjbLH0blvHup8MDj2jTvuV7Uv9UFaTHhFu45JGRg5FHEsGFZCngtt44qdZC8NwLwLoBQoybQDueQfSow5qx3XtaNwU0D7obRs0ZArPAoWgLMhgtdIZBZASDcljmbOJYXyNZB9EsvRYIeAsGBTLBRwZDZD', function(data){
        $('#photo-albums').html('');
        $.each(data.albums.data, function(i, e){
            if(e.type == 'normal' && e.count > 20){
                var album = $('<a class="photo-album" href="'+window.location+ e.id+'"><div>'+ e.name+'</div></a>');
                $('#photo-albums').append(album);

                $.each(e.photos.data, function(j, photo){
                    var img = $('<img src="'+photo.picture+'">');
                    album.prepend(img);
                })
            }
        })
    })
})