function msg_error(str) {
    var element = $("#info_error");
    element.show();
    element.text(str);
    element.delay(5000).fadeOut('slow');
}

$("#login").click(function () {
    $.ajax({
        url: 'api.php',
        type: "POST",
        async: true,
        data: {
            'action': 'check_login',
            'name': $("#username").val(),
            'password': $("#password").val()
        },
        success: function (data) {
            if (data === "OK") {
                document.location.href = "index.php";
            } else {
                msg_error(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

});