$(document).ready(function() {
    $('#btn-clone').hide();

    $('#select_all_projects').change(function() {
        if($(this).is(":checked")) {
            console.log('Select all');
            selectAll();
        } else {
            console.log('Unselect all');
            unselectAll();
        }
    });

    $(this).find(':checkbox').change(function() {
        var n = $('#data-list').find(':checkbox:checked').length;
        if (n == 1) {
            $('#btn-clone').show();
        } else {
            $('#btn-clone').hide();
        }
        // console.log('Checked: ', n);
    });

    function selectAll() {
        var checkboxes = $('#data-list').find(':checkbox');
        checkboxes.prop('checked', true);
    }

    function unselectAll() {
        var checkboxes = $('#data-list').find(':checkbox');
        checkboxes.prop('checked', false);
    }
});
