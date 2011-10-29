<?php
    class UserController {
        public function listing() {
            throw new NotImplemented( 'UserController::Listing' );
        }
        public function createView( $error ) {
            $registerform = true;
            $success = false;
            view(
                'user/create', compact( 'error', 'success' )
            );
        }
        public function create( $name ) {
            // TODO: use key files instead of password
            try {
                $credentials = User::register( $name );
            }
            catch ( UserException $e ) {
                Redirect( 'user/create?error=noregister' );
            }
            view( 
                'user/create', compact( 'success', 'credentials' )
            );
            $_SESSION[ 'user' ] = User::item( $credentials[ 'id' );
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
