<?php if(isset($_GET['id'])): ?>
	<?php
	  include_once "backend/process.php";

	  $news = $model->getAnnouncementById($_GET['id']);
	?>
	<?php foreach($news as $idx => $a): ?>
		<div class="blog-post">
		<h2 class="blog-post-title"> <?= $a['title']?></h2>
		<p class="blog-post-meta"><?= $a['dateadded']?> by <a href="#"><?= $a['username']?></a></p>
		<p><?= $a['description']?></p>
		</div><!-- /.blog-post -->
	<?php endforeach ?>
<?php endif ?>