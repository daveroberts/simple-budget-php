<? $f = new \HappyPuppy\form($entry); ?>
<table>
	<tbody>
		<tr>
			<td><?=$f->label("Description", "description")?></td>
			<td><?=$f->input("description")?></td>
		</tr>
		<tr>
			<td><?=$f->label("Amount", "amount")?></td>
			<td><?=$f->input("amount")?></td>
		</tr>
		<tr>
			<td><?=$f->label("Date", "date")?></td>
			<td><?=$f->input("date", array("class"=>"datepicker"))?></td>
		</tr>
		<tr>
			<td><?=$f->label("Tag", "tag")?></td>
			<td><?=$f->input("tag")?></td>
		</tr>
		<tr>
			<td><?=$f->label("Transfer", "transfer")?></td>
			<td><?=$f->input("transfer")?></td>
		</tr>
		<tr>
			<td><?=$f->label("Charged To", "bank_account")?></td>
			<td><?=$f->input("bank_account")?></td>
		</tr>
		<tr>
			<td>Split Between</td>
			<td>
				<div style="margin-top: 1em;">
					<input type="hidden" name="Entry[rel_ids_people]" value="" />
					<?foreach(\budget\Person::all() as $person):?>
						<div>
							<?= \HappyPuppy\HtmlCheckbox::make("chkSplitBetween_".$person->name, $person->id, $entry->isChargedTo($person), "Entry[rel_ids_people][]") ?>
							<?= \HappyPuppy\HtmlLabel::make("chkSplitBetween_".$person->name, $person->name)?>
						</div>
					<?endforeach;?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
