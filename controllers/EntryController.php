<?

namespace budget;
class EntryController extends \HappyPuppy\Controller
{
	function create(){
		$this->entry = new Entry();
		$this->entry->build($_POST["Entry"]);
		$success = $this->entry->save();
		
		if ($success)
		{
			$this->flash = "New Entry Added";
			if ($this->entry->bank_account == null)
			{
				$person = reset($this->entry->people);
				$person_id = $person->id;
				$this->redirect_to("/person/$person_id/account/list");
			}
			else
			{
				$this->redirect_to('/account/cashflow/'.$this->entry->bank_account->id);
			}
		} else {
			$this->view_template = "account/cashflow";
			$this->flash = "Entry not able to be saved";
		}
	}
	function show($entry_id){
		$this->entry = Entry::Get($entry_id);
	}
	function edit($entry_id){
		$this->entry = Entry::Get($entry_id);
	}
	function update(){
		$this->entry = new Entry();
		$this->entry->build($_POST["Entry"]);
		$error_msg = '';
		$success = $this->entry->save($error_msg);
		if ($success)
		{
			$this->redirect_to('/account/cashflow/'.$this->entry->bank_account->id);
		}
		else
		{
			$this->view_template = "entry/edit";
			$this->flash = $error_msg;
		}
	}
	function delete($entry_id){
		$this->entry = Entry::Get($entry_id);
		if (isset($_POST["delete_id"]))
		{
			$bank_account_id = $this->entry->bank_account->id;
			$this->entry->destroy();
			$this->redirect_to("/account/cashflow/$bank_account_id");
		}
	}
	/**
	* !Route GET, /entry/list/unaccounted
	*/
	function listUnaccounted(){
		$e = new Entry();
		$this->entries = $e->find(array("conditions"=>"charged_to is null"));
		print("<pre>");
		foreach($this->entries as $entry)
		{
			print($entry->prettyPrint());
		}
		print("</pre>");
		$this->text_only = true;
	}
}

?>