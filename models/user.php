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
                    id, name, password, hashing
                FROM
                    users
                WHERE
                    name = :username
                LIMIT 1',
                compact( 'username' )
            );
            if ( count( $users ) ) {
                $storedCrypto = $users[ 0 ][ 'password' ];
                $reEncrypted = blowfishEncrypt( $password, $users[ 0 ][ 'hashing' ] );
                if ( $reEncrypted[ 'password' ] == $storedCrypto ) {
                    return $users[ 0 ];
                }
            }
            return false;
        }
        public static function register( $name ) {
            $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            for ( $i = 0; $i < 128; ++$i ) {
                $password .= $alphabet[ rand( 0, strlen( $alphabet ) - 1 ) ];
            }
            $decryptedPass = $password;
            $encrypted = blowfishEncrypt( $password );
            $password = $encrypted[ 'password' ];
            $hashing = $encrypted[ 'hashing' ];
            $name = str_replace( '.', '', $name );
            try {
                $id = db_insert( 'users', compact( 'name', 'password', 'hashing' ) );
                return compact( 'id', 'decryptedPass' );
            }
            catch ( Exception $e ) {
                // user already exists
                throw new UserException;
            }
        }
    }
?>
