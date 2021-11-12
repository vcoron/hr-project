<?php
session_start();
$pageTitle = 'Members';

if (isset($_SESSION['Admin'])){
	
include 'init.php';

	$do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';
	
		//Start Manage Page
	
		if ($do == 'Manage'){// Manage Members Page 
			
			
			
			
		
			$stmt = $con->prepare("SELECT * FROM emp WHERE GroupID != 1  ORDER BY Emp_ID DESC" );
			
			$stmt->execute();
			
			$rows = $stmt->fetchAll();





				?>
				<section class="table-members">
				<div class="container">
				 <h3 class="h1 text-center header" style="margin-top: 30px"> Manage Members <i class="fas fa-users-cog fa-x3"></i></h3>
					<div class="table-responsive">
					<table class="table table-dark table-bordered border-light text-center main-table">
						<tr class="table-active">
						<td>ID</td>
						<td>User Name</td>
						<td>Email</td>
						<td>Full Name</td>
						<td>Phone</td>
						<td>Registerd Date</td>
						<td>Control</td>
						</tr>
						<?php
							
							foreach($rows as $row){
								echo "<tr>";
								echo "<td>" . $row['Emp_ID'] . "</td>";
								echo "<td>" . $row['UserName'] . "</td>";
								echo "<td>" . $row['Email'] . "</td>";
								echo "<td>" . $row['FullName'] . "</td>";
								echo "<td>" . $row['Phone'] . "</td>";
								echo "<td>" . $row['Date_Register'] . "</td>";
								echo "<td>
								<a href='members.php?do=Edit&userid=" . $row['Emp_ID']  
									."'class='btn btn-outline-success btn-sm'>Edit <i class='fas fa-edit'></i></a>
									
								<a href='members.php?do=Delete&userid=" . $row['Emp_ID']  
								."'class='btn btn-outline-danger btn-sm del confirm'>Delete <i class='fas fa-trash'></i></a>";								
								echo "</td>";
								echo "</tr>";
								
							}
						
						
						?>
						
			
						
						</table>
					
					
					</div>

					<a href="members.php?do=Add" class="btn btn-primary">New Member <i class="fas fa-plus"></i></a>

</div>
</section>


			
	
		
		
		<?php }
		elseif($do == 'Add'){ ?>
			
	<section class="edit-profile">
			<div class="fields">
			<div class="container">
			<div class="row">
				
				<h3 class="text-center h1 header">Add Members <i class="fas fa-plus-square"></i></h3>

				
				<form role="form" action="?do=Insert" method="POST">
					
				<div class="col-md-6 offset-md-3">

				<div class="input-group mb-2 flex-nowrap ">
				<input type="text" name="username" class="form-control" placeholder="User Name" autocomplete="off" required="required" >
				</div>
				<div class="input-group mb-2 ">

					<input type="password" name="password" class="password form-control" placeholder="Password" autocomplete="new-password"  >
					
					<button class="btn btn-outline-secondary hv show-pasword" id="show-pasword" type="button" ><i class="fas fa-eye fa-1x"></i>
					</button>

					
				</div>

				<div class="input-group mb-2 flex-nowrap">
				<input type="email" name="email" class="form-control"  placeholder="Email" required='required'>
				</div>
				<div class="input-group mb-2 flex-nowrap">
				<input type="text" name="full" class="form-control"  placeholder="Full Name" required='required'>
				</div>
				<div class="input-group mb-2 flex-nowrap">
				<input type="text" name="phone" class="form-control"  placeholder="Phone Number" required='required'>
				</div>

				<div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect02">validity</label>
                        <select class="form-select" id="inputGroupSelect02" name="validity">
                            <option  selected>Choose...</option>
                         
						   	<option value='0'>Normal User</option>;
						   	<option value='1'>Admin</option>;
  
						   </select>
                        </div>
				<input type="submit" value="Save" class="btn btn-primary btn-lg w-100">
				</div>
					
				</form>
				</div>
				</div>
				</div>
				</section>
			
		<?php
		}
	
			elseif($do == 'Insert'){
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					echo '<h3 class="text-center header">Add Members <i class="fas fa-edit"></i></h3>';
					echo '<div class="container">';
					
					$user = $_POST['username'];
					$pass = $_POST['password'];
					$email = $_POST['email'];
					$name = $_POST['full'];
					$phone = $_POST['phone'];
					$validity = $_POST['validity'];
										
					$hashPass =sha1($_POST['password']);
					
					
					$check =checkItem('UserName' ,'emp',$user);
					
					//Validate The Form
					$formErrors = array();
					
					
					if ($check > 0){
						
						$formErrors[] = 'This Name Already <strong>Exists</strong>';
					}
					
					if (strlen($user) < 4){
						
						$formErrors[] = 'User Name Cant Be Less Than 4 <strong>Characters</strong>';
					}
					if (strlen($user) > 15){
						
						$formErrors[] = 'User Name Cant Be More Than 15 <strong>Characters</strong>';
					}
					
					if (empty($user)){
						
						$formErrors[] = 'User Name Cant Be <strong>Empty</strong>';
					}
					if (empty($pass)){
						
						$formErrors[] = 'Password Name Cant Be <strong>Empty</strong>';
					}
										
					if (empty($email)){
						
						$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
					}
										
					if (empty($name)){
						
						$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
					}
					if (empty($phone)){
						
						$formErrors[] = 'Phone Number Cant Be <strong>Empty</strong>';
					}
										
					
					foreach($formErrors as $Error){
						$theMsg= '<div class="alert alert-danger">' . $Error . '</div>';
						redirectHome($theMsg ,'back');

					}
					
					
					if(empty($formErrors)){

						$check = checkItem("UserName" , 'emp' , $user);
					
						if($check == 1){
							echo '<div class="container">';
					

							$theMsg = '<div class="alert alert-danger m-2">Sorry This User Is Exist </div>';
							redirectHome($theMsg , 'back');
							echo '</div>';
						}else{
					//Insert The DataBase With This Info
					$stmt = $con->prepare("INSERT INTO
											emp (UserName ,Password ,Email ,FullName ,Phone ,Date_Register,GroupID )
											VALUES(:zuser, :zpass, :zmail, :zname, :zphone , now() ,:zgroup )");
					$stmt->execute(array(
						'zuser' => $user,
						'zpass' => $hashPass,
						'zmail' => $email,
						'zname' => $name,
						'zphone' =>$phone,
						':zgroup' =>$validity
						));
					
					//Echo Success Message
					
					$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
					redirectHome($theMsg ,'back');
						
					}}
				}else{
				
				echo '<div class="container">';
					

					$theMsg = '<div class="alert alert-danger m-2">Sorry You Cant Browse This Page</div>';
					redirectHome($theMsg);
					echo '</div>';
				}

				echo '</div>';
			}
	
	
							 
				elseif($do == 'Edit'){ // Edit Page
				// Check If Get Request UserId Numeric & Integer Value Of It
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				
				// Select All Data Depend On This ID
				$stmt = $con->prepare("SELECT * FROM emp WHERE Emp_ID = ? LIMIT 1");
				
				// Execute Query
				$stmt->execute(array($userid));
				
				// Fetch The Data
				$row = $stmt->fetch();
				
				// The Row Count
				$count = $stmt->rowCount();

				if ($stmt->rowCount() > 0){ ?>

			<section class="edit-profile">
			<div class="fields">
			<div class="container">
			<div class="row">
				
				<h3 class="text-center h1 header">Edit Members <i class="fas fa-edit"></i></h3>

				
				<form role="form" action="?do=Update" method="POST">
					
				<input type="hidden" name="userid" value="<?php echo $userid; ?>" >
				<div class="col-md-6 offset-md-3">

				<div class="input-group mb-2 flex-nowrap ">
				<input type="text" name="username" class="form-control" placeholder="User Name" value="<?php echo $row['UserName'];?>" autocomplete="off" required="required" >
				</div>
				<div class="input-group mb-2 flex-nowrap">
				<input type="hidden" name="oldpassword" value="<?php echo $row['Password'];?>" >
					
					
				<input type="password" name="newpassword" class="pass form-control" placeholder="Password" autocomplete="new-password" >
						<button class="btn btn-outline-secondary hv show-pasword" id="show-pasword2" type="button"><i class="fas fa-eye fa-1x"></i>
					</button>

				</div>
				<div class="input-group mb-2 flex-nowrap">
				<input type="email" name="email" class="form-control" value="<?php echo $row['Email'];?>" placeholder="Email" required='required'>
				</div>
				<div class="input-group mb-2 flex-nowrap">
				<input type="text" name="full" class="form-control" value="<?php echo $row['FullName'];?>" placeholder="Full Name" required='required'>
				</div>
				<div class="input-group mb-2 flex-nowrap">
				<input type="text" name="phone" class="form-control" value="<?php echo $row['Phone'];?>"  placeholder="Phone Number" required='required'>
				</div>

				<div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect02">validity</label>
                        <select class="form-select" id="inputGroupSelect02" name="validity">
                            
						   	<option value='0' >Normal User</option>;
						   	<option value='1' chacked>Admin</option>;
  
						   </select>
                        </div>
				<input type="submit" value="Save" class="btn btn-primary btn-lg w-100">
				</div>
				</form>
				</div>
				</div>
				</div>
				</section>

<?php 
	
				} else {
					$theMsg= '<div class="alert alert-danger">Theres No Such ID</div>';
					redirectHome($theMsg ,'back');

				}
			
			} elseif($do == 'Update') { //Update Page
			
				echo '<h3 class="text-center h1">Edit Members <i class="fas fa-edit"></i></h3>';
				echo '<div class="container">';
				
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					
					$id = $_POST['userid'];
					$user = $_POST['username'];
					$email = $_POST['email'];
					$name = $_POST['full'];
					$phone = $_POST['phone'];
					$validity = $_POST['validity'];
					
					$pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : sha1($_POST['newpassword']);
					
					
						
					$check =checkItem('UserName' ,'emp',$user);
					
					//Validate The Form
					$formErrors = array();
					
					
					
					if (strlen($user) < 4){
						
						$formErrors[] = 'User Name Cant Be Less Than 4 <strong>Characters</strong>';
					}
					if (strlen($user) > 15){
						
						$formErrors[] = 'User Name Cant Be More Than 15 <strong>Characters</strong>';
					}
					
					if (empty($user)){
						
						$formErrors[] = 'User Name Cant Be <strong>Empty</strong>';
					}
										
					if (empty($email)){
						
						$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
					}
										
					if (empty($name)){
						
						$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
					}
										
					
					foreach($formErrors as $Error){
						$theMsg= '<div class="alert alert-danger">' . $Error . '</div>';
						redirectHome($theMsg ,'back');

					}
					
					if(empty($formErrors)){

						$stmt2 = $con->prepare("SELECT * FROM emp WHERE UserName = ? AND Emp_ID != ?");
						$stmt2->execute(array($user,$id));
						$count = $stmt2->rowCount();
						if($count == 1) {
							$theMsg= '<div class="alert alert-danger"> This Name Already <strong>Exists</strong></div>';
							redirectHome($theMsg ,'back');

						}else{

						

					
					//Update The DataBase With This Info
					$stmt = $con->prepare("UPDATE emp SET UserName = ?,Email = ?,FullName = ?,Password = ? ,Phone =? , GroupID =? WHERE Emp_ID = ?");
					$stmt->execute(array($user, $email, $name, $pass,$phone,$validity, $id));
					
					//Echo Success Message
					
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
					redirectHome($theMsg ,'back');
					}}
				}else{
					$theMsg= '<div class="alert alert-danger">Sorry You Cant Browse This Page </div>';
					redirectHome($theMsg ,'back');

				}

				echo '</div>';
				
				
				}elseif($do == 'Delete'){
					 
				echo '<h3 class="text-center h1">Delete Members <i class="fas fa-edit"></i></h3>';
				echo '<div class="container">';
					
			
				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
				
				// Select All Data Depend On This ID
				$check =checkItem('Emp_ID' ,'emp',$userid);


				if ($check > 0){ 

					$stmt = $con->prepare("DELETE FROM emp WHERE Emp_ID = :zuser");
					$stmt->bindParam(":zuser", $userid);
					$stmt->execute();
					$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg ,'back');
					
				}else{
					$theMsg= "<div class 'alert alert-danger'>This ID Is Not Exist</div>";
					redirectHome($theMsg ,'back');
					
				}
	
					echo '</div>';
				
					
					
				}elseif ($do == 'Approve'){
					echo '<h3 class="text-center h1">Present User <i class="fas fa-check"></i></h3>';
						echo '<div class="container">';
					// Check If Get Request Item_ID Numeric & Integer Value Of It
					$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
						
					// Select All Data Depend On This ID
					$check =checkItem('Emp_ID' ,'emp',$id);
		
		
					if ($check > 0){ 
		
						$stmt = $con->prepare("UPDATE emp SET status = 1 , Att_Date=now() WHERE Emp_ID= ?");
						
						$stmt->execute(array($id));
						
						$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Absent</div>';
						
						redirectHome($theMsg ,'back');
						
					}else{
						$theMsg= "<div class 'alert alert-danger'>This ID Is Not Exist</div>";
						redirectHome($theMsg);
						
					}
						echo '</div>';
		
		
		
				}elseif ($do == 'UnApprove'){
					echo '<h3 class="text-center h1">Absent User <i class="fas fa-check"></i></h3>';
						echo '<div class="container">';
							
						// Check If Get Request Item_ID Numeric & Integer Value Of It
						$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
						
						// Select All Data Depend On This ID
						$check =checkItem('Emp_ID' ,'emp',$id);
		
		
						if ($check > 0){ 
		
							$stmt = $con->prepare("UPDATE emp SET status =0, Att_Date= null WHERE Emp_ID = ?");
							
							$stmt->execute(array($id));
							
							$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Absent</div>';
							
							redirectHome($theMsg ,'back');
							
						}else{
							$theMsg= "<div class 'alert alert-danger'>This ID Is Not Exist</div>";
							redirectHome($theMsg);
							
						}
							echo '</div>';
					}

include $tpl . 'footer.php';
	
} else {
	header('Location: index.php');
	exit();
}
?>
