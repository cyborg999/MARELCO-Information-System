<?php if(isset($_GET['nature'])): ?>
  <?php
    include_once "backend/process.php";

    $nature = $model->getNatureRequirementByName($_GET['nature']); 
    $checklist = $model
      ->getRequirementChecklistByNatureAndConsumerId($_GET['nature'],$_GET['id']);

    $req = explode(",", $nature[0]['requirements']); 
    ?>
       <ul>
          <?php foreach($req as $idx => $r): ?>
          <li data-content="<?= $r; ?>">
          <label>
            <input type="checkbox" <?= (array_key_exists(trim($r), $checklist)) ? ($checklist[trim($r)] == "1") ? "checked" : "": "";?> name="checklist[]" value="<?= $r;?>"/> 
            <?= $r; ?>
          </label>
          </li>
        <?php endforeach ?>
        </ul>
<?php endif ?>