<?php 
	
	require 'includes/database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers  set name = ?, email = ?, mobile =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile,$id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$email = $data['email'];
		$mobile = $data['mobile'];
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
    
        <div class="span10 offset1">
            <div class="row">
                    <h3>Update a Customer</h3>
            </div>

            <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                  <label class="control-label">Name</label>
                  <div class="controls">
                      <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                      <?php if (!empty($nameError)): ?>
                              <span class="help-inline"><?php echo $nameError;?></span>
                      <?php endif; ?>
                  </div>
                </div>
                <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                  <label class="control-label">Email Address</label>
                  <div class="controls">
                      <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                      <?php if (!empty($emailError)): ?>
                              <span class="help-inline"><?php echo $emailError;?></span>
                      <?php endif;?>
                  </div>
                </div>
                <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                  <label class="control-label">Mobile Number</label>
                  <div class="controls">
                      <input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                      <?php if (!empty($mobileError)): ?>
                              <span class="help-inline"><?php echo $mobileError;?></span>
                      <?php endif;?>
                  </div>
                </div>
                <br><br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn btn-info" href="index.php">Back</a>
                </div>
            </form>
      </div>
				
    </div> <!-- /container -->
  </body>
</html>