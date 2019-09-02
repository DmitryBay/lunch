

// $.growl({ title: "Growl", message: "The kitten is awake!" });
// $.growl.error({ message: "The kitten is attacking!" });
// $.growl.notice({ message: "The kitten is cute!" });
// $.growl.warning({ message: "The kitten is ugly!" });


$('a.available-soon').click(function(e){
    e.preventDefault();

    $.growl.notice({ message: "Эта функция будет скоро доступна." });
});

function showError(xhr, code, text) {
    'use strict';
    if (xhr.responseJSON) {
        $.growl.error({message: 'Ошибка(' + xhr.status + '): ' + xhr.responseJSON.error_text});
    } else {
        $.growl.error({message: 'Ошибка(' + xhr.status + '): ' + text});
    }
}


$("img").on("error", function () {
    $(this).attr("src", "/img/no_image.jpg");
});
