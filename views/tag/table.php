<table class="tabularData">
	<thead>
		<tr>
			<th>Description</th>
			<th>Amount</th>
			<th>Paid By</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($entries as $entry): ?>
			<tr class="<?=cycle("even","odd")?>">
				<td><?= link_to($entry->description, "/entry/show/".$entry->id)?></td>
				<td class="<?=col($entry->amount)?>"><?=mon($entry->amount)?></td>
				<? if ($entry->bank_account != null) { ?>
					<td><?=link_to($entry->bank_account->owner->name."'s ".$entry->bank_account->name, "/account/cashflow/".$entry->bank_account->id)?></td>
				<? } else {?>
					<td><?=link_to('Unassigned Entry', "/account/none/")?></td>
				<? }?>
				<td><?=$entry->date?></td>
			</tr>
		<? endforeach; ?>
	</tbody>
</table>
<p>Total: <?=mon($total)?></p>