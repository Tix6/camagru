<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Footer.php';
require dirname(__FILE__) . '/components/Gallery.php';
require dirname(__FILE__) . '/components/User.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$gallery = new GalleryComponent();
$user   = new UserComponent();
$footer = new FooterComponent();

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
      <?php $user(); ?>
      <?php $gallery(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
