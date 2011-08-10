<?php
    class PostController {
        public function Listing() {
            $posts = Post::Listing( 1, isset( $_SESSION[ 'user' ] ) && $_SESSION[ 'user' ][ 'id' ] == 1 );
            view(
                'post/listing', array(
                    'posts' => $posts,
                    'loggedin' => isset( $_SESSION[ 'user' ] ),
                    'loginuserid' => $_SESSION[ 'user' ][ 'id' ]
                )
            );
        }
        public function Create( $text, $visibility ) {
            if ( !is_string( $text ) ) {
                throw new Exception( '"text" parameter must be a string, ' . gettype( $text ) . ' given.' );
            }
            if ( !isset( $_SESSION[ 'user' ] ) ) {
                throw new Exception( 'Not authorized.' );
            }
            $postid = Post::Create( $text, 1, 'text', $visibility );
            echo 'Post created successfully with id ' . $postid . '.';
        }
        public function Delete( $postid ) {
            if ( !isset( $_SESSION[ 'user' ] ) ) {
                // TODO: check if post belongs to user
                throw new Exception( 'Not authorized.' );
            }
            if ( ( string )( int )$postid != $postid ) {
                throw new Exception( 'Post id provided was not an integer: "' . $postid . '" given' );
            }
            Post::delete( $postid );
            echo 'Post deleted successfully.';
        }
        public function Update( $id, $created ) {
            if ( !isset( $_SESSION[ 'user' ] ) ) {
                // TODO: check if post belongs to user
                throw new Exception( 'Not authorized.' );
            }
            $timestamp = date( 'Y-m-d H:i:s', strtotime( $created ) );
            $affected = Post::update( $id, $timestamp );
            echo $affected . ' post(s) updated successfully.';
        }
    }
?>
