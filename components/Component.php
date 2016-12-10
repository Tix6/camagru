<?php

abstract class Component {
    const NEED_AUTH = false;
    const ACTION_NAME = 'faire cette action';

    protected $_user_is_auth = false;

    private function _is_auth() {
        if (isset($_SESSION['is_auth']))
            $this->_user_is_auth = true;
        else
            $this->_user_is_auth = false;
    }

    protected function _redirect($uri) {
        header("Location: $uri");
        exit();
    }

    public function __construct() {
        $this->_is_auth();
    }

    public function __invoke() {
        if (static::NEED_AUTH === true && $this->_user_is_auth === false) {
            $action = static::ACTION_NAME;
            echo "<p class=\"error-auth\">Vous devez vous connecter pour $action.</p>";
            echo '<a href="user.php?page=connect">Connectez vous ici.</a>';
            return false;
        } else {
            return true;
        }
    }
}

?>
