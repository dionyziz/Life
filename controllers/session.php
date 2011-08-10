<?php
    class SessionController {
        public function View( $error ) {
            view( 'session/view', compact( 'error' ) );
        }
        public function Create( $username, $password ) {
            $user = User::authenticate( $username, $password );
            if ( $user === false ) {
                return Redirect( 'session/view?error=yes' );
            }
            $_SESSION[ 'user' ] = $user;
            return Redirect( 'index.php' );
        }
        public function Delete() {
            session_destroy();
        }
    }
?>
