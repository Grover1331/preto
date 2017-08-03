<?php 
include("../wp-config.php");
global $wpdb;
global $post;
$userID = $_GET['userID'];
$language = $_GET['language'];
$offSet = $_GET['offSet'];
$latti = $_GET['lattitude'];
$longi = $_GET['longitude'];



function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}



if($userID != "" || $language !="") {
	$author_obj = get_user_by('id', $userID);
	if(empty($author_obj)) {
		$json = array("success"=> 0,"result"=> 0 ,"error"=>"Invalid User");
	} else {
		$myLang = array();
		$results = $wpdb->get_results("SELECT * FROM `wtw_fav` where `user_id` = $userID");
		foreach ($results as $key => $value) {
			$categories = get_the_terms( $value->restaurand_id, 'language' );
			if($categories[0]->slug == $language) {
				$myLang[] = $value->restaurand_id;
			}
		}
		if(empty($myLang)) {
			$json = array("success" => 0, "result" => 0, "error" => "No Favourite Restaurants");
		} else {
			$menuItems = array_slice( $myLang, $offSet, 20 );
			query_posts( array (  'post_type' => 'restaurants', 'post__in' => $menuItems ,'showposts'=>-1) ); 
			while ( have_posts() ) : the_post();

				$wtw_foofitem = $wpdb->get_results("SELECT * FROM `wtw_foofitem` where `restID` = $post->ID");
				$typeOfFood = array();
				foreach ($wtw_foofitem as $key => $type) {
					$typeOfFood[] = $type->name;
				}
				$wtw_foofitem = $wpdb->get_results("SELECT * FROM `wtw_payment` where `restID` = $post->ID");
				$typeOfPayment = array();
				foreach ($wtw_foofitem as $key => $type) {
					$typeOfPayment[] = $type->name;
				}
				$wtw_facilities = $wpdb->get_results("SELECT * FROM `wtw_facilities` where `restID` = $post->ID");
				$typeOffac = array();
				foreach ($wtw_foofitem as $key => $type) {
					$typeOffac[] = $type->name;
				}
				$deliveryStatus = get_field("delivery_available" , $post->ID);
				$phone = get_field("phone" , $post->ID);
				$menu = get_field("menu" , $post->ID);
				$address = get_field("address" , $post->ID);
				$lattitude = get_field("lattitude" , $post->ID);
				$longitude = get_field("longitude" , $post->ID);
				$categorieRest = get_the_terms( $post->ID, 'restaurant_category' );
				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					if (is_array($image_url)) {
							$image_url=$image_url[0];
						} else  { 
							$image_url=""; 
						}
				$wtw_likes = $wpdb->get_var("SELECT count(`id`) FROM `wtw_likes` where `restaurand_id` = $post->ID");



				$newcurrentDate = date('d-m-Y');
					$newcurrentDateTime = date('d-m-Y H:i');
					$newtest = strtotime($newcurrentDateTime);
					$newget_currentTime = date('h:i A', strtotime($newcurrentDateTime));
					$newday = date('l', strtotime($newcurrentDateTime));
					$newresults = $wpdb->get_results("SELECT * FROM `wtw_deal_new_timing` WHERE deal_id = '$post->ID' AND `start_day` = '$newday'");
						$discountArray = array();
						foreach($newresults as $newresult) {
							$newstartDateTemp = $newcurrentDate." ".$newresult->start_time;
							$newstartDate = strtotime($newstartDateTemp);
							if ($newresult->end_day == $newday) {
							$newendDateTemp = $newcurrentDate." ".$newresult->end_time;
							$newendDate = strtotime($newendDateTemp);
							} else {
								$getNextDate = date('d-m-Y', strtotime("next ".$newresult->end_day));
								$newendDateTemp = $getNextDate." ".$newresult->end_time;
								$newendDate = strtotime($newendDateTemp);
							}
							$valueee = 0;
							$newdiscount = "";
							if (($newtest > $newstartDate) && ($newtest < $newendDate)) {
								// echo "Deal is Active Start Time ".$newstartDateTemp. " End Time is ".$newendDateTemp." And Current Date Time is ".$newcurrentDateTime;
								$valueee = 1;
								$time = $newresult->start_time." To ".$newresult->end_time;
							} else {
								 
							}
						}
						if($valueee == 1) {
							$newStat = "Yes";
							$timings = $time;
						} else {

							$newresultsCase = $wpdb->get_results("SELECT * FROM `wtw_deal_new_timing` WHERE deal_id = '$post->ID' AND `end_day` = '$newday'");
							foreach($newresultsCase as $newresultsCas) {
								if($newresultsCas->end_day != $newresultsCas->start_day) {
									$getNextDate = date('d-m-Y', strtotime("last ".$newresultsCas->end_day));
									$newstartDateTemp = $getNextDate." ".$newresultsCas->start_time;
									$newstartDate = strtotime($newstartDateTemp);

									$newendDateTemp = $newcurrentDate." ".$newresultsCas->end_time;
									$newendDate = strtotime($newendDateTemp);
									if (($newtest > $newstartDate) && ($newtest < $newendDate)) {
										// echo "Deal is Active Start Time ".$newstartDateTemp. " End Time is ".$newendDateTemp." And Current Date Time is ".$newcurrentDateTime;
										$valueee = 1;
										$time = $newresultsCas->start_time." To ".$newresultsCas->end_time;
									} else {

									}
									if($valueee == 1) {
										$newStat = "Yes";
										$timings = $time;
									} else {
										$newStat = "No";
								$timings = "";
									}

								} else {

									$newStat = "No";
								$timings = "";
								}
							}
						}

						if (empty($newresults)) {
								$newStat = "No";
								$timings = "";
							}



				if($latti != "" && $longi != "") {
					$distance =  distance($latti, $longi, $lattitude, $longitude, "K");
					$distance = (int)$distance;
				} else {
					$distance = "";
				}
				$myArray[] = array("restID" => $post->ID , "restName" => get_the_title() , "typeOfFood" => $typeOfFood , "description" => get_the_content() , "isHomeDeliveryAvailable" => $deliveryStatus , "paymentMethod" => $typeOfPayment , "phoneNumber" => $phone , "address" => $address , "category" => $categorieRest[0]->slug , "images" => $image_url , "isFavourite" => 1 , "likesCount" => $wtw_likes , "other" => $typeOffac , "menu" => $menu , "lattitude" => $lattitude , "longitude" => $longitude , "isActive" => $newStat , "operatingHours" => $timings , "distance" => $distance);
			endwhile; wp_reset_query();
			$json = array("success" => 1, "result" => $myArray, "error" => "No Error Found");
		}
		
	}
} else {
	$json = array("success" => 0, "result" => 0, "error" => "Parameter Missing");
}
echo json_encode($json);

 ?>