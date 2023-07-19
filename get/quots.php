<?php include '../includes/config.php';
header('Content-Type: application/json');
$resp = [
	'message' => 1,
	'list' => array()
];
extract($_GET);



if ((!isset($s) || $s == '') && (!isset($doctor) || $doctor == 0) && (!isset($datefrom) || $datefrom == '') && (!isset($dateto) || $dateto == '') ) { //Búsqueda general
	$quots = f_content_list(34,'created','downward',25,$page);
}else{
    
    
    if(isset($s) || $s!=''){ //Search Bar
        $customers = q_fsearch(go_utf8($s),'main_val_client',1,'created','downward',0,1);
    //echo count($costumers);
        $quots = array();
        if (!isset($customer['message'])) {
            $customersRowIDS = array_column($customers, 'rowID');
            $db = new Database(1);
            $from = ($page-1)*25;
            $limit = "LIMIT ".$from.",25";
            $sqlComplement = "ORDER BY q_rows.fec_crea DESC $limit";
            $sql = "SELECT cod_reg FROM `q_fields` INNER JOIN q_values ON cod_fie = fie_val INNER JOIN q_rows ON reg_val = cod_reg AND `q_fields`.reg_eli = 0 AND q_values.reg_eli = 0 AND q_rows.reg_eli = 0 AND id_fie = 'client_quot' AND q_values.val_val IN(".implode(',', $customersRowIDS).") GROUP BY reg_val ";
            $replace = "SELECT COUNT(*) FROM `q_fields` INNER JOIN q_values ON cod_fie = fie_val INNER JOIN q_rows ON reg_val = cod_reg AND `q_fields`.reg_eli = 0 AND q_values.reg_eli = 0 AND q_rows.reg_eli = 0 AND id_fie = 'client_quot' AND q_values.val_val IN(".implode(',', $customersRowIDS).") ";
            $db->query($sql.$sqlComplement);
            $row_ids = generate_rowids_array($db);
            $orekaRows = general_content($row_ids,array("count","($replace)"),'fec_crea','DESC');
            $quanRows = count($orekaRows);
            if($quanRows){
                $quots = $orekaRows;
            }
        }else{
            $customers = array();
        }
    }
    if($doctor>0 /*&& $datefrom=='' && $dateto==''*/) //Doctor Search
    {
       $quots = q_fsearch($doctor,'doctor_quot',3,'created','downward',25,$page);
    }
    if($doctor==0 && ($datefrom!='' || $dateto!='')) //Date search
    {
       $quots = q_search("34","10",$datefrom,$dateto,0,"created","downward",25,$page);
    }
    /*if($doctor>0 && ($datefrom!='' || $dateto!='')) //Doctor and Date search
    {
        $quots = q_fsearch($doctor,'doctor_quot',3,'created','downward',25,$page);
    }*/
    if($idquot!="") //Quote ID search
    {
    //    $quots = q_fsearch($idquot,'code_quot',1,'created','downward',25,$page);
    //    var_dump('searching for id quot');
    }
    

}
$quots = isset($quots['message'])?array():$quots;
if (!isset($customers)) {
	$customersRowIDS = array_column($quots, 'client_quot');
	$customers = f_get_content($customersRowIDS);
	$customers = isset($customers['message'])?array():(isset($customers[0])?$customers:[$customers]);
}

//print_r($quots);
/*$cQuots = count($quots);
if(isset($doctor) && $doctor>0)
{
    for($i=0;$i<$cQuots;$i++)
    {
        if($doctor != $quots[$i]['doctor_quot'])
        {
            unset($quots[$i]);
        }
    }
    $quots = array_values($quots);
}*/
$total = $quots[0]['totalRows'];
$cQuots = count($quots);
if($doctor>0 && $datefrom!="")
{
    //echo "From ".$from;
    $date = date($datefrom);
    for($i=0;$i<$cQuots;$i++)
    {
        $qdate = date($quots[$i]['creation_date']);
        if($date > $quots[$i]['creation_date'])
        {
            unset($quots[$i]);
            //$quots[0]['totalRows']--;
        }
    }
    $quots = array_values($quots);
}
$cQuots = count($quots);
 

if($doctor>0 && $dateto!="")
{
    //echo "To ".$to."<br>";
    $date = date($dateto);
    for($i=0;$i<$cQuots;$i++)
    {
       // echo $quots[$i]['creation_date']."<br>";
        $qdate = date($quots[$i]['creation_date']);
        if($date < $qdate)
        {
            //echo "retiro";
            unset($quots[$i]);
            //$quots[0]['totalRows']--;
        }
    }
    $quots = array_values($quots);
}
$cQuots = count($quots);

$customersRowIDS = array_column($customers, 'rowID');
$customerTemplate = [
	'rowID' => -1,
	'name_client' => 'No',
	'last_name_client' => 'seleccionado'
];
for ($i=0; $i < $cQuots; $i++) {
	$quot = $quots[$i];
	$index = array_search($quot['client_quot'], $customersRowIDS);
	$customer = $index === false?$customerTemplate:$customers[$index];
	$names = explode(' ', $customer['name_client']);
	$lnames = explode(' ', $customer['last_name_client']);
	$expOpts = $quot['opts_quot'] == ''?array():explode(',', $quot['opts_quot']);
	$quan = count($expOpts);
	$avg = $quot['avg_quot'];
	$rowID = $quot['rowID'];
	$date = new DateTime($quot['creation_date']);
	array_push($resp['list'], [
		'rowID' => $rowID,
		'code' => $quot['code_quot'],
		'customer' => $names[0].' '.$lnames[0],
		'customerId' => $customer['rowID'],
		'creation_date' => $date->format('Y-m-d'),
		'opts' => $quan,
		'avg' => $avg
	]);
}

//$total = 0;
$quanPages = 0;
$pages = array();


    //$total = $quots[0]['totalRows'];
if($total>0){
    $divisor = 25;
	$quanPages = ceil($total/$divisor);
}else{
	$resp['message'] = 0;
}
/*if($cQuots){

      $total = $quots[0]['totalRows'];  

    $divisor = 25;

	$quanPages = ceil($total/$divisor);
}else{
	$resp['message'] = 0;
}*/
if ($total) {
	if ($quanPages > 10) {
		if ($page < 4) {
			$pages = get_pager_array($quanPages,$page,5,3);
			array_push($pages, '...', $quanPages);
		}elseif ($page > 3 && $page < ($quanPages - 4)) {
			$pages = get_pager_array($quanPages,$page,5,2);
			array_unshift($pages, 1, '...');
			array_push($pages, '...', $quanPages);
		}else{
			$pages = get_pager_array($quanPages,$page,5,0);
			array_unshift($pages, 1, '...');
		}
	}else{
		$pages = get_pager_array($quanPages,$page,5,3);
	}
}
$resp['pages'] = $pages;
$resp['lastPage'] = $quanPages;
$resp['total'] = $total;

echo json_encode($resp); ?>