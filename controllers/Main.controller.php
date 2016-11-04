<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Main_Ctrl extends Controller {

    private $_user;

    public function __construct() {

    }

    public function render() {
        echo '
<section>
<ul>
    <li>
        <a href="index.php?page=connect">connexion</a>
    </li>
    <li>
        <a href="index.php?page=register">register</a>
    </li>
</ul>
<p>SECTION</p>
</section>
<aside>
<p>ASIDE</p>
</aside>';
    }
}

?>
