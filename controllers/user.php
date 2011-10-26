<?php
    class UserController {
        public function listing() {
            throw new NotImplemented( 'UserController::Listing' );
        }
        public function createView( $error ) {
            $registerform = true;
            view(
                'user/create', compact( 'error' )
            );
        }
        public function create( $name, $password, $password2 ) {
            // TODO: use key files instead of password
            if ( $password != $password2 ) {
                Redirect( 'user/create?error=nomatch' );
            }
            try {
                $id = User::register( $name, $password );
            }
            catch ( UserException $e ) {
                Redirect( 'user/create?error=noregister' );
            }
            $_SESSION[ 'user' ] = User::item( $id );
            Redirect( 'post/listing' );
        }
        public function delete( $id ) {
            throw new NotImplemented( 'UserController::Delete' );
        }
        public function update( $id, $password ) {
            throw new NotImplemented( 'UserController::Update' );
        }
        public function view( $id ) {
            throw new NotImplemented( 'UserController::View' );
        }
    }
?>
