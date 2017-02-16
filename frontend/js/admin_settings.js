function msg_error(str) {
    var element = $("#info_error");
    element.show();
    element.text(str);
    element.delay(5000).fadeOut('slow');
}

function msg_success(str) {
    var element = $("#info_success");
    element.show();
    element.text(str);
    element.delay(5000).fadeOut('slow');
}

$("#save-settings").click(function () {
    var data = {};
    data.action = "changeSettings";
    $('.settings_value').each(function (i, obj) {
        var name = $(this).attr("settingname");
        data[name] = $(this).val();
    });

    $.ajax({
        url: 'api.php',
        type: "POST",
        async: true,
        data: data,
        success: function (data) {
            if (data == "OK") {
                msg_success("Einstellungen gespeichert!");
            } else {
                msg_error(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
});