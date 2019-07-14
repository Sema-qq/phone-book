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
        
        if ($form.find('input').is('#image')) {
            var data = new FormData();
            data.append('image', document.getElementById('image').files[0]);
        } else {
            var data = $form.serializeArray();
        }

        $.ajax({
            url: $form.attr('action'),
            type: "POST",
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "html",
            success: function (response) {
                $('div.starter-template').html(response);
                linkHandler();
                submitHandler();
            }
        });

        e.preventDefault();
        return false;
    });
}
