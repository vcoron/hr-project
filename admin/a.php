<?php $stmt = $con->prepare("SELECT attendance.*, emp.UserName AS Member FROM attendance 

INNER JOIN emp ON emp.Emp_ID = attendance.Emp_ID

WHERE attendance.Att_Date = ?

ORDER BY attendance.Att_ID DESC
 " );

$stmt->execute(array($action));

$rows = $stmt->fetchAll();





    ?>
    <section class="table-members">
    <div class="container">
     <h3 class="h1 text-center header" style="margin-top: 30px"> Attendance Sheet <i class="far fa-file fa-x3"></i></h3>
        <div class="table-responsive">
        <table class="table table-dark table-bordered border-light text-center main-table">
            <tr class="table-active">
            <td>User Name</td>
            <td><?php echo $action ?></td>
            <td>Statues</td>
            <td>Control</td>
            </tr>
            <?php
                
                foreach($rows as $row){
                    echo "<tr>";
                    echo "<td>" . $row['Member'] . "</td>";
                    echo "<td>" . $row['Att_Date'] . "</td>";
                    if($row['status'] == 1){
                        $stat= 'Present';
                    }else{
                        $stat ='Absent';
                    }
                    echo "<td>" . $stat . "</td>";
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

    
</div>
</section>






<?php 
