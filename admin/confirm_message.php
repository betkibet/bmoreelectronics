<?php
//START for show confirmation message for success
if($_SESSION['success_msg']!=""){ ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		<strong>
			Well done!
		</strong>
		<?=$_SESSION['success_msg']?>
	</div>
<?php
} unset($_SESSION['success_msg']);
//END for show confirmation message for success

//START for show confirmation message for error
if(@$_SESSION['error_msg']){ ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		<strong>
			Oh snap!
		</strong>
		<?=$_SESSION['error_msg']?>
	</div>
<?php
} unset($_SESSION['error_msg']);
//END for show confirmation message for error ?>
