<?php


function check($value) {
  if($value == "") {
    return "NULL";
  }
  else {
    return $value;
  }
}


function dq($value) {
  if($value == "NULL"){
    return "NULL";
  }
  else {
    return "\"" . $value . "\"";
  }
}
  
function values($mylist) {
  $mystring = "Values(";
  for ($i = 0; $i < count($mylist); $i++) {
	  if(is_string($mylist[$i]) and $mylist[$i] != "NULL" and !is_numeric($mylist[$i])) {
	    $mystring = $mystring . dq($mylist[$i]);
	  }
	  else {
	    $mystring = $mystring . $mylist[$i];
	  }
	  if($i + 1 != count($mylist)){
	    $mystring = $mystring . ", ";
	  }
  }
  $mystring = $mystring. ");";
  return $mystring;
}

function sq($dqsql){ //Primarily used in sql if inserting with dq replaces it with sq
	if (preg_match('~"~', $dqsql)){
		  $regex = '~"~';
		  $replaceWith = '\'';
		  $subject = $dqsql;
		  $dqsql = preg_replace($regex, $replaceWith, $subject);
	}
	return $dqsql;
}
?>


