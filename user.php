<?php
session_start();

require dirname(__FILE__) . '/components/Meta.php';
require dirname(__FILE__) . '/components/Menu.php';
require dirname(__FILE__) . '/components/Footer.php';

$meta   = new MetaComponent();
$menu   = new MenuComponent();
$footer = new FooterComponent();

function redirect_after() {
    header("refresh:5;url=index.php");
}

function redirect_now() {
    header("Location: index.php");
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
            if (count($_POST) > 0)
                redirect_after();
            break ;
        case 'forgot':
            require dirname(__FILE__) . '/components/Forgot.php';
            $component = new ForgotComponent();
            break ;
        case 'reset':
            require dirname(__FILE__) . '/components/Reset.php';
            $component = new ResetComponent();
            if (count($_POST) > 0)
                redirect_now();
            break ;
        case 'confirm':
            require dirname(__FILE__) . '/components/Confirm.php';
            $component = new ConfirmComponent();
            redirect_after();
            break ;
        case 'disconnect':
            $_SESSION = array();
            session_destroy();
        default:
            redirect_now();
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
  <div class="user-container">
      <?php $component(); ?>
  </div>
  <footer>
     <?php $footer(); ?>
  </footer>
</body>
