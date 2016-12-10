<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Sticker.class.php';

final class TreatComponent extends Component {
    const NEED_AUTH = true;
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
        parent::__construct();
        $this->_base64_pic = $_POST['picture'];
        $this->_stickers = Sticker::fetch_all();
    }

    public function __invoke() {
        if (parent::__invoke() === false)
            return ;
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
            <div class="step-1">
                <h3>1. Choisissez un titre</h3>
                <label>Titre :
                <input type="text" name="title" value="" placeholder="indiquez un titre">
                </label>
            </div>
            <div class="step-2">
                <h3>2. Choisissez un autocollant <i class="optional">(optionnel)</i></h3>
                <label>Type :
                <select id="stickers" name="sticker">'
                    . implode("\n", $stickers) .
                '</select>
                </label>
                <label>Taille :
                <select id="sticker-ratio" name="ratio">
                    <option value="0.1">petit</option>
                    <option value="0.2">moyen</option>
                    <option value="0.3">grand</option>
                    <option value="0.4">geant</option>
                </select>
                </label>
                <label>Transparence :
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
                </label>
            </div>
            <div class="step-3">
                <h3>3. Choisissez une bordure <i class="optional">(optionnel)</i></h3>
                <label>Taille :
                <select id="border-size" name="ratio">
                <option value="0">aucun</option>
                <option value="20">petit</option>
                <option value="50">moyen</option>
                <option value="130">grand</option>
                </select>
                </label>
                <label>Couleur :
                <select id="border-color" name="border-color">';
                foreach ($colors as $name => $value) {
                    echo "<option value=\"$value\">$name</option>";
                }
                echo '</select>
                </label>
            </div>
            <div class="step-4">
                <h3>4. Ajouter du texte <i class="optional">(optionnel)</i></h3>
                <label>Couleur :
                <select id="text-color" name="text-color">';
                foreach ($colors as $name => $value) {
                    echo "<option value=\"$value\">$name</option>";
                }
                echo '</select>
                </label>
                <label>Ombre :
                <input id="text-shadow" type="checkbox"> activer
                </label>
                <label>Haut :
                <input id="text-top" type="text" name="top-text" value="" placeholder="texte du haut">
                </label>
                <label>Bas :
                <input id="text-bottom" type="text" name="bottom-text" value="" placeholder="texte du bas">
                </label>
            </div>
            <div class="step-5">
                <h3>5. Desinner <i class="optional">(optionnel)</i></h3>
                <label><input id="draw-checkbox" type="checkbox"> activer</label>
                <label>Couleur :
                <select id="draw-color">';
                foreach ($colors as $name => $value) {
                    echo "<option value=\"$value\">$name</option>";
                }
                echo '</select>
                </label>
                <a id="draw-reset" href="#">Effacer</a>
            </div>
            <input id="inputX" type="hidden" name="x" value="">
            <input id="inputY" type="hidden" name="y" value="">
            <input id="inputRatio" type="hidden" name="ratio" value="">
            <input id="inputOpacity" type="hidden" name="opacity" value="">
            <input id="inputCanvas" type="hidden" name="canvas" value="">
            <a id="prev-step" href="#"><< Précédent</a>
            <a id="next-step" href="#">Suivant >></a>
            <button type="submit" class="validation">Valider</button>
        </form>
        <script type="text/javascript" src="assets/treat.js"></script>
        ';
    }
}

?>
