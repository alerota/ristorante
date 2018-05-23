<?php
include 'menu.php';
?>
<html>
<body id="body">
<div class="container py-5">
    <div class="card">
		
        <?php
        if(isset($_GET['alert'])) {
            ?>
            <br><div class="alert alert-warning">
                <strong>Warning! </strong> <?php echo $_GET['alert']; ?>
            </div>
            <?php
        }
        ?>
        <div class="card-body">
            <div class="container">
				<div class="row">
					<div class="col-md-3"><br></div>
					<div class="col-md-6">
						<h1 class="card-title text-center">Inserisci nuovo utente</h1>
						<hr>
						<form class="form-horizontal"  id="addUtente" method="post" action="codici/insertUtente.php">
							<div class="col-lg-10 col-lg-offset-0">
								<div class="form-group">
									<label for="firstName" class="col-sm-3 control-label">Username</label>
									<div class="col-sm-9">
										<input type="text" name="username" placeholder="Username" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-3 control-label">Password</label>
									<div class="col-sm-9">
										<input type="password" name="password" placeholder="Password" class="form-control">
									</div>
								</div>
								<hr>
								<button onclick="document.getElementById('addUtente').submit();" class="btn btn-primary center-block" type="button" style="width: 50%; ">
								Aggiungi
								</button>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
