
function menuEvent(s) {
    $('.main-container').addClass('hidden');
    $('#' + s ).removeClass('hidden');
    $('.mdl-layout__obfuscator').click();
}

function logout() {
    document.cookie = 'PHPSESSID' + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
    postData('/api/?p=logout', '');
    refreshPage();
}

function refreshPage() {
    window.location.reload();
}

function submitVote(pid) {
    f = $('#' + pid + '-poll-form');
    var data = f.serialize();
    console.log(data);
    postData('/api/?p=vote', data);
}

function submitNewData() {
    f = $('#new-poll-form');
    var data = f.serialize();

    if ($('#new-checkbox-public').prop('checked')) data += '&pub=true';
    else data += '&pub=false';
    if ($('#new-checkbox-dupes').prop('checked')) data += '&dupes=false';
    else data += '&dupes=true';

    console.log(data);
    postData('/api/?p=addPoll', data);
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
        postData('/api/?p=register', data);
    }else{
        if($('#username-reg').val().length < 1
            || $('#password-reg').val().length < 1)
            return;

        data = $('#login-form').serialize();
        postData('/api/?p=login', data);
    }
}

function toastMessage(msg) {
    var toastContainer = document.querySelector('#toast');
    toastContainer.MaterialSnackbar.showSnackbar({
        message: msg,
        timeout: 2000
    });
}

function showToast(dataObj) {
    var toastContainer = document.querySelector('#toast');
    toastContainer.MaterialSnackbar.showSnackbar(dataObj);
}

function postData(url, data) {
    $.post(url, data).always(function(response) {
        if (response === ''
        || response === null)
            return;
        if(typeof(response) === 'string') {
            toastMessage(response);
            return;
        }
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