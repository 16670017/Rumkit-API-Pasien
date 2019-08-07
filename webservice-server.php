<?php

 /** 
  @Description: Book Information Server Side Web Service:
  This Sctript creates a web service using NuSOAP php library. 
  fetchBookData function accepts ISBN and sends back book information.
  @Author:  http://programmerblog.net/
  @Website: http://programmerblog.net/
 */
 require_once('dbconn.php');
 require_once('lib/nusoap.php'); 
 $server = new nusoap_server();

 /* Method to isnter a new book */
function insertPasien($nama_pasien, $jk, $agama, $alamat, $tgl_lahir, $usia, $no_tlp){
  global $dbconn;
  $sql_insert = "insert into pasien (nama_pasien, jk, agama, alamat, tgl_lahir, usia, no_tlp) values ( :nama_pasien, :jk, :agama, :alamat, :tgl_lahir, :usia, :no_tlp)";
  $stmt = $dbconn->prepare($sql_insert);
  // insert a row
  $result = $stmt->execute(array(':nama_pasien'=>$nama_pasien, ':jk'=>$jk, ':agama'=>$agama, ':alamat'=>$alamat, ':tgl_lahir'=>$tgl_lahir, ':usia'=>$usia, ':no_tlp'=>$no_tlp));
  if($result) {
    return json_encode(array('status'=> 200, 'msg'=> 'success'));
  }
  else {
    return json_encode(array('status'=> 400, 'msg'=> 'fail'));
  }
  
  $dbconn = null;
  }
/* Fetch 1 book data */
function fetchBookData($nama_pasien){
	global $dbconn;
	$sql = "SELECT id, nama_pasien, jk, agama, alamat, tgl_lahir, usia, no_tlp FROM pasien
	        where nama_pasien = :nama_pasien";
  // prepare sql and bind parameters
    $stmt = $dbconn->prepare($sql);
    $stmt->bindParam(':nama_pasien', $nama_pasien);
    // insert a row
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return json_encode($data);
    $dbconn = null;
}
$server->configureWSDL('pasienServer', 'urn:pasienn');
$server->register('fetchPasienData',
			array('nama_pasien' => 'xsd:string'),  //parameter
			array('data' => 'xsd:string'),  //output
			'urn:pasienn',   //namespace
			'urn:pasienn#fetchBookData' //soapaction
      );  
      $server->register('insertPasien',
			array('nama_pasien' => 'xsd:string', 'jk' => 'xsd:string', 'agama' => 'xsd:string', 'alamat' => 'xsd:string', 'tgl_lahir' => 'xsd:string', 'usia' => 'xsd:string', 'no_tlp' => 'xsd:string'),  //parameter
			array('data' => 'xsd:string'),  //output
			'urn:book',   //namespace
			'urn:book#fetchBookData' //soapaction
			);  
$server->service(file_get_contents("php://input"));

?>