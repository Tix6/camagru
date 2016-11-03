<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class Forgot_Ctrl extends Controller {

    private $_inputs = array(
        ':mail' => '',
        ':passwd' => ''
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

    public function __construct( array $posted ) {

    }

    // public function init_header() {
    //     if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'] === TRUE)
    //         header("refresh:5;url=index.php");
    // }

    public function render() {
        echo '
<h1 class="title">Oublie de mot de passe</h1>
<hr>'
. $this->_alert .
'<div class="register">
    <form action="index.php?page=forgot" method="POST">
        <label>Adresse mail</label>
        <input type="email" name=":mail" value="' . $this->_inputs[':mail'] . '">
        <button type="submit">Valider</button>
    </form>
</div>
';
    }
}

?>
