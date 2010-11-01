<table class="tabularData">
<? $total = 0; ?>
<? foreach($accounts as $account) {
	$total += $account->balance; ?>
	<tr>
		<td><?= link_to($account->name, "/account/cashflow/".$account->id) ?></td>
		<td style="text-align: right;">
			<span class="<?=col($account->balance)?>"><?= mon($account->balance) ?></span>
		</td>
		<td><?=link_to("Delete", "/account/delete/".$account->id, array("onclick"=>js_delete_confirm("Are you sure you want to delete ".$account->name."?", $account->id)))?></td>
	</tr>
<? } ?>
	<tr>
		<td>Total</td>
		<td style="text-align: right;">
			<span style="color: <?=col($total)?>">
				<?= mon($total) ?>
			</span>
		</td>
		<td></td>
	</tr>
</table>