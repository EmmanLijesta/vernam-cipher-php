<?php
# By Engr. Emman Lijesta, ECE
# www.kiddyyep.com
# Vernam Cipher is an unbreakable encryption method,
# as long as the key or salt is not discovered for decoding it
# used for encoding/decoding plain text
#
# How to use:
#
# Encoding
# $var = new Vernam( $text, $salt );
# $cipher = (string)$var;
# echo $cipher;
#
# Decoding
# $var = new Vernam( $cipher, $salt );
# $plain = (string)$var;
# echo $plain;

class Vernam {
	public $text;
	public $salt;
	public $bytes;

	function __construct( $text, $salt, $bytes = 256 ) {
		$this->text = $text;
		$this->salt = $salt;
		$this->bytes = $bytes;
		$this->textNew = str_split($text);
		$this->textLen = strlen($text);
		$this->saltLen = strlen($salt);
		$this->len = 0;
	}

	private function slow() {
		# iteration is not limited by maximum call stack size
		if ($this->bytes <= 5000) {
			# foreach is fast for 5000 characters and below
			foreach( $this->textNew as $key=>$value ) {
				$this->textNew[$key] = $value ^ $this->salt[$key % $this->saltLen];
			}
		} else {
			--$this->len;
			# while is fast for 5000 characters and above, it's great for huge data
			while ( ++$this->len < $this->textLen ) {
				$this->textNew[$this->len] = $this->text[$this->len] ^ $this->salt[$this->len % $this->saltLen];
			}
		}

		return implode('', $this->textNew);
	}

	private function fast() {
		# recursive function is fast, but is limited by maximum call stack size
		$this->textNew[$this->len] = $this->text[$this->len] ^ $this->salt[$this->len % $this->saltLen];
		return (++$this->len < $this->textLen) ? $this->fast() : implode('', $this->textNew);
	}

	function __toString() {
		return ($this->textLen <= $this->bytes) ? $this->fast() : $this->slow();
	}
}
?>
