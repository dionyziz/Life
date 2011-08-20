<?php
    class Post {
        public static function create( $text, $userid = 1, $type = 'text', $visibility = 'private', $created = false ) {
            $data = compact( 'text', 'userid', 'type', 'visibility' );
            if ( $created !== false ) {
                $data[ 'created' ] = date( "Y-m-d H:i:s", $created );
            }
            return db_insert(
                'posts', $data
            );
        }
        public static function delete( $id ) {
            return db_update(
                'posts', compact( 'id' ), array( 'deleted' => 'yes' )
            );
        }
        public static function listing( $userid, $includeprivate = true ) {
            $visibility = array( 'public' );
            if ( $includeprivate ) {
                $visibility[] = 'private';
            }
            $rows = db_array(
                'SELECT
                    id, text, type, created, visibility, userid
                FROM
                    posts
                WHERE
                    userid = :userid
                    AND visibility IN :visibility
                    AND deleted = "no"
                ORDER BY
                    DATE( created ) DESC, TIME( created ) ASC, id ASC',
                compact( 'userid', 'visibility' )
            );
            foreach ( $rows as $i => $row ) {
                $rows[ $i ][ 'formatted' ] = Post::format( $row[ 'text' ] );
            }
            return $rows;
        }
        public static function update( $id, $created ) {
            return db_update(
                'posts', compact( 'id' ), compact( 'created' )
            );
        }
        public static function format( $text ) {
            return nl2br( htmlspecialchars( $text ) );
        }
    }
?>
