$(document).ready(function () {
    $('.js-captcha-img').on('click', function () {
        $(this).get(0).src = '/auth/captcha?' + Math.random();
    });
});
