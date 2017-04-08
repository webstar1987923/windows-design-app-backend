function getJwtToken() {
    var d = $.Deferred();
    var token, user;
    $.ajax({
        dataType: "json",
        url: window.prossimo.api_base_path + '/admin/security/token',
        success: function (data, textStatus) {
            d.resolve({
                success: true,
                data: {
                    token: data.token,
                    user: data.user
                }
            });
        },
        error: function(error, txtStatus) {
            d.resolve({
                success: false,
                errors: txtStatus
            });
            console.log('GetJwtToken error: ', txtStatus);
        }
    });

    return d.promise();
}

function tokenReceiveError(data) {
    console.log('Error: data:', data);
}
