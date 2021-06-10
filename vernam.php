<?php
# By Engr. Emman Lijesta, ECE
# www.kiddyyep.com
# Vernam Cipher is an unbreakable encryption method,
# as long as the key or salt is not discovered for decoding it
# used for encoding/decoding plain text
#
# how to use it: vernam( $text, $salt )
# for encoding - vernam( "plain text" , "YOURKEYHERE" ) returns "CIPHERTEXT"
# for decoding - vernam( "CIPHERTEXT" , "YOURKEYHERE" ) returns "plain text"

function slow($text, $salt) {
	$textLen = strlen($text);
	$saltLen = strlen($salt);
	$textNew = str_split($text);
	$len = -1;

	if ($textLen <= 5000) {
		# foreach is fast for 5000 characters and below
		foreach( $textNew as $key=>$value ) {
			$textNew[$key] = $value ^ $salt[$key % $saltLen];
		}
	} else {
		# while is fast for 5000 characters and above, it's great for huge data
		while ( ++$len < $textLen ) {
			$textNew[$len] = $text[$len] ^ $salt[$len % $saltLen];
		}
	}

	return implode('', $textNew);
}

function fastSub($text, $salt, $textNew, $len, $textLen, $saltLen) {
	# recursive function is faster but restricted by maximum stack size limit
	$textNew[] = $text[$len] ^ $salt[$len % $saltLen];
	return (++$len < $textLen) ? fastSub($text, $salt, $textNew, $len, $textLen, $saltLen) : implode('', $textNew);
}

function fast($text, $salt, $len = 0) {
	# declare these variables once to avoid overheads
	$textLen = strlen($text);
	$saltLen = strlen($salt);
	$textNew = array();

	# do recursion
	return fastSub($text, $salt, $textNew, $len, $textLen, $saltLen);
}

function vernam($text, $salt, $bytes = 256) {
	return (strlen($text) <= $bytes) ? fast($text, $salt) : slow($text, $salt, $bytes);
}
?>
