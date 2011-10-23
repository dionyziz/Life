<?php
    include 'header.php';

    class Picasa {
        public function __construct() {
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass('Zend_Gdata_Photos');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
            Zend_Loader::loadClass('Zend_Gdata_AuthSub'); 

            $serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
            $username = 'dionyziz@gmail.com';
            $password = 'password';
            $client = Zend_Gdata_ClientLogin::getHttpClient( $username, $password, $serviceName );

            $gp = new Zend_Gdata_Photos( $client, 'Dionyziz-Life-1.0' );

            $query = $gp->newAlbumQuery();

            $query->setUser( 'default' );
            $query->setAlbumName( 'Sikinos' );

            $albumFeed = $gp->getAlbumFeed( $query );

            $i = 0;
            foreach ( $albumFeed as $albumEntry ) {
                try { 
                    $albumid = $albumEntry->getGphotoAlbumId();

                    $exif = $albumEntry->getExifTags();
                    $time = $exif->getTime();
                    if ( $time == null ) {
                        echo "Photo does not contain time information.\n";
                        continue;
                    }
                    $timestamp = $time->getText();

                    $mediaContentArray = $albumEntry->getMediaGroup()->getContent();
                    $contentUrl = $mediaContentArray[ 0 ]->getUrl();
                    $mediaThumbnailArray = $albumEntry->getMediaGroup()->getThumbnail();
                    if ( $mediaThumbnailArray == null ) {
                        echo "Photo does not contain thumbnail.\n";
                        continue;
                    }
                    $maxwidth = 0;
                    $maxid = 0;
                    foreach ( $mediaThumbnailArray as $id => $thumb ) {
                        if ( $thumb->getWidth() > $maxwidth ) {
                            $maxwidth = $thumb->getWidth();
                            $maxid = $id;
                            $thumbnailUrl = $thumb->getUrl();
                        }
                    }

                    // echo "Importing image " . $contentUrl . " from Picasa... ";
                    // $diff = 1310008564116;
                    $link = $albumEntry->getAlternateLink()->getHref();
                    $parts = explode( '/', $link );
                    $userid = $parts[ 3 ];
                    $parts = explode( '#', $link );
                    $photoid = $parts[ 1 ];
                    $link = 'https://plus.google.com/photos/' . $userid . '/albums/' . $albumid . '/' . $photoid;
                    // echo( $link . ': ' . date( "Y-m-d H:i:s", $timestamp - $diff ) . "\n" );
                    Post::update( 
                        Post::create( 'picasa:' . $contentUrl . ' ' . $thumbnailUrl . ' ' . $link, 1, 'photo', 'public' ),
                        date( "Y-m-d H:i:s", $timestamp / 1000 )
                    );
                    ++$i;
                    echo $i . ' / ' . count( $albumFeed ) . "\n";
                }
                catch ( Exception $e ) {
                    echo "Failed to retrieve photo EXIF information.\n";
                }
            }
        }
    }

    new Picasa();
?>
