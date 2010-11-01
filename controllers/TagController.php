<?

namespace budget;
class TagController extends \HappyPuppy\Controller
{
	function defaultAction(){ return "list"; }
	function __init(){
		$this->currentNav = "tags";
	}
	function _list() {
		$this->tags = Tag::All("name");
		usort($this->tags, array("\\budget\\TagController", "entry_count_cmp"));
		$this->newtag = new Tag();
	}
	static function entry_count_cmp($a, $b){
		$c_a = count($a->entries);
		$c_b = count($b->entries);
		return $c_b - $c_a;
	}
	function create(){
    	$this->newtag = new Tag();
		$this->newtag->build($_POST["Tag"]);
		$error = '';
		$success = $this->newtag->save($error);
		
		if ($success)
		{
			$this->flash = "New Tag Added";
			$this->redirect_to("/tag");
		} else {
			$this->view_template = "tag/list";
			$this->flash = "Tag was not able to be saved: ".$error;
			$this->tags = Tag::All("name");
		}
	}
	function show($tag_id) {
		if ($tag_id == -1){
			$this->redirect_to_action("none");
		}
		$this->tag = Tag::Get($tag_id);
		$total = 0;
		foreach($this->tag->entries as $entry){
			$total += $entry->share;
		}
	}
	function none(){
		$this->entries = Entry::Find(array("conditions"=>"tag_id is null"));
	}
	function edit($tag_id){
		$this->tag = Tag::Get($tag_id);
	}
	function update(){
		$this->tag = new Tag();
		$this->tag->build($_POST["Tag"]);
		$error_msg = '';
		$success = $this->tag->save($error_msg);
		if ($success) {
			$this->redirect_to("/tag");
		} else {
			$this->view_template = "tag/edit";
			$this->flash = "Could not save new tag: ".$error_msg;
		}
	}
	function delete($tag_id){
		$this->tag = Tag::Get($tag_id);
		if (isset($_POST["delete_id"])) {
			$this->tag->destroy();
			$this->redirect_to("/tag");
		}
	}
}
?>