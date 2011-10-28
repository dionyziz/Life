<?php
    class PostController {
        public function view( $id ) {
            throw new NotImplemented;
        }
        public function listing( $name ) {
            echo $name;
            $user = User::itemByName( $name );
            if ( empty( $user ) ) {
                throw new Exception( 'User not found' );
            }
            $userid = $user[ 'id' ];
            $user[ 'name' ] = $name;
            var_dump( $user );
            $posts = Post::Listing( $userid, isset( $_SESSION[ 'user' ] ) && $_SESSION[ 'user' ][ 'id' ] == $userid );
            view(
                'post/listing', array(
                    'user' => $user,
                    'posts' => $posts,
                    'loggedin' => isset( $_SESSION[ 'user' ] ),
                    'loginuserid' => $_SESSION[ 'user' ][ 'id' ]
                )
            );
        }
        public function create( $text, $visibility ) {
            if ( !is_string( $text ) ) {
                throw new InvalidInput( '"text" parameter must be a string, ' . gettype( $text ) . ' given.' );
            }
            if ( !isset( $_SESSION[ 'user' ] ) ) {
                throw new NotAuthorized;
            }
            $postid = Post::Create( $text, $_SESSION[ 'user' ][ 'id' ], 'text', $visibility );
            echo 'Post created successfully with id ' . $postid . '.';
        }
        public function delete( $id ) {
            if ( !self::owner( $id ) ) {
                throw new NotAuthorized;
            }
            if ( ( string )( int )$id != $id ) {
                throw new InvalidInput( 'Post id provided was not an integer: "' . $id . '" given' );
            }
            Post::delete( $id );
            echo 'Post deleted successfully.';
        }
        public function update( $id, $created ) {
            if ( !self::owner( $id ) ) {
                throw new NotAuthorized;
            }
            if ( !( int )$id ) {
                throw new InvalidInput;
            }
            $timestamp = date( 'Y-m-d H:i:s', strtotime( $created ) );
            $affected = Post::update( $id, $timestamp );
            echo $affected . ' post(s) updated successfully.';
        }
        private function owner( $id ) {
            $post = Post::item( $id );
            return isset( $_SESSION[ 'user' ] ) && $_SESSION[ 'user' ][ 'id' ] == $post[ 'userid' ];
        }
    }
?>
