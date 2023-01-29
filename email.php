<?php
$file = fopen("downloads.txt","r") or die();
$data = fread($file,filesize("downloads.txt"));
fclose($file);

$subject = "LitDev Downloads";
$to = "steve.todman@gmail.com";
try
{
 mail($to, $subject, $data, null);
}
 catch (Exception $e)
{
?>
