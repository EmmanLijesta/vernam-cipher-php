<?php
# By Engr. Emman Lijesta, ECE
# www.kiddyyep.com
# Vernam Cipher is an unbreakable encryption method,
# as long as key is not discovered for decoding it
# used for encoding/decoding plain
#
# How to use this class:
#
# Encoding
# $var = new Vernam( $data, $key, $limit);
# $cipher = (string)$var;
# echo $cipher;
#
# Decoding
# $var = new Vernam( $cipher, $key, $limit);
# $plain = (string)$var;
# echo $plain;

class Vernam {
	public $data;
	public $salt;
	public $limit;
	public $output;
	public $results;

	public function __construct( $data, $salt, $limit, $output = array() ) {
		$this->data = $data;
		$this->salt = $salt;
		$this->limit = $limit;
		$this->output = $output;
	}

	public function vernamSlow() {
		# Iteration version of Vernam that is slower than recursive,
		# but without a call limit size and is great for huge data

		# get string lengths
		$dataLen = strlen($this->data);
		$keyLen = strlen($this->salt);

		# let results be an array of data to have same type and length
		$results = $this->data;

		# iterate from 0 to data length
		for ($i = 0; $i < $dataLen; $i++) {
			# the modulo generates a random ID from 0 to length of key
			$results[$i] = $this->data[$i] ^ $this->salt[$i % $keyLen];
		}

		return $results;
	}

	public function vernamFast() {
		# recursive is faster but there is a call limit stack size
		# in PHP limited by RAM ex. 512MB for basic server plans

		# get string and array lengths
		$dataLen = strlen($this->data);
		$keyLen = strlen($this->salt);
		$outputLen = count($this->output);

		# if less than data length then continue recursion
		if ($outputLen < $dataLen) {
			array_push($this->output, $this->data[$outputLen] ^ $this->salt[$outputLen % $keyLen]);
			return $this->vernamFast();

		} else {
			# converts array to string
			return implode('', $this->output);
		}
	}

	public function __toString() {
		if (strlen($this->data) <= $this->limit) {
			# recursive vernam
			$this->results = $this->vernamFast();

		} else {
			# iterate vernam
			$this->results = $this->vernamSlow();
		}

		return $this->results;
	}
}
?>
