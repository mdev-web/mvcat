<article>
	<h1>Users</h1>
	<p>Show All users</p>

	<table border="1">
		<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Active</th>
			<th>link</th>
		</tr>
		<?php foreach ($users as $user) { ?>
		<tr>
			<td><?= $user->getFirstname(); ?></td>
			<td><?= $user->getLastname(); ?></td>
			<td><?= $user->isActive() ? "yes" : "no"; ?></td>
			<td><a href="users/<?= $user->getId();?>">show</a></td>
		</tr>
		<?php } ?>
	</table>

</article>