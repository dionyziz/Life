<?php
    class User {
        public static function authenticate( $username, $password ) {
            $users = db_array(
                'SELECT
                    id, name
                FROM
                    users
                WHERE
                    name = :username
                    AND password = :password
                LIMIT 1',
                array(
                    'username' => $username,
                    'password' => md5( $password )
                )
            );
            if ( count( $users ) ) {
                return $users[ 0 ];
            }
            return false;
        }
    }
?>
