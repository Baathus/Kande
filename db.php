<?php

// Kobler til database med verdier fra "db_info.cfg".
// Hvis en database ikke eksisterer vil man få spørsmål om å opprette en.
// Passordet for denne operasjonen kan redigeres noen linjer lenger ned ($dbPassword)
// Hvis den ikke oppnår kontakt med MySQL-serveren vil funksjonen kaste en RuntimeException.

function connectToDB()
{
	$file = file("db_info.cfg"); // Legger alt innhold i config-fila inn i array. Deles opp ved linjeskift.

	$dbPassword = 'passord';
	$dbName = trim($file[0]); // Trim for å få bort eventuelle mellomrom, samt newline
	$user = trim($file[1]);
	$pass = trim($file[2]);
	$host = trim($file[3]);
	
	return connectDirectToDB($dbName, $user, $pass, $host);
}

// Putter en ressurs inn i databasen.
// ID og Time blir satt automatisk. Dataen fra ResourceClass-objektet vil derfor ignoreres.
// Funksjonen returnerer ressursens nye ID fra databasen.
function addResource($resObject)
{
	global $dbName;
	
	$sql = "INSERT INTO `".$dbName."`.`resources` (
		`id` ,
		`title` ,
		`link` ,
		`author` ,
		`timecreated` ,
		`rating` ,
		`description` ,
		`tags`
		)
		VALUES (
		NULL , '".$resObject->name."', '".$resObject->url."', '".$resObject->owner."',
		".time()." , '".$resObject->score."', '".$resObject->description."', '".dcTagArrayToString($resObject->tags)."'
		)";

	$result = mysql_query($sql);

	if($result)
		$result = mysql_insert_id();
		
	return $result;
}

// Returnerer en array med "ResourceClass"-objekter.
// TO INT-er definerer startpunkt og antall som skal leses inn.
// En STRING brukes for å bestemme hva man sorterer på. Kan velge mellom "rating", "timecreated" og flere. Bruker navn fra databasen.
// En BOOL som kan settes til true for å sortere i stigende rekkefølge.
// En ARRAY med tags som begrenser søket. Søk med flere tags returnerer unionen (OR).
// Funksjonen returnerer ikke kommentarer og "description"-feltene. Bruk da "getResourceByID" i stedet.
function getResources($startFrom, $count, $sortBy, $ascending, $tags)
{
	global $dbName;
	
	$tagQuery = "";
	
	if(count($tags) > 0)
	{
		$tagQuery = "WHERE tags LIKE '%".str_replace(";", "<?SK$>", $tags[0])."%'";
		
		for($i = 1; $i < count($tags); $i++)
			$tagQuery .= " OR tags LIKE '%".str_replace(";", "<?SK$>", $tags[$i])."%'";
	}
	
	if($ascending)
		$sortDir = "ASC";
	else
		$sortDir = "DESC";
	
	$sql = "SELECT * FROM `".$dbName."`.`resources` ".$tagQuery." ORDER BY ".$sortBy." ".$sortDir." LIMIT ".$startFrom.", ".$count;

	$result = mysql_query($sql);
	
	if($result)
	{
		$resArray = array();
		
		while($resData = mysql_fetch_row($result))
			array_push($resArray, new ResourceClass($resData[0], $resData[1], $resData[2], $resData[6], dcTagStringToArray($resData[7]), $resData[5], $resData[4], $resData[3], null));
		
		$result = $resArray;
	}
	
	return $result;
}

// Returnerer et "ResourceClass"-objekt, med description.
function getResourceByID($id)
{
	global $dbName;
	
	$sql = "SELECT * FROM `".$dbName."`.`resources` WHERE id = ".$id;
	
	$result = mysql_query($sql);
	
	if($result)
	{
		$resData = mysql_fetch_row($result);
		$result = new ResourceClass($resData[0], $resData[1], $resData[2], $resData[6], dcTagStringToArray($resData[7]), $resData[5], $resData[4], $resData[3], array());
	}
	
	return $result;
}

// Setter ny rating/score på en bestemt ressurs.
function modifyResourceScoreByID($id, $newScore)
{
	global $dbName;
	
	$sql = "UPDATE `".$dbName."`.`resources` SET `rating` = '".$newScore."' WHERE `resources`.`id` = ".$id;
	
	$result = mysql_query($sql);
	
	return $result;
}

// Bytter ut en eksisterende ressurs i databasen med et nytt ResourceClass-objekt.
function modifyResourceByID($id, $resObject)
{
	global $dbName;
	
	$sql = "UPDATE `".$dbName."`.`resources` SET `title` = '".$resObject->name."',
		`link` = '".$resObject->url."',
		`author` = '".$resObject->owner."',
		`timecreated` = '".time()."',
		`rating` = '".$resObject->score."',
		`description` = '".$resObject->description."',
		`tags` = '".dcTagArrayToString($resObject->tags)."' WHERE `resources`.`id` = ".$id;

	$result = mysql_query($sql);
	
	return $result;
}

// Fjerner ressurs fra databasen
function deleteResourceByID($id)
{
	global $dbName;
	
	$sql = "DELETE FROM `".$dbName."`.`resources` WHERE `resources`.`id` = ".$id;
	
	$result = mysql_query($sql);
	
	return $result;
}

// Returnerer en array med alle tags som er i databasen. Ingen duplikater.
function getAllTags()
{
	global $dbName;
	
	$sql = "SELECT tags FROM `".$dbName."`.`resources`";
	
	$result = mysql_query($sql);
	if($result)
	{
		$tagArray = array();
		
		while($resData = mysql_fetch_row($result))
			foreach(dcTagStringToArray($resData[0]) as $tag)
				if(array_search($tag, $tagArray) === false && $tag != "")
					array_push($tagArray, $tag);
		
		$result = $tagArray;
	}
	
	return $result;
}

// -------- Følgende metoder er ikke ment for "allment" bruk --------

function connectDirectToDB($dbNameIn, $user, $pass, $host)
{
	global $dbName;
	
	$dbName = $dbNameIn;
	
	if(!($resultA = @mysql_connect($host, $user, $pass))) // Koble til MySQL-server
		throw new RuntimeException("Kunne ikke koble til database-serveren");

	if(!($resultB = @mysql_select_db($dbName))) // Velge standard database fra server
		dcCheckAndBuildDB();

	return $resultA && $resultB;
}

function dcCheckAndBuildDB()
{
	global $dbPassword;
	
	if($_POST["pass"] != $dbPassword)
		dcAskForNewDB();
	
	global $dbName;

	$sql = "CREATE DATABASE `".$dbName."`";

	$result = mysql_query($sql);

	$sql = "CREATE TABLE `".$dbName."`.`resources` (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`title` VARCHAR( 255 ) NOT NULL ,
		`link` VARCHAR( 255 ) NOT NULL ,
		`author` VARCHAR( 32 ) NOT NULL ,
		`timecreated` INT NOT NULL ,
		`rating` MEDIUMINT NOT NULL ,
		`description` TEXT NOT NULL ,
		`tags` VARCHAR( 512 ) NOT NULL
		) ENGINE = MYISAM ";
	
	$result = mysql_query($sql) && $result;
	
	return $result;
}

function dcAskForNewDB()
{
	global $dbName;
	
	echo '<div style="background-color: #F8F5F3; border: solid; padding: 4px;">
			<p>MySQL tilkoblet, men databasen mangler. Vil du opprette ny database med alle nødvendige tabeller?</p>
			<p>Databasenavn: <b>'.$dbName.'</b></p>
			<p>Tast inn passordet for å opprette ny database:</p>
			<form name="dbpass" method="post" action="..'.$_SERVER["SCRIPT_NAME"].'">
				<input type="password" name="pass" id="pass">
				<input type="submit" name="submit" id="submit" value="Opprett database">
			</form>';
	if(isset($_POST["pass"]))
		echo '			<p style="color: #FF0000;">Feil passord!</p>';
	echo '			<br />
		</div>';
}

function dcTagArrayToString($tagArray)
{
	for($i = 0; $i < count($tagArray); $i++)
		$tagArray[$i] = str_replace(";", "<?SK$>", $tagArray[$i]);	
	
	return implode(";", $tagArray);
}

function dcTagStringToArray($tagString)
{
	$tagArray = explode(";", $tagString);
	
	for($i = 0; $i < count($tagArray); $i++)
		$tagArray[$i] = str_replace("<?SK$>", ";", $tagArray[$i]);	
		
	return $tagArray;
}

?>