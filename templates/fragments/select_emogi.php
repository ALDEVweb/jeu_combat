<?php

// fragment : construit le select du personnage

include "modeles/tableaux.php";


?>

<div class="flex mt16 a-center">
    <label for="emogi" class="yellow mr20 w150p fs12"> Emogi : </label>
    <select class="w130p" name='emogi' id="emogi">
        <?php
        if($emogi_select === ""){
            ?>
            <option value=''>---</option>
            <?php
        }else{
            ?>
            <option value='<?= $emogi_select ?>'><?= $emogis[$emogi_select] ?></option>
            <?php
        }
        foreach ($emogis as $id => $emogi) {
            ?>
            <option value="<?= $id ?>"><?= $emogi ?></option>
            <?php
        }
        ?>
    </select>
</div>
