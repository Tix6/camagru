<?php

require_once dirname(__FILE__) . '/Component.php';

final class WelcomeComponent extends Component {

    public function __construct() {}

    public function __invoke() {
        echo '
        <h1>Bienvenue,</h1>
        ';
    }
}

?>
