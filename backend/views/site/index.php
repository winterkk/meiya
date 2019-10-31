<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body class="<?= \dmstr\helpers\AdminLteHelper::skinClass() ?>">
<?php
	$this->params['breadcrumbs'][] = 'About';
	$this->beginBlock('content-header'); ?>
	
	About <small>static page</small>
	<?php $this->endBlock(); ?>

	<div class="site-about">
	    <p> This is the About page. You may modify the following file to customize its content: </p>
	    <code><?= __FILE__ ?></code>
	</div>
</body>
</html>
