<nav class="site-nav">
  <h2 id="nav-home"><a href="<?php echo home_url(); ?>">Welcome</a></h2>

  <h2 id="nav-guidelines">Guidelines</h2>
  <?php list_pages_in_category('guidelines'); ?>

  <h2 id="nav-development">Development</h2>
  <?php list_pages_in_category('development'); ?>

  <h2 id="nav-internal">Internal</h2>
  <?php list_pages_in_category('internal'); ?>

  <h2 id="nav-clients">Clients</h2>
  <?php list_clients_and_their_pages(); ?>
</nav>