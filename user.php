<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Footer.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$footer = new FooterComponent();

function redirect() {
    header("refresh:5;url=index.php");
}

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'register':
            require dirname(__FILE__) . '/components/Register.php';
            $component = new RegisterComponent();
            break ;
        case 'connect':
            require dirname(__FILE__) . '/components/Connect.php';
            $component = new ConnectComponent();
            break ;
        case 'reset':
            require dirname(__FILE__) . '/components/Reset.php';
            $component = new ResetComponent();
            break ;
        case 'confirm':
            require dirname(__FILE__) . '/components/Confirm.php';
            $component = new ConfirmComponent();
            redirect();
            break ;
        case 'disconnect':
            $_SESSION = array();
            session_destroy();
        default:
            redirect();
            break ;
    }
}
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
      <?php $component(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
