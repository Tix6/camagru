<?php

require_once dirname(__FILE__) . '/Component.php';

final class MenuComponent extends Component {

    private $_items = array(
        array('les + aimés', 'index.php?filter=like'),
        array('les + commentés', 'index.php?filter=comment'),
        array('<span class="add">ajouter</span>', 'add.php')
    );

    private $_items_for_user_auth = array(
        array('<i class="icon-logout"></i>', 'user.php?page=disconnect')
    );

    private $_items_for_guest = array(
        array('se connecter', 'user.php?page=connect'),
        array('s\'enregister', 'user.php?page=register')
    );

    private $_items_to_display;

    private function _display_menu($items) {
        $menu = array();
        foreach ($items as $item) {
            $menu[] = "<li><a href=\"{$item[1]}\">{$item[0]}</a></li>";
        }
        return implode("\n", $menu);
    }

    public function __construct() {
        parent::__construct();
        if ($this->_user_is_auth) {
            $id = $_SESSION['id'];
            $username = ucfirst($_SESSION['name']);
            $user_item = array($username, "profile.php?id=$id");
            array_unshift($this->_items_for_user_auth, $user_item);
            $this->_items_to_display = $this->_items_for_user_auth;
        } else {
            $this->_items_to_display = $this->_items_for_guest;
        }
    }

    public function __invoke() {
        echo '
        <nav>
            <div class="left">
                <a class="title" href="index.php">Camagru</a>
                <ul>'
                . $this->_display_menu($this->_items) .
                '</ul>
            </div>
            <div class="right">
                <ul>'
                . $this->_display_menu($this->_items_to_display) .
                '</ul>
            <div>
        </nav>
        ';
    }
}

 ?>
