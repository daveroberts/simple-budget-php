<div><?= PhpRender::render('account/table', "accounts", $accounts) ?></div>
<div><?=link_to("Entries without an Account", '/account/none')?></div>