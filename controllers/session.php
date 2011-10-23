<?php
    class SessionController {
        public function createView( $error ) {
            if ( isset( $_SESSION[ 'user' ] ) ) {
                Redirect( 'post/listing' );
            }
            $loginform = true;
            view( 'session/view', compact( 'error' ) );
        }
        public function create( $username, $password ) {
            $user = User::authenticate( $username, $password );
            if ( $user === false ) {
                Redirect( 'session/create?error=yes' );
            }
            $_SESSION[ 'user' ] = $user;
            Redirect( 'index.php' );
        }
        public function delete() {
            session_destroy();
        }
    }
?>
