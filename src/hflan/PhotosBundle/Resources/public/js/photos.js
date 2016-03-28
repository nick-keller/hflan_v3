$(function(){
    var id = $('#photo-gallery').attr('data-id');

    $.getJSON('https://graph.facebook.com/'+id+'?fields=from,photos.limit(300).fields(source,picture),name&access_token=CAAOwtDcpVY8BAEYZBmZBG7UYOPlACddJSquCsDrvoHwnawgZAlysweLsPbBjbLH0blvHup8MDj2jTvuV7Uv9UFaTHhFu45JGRg5FHEsGFZCngtt44qdZC8NwLwLoBQoybQDueQfSow5qx3XtaNwU0D7obRs0ZArPAoWgLMhgtdIZBZASDcljmbOJYXyNZB9EsvRYIeAsGBTLBRwZDZD', function(data){
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