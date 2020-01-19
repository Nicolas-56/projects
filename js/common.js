$(".add").on("click",function(){
    var fio = $('input[name=user_fio]').val();
    var post = $('input[name=user_post]').val();
    var city = $('input[name=user_city]').val();
    var email = $('input[name=user_mail]').val();
    $.ajax({
        'url':'action.php',
        'type':'POST',
        'data':{
            'action':'add',
            'fio':fio,
            'post':post,
            'city':city,
            'email':email
        },
        success: function(response){
            if (response){
                response = $.parseJSON(response);
                if (response["errors"])
                {
                    $(".errors").html(response["errors"]);
                }
                if (response["result"]){
                    $(".data-users__table").html(response["result"]);
                }
            }
        }
    })
});

$(document).on("click",".delete",function(){

    if (confirm('Точно хотите удалить?'))
    {
        var id = $(this).attr('data-id');
        var self = $(this).parents('tr');
        $.ajax({
            'url':'action.php',
            'type':'POST',
            'data':{
                'action':'delete',
                'id':id,
            },
            success: function(response){
                response = $.parseJSON(response);
                if (response["result"]){
                    $(".data-users__table").html(response["result"]);
                }
            }
        })
    }
    
});