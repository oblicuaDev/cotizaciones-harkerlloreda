<?php if(!defined("CLASS_O")){
define("CLASS_O", 1);
class O { 
    public $accessToken = 0;
    public $environment = 0;
    public $b64 = 0;
    private $headers = array();
    const ACCESS_POINT = 'http://oreka.harkerlloreda.com/api/public/';
    public function __construct($CaccessToken,$Cenvironment=0,$Cb64=0) {
       
        $this->accessToken = $CaccessToken;
        $this->environment = $Cenvironment;
        $this->b64 = $Cb64;
        $this->headers = array('Access-token: '.$this->accessToken.'','Environment-set: '.$this->environment,'Content-Type: application/json');
    }
    /*,'Environment-set: '.$this->environment,'enable-b64: '.$this->b64*/
    public function helloworld()
    {
        $service_url = self::ACCESS_POINT.'v1/hello';
        $myresponse = $this->MakeGetCall($service_url);
        return $myresponse;
    }
    public function getUser($userID)
    {
        $userID = urlencode((string)$userID);
        $service_url = self::ACCESS_POINT.'v1/users/'.$userID;
        return $this->MakeGetCall($service_url);
    }
    public function getRows($id)
    {
        $theID = (string)$id;
        $theID = urlencode($theID);
        $service_url = self::ACCESS_POINT.'v1/rows/'.$theID;
        $resp = $this->MakeGetCall($service_url);
        return $resp;
    }
    public function getCollection($moduleID,$sort,$orientation,$quantity,$page,$p = false)
    {
        if($quantity<=50){
            $themodule = (string)$moduleID;
            $themodule = urlencode($themodule);
            $service_url = self::ACCESS_POINT.'v1/collection/'.$themodule.'/'.$sort.'/'.$orientation.'/'.$quantity.'/'.$page;
            if ($p) die($service_url);
            $response = $this->MakeGetCall($service_url);
        }else
        {
           $response = (object)["message" => "Requests over 50 rows are not permitted in Oreka Rest API."];
        }
        return $response;
    }
    public function getSearch($moduleID,$keyword,$date1="",$date2="",$bounded=0)
    {
        $themodule = (string)$moduleID;
        $themodule = urlencode($themodule);
        $thevalue = (string)$keyword;
        $thevalue = urlencode($thevalue);
        $service_url = self::ACCESS_POINT.'v1_1/searches/'.$themodule.'/'.$thevalue;
        if($bounded){
            $service_url .= '/1';
        }
        if($date1!=""){
            $date1 = urldecode((string)$date1);
            $service_url .= '/'.$date1;
            if($date2!=""){
                $date2 = urldecode((string)$date2);
                $service_url .= '/'.$date2;
            }
        }
        $resp = $this->MakeGetCall($service_url);
        return $resp;
    }
    public function getByField($value,$field,$type,$quantity,$page,$sort,$orientation,$bounded=0)
    {
        if($quantity<=50){
            $thevalue = urlencode((string)$value);
            $field = urlencode((string)$field);
            $type = urlencode((string)$type);
            $bounded = urlencode((string)$bounded);
            $quantity = urlencode((string)$quantity);
            $page = urlencode((string)$page);
            $sort = urlencode((string)$sort);
            $orientation = urlencode((string)$orientation);
            $service_url = self::ACCESS_POINT.'v1_1/dev-searches/'.$thevalue.'/'.$field.'/'.$type.'/'.$bounded.'/'.$quantity.'/'.$page.'/'.$sort.'/'.$orientation;
            $response = $this->MakeGetCall($service_url);
        }else
        {
           $response = (object)["message" => "Requests over 50 rows are not permitted in Oreka Rest API."];
        }
        return $response;
    }
    public function getByMultipleField($value,$field,$type,$quantity,$page,$sort,$orientation)
    {
        if($quantity<=50){
            $thevalue = urlencode((string)$value);
            $field=urlencode((string)$field);
            $type=urldecode((string)$type);
            $quantity = urlencode((string)$quantity);
            $page = urlencode((string)$page);
            $sort = urlencode((string)$sort);
            $orientation = urlencode((string)$orientation);
            $service_url = self::ACCESS_POINT.'v1/dev-searches-multiple/'.$thevalue.'/'.$field.'/'.$type.'/'.$quantity.'/'.$page.'/'.$sort.'/'.$orientation;
            $response = $this->MakeGetCall($service_url);
        }else
        {
           $response = (object)["message" => "Requests over 50 rows are not permitted in Oreka Rest API."];
        }
        return $response;
    }
    public function getModule($id){
        $service_url=self::ACCESS_POINT."v1/modules/".urlencode((string)$id);
        return $this->MakeGetCall($service_url);
    }
    public function countRows($moduleID)
    {
        $service_url = self::ACCESS_POINT."v1/count_re/"+urlencode((string)$moduleID);
        return $this->MakeGetCall($service_url);
    }
    public function editRow($body)
    {
        $bodyi = json_encode($body);
        $service_url = self::ACCESS_POINT.'v1/edit';
        return $this->MakePutCall($service_url,$bodyi);
    }
    public function sendNotification($from,$to,$toname,$mergevariables,$subject,$template,$mandrillApiKey,$fromName="Oreka Notifications Service"){
        $body = array("from"=>$from,"to"=>$to,"toname"=>$toname,"subject"=>$subject,"template"=>$template,"mandrillapikey"=>$mandrillApiKey,"sender"=>$fromName);
        $merged = array();
        for($i=0;$i<count($mergevariables);$i++){
            $merged["pos".$i] = $mergevariables[$i];
        }
        $body["mergevariables"] = $merged;
        $service_url = self::ACCESS_POINT."v1/notifications";
        $body = json_encode($body);
        return $this->MakePostCall($service_url,$body);
    }
    public function deleteRow($rowID){
        $rowID = urlencode((string)$rowID);
        $service_url = self::ACCESS_POINT."v1/delete/$rowID";
        return $this->MakePostCall($service_url);
    }
    public function postRow($modules, $rows, $idfies, $types, $values){
        $service_url=self::ACCESS_POINT."v1/create";
        $iRows=0;
        if(!is_array($modules)){
            $modules=[$modules];
            $rows=[$rows];
            $idfies=[$idfies];
            $ntypes=count(explode(",", $types));
            $types=[$types];
            $nvalues=count($values);
            if($ntypes==$nvalues)
                $values=[[$values]];
        }

        $data=new stdClass();
        $body=new stdClass();
        for ($i=0; $i < count($modules); $i++) { 
            $currFields=explode(",", $idfies[$i]);
            $currTypes=explode(",", $types[$i]);
            for ($j=0; $j < $rows[$i]; $j++) {
                $newrow=new stdClass();
                $newrow->module=$modules[$i];
                $newrow->types="";
                $newrow->values=new stdClass();
                $newrow->idfields=new stdClass();
                $newrow->typefields=new stdClass();
                for ($k=0; $k < count($currFields); $k++) {
                    $val="val$k";
                    $type="type$k";
                    $idfie="id$k";
                    $newrow->values->$val=$values[$i][$j][$k];
                    $newrow->idfields->$idfie=$currFields[$k];
                    $newrow->typefields->$type=$currTypes[$k];
                }
                $newrowS="newrow$iRows";
                $data->$newrowS=$newrow;
                $iRows++;
            }
        }
        $body->data=$data;
        $body=json_encode($body);
        return $this->MakePostCall($service_url,$body);
    }
    public function setValidity($rowID,$to,$from="same"){
        $to = urlencode((string)$to);
        $from = urlencode((string)$from);
        $service_url=self::ACCESS_POINT."v1/validity/".(string)$rowID."/$to/$from";
        return $this->MakePutCall($service_url);
    }
    public function setDraft($rowID,$draft=1){
        $service_url=self::ACCESS_POINT."v1/draft/".(string)$rowID."/$draft";
        return $this->MakePutCall($service_url);
    }
    public function destroy(){
        $service_url=self::ACCESS_POINT."destroy";
        return $this->MakeGetCall($service_url);
    }
    public function uploadImage($file){
        $body=array('picture' =>curl_file_create($file['tmp_name'], $file['type'], $file['name']));
        $service_url=self::ACCESS_POINT."v1/upload-picture";
        return $this->UploadFile($service_url,$body);
    }
    public function uploadMedia($file){
        $body=array('media' =>curl_file_create($file['tmp_name'], $file['type'], $file['name']));
        $service_url=self::ACCESS_POINT."v1/upload-media";
        return $this->UploadFile($service_url,$body);
    }
    public function uploadFiles($file){
        $body=array('media' =>curl_file_create($file['tmp_name'], $file['type'], $file['name']));
        $service_url=self::ACCESS_POINT."v1/upload-files";
        return $this->UploadFile($service_url,$body);
    }
    public function MakeGetCall($url)
    {
        $service_url = $url;
        $ch = curl_init($service_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        // curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        $ch_response = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($ch_response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("MakeGetCall JSON Error[$service_url]: " . json_last_error_msg() . " - " . $ch_response . "\n", 3, __DIR__ . "/json_error.log");
        }
        return $decoded;
    }
    
    public function MakePutCall($url,$body="{}")
    {
        //array_push($this->headers,'Content-Length: '.strlen($body));
        //array_push($this->headers,'Content-Type: application/json');
        
        $service_url = $url;
        $ch = curl_init($service_url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        // curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        $ch_response = curl_exec($ch);
        
        curl_close($ch);
        $decoded = json_decode($ch_response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("MakePutCall JSON Error[$service_url]: " . json_last_error_msg() . " - " . $ch_response . "\n", 3, __DIR__ . "/json_error.log");
        }
        return $decoded;
    }
    public function MakePostCall($url,$body="{}"){
        //array_push($this->headers,'Content-Length: '.strlen($body));
        //array_push($this->headers,'Content-Type: application/json');
        $service_url = $url;
        $ch = curl_init($service_url);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        // curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        $ch_response = curl_exec($ch);
        
        curl_close($ch);
        $decoded = json_decode($ch_response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("MakePostCall JSON Error[$service_url]: " . json_last_error_msg() . " - " . $ch_response . "\n", 3, __DIR__ . "/json_error.log");
        }
        return $decoded; 
    }
    public function UploadFile($url,$body){
        $headers=array('Access-token: '.$this->accessToken.'','Environment-set: '.$this->environment,'Cache-Control: no-cache');
        $service_url = $url;
        $ch = curl_init($service_url);
        
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        // curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        // curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        $ch_response = curl_exec($ch);
        
        curl_close($ch);
        $decoded = json_decode($ch_response);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("UploadFile JSON Error[$service_url]: " . json_last_error_msg() . " - " . $ch_response . "\n", 3, __DIR__ . "/json_error.log");
        }
        return $decoded;
    }
}
} ?>