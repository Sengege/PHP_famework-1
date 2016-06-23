
<?php
	include ('navigation.php');
?>

<nav class="navbar navbar-default navbar-fixed-top scrolled" role="navigation">
<div class="container">
	<div class="row">

		<div class="col-lg-2 col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-2 col-xs-offset-0">
			<div class="navbar-header">
				<button aria-expanded="true" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="fa fa-bars fa-lg"></span>
				</button>
				<a  href="home.php">
					<img src="../images/Logo_v3-01.png" width="100%" />
				</a>
			</div>
		</div>

		<div class="col-lg-5 col-lg-offset-0 col-md-5 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-8 col-xs-offset-0">
			<div class="input-group" style="margin-top: 3%;filter:alpha(opacity=70);-moz-opacity:0.7;-khtml-opacity: 0.7;opacity: 0.7; ">
				<input type="text" class="form-control">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-11">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="login.php">SIGN IN</a>
					</li>
					<li>
						<a href="register.php">SIGN UP</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
</nav>