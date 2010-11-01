<div id="columnTogglesLinkDiv" style="height: 2.5em;"><a href="#" onclick="$('#columnTogglesLinkDiv').hide(); $('#columnToggles').show();">Show Adjust Columns</a></div>
<div id="columnToggles" style="display: none; height: 2.5em;">
	<a href="#" onclick="$('#columnToggles').hide(); $('#columnTogglesLinkDiv').show();">Hide Adjust Columns</a>
	<div>
		<input type="checkbox" id="chkDate" checked="checked" /><label for="chkDate">Date</label>
		<input type="checkbox" id="chkDescription" checked="checked" /><label for="chkDescription">Description</label>
		<input type="checkbox" id="chkAmount" checked="checked" /><label for="chkAmount">Amount</label>
		<input type="checkbox" id="chkTag" checked="checked" /><label for="chkTag">Tag</label>
		<input type="checkbox" id="chkShared" checked="checked" /><label for="chkShared">Shared</label>
		<input type="checkbox" id="chkBalance" checked="checked" /><label for="chkBalance">Balance</label>
	</div>
</div>
<table id="entryTable" class="draggable">
	<thead>
		<tr>
			<th id="colHeaderDate" class="colDate">Date</th>
			<th id="colHeaderDescription" class="colDescription">Description</th>
			<th id="colHeaderAmount" class="colAmount">Amount</th>
			<th id="colHeaderTag" class="colTag">Tag</th>
			<th id="colHeaderShared" class="colShared">Shared Between</th>
			<th id="colHeaderBalance" class="colBalance">Balance</th>
		</tr>
	</thead>
	<tbody>
		<? $balance = $starting_balance; ?>
		<? foreach($entries as $entry): ?>
			<tr onmouseover="$(this).addClass('highlightRow');" onmouseout="$(this).removeClass('highlightRow');" onclick="location.href ='<?=rawurl_from_appurl("/entry/show/".$entry->id)?>';" class="<?=cycle("even","odd")?>">
				<td class="colDate"><?=$entry->date?></td>
				<td class="colDescription"><?=$entry->description?></td>
				<td class="colAmount <?=col($entry->amount)?>"><?=mon($entry->amount)?></td>
				<td class="colTag">
					<? if ($entry->tag != null){ ?>
						<? $tagid = $entry->tag->id; $tagname = $entry->tag->name; ?>
						<?=link_to($tagname, "/tag/show/".$tagid, array("class"=>"tag_".$entry->tag->id))?>
					<? } else { ?>
						<?=link_to("Untagged", "/tag/none/", array("class"=>"tag"))?>
					<? } ?>
				</td>
				<td class="colShared"><?=$entry->list_people()?></td>
				<td class="colBalance"><?=mon($balance)?></td>
				<? $balance -= $entry->amount; ?>
			</tr>
		<? endforeach; ?>
		<tr class="<?=cycle("even","odd")?>" onmouseover="$(this).addClass('highlightRow');" onmouseout="$(this).removeClass('highlightRow');">
			<td class="colDate"></td>
			<td class="colDescription">Balance at beginning of period</td>
			<td class="colAmount <?=col($balance)?>"><?=mon($balance)?></td>
			<td class="colTag"></td>
			<td class="colShared"></td>
			<td class="colBalance"></td>
		</tr>
	</tbody>
</table>
