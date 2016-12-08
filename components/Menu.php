<?php

require_once dirname(__FILE__) . '/Component.php';

final class MenuComponent extends Component {

    private static $_items = array(
        'new' => array('nouveautés', 'index.php?filter=new'),
        'liked' => array('les + aimés', 'index.php?filter=like'),
        'commented' => array('les + commentés', 'index.php?filter=comment'),
        'connect' => array('se connecter', 'user.php?page=connect'),
        'register' => array('s\'enregister', 'user.php?page=register'),
        'add' => array('ajouter', 'add.php'),
        'disconnect' => array('<i class="icon-login"></i>', 'user.php?page=disconnect')
    );

    private $_user = array(
        'id' => 0,
        'name' => ''
    );

    private $_to_display = array();

    public function __construct() {
        $this->_to_display[] = self::$_items['new'];
        $this->_to_display[] = self::$_items['liked'];
        $this->_to_display[] = self::$_items['commented'];
        if (isset($_SESSION) && isset($_SESSION['is_auth'])) {
            $this->_to_display[] = self::$_items['add'];
            $this->_user['name'] = ucfirst($_SESSION['name']);
            $this->_user['id'] = $_SESSION['id'];
        }
        else {
            $this->_to_display[] = self::$_items['connect'];
            $this->_to_display[] = self::$_items['register'];
        }
    }

    private function _display_menu() {
        $menu = array();
        foreach ($this->_to_display as $elem) {
            $menu[] = "<li><a href=\"{$elem[1]}\">{$elem[0]}</a></li>";
        }
        return implode("\n", $menu);
    }

    public function __invoke() {
        echo '
        <nav>
            <div class="left">
                <a class="title" href="index.php">Camagru</a>
                <ul>'
                . $this->_display_menu() .
                '</ul>
            </div>
            <div class="right">';
        if (isset($this->_user)) {
            echo '
            <a href="profile.php?user=' . $this->_user['id'] . '">' . $this->_user['name'] . '</a>
            <a href="user.php?page=disconnect"><i class="icon-login"></i></a>
            ';
        } else {
            echo '
            <span class="user">Invité</span>
            ';
        }
        echo '
            <div>
        </nav>
        ';
    }
}

 ?>
