var url='http://proyecto-laravel.dev.com/';
window.addEventListener("load",function(){
    //like
    $('.btn-like').css('cursor','pointer');
    $('.btn-dislike').css('cursor','pointer');

    //like
    function like(){
        $('.btn-like').unbind('click').click(function(){
            $(this).addClass('btn-dislike').removeClass('btn-like');
            $(this).attr('src',url+'img/heart1.png');

            $.ajax({
                url:url+'/like/'+$(this).data('id'),
                type:'GET',
                success:function(response){
                    if(response.like){
                        console.log('has dado like');
                    }
                    else{
                        console.log(response.message);
                    }
                    
                }
            })
            dislike();   
        })
    }

    like();

    //dislike
    function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
            $(this).addClass('btn-like').removeClass('btn-dislike');
            $(this).attr('src',url+'img/heart.png');
            like();

            $.ajax({
                url:url+'/dislike/'+$(this).data('id'),
                type:'GET',
                success:function(response){
                    if(response.like){
                        console.log('has dado dislike');
                    }
                    else{
                        console.log(response.message);
                    }
                }
            })
        })
    }
    dislike();  
    
    $('#buscar').submit(function(e){
        $(this).attr('action',url+'users/'+$('#buscar #search').val());
    });
});