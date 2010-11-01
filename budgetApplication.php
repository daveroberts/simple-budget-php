<?
namespace budget;

//require('/content/chart/php-ofc-library/open-flash-chart.php');
//require('/content/chart/gChart.php');

class budgetApplication extends \HappyPuppy\Application
{
	function defaultController(){ return "Person"; }
	
	public function __init()
	{
		$this->require_file('controllers/helper.php');
		$_ENV["config"]["plural_db_tables"] = 1;
		$this->title = "Simple Budget";
	}
}
?>