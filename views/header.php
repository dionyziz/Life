<!doctype html>
<!--
    Developer: Dionysis "dionyziz" Zindros <dionyziz@gmail.com>
-->
<html>
    <head>
        <title>dionyziz' life</title>
        <base href="http://dionyziz.kamibu.com/life/" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
        <meta charset="utf-8" />
    </head>
    <body>
        <ul class="toolbar"><?php
        if ( $loggedin ) {
            ?><li><a href="session/delete" id="logoutlink">Log out</a></li>
            <li><span>dionyziz</span></li>
<?php
        }
        else {
            ?><li><a href="session/view">Log in</a></li><?php
        }
        ?></ul><?php
