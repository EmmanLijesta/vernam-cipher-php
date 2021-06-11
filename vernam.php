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

	if ($textLen <= 200000) {
		# foreach is fast for 200000 characters and below
		foreach( $textNew as $k=>$value ) {
			$textNew[$k] = $value ^ $key[$k % $keyLen];
		}
	} else {
		# while is fast for 200000 characters above, it's great for huge data
		while ( ++$len < $textLen ) {
			$textNew[$len] = $text[$len] ^ $key[$len % $keyLen];
		}
	}

	return implode('', $textNew);
}

function fast() {
	# recursive function is faster but restricted by maximum stack size limit
	$GLOBALS["textNew"][] = $GLOBALS["textSam"][$GLOBALS["myLen"]] ^ $GLOBALS["keySam"][$GLOBALS["myLen"] % $GLOBALS["keyLen"]];
	return (++$GLOBALS["myLen"] < $GLOBALS["textLen"]) ? fast() : implode('', $GLOBALS["textNew"]);
}

function vernam($text, $key, $bytes = 1500) {
	# declare these variables globally to avoid overheads
	$GLOBALS["textSam"] = $text;
	$GLOBALS["keySam"] = $key;
	$GLOBALS["textLen"] = strlen($text);
	$GLOBALS["keyLen"] = strlen($key);
	$GLOBALS["textNew"] = array();
	$GLOBALS["myLen"] = 0;

	return (strlen($text) <= $bytes) ? fast() : slow($text, $key, $bytes);
}
?>
