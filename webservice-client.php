<?php

	/*  
	  ini_set('display_errors', true);
	  error_reporting(E_ALL); 
	 */
  
	require_once('lib/nusoap.php');
	$error  = '';
	$result = array();
	$response = '';
	$wsdl = "http://localhost/webservice/webservice-server.php?wsdl";
	if(isset($_POST['sub'])){
		$nama_pasien = trim($_POST['nama_pasien']);
		if(!$nama_pasien){
			$error = 'Nama Pasien cannot be left blank.';
		}

		if(!$error){
			//create client object
			$client = new nusoap_client($wsdl, true);
			$err = $client->getError();
			if ($err) {
				echo '<h2>Constructor error</h2>' . $err;
				// At this point, you know the call that follows will fail
			    exit();
			}
			 try {
				$result = $client->call('fetchBookData', array($nama_pasien));
				$result = json_decode($result);
			  }catch (Exception $e) {
			    echo 'Caught exception: ',  $e->getMessage(), "\n";
			 }
		}
	}	

	/* Add new book **/
	if(isset($_POST['addbtn'])){
		$nama_pasien = trim($_POST['nama_pasien']);
		$jk = trim($_POST['jk']);
		$agama = trim($_POST['agama']);
		$alamat = trim($_POST['alamat']);
		$tgl_lahir = trim($_POST['tgl_lahir']);
		$usia = trim($_POST['usia']);
		$no_tlp = trim($_POST['no_tlp']);

		//Perform all required validations here
		if(!$nama_pasien || !$jk || !$agama || !$alamat || !$tgl_lahir || !$usia || !$no_tlp){
			$error = 'All fields are required.';
		}

		if(!$error){
			//create client object
			$client = new nusoap_client($wsdl, true);
			$err = $client->getError();
			if ($err) {
				echo '<h2>Constructor error</h2>' . $err;
				// At this point, you know the call that follows will fail
			    exit();
			}
			 try {
				/** Call insert book method */
				 $response =  $client->call('insertBook', array($nama_pasien, $jk, $agama, $alamat, $tgl_lahir, $usia , $no_tlp));
				 $response = json_decode($response);
			  }catch (Exception $e) {
			    echo 'Caught exception: ',  $e->getMessage(), "\n";
			 }
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RUMKIT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Data Pasien Rumah Sakit</h2>
  <p>Masukan <strong>Nama Pasien</strong> dan click <strong>Pencarian Informasi</strong></p>
  <br />       
  <div class='row'>
  	<form class="form-inline" method = 'post' name='form1'>
  		<?php if($error) { ?> 
	    	<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp;<?php echo $error; ?> 
	        </div>
		<?php } ?>
	    <div class="form-group">
	      <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Enter Nama Pasien" required>
	    </div>
	    <button type="submit" name='sub' class="btn btn-default">Pencarian Informasi Pasien</button>
    </form>
   </div>
   <br />
  <?php
 				echo "<pre>";
                    print_r($result);
                echo "</pre>";
   ?>
	<div class='row'>
	<h2>Tambah Pasien</h2>
	 <?php if(isset($response->status)) {

	  if($response->status == 200){ ?>
		<div class="alert alert-success fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Success!</strong>&nbsp; Tambah pasien succesfully. 
	        </div>
	  <?php }elseif(isset($response) && $response->status != 200) { ?>
			<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp; Cannot Add a pasien. Please try again. 
	        </div>
	 <?php } 
	 }
	 ?>
  	<form class="form-inline" method = 'post' name='form1'>
  		<?php if($error) { ?> 
	    	<div class="alert alert-danger fade in">
    			<a href="#" class="close" data-dismiss="alert">&times;</a>
    			<strong>Error!</strong>&nbsp;<?php echo $error; ?> 
	        </div>
		<?php } ?>
	    <div class="form-group">
	      <label for="email"></label>
	      <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Enter nama_pasien" required>
				<input type="text" class="form-control" name="jk" id="jk" placeholder="Enter jk" required>
				<input type="text" class="form-control" name="agama" id="agama" placeholder="Enter agama" required>
				<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Enter alamat" required>
				<input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Enter tgl_lahir" required>
				<input type="text" class="form-control" name="usia" id="usia" placeholder="Enter usia" required>
				<input type="text" class="form-control" name="no_tlp" id="no_tlp" placeholder="Enter no_tlp" required>
	    </div>
	    <button type="submit" name='addbtn' class="btn btn-default">Tambah Pasien</button>
    </form>
   </div>
</div>

</body>
</html>



