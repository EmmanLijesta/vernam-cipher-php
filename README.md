# Vernam Cipher in PHP
A high performance vernam cipher in PHP for encoding and decoding plain texts to cipher text. Used in private messaging, cookies and more.

How to use (vernam.php):

vernam( $data, $key );

Encoding:

$key = "b8d285ce189d4e06a884053a4cede2bde6bb81242354b500aac3360a4344a2c0";

$data = "The quick brown fox jumps over the lazy dog.";

$cipher = vernam ( $data, $key );

Decoding:

$plain = vernam ( $cipher, $key);


How to use (vernam-class.php)

$res = new Vernam( $data, $key, $limit );

$data = "A long black shadow slid across the pavement near their feet and the five Venusians, very much startled, looked overhead. They were barely in time to see the huge gray form of the carnivore before it vanished behind a sign atop a nearby building.";

$key = "0c5e096996e96407238d8c02c473844449187d3f98ef618c84a4a316cedce58b";

$res = new Vernam( $data, $key, 256 );
$cipher = (string)$res;
echo $cipher;

$res = new Vernam( $cipher, $key, 256 );
$plain = (string)$res;
echo $plain;
