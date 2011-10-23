<?php
    class UserException extends Exception { };

    class User {
        public static function itemByName( $name ) {
            return array_shift( db_select( 'users', compact( 'name' ) ) );
        }
        public static function item( $id ) {
            return array_shift( db_select( 'users', compact( 'id' ) ) );
        }
        public static function authenticate( $username, $password ) {
            $users = db_array(
                'SELECT
                    id, name, password
                FROM
                    users
                WHERE
                    name = :username
                LIMIT 1',
                compact( 'username' )
            );
            if ( count( $users ) ) {
                $storedCrypto = $users[ 0 ][ 'password' ];
                if ( $storedCrypto == blowfishEncrypt( $password ) ) {
                    return $users[ 0 ];
                }
            }
            return false;
        }
        public static function register( $name,  $password ) {
            $password = blowfishEncrypt( $password );
            try {
                return db_insert( 'users', compact( 'name', 'password' ) );
            }
            catch ( Exception $e ) {
                // user already exists
                throw new UserException;
            }
        }
    }
?>
