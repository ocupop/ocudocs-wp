<?php

// Never cache.
nocache_headers();

// Don't ever empty the trash.
define('EMPTY_TRASH_DAYS', 0);

// Disable Wordpress' auto-paragraph filter.
remove_filter('the_excerpt', 'wpautop');
remove_filter('the_content', 'wpautop');

// Disable visual editor.
add_filter('user_can_richedit', create_function('$a', 'return false;') , 50);

// Markdown breaks autoembedding by wrapping URLs on their own line in paragraphs. This fixes that problem.
function oembed_fixer($content) {
  global $wp_embed;
  return preg_replace_callback('|^\s*<p>(https?://[^\s"]+)</p>\s*$|im', array($wp_embed, 'autoembed_callback'), $content);
}
if (get_option('embed_autourls'))
  add_filter('the_content', 'oembed_fixer', 8);

// Automatic database optimizing.
define('WP_ALLOW_REPAIR', true);

// Override regular expression parsing limits. Too many shortcodes in a post will make PHP stop regex-evaluating that post.
ini_set('pcre.recursion_limit',20000000);
ini_set('pcre.backtrack_limit',10000000);

//  Add page slug as nav IDs.
function nav_id_filter($id, $item ) {
  return 'nav-'.sanitize_title($item->title);
}
add_filter('nav_menu_item_id', 'nav_id_filter', 10, 2);

// Remove menus from sidebar.
function remove_menus() {
  remove_menu_page('edit.php');
  remove_menu_page('link-manager.php');
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_menus', 999);


/* Shortcodes */

// [[TITLE]]
// To create an automatic internal link.
//
// TODO
// Check out the functionality of:
//   http://wordpress.org/plugins/wordpress-wiki-plugin/
// or
//   http://wordpress.org/plugins/wordpress-wiki/

?>