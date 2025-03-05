<?php
/**
 * @package Demo
 * @version 1.0
 */
/*
Plugin Name: Demo
Plugin URI: http://wordpress.org/plugins/demo
Description: First WordPress plugin Demo with Tarteaucitron.js configuration.
Author: Karim Oujid
Version: 1.0
Author URI: https://youtu.be/dQw4w9WgXcQ?si=8nbziXDsUd9h56oq
Text Domain: demo
Domain Path: /languages
*/

function demo_load_textdomain() {
    load_plugin_textdomain('demo', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'demo_load_textdomain');

function tarteaucitron_register_settings() {
    register_setting(
        'tarteaucitron_settings_group',
        'tarteaucitron_options',
        array('sanitize_callback' => 'tarteaucitron_sanitize_options')
    );
}
add_action('admin_init', 'tarteaucitron_register_settings');

function tarteaucitron_sanitize_options($input) {
    $output = array();
    $output['hashtag'] = sanitize_text_field($input['hashtag'] ?? '#tarteaucitron');
    $output['highPrivacy'] = isset($input['highPrivacy']) && $input['highPrivacy'] ? 1 : 0;
    $output['AcceptAllCta'] = isset($input['AcceptAllCta']) && $input['AcceptAllCta'] ? 1 : 0;
    $output['orientation'] = in_array($input['orientation'] ?? 'top', array('top', 'bottom')) ? $input['orientation'] : 'top';
    $output['adblocker'] = isset($input['adblocker']) && $input['adblocker'] ? 1 : 0;
    $output['showAlertSmall'] = isset($input['showAlertSmall']) && $input['showAlertSmall'] ? 1 : 0;
    $output['cookieslist'] = isset($input['cookieslist']) && $input['cookieslist'] ? 1 : 0;
    return $output;
}

function tarteaucitron_add_settings_fields() {
    add_settings_section(
        'tarteaucitron_main_section',
        __('Tarteaucitron.js Initialization Settings', 'demo'),
        'tarteaucitron_section_callback',
        'tarteaucitron'
    );

    add_settings_field(
        'tarteaucitron_hashtag',
        __('Hashtag', 'demo'),
        'tarteaucitron_hashtag_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );

    add_settings_field(
        'tarteaucitron_high_privacy',
        __('High Privacy', 'demo'),
        'tarteaucitron_high_privacy_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );

    add_settings_field(
        'tarteaucitron_accept_all_cta',
        __('Accept All CTA', 'demo'),
        'tarteaucitron_accept_all_cta_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );

    add_settings_field(
        'tarteaucitron_orientation',
        __('Orientation', 'demo'),
        'tarteaucitron_orientation_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );

    add_settings_field(
        'tarteaucitron_adblocker',
        __('Adblocker', 'demo'),
        'tarteaucitron_adblocker_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );

    add_settings_field(
        'tarteaucitron_show_alert_small',
        __('Show Alert Small', 'demo'),
        'tarteaucitron_show_alert_small_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );

    add_settings_field(
        'tarteaucitron_cookieslist',
        __('Cookies List', 'demo'),
        'tarteaucitron_cookieslist_field',
        'tarteaucitron',
        'tarteaucitron_main_section'
    );
}
add_action('admin_init', 'tarteaucitron_add_settings_fields');

function tarteaucitron_section_callback() {
    echo '<p>' . __('Fill in the contents of the Tarteaucitron.js initialization scripts.', 'demo') . '</p>';
}

function tarteaucitron_hashtag_field() {
    $options = get_option('tarteaucitron_options');
    $value = $options['hashtag'] ?? '#tarteaucitron';
    echo '<input type="text" name="tarteaucitron_options[hashtag]" value="' . esc_attr($value) . '" />';
    echo '<p class="description">' . __('Automatically open the panel with the hashtag', 'demo') . '</p>';
}

function tarteaucitron_high_privacy_field() {
    $options = get_option('tarteaucitron_options');
    $value = isset($options['highPrivacy']) ? $options['highPrivacy'] : 1;
    echo '<select name="tarteaucitron_options[highPrivacy]">';
    echo '<option value="1" ' . selected($value, 1, false) . '>True</option>';
    echo '<option value="0" ' . selected($value, 0, false) . '>False</option>';
    echo '</select>';
    echo '<p class="description">' . __('Disabling the auto consent feature on navigation?', 'demo') . '</p>';
}

function tarteaucitron_accept_all_cta_field() {
    $options = get_option('tarteaucitron_options');
    $value = isset($options['AcceptAllCta']) ? $options['AcceptAllCta'] : 1;
    echo '<select name="tarteaucitron_options[AcceptAllCta]">';
    echo '<option value="1" ' . selected($value, 1, false) . '>True</option>';
    echo '<option value="0" ' . selected($value, 0, false) . '>False</option>';
    echo '</select>';
    echo '<p class="description">' . __('Show the accept all button when highPrivacy on', 'demo') . '</p>';
}

function tarteaucitron_orientation_field() {
    $options = get_option('tarteaucitron_options');
    $value = $options['orientation'] ?? 'top';
    echo '<select name="tarteaucitron_options[orientation]">';
    echo '<option value="top" ' . selected($value, 'top', false) . '>Top</option>';
    echo '<option value="bottom" ' . selected($value, 'bottom', false) . '>Bottom</option>';
    echo '</select>';
    echo '<p class="description">' . __('The big banner should be on \'top\' or \'bottom\'?', 'demo') . '</p>';
}

function tarteaucitron_adblocker_field() {
    $options = get_option('tarteaucitron_options');
    $value = isset($options['adblocker']) ? $options['adblocker'] : 0;
    echo '<select name="tarteaucitron_options[adblocker]">';
    echo '<option value="1" ' . selected($value, 1, false) . '>True</option>';
    echo '<option value="0" ' . selected($value, 0, false) . '>False</option>';
    echo '</select>';
    echo '<p class="description">' . __('Display a message if an adblocker is detected', 'demo') . '</p>';
}

function tarteaucitron_show_alert_small_field() {
    $options = get_option('tarteaucitron_options');
    $value = isset($options['showAlertSmall']) ? $options['showAlertSmall'] : 0;
    echo '<select name="tarteaucitron_options[showAlertSmall]">';
    echo '<option value="1" ' . selected($value, 1, false) . '>True</option>';
    echo '<option value="0" ' . selected($value, 0, false) . '>False</option>';
    echo '</select>';
    echo '<p class="description">' . __('Show the small banner on bottom/top right?', 'demo') . '</p>';
}

function tarteaucitron_cookieslist_field() {
    $options = get_option('tarteaucitron_options');
    $value = isset($options['cookieslist']) ? $options['cookieslist'] : 0;
    echo '<select name="tarteaucitron_options[cookieslist]">';
    echo '<option value="1" ' . selected($value, 1, false) . '>True</option>';
    echo '<option value="0" ' . selected($value, 0, false) . '>False</option>';
    echo '</select>';
    echo '<p class="description">' . __('Display the list of cookies installed?', 'demo') . '</p>';
}

function add_menu_tarteaucitron() {
    add_menu_page(
        __('Tarteaucitron', 'demo'),
        __('Tarteaucitron', 'demo'),
        'manage_options',
        'tarteaucitron',
        'tarteaucitron_admin_page',
        'dashicons-admin-generic'
    );
}
add_action('admin_menu', 'add_menu_tarteaucitron');

function tarteaucitron_admin_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('Tarteaucitron.js Parameters', 'demo'); ?></h1>
        <form method="post" action="options.php" class="tarteaucitron-config-form">
            <?php
            settings_fields('tarteaucitron_settings_group');
            do_settings_sections('tarteaucitron');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function tarteaucitron_enqueue_styles() {
    wp_enqueue_style('tarteaucitron-admin-style', plugin_dir_url(__FILE__) . 'css/tarteaucitron-admin.css');
}
add_action('admin_enqueue_scripts', 'tarteaucitron_enqueue_styles');

function tarteaucitron() {
    wp_enqueue_script('tarteaucitron-js', "https://cdn.jsdelivr.net/npm/tarteaucitronjs@1.19.0/tarteaucitron.min.js", array(), null, false);
}
add_action('wp_enqueue_scripts', 'tarteaucitron');

function addScript() {
    $options = get_option('tarteaucitron_options');
    ?>
    <script type="text/javascript">
        tarteaucitron.init({
            "privacyUrl": "",
            "bodyPosition": "top",
            "hashtag": "<?php echo esc_js($options['hashtag'] ?? '#tarteaucitron'); ?>",
            "cookieName": "tarteaucitron",
            "orientation": "<?php echo esc_js($options['orientation'] ?? 'middle'); ?>",
            "groupServices": true,
            "showDetailsOnClick": true,
            "serviceDefaultState": "wait",
            "showAlertSmall": <?php echo $options['showAlertSmall'] ? 'true' : 'false'; ?>,
            "cookieslist": <?php echo $options['cookieslist'] ? 'true' : 'false'; ?>,
            "closePopup": true,
            "showIcon": true,
            "iconPosition": "BottomRight",
            "adblocker": <?php echo $options['adblocker'] ? 'true' : 'false'; ?>,
            "DenyAllCta": true,
            "AcceptAllCta": <?php echo $options['AcceptAllCta'] ? 'true' : 'false'; ?>,
            "highPrivacy": <?php echo $options['highPrivacy'] ? 'true' : 'false'; ?>,
            "alwaysNeedConsent": false,
            "handleBrowserDNTRequest": false,
            "removeCredit": false,
            "moreInfoLink": true,
            "useExternalCss": false,
            "useExternalJs": false,
            "googleConsentMode": true,
            "partnersList": true
        });
    </script>
    <?php
}
add_action('wp_head', 'addScript');