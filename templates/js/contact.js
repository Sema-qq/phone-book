$(document).ready(function () {
    linkHandler();
    submitHandler();
});

function linkHandler() {
    $('div.starter-template a').on('click', function () {
        $.get($(this).attr('href'), {}, function (response) {
            $('div.starter-template').html(response);
            linkHandler();
            submitHandler();
        });


        return false;
    })
}

function submitHandler() {
    $('div.starter-template').on('submit', function (e) {
        let $this = $(this),
            $form = $this.find('form').first();
        
        $.post($form.attr('action'), $form.serializeArray(), function (response) {
            $('div.starter-template').html(response);
            linkHandler();
            submitHandler();
        });


        e.preventDefault();
        return false;
    });
}
