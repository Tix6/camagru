<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Register_Ctrl extends Controller {

    /* filled by user's form */
    private $_inputs = NULL;
    /* database response on user creation */
    private $_user_id;

    private $_err_handler = array(
        ':name' => array(
            'is_valid' => FALSE,
            'err_str' => 'Requiert au moins 4 caracteres (alphabetiques uniquement)',
            'regexp' => "/^[A-Za-z]{4,12}$/"
        ),
        ':passwd' => array(
            'is_valid' => FALSE,
            'err_str' => 'Une majuscule, une minuscule et un chiffre (taille >= 8)',
            'regexp' => "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,12}$/"
        ),
        ':mail' => array(
            'is_valid' => FALSE,
            'err_str' => 'Adresse mail invalide',
            'regexp' => "/^\w{3,}@\w{2,}\.\w{2,}$/"
        )
    );

    /* alerts array */
    private $_alerts = array(
        'success' => '<p class="alert-success">Compte crée, vous allez recevoir un mail de confirmation.</p>',
        'failure' => '<p class="alert-danger">Echec de création du compte. (nom ou mail deja utilisé).</p>'
    );

    /* alert to display */
    private $alert = '';

    private function check_form() {
        $is_valid_form = TRUE;
        foreach ($this->_err_handler as $key => $array) {
            if (preg_match($array['regexp'], $this->_inputs[$key]) == FALSE)
                $is_valid_form = FALSE;
            else
                $this->_err_handler[$key]['is_valid'] = TRUE;
        }
        return $is_valid_form;
    }

    /* TODO: handle mail sending into special class */
    private function _send_confirmation_mail() {
        $headers   = array();
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Admin <admin@camagru.com>';

        $title = "Camagru - Confirmez votre compte {$this->_inputs[':name']}.";

        $link = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/camagru/index.php?page=confirm&id=' . urlencode($this->_user_id) . '&token=' . urlencode($this->_inputs[':token']) . '">Cliquez ici pour activer votre compte.</a>';
        $message = "Bonjour {$this->_inputs[':name']}, merci de confirmer ton inscription en cliquant sur le lien suivant :<br><br>$link";
        $message = wordwrap($message, 70, "\r\n");
        return mail($this->_inputs[':mail'], $title, $message, implode("\r\n", $headers));
    }

    private function _reset_form_and_inputs() {
        $this->_inputs = array_fill_keys(array_keys($this->_inputs), '');
    }

    private function _create_user() {
        $fields = User::get_fields();
        $sql_params = array_intersect_key($this->_inputs, $fields);
        return User::add_item($sql_params);
    }

    public function __construct( array $posted ) {
        if (isset($posted['register']) && $posted['register'] === 'ok')
        {
            $this->_inputs = $posted;
            if ($this->check_form() === TRUE)
            {
                $this->_inputs[':token'] = User::init_token();
                if ($this->_user_id = $this->_create_user())
                {
                    $this->_send_confirmation_mail();
                    $this->_alert = $this->_alerts['success'];
                    $this->_reset_form_and_inputs();
                }
                else {
                    $this->_alert = $this->_alerts['failure'];
                }
            }
        }
    }

    public function render() {
        if (isset($this->_inputs)) {
            $errors = array();
            foreach ($this->_err_handler as $key => $array) {
                $errors[$key] = ($array['is_valid'] === FALSE) ? $array['err_str'] : '';
            }
        }
        echo '
<h1 class="title">Inscription</h1>
<hr>'
. $this->_alert .
'<div class="register">
    <form action="index.php?page=register" method="POST">
        <label>Pseudo</label>
        <input type="text" name=":name" value="' . $this->_inputs[':name'] . '">
        <p>' . $errors[':name'] . '</p>
        <label>Mot de passe</label>
        <input type="password" name=":passwd" value="' . $this->_inputs[':passwd'] . '">
        <p>' . $errors[':passwd'] . '</p>
        <label>Adresse mail</label>
        <input type="email" name=":mail" value="' . $this->_inputs[':mail'] . '">
        <p>' . $errors[':mail'] . '</p>
        <button type="submit" name="register" value="ok">Valider</button>
    </form>
</div>';
    }
}

?>
