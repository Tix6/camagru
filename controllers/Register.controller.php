<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Register_Ctrl extends Controller {

    public function render() {
        return
'<div class="register">
    <h1 class="title">Inscription</h1>
    <hr>
    <form action="index.php">
        <div>
            <label>Pseudo</label>
            <input type="text" name="pseudo" value="">
        <div>
        <div>
            <label>Mot de passe</label>
            <input type="password" name="passwd" value="">
        </div>
        <div>
            <label>Adresse mail</label>
            <input type="email" name="mail" value="">
        </div>
        <input type="submit" value="register">
    </form>
</div>';
    }
}

?>
