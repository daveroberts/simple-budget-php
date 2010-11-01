<?

namespace budget;

class BankAccount extends \HappyPuppy\dbobject
{
	function __construct(){
		parent::__construct("bankaccount");
		parent::has_one("owner", "\\budget\\Person", 'person');
		parent::has_many("entries", "date", "\\budget\\Entry", "entry", "charged_to");
		parent::setDescription("name");
	}
	var $_balance;
	var $_expenses;
	var $_revenues;

	public function __get($name){
		$value = parent::__get($name);
		if ($value != null || is_array($value)){ return $value; }
		if ($name == "balance")
		{
			if ($this->_balance == null)
			{
				$this->_balance = $this->balance_as_of(time());
			}
			return $this->_balance;
		}
		if ($name == "expenses")
		{
			if ($this->_expenses == null)
			{
				$total = 0;
				foreach($this->entries as $entry)
				{
					if ($entry->amount < 0)
					{
						$total += $entry->amount;
					}
				}
				$this->_expenses = $total;
			}
			return $this->_expenses;
		}
		if ($name == "revenues")
		{
			if ($this->_revenues == null)
			{
				$total = 0;
				foreach($this->entries as $entry)
				{
					if ($entry->amount > 0)
					{
						$total += $entry->amount;
					}
				}
				$this->_revenues = $total;
			}
			return $this->_revenues;
		}
		return null;
	}
	public static function getTablename(){ return "BankAccount"; }
	public function balance_as_of($date){
		if ($date == null)
		{
			$total = $this->beginning_balance;
			foreach($this->entries as $entry)
			{
				$total += $entry->amount;
			}
			return $total;
		}
		else
		{
			$total = $this->beginning_balance;
			foreach($this->entries as $entry)
			{
				$dateArr = explode("-",$entry->date);
				$dateInt1 = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]) ;
				$dateInt2 = $date;

				if ($dateInt1 - $dateInt2 > 0)
				{
					$total += $entry->amount;
				}
			}
			return $total;
		}
	}
	static function sort($arr){
		return usort($arr, BankAccount::cmp);
	}
	static function cmp($a, $b){
		if ($a->name == $b->name) { return 0; }
		return strcmp($a, $b) ? -1 : 1;
	}
	public function ranged_entries($from_date, $to_date){
		$entry = new Entry();
		$conditions = ''; $order = 'date desc';
		if ($this->from_date != null && $this->to_date != null)
		{
			$conditions = sprintf("charged_to=%s AND date BETWEEN '%s' AND '%s'", $this->id, $from_date, $to_date);
		}
      	else if ($this->from_date != null )
      	{
			$conditions = sprintf("charged_to=%s AND date AFTER '%s'", $this->id, $from_date);
      	}
      	else if ($this->to_date != null )
      	{
			$conditions = sprintf("charged_to=%s AND date BEFORE '%s'", $this->id, $to_date);
      	}
      	else
      	{
			$conditions = sprintf("charged_to=%s", $this->id);
      	}
      	return $entry->find(array("conditions"=>$conditions, "order"=>$order));
	}
	public function tags()
	{
		$sql = "select distinct t.* from tag t left join entry e on e.tag_id = t.id left join bankaccount b on e.charged_to = b.id where b.id = ".$this->id;
		return Tag::FindBySQL($sql);
	}
}
?>