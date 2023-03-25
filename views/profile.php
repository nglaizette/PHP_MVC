<?php
/** @var $this \app\core\View */
$this->title = 'Profile';
?>

<h1> Profile </h1>
<form action="" method="post">
	<div class="mb-3">
		<label class="form-label">Subject</label>
		<input type="text" class="form-control" name="subject">
	</div>
	<div class="mb-3">
		<label class="form-label">Email</label>
		<input type="text" class="form-control" name="email">
	</div>
	<div class="mb-3">
		<label class="form-label">Body</label>
		<textarea class="form-control" name="body"></textarea>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>