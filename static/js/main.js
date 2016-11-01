
function menuEvent(s) {
    $('.main-container').addClass('hidden');
    $('#' + s ).removeClass('hidden');
    $('.mdl-layout__obfuscator').click();
}

function logout() {
    refreshPage();
}

function refreshPage() {
    window.location.reload();
}

function submitNewData() {
    f = $('#new-poll-form');
    var data = f.serialize();

    if ($('#new-checkbox-public').prop('checked')) data += '&pub=true';
    else data += '&pub=false';
    if ($('#new-checkbox-multiple').prop('checked')) data += '&multi=true';
    else data += '&multi=false';
    if ($('#new-checkbox-dupes').prop('checked')) data += '&dupes=false';
    else data += '&dupes=true';

    postData('/api?p=newPoll', data);
}

function submitLogin(register) {
    var data;
    if(register){
        if($('#username-reg').val().length < 1)
            return toastMessage('Username zu kurz!');
        if($('#password-reg').val().length < 8)
            return toastMessage('Passwort zu kurz!');
        if($('#password-reg').val() !== $('#password-confirm-reg').val())
            return toastMessage('Passwörter sind nicht gleich!');

        data = $('#registration-form').serialize();
        postData('/api?p=register', data);
    }else{
        if($('#username-reg').val().length < 1
            || $('#password-reg').val().length < 1)
            return;

        data = $('#login-form').serialize();
        postData('/api?p=login', data);
    }
}

function toastMessage(msg) {
    var toastContainer = document.querySelector('#toast');
    toastContainer.MaterialSnackbar.showSnackbar({
        message: msg,
        timeout: 1000
    });
}

function postData(url, data) {
    $.post(url, data).done(function(response) {
        toastMessage(response.responseText);
    }).fail(function(response) {
        toastMessage(response.responseText);
    });
}

// EVENT HANDLERS
// ==============

$(function() {
    $('#login-submit').click(function(){
        submitLogin(false);
    });

    $('#register-submit').click(function(){
        submitLogin(true);
    });

    $('#new-submit').click(function(){
        submitNewData();
    });
});