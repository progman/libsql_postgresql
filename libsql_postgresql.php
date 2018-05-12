<?php
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
// 0.2.4
// Alexey Potehin <gnuplanet@gmail.com>, http://www.gnuplanet.ru/doc/cv
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
class sql_t
{
	var $sql_tag;
	var $sql_str;


	function sql_t
	(
		$sql_tag,
		$sql_str
	)
	{
		$this->sql_tag = $sql_tag;
		$this->sql_str = $sql_str;
	}
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
function libsql__var2inner_text($item)
function libsql__var2text($item)
function libsql__var2text_list($item_list, $flag_skip_null = true)
function libsql__var2bytea($item)
function libsql__var2bytea_list($item_list, $flag_skip_null = true)
function libsql__var2uuid($item)
function libsql__var2uuid_list($item_list, $flag_skip_null = true)
function libsql__var2bigint($item)
function libsql__var2bigint_list($item_list, $flag_skip_null = true)
function libsql__var2bool($item)
function libsql__var2bool_list($item_list, $flag_skip_null = true)
function libsql__var2json($item)
function libsql__var2json_list($item_list, $flag_skip_null = true)
function libsql__var2time($item)
function drop_sql_injection($str)
function libsql__bytea2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__uuid2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__text2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__json2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__bigint2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__flag2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__time2var($table_name_short, $col_name, $flag_make_col_alias = true)
function libsql__error($sql_handle)
function libsql__num_rows($sql_result)
function libsql__query($sql_handle, $sql_tag, $sql_str, $rc_target)
function libsql__query_free($sql_result)
function libsql__query_view()
function libsql__database_open($host, $port, $database, $login, $password)
function libsql__database_close($sql_handle)
function libsql__transaction_begin($sql_handle, $flag_serializable = false)
function libsql__transaction_rollback($sql_handle)
function libsql__transaction_commit($sql_handle)
function libsql__ping($sql_handle)
function libsql__notify_wait($sql_handle, $timewait = 30, $timeout = 100000)
function libsql__get_notify($sql_handle)
*/
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2inner_text($item)
{
	settype($item, "string");
	$item_size = strlen($item);


	$tmp = "";
	for ($i=0; $i < $item_size; $i++)
	{
		$ch = ord($item[$i]);
		if ($ch === 0)
		{
			continue;
		}
		$tmp.="\x".sprintf("%02x", $ch);
	}


//	$tmp = @addslashes($item); // для 0 пораждает \0 что не приемлемо для postgres, а так же не обрабатывает \r и \n

/*
	$tmp1 = @pg_escape_string($item); // не обрабатывает \r и \n
	$tmp2 = @str_replace(chr(hexdec("0a")), '\r', $tmp1);
	$tmp3 = @str_replace(chr(hexdec("0d")), '\n', $tmp2);
	$tmp  = $tmp3;
*/

	return $tmp;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2text($item)
{
	if ($item === null)
	{
		return "NULL";
	}

	return "E'".libsql__var2inner_text($item)."'::text";
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2text_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2text($item_list[$i]);
	}
	$str .= "]::text[]";

	return $str;
}
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bytea($item)
{
	if (libcore__is_hex($item, true) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "decode('".$item."', 'hex')::bytea";
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bytea_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2bytea($item_list[$i]);
	}
	$str .= "]::bytea[]";

	return $str;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2uuid($item)
{
	if (libcore__is_uuid($item) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "'".$item."'::uuid";
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2uuid_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2uuid($item_list[$i]);
	}
	$str .= "]::uuid[]";

	return $str;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bigint($item)
{
	if (libcore__is_uint($item) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "'".$item."'::bigint";
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2bigint_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2bigint($item_list[$i]);
	}
	$str .= "]::bigint[]";

	return $str;
}
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
function libsql__var2bool_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2bool($item_list[$i]);
	}
	$str .= "]::boolean[]";

	return $str;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2json($item)
{
	if
	(
		(is_object($item) === false) &&
		(is_array($item) === false)
	)


	if ($item === null)
	{
		return "NULL";
	}


	return "E'".libsql__var2inner_text(json_encode($item))."'::jsonb";
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2json_list($item_list, $flag_skip_null = true)
{
	$str = "ARRAY[";
	$size = count($item_list);
	for ($i=0; $i < $size; $i++)
	{
		if (($item_list[$i] === null) && ($flag_skip_null === true)) continue;

		if ($i !== 0)
		{
			$str .= ', ';
		}

		$str .= libsql__var2json($item_list[$i]);
	}
	$str .= "]::jsonb[]";

	return $str;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__var2time($item)
{
	if (libcore__is_uint($item) === false)
	{
		$item = null;
	}


	if ($item === null)
	{
		return "NULL";
	}


	return "UNIXMICROTIME_TO_UTC('".$item."'::bigint)";
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
/*
function drop_sql_injection($str)
{
//see mysql_real_escape_string()
	settype($str, "string");


	$tmp = '';
	$size = strlen($str);
	for ($i=0; $i < $size; $i++)
	{
		$ch = $str[$i];

		if (ord($ch) == 0)
		{
			$tmp .= '\x00'; // end of string
			continue;
		}

		if (ord($ch) == 34) // double quotes '"'
		{
			$tmp .= '&#034;'; // may be "\""
			continue;
		}

		if (ord($ch) == 39) // single quote '\''
		{
			$tmp .= '&#039;'; // may be "\'"
			continue;
		}

		if (ord($ch) == 92) // backslash
		{
			$tmp .= '&#092;'; // may be "\\"
			continue;
		}

		if (ord($ch) == 26) // EOF
		{
			$tmp .= '\x1a';
			continue;
		}

		$tmp .= $ch;
	}


	return $tmp;
}
*/
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__bytea2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return "encode(".$table_name_short.".".$col_name.", 'hex')::text";
	}

	return "encode(".$table_name_short.".".$col_name.", 'hex')::text AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__uuid2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return "replace(".$table_name_short.".".$col_name."::text, '-', '')";
	}

	return "replace(".$table_name_short.".".$col_name."::text, '-', '') AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__text2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return $table_name_short.".".$col_name;
	}

	return $table_name_short.".".$col_name." AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__json2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return $table_name_short.".".$col_name;
	}

	return $table_name_short.".".$col_name." AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__bigint2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return $table_name_short.".".$col_name;
	}

	return $table_name_short.".".$col_name." AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__flag2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return $table_name_short.".".$col_name."::int";
	}

	return $table_name_short.".".$col_name."::int AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__time2var($table_name_short, $col_name, $flag_make_col_alias = true)
{
	if ($flag_make_col_alias === false)
	{
		return "UTC_TO_UNIXMICROTIME(".$table_name_short.".".$col_name.")";
	}

	return "UTC_TO_UNIXMICROTIME(".$table_name_short.".".$col_name.") AS ".$col_name;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__error($sql_handle)
{
	$error = @pg_last_error();

	if (($error == '') && (@pg_connection_status($sql_handle) !== PGSQL_CONNECTION_OK))
	{
		$error = "database connection lost";
	}

//	return drop_sql_injection($error);
	return $error;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__num_rows($sql_result)
{
	return @pg_num_rows($sql_result);
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__query($sql_handle, $sql_tag, $sql_str, $rc_target)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	global $GLOBAL_SQL_STR_LIST;
	global $GLOBAL_SQL_COUNT;


	$flag_log_sql = libcore__get_var_flag("FLAG_LOG_SQL", "0");


	if ($flag_log_sql == '1')
	{
		libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.log", $sql_str."\n");
	}


	$GLOBAL_SQL_COUNT = $GLOBAL_SQL_COUNT + 1;


	$time1 = microtime();

	$sql_result = @pg_query($sql_handle, $sql_str);

	$time2 = microtime();
	list($usec1, $sec1) = explode(" ", $time1);
	list($usec2, $sec2) = explode(" ", $time2);
	$work_time = (($sec2 - $sec1) * 1000000) + intval($usec2 * 1000000) - intval($usec1 * 1000000);


	if ($sql_result !== false)
	{
		if ($flag_log_sql == '1')
		{
			$out = time().' '.$work_time.' '.$sql_tag.' '.bin2hex($sql_str)."\n";
			libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.stat.log", $out);
		}
	}
//	else
//	{
//		libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.err", $sql_str."\n".libsql__error($sql_handle)."\n\n\n");
//	}
	if ($sql_result === false)
	{
		libcore__file_add("/tmp/".libcore__get_var_str("SQL_DATABASE").".sql.err", $sql_str."\n".libsql__error($sql_handle)."\n\n\n");
	}


	$flag_debug_sql = libcore__get_var_flag("flag_debug_sql", "0");
	if (libcore__is_flag_set($flag_debug_sql) === true)
	{
		$sql_str = drop_sql_comment($sql_str);
		$sql_str = msg_convert_in($sql_str);
		$GLOBAL_SQL_STR_LIST=$GLOBAL_SQL_STR_LIST.'<hr />'.'&nbsp;<span class="strong">'.$rc_target->get_function_name().'</span>: '.$work_time.'<br />&nbsp;'.$sql_str.';';
	}


	return $sql_result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__query_free($sql_result)
{
	@pg_free_result($sql_result);
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__query_view()
{
	$result = new result_t(__FUNCTION__, __FILE__);


	global $GLOBAL_SQL_STR_LIST;
	global $GLOBAL_SQL_COUNT;


	if ($GLOBAL_SQL_STR_LIST != '')
	{
//		echo '<pre>';
//		echo msg_convert_in($GLOBAL_SQL_STR_LIST);
		echo $GLOBAL_SQL_STR_LIST;
//		echo '</pre>';
		echo '<hr />';
		echo '<span class="strong">Total sql query: '.$GLOBAL_SQL_COUNT.'</span><br /><br />';
	}
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__database_open($host, $port, $database, $login, $password)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$connection_string = "host=".$host." port=".$port." dbname=".$database." user=".$login." password=".$password;
	$sql_handle = @pg_connect($connection_string, PGSQL_CONNECT_FORCE_NEW);
	if ($sql_handle === false)
	{
		$result->set_err(1, "SQL сервер недоступен");
		return $result;
	}


	$sql_tag = "SQL001";
	$sql_str = "SET bytea_output = escape; -- ".$sql_tag;
	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	$result->set_value($sql_handle);
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__database_close($sql_handle)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	@pg_close($sql_handle);
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__transaction_begin($sql_handle, $flag_serializable = false)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$sql_tag = "";
	$sql_str = "";
	if ($flag_serializable === false)
	{
		$sql_tag = "SQL002";
		$sql_str = "BEGIN TRANSACTION ISOLATION LEVEL READ COMMITTED; -- ".$sql_tag;
	}
	else
	{
		$sql_tag = "SQL003";
		$sql_str = "BEGIN TRANSACTION ISOLATION LEVEL SERIALIZABLE; -- ".$sql_tag;
	}


	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__transaction_rollback($sql_handle)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$sql_tag = "SQL004";
	$sql_str = "ROLLBACK; -- ".$sql_tag;
	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__transaction_commit($sql_handle)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$sql_tag = "SQL005";
	$sql_str = "COMMIT; -- ".$sql_tag;
	$sql_result = libsql__query($sql_handle, $sql_tag, $sql_str, $result);
	if ($sql_result === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}
	libsql__query_free($sql_result);


	$result->set_ok();
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__ping($sql_handle)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$flag_connection = @pg_ping($sql_handle);
	if ($flag_connection === false)
	{
		$result->set_err(1, "sql error", libsql__error($sql_handle));
		return $result;
	}


	$result->set_ok();
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__notify_wait($sql_handle, $timewait = 30, $timeout = 100000)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	if (function_exists("pg_socket") === false) // php < 5.6
	{
		usleep($timeout);
		return $result;
	}


	$sock = @pg_socket($sql_handle);
	if ($sock === false)
	{
		usleep($timeout);
		return $result;
	}

	$read   = array($sock);
	$write  = array();
	$except = array($sock);
	stream_select($read, $write, $except, $timewait);


	$result->set_ok();
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
function libsql__get_notify($sql_handle)
{
	$result = new result_t(__FUNCTION__, __FILE__);


	$notify = @pg_get_notify($sql_handle);


	$result->set_ok();
	$result->set_value($notify);
	return $result;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//
?>