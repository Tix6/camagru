<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Confirm_Ctrl extends Controller {

    private $_user;

    /* alerts array */
    private $_alerts = array(
        'success' => '<p class="alert-success">Compte crée, vous pouvez maintenant vous connecter.</p>',
        'failure' => '<p class="alert-danger">Echec de création du compte. Contactez l\'administrateur.</p>'
    );

    /* alert to display */
    private $alert = '';

    public function __construct( $id, $token ) {
        if ($id > 0 && strlen($token) == User::TOKEN_SIZE) {
            if (User::confirm_registration($id, $token) == 1)
                $this->alert = $this->_alerts['success'];
            else
                $this->alert = $this->_alerts['failure'];
        } else {
            $this->alert = $this->_alerts['failure'];
        }
    }

    public function render() {
        echo '<h1 class="title">Confirmation</h1>' . $this->alert;
    }
}

?>
