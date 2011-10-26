<?php
    $settingsLocal = include 'settings-local.php';
    $settingsGlobal = array(
        'db' => array(
            'user' => 'life',
            'password' => 'password',
            'name' => 'life'
        ),
        'url' => 'http://life.kamibu.com/'
    );

    foreach ( $settingsLocal as $key => $setting ) {
        $settingsGlobal[ $key ] = $setting;
    }
    return $settingsGlobal;
?>
