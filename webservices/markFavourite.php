<?php 
include("../wp-config.php");
$userID = $_GET['userID'];
$restID = $_GET['restID'];
if($userID != "" || $restID !="") {
	$author_obj = get_user_by('id', $userID);
	if(empty($author_obj)) {
		$json = array("success"=> 0,"result"=> 0 ,"error"=>"Invalid User");
	} else {
		$countt = $wpdb->get_var("SELECT count(`restaurand_id`) FROM `wtw_fav` where `user_id`=$userID AND `restaurand_id` = $restID");
		if($countt == 0) {
			$wpdb->insert( 'wtw_fav', array(
				'user_id' => $userID,
				'restaurand_id' => $restID)
			);
			$json = array("success"=> 1,"result"=> 1 ,"error"=>"No Error Found");
		} else {
			$wpdb->query("DELETE  FROM `wtw_fav` where `user_id`='$userID' AND `restaurand_id` = '$restID'");

			$json = array("success"=> 1,"result"=> 0 ,"error"=>"No Error Found");
		}
	}
} else {
	$json = array("success" => 0, "result" => 0, "error" => "Parameter Missing");
}
echo json_encode($json);
 ?>