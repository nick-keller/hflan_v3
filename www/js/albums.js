$(function(){
    $.getJSON('https://graph.facebook.com/hf.lan.esiee?fields=albums.fields(name,type,count,id,photos.limit(3).fields(picture))&access_token=EAAOwtDcpVY8BACEN3MaijhLdD0BZAwZCl02zpo1vKsZCPgatQUUEfqtSIv35TD8zWNaUz2hjJXJwUhYEZBZCIO5ROFFQZBk8oNQactVbAdR4ebK82RAfp8XBZCMH3uiLZBpeA0jV5c4k3iP3rlUD0ECAfWap6HTCaGS9oXtJLeaiT68vwTszAZAl35b6QGT3X42oJAYPB7bZBJ0AZDZD', function(data){
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
