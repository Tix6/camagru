<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Footer.php';
require dirname(__FILE__) . '/components/Gallery.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$gallery = new GalleryComponent();
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
      <?php $gallery(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
