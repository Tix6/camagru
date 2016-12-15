<?php

abstract class Component {

    protected $_action_name = 'faire cette action';
    protected $_need_auth = false;
    protected $_user_is_auth = false;

    /* used as signal to refresh for parent page */
    public $_need_to_refresh = false;

    private function _is_auth() {
        if (isset($_SESSION['is_auth']))
            $this->_user_is_auth = true;
        else
            $this->_user_is_auth = false;
    }

    protected function _redirect($uri) {
        header("Location: $uri");
    }

    public function __construct() {
        $this->_is_auth();
    }

    public function __invoke() {
        if ($this->_need_auth === true && $this->_user_is_auth === false) {
            $action = $this->_action_name;
            echo "<p class=\"error-auth\">Vous devez vous connecter pour $action.</p>";
            echo '<a href="user.php?page=connect">Connectez vous ici.</a>';
            return false;
        } else {
            return true;
        }
    }
}

?>
