<?php include '../includes/config.php';
header('Content-Type: application/json');
extract($_GET);
$proceduresIt = q_fsearch($procedure,'procedure_pprice',3,'created','downward',0,1);
$resp = ['message' => 1];
$resp['response'] = array_map(function($it){
	return [
		'rowID' => $it['rowID'],
		'price' => $it['price_pprice'],
		'name'  => $it['name_pprice']
	];
},$proceduresIt);
echo json_encode($resp); ?>