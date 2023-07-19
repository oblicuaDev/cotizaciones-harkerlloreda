<?php include '../includes/config.php';
header('Content-Type: application/json');
$procedures = f_content_list(36,'name_procedure_cot','upward',0,1);
echo json_encode($procedures); ?>