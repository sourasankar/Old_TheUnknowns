<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.php" class="navbar-brand"><span><img class="logo2" src="logo/logo.png" width="30px"></span><b> Th€ Unknow$</b></a>
			</div>
			<div class="collapse navbar-collapse" id="mynavbar">
				<ul class="nav navbar-nav navbar-right">
					<?php if (!isset($_SESSION["user"])) { ?>
					<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign up</a></li>
					<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					<?php } 
					else{ ?>
					<li><a href="logged.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["user"] ?></a></li>
					<li><a href="php/logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
				    <?php } ?>
				</ul>
			</div>
		</div>
	</nav>