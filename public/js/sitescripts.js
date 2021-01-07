var result = 0;
$(document).ready(function () {
    makeCapchar();

});
function validateForm() {
    checkCapchar();
    if ($('#form-login')[0].checkValidity() === false) {
        event.preventDefault(); //Chặn không cho gửi form đi
        event.stopPropagation(); //Ngưng các sự kiện được kế thừa
    }
    $('#form-login').addClass('was-validated'); //addClass(): thêm một class vào một tag
}
function makeCapchar() {
    var operator = getRandomIntInclusive(0, 1) == 0 ? '+' : '-';
    var capChar = getRandomIntInclusive(0, 99) + operator + getRandomIntInclusive(0, 99);
    $('.makeCapchar').text(capChar);

}
function checkCapchar() {
    result = eval($('.makeCapchar').text());
    var input = $('#capchar').val();
    if (result == input) {
        $('#capchar')[0].setCustomValidity('');
        return true;
    }
    else {
        $('#capchar')[0].setCustomValidity('sai');
        return false;
    }

};
function getRandomIntInclusive(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min; //The maximum is inclusive and the minimum is inclusive 
}







/*
function validateForm() {
    if (validateUsername() & validateMSSV()) {
        return true;
    }
    else {
        return false;
    }
}

function validateUsername() {
    var filter = /^.{6,}$/;
    var input = $('#username').val();
    if(filter.test(input) === false) {
        alert('Nhap sai username');
        return false;
    }
    else {
        return true;
    }
}

function validateMSSV() {
    var filter = /^\d{5}[Tt]{2}\d{4}$/;
    var input = $('#mssv').val();
    if(filter.test(input) === false) {
        alert('Nhap sai mssv');
        return false;
    }
    else {
        return true;
    }
}
*/