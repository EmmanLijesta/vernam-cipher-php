<?php
# By Engr. Emman Lijesta, ECE
# www.kiddyyep.com
# Vernam Cipher is an unbreakable encryption method,
# as long as the key is not discovered for decoding it
# used for encoding/decoding plain text
#
# How to use:
#
# Encoding
# $var = new Vernam( $text, $key );
# $cipher = (string)$var;
# echo $cipher;
#
# Decoding
# $var = new Vernam( $cipher, $key );
# $plain = (string)$var;
# echo $plain;

class Vernam {
	public $text;
	public $key;
	public $bytes;

	function __construct( $text, $key, $bytes = 256 ) {
		$this->text = $text;
		$this->key = $key;
		$this->bytes = $bytes;
		$this->textNew = str_split($text);
		$this->textLen = strlen($text);
		$this->keyLen = strlen($key);
		$this->len = 0;
	}

	private function slow() {
		if ($this->textLen <= 5000) {
			# foreach is fast for 5000 characters and below
			foreach( $this->textNew as $k=>$value ) {
				$this->textNew[$k] = $value ^ $this->key[$k % $this->keyLen];
			}
		} else {
			--$this->len;
			# while is fast for 5000 characters and above, it's great for huge data
			while ( ++$this->len < $this->textLen ) {
				$this->textNew[$this->len] = $this->text[$this->len] ^ $this->key[$this->len % $this->keyLen];
			}
		}

		return implode('', $this->textNew);
	}

	private function fast() {
		$this->textNew[$this->len] = $this->text[$this->len] ^ $this->key[$this->len % $this->keyLen];
		return (++$this->len < $this->textLen) ? $this->fast() : implode('', $this->textNew);
	}

	function __toString() {
		return ($this->textLen <= $this->bytes) ? $this->fast() : $this->slow();
	}
}
?>
