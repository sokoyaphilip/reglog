<?php if(Session::exists('success')): ?>
<div class="alert alert-success">
	<strong><?= Session::flash('success'); unset($_SESSION['success']);?></strong>
</div>
<?php endif; ?>
    
<?php if(Session::exists('error')):?>
<div class="alert alert-danger">
	<strong><?= Session::flash('error'); unset($_SESSION['error']);?></strong>
</div>
<?php endif; ?>

