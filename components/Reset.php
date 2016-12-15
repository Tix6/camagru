<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class ResetComponent extends Component {

    private $_token;

    private $_inputs = array(
        'passwd' => '',
        'token' => ''
    );

    private $_err_handler = array(
        'passwd' => array(
            'is_valid' => FALSE,
            'err_str' => 'Une majuscule, une minuscule et un chiffre (taille >= 8)',
            'regexp' => "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,12}$/"
        )
    );

    private $_error = '';

    private $_alerts = array(
        'success' => '<p class="alert-success">Mot de passe mis à jour.</p>',
        'update' => '<p class="alert-success">Indiquez un nouveau mot de passe.</p>',
        'err_token' => '<p class="alert-danger">Token invalide, contactez l\'administrateur.</p>'
    );

    private $_alert = '';

    public function __construct() {
        $posted = $_POST;
        $token = $_GET['token'];
        if (isset($token)) {
            $user = User::get_item_by(array('token' => $token));
            if ($user) {
                $this->_token = $token;
                $this->_alert = $this->_alerts['update'];
            }
        } else if (isset($posted) && $posted['token'] && $posted['passwd']) {
            if (preg_match($this->_err_handler['passwd']['regexp'], $posted['passwd']) == FALSE) {
                $this->_error = $this->_err_handler['passwd']['err_str'];
                return ;
            }
            $user = User::get_item_by(array('token' => $posted['token']));
            if ($user) {
                User::update_item_by_id($user['id'], 'passwd', $posted['passwd']);
                $this->_alert = $this->_alerts['success'];
                $this->_need_to_refresh = true;
            } else {
                $this->_alert = $this->_alerts['err_token'];
            }
        } else {
            $this->_alert = $this->_alerts['err_token'];
        }
    }

    public function __invoke() {
        echo
'<h1 class="title">Changement de mot de passe</h1>
<hr>'
. $this->_alert .
'<div class="register">
    <form action="user.php?page=reset" method="POST">
        <label>Nouveau mot de passe</label>
        <input type="password" name="passwd" value="' . $this->_inputs['passwd'] . '">'
        . '<p>' . $this->_error . '</p>' .
        '<input type="hidden" name="token" value="' . $this->_token . '">
        <button type="submit">Valider</button>
    </form>
</div>
';
    }
}

?>
