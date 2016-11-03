function menuEvent(s, clickMenu) {
    $('.main-container').addClass('hidden');
    $('#' + s).removeClass('hidden');
    if (clickMenu)
        $('.mdl-layout__obfuscator').click();
}

function logout() {
    postData('/api/?p=logout', '');
    updateMenu(false);
    setTimeout(function () {
        refreshPage(true);
    },500);
}

function refreshPage(hard) {
    if (hard)
        window.location.href = window.location.href;
    else
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
    if (register) {
        if ($('#username-reg').val().length < 1)
            return toastMessage('Username zu kurz!');
        if ($('#password-reg').val().length < 8)
            return toastMessage('Passwort zu kurz!');
        if ($('#password-reg').val() !== $('#password-confirm-reg').val())
            return toastMessage('Passwörter sind nicht gleich!');

        data = $('#registration-form').serialize();
        var url = '/api/?p=register';
    } else {
        if ($('#username-login').val().length < 1
            || $('#password-login').val().length < 1)
            return;

        data = $('#login-form').serialize();
        var url = '/api/?p=login';
    }
    $.post(url, data).done(function () {
        refreshPage(false);
    }).always(function (response) {
        if (response === ''
            || response === null)
            return result;
        if (typeof(response) === 'string') {
            toastMessage(response);
        }
        else {
            toastMessage(response.responseText);
        }
    });
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
    $.post(url, data).always(function (response) {
        if (response === ''
            || response === null)
            return result;
        if (typeof(response) === 'string') {
            toastMessage(response);
        } else {
            toastMessage(response.responseText);
        }
    });
}

function updateMenu(loggedIn) {
    if (loggedIn) {
        $('.loggedout-only').addClass('hidden');
        $('.login-only').removeClass('hidden');
        setUsername(value);
    } else {
        $('.login-only').addClass('hidden');
        $('.loggedout-only').removeClass('hidden');
    }
}

function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

function setUsername(name) {
    $('#username-storage').val(name);
}

function getUsername() {
    return $('#username-storage').val();
}

// EVENT HANDLERS
// ==============

$(function () {
    $('#login-submit').click(function () {
        submitLogin(false);
    });

    $('#register-submit').click(function () {
        submitLogin(true);
    });

    $('#new-submit').click(function () {
        submitNewData();
    });
});

// INIT
// ====

$(function () {
    var sitePid = getParameterByName('pid');
    var showResults = getParameterByName('results');

    // check if pid and/or results url parameters are set
    if (showResults)
        menuEvent('result-main-container', false);
    else if (sitePid > 0)
        menuEvent('single-poll-main-container', false);

    $.get('/api/?p=getLoginInfo').always(function (response) {
        if (response === ''
            || response === null)
            return false;

        value = false;
        if (typeof(response) === 'string')
            value = response;
        else
            value = response.responseText;

        updateMenu((value !== 'false'));
    });
});