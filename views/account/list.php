<h2>Accounts for: <?=$person->name?></h2>
<div><?= PhpRender::render('account/table', "accounts", $accounts) ?></div>
<p><?= jslink("Add New Account", "/person/".$person->id."/account/new", "$('#newAccount').slideToggle();") ?></p>
<div id="newAccount" style="display: none">
<?= $new_account_form->start("create") ?>
<input type="hidden" name="BankAccount[person_id]" value="<?=$person->id?>" />
<table>
	<thead></thead>
	<tbody>
		<tr>
			<td><?= $new_account_form->label("name", "Name") ?></td>
			<td><?= $new_account_form->input("name") ?></td>
		</tr>
		<tr>
			<td><?= $new_account_form->label("beginning_balance", "Beginning Balance") ?></td>
			<td><?= $new_account_form->input("beginning_balance") ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?= $new_account_form->submit("Add New Bank Account") ?></td>
		</tr>
	</tbody>
</table>
<?= $new_account_form->end() ?>
</div>
<div><?= link_to("Back to list of people", "/person/list") ?></div>
