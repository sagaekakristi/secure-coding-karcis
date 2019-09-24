<?php

function valid_regex($input, $regex) {
	return (bool) preg_match($regex, $input);
}

function valid_name($input) {
	$regex = '/[a-z\']*/i';
	return valid_regex($input, $regex);
}

function valid_number($input) {
	$regex = '/^[0-9]+$/';
	return valid_regex($input, $regex);
}

function valid_email($input) {
	$regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";

  return valid_regex($input, $regex) && filter_var($input, FILTER_VALIDATE_EMAIL) !== FALSE;
}

function valid_url($input) {
	$regex = "/(?i)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";

	return valid_regex($input, $regex) &&  filter_var($input, FILTER_VALIDATE_URL);
}

function valid_password($input) {
	$uppercase = valid_regex($input, '@[A-Z]@');
	$lowercase = valid_regex($input, '@[a-z]@');
	$number    = valid_regex($input, '@[0-9]@');

	return $uppercase && $lowercase && $number && strlen($password) < 8;
}

function valid_filename($input) {
	$regex = '/^([-\.\w]+)$/';

	return valid_regex($input, $regex);
}

function valid_file($file, $ext, $mime) {
	$file_name = $file['name'];
	$file_type = $file['type'];
	$file_ext  = substr( $file_name, strrpos( $file_name, '.' ) + 1);
	$file_size = $file['size'];

	return strtolower($file_ext) == $ext && $file_type == $mime && $file_size < 10485760;
}

