<table class="tabularData">
	<tbody>
		<tr>
			<td>Description</td>
			<td><?=$entry->description?></td>
		</tr>
		<tr>
			<td>Amount</td>
			<td><span class="<?=col($entry->amount)?>"><?=mon($entry->amount)?></span></td>
		</tr>
		<tr>
			<td>Date</td>
			<td><?=$entry->date?></td>
		</tr>
		<tr>
			<td>Tag</td>
			<td><?=$entry->tag->name?></td>
		</tr>
		<tr>
			<td>Transfer</td>
			<td><?= $entry->transfer ? "Yes" : "No" ?></td>
		</tr>
		<tr>
			<td>Charged To</td>
			<td><?=$entry->bank_account->name?></td>
		</tr>
		<tr>
			<td>Split Between</td>
			<td>
				<div style="margin-top: 1em;">
					<?foreach($entry->people as $person):?>
						<div><?= $person->name ?></div>
					<?endforeach;?>
				</div>
			</td>
		</tr>
	</tbody>
</table>