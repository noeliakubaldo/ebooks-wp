jQuery(document).ready(function($) {
    $('#import-theme-mods').click(function(e) {
        e.preventDefault();

        // Display loading text
        $('#import-response').text('Importing theme mods...');

        // Make the AJAX request
        $.ajax({
            url: demoImporter.ajax_url,
            type: 'post',
            data: {
                action: 'import_theme_mods',
                _ajax_nonce: demoImporter.nonce
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                    // $('#import-response').text(response.data.msg);
                    // window.open(response.data.redirect, '_blank')
                } else {
                    $('#import-response').text('Error: ' + response.data);
                }
            },
            error: function(xhr, status, error) {
                $('#import-response').text('AJAX error: ' + error);
            }
        });
    });
});