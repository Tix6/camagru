<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class ConnectComponent extends Component {

    private $_inputs = array(
        'mail' => '',
        'passwd' => ''
    );

    private $_user;

    private $_alerts = array(
        'success' => "<p class=\"alert-success\">Merci, vous allez être redirigé.</p>",
        'not_valid' => '<p class="alert-danger">Mot de passe invalide.</p>',
        'not_exist' => '<p class="alert-danger">Utilisateur inexistant.</p>',
        'not_confirmed' => '<p class="alert-danger">Vous devez confirmer votre compte.</p>',
        'already_connected' => '<p class="alert-danger">Il semblerait que vous soyez déjà connecté.</p>'
    );

    private $_alert = '';

    public function __construct() {
        $posted = $_POST;
        if (isset($_SESSION['is_auth']) === TRUE) {
            $this->_alert = $this->_alerts['already_connected'];
            return ;
        }
        if (array_key_exists('mail', $posted) && array_key_exists('passwd', $posted)) {
            $this->_inputs = array_intersect_key($posted, $this->_inputs);
            $this->_auth();
        }
    }

    private function _auth() {
        $user = User::get_item_by(array('mail' => $this->_inputs['mail']));
        if ($user) {
            if ($user['confirmed'] != TRUE)
                $this->_alert = $this->_alerts['not_confirmed'];
            else if (User::passwd_verify($this->_inputs['passwd'], $user['passwd'])) {
                $this->_user = $user;
                $this->_set_session();
                $this->_alert = $this->_alerts['success'];
            } else
                $this->_alert = $this->_alerts['not_valid'];
        }
        else
            $this->_alert = $this->_alerts['not_exist'];
    }

    private function _set_session() {
        $_SESSION['is_auth'] = TRUE;
        $_SESSION['id'] = $this->_user['id'];
        $_SESSION['name'] = $this->_user['name'];
    }

    public function __invoke() {
        echo '
<h1 class="title">Connexion</h1>
<hr>'
. $this->_alert .
'<div class="register">
    <form action="user.php?page=connect" method="POST">
        <label>Adresse mail</label>
        <input type="email" name="mail" value="' . $this->_inputs['mail'] . '">
        <label>Mot de passe</label>
        <input type="password" name="passwd" value="' . $this->_inputs['passwd'] . '">
        <button type="submit">Valider</button>
    </form>
    <a href="index.php?page=forgot">Mot de passe oublié.</a>
</div>
';
    }
}

?>
