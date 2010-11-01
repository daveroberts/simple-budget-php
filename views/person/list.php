<table class="tabularData">
	<thead>
		<tr>
			<th>Name</th>
			<th>Accounts</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($people as $person): ?>
			<tr>
				<td><?= link_to($person->name, "/person/".$person->id."/account/list") ?></td>
				<td><?=count($person->bank_accounts)?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<?= $new_person_form->start("new") ?>
<table>
	<thead></thead>
	<tbody>
		<tr>
			<td><?= $new_person_form->label("name", "Name") ?></td>
			<td><?= $new_person_form->input("name") ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?= $new_person_form->submit("Add New Person") ?></td>
		</tr>
	</tbody>
</table>
<?= $new_person_form->end() ?>
