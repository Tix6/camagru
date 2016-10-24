<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Connect_Ctrl extends Controller {

    public function render() {
        echo '
<h1 class="title">Connexion</h1>
<hr>
<div class="register">
    <form action="index.php">
        <label>Pseudo</label>
        <input type="text" name="name" value="">
        <label>Mot de passe</label>
        <input type="password" name="passwd" value="">
        <button type="submit" value="register">Valider</button>
    </form>
</div>
';
    }
}

?>
