<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Sticker.class.php';

final class TreatComponent extends Component {

    private $_base64_pic;
    private $_stickers;

    private $_colors = array(
        'Noir'      => 'black',
        'Blanc'     => 'white',
        'Gris'      => 'gray',
        'Bleu'      => 'royalblue',
        'Cyan'      => 'cyan',
        'Vert'      => 'green',
        'Rouge'     => 'red',
        'Jaune'     => 'yellow',
        'Or'        => 'gold',
        'Orange'    => 'orange',
        'Violet'    => 'blueviolet',
        'Rose'      => 'violet'
    );

    public function __construct() {
      $this->_base64_pic = $_POST['picture'];
      $this->_stickers = Sticker::fetch_all();
    }

    public function __invoke() {
        $colors = $this->_colors;
        $stickers = array(0 => '<option value="">aucun</option>');
        foreach ($this->_stickers as $sticker) {
            $stickers[] = "<option value=\"{$sticker['path']}\">{$sticker['title']}</option>";
        }
        echo '
        <div id="visu">
            <img id="dragItem" draggable="true" style="width:100%;height:auto;position:absolute;" ondragstart="return true;">
            <img id="pictureInput" alt="Embedded Image" src="' . $this->_base64_pic . '" />
        </div>
        <form action="save.php" method="POST">
            <label>1. Choisissez un titre</label>
            <input type="text" name="title" value="" placeholder="indiquez un titre">
            <label>2. Choisissez un autocollant <i class="optional">(optionnel)</i></label>
            <span>type :</span>
            <select id="stickers" name="sticker">'
                . implode("\n", $stickers) .
            '</select>
            <span>taille :</span>
            <select id="sticker-ratio" name="ratio">
                <option value="0.1">petit</option>
                <option value="0.2">moyen</option>
                <option value="0.3">grand</option>
                <option value="0.4">geant</option>
            </select>
            <span>transparence :</span>
            <select id="sticker-opacity" name="opacity">
                <option value="1">100 %</option>
                <option value="0.9">90 %</option>
                <option value="0.8">80 %</option>
                <option value="0.7">70 %</option>
                <option value="0.6">60 %</option>
                <option value="0.5">50 %</option>
                <option value="0.4">40 %</option>
                <option value="0.4">30 %</option>
                <option value="0.2">20 %</option>
                <option value="0.1">10 %</option>
            </select>
            <label>3. Choisissez une bordure <i class="optional">(optionnel)</i></label>
            </select>
            <span>taille :</span>
            <select id="border-size" name="ratio">
            <option value="0">aucun</option>
            <option value="3">petit</option>
            <option value="30">moyen</option>
            <option value="140">grand</option>
            </select>
            <span>couleur :</span>
            <select id="border-color" name="border-color">';
            foreach ($colors as $name => $value) {
                echo "<option value=\"$value\">$name</option>";
            }
            echo '</select>
            <label>4. Ajouter du texte <i class="optional">(optionnel)</i></label>
            <input id="text-top" type="text" name="top-text" value="" placeholder="texte du haut">
            <input id="text-bottom" type="text" name="bottom-text" value="" placeholder="texte du bas">
            <span>couleur :</span>
            <select id="text-color" name="text-color">';
            foreach ($colors as $name => $value) {
                echo "<option value=\"$value\">$name</option>";
            }
            echo '</select>
            <input id="inputX" type="hidden" name="x" value="">
            <input id="inputY" type="hidden" name="y" value="">
            <input id="inputRatio" type="hidden" name="ratio" value="">
            <input id="inputOpacity" type="hidden" name="opacity" value="">
            <input id="inputCanvas" type="hidden" name="canvas" value="">
            <button type="submit" class="next">Valider</button>
        </form>
        <script type="text/javascript" src="assets/treat.js"></script>
        ';
    }
    // <div id="drag" draggable="true" style="position:absolute;background-color:red;width:20px;height:20px;"></div>

}

?>
