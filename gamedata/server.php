<?php
	$dataFile = "data.txt";
	$id = "program";
	$action = "action";
	$info = "info";

	readData();
	updateData();
	printData();

function readData()
{
	global $data, $dataFile;
	if (!file_exists($dataFile))	// Create if it doesn't exist
	{
		$handle = fopen($dataFile,"w");
		fwrite($handle,"", 0);
		fclose($handle);
	}
	$handle = fopen($dataFile,"r");	// Open
	while(!flock($handle,LOCK_SH))	// Lock
	{	
		sleep(1);
	}
	if (filesize($dataFile) > 0)
	{
	  $data_file = fread($handle,filesize($dataFile));	// Read
	  flock($handle, LOCK_UN);	// Unlock
	  $data = unserialize($data_file);
	}
	else
	{
	  $data = "";
	}
	fclose($handle);	// Close
}

function updateData()
{
	global $data, $id, $action, $info, $element;
	$keys = array_keys($_GET);
	if (count($keys) > 0)
	{
		if ($keys[0] == $id && $keys[1] == $action && $keys[2] == $info)	//Program found
		{
			$element = array();
			$element[$id] = $_GET[$id];
			$element[$info] = $_GET[$info];
			$program = $element[$id];

			if (is_array($data))  //extsting data
			{
				$found = 0;
				foreach ($data as &$entry)
				{
					if ($entry[$id] == $program)	//Program found
					{
						if ($_GET[$action] == 0) //Read
						{
							$element=$entry;
 						}
						elseif ($_GET[$action] == 1) //Write
						{
							$entry=$element;
						}
						$found = 1;
						break;
					}
				}
				if ($found == 0)	array_push($data,$element);	//New program
			}
			else
			{
				$data = array($element);		//First program
			}
		
			if ($_GET[$action] == 1) writeData();
		}
	}
}

function writeData()
{
	global $data, $dataFile;
	$handle = fopen($dataFile,"w");
	while(!flock($handle,LOCK_EX))
	{
		sleep(1);
	}
	$data_string=serialize($data);	// Serialize
	fwrite($handle,$data_string, strlen($data_string));	// Write
	flock($handle,LOCK_UN);	// Unlock
	fclose($handle);	// Close
}

function printData()
{
	global $element, $info;
	$keys = array_keys($element);
	if (count($keys) > 0)
	{
		foreach ($keys as &$key)
		{
			if ($key == $info)
			{
				echo $element[$key];
			}
		}
	}
	echo "<br>";
}

?>