<?php
/*
** This file is simply a router with the basic HTML template
*/

session_start();

if (isset($_GET['page']))
{
    switch ($_GET['page']) {
        case 'register':
            require_once dirname(__FILE__) . '/controllers/Register.controller.php';
            $controller = new Register_Ctrl($_POST);
            break ;
        case 'connect':
            require_once dirname(__FILE__) . '/controllers/Connect.controller.php';
            $controller = new Connect_Ctrl($_POST);
            break ;
        case 'confirm':
            require_once dirname(__FILE__) . '/controllers/Confirm.controller.php';
            $controller = new Confirm_Ctrl(intval($_GET['id']), $_GET['token']);
            break ;
        case 'forgot':
            require_once dirname(__FILE__) . '/controllers/Forgot.controller.php';
            $controller = new Forgot_Ctrl($_POST);
            break ;
        case 'add':
            require_once dirname(__FILE__) . '/controllers/Add.controller.php';
            $controller = new Add_Ctrl($_POST);
            break ;
        case 'camera':
            require_once dirname(__FILE__) . '/controllers/Camera.controller.php';
            $controller = new Camera_Ctrl($_POST);
            break ;
        case 'upload':
            require_once dirname(__FILE__) . '/controllers/Upload.controller.php';
            $controller = new Upload_Ctrl($_POST);
            break ;
        case 'treat':
            require_once dirname(__FILE__) . '/controllers/Treat.controller.php';
            $controller = new Treat_Ctrl($_POST);
            break ;
        case 'save':
            require_once dirname(__FILE__) . '/controllers/Save.controller.php';
            $controller = new Save_Ctrl($_POST);
            break ;
        case 'reset':
            require_once dirname(__FILE__) . '/controllers/Reset.controller.php';
            $controller = new Reset_Ctrl($_GET['token'], $_POST);
            break ;
        case 'disconnect':
            $_SESSION = array();
            session_destroy();
        default:
            require_once dirname(__FILE__) . '/controllers/Main.controller.php';
            $controller = new Main_Ctrl();
            break ;
    }
} else {
    require_once dirname(__FILE__) . '/controllers/Main.controller.php';
    $controller = new Main_Ctrl();
}

require dirname(__FILE__) . '/controllers/Menu.controller.php';
$menu = new Menu_Ctrl();

?>
<?php $controller->init_header(); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Camagru</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
      <?php $menu->render(); ?>
  </header>
  <div class="container">
      <?php $controller->render(); ?>
  </div>
  <footer>
      <p>Réalisé dans le cadre d'un projet avec l'école 42. - dev by <a href="http://github.com/tix6" target="_blank">tix6</a></p>
  </footer>
</body>
</html>
