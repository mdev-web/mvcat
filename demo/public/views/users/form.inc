<article>
	<h1>Users</h1>
	<h3>Form</h3>

	<form action="users"method="post">
		Firstname: <input type="text" name="fname" value="" maxlength="90" style="width: 100px;"> <br>
		Lastname: <input type="text" name="lname" value="" maxlength="90" style="width: 100px;"> <br>
		Active: <input type="checkbox" id="active" name="active" <?= filter_var($active, FILTER_VALIDATE_BOOLEAN) ? "checked" : "" ?>> <br>
		<input type="submit" value="<?= $form === "create" ? "Create user" : "Update user"; ?>">
	</form>
</article>