<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">HOME</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav">
       
	
		<li class="nav-item">
          <a class="nav-link" aria-current="page" href="members.php?do=Manage&userid=<?php echo $_SESSION['Admin_ID']?>"></a>
        </li>
     
 
		</ul>
		<ul class="navbar-nav ">
    <li class="nav-item">
          <a class="nav-link" aria-current="page" href="members.php?do=Manage&userid=<?php echo $_SESSION['Admin_ID']?>">MEMBERS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="attendance.php?do=Manage&userid=<?php echo $_SESSION['Admin_ID']?>">Attendance Report </a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['Admin']?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li>
			<a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['Admin_ID']?>">Edit Profile <i class="fas fa-edit"></i></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Logout <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </li>
        
      </ul>
    </div>
  </div>
</nav>