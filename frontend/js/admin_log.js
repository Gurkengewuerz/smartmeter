function refreshLog() {
    $.ajax({
        url: 'api.php',
        type: "POST",
        async: true,
        data: {
            'action': 'logs'
        },
        success: function (data) {
            $("#console").text(data);
            $('#console').scrollTop($('#console')[0].scrollHeight);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });
}

refreshLog();
setInterval(function () {
    refreshLog();
}, 60000);

$("#refresh").click(function () {
    refreshLog();
});