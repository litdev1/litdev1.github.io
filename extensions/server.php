<?php
	$dataFile = "data.txt";
	$message = "message";

	logData();
 
function logData()
{
	global $dataFile, $message;
	if (!file_exists($dataFile))	// Create if it doesn't exist
	{
		$file = fopen($dataFile,"w");
		fwrite($file,"", 0);
		fclose($file);
	}
	$file = fopen($dataFile,'a') or die();	// Open
	while(!flock($file,LOCK_SH))	// Lock
	{	
		sleep(1);
	}
	$keys = array_keys($_GET);
	if (count($keys) > 0)
	{
		if ($keys[0] == $message)	//Message found
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			$host = gethostbyaddr($ip);
			$date=getdate(date("U"));
			$info=$date[hours].':'.$date[minutes].':'.$date[seconds].' '.$date[mday].'/'.$date[mon].'/'.$date[year].' ('.$ip.' : '.$host.') : '.$_GET[$message].PHP_EOL;
			fwrite($file,$info);
		}
	}	
	fclose($file);	// Close
}
?>