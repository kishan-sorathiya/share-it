jQuery(document).ready(function () {
    // Open popup for copy sharable link
    jQuery(document).on('click', '.share', function (event) {
        event.preventDefault();
        var popup = jQuery("#share_file_popup");
        if (popup.length  > 0  && jQuery(this).length > 0)
        {
            jQuery("#sharable-file-link").val(jQuery(this).attr('data-share-url'));
            popup.modal('show');
        }
        return false;
    });
    // Click event for copy link
    jQuery(document).on('click', '#copy_sharable_link', function (event) {
        event.preventDefault();
        var link = jQuery("#sharable-file-link").val();
        if(link.length > 0)
        {
            jQuery("#sharable-file-link").select();
            document.execCommand("copy");
        }
        return false;
    });
    // Delete confirmation box
    jQuery(document).on('click', '.delete', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if(value) {
                jQuery('#delete-record').attr('action',url);
                jQuery('#delete-record').submit();
            }
        });
    });
});