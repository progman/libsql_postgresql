//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bool($item)
{
	if (libcore__is_flag($item) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "'".libcore__flag2int($item)."'::boolean";
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//