<?php include '../includes/config.php';
ignore_user_abort(true);
set_time_limit(0);

ob_start();

header('Content-Type: application/json');
$customer = f_get_content([$_POST['customer']]);
$quot = f_get_content([$_POST['quot']]);
$name = explode(' ',$customer['name_client']);
$linkquot = 'http://harkerlloreda.com/cotizacion/'.$quot['rowID'];
$mvars = [
	[
		'name'    => 'NAME',
		'content' => $name[0]
	],
	[
		'name'    => 'LINKQUOT',
		'content' => $linkquot
	]
];
// oreka_notification('procedimientos@harkerlloreda.com',$customer['email_client'],$name[0],$mvars,'Cotización #'.$quot['code_quot'].' - Harker & Lloreda','5-harkerlloreda','KqY8l4g5VI97tTl7k_toiA',"Harker & Lloreda");
oreka_notification('procedimientos@harkerlloreda.com',$customer['email_client'],$name[0],$mvars,'Cotización #'.$quot['code_quot'].' - Harker & Lloreda','5-harkerlloreda','KqY8l4g5VI97tTl7k_toiA',"Harker & Lloreda");
oreka_notification('procedimientos@harkerlloreda.com',"simon@harkerlloreda.com",$name[0],$mvars,'Cotización #'.$quot['code_quot'].' - Harker & Lloreda','5-harkerlloreda','KqY8l4g5VI97tTl7k_toiA',"Harker & Lloreda");
oreka_notification('procedimientos@harkerlloreda.com',"carlos@harkerlloreda.com",$name[0],$mvars,'Cotización #'.$quot['code_quot'].' - Harker & Lloreda','5-harkerlloreda','KqY8l4g5VI97tTl7k_toiA',"Harker & Lloreda");
oreka_notification('procedimientos@harkerlloreda.com',"asesora@harkerlloreda.com",$name[0],$mvars,'Cliente:'.$customer['name_client'].' - Cotización #'.$quot['code_quot'].' - Harker & Lloreda','5-harkerlloreda','KqY8l4g5VI97tTl7k_toiA',"Harker & Lloreda");
echo '{"message": 1, "email": "'.$customer['email_client'].'", "code": "'.$quot['code_quot'].'"}';
header('Connection: close');
header('Content-Length: '.ob_get_length());
ob_end_flush();
ob_flush();
flush();
date_default_timezone_set('America/Bogota');
switch ($_POST['type']) {
	case 'first':
		$date = new DateTime();
		// $date->add(new DateInterval('P2M'));
		$date->add(new DateInterval('P15D'));
		$datestr = $date->format('m/d/Y');
		$birthday = new DateTime($customer['birthday_client']);
		$customerData = [
			'FNAME'    => $customer['name_client'],
			'LNAME'    => $customer['last_name_client'],
			'BIRTHDAY' => $birthday->format('m/d'),
			'NAME'     => $name[0],
			'LINKQUOT' => $linkquot,
			'DATECOT'  => $datestr,
			'SALE'     => 'No'
		];
		$result = addCustomerToList($customer['email_client'],$customerData);
		break;
} ?>