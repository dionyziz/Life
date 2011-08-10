/*
 * Developer: Dionysis "dionyziz" Zindros <dionyziz@gmail.com>
 */

function getCurrentVisibility() {
    if ( $( 'form.newpost span' ).hasClass( 'open' ) ) {
        return 'public';
    }
    return 'private';
}

if ( document.getElementsByTagName( 'textarea' ).length ) {
    document.getElementsByTagName( 'textarea' )[ 0 ].onkeypress = function ( e ) {
        if ( e.keyCode == 13 && e.shiftKey == 0 ) { // enter
            this.blur();
            $.post( 'post/create', {
                text: $( 'textarea' )[ 0 ].value,
                visibility: getCurrentVisibility()
            }, function () {
                window.location.reload(); // TODO: append post dynamically
            } );
        }
    };
}
if ( document.getElementsByTagName( 'input' ).length ) {
    document.getElementsByTagName( 'input' )[ 0 ].focus();
}
if ( document.getElementById( 'logoutlink' ) ) {
    document.getElementById( 'logoutlink' ).onclick = function () {
        $.post( 'session/delete', {}, function () {
            window.location.href = '';
        } );
        return false;
    };
    $( 'body' )[ 0 ].addEventListener( 'dragenter', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
        $( '.uploadarea' ).show();
    }, false );
    $( '.uploadarea' )[ 0 ].addEventListener( 'dragleave', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
        $( '.uploadarea' ).hide();
    }, false );
    $( '.uploadarea' )[ 0 ].addEventListener( 'dragover', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
    }, false );
    $( '.uploadarea' )[ 0 ].addEventListener( 'drop', function ( e ) {
        e.stopPropagation();
        e.preventDefault();

        var dt = e.dataTransfer;
        var files = dt.files;

        handleFiles( files, 0 );
    }, false );

    function handleFiles( files, i ) {
        if ( i == files.length ) {
            $( '.uploadarea' ).text( 'Drop the file to post it to your life.' ).hide();
            // window.location.reload(); // TODO: append new posts dynamically
            return;
        }
        if ( files.length == 1 ) {
            $( '.uploadarea' ).text( 'Uploading file...' );
        }
        else {
            $( '.uploadarea' ).text( 'Uploading file ' + ( i + 1 ) + ' of ' + files.length + '...' );
        }
        uploadFile( files[ i ], function () {
            handleFiles( files, i + 1 );
        } );
    }

    function uploadFile( file, continuation ) {
        var reader = new FileReader();

        reader.onload = function ( e ) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if ( xhr.readyState == 4 ) {
                    continuation();
                }
            };
            xhr.open( 'POST', 'photo/create', true );
            xhr.setRequestHeader( 'Content-type', 'application/x-www-form-urlencoded' );
            var formdata = {
                data: e.target.result.split( ',' )[ 1 ],
                filename: file.fileName,
                visibility: getCurrentVisibility()
            };
            var fields = [];
            for ( var i in formdata ) {
                formdata[ i ] = encodeURIComponent( formdata[ i ] );
                fields.push( i + '=' + formdata[ i ] );
            }
            var urlencoded = fields.join( '&' );

            xhr.send( urlencoded );
        };
        reader.readAsDataURL( file );
    }

    $( 'a.x' ).click( function () {
        var link = this;
        $.post( 'post/delete', {
            postid: $( this ).parents( 'p' )[ 0 ].id.split( 'p' )[ 1 ]
        }, function () {
            $( $( link ).parents( 'div' )[ 0 ] ).remove();
        } );
        return false;
    } );
    $( 'form.newpost span.padlock' ).click( function () {
        $( this ).toggleClass( 'open' );
        if ( $( this ).hasClass( 'open' ) ) {
            $( this )[ 0 ].title = 'This post will be visible to everyone'
        }
        else {
            $( this )[ 0 ].title = 'This post will be visible only to you'
        }
    } ).click();

    $( 'span.clock' ).click( function () {
        var date = $( $( this ).parents( 'span' )[ 0 ] ).find( 'span.date' ).text();
        var time = $( this ).text();
        var newTime = prompt( "Enter new date/time for this post:", date + ', ' + time );
        if ( newTime ) {
            $.post( 'post/update', {
                id: $( $( this ).parents( 'div' )[ 0 ] ).find( 'p' )[ 0 ].id.split( 'p' )[ 1 ],
                created: newTime
            }, function () {
                window.location.reload(); // TODO: update date/time dynamically
            } );
        }
    } );
}
