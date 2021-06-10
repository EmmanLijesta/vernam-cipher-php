# Vernam Cipher in PHP
A high performance vernam cipher in PHP for encoding and decoding plain texts to cipher text. Used in private messaging, cookies and more.

# Credits to the Creator
Vernam cipher, created by Gilber Sandford Vernam (3 April 1890 – 7 February 1960), is a symmetrical stream cipher in which the plaintext is combined with a random or pseudorandom stream of data (the "keystream") of the same length, to generate the ciphertext, using the XOR function.

Vernam also patented a "Secret Signaling System" in July 22, 1919. The NSA has called this patent "perhaps one of the most important in the history of cryptography." Also, the US Army 1925 SIGTOT teletype system was based on Vernam's machine encipherment concept.

Vernam cipher is also called an unbreakable cipher, as long as the key is kept secret.

# How to use (vernam.php):

include "vernam.php";

$key = "b8d285ce189d4e06a884053a4cede2bde6bb81242354b500aac3360a4344a2c0";

$data = "The quick brown fox jumps over the lazy dog.";

$cipher = vernam ( $data, $key ); # Encoding

echo $cipher;

$plain = vernam ( $cipher, $key); # Decoding

echo $plain;

# How to use (vernam-class.php):

include "vernam-class.php";

$data = "A long black shadow slid across the pavement near their feet and the five Venusians, very much startled, looked overhead. They were barely in time to see the huge gray form of the carnivore before it vanished behind a sign atop a nearby building.";

$key = "0c5e096996e96407238d8c02c473844449187d3f98ef618c84a4a316cedce58b";

$limit = 256; # 256 bytes

$res = new Vernam( $data, $key, $limit ); # Encoding

$cipher = (string)$res;

echo $cipher;

$res = new Vernam( $cipher, $key, $limit ); # Decoding

$plain = (string)$res;

echo $plain;
