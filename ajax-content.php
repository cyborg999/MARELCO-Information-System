<?php
  include_once "backend/process.php";
  include_once "backend/chikkaConfig.php";

  $nature = $model->getNatureById($_GET['id']);
?>
<div class="col-sm-10  blog-main">
  <div class="blog-post" style="border:0px!important;">
    <h2 class="blog-post-title"><?= $nature['name']?></h2>
    
    <p class="blog-post-meta" style="margin:0px;border:0px!important;">Description:    <span style="color: black;font-size: 13px;">
      <?= $nature['description'];?>
    </span></p>
    <br>
    <?php $req = explode(",", $nature['requirements']); ?>
    <ol>
      <?php foreach($req as $idx => $r): ?>
        <?php if($r != ""):?>
          <li><?= $r;?></li>
        <?php endif ?>
      <?php endforeach ?>
    </ol>
    <br>
    <blockquote >
      Follow the instruction below to make a request/complaint:<br>
       <p>C-<?= $nature['id'];?> FIRSTNAME,MIDDLENAME,LASTNAME/BRGY,MUNICIPALITY </p>
       <br> to <b><?= $shortCode;?></b> 
      
      <br>
      <br>
      e.g
      <br>
      <em>C-<?= $nature['id'];?> Juan,Lopez,Delacrus/Pili,Boac</em>
    </blockquote>
  </div>
</div>