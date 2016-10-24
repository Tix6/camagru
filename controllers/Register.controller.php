<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Register_Ctrl extends Controller {

    private $_name;
    private $_passwd;
    private $_mail;

    private static $_name_regexp = "/^[A-Za-z]{4,12}$/";
    private static $_passwd_regexp = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,12}$/";
    private static $_mail_regexp = "/^\w{3,}@\w{2,}\.\w{2,}$/";

    private static $_name_error = 'Doit contenir au moins 4 caracteres (alphabetiques).';
    private static $_passwd_error = 'Une majuscule, une minuscule et un chiffre (taille >= 8)';
    private static $_mail_error = 'Adresse mail invalide.';

    private $_token;
    private $is_valid_form = FALSE;

    private function check_form() {
        $this->error_name = preg_match(self::$_name_regexp, $this->_name) ? NULL : self::$_name_error;
        $this->error_passwd = preg_match(self::$_passwd_regexp, $this->_passwd) ? NULL : self::$_passwd_error;
        $this->error_mail = preg_match(self::$_mail_regexp, $this->_mail) ? NULL : self::$_mail_error;
        return (is_null($this->error_name) && is_null($this->error_passwd) && is_null($this->error_mail));
    }

    private function send_confirmation_mail() {
        $headers = "Content-type: text/html; charset=UTF-8";
        $title = "Camagru - Confirmez votre compte $user.";
        $link = '<a href="http://' . $_SERVER['HTTP_HOST'] . '/camagru/index.php?page=register&confirm=ok&id=' . urlencode($user_id) . '&token=' . urlencode($token) . '">Cliquez ici pour activer votre compte.</a>';
        $content = "Bonjour $user, merci de confirmer ton inscription en cliquant sur le lien suivant :<br><br>$link";
        mail($email, $title, $content, $headers);
    }

    private function create_user() {
        $fields = User::get_fields();
        foreach ($fields as $key => $value) {
            switch ($key) {
                case ':name':
                    $fields[$key] = $this->_name;
                    break;
                case ':passwd':
                    $fields[$key] = $this->_passwd;
                    break;
                case ':mail':
                    $fields[$key] = $this->_mail;
                    break;
                case ':token':
                    $fields[$key] = $this->_token;
                    break;
                default:
                    break;
            }
        }
        return User::add_item($fields);
    }

    public function __construct( array $posted ) {
        if (isset($posted['register']) && $posted['register'] === 'ok')
        {
            $this->_name = $posted['name'];
            $this->_passwd = $posted['passwd'];
            $this->_mail = $posted['mail'];
            $this->is_valid_form = $this->check_form();
            if ($this->is_valid_form === TRUE)
            {
                $this->_token = User::init_token();
                if ($id = $this->create_user()) {
                    echo "utilisateur cree. <br>";
                    echo "[" . $id . "]";
                    // $user_created = User::get_item_by_name
                }
                else {
                    echo "Erreur";
                }
            }
        }
    }

    public function render() {
        echo "
<h1 class=\"title\">Inscription</h1>
<hr>
<div class=\"register\">
    <form action=\"index.php?page=register\" method=\"POST\">
        <label>Pseudo</label>
        <input type=\"text\" name=\"name\" value=\"$this->_name\">
        <p>$this->error_name</p>
        <label>Mot de passe</label>
        <input type=\"password\" name=\"passwd\" value=\"$this->_passwd\">
        <p>$this->error_passwd</p>
        <label>Adresse mail</label>
        <input type=\"email\" name=\"mail\" value=\"$this->_mail\">
        <p>$this->error_mail</p>
        <button type=\"submit\" name=\"register\" value=\"ok\">Valider</button>
    </form>
</div>
";
    }
}

?>
