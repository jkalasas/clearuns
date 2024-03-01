<nav>
	<ul>
		<li><a href="/admin/">Home</a></li>
		<li><a href="/admin/user/create.php">Create User</a></li>
		<?php if (count($roles) > 1) { ?>
			<li><a href="/choose-role.php">Change Role</a></li>
		<?php } ?>
		<li><a href="/logout.php">Logout</a></li>
	</ul>
</nav>
