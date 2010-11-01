<div><a href="#" onclick="$('#date_range_select').slideToggle();">Date Range Select</a></div>
<div id="date_range_select" style="display: none;">
	<?= PhpRender::render_arr('date/range', array("from_date"=>$from_date, "to_date"=>$to_date, "id"=>$account->owner->id)) ?>
</div>
<h1><?= $account->name ?>: Statement of Cash Flow</h1>
<div><a href="#" onclick="$('#newEntry').slideToggle();">Add New Entry</a></div>
<div id="newEntry" style="display: none;">
	<? $f = new \HappyPuppy\form($entry); ?>
	<?= $f->start("/entry/create") ?>
		<fieldset>
			<legend>New Entry</legend>
			<div><?= PhpRender::render('entry/entry', "entry", $entry) ?></div>
			<p><input type="submit" value="Add new entry" /></p>
		</fieldset>
	<?=$f->end()?>
</div>
<? $starting_balance = $account->balance_as_of($to_date);?>
<p>Balance <?= mon($starting_balance) ?></p>
<div><?= PhpRender::render_arr('entry/table', array("entries"=>$entries, "starting_balance"=>$starting_balance)) ?></div>
<div><?=link_to("Net Worth", "/account/networth/".$account->id)?></div>
<div><?=link_to("List of Accounts", "/person/".$account->owner->id."/account/list")?></div>