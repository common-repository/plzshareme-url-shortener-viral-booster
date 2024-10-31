<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div style="margin-top:3em;">
  <?php if ($opt['Display'] != 'N'): ?>
    <?php echo __('Shortlink') ?>
    <a href="<?php echo $shortUrl ?>" target="_blank"><?php echo get_post_meta($post->ID, 'plzsharemeShortURL', true); ?></a>
  <?php endif ?>
</div>

<div style="margin-top:1em; display: inline-block;">
  <?php if ($opt['TwitterLink'] != 'N'): ?>
    <?php echo __('') ?>
    <a href="https://twitter.com/intent/tweet?url=<?php echo $shortUrlEncoded ?>&amp;text=<?php echo get_the_title() ?>&amp;via=<?php echo get_option( 'TwitterTag' ); ?>"><img src="<?php echo plzshareme_plugin_url.'icons/twitter-plzshareme-icon.png' ?>" style="float:left;" title="Share On Twitter" alt="<?php get_site_url(); ?> plzshare.me social" /></a><a href="https://plus.google.com/share?url=<?php echo $shortUrlEncoded ?>"><img src="<?php echo plzshareme_plugin_url.'icons/google-plzshareme-icon.png' ?>" style="float:left;" title="Share on Google Plus" alt="<?php get_site_url(); ?> plzshare.me google plus social" /></a><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shortUrlEncoded ?>&amp;mesage=[{<?php echo get_option( 'FacebookTag' ); ?>}:1:{<?php echo get_option( 'FacebookTag' ); ?>}]" target="_blank"><img src="<?php echo plzshareme_plugin_url.'icons/facebook-plzshareme-icon.png' ?>" style="float:left;" title="Share on Facebook" alt="<?php get_site_url(); ?> plzshare.me facebook social" /></a><a data-pin-do="buttonBookmark" data-pin-custom="true" data-pin-tall="true" href="http://pinterest.com/pin/create/button/?url=<?php echo $shortUrlEncoded ?>&title=<?php echo get_the_title() ?>&amp;description=@<?php echo get_option( 'PinterestTag' ); ?>"><img src="<?php echo plzshareme_plugin_url.'icons/pinterest-plzshareme-icon.png' ?>" style="float:left;" title="Pin to Pinterst" alt="<?php get_site_url(); ?> plzshare.me pinterest social" /></a>
<?php endif ?>
</div>

<div style="clear:both;"></div>
<div>
<ul style="float:left; overflow: auto; width: 299px; margin-left: 1px; margin-bottom: 20px; padding-left: 0; list-style-type:none;">
	<li style="font-size: 14px; margin-bottom: 1px; color: #bbb; list-style-type: none; clear:both;"><?php echo __('Stay Connected') ?><br>
<?php if (get_option( 'PinterestTag' ) !== '') { ?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<div style="float:left; max-width:250px; height:30px; overflow:hidden; padding:5px;"><a data-pin-do="buttonFollow" href="https://www.pinterest.com/<?php echo get_option( 'PinterestTag' ); ?>/"><?php echo get_option( 'PinterestTag' ); ?></a></div>
<?php } ?>
</li>
<li style="font-size: 14px; margin-bottom: 1px; color: #bbb; list-style-type: none; clear:both;">
<?php if (get_option( 'TwitterTag' ) !== '') { ?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div style="float:left; max-width:250px; height:30px; overflow:hidden; padding:5px;"><a href="https://twitter.com/<?php echo get_option( 'TwitterTag' ); ?>" class="twitter-follow-button" data-show-count="true">Follow @<?php echo get_option( 'TwitterTag' ); ?></a></div>
<?php } ?>
 </li>
<li style="font-size: 14px; margin-bottom: 1px; color: #bbb; list-style-type: none; clear:both;">
<?php if (get_option( 'FacebookTag' ) !== '') { ?>
<div id="fb-root"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=353678204827383";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div style="float:left; max-width:250px; height:30px; overflow:hidden; padding:5px;"><div class="fb-like" data-href="https://facebook.com/<?php echo get_option( 'FacebookTag' ); ?>" data-width="100" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></div>
<?php } ?>
</li>
<li style="font-size: 14px; margin-bottom: 1px; color: #bbb; list-style-type: none; clear:both;">
<?php if (get_option( 'GoogleTag' ) !== '') { ?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<div style="float:left; max-width:250px; height:30px; overflow:hidden; padding:5px;"><div class="g-follow" data-annotation="bubble" data-height="20" data-href="https://plus.google.com/<?php echo get_option( 'GoogleTag' ); ?>" data-rel="publisher"></div></div>
<?php } ?>
</li></ul></div>
<div style="clear:both; padding:10px;"></div>






