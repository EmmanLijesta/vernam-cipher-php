# Vernam Cipher in PHP
A high performance vernam cipher in PHP for encoding and decoding plain texts to cipher text. Used in private messaging, cookies and more.

How to use:

vernam( $data, $key );

Encoding:

$key = "b8d285ce189d4e06a884053a4cede2bde6bb81242354b500aac3360a4344a2c0";
$data = "The quick brown fox jumps over the lazy dog.";

$cipher = vernam ( $data, $key );

Decoding:

$plain = vernam ( $cipher, $key);
