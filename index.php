<?php
    include 'header.php';
    $methods = array(
        'create' => 1,
        'view' => 0,
        'listing' => 0,
        'update' => 1,
        'delete' => 1
    );
    if ( isset( $_GET[ 'resource' ] ) ) {
        $resource = $_GET[ 'resource' ]; 
    }
    else {
        $resource = '';
    }
    if ( isset( $_GET[ 'method' ] ) ) {
        $method = $_GET[ 'method' ];
    }
    else {
        $method = '';
    }
    if ( !isset( $methods[ $method ] ) ) {
        $method = 'view';
    }
    switch ( $_SERVER[ 'REQUEST_METHOD' ] ) {
        case 'POST':
            $http_vars = $_POST;
            break;
        case 'GET':
            $http_vars = $_GET;
            break;
        default:
            $http_vars = array();
            break;
    }
    if ( $methods[ $method ] == 1 && $_SERVER[ 'REQUEST_METHOD' ] != 'POST' ) {
        $method = $method . 'View';
        // die( 'Method "' . $method . '" which is a POST method called using HTTP GET. (Rejected)'  );
    }
    $resource = basename( $resource );
    $filename = 'controllers/' . $resource . '.php';
    if ( !file_exists( $filename ) ) {
        // die( 'File not found: ' . $filename );
        $resource = 'session';
        $method = 'createView';
        $filename = 'controllers/' . $resource . '.php';
    }
    include $filename;
    $controllername = ucfirst( $resource ) . 'Controller';
    $methodname = $method;
    $reflection = new ReflectionMethod( $controllername, $methodname );
    $parameters = $reflection->getParameters();
    $arguments = array();
    foreach ( $parameters as $parameter ) {
        if ( isset( $http_vars[ $parameter->name ] ) ) {
            $arguments[] = $http_vars[ $parameter->name ];
        }
        else {
            $arguments[] = null;
        }
    }
    try {
        call_user_func_array( array( $controllername, $methodname ), $arguments );
    }
    catch ( NotImplemented $e ) {
        die( 'An attempt was made to call a non-implemented function: ' . $e->getFunctionName() );
    }
    catch ( RedirectException $e ) {
        global $settings;
        $url = $settings[ 'url' ] . $e->getURL();
        header( 'Location: ' . $url );
    }
    catch ( Exception $e ) {
        die( $controllername . '::' . $methodname . ' call rejected: ' . $e->getMessage() );
    }
?>
