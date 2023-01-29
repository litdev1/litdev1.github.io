<?php
$name=$_POST['download'];
$download='downloads/'.$name;
$ip = $_SERVER['REMOTE_ADDR'];
$host = gethostbyaddr($ip);

if ($ip != '94.193.58.255')
{
 $date=getdate(date("U"));
 $info=$date[hours].':'.$date[minutes].':'.$date[seconds].' '.$date[mday].'/'.$date[mon].'/'.$date[year].' ('.$host.') '.$name.PHP_EOL;
 $file=fopen('downloads.txt','a') or die();
 fwrite($file,$info);
 fclose($file);

/*
 $subject = "LitDev log messsge";
 $to = "steve.todman@gmail.com";
 $message = $info;
 try
 {
  mail($to, $subject, $message, null);
 }
 catch (Exception $e)
 {
 }
*/
}
  
header("Location: $download");
?>
