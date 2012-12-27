<?php
    /*
    index.php: A simple RESTful MVC handler with named parameters.

    Copyright (C) 2011 by Dionysis "dionyziz" Zindros <dionyziz@gmail.com>

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
    */

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
            try {
                $arguments[] = $parameter->getDefaultValue();
            }
            catch ( ReflectionException $e ) {
                // not an optional parameter
                $arguments[] = null;
            }
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
