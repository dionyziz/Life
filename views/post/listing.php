<?php
    if ( $loggedin ) {
        include 'views/post/create.php';
    }
    $lastdate = '';
    ?><div class="posts"><?php
    $i = 0;
    if ( !count( $posts ) ) {
        ?><p>No posts here.</p>
        <p>Why not check out this <a href="http://en.wikipedia.org/wiki/Special:Random">random Wikipedia article</a> to learn something new?</p><?php
    }
    foreach ( $posts as $post ) {
        $differentday = false;
        $lasthourofday = false;
        if ( $lastdate != date( 'F j', strtotime( $post[ 'created' ] ) ) ) {
            $lastdate = date( 'F j', strtotime( $post[ 'created' ] ) );
            $differentday = true;
        }
        if ( isset( $posts[ $i + 1 ] ) && date( 'F j', strtotime( $posts[ $i + 1 ][ 'created' ] ) ) != $lastdate ) {
            $lasthourofday = true;
        }
        ?><div<?php
        $classes = array();
        if ( $lasthourofday ) {
            $classes[] = 'lasthour';
        }
        if ( $differentday ) {
            $classes[] = 'different';
        }
        if ( !empty( $classes ) ) {
            ?> class="<?php
            echo implode( ' ', $classes );
            ?>"<?php
        }
        ?>><?php
        ?><span class='time'><span class='clock<?php
        if ( $loginuserid == $post[ 'userid' ] ) {
            ?> editable<?php
        }
        ?>'<?php
        if ( $loginuserid == $post[ 'userid' ] ) {
            ?> title="Edit the time and date of this post"<?php
        }
        ?>><?php
        echo date( "G:i", strtotime( $post[ 'created' ] ) );
        ?></span><?php
        if ( $differentday ) {
            ?><span class='date'><?php
            echo date( "l, F jS", strtotime( $post[ 'created' ] ) );
            ?></span><?php
        }
        if ( $post[ 'visibility' ] == 'private' ) {
            ?><span class="padlock" title="This post is visible only to you"></span><?php
        }
        ?></span><p id="p<?php
        echo $post[ 'id' ];
        ?>"><?php
        if ( $loginuserid == $post[ 'userid' ] ) {
            ?><a href="" title='Delete this post' class='x'>&times;</a><?php
        }
        if ( $post[ 'type' ] == 'text' ) {
            ?><span class="text"><?php
            echo nl2br( htmlspecialchars( $post[ 'text' ] ) );
            ?></span><?php
        }
        else {
            ?><img src="thumb.php?file=uploads/<?php
            echo $post[ 'text' ];
            ?>" alt="" /><?php
        }
        ?></p></div><?php
        ++$i;
    }
    ?></div><?php
?>
