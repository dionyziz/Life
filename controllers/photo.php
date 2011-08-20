<?php
    class PhotoController {
        public function Create( $data, $filename, $visibility ) {
            if ( $data == '' ) {
                // attempt to overcome PHP bug that causes
                // the HTTP POST value to be empty
                // it seems that PHP is trying to urldecode the
                // raw HTTP POST string, but for big enough values
                // this causes a memory overflow and the data
                // item remains unset
                // Here we process the php://input stream directly.
                $vars = explode( '&', file_get_contents( 'php://input' ) );
                foreach ( $vars as $var ) {
                    $vardata = explode( '=', $var );
                    $key = $vardata[ 0 ];
                    $value = $vardata[ 1 ];
                    if ( $key == 'data' ) {
                        $data = urldecode( $value );
                        break;
                    }
                }
            }

            if ( !isset( $_SESSION[ 'user' ] ) ) {
                throw new Exception( 'Not authorized.' );
            }
            if ( $data == '' ) {
                echo "Data provided is empty. Dumping $_POST variable.\n";
                var_dump( $_POST );
                throw new Exception( 'Data provided is empty.' );
            }
            $filename = strtolower( $filename );
            $extension = substr( $filename, strrpos( $filename, '.' ) + 1 );
            switch ( $extension ) {
                case 'jpg':
                case 'gif':
                case 'png':
                    break;
                default:
                    throw new Exception( 'Unrecognized image type. Expected "jpg", "gif", or "png", but got "' . $extension . '".' );
            }
            switch ( $visibility ) {
                case 'public':
                case 'private':
                    break;
                default:
                    throw new Exception( 'Invalid visibility; expected "public" or "private", but got "' . $visibility . '"' );
            }
            $data = base64_decode( $data );
            if ( $data === false ) {
                throw new Exception( 'Invalid data supplied: data is not base64-encoded.' );
            }
            $im = @imagecreatefromstring( $data );
            if ( $im !== false ) {
                $width = imagesx( $im );
                $height = imagesy( $im );
            }
            else {
                echo 'Warning: We believe this is not a valid image file, but we\'re uploading it anyway.';
                $width = 0;
                $height = 0;
            }
            $result = Photo::create( $filename, $extension, strlen( $data ), $_SESSION[ 'user' ][ 'id' ], $width, $height );
            $id = $result[ 'id' ];
            $filename = $result[ 'filename' ];
            $uploadfile = 'uploads/' . $filename;
            if ( file_exists( $uploadfile ) ){
                throw new Exception( 'File already exists.' );
            }
            file_put_contents( $uploadfile, $data );
            $taken = Photo::timeFromFile( $uploadfile );
            Photo::update( $id, $taken );
            echo 'File uploaded successfully.';
            Post::create( $filename, $_SESSION[ 'user' ][ 'id' ], 'photo', $visibility, $taken );
        }
    }
?>
