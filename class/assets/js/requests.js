jQuery(document).ready(function () {
    jQuery("#form-save-options").ajaxForm({
        beforeSend: function () {
            jQuery('#dnzBtnForm').val('Processing...');
        },
        success: function (responseText) {
            jQuery('#dnzMsgForm').html('<div id="message" class="updated notice is-dismissible"><p>Successfully saved data!.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notification.</span></button></div> ');
        },
        complete: function () {
            jQuery('#dnzBtnForm').val('Save options');
        }
    });
});