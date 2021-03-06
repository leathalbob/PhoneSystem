$(document).ready(function(){

    /* REGISTRATION FUNCTIONS */
    function data_register_submission_function(type){
        if(type === 2){
            var selection = $('#register_reseller_form [data-register-submission]');
            var form = $('#register_reseller_form');
            var selectionType = 2;
        } else {
            var selection = $('#register_standard_form [data-register-submission]');
            var form = $('#register_standard_form');
            var selectionType = 1;
        }

        if(!selection.hasClass('disabled')){
            var email = form.find('[name="email"]').val();
            var pass1 = form.find('#password1').val();
            var pass2 = form.find('#password2').val();
            var fname = form.find('[name="fname"]').val();
            var errorPanel = form.find('#register_status_panel');
            selection.addClass('disabled');

            if(form.find('#terms_and_conditions').is(':checked')){
                $.ajax({
                    type: "POST",
                    url: "/content/javascripts/ajax/register.php",
                    data: "selection="+selectionType+"&email="+email+"&pass1="+pass1+"&pass2="+pass2+"&fname="+fname,
                    success: function(data){
                        data = JSON.parse(data);

                        if(data.status === 1){
                            $('.account-logo-box').css('display','none');
                            $('.account-content').empty().append('<span style="text-align:center; width:100%; display:inline-block">Please check your email account for a verification email.</span>');
                        } else {
                            errorPanel.html(data.error_message).addClass('active');
                        }

                        setTimeout(function(){
                            selection.removeClass("disabled");
                        },1500);
                    }
                });
            } else{
                errorPanel.html('Please accept Terms and Conditions').addClass('active');

                setTimeout(function(){
                    selection.removeClass("disabled");
                },1500);
            }
        }
    }

    $(document).on('click','[data-register-submission]',function(e){
        data_register_submission_function($(this).data('register-submission'));
    });

    $(document).on('keypress','#register_reseller_form input',function(e){
        if (e.keyCode === 13){
            data_register_submission_function(2);
        }
    });

    $(document).on('keypress','#register_standard_form input',function(e){
        if (e.keyCode === 13){
            data_register_submission_function(1);
        }
    });

    /* LOGIN FUNCTIONS */
    function data_login_submission_function(){
        var selection = $('#login_form [data-login-submission]');

        if(!selection.hasClass('disabled')){
            var form = $('#login_form');
            var email = form.find('[name="email"]').val();
            var password = form.find('[name="password"]').val();
            var errorPanel = form.find('#login_status_panel');
            selection.addClass('disabled');

            $.ajax({
                type: "POST",
                url: "/content/javascripts/ajax/login.php",
                data: "email="+email+"&password="+password,
                success: function(data){
                    data = JSON.parse(data);

                    if(data.status === 1){
                        errorPanel.removeClass('active');
                        window.location.href = '/';
                    } else {
                        errorPanel.html(data.error_message).addClass('active');
                    }

                    setTimeout(function(){
                        selection.removeClass("disabled");
                    },1500);
                }
            });
        }
    }

    $(document).on('click','[data-login-submission]',function(){
        data_login_submission_function($(this));
    });

    $(document).on('keypress','#login_form input',function(e){
        if (e.keyCode === 13){
            data_login_submission_function($(this));
        }
    });


    /* TODO: Check the password reset works */
    /* PASSWORD RESET FUNCTIONS */
    function data_preset_submission_function(){
        var selection = $('#preset_form [data-preset-submission]');

        if(!selection.hasClass('disabled')){
            var form = $('#preset_form').closest('form');
            var email = form.find('[name="email"]').val();
            var errorPanel = form.find('#preset_status_panel');
            selection.addClass('disabled');

            $.ajax({
                type: "POST",
                url: "/content/javascripts/ajax/password_reset.php",
                data: "email="+email,
                success: function(data){
                    data = JSON.parse(data);

                    errorPanel.html(data.status_message).addClass('active');

                    setTimeout(function(){
                        selection.removeClass("disabled");
                    },1500);
                }
            });
        }
    }

    $(document).on('click','[data-preset-submission]',function(e){
        e.preventDefault();
        data_preset_submission_function($(this));
    });

    $(document).on('keypress','#preset_form input',function(e){
        if (e.keyCode === 13){
            e.preventDefault();
            data_preset_submission_function($(this));
        }
    });

    $(document).on('click','#sip_dump',function(e){
          if($(this).hasClass('active')){
            $(this).removeClass('active').css('height','0px');
          } else {
            $(this).addClass('active').css('height','300px');
          }
    });
});