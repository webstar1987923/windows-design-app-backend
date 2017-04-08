function linkFilesToUser(userId, fileUuids, redirect) {
    if (userId && fileUuids && Array.isArray(fileUuids)) {
        _linkFilesToUserOrProject(
            window.prossimo.api_base_path + '/admin/files/link_user_files/' + userId,
            fileUuids,
            redirect
        );
    }
}

function linkFilesToProject(projectId, fileUuids, redirect) {
    if (projectId && fileUuids && Array.isArray(fileUuids)) {
        _linkFilesToUserOrProject(
            window.prossimo.api_base_path + '/admin/files/link_project_files/' + projectId,
            fileUuids,
            redirect
        );
    }
}

function _linkFilesToUserOrProject(url, fileUuids, redirect) {
    $.ajax({
        method: "POST",
        dataType: "json",
        contentType: 'application/json; charset=UTF-8',
        url: url,
        data: JSON.stringify(fileUuids),
        success: function (data, textStatus) { // вешаем свой обработчик на функцию success
            console.log('data:',data);
            if (redirect) {
                window.location.replace(redirect);
            }
        },
        error: function(error, txtStatus) {
            console.log('_linkFilesToUserOrProject error: ', txtStatus);
        }
    });
}