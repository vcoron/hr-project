<?php
ob_start(); // Output Buffering Start

session_start();

$pageTitle = '';

if (isset($_SESSION['Admin'])){
	
    include 'init.php';
    
        $do = isset($_GET['do']) ? $do = $_GET['do'] : 'Manage';


        if ($do == 'Manage'){
               ?>
           <div class="content">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title text-center header" style="margin-top: 20px;"><i class="fa fa-search"></i> Search Attendance Report By Date</h3>
						</div>
						<form id="form1" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" accept-charset="utf-8">
							<div class="box-body">						
								<div class="row">
									<div class="col-md-4 offset-4">
										<div class="form-group">
											<small class="req"> *</small>
											<label for="attendanceDate" class="h5 text-center">Attendance Date</label>
                                            <input type="date" name="attendanceDate" class="form-control mb-2" placeholder="yyyy-mm-dd" autocomplete="off">											
										</div>
                                        <div class="box-footer">
                                        <input type="submit" value="Search" class="btn btn-primary btn-md w-100 mb-2">
							</div>
									</div> 										
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
			<div class="row">	

								
<?php 


if (isset($_SERVER['REQUEST_METHOD']) == 'POST' ){





if (!empty($_POST['attendanceDate'])){
    $stmt = $con->prepare("SELECT attendance.*, emp.UserName AS Member FROM attendance 

    INNER JOIN emp ON emp.Emp_ID = attendance.Emp_ID
    
    WHERE attendance.Att_Date = ?
    
    ORDER BY attendance.Att_ID DESC
     " );
    
    $stmt->execute(array($_POST['attendanceDate']));
    
    $rows = $stmt->fetchAll();


    ?>
    <section class="table-members">
    <div class="container">
     <h3 class="h1 text-center header" style="margin-top: 30px"> Attendance Sheet <i class="far fa-file fa-x3"></i></h3>
        <div class="table-responsive">
        <table class="table table-dark table-bordered border-light text-center main-table">
            <tr class="table-active">
            <td>User Name</td>
            <td><?php if ($_POST['attendanceDate']){
                echo $_POST['attendanceDate'];}
                else{
                    echo "Date";
                } ?></td>
            <td>Control</td>
            </tr>
            <?php
                
                foreach($rows as $row){
                    echo "<tr>";
                    echo "<td>" . $row['Member'] . "</td>";
                    if($row['status'] == 1){
                        $stat= 'Present';
                    }else{
                        $stat ='Absent';
                    }
                    echo "<td>" . $stat . "</td>";
                    echo "<td>
                    
                     <a href='attendance.php?do=Edit&id=" . $row['Att_ID']  
                    ."'class='btn btn-info approve btn-sm '>Present <i class='fas fa-check'></i></a>";
                    
    
                        echo "<a href='attendance.php?do=Unedit&id=" . $row['Att_ID']  
                    ."'class='btn btn-secondary approve btn-sm'>Absent <i class='fas fa-times'></i></a>";
                        
                    echo "</td>";
                    echo "</tr>";
                    
                }
            
            
            ?>
            

            
            </table>
			</div>					
	</div>	                                
</div>
        
        </div>

    
</div>
</section>



            


<?php 
}}else{
    echo '<div class="alert alert-danger">error</div>';
}		
}elseif ($do == 'Edit'){
    
    echo '<h3 class="text-center h1">Present User <i class="fas fa-check"></i></h3>';
    echo '<div class="container">';
// Check If Get Request Item_ID Numeric & Integer Value Of It
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);

    
// Select All Data Depend On This ID


$check=checkA($id); 
if ($check > 0){ 
    $stmt = $con->prepare("UPDATE attendance SET status =1 WHERE Att_ID = ?");
        
        $stmt->execute(array($id));
        
        $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Presnt</div>';
        
        redirectHome($theMsg ,'back');

}
    
     } else{
    $theMsg= "<div class 'alert alert-danger'>This ID Is Not Exist</div>";
    redirectHome($theMsg);
    
}
    echo '</div>';


}elseif ($do == 'Unedit'){
    echo '<h3 class="text-center h1">Absent User <i class="fas fa-check"></i></h3>';
    echo '<div class="container">';
// Check If Get Request Item_ID Numeric & Integer Value Of It
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);

    
// Select All Data Depend On This ID


$check=checkA($id); 
if ($check > 0){ 
    $stmt = $con->prepare("UPDATE attendance SET status = 0 WHERE Att_ID = ?");
        
        $stmt->execute(array($id));
        
        $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Absent</div>';
        
        redirectHome($theMsg ,'back');

}
    
     } else{
    $theMsg= "<div class 'alert alert-danger'>This ID Is Not Exist</div>";
    redirectHome($theMsg);
    
}
    echo '</div>';
    


        }elseif ($do == 'Approve'){
           
            echo '<h3 class="text-center h1">Present User <i class="fas fa-check"></i></h3>';
				echo '<div class="container">';
			// Check If Get Request Item_ID Numeric & Integer Value Of It
            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $id = intval($_GET['id']);
            
				
            // Select All Data Depend On This ID
           

            $check=checkAtt($id); 
            if ($check > 0){ 
                $stmt = $con->prepare("UPDATE attendance SET status =1 WHERE Emp_ID = ? AND Att_Date = CURDATE()");
					
					$stmt->execute(array($id));
					
					$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Presnt</div>';
					
					redirectHome($theMsg ,'back');

            }elseif(checkItem('Emp_ID','emp',$id) ){

                $stmt = $con->prepare("INSERT INTO
                attendance (Att_Date , status , Emp_ID )
                VALUES( now() , 1 , :zemp ) WHERE ");

                    $stmt->execute(array(
                    'zemp' => $id
                   
                    ));


                
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Present</div>';
                
                redirectHome($theMsg ,'back');}
                
                 } else{
                $theMsg= "<div class 'alert alert-danger'>This ID Is Not Exist</div>";
                redirectHome($theMsg);
                
            }
                echo '</div>';



        }elseif ($do == 'UnApprove'){
           
            echo '<h3 class="text-center h1">Absent User <i class="fas fa-check"></i></h3>';
				echo '<div class="container">';
			// Check If Get Request Item_ID Numeric & Integer Value Of It
            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $id = intval($_GET['id']);
            
				
            // Select All Data Depend On This ID
           

            $check=checkAtt($id); 
            if ($check > 0){ 
                $stmt = $con->prepare("UPDATE attendance SET status =0 WHERE Emp_ID = ? AND Att_Date = CURDATE()");
					
					$stmt->execute(array($id));
					
					$theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Absent</div>';
					
					redirectHome($theMsg ,'back');

            }elseif(checkItem('Emp_ID','emp',$id) >0){
                $stmt = $con->prepare("INSERT INTO
                attendance (Att_Date , status , Emp_ID )
                VALUES( now() , 0 , :zemp )");

                    $stmt->execute(array(
                    'zemp' => $id
                   
                    ));


                
                $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' The User Is Absent</div>';
                
                redirectHome($theMsg ,'back');}
                
                 } else{
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
ob_end_flush(); // Release The Output

?>