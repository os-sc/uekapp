/**             _        _          _
 *  _ __   ___ | |_ __ _| |_ ___   (_)___
 * | '_ \ / _ \| __/ _` | __/ _ \  | / __|
 * | |_) | (_) | || (_| | || (_) | | \__ \
 * | .__/ \___/ \__\__,_|\__\___(_)/ |___/
 * |_|                           |__/
 *
 * potato.js lib version 1.4.26
**/

/*
 MIT License

 Copyright (c) 2016 os-sc

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.

 */


function addContainer(container, parent) {

}

function fillContainer(phd, dataObj) {
    replaceAll('%phd%', phd);
    replaceAll('%phcontent%-', item);

}

function createContainer(phd, type, dataObj) {
    switch (type) {
        case 'CONTAINER_SURVEY_CARD':
            return fillContainer(phd, dataObj, CONTAINER_SURVEY_CARD);
    }
}

function createDataObject(jsonArr) {
    var dataObj = {
        names:  [],
        values: [],
        length: 0
    }
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(str) {
    return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

const CONTAINER_SURVEY_CARD = '' +
    '<div id="%phd%-survey-card" class="card-wide mdl-card mdl-shadow--2dp">' +
    '<div class="mdl-card__title">' +
    '<h2 class="mdl-card__title-text" id="%phd%-question-title">%phcontent%-question-title</h2>' +
    '</div>' +
    '<div class="mdl-card__supporting-text">' +
    '<form id="%phd%-survey-form">' +
    '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="%phd%-checkbox-0">' +
    '<input type="checkbox" id="%phd%-checkbox-0" class="mdl-checkbox__input">' +
    '<span class="mdl-checkbox__label" id="%phd%-answer-0-label">%phcontent%-answer-0</span>' +
    '</label>' +
    '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="%phd%-checkbox-1">' +
    '<input type="checkbox" id="%phd%-checkbox-1" class="mdl-checkbox__input">' +
    '<span class="mdl-checkbox__label" id="%phd%-answer-1-label">%phcontent%-answer-1</span>' +
    '</label>' +
    '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="%phd%-checkbox-2">' +
    '<input type="checkbox" id="%phd%-checkbox-2" class="mdl-checkbox__input">' +
    '<span class="mdl-checkbox__label" id="%phd%-answer-2-label">%phcontent%-answer-2</span>' +
    '</label>' +
    '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="%phd%-checkbox-3">' +
    '<input type="checkbox" id="%phd%-checkbox-3" class="mdl-checkbox__input">' +
    '<span class="mdl-checkbox__label" id="%phd%-answer-3-label">%phcontent%-answer-3</span>' +
    '</label>' +
    '</form>' +
    '</div>' +
    '<div class="mdl-card__actions mdl-card--border">' +
    '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="%phd%-vote-button">' +
    'Abstimmen' +
    '</button>' +
    '<button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect right"id="%phd%-results-button">' +
    'Resultate' +
    '</button>' +
    '</div>' +
    '<div class="mdl-card__menu">' +
    '<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect share" id="%phd%-share-button">' +
    '<i class="material-icons">share</i>' +
    '</button>' +
    '</div>' +
    '</div>';

