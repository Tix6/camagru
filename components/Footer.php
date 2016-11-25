<?php

require_once dirname(__FILE__) . '/Component.php';

final class FooterComponent extends Component {

    public function __construct() {}

    public function __invoke() {
        echo 'made by <a href="http://github.com/tix6" target="_blank">tix6</a>.';
    }
}

 ?>
