<?php echo validation_errors(); ?>

<?php echo form_open('users/register'); ?>
	<div class="row">
		<div class="col-md-4 col-md-offset-4" style='margin: 10px auto;'>
			<h1 class="text-center"><?= $title; ?></h1>
			<div class="form-group">
				<label>ID</label>
				<input type="text" class="form-control" name="user_id" placeholder="ID">
			</div>
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" name="user_nm" placeholder="Name">
			</div>
			
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" name="password" placeholder="password">
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" class="form-control" name="password2" placeholder="Confirm Password">
			</div>

			<div class="form-group">
				<label>Organization</label>
				<input type="text" class="form-control" name="org_nm" placeholder="Organization">
			</div>
			<div class="form-group">
				<label>Dept</label>
				<input type="text" class="form-control" name="org_dept_nm" placeholder="Dept">
			</div>
			<div class="form-group">
				<label>Position</label>
				<input type="text" class="form-control" name="org_position" placeholder="Position">
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="user_email" placeholder="Email">
			</div>
			<div class="form-group">
				<label>Phone</label>
				<input type="text" class="form-control" name="user_hp" placeholder="Phone">
			</div>
			<button type="submit" class="btn btn-primary btn-block">Submit</button>
		</div>
	</div>
<?php echo form_close(); ?>
