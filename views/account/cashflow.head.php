<style type="text/css">
	#entryTable{ border-collapse: collapse; }
	#entryTable td, #entryTable th{ border: 1px solid #AAA; padding: 4px; }
	.highlightColHeader{ background-color: #FFDB4D !important; }
	.draggable thead tr:hover{ cursor: move; }
	<? $x = 0; $colors = array("#CC2222", "#22CC22", "#2222CC", "#CCCC22"); ?>
	<? foreach($tags as $tag): ?>
	.tag_<?=$tag->id?>{ border: 1px solid transparent; background-color: <?=$colors[$x % count($colors)]?>; -moz-border-radius: 10px; border-radius: 10px; color: white; font-weight: bold; padding: 3px; }
	.tag_<?=$tag->id?>:hover{ text-decoration: none; color: black; border: 1px solid black; background-color: white;}
	<?$x++;?>
	<? endforeach; ?>
</style>
<script type="text/javascript">
	$(document).ready(function(){
		columnHeaderHighlight('#colHeaderDate');
		columnHeaderHighlight('#colHeaderDescription');
		columnHeaderHighlight('#colHeaderEdit');
		columnHeaderHighlight('#colHeaderAmount');
		columnHeaderHighlight('#colHeaderTag');
		columnHeaderHighlight('#colHeaderShared');
		columnHeaderHighlight('#colHeaderBalance');
		showHideColumns('#chkDate', '.colDate');
		showHideColumns('#chkDescription', '.colDescription');
		showHideColumns('#chkEdit', '.colEdit');
		showHideColumns('#chkAmount', '.colAmount');
		showHideColumns('#chkTag', '.colTag');
		showHideColumns('#chkShared', '.colShared');
		showHideColumns('#chkBalance', '.colBalance');
	});
	function columnHeaderHighlight(colSelector)
	{
		$(colSelector).mouseenter(function(){ $(colSelector).addClass('highlightColHeader'); });
		$(colSelector).mouseleave(function(){ $(colSelector).removeClass('highlightColHeader'); });
	}
	function showHideColumns(chkSelector, colSelector)
	{
		$(chkSelector).change(function(){
			if ($(this).is(':checked'))
			{
				$(colSelector).show();
			}
			else
			{
				$(colSelector).hide();
			}
		});
	}
	
</script>