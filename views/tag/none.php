<h1>Untagged Entries</h1>
<div><?= PhpRender::render('tag/table', "entries", $entries) ?></div>
<p><?=link_to_action("Back to tag listing", "list")?></p>