<?

function col($amount)
{
	if ($amount < 0)
		return "red";
	else
		return "green";
}

function mon($amount)
{
	if ($amount < 10000 && $amount > -10000)
	{
		return '$'.number_format($amount, 2, '.', '');
	}
	else
	{
		return '$'.number_format($amount, 2, '.', ',');
	}
}
?>