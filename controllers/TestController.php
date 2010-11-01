<?

//todo INSERTS should handle nulls not as empty strings
namespace budget;
class testController extends \HappyPuppy\Controller
{
	public function test()
	{
		print('<pre>');
		$people = Person::All();
		foreach($people as $p)
		{
			print($p->prettyPrint());
			foreach($p->bank_accounts as $bank_account)
			{
				print($bank_account->prettyPrint());
			}
		}
		//print(Person::all());
		//$sql = 'select b.id as __id, p.* from bank_account b left join person p on b.person_id = p.id';
		/*$bank_accounts[0]->load_relation($sql, "owner");
		foreach($bank_accounts as $b)
		{
			print($b->prettyPrint());
		}*/
		print('</pre>');
		exit();
		//$this->render_text("You rock! (".$person->bank_accounts[0]->owner->name.")");
	}
}
?>
