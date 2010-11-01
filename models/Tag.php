<?
namespace budget;
class Tag extends \HappyPuppy\dbobject
{
	function __construct()
	{
		parent::__construct("tag");
		parent::has_many("entries", "date", "\\budget\\Entry", "entry", "tag_id");
		parent::isUniqueField("name");
	}
	
	function __get($name){
		$value = parent::__get($name);
		if ($value != null || is_array($value)){ return $value; }
		return null;
	}
	
	/*SELECT t.name, SUM(e.amount / people_per_entry.peoplenum) FROM tag t

LEFT JOIN entry e ON e.tag_id = t.id

LEFT JOIN (
SELECT e.id AS id, COUNT(p.id) AS peoplenum FROM entry e
LEFT JOIN entry_person ep ON e.id = ep.entry_id
LEFT JOIN person p ON ep.person_id = p.id
GROUP BY e.id)
people_per_entry ON e.id = people_per_entry.id

INNER JOIN (
SELECT e.id AS id FROM entry e
LEFT JOIN entry_person ep ON e.id = ep.entry_id
LEFT JOIN person p ON ep.person_id = p.id
WHERE p.id = 1)
entries_with_dave ON e.id = entries_with_dave.id

GROUP BY t.name*/
}
