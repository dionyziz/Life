<?php
    if ( !isset( $_GET[ 'file' ] ) ) {
        die( 'File not specified' );
    }
    $file = basename( $_GET[ 'file' ] );
    $filename = 'uploads/' . $file;
    $im = @imagecreatefromstring( file_get_contents( $filename ) );
    if ( $im !== false ) {
        $w = imagesx( $im );
        $h = imagesy( $im );
        $maxw = 500;
        $ratio = 1;
        if ( $w > $maxw ) {
            $ratio = $maxw / $w;
        }
        $neww = $ratio * $w;
        $newh = $ratio * $h;
        $thumb = imagecreatetruecolor( $neww, $newh );
        imagecopyresampled( $thumb, $im, 0, 0, 0, 0, $neww, $newh, $w, $h );
        header( 'Content-type: image/png' );
        imagepng( $thumb );
    }
    else {
        header( 'Content-type: image/jpg' ); // TODO account for png
        file( $filename );
    }
?>
