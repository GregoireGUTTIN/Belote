<?php

function Connexion($base)
{
	// Connexion et sélection de la base
	try{
		$link = @new PDO("sqlite:".$base);
		$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch(PDOException  $e ){
		echo "Error: ".$e;
	}
	return $link;
}

function Get($link,$req)
{
	$stmt = null;
	try{
		$stmt = $link->query( $req );
	}catch(PDOException  $e ){
		echo "Error: ".$e;
	}
			
	return $stmt->fetchAll();
}

function Deconnexion($link)
{
	// Fermeture de la connexion
	$link = null;
}

function Set($link,$req)
{
	
	try{
		//echo "<br>$req<br>";
		$stmt = $link->query( $req );
	}catch(PDOException  $e ){
		echo "Error: ".$e;
	}
}


?>
