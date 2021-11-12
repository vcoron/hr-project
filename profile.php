<?php 
ob_start();
session_start();

$pageTitle='Profile';

include 'init.php'; 

if (isset($_SESSION['Emp'])){

    $getUser = $con -> prepare ("SELECT * FROM emp WHERE UserName = ?");

    $getUser -> execute(array($sessionUser));

    $info = $getUser->fetch();


    $abs= getStatus ('0' , $sessionID);
    $pres = getStatus ('1' , $sessionID);
    


?>



<section class="information block profile">
<h1 class="header text-center"><i class="fas fa-user-alt"></i> <?php echo $sessionUser ?> Profile</h1>

<div class="container">
    <div class="row">
        <div class="col-sm-12 ">
                <div class="card text-white bg-dark"  style="margin-top: 20px;" >
                   
                <div class="card-header text-center border-primary">
                    	<h5>My Information <button class="btn btn-info btn-sm float-end"><a href="logout.php" style="text-decoration: none; font-weight: bold; color: black;">Log Out</a> <i class="fas fa-sign-out-alt"></i></button> </h5>

                </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                        
                        <li>
                            <i class='fas fa-unlock-alt fa-fw'></i>
                            <span>Name</span>: <?php echo $info['UserName'] ?> 
                        </li>

                        <li>
                        <i class='fas fa-envelope fa-fw'></i>
                            <span>Email</span>: <?php echo $info['Email'] ?>
                        </li>
                        
                        <li>
                        <i class='fas fa-user fa-fw'></i>
                            <span>Full Name</span>: <?php echo $info['FullName'] ?> 
                        </li>
                        
                        <li>
                        <i class='fas fa-calendar fa-fw'></i>
                            <span>Start Work</span>: <?php echo $info['Date_Register'] ?>
                        </li>
                        <li>
                        <i class='fas fa-mobile fa-fw'></i>
                            <span>Phone Number</span>: <?php echo $info['Phone'] ?>
                        </li>
                        
                       

                        </ul>
                                                                                                                                                                     
                    </div>
            </div>
        </div>
        </div>
        </div>
</section>

<section class="information block profile">
<h1 class="header text-center"><i class="far fa-file fa-x3"></i> Attendance Sheet</h1>

<div class="container">
    <div class="row">
        <div class="col-sm-12 ">
                <div class="card text-white bg-dark"  style="margin-top: 20px; margin-bottom: 20px;" >
                   
                <div class="card-header  border-primary">
                    	<h5 class="text-center">My Attendance Sheet  </h5>
                        <i class="fas fa-user-slash"></i> <span>Total absence is</span>: <?php echo $abs ?> <aside class="float-end"><i class="fas fa-user-check"></i> </i><span>Total Present is</span>: <?php echo $pres ?></aside></li>
                </div>
                    <div class="card-body md-3">
                        <ul class="list-unstyled">
                           
                            
                        <?php
                        foreach(getAtt($sessionID) as $row){ 
                            if($row['status'] ==1){
                                $state = "Presnet";
                            }else{
                                $state = "Absent";
                            }
                            echo '<li>';
                            echo "<i class='fas fa-calendar fa-fw></i>" ."  " ;
                            echo'<span>' ." ". $row['Att_Date'] .'</span>:'." ".$state .' </li>';

                            echo '<li>';
                            echo "<i class='fas fa-calendar fa-fw></i>" ."  " ;
                            echo'<span>' ." ". $row['Att_Date'] .'</span>:'." ".$state .' </li>';

                       
                        
                        } ?>

                        </ul>
                                                                                                                                                                     
                    </div>
            </div>
        </div>
        </div>
        </div>
</section>

<?php
}else{
    header('Location:index.php');
    exit();
}
include $tpl . 'footer.php';

ob_end_flush();
?>