<?php 
    function hash_random() {
        $bytes = array(); // the array of all our 16 bytes
        for ( $i = 0; $i < 8 ; ++$i ) {
            $bytesequence = rand( 0, 65535 ); // generate a 2-bytes sequence
            // split the two bytes
            // lower-order byte
            $a = $bytesequence & 255; // a will be 0...255
            // higher-order byte
            $b = $bytesequence >> 8; // b will also be 0...255
            // append the bytes
            $bytes[] = $a;
            $bytes[] = $b;
        }
        $hash = '';
        foreach ( $bytes as $byte ) {
            $first = $byte & 15; // this will be 0...15
            $second = $byte >> 4; // this will be 0...15 again
            $hash .= dechex( $first ) . dechex( $second );
        }
        return $hash;
    }
?>
