<!doctype html>
<!--
    Developer: Dionysis "dionyziz" Zindros <dionyziz@gmail.com>
-->
<html>
    <head>
        <title><?php
        echo $user[ 'name' ];
        ?>' life</title>
        <base href="<?php
        global $settings;
        echo $settings[ 'url' ];
        ?>" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
        <meta charset="utf-8" />
    </head>
    <body>
        <ul class="toolbar"><?php
        if ( $loginform ) {
            ?><li><a href='user/create'>Get a life</a></li><?php
        }
        else {
            if ( $loggedin ) {
                ?><li><a href="session/delete" id="logoutlink">Log out</a></li>
                <li><span><?php
                echo $user[ 'name' ];
                ?></span></li> <?php
            }
            else {
                ?><li><a href="session/view">Log in</a></li><?php
            }
        }
        ?></ul><?php
