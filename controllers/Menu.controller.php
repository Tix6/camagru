<?php

final class Menu_Ctrl {

    private static $_items = array(
        'connect' => array('se connecter', 'index.php?page=connect'),
        'register' => array('s\'enregister', 'index.php?page=register'),
        'disconnect' => array('se deconnecter', 'index.php?page=disconnect')
    );

    private $_user;

    private $_to_display = array();

    public function __construct() {
        if (isset($_SESSION) && isset($_SESSION['is_auth'])) {
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

    public function render() {
        echo '
<nav>
<a class="title" href="index.php">Camagru</a>
    <ul>'
    . $this->_display_menu() .
    '</ul>
    <span class="user">' . $this->_user . '</span>
</nav>
';
    }
}

 ?>
