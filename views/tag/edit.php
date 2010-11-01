<? $f = new \HappyPuppy\form($tag); ?>
<?= $f->start("update") ?>
<div><?= $f->hidden("id", $tag->id) ?></div>
<div><?= PhpRender::render('tag/tag', "tag", $tag) ?></div>
<p><input type="submit" value="Update tag" /></p>
<?= $f->end() ?>
<?=link_to("Delete", "/tag/delete/".$tag->id, array("onclick"=>js_delete_confirm("Are you sure you want to delete ".$tag->name."?", $tag->id)))?>
<div><?=link_to("Back to Tag list", "/tag")?></div>