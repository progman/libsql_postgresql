//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__json_list2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return "TO_JSON(".$table_name_short.".".$col_name.")::json";
	}

	return "TO_JSON(".$table_name_short.".".$col_name.")::json AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
