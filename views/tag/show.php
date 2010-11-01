<h1><?=$tag->name?> breakdown</h1>
<div><?=link_to("Edit", "/tag/edit/".$tag->id)?></div>
<div><?= PhpRender::render('tag/table', "entries", $tag->entries) ?></div>
<p><?=link_to_action("Back to tag listing", "list")?></p>