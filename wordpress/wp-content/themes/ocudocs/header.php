<!doctype html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <title>
    <?php
    bloginfo();

    echo " | ";

    if (is_front_page())
      echo( "Home" );
    else
      the_title();
    ?>
  </title>

  <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" />

  <script src="<?php bloginfo('template_url') ?>/js/modernizr.js"></script>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div class="site-container">

    <div class="site-sidebar">
      <header class="site-header">
        <a href="<?php echo home_url(); ?>">
          <img src="<?php bloginfo('template_url'); ?>/img/ocupop.png">
          <span>Ocudocs</span>
        </a>
      </header>

      <?php get_sidebar(); ?>
    </div>
