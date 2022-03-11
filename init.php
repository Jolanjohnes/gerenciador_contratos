<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */date_default_timezone_set('America/Sao_Paulo');

class conexao {
    
    
    function getConection(){
		$servername = "localhost";
		$username = "root";
		$password = "";

		try {
		    $conn = new PDO("mysql:host=$servername;dbname=contratosacqua", $username, $password);
		    // set the PDO error mode to exception
		   return $conn;
		}
		catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		}
	}
}