

// $.growl({ title: "Growl", message: "The kitten is awake!" });
// $.growl.error({ message: "The kitten is attacking!" });
// $.growl.notice({ message: "The kitten is cute!" });
// $.growl.warning({ message: "The kitten is ugly!" });


function showError(xhr, code, text) {
    if (xhr.responseJSON) {
        $.growl.error({message: 'Error(' + xhr.status + '): ' + xhr.responseJSON.error_text});
    } else {
        $.growl.error({message: 'Error(' + xhr.status + '): ' + text});
    }
}