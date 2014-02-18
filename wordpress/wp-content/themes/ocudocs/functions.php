<?php

/* Customizations */

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

// Remove widgets from admin dashboard.
function remove_dashboard_widget() {
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
  // remove_meta_box('dashboard_activity', 'dashboard', 'normal');
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
  remove_meta_box('dashboard_primary', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'remove_dashboard_widget' );

// Remove menus from admin sidebar.
function remove_menus() {
  remove_menu_page('edit.php');
  remove_menu_page('link-manager.php');
  remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_menus', 999);



/* Functions */

function list_pages_in_category($categoryName) {
  $categoryObject = get_category_by_slug($categoryName);
  $categoryID = $categoryObject->term_id;

  $args = array('posts_per_page'   => -1,
                'category'         => $categoryID,
                'orderby'          => 'post_title',
                'order'            => 'ASC',
                'post_type'        => 'page',
                'exclude'          => 5); // Exclude the 'Welcome' page.

  $posts = get_posts($args);

  echo "<ul>";
  foreach ($posts as $post)
    echo "<li><a href=\"" . get_bloginfo('url') . "/" . $post->post_name . "\">" . $post->post_title . "</a></li>";
  echo "</ul>";
}

function list_clients_and_their_pages() {
  $client_args = array('posts_per_page'   => -1,
                       'category'         => 2,
                       'orderby'          => 'post_title',
                       'order'            => 'ASC',
                       'post_type'        => 'page');

  $clients = get_posts($client_args);

  echo "<ul class=\"clients\">";
  foreach ($clients as $client) {
    echo "<li class=\"client-title\"><a href=\"" . get_bloginfo('url') . "/" . $client->post_name . "\">" . $client->post_title . "</a></li>";
    echo "<li>
            <ul>";

    $client_pages_args = array('posts_per_page'   => -1,
                               'post_parent'      => $client->ID,
                               'orderby'          => 'post_title',
                               'order'            => 'ASC',
                               'post_type'        => 'page');

    $client_pages = get_posts($client_pages_args);

    foreach($client_pages as $client_page) {
      echo "<li><a href=\"" . get_bloginfo('url') . "/" . $client->post_name . "/" . $client_page->post_name . "\">" . $client_page->post_title . "</a></li>";
    }
    echo "  </ul>
          </li>";
  }
  echo "</ul>";
}

?>
