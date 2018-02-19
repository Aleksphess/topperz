$(document).ready(function(){
    $(document).on('click', '.js-add-to-cart', function(e){
        e.preventDefault();
        var id = $(e.currentTarget).data('id');
        var params = $('.js-category-'+id+' .item.active').data('id');
        var count = $('.js-count-add-'+id).val();
        var method = 'add';
        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/cart/request',
            data: {count:count,id:id,params:params,method:method},
            success: function (response) {
                console.log(response);
                $('.js-backet-price').text(response.cost);
                $('.js-backet-count').text(response.cart_count);
                $('body,html').animate({scrollTop:0},2000);
              /*  $('#modal_success').modal('toggle');*/
            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $("form#sign-up").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/auth/sign-up',
            data: $( this ).serialize(),
            success: function (data) {
                if(data=='success')
                {
                    $('#sign-up').trigger("reset");
                    $('.js-registration-answer').text('Вы успешно зарегестрированы, вам на почту выслано сообщение с подтверждением');
                }
                else
                {
                    $('.js-registration-answer').text(data);
                }

            },
            error: function (error) {
                $('form#callback').find('.bad-msg').fadeIn();
            }
        });
    });
    $("form#sign-in").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/auth/sign-in',
            data: $( this ).serialize(),
            success: function (data) {
                if(data.answer=='success')
                {
                    location.href=data.url;
                }
                else
                {
                    $('.js-answer-status').text(data);
                }

            },
            error: function (error) {
                $('form#callback').find('.bad-msg').fadeIn();
            }
        });
    });
    $("form#change-settings").on('submit',function(e){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/user/change-settings',
            data: $( this ).serialize(),
            success: function (data) {
                if(data=='success')
                {
                    $('.js-successs').text(data);
                    $('#modal_1_success').modal('toggle');

                }
                else
                {
                    $('.js-registration-answer').text(data);
                }

            },
            error: function (error) {
                $('form#callback').find('.bad-msg').fadeIn();
            }
        });
    });
    $(document).on('click', '.js-change-password', function(e){
        e.preventDefault();
        var password = $('#password').val()
                $.ajax({
            type: "post",
            dataType: 'json',
            url: '/user/change-password',
            data: {password:password},
            success: function (response) {
                $('.js-successs').text(response);
                $('#modal_1_success').modal('toggle');

            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $(document).on('click', '.js-delivery-add', function(e){
        e.preventDefault();
        var address = $('#address').val();
        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/user/add-address',
            data: {address:address},
            success: function (response) {

                $(response).appendTo('.js-render');
                $('.js-successs').text('успешно');
                $('#modal_1_success').modal('toggle');

            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $(document).on('click', '.js-delete-address', function(e){
        e.preventDefault();
        var id = $(e.currentTarget).data('id');

        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/user/delete-address',
            data: {id:id},
            success: function (response) {

                $('.js-none-'+id).remove();
                $('.js-successs').text('удалено');
                $('#modal_1_success').modal('toggle');

            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $(document).on('click', '.js-change-address', function(e){
        e.preventDefault();
        var id = $(e.currentTarget).data('id');
        var address = $('.js-change-'+id).val();
        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/user/change-address',
            data: {id:id,address:address},
            success: function (response) {

                //$('.js-success-change-'+id).text('change');
                $('.js-successs').text('Изменено');
                $('#modal_1_success').modal('toggle');

            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $(document).on('click', '.js-change-count', function(e){
        e.preventDefault();
        var id = $(e.currentTarget).data('id');
        var count = $('.js-count-requst-'+id).val();

        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/cart/change-count',
            data: {id:id,count:count},
            success: function (response) {
                console.log(response);
                $('.js-backet-price').text(response.cost);
                $('.js-change-price-'+id).text(response.param_summ);

            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $(document).on('click', '.js-delete-from-backet', function(e){
        e.preventDefault();
        var id = $(e.currentTarget).data('id');


        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/cart/delete-from-backet',
            data: {id:id},
            success: function (response) {
                $('.js-remove-from-backet-'+id).remove();
                $('.js-backet-price').text(response.cost);
                $('.js-backet-count').text(response.cart_count);



            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
        ;});
    $(document).on('click', '.js-change-price', function(e){
        e.preventDefault();
        var id = $(e.currentTarget).data('id');
        var price = $(e.currentTarget).data('price')*$('.js-count-add-'+id).val();

        $('.js-count-view-'+id).text(price);


    });
    $(".js-qty-input").on("change paste keyup", function(e) {
        var count = $(this).val();
        var id =  $(e.currentTarget).data('id');
        var price = $('.js-category-'+id+' .item.active .js-change-price').data('price');

        if (count > 0)
        {
            $('.js-count-view-'+id).text(price*count);
        }else {
            $(this).val(1);
        }

    });
    $(document).on('click', '.js-count-in-catalog', function(e){

        var id = $(e.currentTarget).data('id');
        var count = $('.js-count-add-'+id).val();
        var price = $('.js-category-'+id+' .item.active .js-change-price').data('price');
        console.log(id,count,price);
        if (count > 0)
        {
            $('.js-count-view-'+id).text(price*count);
        } else {
        $(this).val(1);
        }
    });
    $("form#js-feedback").on('submit',function(e){
        e.preventDefault();
        var mark = $('.user_rating').data('star');
        var name = $('.name').val();
        var text = $('.msg_reviews').val();
        $.ajax({
            type: 'POST',
            url: '/forms/feedback',
            data: {mark:mark,name:name,text:text},
            success: function (data) {
                if(data=='success')
                {
                    $('#js-feedback').trigger("reset");
                    $('.js-successs').text('Отзыв оставлен');
                    $('#modal_1_success').modal('toggle');

                }
                else
                {
                    $('.js-successs').text(data);
                    $('#modal_1_success').modal('toggle');
                }

            },
            error: function (error) {
                $('form#callback').find('.bad-msg').fadeIn();
            }
        });
    });
    $(document).on('click', '.js-clear', function(e){

        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/cart/clear',
            success: function (response) {
                location.href=response;



            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
    });
    $(document).on('click', '.js-order-request', function(e){
        var username = $('.js-name').val();
        var phone = $('.js-phone').val();
        var email = $('.js-email').val();
        var address = $('.js-address').val();
        var pay_type = $('.js-pay:checked').val();
        var delivery_type = $('.js-delivery:checked').val();
        var comment = $('.js-comment').val();
        var price = $('.js-order-price').data('price');
        $.ajax({
            type: "post",
            dataType: 'json',
            url: '/cart/new-order',
            data: {username:username,phone:phone,email:email,address:address,pay_type:pay_type,
                delivery_type:delivery_type,comment:comment,price:price},
            success: function (response) {
                location.href = response.url;


            },
            error: function (jqXhr) {
                console.log("Ошибка: " + jqXhr.statusText + " (" + jqXhr.readyState + ", " + jqXhr.status + ", " + jqXhr.responseText + ")");
            }

        })
    });
    $("form#js-question").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/user/save-question',
            data: $( this ).serialize(),
            success: function (data) {
                if(data==true)
                {
                    $('#js-question').trigger("reset");
                    $('.js-successs').text('вопрос успешно отправлен');
                    $('#modal_1_success').modal('toggle');
                }
                else
                {
                    $('.js-successs').text('произошла ошибка');
                    $('#modal_1_success').modal('toggle');
                }

            },
            error: function (error) {
                $('form#callback').find('.bad-msg').fadeIn();
            }
        });
    });
    $("form#js-callback").on('submit',function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/forms/callback',
            data: $( this ).serialize(),
            success: function (data) {
                if(data==true)
                {
                    $('#js-callback').trigger("reset");
                    $('.js-successs').text('вопрос успешно отправлен');
                    $('#myModal').fadeOut();
                    $('.modal-backdrop').fadeOut();
                    $('#modal_1_success').modal('toggle');


                }
                else
                {
                    $('.js-successs').text(data);
                    $('#modal_1_success').modal('toggle');
                }

            },
            error: function (error) {
                $('form#callback').find('.bad-msg').fadeIn();
            }
        });
    });

});