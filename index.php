<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Welcome.php';
require dirname(__FILE__) . '/components/Footer.php';

$meta = new MetaComponent();
$menu = new MenuComponent();
$welcome = new WelcomeComponent();
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
      <?php $welcome(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
</html>
