<?php 
session_start();

if (isset($_SESSION['Admin'])){
	
$pageTitle = 'Dashboard';

include 'init.php';
	
$stmt = $con->prepare("SELECT attendance.*, emp.UserName AS Member , DATE_FORMAT(attendance.Att_Date, '%Y-%m-%d')  FROM attendance 

INNER JOIN emp ON emp.Emp_ID = attendance.Emp_ID

 
WHERE DATE(attendance.Att_Date) = CURDATE()

ORDER BY Att_ID DESC

													   ");

$stmt->execute();

$rows = $stmt->fetchAll();

	?>




<section class="table-members">
<h1 class="header text-center" style="margin-top: 30px"> Attendance <i class="fas fa-sliders-h"></i></h1>
				<div class="container">
					<div class="col-12">
					<div class="table-responsive">
					<table class="table table-dark table-bordered border-light text-center main-table">
						<tr class="table-active">
						
						<td>User Name</td>
						<td><?php echo $date=date("l"); ?></td>
						
						
						<td>Control</td>
						</tr>
						<?php
							
							foreach(getLatest("*", "emp") as $emp){
							
								
								echo "<tr>";
								echo "<td>" . $emp['UserName'] . "</td>";
								echo "<td>" . date("Y-m-d"). "</td>";
								echo "<td>";

								
									
								
									echo "<a href='attendance.php?do=Approve&id=" . $emp['Emp_ID']  
								."'class='btn btn-info approve btn-sm '>Present <i class='fas fa-check'></i></a>";
								
				
									echo "<a href='attendance.php?do=UnApprove&id=" . $emp['Emp_ID']  
								."'class='btn btn-secondary approve btn-sm'>Absent <i class='fas fa-times'></i></a>";
															
								echo "</td>";
								echo "</tr>";


							}
								
							
						
						
						?>
						
			
						
						</table>
					
					
					</div>

					</div>		
</div>
</section>
	
<?php
	
include $tpl . 'footer.php';
	
} else {
	header('Location: index.php');
	exit();
}
?>