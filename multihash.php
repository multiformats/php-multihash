<?php

require_once('vendor/autoload.php');

$base58 = new StephenHill\Base58();

#echo $base58->encode('Hello World'),"\n";
#echo $base58->decode('JxF12TrwUP45BMd'),"\n";




### cf https://github.com/jbenet/multihash

$data = "hello"; 

/*
0x11 sha1
0x12 sha2-256
0x13 sha2-512
0x14 sha3-512
0x15 sha3-384
0x16 sha3-256
0x17 sha3-224
0x18 shake-128
0x19 shake-256
0x40 blake2b
0x41 blake2s
*/

$algos = [
	0x11 => 'sha1',
	0x12 => 'sha256',
	0x13 => 'sha512',
];

foreach ($algos as $code => $name) {
    $r = hash($name, $data, true);
    $r = //substr($r,0,20); 
    printf("%-12s %3d %s\n", $name, strlen($r), $base58->encode(chr($code).chr(strlen($r)).$r)); 
}


$m = ( $base58->decode('QmTkzDwWqPbnAh5YiV5VwcTLnGdwSNsNTn2aDxdXBFca7D') );

if (strlen($m) > 1
AND $a = ord($m[0])
AND $len = ord($m[1])
AND $len == strlen($m) - 2
AND isset($algos[$a])
) {
	echo $algos[$a], ' - ', bin2hex(substr($m,2)),"\n";
}
else {
	var_dump($a, $len, $algos[$a], $m);
	echo "error!\n";
}
