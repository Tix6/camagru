<?php

require_once dirname(__FILE__) . '/Component.php';

final class MenuComponent extends Component {

    private static $_items = array(
        'gallery' => array('gallerie', 'gallery.php'),
        'connect' => array('se connecter', 'user.php?page=connect'),
        'register' => array('s\'enregister', 'user.php?page=register'),
        'add' => array('ajouter', 'add.php'),
        'disconnect' => array('se deconnecter', 'user.php?page=disconnect')
    );

    private $_user;

    private $_to_display = array();

    public function __construct() {
        $this->_to_display[] = self::$_items['gallery'];
        if (isset($_SESSION) && isset($_SESSION['is_auth'])) {
            $this->_to_display[] = self::$_items['add'];
            $this->_to_display[] = self::$_items['disconnect'];
            $this->_user = ucfirst($_SESSION['name']);
        }
        else {
            $this->_to_display[] = self::$_items['connect'];
            $this->_to_display[] = self::$_items['register'];
            $this->_user = 'Invité';
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
            <div class="right">
                <span class="user">' . $this->_user . '</span>
            <div>
        </nav>
        ';
    }
}

 ?>
