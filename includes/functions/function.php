<?php
 

/*
** Get Records Function v2.0 
** Function To Get Attendance From Database

*/

function getAtt($value){
	global $con;
	$getAtt = $con->prepare("SELECT * FROM attendance WHERE Emp_ID = ? ORDER BY Att_Date DESC ");
	$getAtt->execute(array($value));
	$Item =$getAtt->fetchAll();
	return $Item;
}

function getStatus ($value , $id){
	global $con;
	$absent = $con -> prepare ("SELECT * FROM attendance WHERE status = $value And Emp_ID = $id");

	$absent -> execute(array($value , $id));

	$abs = $absent->rowCount();
	return $abs;

}


 /*
 ** Title Function v1.0
 ** Title Function That Echo The Page Title In Case The Page
 ** Has The Variable $pageTitle And Echo Defult Title For Other Page
 */
function getTitle(){
	global $pageTitle;
	
	if(isset($pageTitle)){
		echo $pageTitle;
	}else{
		echo 'Default';
	}
}

































?>













