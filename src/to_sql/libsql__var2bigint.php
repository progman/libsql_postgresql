//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bigint($item)
{
	if (libcore__is_sint($item) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "'".$item."'::bigint";
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
