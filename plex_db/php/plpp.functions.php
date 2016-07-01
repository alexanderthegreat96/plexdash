<?php

// Error handler function
function error_handler() {
	global $plppErrors;
	// Check for unhandled errors (fatal shutdown)
	$e = error_get_last();
	// If none, check function args (error handler)
	if($e === null) { $e = func_get_args(); }
	// Catch error message and return
	if (isset($e['message'])) {
		$plppErrors[] = $e['message'];
		print $e['message'].'<br />';
	}
	return;
}


// Load images regardless of the format
function createImageFromFile($filename, $use_include_path = false, $context = null, &$info = null)
{
  // try to detect image informations -> info is false if image was not readable or is no php supported image format (a  check for "is_readable" or fileextension is no longer needed)
  $info = array("image"=>getimagesize($filename));
  $info["image"] = getimagesize($filename);
  if($info["image"] === false) throw new InvalidArgumentException("\"".$filename."\" is not readable or no php supported format");
  else
  {
    // fetches fileconten from url and creates an image ressource by string data
    // if file is not readable or not supportet by imagecreate FALSE will be returnes as $imageRes
    $imageRes = imagecreatefromstring(file_get_contents($filename, $use_include_path, $context));
    // export $http_response_header to have this info outside of this function
    if(isset($http_response_header)) $info["http"] = $http_response_header;
    return $imageRes;
  }
}


// Load json config file into array
function json_load($json, $path, $key = ''){
	if (!empty($key)) {
		if (file_exists($path.$key.'.json')) {
			$json[$key] = json_decode(file_get_contents($path.$key.'.json', JSON_NUMERIC_CHECK), true);
		}
	}
	else {
		foreach ($json as $key => $value) {
			if (file_exists($path.$key.'.json')) {
				$json[$key] = json_decode(file_get_contents($path.$key.'.json', JSON_NUMERIC_CHECK), true);
			}
		}
	}
	return $json;
}


// Write array into json config file
function json_write($json, $path, $key = ''){
	if (!empty($key)){
		$fp = fopen($path.$key.'.json', 'w');
		if ($fp) {
			$success_write = fwrite($fp, json_encode($json[$key], JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
			$success_close = fclose($fp);
			if ($success_write == FALSE) {$return[$key][] = 'Could not write to file '.$path.$key.'.json! Are there permission issues?';}
			if ($success_close == FALSE) {$return[$key][] = 'Could not close file '.$path.$key.'.json! Are there permission issues?';}
		}
		else {
			$return[$key][] = 'Could not open file '.$path.$key.'.json for writting! Are there permission issues?';
		}
		if (!is_array($return[$key])) { $return[$key] = true; }
	}
	else {
		foreach ($json as $key => $value) {
			$fp = fopen($path.$key.'.json', 'w');
			if ($fp) {
				$success_write = fwrite($fp, json_encode($value, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
				$success_close = fclose($fp);
				if ($success_write == FALSE) {$return[$key][] = 'Could not write to file '.$path.$key.'.json! Are there permission issues?';}
				if ($success_close == FALSE) {$return[$key][] = 'Could not close file '.$path.$key.'.json! Are there permission issues?';}
			}
			else {
				$return[$key][] = 'Could not open file '.$path.$key.'.json for writing! Are there permission issues?';
			}
			if (!is_array($return[$key])) { $return[$key] = true; }
		}
	}
	return $return;
}


function plpp_templates($items, $type, $viewmode) {
	$output = new Template(PLPP_TEMPLATES_PATH.$type.'_'.$viewmode.'.tpl');
	foreach ($items[$viewmode] as $key => $value){
		$output->set($key, $value);
	}
	return $output->output();
}


// Helper function to sort arrays
// Taken from: http://stackoverflow.com/questions/96759/how-do-i-sort-a-multidimensional-array-in-php
function make_comparer() {
	// Normalize criteria up front so that the comparer finds everything tidy
	$criteria = func_get_args();
	foreach ($criteria as $index => $criterion) {
		$criteria[$index] = is_array($criterion)
			? array_pad($criterion, 3, null)
			: array($criterion, SORT_ASC, null);
	}
	return function($first, $second) use (&$criteria) {
	foreach ($criteria as $criterion) {
		// How will we compare this round?
		list($column, $sortOrder, $projection) = $criterion;
		$sortOrder = $sortOrder === SORT_DESC ? -1 : 1;
		// If a projection was defined project the values now
		if ($projection) {
			$lhs = call_user_func($projection, $first[$column]);
			$rhs = call_user_func($projection, $second[$column]);
		}
		else {
			$lhs = $first[$column];
			$rhs = $second[$column];
		}
		// Do the actual comparison; do not return if equal
		if ($lhs < $rhs) {
			return -1 * $sortOrder;
		}
		else if ($lhs > $rhs) {
			return 1 * $sortOrder;
		}
	}
	return 0; // tiebreakers exhausted, so $first == $second
	};
}

?>