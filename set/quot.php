<?php include '../includes/config.php';
header('Content-Type: application/json');
$json = file_get_contents('php://input');
$data = json_decode($json);
$values = array();
$qOpts = count($data->opts);
if ($data->create == 1) {
	for ($i=0; $i < $qOpts; $i++) {
		$opt = $data->opts[$i];
		$values[] = $opt->name;
		$values[] = serialize($opt->procedures);
		$values[] = serialize($opt->aditionals);
		$values[] = serialize($opt->others);
		$values[] = $opt->discount;
		$values[] = $opt->total;
	}
	$optsRowIDs = reg_frontend_info(21,[218,139,140,141,165,164],'','',$values,-1,null,$qOpts)['rowID'];
	$imp = is_array($optsRowIDs)?implode(',', $optsRowIDs):$optsRowIDs;
	$quotRowID  = reg_frontend_info(34,[224,225,226,229,2269],'','',[$data->code,$imp,$data->customer,$data->avg,$data->doctor])['rowID'];
	updateCounter($data->code + 1);
	echo '{"quotId": '.$quotRowID.', "opts": "'.$imp.'"}';
}else{
	$optsRowIDs = array();
	$originalQuot = f_get_content([$data->id]);
	$originalOpts = explode(',', $originalQuot['opts_quot']);
	for ($i=0; $i < $qOpts; $i++) {
		$opt = $data->opts[$i];
		$values = array();
		$values[] = $opt->name;
		$values[] = serialize($opt->procedures);
		$values[] = serialize($opt->aditionals);
		$values[] = serialize($opt->others);
		$values[] = $opt->discount;
		$values[] = $opt->total;
		if($opt->id != ''){
			$optsRowIDs[] = $opt->id;
			edit_row([218,139,140,141,165,164],$values,'',$opt->id,'gimmeAsignal');
		}else{
			$optsRowIDs[] = reg_frontend_info(21,[218,139,140,141,165,164],'','',$values)['rowID'];
		}
	}
	$delete_array = array_slice(array_diff($originalOpts, $optsRowIDs),0);
	if (count($delete_array)) {
		delete_frontend_info($delete_array);
	}
	$imp = implode(',', $optsRowIDs);
	edit_row([224,225,226,229],[$data->code,$imp,$data->customer,$data->avg],'',$data->id,'gimmeAsignal');
	echo '{"message": 1,"quotId": '.$data->id.'}';
} ?>