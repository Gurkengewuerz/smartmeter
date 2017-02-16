$(document).ready(function () {
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

    $("#insert_user").click(function (event) {
        $.ajax({
            url: 'api.php',
            type: "POST",
            async: true,
            data: {
                'action': 'add_user',
                'name': $("#usr").val(),
                'password': $("#pwd").val()
            },
            success: function (data) {
                if (data == "OK") {
                    msg_success("Benutzer erfolgreich eingefügt!");
                } else {
                    msg_error(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $(".delete-btn").click(function (event) {
        var element = $(this);
        $.ajax({
            url: 'api.php',
            type: "POST",
            async: true,
            data: {
                'action': 'remove_user',
                'name': element.attr("where")
            },
            success: function (data) {
                if (data == "OK") {
                    msg_success("Benutzer erfolgreich gelöscht!");
                    element.closest("tr").remove();
                } else {
                    msg_error(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    $(".edit-btn").click(function () {
        var element = $(this);
        $('#edit-modal').modal('show');
        $('#modal-name').val(element.attr("where"));
        $('#modal-rank').val(element.attr("rank"));
    });

    $("#modal-save").click(function () {
        $.ajax({
            url: 'api.php',
            type: "POST",
            async: true,
            data: {
                'action': 'change_rank',
                'name': $('#modal-name').val(),
                'new_rank': $('#modal-rank').val()
            },
            success: function (data) {
                if (data == "OK") {
                    msg_success("Benutzer erfolgreich bearbeitet!");
                } else {
                    msg_error(data);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

});
