<? if ($from_date != null && $to_date != null){ ?>
	<div>From <?=$from_date?> to <?=$to_date?></div>
<? } ?>
<div id="dateRange">
	<form action="" method="post">
		<fieldset>
			<legend>Date Range</legend>
			<label for="from_date">From Date</label>
			<input type="text" class="datepicker" id="from_date" />
			<label for="to_date">To Date</label>
			<input type="text" class="datepicker" id="to_date" />
			<p><input type="submit" value="Run Report" /></p>
		</fieldset>
	</form>
</div>