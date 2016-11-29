<?php

require_once dirname(__FILE__) . '/Component.php';

final class MetaComponent extends Component {

    public function __construct() {}

    private function _display_menu() {
        $menu = array();
        foreach ($this->_to_display as $elem) {
            $menu[] = "<li><a href=\"{$elem[1]}\">{$elem[0]}</a></li>";
        }
        return implode("\n", $menu);
    }

    public function __invoke() {
        echo '
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Camagru</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/fontello-embedded.css">
        <link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
        ';
    }
}

 ?>
