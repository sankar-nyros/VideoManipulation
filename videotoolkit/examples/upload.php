<?php
if($_FILES['img']['error'] > 0) die('Error ' . $_FILES['file']['error']);
if(empty($_FILES['img']['name'])) die('No file sent.');

$tmp = $_FILES['img']['tmp_name'];

if(is_uploaded_file($tmp))
{
    if(move_uploaded_file($tmp, 'watermark.jpg'))
    {
    	echo "1";
    }
    else
    {
    	echo "0";
    }
}
else echo 'Upload failed !';
?>
