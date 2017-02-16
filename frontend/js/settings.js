function check() {
    var ucase = new RegExp("[A-Z]+");
    var lcase = new RegExp("[a-z]+");
    var num = new RegExp("[0-9]+");
    var counter = 0;

    if ($("#password1").val().length >= 8) {
        $("#8char").removeClass("glyphicon-remove");
        $("#8char").addClass("glyphicon-ok");
        $("#8char").css("color", "#00A41E");
        counter++;
    } else {
        $("#8char").removeClass("glyphicon-ok");
        $("#8char").addClass("glyphicon-remove");
        $("#8char").css("color", "#FF0004");
        counter--;
    }

    if (ucase.test($("#password1").val())) {
        $("#ucase").removeClass("glyphicon-remove");
        $("#ucase").addClass("glyphicon-ok");
        $("#ucase").css("color", "#00A41E");
        counter++;
    } else {
        $("#ucase").removeClass("glyphicon-ok");
        $("#ucase").addClass("glyphicon-remove");
        $("#ucase").css("color", "#FF0004");
        counter--;
    }

    if (lcase.test($("#password1").val())) {
        $("#lcase").removeClass("glyphicon-remove");
        $("#lcase").addClass("glyphicon-ok");
        $("#lcase").css("color", "#00A41E");
        counter++;
    } else {
        $("#lcase").removeClass("glyphicon-ok");
        $("#lcase").addClass("glyphicon-remove");
        $("#lcase").css("color", "#FF0004");
        counter--;
    }

    if (num.test($("#password1").val())) {
        $("#num").removeClass("glyphicon-remove");
        $("#num").addClass("glyphicon-ok");
        $("#num").css("color", "#00A41E");
        counter++;
    } else {
        $("#num").removeClass("glyphicon-ok");
        $("#num").addClass("glyphicon-remove");
        $("#num").css("color", "#FF0004");
        counter--;
    }

    if ($("#password1").val() === $("#password2").val()) {
        $("#pwmatch").removeClass("glyphicon-remove");
        $("#pwmatch").addClass("glyphicon-ok");
        $("#pwmatch").css("color", "#00A41E");
    } else {
        $("#pwmatch").removeClass("glyphicon-ok");
        $("#pwmatch").addClass("glyphicon-remove");
        $("#pwmatch").css("color", "#FF0004");
    }

    if (counter >= 2) {
        return true;
    }
    return false;
}

$("input[type=password]").keyup(check);

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

$("#change-btn").click(function () {
    if ($("#password1").val() === $("#password2").val()) {
        if (check()) {
            $.ajax({
                url: 'api.php',
                type: "POST",
                async: true,
                data: {
                    'action': 'change_password_seassion',
                    'new_pw': $("#password2").val()
                },
                success: function (data) {
                    if (data === "OK") {
                        msg_success("Passwort erfolgreich geändert!");
                    } else {
                        msg_error(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        } else {
            msg_error("Es sind zu wenig Bedingungen erfüllt!");
        }
    } else {
        msg_error("Passwörter stimmen nicht überein!");
    }
});