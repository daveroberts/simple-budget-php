<?

namespace budget;
class Person extends \HappyPuppy\dbobject
{
	#id
	#name
	function __construct(){
		parent::__construct();
		$this->has_many("bank_accounts", "name");
		$this->habtm("entries", "date");
	}
	function expenses_paid($other_person_id){
		$receivables = 0;
		if (count($this->bank_accounts) == 0){ return 0; }
		foreach($this->bank_accounts as $account)
		{
			if (count($account->entries) == 0) return 0;
			foreach($account->entries as $entry)
			{
				$paid_by_person = false;
				foreach($entry->people as $person)
				{
					if ($person->id == $other_person_id)
					{
						$paid_by_person = true;
						break;
					}
				}
				if ($paid_by_person)
				{
					$receivables += $entry->share;
				}
			}
		}
		return $receivables;
	}
	function debts(){
		$debts_data = array();
		foreach(Person::all() as $person)
		{
			if ($person->id == $this->id){ continue; }
			$receivables = $this->expenses_paid($person->id);
			$payables = Person::find($person->id).expenses_paid($this->id);
			$debts_data[$person->id] = receivables - payables;
		}
		return $debts_data;
	}
	function expenses_by_tag($tag_id){
		$expenses = 0;
		foreach($this->entries as $entry)
		{
			if($tag_id == -1 && $entry->tag == null)
			{
				$expenses += $entry->share;
			}
			else if ($entry->tag != null && $entry->tag->id == $tag_id)
			{
				$expenses += $entry->share;
			}
		}
		return $expenses;
	}
	function expenses($from, $to){
		$sum = 0;
		foreach($this->entries as $entry)
		{
			if ($entry->date >= $from && $entry->date <= to && $entry->share < 0 && !$entry->transfer)
			{
				$sum += abs($entry->share);
			}
		}
		return $sum;
	}
	function revenues($from, $to){
		$sum = 0;
		foreach($this->entries as $entry)
		{
			if ($entry->date >= $from && $entry->date <= to && $entry->share > 0 && !$entry->transfer)
			{
				$sum += abs($entry->share);
			}
		}
		return $sum;
	}
	function __get($name){
		$value = parent::__get($name);
		if ($value != null || is_array($value)){ return $value; }
		if ($name == "first_entry")
		{
			$earliest = date();
			foreach($this->entries as $entry)
			{
				if ($entry->date < $earliest)
				{
					$earliest = $entry->date;
				}
			}
			return $earliest;
		}
		else if ($name == "last_entry")
		{
			$latest = date();
			foreach($this->entries as $entry)
			{
				if ($entry->date > $earliest)
				{
					$latest = $entry->date;
				}
			}
			return $latest;
		}
		return null;
	}
	public function __call  ($name, $arguments){
		return parent::__call($name, $arguments);
	}
	function networth($as_of){
		$networth = 0;
		foreach($this->bank_accounts as $account)
		{
			$networth += $account->balance_as_of($as_of);
		}
		return $networth;
	}
}
?>