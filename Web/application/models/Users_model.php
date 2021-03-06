<?php
class Users_model extends CI_Model
{
	function Users_model()
	{
		parent::__Construct();
	$this->load->library('mongo_db');
		$collection = $this->mongo_db->db->selectCollection('riders');
	}
	function insert_data($data)
	{
		
		$result1 = $this->mongo_db->db->riders->insert($data);
		return $result1;
	}
	

	  function GetExpireTime() {
		$result = $this->mongo_db->db->expiretime->find(array("id"=> 1));
		return $result;
	}	
	
	function check_valid_user_or_not()
	{
	       $this->load->library('mongo_db');
		$collection = $this->mongo_db->db->selectCollection('riders');
		
		  $username = $this->input->post('ridermailid');
          $password = $this->input->post('riderpasswd');
          //  $db = $this->mongo_db->db();
          $collection = $this->mongo_db->db->riders;
          $user = $collection->findOne(array("email" => $username, "password" => sha1($password))); 	        
		  if (count($user))
          {
                return $user;
           }
          else
           {
                return false;     
           }		
	}
function get_details($user_id)//,$email)
	{

	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($user_id)));


	return $result;
	
	}
	
	function GetAllTransactionByLimit($offset, $limit) {
		//$result = $this->mongo_db->db->drivers->find(array("status"=>'on',"carcategory" => $carcategory,"value"=>array('$lte'=>1200)))->sort(array('value' => 1));
		
	    $result = $this->mongo_db->db->trips->find()->skip($offset)->limit($limit);
		return $result;
		
	}
	function GetAllTransaction() {
		$email = $this->input->post('ridermailid');
		$user = $this->mongo_db->db->riders->find(array('email'=>$email))->count();
		foreach ($user as $use)
		$id = $use['_id'];
	    $result = $this->mongo_db->db->trips->find(array('rider_id'=>$id))->count();
		return $result;
		
	}
	
	public function search($keyword)
{
	$regex = new MongoRegex("/^$keyword/i");
		$data = $this->mongo_db->db->riders->find(array('$or' => array(array('email' => $regex), array('firstname' => $regex), array('lastname' => $regex))));
	return $data;
}
	function insert_sample($data)
	{
		
		$data1['password']=sha1($data['password']);
		$data1['email']=$data['email'];
		$data1['mobile_no']=$data['mobile_no'];
		$data1['regid']=$data['regid'];
		$data1['firstname']=$data['firstname'];
		$data1['lastname']=$data['lastname'];
		$data1['created']=$data['created'];
		$data1['requesttime']=$data['requesttime'];
		$data1['devicetoken']=$data['devicetoken'];
		$data1['regid']=$data['regid'];
		
		
		
		$result1 = $this->mongo_db->db->riders->insert($data1);
		return $result1;
	}
	
	
	//for credit card add nonce
	function insert_sample1($data)
	{
		$data1['nonce']=$data['nonce'];
		$data1['password']=sha1($data['password']);
		$data1['email']=$data['email'];
		$data1['mobile_no']=$data['mobile_no'];
		$data1['regid']=$data['regid'];
		$data1['firstname']=$data['firstname'];
		$data1['lastname']=$data['lastname'];
		$data1['created']=$data['created'];
		$data1['requesttime']=$data['requesttime'];
		$data1['devicetoken']=$data['devicetoken'];
		$data1['regid']=$data['regid'];
		$data1['imei']=@$data['imei'];
		
		$result1 = $this->mongo_db->db->riders->insert($data1);
		return $result1;
	}
	
	
	function get_data($email,$password)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->riders->update(array("email"=>$email,"password"=>$password,"firstname"=>array('$exists'=>false)),array('$set'=>array("firstname"=>"null")));
		$this->mongo_db->db->riders->update(array("email"=>$email,"password"=>$password,"lastname"=>array('$exists'=>false)),array('$set'=>array("lastname"=>"null")));
		$this->mongo_db->db->riders->update(array("email"=>$email,"password"=>$password,"prof_pic"=>array('$exists'=>false)),array('$set'=>array("prof_pic"=>"null")));
	  $result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password),array("_id"=>1,"firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1));

	return $result;
	
	}
	function check_data($email)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	
	  $result = $this->mongo_db->db->riders->find(array("email"=>$email),array("_id"=>1,"firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1));
	if($result->hasNext())
	{
		return true;
	}
	else
	{
		return false;
	}
	
	}
	function check_mail($email)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	
	  $result = $this->mongo_db->db->riders->find(array("email"=>$email),array("_id"=>1,"email"=>1));
	return $result;
	}
	function check_id($id)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	
	  //$result = $this->mongo_db->db->fb_riders->find(array("_id"=>new MongoId($id)),array("_id"=>1,"firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1));
	  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($id)));
	  return $result;
	  
	  //$result_normal = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($id)));
	  
/*if($result->hasNext())
{
	return 2;
}
else if($result_normal->hasNext())
{
	return 1;
}
else{
	return 3 ;
}*/
	
	}
	function users_details($user_id)//,$email)
	{
	
	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($user_id)));
//print_r($user_id);

	return $result;
	}
	
	function display_details($user_id)//,$email)
	{
	
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id),"firstname"=>array('$exists'=>false)),array('$set'=>array("firstname"=>"null")));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id),"lastname"=>array('$exists'=>false)),array('$set'=>array("lastname"=>"null")));
$this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id),"prof_pic"=>array('$exists'=>false)),array('$set'=>array("prof_pic"=>"null")));
$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($user_id)));
//print_r($user_id);

	return $result;
	}
	function display_details2($user_id,$email)
	{
	
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id),"firstname"=>array('$exists'=>false)),array('$set'=>array("firstname"=>"null")));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id),"lastname"=>array('$exists'=>false)),array('$set'=>array("lastname"=>"null")));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id),"prof_pic"=>array('$exists'=>false)),array('$set'=>array("prof_pic"=>"null")));
  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($user_id),"email"=>$email),array("firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1,"user_id"=>1));
//print_r($user_id);

	return $result;
	
	}
	function display_details1($email)
	{
	//$result = $this->mongo_db->db->riders->find(array("user_id"=>$user_id));//,"email"=>$email));
	
  $this->mongo_db->db->riders->update(array("email"=>$email,"firstname"=>array('$exists'=>false)),array('$set'=>array("firstname"=>"null")));
		$this->mongo_db->db->riders->update(array("email"=>$email,"lastname"=>array('$exists'=>false)),array('$set'=>array("lastname"=>"null")));
		$this->mongo_db->db->riders->update(array("email"=>$email,"prof_pic"=>array('$exists'=>false)),array('$set'=>array("prof_pic"=>"null")));
  $result = $this->mongo_db->db->riders->find(array("email"=>$email),array("firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1,"user_id"=>1));
//print_r($user_id);
	return $result;
	
	}
	
	function fare_calc($driverid)
	{
	$driver = $this->mongo_db->db->drivers->findOne(array("_id"=>new MongoId($driverid)));
	$carname=$driver['carname'];
	$carcategory=$driver['carcategory'];
	
	$car = $this->mongo_db->db->car->findOne(array("carname"=>$carname,"category"=>$carcategory));
	return $car;
	
	}
	
	function update_data($id,$credit_card_num,$cvv,$expiry_date)
	{
	
	 $result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("credit_card_num"=>$credit_card_num,"cvv"=>$cvv,"expiry_date"=>$expiry_date,"paymentnonce"=>$nonce)));
      
	return $result;
	}	
	
		//add toll fees
	function insert_toll($data)
	{
		
		$result1 = $this->mongo_db->db->toll_fees->insert($data);
		return $result1;
	}
	
	function update_data_creditcard($id,$nonce,$cusid)
	{
	  //$result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("credit_card_num"=>$credit_card_num,"cvv"=>$cvv,"expiry_date"=>$expiry_date,"paymentnonce"=>$nonce)));
	  $result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("auto_paymentnonce"=>$nonce,"customer_id"=>$cusid)));
	  //$result1 = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($id)),array("_id"=>1,"firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1));
	
	return $result;
	
	}
	function update_data1($id,$nonce)
	{
	  //$result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("credit_card_num"=>$credit_card_num,"cvv"=>$cvv,"expiry_date"=>$expiry_date,"paymentnonce"=>$nonce)));
	  $result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("paymentnonce"=>$nonce)));
	  //$result1 = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($id)),array("_id"=>1,"firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1));
	
	return $result;
	
	}
	function update_data2($id,$credit_card_num,$cvv,$expiry_date)
	{
	  $result = $this->mongo_db->db->fb_riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("credit_card_num"=>$credit_card_num,"cvv"=>$cvv,"expiry_date"=>$expiry_date)));
//$result1 = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($id)),array("_id"=>1,"firstname"=>1,"lastname"=>1,"prof_pic"=>1,"email"=>1,"mobile_no"=>1,"password"=>1));
	
	return $result;
	
	}
	
	//braintree
	function brain_update_details($user_id, $payment_token, $customer_id)
	{
		$result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id)),array('$set'=>array("payment_token"=>$payment_token, "customer_id"=>$customer_id)));

		return $result;
	}
	
	
	function update_details($user_id,$firstname,$lastname,$prof_pic,$email,$mobile_no,$password)
	{
	  $result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id)),array('$set'=>array("firstname"=>$firstname,"lastname"=>$lastname,"prof_pic"=>$prof_pic,"email"=>$email,"mobile_no"=>$mobile_no,"password"=>$password)));

	return $result;
	
	}
	function updateProfile($id,$image_url)
	{
	
	 $result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($id)),array('$set'=>array("prof_pic"=>$image_url)));
      
	return $result;
	}	
	function reset_password($user_id,$password)
	{
		$password1=sha1($password);
		$result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($user_id)),array('$set'=>array("password"=>$password1)));
	    return $result;
	}
	public function RiderChangePasswordBasedOnId($RiderId) {
		extract($this->input->post());
		$this->mongo_db->db->riders->update(array('_id' =>  new MongoId($RiderId) ),array('$set'=>array("password"=> sha1($new_password))));
	}
	public function GetRiderDetailsBasedOnId($RiderId) {
		$result = $this->mongo_db->db->riders->find(array('_id' => new MongoId($RiderId)));
		return $result;
	}
	
	function update_code($email)
	{
		$result = $this->mongo_db->db->riders->update(array("email"=>$email),array('$set'=>array("email_code"=>md5($email))));
		return $result;
	}
	function fb_login($firstname,$lastname,$mobile_no,$email,$fb_id)
	{	
	  $result = $this->mongo_db->db->riders->find(array("fb_id"=>$fb_id),array("_id"=>1,"firstname"=>1));

	return $result;
	
	}
	function fb_login1($fb_id)
	{	
	  $result = $this->mongo_db->db->riders->find(array("fb_id"=>$fb_id),array("_id"=>1,"firstname"=>1));

	return $result;
	
	}	
	
	
	function get_fb_id($firstname,$lastname,$mobile_no,$email)
	{	
	  $result = $this->mongo_db->db->riders->find(array("firstname"=>$firstname,"lastname"=>$lastname,"mobile_no"=>$mobile_no,"email"=>$email),array("_id"=>1,"fb_id"=>1));

	return $result;
	
	}	
	function login($email,$password)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->riders->update(array("email"=>$email,"password"=>sha1($password),"firstname"=>array('$exists'=>false)),array('$set'=>array("firstname"=>"null")));
		$this->mongo_db->db->riders->update(array("email"=>$email,"password"=>sha1($password),"lastname"=>array('$exists'=>false)),array('$set'=>array("lastname"=>"null")));
		$this->mongo_db->db->riders->update(array("email"=>$email,"password"=>sha1($password),"prof_pic"=>array('$exists'=>false)),array('$set'=>array("prof_pic"=>"null")));
	  //$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>sha1($password)),array());
	    $result = $this->mongo_db->db->riders->find(array('$or' => array(array('email' => $email), array('mobile_no' => $email)),"password"=>sha1($password)),array());
   
	return $result;
	
	}
	
	function update_availability($_id,$availability)
    {
    $this->mongo_db->db->riders->update(array("_id"=>new MongoId($_id)),array('$set'=>array("availability"=>$availability)));
    $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($_id)));
    return $result;
	}
	
	
	function sendMail($to,$from_email,$from_name,$subject,$message)
	{
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		
$this->email->set_mailtype("html");	

		$this->email->to($to);
  $this->email->from($from_email,$from_name);
  $this->email->subject($subject);
  $this->email->message($message);
		
 $headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\n";

$headers .= 'From: ' .'Arcane'. '<'.$from_email.'>' . "\r\n";
// Inform the user
		if(mail($to,$subject,$message,$headers))
			{
			return 1;
			}
			else {
				echo $this->email->print_debugger();
				return 0;
			}
			}
	function update_accept_no($userid,$lat,$long,$driverid,$requesttime)
	{
		
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	    $this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("lat"=>$lat)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("long"=>$long)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("driverid"=>$driverid)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("accept"=>"no")));
	  //adding req time
	  $this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("requesttime"=>$requesttime)));
	  //adding req time
	     $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	   return $result;  
	}
	function check_driver($driverid,$userid)
	{
		$tmp=$this->mongo_db->db->riders->find(array("driverid"=>$driverid))->count();
		if($tmp >= 1)
		{
			$tmp=$this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid),"driverid"=>$driverid))->count();
			if($tmp >= 1)
			{
				$tmp = 0;
			}
			else {
				$tmp = 1;
			}
		}
		return $tmp;
	}
	
	function check_driver1($driverid)
	{
		$tmp=$this->mongo_db->db->riders->find(array("driverid"=>$driverid))->count();

		return $tmp;
	}
	
	function update_location($userid,$lat,$long,$driverid,$message,$requesttime)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
  	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("lat"=>$lat)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("long"=>$long)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("driverid"=>$driverid)));
				$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("message"=>$message)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("requesttime"=>$requesttime)));
		
     $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));

	return $result;
	
	}
	function update_location1($userid,$lat,$long,$driverid,$pickuplat,$pickuplong,$destaddress)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("lat"=>$lat)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("long"=>$long)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("pickuplat"=>$pickuplat)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("pickuplong"=>$pickuplong)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("destaddress"=>$destaddress)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("driverid"=>$driverid)));
		
			  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));

	return $result;
	
	}
		function driver_status_off($userid,$lat,$long,$status)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->drivers->update(array("_id"=>new MongoId($userid)),array('$set'=>array("lat"=>$lat)));
		$this->mongo_db->db->drivers->update(array("_id"=>new MongoId($userid)),array('$set'=>array("long"=>$long)));
		$this->mongo_db->db->drivers->update(array("_id"=>new MongoId($userid)),array('$set'=>array("status"=>$status)));
		
			  $result = $this->mongo_db->db->drivers->find(array("_id"=>new MongoId($userid)));

	return $result;
	
	}
	function ret_rideridandname($rideremail)
	{
		$riderresult=$this->mongo_db->db->riders->findOne(array("paypalemail"=>$rideremail));
		return $riderresult;
	}
	
	function retid_rideridandname_value($ridername)
	{
		$riderresult=$this->mongo_db->db->riders->findOne(array("firstname"=>$ridername));
		return $riderresult;
	}
	

	function get_devicetoken($driverid)
	{
	 $result = $this->mongo_db->db->drivers->find(array("_id"=>new MongoId($driverid)));
     return $result;
    }	
	
	function update_regid($_id,$regid,$devicetoken,$imei)
	{
	if(empty($imei))
	{
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($_id)),array('$set'=>array("regid"=>$regid,"devicetoken"=>$devicetoken)));
	}else
	{
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($_id)),array('$set'=>array("regid"=>$regid,"devicetoken"=>$devicetoken,"imei"=>$imei)));
	}
    $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($_id)));



	return $result;
	
	}
	function update_availablity($_id,$availablity)
	{
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($_id)),array('$set'=>array("availablity"=>$availablity)));
	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($_id)));
	return $result;
	}
	
	function update_toll($userid,$tollamount)
	{
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("tollamount"=>$tollamount)));
		// $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
		// return $result;
	}
	
	function update_toll_trip($tripid,$tollamount)
	{
		$this->mongo_db->db->trips->update(array("_id"=>new MongoId($tripid)),array('$set'=>array("tollamount"=>$tollamount)));
		// $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
		// return $result;
	}
	
	
	function update_location_user($userid,$lat,$long)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("lat"=>$lat)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("long"=>$long)));
					  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));

	return $result;
	
	}
	function get_acceptstatus($userid)
	{
		
	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	return $result;
	
	}
	function get_amount($userid)
	{
		$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
		return $result;
	
	}
	
	function get_driverid($userid)
	{
				  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));

	return $result;
	
	}
	
/*
	function update_rate($driverid,$rider_count,$rate,$consolidate_rate)
	{
		
			
				 // $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	
	  $this->mongo_db->db->drivers->update(array("_id"=>new MongoId($driverid)),array('$set'=>array("ridercount"=>$rider_count,"rate"=>$rate,"consolidate_rate"=>$consolidate_rate)));
	  $result = $this->mongo_db->db->drivers->find(array("_id"=>new MongoId($driverid)));

	return $result;
	
	
	
	}*/
function update_rate($userid,$driverid,$promoamount,$rider_count,$rate,$rate1,$consolidate_rate,$ridername,$drivername)
	{
		$update = array();
		$update['rider_id'] = $userid ;
		$update['driver_id'] = $driverid ;
		$update['rider_name'] = $ridername ;
		$update['driver_name'] = $drivername ;
		$update['promoamount'] = $promoamount ;
		//$update['rider_count'] = $rider_count ;
		
		//$update['consolidate_rate'] = $consolidate_rate ;
		$update['rate'] = $rate1;
		
			$this->mongo_db->db->review->insert($update);
		
		
		$last_id =  "'".$update['_id']."'";
		$last_id = trim($last_id,"'");
			$review_id = 	$last_id ;
			
		/*
		$update['drop'] = $drop ;
				$update['timestamp'] = $timestamp ;
				$update['service'] = $service ;
				$update['distance'] = $distance ;
				$update['arrive'] = $arrive ;
				$update['waitingtime'] = $waitingtime ;*/
		
		
			
				 // $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	 $this->mongo_db->db->drivers->update(array("_id"=>new MongoId($driverid)),array('$set'=>array("ridercount"=>$rider_count,"rate"=>$rate,"consolidate_rate"=>$consolidate_rate,"promoamount"=>$promoamount)));
	 $result = $this->mongo_db->db->drivers->find(array("_id"=>new MongoId($driverid)));

	return $result;
	
	
	
	}
		
	function clear_amount_user($userid)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	if($result->hasNext())
	{
	foreach($result as $document)
	 {
	 	$driverid = $document['driverid'];
	 	if(isset($document['trip_rider_status']))
	 	{	
		$trip_rider_status = $document['trip_rider_status'];
		}
		else
		{
		$trip_rider_status = "Home";
		}	
	}
	 $this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("android_status"=>'null')));
	 $this->mongo_db->db->drivers->update(array("_id"=>new MongoId($driverid)),array('$set'=>array("android_status"=>'null')));
	}
	if($trip_rider_status=="Home")
	{
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("driverid"=>'null')));
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("amount"=>'null')));
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("accept"=>'')));
	$this->mongo_db->db->riders->update(array("split_id"=>$userid),array('$set'=>array("split_id"=>'null')));	
	}
	return $result;
	}
	
	function clear_split($userid)
	{
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("split_id"=>'null')));	
    	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
		return $result;
	}
	
	function update_arrive($userid,$driver_name,$driver_mobileno)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("driver_name"=>$driver_name)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("driver_mobileno"=>$driver_mobileno)));
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("arrive"=>'on')));
			  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));

	return $result;
	
	}



function get_today_user(){
	$created=strtotime ("00:00:00");
	$result = $this->mongo_db->db->riders->find(array("created"=>array('$gte'=>$created)))->count();
	return $result;
}
function gettoday_transaction(){
	$created=strtotime ("00:00:00");
	$result = $this->mongo_db->db->trips->find(array("created"=>array('$gte'=>$created),"status" => array('$ne' => 'pending','$ne' => '')))->count();
	return $result;
}

function get_paymentnonce($userid,$nonce)
{
  	//print_r($nonce);
		$this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("paymentnonce"=>$nonce)));
			  $result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));

	return $result;
}
function update_paymode($tripid,$paymode)
{
  	//print_r($nonce);
		$this->mongo_db->db->trips->update(array("_id"=>new MongoId($tripid)),array('$set'=>array("paymode"=>$paymode)));
			  $result = $this->mongo_db->db->trips->find(array("_id"=>new MongoId($tripid)));

	return $result;
}
	
function update_settings($data1)
	{
		$setting_image = $this->mongo_db->db->settings->find();
				
							
		if($setting_image->hasNext())
	{
			foreach($setting_image as $documentimage)
				 {
				 $settingid    = $documentimage['_id'];	
				 }
	}
		$this->mongo_db->db->settings->update(array("_id"=>new MongoId($settingid)),array('$set'=>array("title"=>$data1['title'])));
		$this->mongo_db->db->settings->update(array("_id"=>new MongoId($settingid)),array('$set'=>array("sitelogan"=>$data1['sitelogan'])));
		$this->mongo_db->db->settings->update(array("_id"=>new MongoId($settingid)),array('$set'=>array("admin_mail"=>$data1['admin_mail'])));
		$this->mongo_db->db->settings->update(array("_id"=>new MongoId($settingid)),array('$set'=>array("admin_no"=>$data1['admin_no'])));
			 $this->mongo_db->db->settings->update(array("_id"=>new MongoId($settingid)),array('$set'=>array("image_name"=>$data1['image_name'])));
			  $result = $this->mongo_db->db->settings->find(array("_id"=>new MongoId($settingid)));

		return $result;
	}
function get_settings(){
		$result = $this->mongo_db->db->settings->find();
	return $result;
	}

function get_settings_admin(){
		
	$setting_result = $this->mongo_db->db->settings->find();
	if($setting_result->hasNext())
	{
			foreach($setting_result as $document)
				 {
				 	$data['sitetitle']=$document['title'];
					$data['sitelogan']=$document['sitelogan'];
					$data['admin_email']=$document['admin_mail'];
				 }
				 return $data;
	}else{
		return "";
	}
	
	}	

	function get_image($id){
		  $result = $this->mongo_db->db->settings->find(array("_id"=>new MongoId($id)));

		return $result;
	}
	/*function get_arrivestatus()
	{
	
	  $result = $this->mongo_db->db->drivers->find(array("status"=>'on'));

	return $result;
	
	}*/
	
	function addemail()
	{
		
    	 $db = $this->mongo_db->db;
		 $user = $db->email->findOne(array("code" => $this->input->post('code')));
        if(count($user))
		{
			return 0;
			
		}
		else {
			
		
        $insertData = array(
        'subject'=> $this->input->post('sub'),
        'code'=> $this->input->post('code'),
                            'message'=> $this->input->post('message'),
                            );
       
        $db->email->insert($insertData);
		return 1;
    }
		
	}
function getemail()
{
	
	 	        $db = $this->mongo_db->db;
				$message=$db->email->find();
				return $message;
}



function getemailbyid()
{
	$id=$this->uri->segment(4);
	//echo $id;exit;
	 $db = $this->mongo_db->db;
			 $realmongoid = new MongoId($id);
			 //echo $realmongoid;exit;
         $message = $db->email->find(array("_id" => $realmongoid));
		 $count=$db->email->find(array("_id" => $realmongoid))->count();
		 return array(
    'records' => $message,
    'count' =>  $count
);
		// echo $message;exit;
		
         return $message;
}
function getemailbyidcount($id)
{
	//$id=$this->uri->segment(3);
	//echo $id;exit;
	 $db = $this->mongo_db->db;
			 $realmongoid = new MongoId($id);
			 //echo $realmongoid;exit;
         $message = $db->email->find(array("_id" => $realmongoid))->count();
		// echo $message;exit;
		
         return $message;
}

function get_split_id($splitteid)
    {
    	$id="$splitteid";
		$result = $this->mongo_db->db->riders->find(array("split_id"=>$id));
    	return $result;
	}

function updatemailbyid()
{
	  $db = $this->mongo_db->db;
        //  $realmongoid = new MongoId($userid);
        //  echo "<pre>"; print_r($insertData); echo $realmongoid; exit;
        $updatedata=array(
        'subject'=> $this->input->post('sub'),
        'code'=> $this->input->post('code'),
                            'message'=> $this->input->post('message'),
                            );
							$id=$this->uri->segment(4);
							//echo $id;exit;
										 $realmongoid = new MongoId($id);
							             //echo $realmongoid;exit;
							           //  print_r($updatedata);exit;
          $db->email->update(array("_id" => $realmongoid), array('$set' => $updatedata));
		  $updatedata=$db->email->find(array("_id" => $realmongoid))->count();
		  return $updatedata;
}

function deletemailbyid($id)
{	
	        $db = $this->mongo_db->db;       
			$realmongoid = new MongoId($id);
		    $db->email->remove(array('_id' => $realmongoid), array("justOne" => true));

}

function getemailbycode($code)
	{
		     $db =  $this->mongo_db->db;
		    	$message=$db->email->find(array("code" => $code ));
				foreach ($message as $template) {
			$dbmsg=$template['message'];
		 $dbsub=$template['subject'];
				}
	return array(
    'msg' => $dbmsg,
    'sub' =>  $dbsub
	);

	}
function get_pending()
{
    $result = $this->mongo_db->db->trips->find(array("status"=>'pending'))->count();
	return $result;	  
	  
}
function get_completed()
{
    $result = $this->mongo_db->db->trips->find(array("status"=>'Paid'))->count();
	return $result;	  
	  
}
function get_total_trips()
{
    $result = $this->mongo_db->db->trips->find()->count();
	
	return $result;	  
	  
}

function get_fare_amount($category)
	{
	  $result = $this->mongo_db->db->category->find(array("categoryname"=>$category));
	  return $result;
	}


function get_total_payments()
{
    $result = $this->mongo_db->db->trips->find();
		$initial=0;	
	foreach ($result as $res) {
	
			
		$initial=$initial+$res['amount'];
	    //$res++;
		//print_r($res['amount']);
	
	
	}
	
	
	return $initial;	  
	  
}



function gp_login($gp_id)
	{
	  $this->mongo_db->db->riders->update(array("gp_id"=>$gp_id,"password"=>array('$exists'=>false)),array('$set'=>array("password"=>"null")));		
	  $result = $this->mongo_db->db->riders->find(array("gp_id"=>$gp_id));

	return $result;
	
	}	

function check_gp_data($gp_id)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->riders->update(array("gp_id"=>$gp_id,"password"=>array('$exists'=>false)),array('$set'=>array("password"=>"null")));
	  $result = $this->mongo_db->db->riders->find(array("gp_id"=>$gp_id));
if($result->hasNext())
{
	return true;
}
else
{
	return false;
}
}
	function insert_gp_data($data)
	{
		//print_r($data['fb_id']); exit;
		$result1 = $this->mongo_db->db->riders->insert($data);
		return $result1;
	}


function get_gp_data($gp_id)
	{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	$this->mongo_db->db->riders->update(array("gp_id"=>$gp_id,"prof_pic"=>array('$exists'=>false)),array('$set'=>array("prof_pic"=>"null")));
		$this->mongo_db->db->riders->update(array("gp_id"=>$gp_id,"password"=>array('$exists'=>false)),array('$set'=>array("password"=>"null")));
	  $result = $this->mongo_db->db->riders->find(array("gp_id"=>$gp_id));

	return $result;
	
	}
	function update_paymentid($id,$payid)
	{
	 $result = $this->mongo_db->db->trips->update(array("_id"=>new MongoId($id)),array('$set'=>array("payment_id"=>$payid)));
     return $result;
	}
	
	function update_paymentid1($id,$payid)
	{
	 $result = $this->mongo_db->db->trips->update(array("_id"=>new MongoId($id)),array('$set'=>array("payment_id1"=>$payid)));
     return $result;
	}
		
	function get_paymentid($id){
		 $result = $this->mongo_db->db->trips->find(array("_id"=>new MongoId($id)));
		 
		 	foreach ($result as $res) {
				 $pay=$res['payment_id'];
			 }
		 return $pay;
	}
	function get_admino(){
		 $result = $this->mongo_db->db->settings->find();
		 
		 	foreach ($result as $res) {
				 $num=$res['admin_no'];
			 }
		 return $num;
	}
	function getsms()
{
	
	 	        $db = $this->mongo_db->db;
				$message=$db->sms->find();
				return $message;
}
function gettwilio()
{
	
	 	        $db = $this->mongo_db->db;
				$message=$db->twilio->find();
				return $message;
}
function updatetwilio()
{
	  $db = $this->mongo_db->db;
  $sid=$this->input->post('twilio_sid'); 
   $tok=$this->input->post('twilio_token'); 
   $num=$this->input->post('twilio_number');
    //                        );
						            //echo $realmongoid;exit;
							           //  print_r($updatedata);exit;
          $db->twilio->update(array("no" => "1"), array('$set'=>array("twilio_sid"=>$sid,"twilio_token"=>$tok,"twilio_number"=>$num)));
		  $updatedata=$db->twilio->find(array("no" =>"1"))->count();
		  return $updatedata;
}
function getsmsbyid()
{
	$id=$this->uri->segment(4);
	//echo $id;exit;
	 $db = $this->mongo_db->db;
			 $realmongoid = new MongoId($id);
			 //echo $realmongoid;exit;
         $message = $db->sms->find(array("_id" => $realmongoid));
		 $count=$db->sms->find(array("_id" => $realmongoid))->count();
		 return array(
    'records' => $message,
    'count' =>  $count
);
		// echo $message;exit;
		
         return $message;
}
function updatsmsbyid()
{
	  $db = $this->mongo_db->db;
        //  $realmongoid = new MongoId($userid);
        //  echo "<pre>"; print_r($insertData); echo $realmongoid; exit;
        $updatedata=array(
        'subject'=> $this->input->post('sub'),
        'code'=> $this->input->post('code'),
        'description'=> $this->input->post('description'),
                            'message'=> $this->input->post('message')
                            );
							$id=$this->uri->segment(4);
							//echo $id;exit;
										 $realmongoid = new MongoId($id);
							             //echo $realmongoid;exit;
							           //  print_r($updatedata);exit;
          $db->sms->update(array("_id" => $realmongoid), array('$set' => $updatedata));
		  $updatedata=$db->sms->find(array("_id" => $realmongoid))->count();
		  return $updatedata;
}

function update_split_request($userid,$splitid,$splitname)
{
	
	 $result = $this->mongo_db->db->riders->find(array("mobile_no"=>$splitid));
	 if($result->hasNext())
	 {
	 	
	 	$result1 = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("split_id"=>$splitid)));
		$result2 = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($userid)),array('$set'=>array("split_name"=>$splitname)));
		
	 	//$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($splitid)));
	 	return $result;
	 }
	 else {
	 	
		 return "null";
	 }
	
}

/*
function update_split_request($userid,$splitid,$splitname)
{
	
	 $result = $this->mongo_db->db->riders->find(array("mobile_no"=>$splitid));
	 if($result->hasNext())
	 {
	 			
	 	 foreach ($result as $key) 
	 	 {
		 	$splitid = $key["_id"];
	     }
	 	$result = $this->mongo_db->db->riders->update(array("_id"=>new MongoId($splitid)),array('$set'=>array("split_id"=>$userid)));
		
	 	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($splitid)));
	 	return $result;
	 }
	 else {
	 	
		 return "null";
	 }
	
}
*/



function get_invite_status($userid)
{
$result = $this->mongo_db->db->riders->find(array("split_id"=>$userid,"split_accept" =>"Driver Accepted the Request"));
return $result;
}



function twilio_setng()
{
	//$result = $this->mongo_db->db->riders->find(array("email"=>$email,"password"=>$password));
	
	  $result = $this->mongo_db->db->twilio->find(array("no"=>"1"));
	return $result;
}
function get_category_details($category)
{
	 $result = $this->mongo_db->db->category->find(array("categoryname"=>$category));
      return $result;
}
function get_prime_time()
{
	 $result = $this->mongo_db->db->primetime->find();
      return $result;
}
function getlogoname($userid)
{
	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	return $result;
}
//For Promo Code
//function getemailbycode($code)
//{
	
	// 	        $db =  $this->mongo_db->db;
		//		$message=$db->email->find(array("code" => $code ));
			//	foreach ($message as $template) {
			//$dbmsg=$template['message'];
		 //$dbsub=$template['subject'];
		
//	}
	//		    return array(
    //'msg' => $dbmsg,
    //'sub' =>  $dbsub
//);
//}
//End




function get_acceptstatus1($userid)
	{
		
	$result = $this->mongo_db->db->riders->find(array("_id"=>new MongoId($userid)));
	return $result;
	
	}

function ridername_autocomplete(){
 	
		$riderresult['ridername']=$this->mongo_db->db->riders->findOne(array("paypalemail"=>$rideremail));
		return $riderresult['ridername'];
		
	 }

// Export for Rider
function export_txt(){
$database = 'arcanemobile';
$collection = 'riders';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_rdr.txt';
force_download($name,$json);
}
function export_csv(){
$database = 'arcanemobile';
$collection = 'riders';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_rdr.csv';
force_download($name,$json);
} //Export for Rider
// Export for driver
function export_driver_txt(){
$database = 'arcanemobile';
$collection = 'drivers';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_drv.txt';
force_download($name,$json);
}
function export_driver_csv(){
$database = 'arcanemobile';
$collection = 'drivers';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_drv.csv';
force_download($name,$json);
} //Export for driver
// Export for Transcation
function export_trans_txt(){
$database = 'arcanemobile';
$collection = 'trips';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_tnc.txt';
force_download($name,$json);
}
function export_trans_csv(){
$database = 'arcanemobile';
$collection = 'trips';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_tnc.csv';
force_download($name,$json);
} //Export for Transcation
// Export for Ride later
function export_ride_txt(){
$database = 'arcanemobile';
$collection = 'futurebook';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_ride_later.txt';
force_download($name,$json);
}
function export_ride_csv(){
$database = 'arcanemobile';
$collection = 'futurebook';
$m = new MongoClient();
$col = $m->selectDB($database)->$collection;
$json = json_encode(iterator_to_array($col->find()),JSON_PRETTY_PRINT);
$name='Doc_ride_later.csv';
force_download($name,$json);
} //Export for Ride later

function get_imei($imei)
	{
	
	  //$result = $this->mongo_db->db->riders->find(array("driverid"=>$driverid,"requesttime"=>array('$lt'=>time())))->sort(array('requesttime' => 1));
    $result = $this->mongo_db->db->riders->find(array("imei"=>$imei));
	return $result;
	
	}
	function empty_regid($_id,$regid)
	{
	$this->mongo_db->db->riders->update(array("_id"=>new MongoId($_id)),array('$set'=>array("regid"=>$regid,"imei"=>"nil","availability"=>"off")));
	
	}
	
	
function fare_calc_cat($carcategory)
	{
	/*
	$driver = $this->mongo_db->db->drivers->findOne(array("_id"=>new MongoId($driverid)));
		$carname=$driver['carname'];
		$carcategory=$driver['carcategory'];*/
	
	
	//$car = $this->mongo_db->db->car->findOne(array("carname"=>$carname,"category"=>$carcategory));
	$car = $this->mongo_db->db->category->findOne(array("categoryname"=>$carcategory));
	return $car;
	
	}
// Create new Promo code automatically	
	public function create_promocode($expire_date,$price,$promo_code)
	{

		$data = array(
							'id'         => NULL,
							'expire_in'       => $expire_date,
							'price'          => $price,
							'code'          => $promo_code,
							'send_status'=>0,
							'status' =>0

							);
		$result1 = $this->mongo_db->db->promocode->insert($data);
		//$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success','Promo Code Added successfully'));
		   //redirect('administrator/coupon/view_all_coupon');

	}
	
	
} /// Model ends here
?>