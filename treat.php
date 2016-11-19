<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Treat.php';
require dirname(__FILE__) . '/components/Footer.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$treat  = new TreatComponent();
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
  <div class="container">
      <?php $treat(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
</html>
