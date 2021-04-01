<?php echo form_open('users/login'); ?>
	<div class="row" style='margin-top: 150px;'>
		<div class="col-md-4 col-md-offset-4" style='margin: 0 auto;'>
			<h1 class="text-center"><?php echo $title; ?></h1>
			<div class="form-group">
				<input type="text" name="user_id" class="form-control" placeholder="Enter Username" required autofocus>
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Login</button>

		</div>
	</div>
<?php echo form_close(); ?>

<div class="col-md-4 col-md-offset-4" style='margin: 10px auto; padding-left:10px;padding-right:10px;'>
	<div class="form-group">
		<a href="<?php echo base_url(); ?>users/register" class="btn btn-info btn-block">Sign Up</a>
	</div>
</div> 