<?php
	/***************************************************************************************************
    *                                      CONEXÃO COM O BANDO                                         *     
    ***************************************************************************************************/
	try{
        $pdo = new PDO ("mysql:dbname=mark1;host=localhost","root","");        
    } 
    catch(PDOException $e){
        echo "Erro com o banco de dados: ".$e->getMessege();
    }
    catch(Exception $e){
        echo "Erro generico: ".$e->getMessege(); 
    }	
?>