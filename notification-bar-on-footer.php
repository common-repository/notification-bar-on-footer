<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.topinfosoft.com/about
 * @since             1.0.1
 * @package           Notification_Bar_On_Footer
 *
 * @wordpress-plugin
 * Plugin Name:       Notification bar on footer
 * Plugin URI:        http://www.topinfosoft.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            Top Infosoft
 * Author URI:        http://www.topinfosoft.com/about
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       notification-bar-on-footer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NOTIFICATION_BAR_ON_FOOTER_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-notification-bar-on-footer-activator.php
 */
function activate_notification_bar_on_footer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-notification-bar-on-footer-activator.php';
	Notification_Bar_On_Footer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-notification-bar-on-footer-deactivator.php
 */
function deactivate_notification_bar_on_footer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-notification-bar-on-footer-deactivator.php';
	Notification_Bar_On_Footer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_notification_bar_on_footer' );
register_deactivation_hook( __FILE__, 'deactivate_notification_bar_on_footer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-notification-bar-on-footer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_notification_bar_on_footer() {

	$plugin = new Notification_Bar_On_Footer();
	$plugin->run();
	

}
run_notification_bar_on_footer();


//  1ST  ############################## create database //##############################
// create custom database
global $nbof_db_version;
$nbof_notification_db_version = '1.0';


function nbofDb()
{

global $wpdb;
global $nbof_db_version;
$nbof_table_name = $wpdb->prefix . 'notification_bar_footer';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $nbof_table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		align varchar(55) DEFAULT '' NOT NULL,
		background_color varchar(55) DEFAULT '' NOT NULL,
		text_color varchar(55) DEFAULT '' NOT NULL,
		text_size varchar(55) DEFAULT '' NOT NULL,
		notification_text varchar(255) DEFAULT '' NOT NULL,
		button_color varchar(55) DEFAULT '' NOT NULL,
		button_text_color varchar(55) DEFAULT '' NOT NULL,
		button_text_size varchar(55) DEFAULT '' NOT NULL,
		button_text varchar(55) DEFAULT '' NOT NULL,
		button_url varchar(55) DEFAULT '' NOT NULL,
		button_hide varchar(55) DEFAULT '' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
    add_option('nbof_db_version', $nbof_db_version);

    $wpdb->query($wpdb->prepare("DELETE FROM $nbof_table_name"));
        $wpdb->insert($nbof_table_name,
            array(
                // 'ip' => UserInfo::get_ip(),
                'align' => '1',
                'background_color' => '#cd2653',
                'text_color' => '#000000',
                'text_size' => 12,
                'notification_text' => 'Hello Everyone, Welcome to our website.',
                'button_color' => '#ffffff',
                'button_text_color' => '#000000',
                'button_text_size' => 12,
                'button_text' => 'button',
                'button_url' => 'http://www.topinfosoft.com',
                'button_hide' => '1'
            )
        );


}
// register hook
register_activation_hook(__FILE__, 'nbofDb');
//############################## create database //##############################


//   2ND   ############################## show menu at admin //##############################
add_action('admin_menu', 'nbof_nofitication_menu');
function nbof_nofitication_menu()
{
    add_options_page('Notification Footer', 'Footer Notification', 'manage_options', 'notification-footer', 'nbof_plugin_options');
}

// Code or form that will be shown there on the menu we created above  nbof_nofitication_menu
function nbof_plugin_options()
{
?>
<style type="text/css">
.myWrap{width:90%; background-color: #fff; padding: 10px 20px 20px 20px;}
.myInput{background-color: white; border:none; border-radius:3px; font-size:12px; padding: 6px 10px; border: 1px solid}
.myWrap label{min-width: 120px;display: inline-block;}
.myWrap input[type="number"]{margin-right: 30px; width: 158px;}
.myWrap input[type=text]{margin-right: 33.4px;}	
.myWrap input.bigtext{width: 80%;}
.myWrap div{margin: 2px 4px;}
button.button.wp-color-result{width: 157px; margin-left: -3px !important;}
</style>
<div class="wrap">
<div class="myWrap">
<h2>Notification on Footer</h2>
<p>Notification comes on footer when you scroll down your web page and hide back when scroll up. The settings for this plugin is liested under settings->Footer Notification - You can customize the notification from there. </p>
<form method="post">
<input name="notificationstyle" type="hidden" value="<?php echo wp_create_nonce('notification-style'); ?>" />
    <?php 
    global $wpdb;
    $nbof_table_name = $wpdb->prefix . 'notification_bar_footer';
    $results = $wpdb->get_results("SELECT * FROM $nbof_table_name");
    foreach ($results as $row) {
    // echo $row->align;
    ?>
<div>
<label>Notification Text </label><input class="bigtext" type="text" name="notification_text" value="<?php echo esc_attr($row->notification_text); ?>">
</div>
<div>
<label>Button Link </label><input class="bigtext" type="text" name="button_url" value="<?php echo esc_attr($row->button_url); ?>">
</div>
<div>
<label>Button Label </label><input type="text" name="button_text" value="<?php echo esc_attr($row->button_text); ?>">
</div>


<h4>Other Settings</h4>         
<div>
<label>Hide Button </label><input type="number" name="button_hide" value="<?php echo esc_attr($row->button_hide); ?>" min="0" max="1"> <span>0 = To Hide Button, 1 = To Show Button</span>
</div>
<div>
<label>Alignment </label><input type="number" name="align" value="<?php echo esc_attr($row->align); ?>" min="1" max="3"> <span>1 = Center, 2 = Left side, 3 = Right side</span>
</div>
<h4>Size Settings</h4> 
<div>
<label>Text Size </label><input type="number" name="text_size" value="<?php echo esc_attr($row->text_size); ?>"> <span>Font size in Pixel</span>
</div>
<div>
<label>Button Text Size </label><input type="number" name="button_text_size" value="<?php echo esc_attr($row->button_text_size); ?>"> <span>Button Font size in Pixel</span>
</div>
<h4>Color Settings</h4> 
<div>
<label>Background Color </label><input type="text" name="background_color" value="<?php echo esc_attr($row->background_color); ?>" id="background_color" class="background_color" data-default-color="#effeff">
</div>
<div>
<label>Text Color </label><input type="text" name="text_color" value="<?php echo esc_attr($row->text_color); ?>" id="text_color"class="text_color" data-default-color="#effeff">
</div>
<div>
<label>Button Color </label><input type="text" name="button_color" value="<?php echo esc_attr($row->button_color); ?>" id="button_color" id="button_color" data-default-color="#effeff">
</div>
<div>
<label>Button Text Color </label><input type="text" name="button_text_color" value="<?php echo esc_attr($row->button_text_color); ?>" id="button_text_color" class="button_text_color" data-default-color="#effeff">
</div>

<input type="submit" name="submit" value="Save Changes" class="myInput" onClick="window.location.reload()">
<?php 
}
 ?>
</form>
</div>
</div>
<?php }


//    3RD    ############################## color picker //##############################
// Wordpress function 1
add_action( 'admin_enqueue_scripts', 'nbof_enqueue_color_picker_notification' );
function nbof_enqueue_color_picker_notification( $hook_suffix ) {
// first check that $hook_suffix is appropriate for your admin page
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'nbof-colorpicker', plugins_url('admin/js/cfzc-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

// color picket 2
// <label>H1 Color</label><input type="text" name="h1color" value="#bada55" class="my-color-field" data-default-color="#effeff">

// color picket 3
// goto admin/js/cfzc-script.js
//############################## color picker //##############################


//   4TH     ############################## VIEW SECTION OF FRONT  ############################### //
// Front end - Functionality 
function nbof_notification() {
global $wpdb;
$nbof_table_name = $wpdb->prefix . 'notification_bar_footer';
$results = $wpdb->get_results("SELECT * FROM $nbof_table_name");
foreach ($results as $row) {
if($row->align == '2')
{
	$align = 'left';
}
elseif($row->align == '3')
{
	$align = 'right';
}
else
{
	$align = 'center';
}
?>
<style type="text/css" media="screen">
	.nbof_bottomMenu {
    display: none;
    position: fixed;
    bottom: 0;
    width: 100%;
    z-index: 1;
    border-top: 1px solid #000;
    padding: 10px 30px;
    background: <?php echo esc_html($row->background_color); ?>;
    color: <?php echo esc_html($row->text_color); ?>;
    font-size: <?php echo esc_html($row->text_size); ?>;
	}
	.nbof_bottomMenu a{
    padding: 5px 10px;
    text-decoration: none;
    cursor: pointer;
    background: <?php echo esc_html($row->button_color); ?>;
    color: <?php echo esc_html($row->button_text_color); ?>;
    font-size: <?php echo esc_html($row->button_text_size); ?>;
	}

</style>
<div class="nbof_bottomMenu" align="<?php echo esc_html($align); ?>"><?php echo esc_html($row->notification_text); ?> <a id="nbof_btn" href="<?php echo esc_html($row->button_url); ?>" target="_blank"><?php echo esc_html($row->button_text); ?></a></div>
<?php
}
}
add_action('wp_footer', 'nbof_notification');


//   5TH     ############################## INSERT RECORD  ############################### //
function nbof_colorPickerInsert()
{
    global $wpdb;
    // if (!current_user_can('manage_options')) {
    //     wp_die(__('You do not have sufficient permissions to access this page.'));
    // }
    // include plugin_dir_path(__FILE__) . 'includes/UserInfo.php';
if(isset($_POST['submit']))
{
    $nbof_table_name = $wpdb->prefix . 'notification_bar_footer';
if (!isset($_POST['notificationstyle'])) die("<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! ");
if (!wp_verify_nonce($_POST['notificationstyle'],'notification-style')) die("<br><br>Hmm .. looks like you didn't send any credentials.. No CSRF for you! ");
    $wpdb->query($wpdb->prepare("DELETE FROM $nbof_table_name"));
        $wpdb->insert($nbof_table_name,
            array(
            	// 'ip' => UserInfo::get_ip(),
            	'align' => sanitize_text_field($_POST['align']),
            	'background_color' => sanitize_hex_color($_POST['background_color']),
            	'text_color' => sanitize_hex_color($_POST['text_color']),
            	'text_size' => sanitize_text_field($_POST['text_size']),
            	'notification_text' => sanitize_text_field($_POST['notification_text']),
            	'button_color' => sanitize_hex_color($_POST['button_color']),
            	'button_text_color' => sanitize_hex_color($_POST['button_text_color']),
            	'button_text_size' => sanitize_text_field($_POST['button_text_size']),
            	'button_text' => sanitize_text_field($_POST['button_text']),
            	'button_url' => sanitize_text_field($_POST['button_url']),
            	'button_hide' => sanitize_text_field($_POST['button_hide']))
        );
}
}
// nbof_colorPickerInsert();
// register_activation_hook(ini, 'nbof_colorPickerInsert');
add_action ( 'admin_init', 'nbof_colorPickerInsert');

