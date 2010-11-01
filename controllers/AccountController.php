<?

namespace budget;
class AccountController extends \HappyPuppy\Controller
{
	function defaultAction(){ return "list"; }
	function __init(){
		$this->currentNav = "accounts";
	}

	function all()
	{
		$this->title .= " - List of Accounts for everybody";
		$this->accounts = BankAccount::All("name");
	}
	/**
	* !Route GET, /person/$person_id/account/list
	*/
	function _list($person_id)
	{
		$this->person = Person::Get($person_id);
		$this->title .= " - List of Accounts for ".$this->person->name;
		$this->person_id = $person_id;
		$this->accounts = $this->person->bank_accounts;
		$new_account = new BankAccount();
		$this->new_account_form = new \HappyPuppy\form($new_account);
	}

	function create(){
    	$this->newaccount = new BankAccount();
		$this->newaccount->build($_POST["BankAccount"]);
		$error = '';
		$success = $this->newaccount->save($error);

		if ($success)
		{
			$this->flash = "New Account Added";
			$this->redirect_to("/person/".$this->newaccount->owner->id."/account/list");
		} else {
			$this->view_template = "account/all";
			$this->flash = "Account was not able to be created: ".$error;
			$this->title .= " - List of Accounts for everybody";
			$this->accounts = BankAccount::All("name");
		}
	}

	/**
	* !Route GET, /account/cashflow
	*/
	function noaccountcashflow()
	{
		$this->redirect_to("/account/none");
	}

	function cashflow($account_id)
	{
		$this->account = BankAccount::Get($account_id);
		$this->entry = new Entry();
		list($this->from_date, $this->to_date) = get_date_range();
		$this->entries = $this->account->ranged_entries($this->from_date, $this->to_date);
		$this->tags = $this->account->tags();
	}
	function none()
	{
		$this->entries = Entry::Find(array("conditions"=>"charged_to=0"));
	}

	/**
	* !Route GET, /account/cashflow/chart/$account_id
	*/
	function cashFlowChart($account_id){
		$this->account_id = $account_id;

		/*$account = BankAccount::Get($account_id);
		$months = array();
		$bar_data = array();
		for($x=0; $x<=12; $x++)
		{
			$date = mktime(0, 0, 0, date("m")-$x, date("d"),   date("Y"));
			$balance = $account->balance_as_of($date);
			if ($balance > $max) { $max = $balance; }
			$bar_data[] = $balance;
			$months[] = date('M', $date);
		}

		$this->chart = new \gLineChart(720,200);
		$this->chart->addDataSet($bar_data);
		$this->chart->setLegend(array("Balance over Time"));
		$this->chart->setColors(array("000000"));
		$this->chart->setVisibleAxes(array('x','y'));
		$this->chart->addAxisRange(0, 0, 12, 1);
		$this->chart->addAxisLabel(0, $months);
		$this->chart->addAxisRange(1, 0, 1.1*$max);
		$this->chart->addLineFill(B,'C4D4FB',0,0);*/
	}
	/**
	* !Route GET, /account/cashflow/chart/data/$account_id
	*/
	function cashFlowChartData($account_id){
		$account = BankAccount::Get($account_id);
		$data = array();
		$max = 0;
		for($x=0; $x<=1; $x++)
		{
			$date = mktime(0, 0, 0, date("m")-$x, date("d"),   date("Y"));
			$balance = $account->balance_as_of($date);
			if ($balance > $max) { $max = $balance; }
			$data[] = $balance;
		}

		/*$title = new \title( "My Title ".date("D M d Y") );

		$bar = new \bar();


		$bar->set_values( $bar_data );

		$chart = new \open_flash_chart();
		$chart->set_title( $title );
		$chart->add_element( $bar );

		$y = new \y_axis();
		$y->set_range( 0, $max * 1.1 );

		$chart->set_y_axis($y);

		$this->render_text($chart->toString());*/

		$chart = new \open_flash_chart();
		$chart->set_title( new \title( 'Area Chart' ) );

		$d = new \dot();
		$d->colour('#9C0E57')->size(7);

		$area = new \area();
		// set the circle line width:
		$area->set_width( 2 );
		$area->set_default_dot_style($d);
		$area->set_colour( '#C4B86A' );
		$area->set_fill_colour( '#C4B86A' );
		$area->set_fill_alpha( 0.7 );
		$area->set_values( $data );

		// add the area object to the chart:
		$chart->add_element( $area );

		$y_axis = new \y_axis();
		$y_axis->set_range( 0, 1.1*$max );
		$y_axis->labels = null;
		$y_axis->set_offset( false );

		$x_axis = new \x_axis();
		$x_axis->labels = $data;
		$x_axis->set_steps( 2 );

		$x_labels = new \x_axis_labels();
		$x_labels->set_steps( 4 );
		$x_labels->set_vertical();
		// Add the X Axis Labels to the X Axis
		$x_axis->set_labels( $x_labels );



		$chart->add_y_axis( $y_axis );
		$chart->x_axis = $x_axis;

		$this->render_text($chart->toPrettyString());
	}

	function delete($account_id){
		$this->account = BankAccount::Get($account_id);
		if (isset($_POST["delete_id"])) {
			$this->account->destroy(true);
			$this->redirect_to("/account/all");
		}
	}
}
?>
