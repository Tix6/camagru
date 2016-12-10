<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Footer.php';
require dirname(__FILE__) . '/components/Profile.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$footer = new FooterComponent();
$profile = new ProfileComponent();
?>
<!doctype html>
<html lang="fr">
<head>
    <?php $meta(); ?>
</head>
<body>
  <header>
      <?php $menu(); ?>
  </header>
  <div class="gallery-container">
      <?php $profile(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
