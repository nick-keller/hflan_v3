$(function(){
    $.getJSON('https://graph.facebook.com/hf.lan.esiee?fields=albums.fields(name,type,count,id,photos.limit(3).fields(picture))', function(data){
        alert('yeeees!')
    })
})