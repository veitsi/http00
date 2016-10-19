$(document).ready(function() {

    $("#sign_reg").on("click", function(e) {
        e.preventDefault();
        $("#reg_error").html();
        form_data = $("#reg_form").serialize();
        $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'reg', data: form_data}, function(r) {
            try {
                result = jQuery.parseJSON(r);
            } catch(err){
                alert(err);
            }
            if (result.status == "success") {
                alert(result.mes);
            } else {
                $("#reg_error").html(result.mes);
            }
        });
    });
    $("#sign_login").on("click", function(e) {
        e.preventDefault();
        $("#sign_error").html();
        form_data = $("#sign_form").serialize();
        $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'auth', data: form_data}, function(r) {
            try {
                result = jQuery.parseJSON(r);
            } catch(err){
                alert(err);
            }
            if (result.status == "success") {
                window.location.reload();
            } else {
                $("#sign_error").html(result.mes);
            }
        });
    });
    $("#sign_logout").on("click", function(e) {
        e.preventDefault();
        var data = 'auth_type=0';
        $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'auth', data: data }, function() {
            window.location.reload();
        });
    });
    $("#sign_rec").on("click", function(e) {
        e.preventDefault();
        form_data = $("#rec_form").serialize();
        $.post("/_ajax.php", {token: $('#f_token').attr("content"), file: 'pass_recovery', data: form_data }, function(r) {
            try {
                result = jQuery.parseJSON(r);
            } catch(err){
                alert(err);
            }
            if (result.status == "success") {
                alert(result.mes);
            } else {
                $("#rec_error").html(result.mes);
            }
        });
    });

    var popupOverlay             = $('#popup_overlay');
    var loginTrigger             = $('[data-el="login_trigger"]');
    var closeIcon                = $('.b-popup__close');
    var showPassIcon             = $('[data-icon="show_pass"]');
    var registrationForm         = $('#popup_registration');
    var loginForm                = $('#popup_login');
    var registrationFormTrigger  = $('[data-el="create_popup_trigger"]');
    var restoreForm              = $('#restore_popup');
    var restoreFormTrigger       = $('#sign_restore');

    //LOGIN POPUP
    function openLoginPopup() {
        popupOverlay.fadeIn();
        loginForm.removeClass('is-hidden');
        registrationForm.addClass('is-hidden');
    }

    function hideAllPopups() {
        $('.b-popup').addClass('is-hidden');
    }

    loginTrigger.on('click',function(e) {
        e.preventDefault();
        openLoginPopup();
    });

    closeIcon.click(function() {
        $(this).parent().parent('.b-overlay').fadeOut();
        hideAllPopups();
    });

    registrationFormTrigger.on('click',function() {
        popupOverlay.fadeIn();
        hideAllPopups();
        registrationForm.removeClass('is-hidden');
    });

    showPassIcon.click(function() {
        var passInput = $(this).siblings('.b-input');
        var inputType = passInput.attr('type');

        if (inputType == 'password') {
            passInput.attr('type', 'text');
        } else {
            passInput.attr('type', 'password');
        }
    });

    restoreFormTrigger.on('click', function() {
        hideAllPopups();
        restoreForm.removeClass('is-hidden');
    });
});