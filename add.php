<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Add.php';
require dirname(__FILE__) . '/components/Footer.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$add    = new AddComponent();
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
      <?php $add(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
</html>
