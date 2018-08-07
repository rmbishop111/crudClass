<?php

class Customer extends Database {
    
    function getAllCustomers() {
        
        $data = array();
        $pdo = Database::connect();
        $sql = "SELECT * FROM customers ORDER BY id DESC";
        foreach ($pdo->query($sql) as $row) {

            array_push($data, $row);
        }
        return $data;

    }
    
    function display_Record(){
        
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
                return $data;
                echo $data['name'];
		Database::disconnect();
	}
        
    }
    
}

