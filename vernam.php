<?php
# By Engr. Emman Lijesta, ECE
# www.kiddyyep.com
# Vernam Cipher is an unbreakable encryption method,
# as long as the key is not discovered for decoding it
# used for encoding/decoding plain text
#
# how to use it: vernam( $text, $key )
# for encoding - vernam( "plain text" , "YOURKEYHERE" ) returns "CIPHERTEXT"
# for decoding - vernam( "CIPHERTEXT" , "YOURKEYHERE" ) returns "plain text"

function slow($text, $key) {
	$textLen = strlen($text);
	$keyLen = strlen($key);
	$textNew = str_split($text);
	$len = -1;

	if ($textLen <= 5000) {
		# foreach is fast for 5000 characters and below
		foreach( $textNew as $k=>$value ) {
			$textNew[$k] = $value ^ $key[$k % $keyLen];
		}
	} else {
		# while is fast for 5000 characters and above, it's great for huge data
		while ( ++$len < $textLen ) {
			$textNew[$len] = $text[$len] ^ $key[$len % $keyLen];
		}
	}

	return implode('', $textNew);
}

function fastSub($text, $key, $textNew, $len, $textLen, $keyLen) {
	# recursive function is faster but restricted by maximum stack size limit
	$textNew[] = $text[$len] ^ $key[$len % $keyLen];
	return (++$len < $textLen) ? fastSub($text, $key, $textNew, $len, $textLen, $keyLen) : implode('', $textNew);
}

function fast($text, $key, $len = 0) {
	# declare these variables once to avoid overheads
	$textLen = strlen($text);
	$keyLen = strlen($key);
	$textNew = array();

	# do recursion
	return fastSub($text, $key, $textNew, $len, $textLen, $keyLen);
}

function vernam($text, $key, $bytes = 256) {
	return (strlen($text) <= $bytes) ? fast($text, $key) : slow($text, $key, $bytes);
}
?>
