<?php
namespace budget;
class PersonController extends \HappyPuppy\Controller
{
	function defaultAction(){ return "list"; }
	function __init(){
		$this->currentNav = "people";
	}
	function _list()
	{
		$this->title = "List of People";
		$this->people = Person::All('name');
		$this->new_person_form = new \HappyPuppy\form(new Person());
	}
	function edit($person_id)
	{
		$this->render_text("Editing person $person_id");
	}
	function _new()
	{
		$person = new Person();
		$person->build($_POST["Person"]);
		$result = $person->save($err_message);
		if ($result){ setflash("New person created."); }
		else { setflash("Unable to create new person"); }
		$this->redirect_to_action("list");
	}
}
?>
