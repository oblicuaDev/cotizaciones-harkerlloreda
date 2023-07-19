<?php include '../includes/config.php';
header('Content-Type: application/json');
extract($_GET);
$exp = explode(',', $optsStr);
$cOpts = count($exp);
$opts = f_get_content($exp);
$opts = $cOpts==1?[$opts]:$opts;
for ($i=0; $i < $cOpts; $i++) { 
	$opts[$i]['procedures_opt'] = unserialize($opts[$i]['procedures_opt']);
	$opts[$i]['aditionals_opt'] = unserialize($opts[$i]['aditionals_opt']);
	$opts[$i]['others_opt'] = unserialize($opts[$i]['others_opt']);
}
echo json_encode($opts); ?>