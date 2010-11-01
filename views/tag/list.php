<table class="tabularData">
	<thead>
		<tr>
			<th>Name</th>
			<th>Entries tagged</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($tags as $tag): ?>
			<tr onmouseover="$(this).addClass('highlightRow');" onmouseout="$(this).removeClass('highlightRow');" onclick="location.href ='<?=rawurl_from_appurl("/tag/show/".$tag->id)?>';">
				<td><?=$tag->name?></td>
				<td><?=count($tag->entries)?></td>
				<? $total = 0; foreach($tag->entries as $entry){ $total += $entry->amount; } ?>
				<td class="<?=col($total)?>"><?=mon($total)?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>

<? $f = new \HappyPuppy\form($newtag); ?>
<?= $f->start("create") ?>
<table>
	<tbody>
		<tr>
			<td><?=$f->label("Name", "name")?></td>
			<td><?=$f->input("name")?></td>
		</tr>
	</tbody>
</table>
<?= $f->submit("Add New Tag") ?>
<?= $f->end() ?>