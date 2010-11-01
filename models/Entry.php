<?

namespace budget;
class Entry extends \HappyPuppy\dbobject
{
	var $import;
	var $autofilled;
	var $_shared_between;
	
	function __construct()
	{
		parent::__construct("entry", __NAMESPACE__);
		$this->habtm(
			"people",
				"name",
				'\\budget\\Person',
				"person",
				"id",
				"entry_person",
				"entry_id",
				"person_id");
		$this->has_one("tag");
		$this->has_one("bank_account", "\\budget\\BankAccount", "bankaccount", "charged_to");
	}
	function __set($name, $value)
	{
		$parent_call_success = true;
		try { parent::__set($name, $value); } catch (Exception $e){ $parent_call_success = false; }
		if ($$parent_call_success){ return $value; }
		if($name == "shared_between")
		{
			$people = array();
			if ($value == null || $value == "")
			{
				return;
			}
			foreach(explode(' ', $value) as $person_name)
			{
				$person = Person::find_by_name($person_name);
				if ($person != null)
				{
					$people[] = $person;
				}
			}
		}
	}
	function __get($name){
		$value = parent::__get($name);
		if ($value != null || is_array($value)){ return $value; }
		if ($name == "shared_between")
		{
			return join(" ",$this->people);
		}
		if ($name == "budgeted?")
		{
			return count($this->people) != 0;
		}
		if ($name == "rowclass")
		{
			if (!$this->import)
			{
				return "redrow";
			}
			else if ($this->autofilled)
			{
				return "autofilledrow";
			}
			return "";
		}
		if ($name == "similar_in_db")
		{
			return Entry.find_by_amount_and_date($this->amount, $this->date);
		}
	}
	function share($person_id){
		if (count($this->people) == 0){ return 0; }
		foreach($this->people as $person)
		{
			if ($person->id == $person_id)
			{
				return $this->amount / count($this->people);
			}
		}
		return 0;
	}
	function list_people()
	{
		$out = '';
		foreach($this->people as $person)
		{
			$out .= $person->name." ";
		}
		return $out;
	}
	function expand_descriptions()
	{
		if ($this->_description == null) { return; }
		foreach(Expand::getAll() as $expand)
		{
			if ($this->description.include($expand.in))
			{
				$this->description = $expand.out;
				$this->tag = $expand.tag;
				if ($expand.shared_between != null && !expand.shared_between != "")
				{
					$this->shared_between = $expand.shared_between;
				}
				$this->autofilled = true;
			}
		}
	}
	function isChargedTo($person)
	{
		foreach($this->people as $p)
		{
			if ($p->id == $person->id){ return true; }
		}
		return false;
	}
}
?>