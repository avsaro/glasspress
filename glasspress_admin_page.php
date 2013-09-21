<?php

if ($_POST['glasspress-action'] == 'edit-config') {
    $option_name = 'glasspress_api_client_id';
    update_option($option_name, $_POST['api_client_id']);
    
    $option_name = 'glasspress_api_client_secret';
    update_option($option_name, $_POST['api_client_secret']);
    
    $option_name = 'glasspress_api_key';
    update_option($option_name, $_POST['api_key']);
}

?>

<div>
    <form method="POST" action="">
        <label for="api_client_id">API Client ID:</label>
        <input type="text" name="api_client_id" id="api_client_id" value="<?php echo get_option('glasspress_api_client_id'); ?>" />
        <br />
        
        <label for="api_client_secret">API Client Secret:</label>
        <input type="text" name="api_client_secret" id="api_client_secret" value="<?php echo get_option('glasspress_api_client_secret'); ?>" />
        <br />
        
        <label for="api_key">API Key:</label>
        <input type="text" name="api_key" id="api_key" value="<?php echo get_option('glasspress_api_key'); ?>" />
        <br />
        
        <input type="hidden" name="glasspress-action" value="edit-config" />
        <input type="submit" value="Submit"/>
    </form>
</div>
