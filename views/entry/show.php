<p><?=link_to("Edit", "/entry/edit/".$entry->id)?></p>

<div><?= PhpRender::render('entry/entryview', "entry", $entry) ?></div>

<p><?=link_to("Cash Flow for ".$entry->bank_account->name, '/account/cashflow/'.$entry->bank_account->id)?></p>
