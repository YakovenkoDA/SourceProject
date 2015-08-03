$(document).ready(function() {
    var url_host=$('a:contains(Главная)').attr('href');
    $('#loginForm').on('click', 'input[name=register]', function(e){
        e.preventDefault();
        $.post(
            url_host+'authorize/register',
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#userEmail').html('Вы зашли как: ' + '<a href='+url_host+'"/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#userId').html('<a id="logout" href="#">Exit</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                }
            },
            'json'
        );
    });
    
    $('#loginForm').on('click', 'input[name=login]', function(e){
        e.preventDefault();
        $.post(
            url_host+'authorize/login', 
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){ 
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('#userEnter').show();
                    $('#userEmail').html('Вы зашли как: ' + '<a href="'+url_host+'/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#userId').html('<a id="logout" href="#">Exit</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                   
                    if(data.role_id == 1) {
                         $('#admin_href').show();
                    }
                }
            },
            'json'
        );
    });
    
    $('body').on('click', '#logout', function(e) {
        e.preventDefault();
        $.post(
            url_host+'authorize/exit/', 
            {
                
            },
            function(){ 
                $('#logout').empty();
                $('#userId').show();
                $('#loginFormDiv').show();
                $('#userEmail').empty();
                $('#admin_href').hide();
            }
        ); 
    });
});