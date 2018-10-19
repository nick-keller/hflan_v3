$(function(){
    var id = $('#photo-gallery').attr('data-id');

    $.getJSON('https://graph.facebook.com/'+id+'?fields=from,photos.limit(300).fields(source,picture),name&access_token=EAAOwtDcpVY8BACEN3MaijhLdD0BZAwZCl02zpo1vKsZCPgatQUUEfqtSIv35TD8zWNaUz2hjJXJwUhYEZBZCIO5ROFFQZBk8oNQactVbAdR4ebK82RAfp8XBZCMH3uiLZBpeA0jV5c4k3iP3rlUD0ECAfWap6HTCaGS9oXtJLeaiT68vwTszAZAl35b6QGT3X42oJAYPB7bZBJ0AZDZD', function(data){
        if(data.error != undefined || data.from == undefined || data.from.id != 236675399770934){
            $('#album-title').html('Erreur');
            $('#photo-gallery').html("<p>Cet album photo n'existe pas...</p>");
        }
        else{
            $('#album-title').html(data.name);
            $('#photo-gallery').html('');

            $.each(data.photos.data, function(i, photo){
                $('#photo-gallery').append('<a href="'+photo.source+'" data-lightbox="album" style="background-image:url('+photo.picture+')"></a>');
            })
        }
    })
})
