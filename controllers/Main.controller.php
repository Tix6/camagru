<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/Register.controller.php';


final class Main_Ctrl extends Controller {

    private $_user;
    private $_reg;

    public function __construct( array $args ) {
        if (isset($args['id']) === TRUE)
            $this->_user = User::get_item_by_id($args['id']);
        // echo "utilisateur: " . var_dump($this->_user);
        $this->_reg = new Register_Ctrl();
        $this->_reg = $this->_reg->render();
        $this->render();
    }

    public function render() {
        echo
"<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">
    <title>Camagru</title>
    <meta name=\"description\" content=\"\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" href=\"css/reset.css\">
    <link rel=\"stylesheet\" href=\"css/style.css\">
    <link href=\"https://fonts.googleapis.com/css?family=Patrick+Hand+SC\" rel=\"stylesheet\">
</head>
<body>
  <header>
      <h1 class=\"title\"><a href=\"index.php\">Camagru</a></h1>
  </header>
  <div class=\"container\">
  <section>
  $this->_reg
  </section>
  <aside>
      pictures pagination
  </aside>
  <footer>
      footer de qualite
  </footer>
  </div>
</body>
</html>";
    }
}

?>
