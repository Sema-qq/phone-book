$(document).ready(function () {
    linkHandler();
    submitHandler();
});

/**
 * Устанавливает обработчики на все ссылки
 */
function linkHandler() {
    let $links = $('div.starter-template a');

    // отменим предыдущие обработчики
    $links.off('click');
    // навесим новые обработчики
    $links.on('click', function (e) { // остановим ссылки и сходим на них сами
        $.get($(this).attr('href'), {}, function (response) {
            setContent(response)
        });

        return false;
    })
}

/**
 * Устанавливает обработчики на все отправки форм
 */
function submitHandler() {
    let $main = $('div.starter-template');

    // отменим предыдущие обработчики
    $main.off('submit');
    // навесим новые обработчики
    $main.on('submit', function (e) {
        let $this = $(this),
            $form = $this.find('form').first();
        
        // если есть загрузка изображений, то соберем форм дату и установим нужне параметры для аякса
        if ($form.find('input').is('#image')) {
            let data = new FormData();
            data.append('image', document.getElementById('image').files[0]);

            $.ajax({
                url: $form.attr('action'),
                type: "POST",
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "html",
                success: function (response) {
                    setContent(response)
                }
            });
        } else { // иначе отправим простой пост запрос
            $.post($form.attr('action'), $form.serializeArray(), function (response) {
                setContent(response)
            })
        }

        e.preventDefault();
        return false;
    });
}

/**
 * Вставляет контент в блок с контентом
 * @param {html} content
 */
function setContent(content) {
    $('div.starter-template').html(content);

    linkHandler();
    submitHandler();
}
