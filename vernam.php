<?php
# By Engr. Emman Lijesta, ECE
# www.kiddyyep.com
# Vernam Cipher is an unbreakable encryption method,
# as long as key is not discovered for decoding it =)
# used for encoding/decoding plain texts

# how to use it: vernam( $data, $key )
# for encoding - vernam( "plain text" , "YOURKEYHERE" ) returns "CIPHERTEXT"
# for decoding - vernam( "CIPHERTEXT" , "YOURKEYHERE" ) returns "plain text"

# Iteration version of Vernam that is slower than recursive,
# but without a call limit size and is great for huge data
function vernamSlow($data, $key) {
	# get string lengths
	$dataLen = strlen($data);
	$keyLen = strlen($key);

	# let output be an array of data to have same type and length
	$output = $data;

	# iterate from 0 to data length
	for ($i = 0; $i < $dataLen; $i++) {
		# the modulo generates a random ID from 0 to length of key
		$output[$i] = $data[$i] ^ $key[$i % $keyLen];
	}

	return $output;
}

# recursive is faster but there is a call limit stack size
# in PHP limited by RAM ex. 512MB for basic server plans
function vernamFast($data, $key, $output = array()) {
	# get string and array lengths
	$dataLen = strlen($data);
	$keyLen = strlen($key);
	$outputLen = count($output);

	# if less than data length then continue recursion
	if ($outputLen < $dataLen) {
		array_push($output, $data[$outputLen] ^ $key[$outputLen % $keyLen]);
		return vernamFast($data, $key, $output);

	} else {
		# converts array to string
		return implode('', $output);
	}
}

# use both iteration and recursive method depending on the size of the string for performance
# 1 character = 1 byte, 256 char = 256 bytes
# for 512MB with 256 bytes will be able to handle 2M calls to this function
function vernam($data, $key, $limit = 256) {
	$output = "";

	if (strlen($data) <= $limit) {
		# recursive vernam
		$output = vernamFast($data, $key);

	} else {
		# iterate vernam
		$output = vernamSlow($data, $key);
	}
	
	return $output;
}
?>
