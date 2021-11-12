<?php
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

/*
** Home Redirect Function v2.0
** This Function Accept Parameters
** $theMsg = Echo The Message [Error | success | Warning]
** $url = Tle Linnk You Want To Redirect To
** $seconds = Seconds Before Redirecting
*/

function redirectHome($theMsg,$url=null, $seconds=.5){
	
	if($url ===null){
		$url='index.php';
		
		$link = 'Home Page';
	}else {
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ){
			
			$url= $_SERVER['HTTP_REFERER'];
			
			$link = 'Previous Page';
		
		}else{
			$url='index.php';
			$link = 'Home Page';
		}
	}
	
	echo $theMsg ;
	
	echo "<div class='alert alert-info m-2'>You Will Be Redirected To $link After " . $seconds . " seconds</div>";
	
	header("refresh:$seconds;url=$url");
}
/*
** Check Items Function v1.0 
** Function To Check Item In Database[Function Accept Parameters]
** $select = The Ittem To Select [ Examble: user, item, categories ]
** $from = The Table To Select From [ Examble: user, item, categories ]
** $value = The Value Of Select [ Examble: Anas, Iphon6s Plus, Phones ]
*/

function checkItem($select,$from,$value){
	global $con;
	
	$statement = $con->prepare("SELECT $select FROM $from WHERE $select =?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}

function checkAtt($value){
	global $con;
	
	$statement = $con->prepare("SELECT Emp_ID FROM attendance WHERE Att_Date = CURDATE() AND Emp_ID =? ");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}

function checkA($value){
	global $con;
	
	$statement = $con->prepare("SELECT Att_ID FROM attendance WHERE Att_ID =? ");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count;
}

/*
** Get Latest Records Function v1.0 
** Function To Get Latest Records Items From Database
** $select = Field To Select
** $table = The Table To Select From
** $order = The Ordering
*/

function getLatest($select, $table){
	global $con;
	
	$stmt2 = $con->prepare("SELECT $select FROM $table WHERE GroupID = 0 ");
	$stmt2->execute();
	$rows =$stmt2->fetchAll();
	return $rows;
}















?>













