<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
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

    <br />
<br />
<br />
<h2><?php _e('How to reference shortcodes on in Posts and Pages','plzshareme') ?>:</h2>
<p><?php _e('Use this shortcode to display on a post or page','plzshareme')?>:</p>
<p><strong>[plzshareme-url]</strong></p>
<p><?php _e('If you would like to shorten a url that is not on your site, use the following shortcode','plzshareme')?>:</p>
<p>Example: Using <a target="_blank" href="http://plzshare.me" ><font color="blue">http://plzshare.me</font></a> as extrnal link, then use following code</p>
<p><pre>[plzshareme-url u="<font color="blue">http://plzshare.me</font>"]</pre></p>

<form method="post" id="plzshareme_shorturl_settings">
<table class="plzsharemetables" style="margin-top:2em;margin-left:1em;">
		<tr valign="top">
        <th scope="row">Enter Api key</th>
        <td>
        <input type="text" name="new_Api_key" value="<?php echo sanitize_text_field( get_option('new_Api_key') );?>" /> <a href="http://plzshare.me/user/register" target="_blank"><?php esc_html_e( 'Get API Key?' ); ?></a></td>
        </tr>
  <tr valign="top">
    <th scope="row">
        <?php echo __('Display Short URL Under Post Content?') ?>
    </th>
    <td>
        <input type="radio" name="Display" value="Y" <?php echo esc_textarea ( $opt['Display'] == 'Y' ? 'checked="checked"' : '' ) ?> /> <?php echo __('Yes') ?>
        <input type="radio" name="Display" value="N" <?php echo esc_textarea ( $opt['Display'] == 'N' ? 'checked="checked"' : '' ) ?> /> <?php echo __('No') ?>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row">
        <label for="TwitterLink" style="font-weight:bold;"><?php echo __('Display Social Icons Under Post Content?') ?></label>
    </th>
  	<td>
        <input type="radio" name="TwitterLink" value="Y" <?php echo esc_textarea ( $opt['TwitterLink'] == 'Y' ? 'checked="checked"' : '' ) ?> /> <?php echo __('Yes') ?>
        <input type="radio" name="TwitterLink" value="N" <?php echo esc_textarea ( $opt['TwitterLink'] == 'N' ? 'checked="checked"' : '' ) ?> /> <?php echo __('No') ?>
    </td>
  </tr>
  
  <!-- tag your social accounts -->
  <tr valign="top">
    <th scope="row">
        <label for="TwitterLink" style="font-weight:bold;"><?php echo __('Display follow/like widgets?<br>Must set the above DISPLAY SOCIAL ICONS to Yes<br>only enter the profile id<br>G+ after plus.google.com/') ?></label>
    </th>
  	<td>
        Twitter Profile Name: <input type="text" name="TwitterTag" value="<?php echo sanitize_text_field( get_option('TwitterTag') );?>" /><br>
        Facebook Page Name: <input type="text" name="FacebookTag" value="<?php echo sanitize_text_field( get_option('FacebookTag') );?>" /><br>
        Google+: <input type="text" name="GoogleTag" value="<?php echo sanitize_text_field( get_option('GoogleTag') );?>" /><br>
        Pinterest: <input type="text" name="PinterestTag" value="<?php echo sanitize_text_field( get_option('PinterestTag') );?>" />
        
        
        <input type="hidden" value="plzshare.me" <?php echo sanitize_text_field( $opt['Domain'] == 'plzshare.me' ? 'selected' : '' ) ?>>plzshare.me</option>
        
    </td>
  </tr>
  <tr valign="top">
    <th scope="row" colspan="2">
        <input type="submit" class="button-primary" name="save" value="<?php echo __('Save') ?>" />
    </th>
  </tr>
</table>
</form>
