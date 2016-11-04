<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class Forgot_Ctrl extends Controller {

    private $_inputs = array(
        ':mail' => '',
        ':passwd' => ''
    );

    private $_user;
    private $_reset_token;

    private $_alerts = array(
        'success' => '<p class="alert-success">Merci, vous allez recevoir un mail de confirmation.</p>',
        'not_valid' => '<p class="alert-danger">Adresse mail non reconnue.</p>',
        'not_confirmed' => '<p class="alert-danger">Vous devez confirmer votre compte.</p>',
        'internal_error' => '<p>Erreur interne, contactez l\'administrateur.</p>'
    );

    private $_alert = '';

    private function _send_reset_mail() {
        $headers   = array();
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Admin <admin@camagru.com>';

        $title = "Camagru - Nouveau mot de passe.";

        $link = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/camagru/index.php?page=reset&token=' . urlencode($this->_reset_token) . '">Changer de mot de passe.</a>';
        $message = "Bonjour {$this->_user['name']}, changez votre mot de passe en cliquant sur le lien suivant :<br><br>$link";
        $message = wordwrap($message, 70, "\r\n");
        return mail($this->_inputs[':mail'], $title, $message, implode("\r\n", $headers));
    }

    public function __construct( array $posted ) {
        if (array_key_exists(':mail', $posted)) {
            $this->_inputs = array_intersect_key($posted, $this->_inputs);
            $user = User::get_item_by('mail', $this->_inputs[':mail']);
            if ($user) {
                $this->_user = $user;
                if ($user['confirmed'] != TRUE)
                $this->_alert = $this->_alerts['not_confirmed'];
                else {
                    $this->_reset_token = User::init_token();
                    if (User::update_token($this->_user['id'], $this->_reset_token)) {
                        $this->_send_reset_mail();
                        $this->_alert = $this->_alerts['success'];
                    } else {
                        $this->_alert = $this->_alerts['internal_error'];
                    }
                }
            }
            else
                $this->_alert = $this->_alerts['not_valid'];
        }
    }

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
