<?php
    session_start();
    set_include_path( get_include_path() . PATH_SEPARATOR . '/home/dionyziz/life/models/ZendGdata/library' );
    function Redirect( $url = '' ) {
        $url = 'http://dionyziz.kamibu.com/life/' . $url;
        header( 'Location: ' . $url );
    }
    function view( $path, $variables = false) {
        if ( $variables === false ) {
            $variables = array();
        }
        extract( $variables );
        include 'views/header.php';
        include 'views/' . $path . '.php';
        include 'views/footer.php';
    }
    global $settings;
    $settings = include 'settings.php';
    include 'models/db.php';
    include 'models/user.php';
    include 'models/post.php';
    include 'models/photo.php';
    include 'models/hash.php';
?>
