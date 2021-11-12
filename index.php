<?php 
// Start Session

session_start();

$pageTitle = 'Login';

if (isset($_SESSION['emp'])){
	header('Location: index.php');

}

// The Include 

	include "init.php";


// Check If User Comming From HTTP Post Request
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedpass = sha1($password);
		
		// Check If The User Exist In Database
		$stmt = $con->prepare("SELECT Emp_ID,UserName,GroupID, Password FROM emp WHERE UserName = ? AND Password = ? And GroupID =0  LIMIT 1");
		$stmt->execute(array($username,$hashedpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		// If Count > 0 This Mean The Database Contain Record About This UserName

		if($count > 0 ){

			
			$_SESSION['Emp'] = $username;
			$_SESSION['Emp_ID'] = $row['Emp_ID'];
			header('Location: profile.php');
			exit();
		}
	}

?>



<section class="log-in">
	<div class="fields">
			<div class="container">
			<div class="row">
			<h3 class="text-center header">Login <i class="fas fa-sign-in-alt"></i></h3>
		
	<form  role="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			
		<div class="col-md-4 offset-md-4">
			
		<div class="input-group mb-2 flex-nowrap ">

		<input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off"   />
			</div>
	
			<div class="input-group mb-2 flex-nowrap ">

			<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"  />
			
			</div>
			
			<input class="btn btn-primary  w-100" type="submit" value="login" />
					
		</div>


</form>
				</div>
				</div>
		</div>
	</section>

<?php include $tpl . 'footer.php';?>