<?php
session_start();
$name = date('YmdHis');
$newname="images/".$name.".jpg";
$file = file_put_contents( $newname, file_get_contents('php://input') );
if (!$file) {
    print "ERROR: Failed to write data to $filename, check permissions\n";
    exit();
}


$url2 = "images/".$name.".jpg";
print "$url2\n";

?>