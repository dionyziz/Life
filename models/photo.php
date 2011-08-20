<?php
    class Photo {
        public static function create( $title, $extension, $size, $userid, $width, $height ) {
            $hash = hash_random();
            $id = db_insert(
                'photos',
                compact(
                    'title', 'extension', 'size', 'userid', 'hash', 'width', 'height'
                )
            );
            assert( $id > 0 );
            return array(
                'id' => $id,
                'filename' => $id . '-' . $hash . '.' . $extension
            );
        }
        public static function item( $id ) {
            assert( $id > 0 );
            $rows = db_select( 'photos', compact( 'id' ) );
            if ( empty( $rows ) ) {
                return false;
            }
            return array_pop( $rows );
        }
        public static function update( $id, $taken ) {
            assert( $id > 0 );
            $taken = date( "Y-m-d H:i:s", $taken );
            db_update( 'photos', compact( 'id' ), compact( 'taken' ) );
        }
        public static function timeFromFile( $file ) {
            $exif = exif_read_data( $file, 0, true );
            return strtotime( $exif[ 'EXIF' ][ 'DateTimeOriginal' ] );
        }
    }
?>
