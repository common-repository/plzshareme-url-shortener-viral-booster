<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
/*
* Plugin Name: PlzShare.Me Url Shortener & Viral Booster
* Description: Shorten your posts and generate social/viral activity at the same time. This plugin does several things at once: It will instantly shorten any post you create with the social friendly url PlzShare.Me, it adds social sharing buttons and social subscription/follow/like widgets to help you gain new followers, plus your shortened posts will be shared on the PlzShare.Me social network to help boost your website traffic through organic and viral discovery (also excellent for SEO).
* Version: 1.5
* Author: Paul Keller
* Author URI: http://plzshare.me/
* Text Domain: plzshare.me
* Tested up to: 4.6.1
* Stable tag: 1.5
* License: GPLv3
* Tags: plzshareme, followers, likes, share, social, facebook, twitter, reddit, pinterest, google, viral, traffic, boost, url, shortener, subscription, subscribe, widgets, seo, campaigns, vine, instagram, please
*/



add_filter( 'plugin_row_meta', 'plzshareme_plugin_row_meta', 10, 2 );
function plzshareme_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'plzshareme_shorturl.php' ) !== false ) {
		$new_links = array(
					'<a href="http://plzshare.me/blog/" target="_blank">Plugin Home</a>',
				);
		$links = array_merge( $links, $new_links );
	}	
	return $links;
}


// Add your API from the website plzshare.me
$var_Apikey = get_option('new_Api_key');
define('DEFAULT_API_URL', 'http://plzshare.me/api?api='.$var_Apikey.'&format=text&url=%s');
define('plzshareme_plugin_path', plugin_dir_path(__FILE__) );
define('plzshareme_plugin_url', plugin_dir_url(__FILE__) );
/* returns results */
if ( ! function_exists( 'curl_get_url' ) ){
  function curl_get_url($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
 }
}
if ( ! function_exists( 'get_plzshareme_url' ) ){ 
function get_plzshareme_url($url,$format='txt') {
   global $var_Apikey;
   $connectURL = 'http://plzshare.me/api?api='.$var_Apikey.'&format=text&url='.$url;
   return curl_get_url($connectURL);   
 }
}

if ( ! function_exists( 'plzshareme_show_url' ) ){
 function plzshareme_show_url($showurl) { 
  $url_create = get_plzshareme_url(get_permalink( $id ));
  $kshort .= '<a href="'.$url_create.'" target="_blank">'.$url_create.'</a>';
  return $kshort;
 }
}
if ( ! function_exists( 'plzshareme_shortcode_handler' ) ){
 function plzshareme_shortcode_handler( $atts, $text = null, $code = "" ) {
	extract( shortcode_atts( array( 'u' => null ), $atts ) );	
	$url = get_plzshareme_url( $u );
	$rurl = plzshareme_show_url($showurl); 
	if( !$u )
		return $rurl;
	if( !$text )
		return '<a href="' .$url. '">' .$url. '</a>';	
	return '<a href="' .$url. '">' .$text. '</a>';
 }
}
add_shortcode('plzshareme-url', 'plzshareme_shortcode_handler');
class plzshareme_Short_URL
{
    const META_FIELD_NAME='Shorter link';		
    /**
     * List all urls shortened in your account
     */
    function api_urls()
    {
		$var_Apikey = get_option('new_Api_key');
        return array(
            array(
                'name' => 'plzshare.me Safe Url Shortener',
                'url'  => 'http://plzshare.me/api?api='.$var_Apikey.'&format=text&url=%s',
                )
            );
    }

    /**
     * Create shortened plzshare.me link
     */
    function create($post_id)
    {
        if (!$apiURL = get_option('plzsharemeShortUrlApiUrl')) {
            $apiURL = DEFAULT_API_URL;
        }
        $post = get_post($post_id);
        $pos = strpos($post->post_name, 'autosave');
        if ($pos !== false) {
            return false;
        }
        $pos = strpos($post->post_name, 'revision');
        if ($pos !== false) {
            return false;
        }
		// for imported files TBD
        $apiURL = str_replace('%s', urlencode(get_permalink($post_id)), $apiURL);
        $result = false;
        if (ini_get('allow_url_fopen')) {
            if ($handle = @fopen($apiURL, 'r')) {
                $result = fread($handle, 4096);
                fclose($handle);
            }
        } elseif (function_exists('curl_init')) {
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $result = @curl_exec($ch);
            curl_close($ch);
        }
        if ($result !== false) {
            delete_post_meta($post_id, 'plzsharemeShortURL');
            $res = add_post_meta($post_id, 'plzsharemeShortURL', $result, true);
            return true;
        }
    }

    /**
     * Option list (default settings)
     */
    
    function options()
    {
        return array(
           'ApiUrl'         => DEFAULT_API_URL,
           'Display'        => 'Y',
           'TwitterLink'    => 'Y',
		   'Domain'			=> 'plzshare.me',
		   'TwitterTag'     => 'plzshareme',
		   'FacebookTag'    => 'plzshareme',
		   'GoogleTag'   	=> 'plzshareme',
		   'PinterestTag'	=> 'plzshareme'
           );
    }
    
    /**
     * Plugin settings
     *
     */
    
    function settings()
    {
        $apiUrls = $this->api_urls();
        $options = $this->options();
        $opt = array();

        if (!empty($_POST)) {
            foreach ($options AS $key => $val)
            {
                if (!isset($_POST[$key])) {
                    continue;
                }
                sanitize_text_field( update_option('plzsharemeShortURL' . $key, $_POST[$key]));
            }
			sanitize_text_field( update_option('new_Api_key', $_POST['new_Api_key']));
			sanitize_text_field( update_option('TwitterTag', $_POST['TwitterTag']));
			sanitize_text_field( update_option('GoogleTag', $_POST['GoogleTag']));
			sanitize_text_field( update_option('PinterestTag', $_POST['PinterestTag']));
			sanitize_text_field( update_option('FacebookTag', $_POST['FacebookTag']));
        }
        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('plzsharemeShortURL' . $key);
        }
        include plzshareme_plugin_path . 'template/psmsettings.php';
    }
    
    /**
     *
     */
    
    function admin_menu()
    {
//        add_options_page('PlzShareMe URL Viral Booster', 'PlzShareMe URLs', 10, 'plzshareme_shorturl-settings', array(&$this, 'settings'));
	add_menu_page('PlzShare.Me Plugin Settings', 'PlzShare.Me', 'administrator','short_link_settings_page', 'short_link_settings_page',plugins_url('icon.png', __FILE__));
	add_submenu_page( 'short_link_settings_page', 'PlzShareMe URL Viral Booster','Settings' , 'manage_options', 'short_link_settings_page2', array(&$this, 'settings') ); 

    }
    
    /**
     * Display the short URL
     */
    function display($content)
    {

        global $post;

        if ($post->ID <= 0) {
            return $content;
        }

        $options = $this->options();
	//$options = array();

        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('plzsharemeShortURL' . $key);
        }

        $shortUrl = get_post_meta($post->ID, 'plzsharemeShortURL', true);

        if (empty($shortUrl)) {
            return $content;
        }

        $shortUrlEncoded = urlencode($shortUrl);
		$domain = $opt['Domain'];
		str_replace('plzshare.me',$domain,$shortUrlEncoded);

        ob_start();
        include plzshareme_plugin_path . 'template/psmfrontend.php';
        $content .= ob_get_contents();
        ob_end_clean();

        return $content;
    }

    public function pre_get_shortlink($false, $id, $context=null, $allow_slugs=null)
    {
        // get the post id
        global $wp_query;
        if ($id == 0) {
            $post_id = $wp_query->get_queried_object_id();
        } else {
            $post = get_post($id);
            $post_id = $post->ID;
        }

        $short_link = get_post_meta($post_id, self::META_FIELD_NAME, true);
        if('' == $short_link) {
            $short_link = $post_id;
        }

        $url = get_plzshareme_url(get_permalink( $id ));
        if (!empty($url)) {
            $short_link = $url;
        } else {
            $short_link = home_url($short_link);
        }
        return $short_link;
    }

}

$plzshareme = new plzshareme_Short_URL;

if (is_admin()) {
    add_action('edit_post', array(&$plzshareme, 'create'));
    add_action('save_post', array(&$plzshareme, 'create'));
    add_action('publish_post', array(&$plzshareme, 'create'));
    add_action('admin_menu', array(&$plzshareme, 'admin_menu'));
    add_filter('pre_get_shortlink',  array(&$plzshareme, 'pre_get_shortlink'), 10, 4);
} else {
    add_filter('the_content', array(&$plzshareme, 'display'));
}
add_action('admin_enqueue_scripts','plzshareme_admin_scripts');
add_action('admin_head','plzshareme_head');

function plzshareme_admin_scripts(){
	wp_enqueue_style('plzshareme-topbuttons', plugins_url( '/plzshareme-url-shortener-viral-booster/css/btns.css' , dirname(__FILE__) ) );
	wp_enqueue_script('plzshareme-table', plugins_url( '/plzshareme-url-shortener-viral-booster/template/jquery.dataTables.min.js' , dirname(__FILE__) , array('jquery') ) );
}
function plzshareme_head(){
	echo '<script>
	jQuery(document).ready(function(){
    jQuery("#myTable").DataTable();
});
</script>
';
	
	
}

// Admin page settings
add_action('admin_menu', 'shortlink_create_menu');
function shortlink_create_menu() {
}
function register_mysettings() {
// Save your settings here
	register_setting( 'shortlink-settings-group', 'new_Api_key' );
}
add_action( 'admin_init', 'register_mysettings' );

function  short_link_settings_page() {
?>
	<div style="clear:both; padding-top:5px;"></div>
    <div class="psm-container">
	<div class="psm-social-blocks-text"><?php echo __('Connect With PlzShare.Me ') ?></div>
    	<div style="clear:both; padding-top:15px;"></div>
	<div class="psm-social-blocks"> 
		<a href="http://facebook.com/pleaseshareme" target="_blank" class="psm-social-fb"><?php esc_html_e( 'fb' ); ?></a>
		<a href="http://twitter.com/plzshareme" target="_blank" class="psm-social-tw"><?php esc_html_e( 'tw' ); ?></a>
		<a href="http://pinterest.com/pleazeshareme" target="_blank" class="psm-social-pi"><?php esc_html_e( 'pi' ); ?></a>
		<a href="http://plzshareme.tumblr.com" target="_blank" class="psm-social-tu"><?php esc_html_e( 'tu' ); ?></a>
		<a href="http://reddit.com/r/plzshareme" target="_blank" class="psm-social-re"><?php esc_html_e( 're' ); ?></a>
		<a href="http://plzshare.me/blog" target="_blank" class="psm-social-bl"><?php esc_html_e( 'bl' ); ?></a>
	</div>
	<div style="clear:both; padding-top:15px;"></div>
    <a href="http://plzshare.me/blog/#aboutus" class="quotebuttons quotetext1" target="_blank"><div class="quotetext1-icon"></div><?php esc_html_e( 'See How We Boost Your Traffic' ); ?></a>
    <a href="http://plzshare.me/blog/#testimonials" class="quotebuttons quotetext1" target="_blank"><div class="quotetext2-icon"></div><?php esc_html_e( 'Increase Video Views' ); ?></a>
	</div>
	<div style="clear:both; padding-top:15px;"></div>

<br> 
<br>
<form method="post" action="<?php echo esc_url( 'options.php' ); ?>">
    <?php settings_fields( 'shortlink-settings-group' ); ?>
    <?php do_settings_sections( 'shortlink-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Enter Api key</th>
        <td><input type="text" name="new_Api_key" value="<?php echo sanitize_text_field( get_option('new_Api_key') );?>" /> <a href="http://plzshare.me/user/register" target="_blank"><?php esc_html_e( 'Get API Key?' ); ?></a></td>
        </tr>
    </table>
<?php submit_button(); ?>
</form>
<div>
<h2>Statistics</h2>
<?php
$args = array(
	'posts_per_page'   => 5,
	'offset'           => 0
	);
$posts = get_posts($args);
global $wpdb;
$allurls = $wpdb->get_results( "SELECT * FROM  $wpdb->postmeta WHERE  meta_key =  'plzsharemeShortURL' ORDER BY  meta_id DESC ", OBJECT);
//print_r($allurls);
echo '<table id="myTable" class="plzsharemetables">';
echo '<thead>';
echo '<th>Long URL</th>';
echo '<th>Short URL</th>';
echo '<th>Details</th>';
echo '<th>Clicks</th>';
echo '</thead>';
echo '<tbody>';
if (!empty($allurls)){
foreach($allurls as $singleurl){
	$short = $singleurl->meta_value;//get_post_meta($post->ID,'plzsharemeShortURL',true);
	$clicks = file_get_contents('http://plzshare.me/api?api='.get_option('new_Api_key').'&short='.$short);
	$clicks = json_decode($clicks);
	if ($clicks->error != 1){
	echo '<tr>';
	echo '<td>'.$clicks->long.'</td>';
	echo '<td>'.$short.'</td>';
	echo '<td><a target="_blank" href="'.$short.'+">'.__('See Stats').'</a></td>';
	echo '<td>'.$clicks->click.'</td>';
	echo '</tr>';
	} // if no error
//	http://plzshare.me/api?api=hqpg3XQTxyHD&short=http://plzshare.me/r0zuH
}
}
echo '</tbody>';
echo '</table>';
?>
</div>
<div style="clear:both;"></div>
</div>

<?php } 

function plzshareme_add_meta_box() {

		add_meta_box(
			'plzshareme_sectionid',
			__( 'Short Link Stats', 'plzshareme' ),
			'plzshareme_meta_box_callback',
			'post','side','high'
		);
	
}
function plzshareme_meta_box_callback( $post ) {
	$short = get_post_meta( $post->ID, 'plzsharemeShortURL', true );

	echo '<h2>';
	$clicks = file_get_contents('http://plzshare.me/api?api='.get_option('new_Api_key').'&short='.$short);
	$clicks = json_decode($clicks);
	echo isset($clicks->click) ? $clicks->click : '0';
	_e( ' Clicks', 'plzshareme' );
	echo '</h2> ';
	echo '<a target="_blank" href="'.$short.'+">'. __('More Details').'..</a>';

}
add_action( 'add_meta_boxes', 'plzshareme_add_meta_box' );


/* ACTIVATION */
register_activation_hook(__FILE__, 'plzshareme_plugin_activate');
add_action('admin_init', 'plzshareme_plugin_redirect');

function plzshareme_plugin_activate() {
    add_option('plzshareme_plugin_do_activation_redirect', true);
}

function plzshareme_plugin_redirect() {
    if (get_option('plzshareme_plugin_do_activation_redirect', false)) {
        delete_option('plzshareme_plugin_do_activation_redirect');
        wp_redirect('admin.php?page=short_link_settings_page2');
    }
}
?>