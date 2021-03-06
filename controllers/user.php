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
        public function create( $name ) {
            try {
                $credentials = User::register( $name );
            }
            catch ( UserException $e ) {
                Redirect( 'user/create?error=noregister' );
            }
            $_SESSION[ 'user' ] = User::item( $credentials[ 'id' ] );
            echo $_SESSION[ 'user' ][ 'name' ] . '.' . $credentials[ 'decryptedPass' ];
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
