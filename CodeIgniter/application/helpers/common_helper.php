<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*===============================Subscription Funtion Starts Here======================*/





function checkSubscription()
{
	$CI = get_instance();
	$loginMemberGender = getUser('mem_gender'); //if gender is Female, dont apply subscription
	
	if($loginMemberGender=='female'){
		return FALSE;
	} else {
		
		$checkPromotionsApplied = checkPromotionsApplied(); 
		if($checkPromotionsApplied->apply_promotions==1){ //check if admin applied subscriptions
			
			$checkCurrentMonthPromo = checkCurrentMonthIsFree();
			if($checkCurrentMonthPromo->charge_subscription==1){ //check if current month is free or not
			
				$checkUserSubscribed = checkIfUserSubscribed();
				//var_dump($checkUserSubscribed);exit;
				if($checkUserSubscribed){ //check if user subscribed for current month or not
					return FALSE;
				} else {
					return TRUE;
				}
				
			} else {
				return FALSE;
			}
			
		} else {
			return FALSE;	
		}
	}
	
}

function checkIfUserSubscribed()
{
	$CI = get_instance();
	$CI->db->select("sub_id");
	$currentMonth = date('F');
	$currentYear = date('Y');
	$CI->db->like('sub_month',$currentMonth);
	$CI->db->where('sub_year',$currentYear);
	$CI->db->where('mem_id',$CI->session->userdata('mem_id'));
	$query = $CI->db->get('tbl_subscriptions');
	$SITE = $query->row();
	//var_dump($SITE);exit;
	if(!empty($SITE->sub_id)){
		return TRUE;
	} else {
		return FALSE;
	}
}

/*===============================Subscription Funtion Ends Here======================*/


function pr($ary)
{
	echo "<pre>";
	print_r($ary);
	echo "</pre>";
}

function getAppropriateStatus($status)
{
	if($status == '1'){
		return 'Reported as Inappropriate';
	}else{
		return 'Mark as Inappropriate';
	}
}

function getCountryFlagCodeForChat ($countryName){
	
	$CI = get_instance();
	$CI->db->select("country_flag");
	$CI->db->where('country_name',$countryName);
	$query = $CI->db->get('tbl_countries');
	$SITE = $query->row();
	return '<img src="'.base_url().'assets/flags/'.$SITE->country_flag.'.png">';
}

function countMyNewMessages ()
{
	$CI = get_instance();
	
	$session_data=$CI->session->userdata('logged_in');
    $user_id=$session_data['id'];
	
	$conversationsSql = 'select c.user1 as user1, c.id as conversation_id, c.user2 as user2 from tbl_conversation c WHERE c.user1="'.$user_id.'" OR c.user2="'.$user_id.'"';
		
		$query = $CI->db->query($conversationsSql);
		$conversations = $query->result();
		 $i=0;
		if(!empty($conversations)){
						$arrConversations = array();
						
						foreach($conversations as $con){
							 $sqlLatestMsg = 'select pm.conversation_id,pm.message_id from private_messages pm 
		where pm.conversation_id="'.$con->conversation_id.'" AND pm.message_read="0" 
		AND pm.sender_id!="'.$user_id.'"
		group by pm.conversation_id,pm.message_id
		order by pm.created desc'; // limit 1
							$latestMsgQuery = $CI->db->query($sqlLatestMsg);
							$getConversatonMessage = $latestMsgQuery->row();
							if(!empty($getConversatonMessage)){
								$i++;
							}
							
							
						}
						
		}
		//echo count($getConversatonMessage);
		return $i;
}
function getSite($field)
{
	$CI = get_instance();
	$CI->db->select($field);
	$query = $CI->db->get('siteadmin');
	$SITE = $query->row();
	return $SITE->$field;
}

function getPage($slug,$field)
{
	$CI = get_instance();
	$CI->db->select($field);
	$CI->db->where('slug',$slug);
	$query = $CI->db->get('tbl_contents');
	$SITE = $query->row();
	return $SITE->$field;
}
function getMemberByUsername($mem_username,$field)
{
	$CI = get_instance();
	$CI->db->select($field);
	$CI->db->where('mem_username',$mem_username);
	$query = $CI->db->get('tbl_members');
	$SITE = $query->row();
	return $SITE->$field;
}

function checkMemberExistsByUsername($mem_username)
{
	$CI = get_instance();
	//$CI->db->select($field);
	$CI->db->where('mem_username',$mem_username);
	$CI->db->where('mem_id !=',$CI->session->userdata('mem_id'));
	$query = $CI->db->get('tbl_members');
	$SITE = $query->row();
	if($SITE){
		return $SITE;
	} else {
		return false;
	}
	
}

function checkBlockedUsername($mem_username)
{
	$loginMemberUsername = getUser('mem_username');
	
	$otherUserId = getMemberByUsername($mem_username,'mem_id');
	
	$CI = get_instance();
	//$CI->db->select($field);
	$CI->db->where('block_username',$loginMemberUsername);
	$CI->db->where('mem_id',$otherUserId);
	$query = $CI->db->get('tbl_block_usernames');
	$SITE = $query->row();
	if($SITE){
		return true;
	} else {
		return false;
	}
	
}

function checkBlockedUsernameByMe($mem_username)
{	
	$CI = get_instance();
	//$CI->db->select($field);
	$CI->db->where('block_username',$mem_username);
	$CI->db->where('mem_id',$CI->session->userdata('mem_id'));
	$query = $CI->db->get('tbl_block_usernames');
	$SITE = $query->row();
	if($SITE){
		return true;
	} else {
		return false;
	}
	
}

function checkIfYouBlockedOtherUser ($mem_username)
{
	
	$CI = get_instance();
	//$CI->db->select($field);
	$CI->db->where('block_username',$mem_username);
	$CI->db->where('mem_id',$CI->session->userdata('mem_id'));
	$query = $CI->db->get('tbl_block_usernames');
	$SITE = $query->row();
	if($SITE){
		return true;
	} else {
		return false;
	}
}

function checkIfOtherUserBlockedYou ($mem_username, $mem_id)
{
	
	$CI = get_instance();
	//$CI->db->select($field);
	$CI->db->where('block_username',$mem_username);
	$CI->db->where('mem_id',$mem_id);
	$query = $CI->db->get('tbl_block_usernames');
	$SITE = $query->row();
	if($SITE){
		return true;
	} else {
		return false;
	}
}


function checkCommunicationFilters($viewed_mem_username)
{
	$CI = get_instance();
	
	$CI->db->where('mem_id',$CI->session->userdata('mem_id'));
	$query = $CI->db->get('tbl_communication_filters');
	$SITE = $query->row();
	if($SITE){
		$otherUserDetails = checkMemberExistsByUsername($viewed_mem_username);
		if($otherUserDetails){
			
			$memAge = getMemAge($otherUserDetails->mem_dob);
			if(!empty($SITE->block_marital_status) && $SITE->block_marital_status == $otherUserDetails->mem_martial_status){
				return true;
			} 
			elseif (!empty($SITE->block_have_children) && $SITE->block_have_children == $otherUserDetails->mem_have_children){
				return true;
			} 
			elseif(!empty($SITE->block_with_disabilities) && $SITE->block_with_disabilities == $otherUserDetails->mem_have_disabilities){
				return true;
			} 
			elseif(!empty($SITE->block_smokers) && $SITE->block_smokers == $otherUserDetails->mem_smoke_drink){
				return true;
			}
			elseif(!empty($SITE->block_older_age) && $SITE->block_older_age < $memAge){
				return true;
			} else {
				return false;
			}
		
		} else {
			return false;
		}
		var_dump($otherUserDetails);
	} else {
		return false;
	}
}

function getMember($mem_id)
{
	$CI = get_instance();
	$CI->db->select('*');
	$CI->db->where('id',$mem_id);
	$query = $CI->db->get('users');
	$SITE = $query->row();
	return $SITE;
}
function getPageData($slug)
{
	$CI = get_instance();
	$CI->db->where('slug',$slug);
	$query = $CI->db->get('tbl_contents');
	return $query->row();
}

function getCatName($cat_id)
{
	$CI = get_instance();
	$CI->db->select('cat_name');
	$CI->db->where('cat_id',$cat_id);
	$query = $CI->db->get('tbl_categories');
	$SITE = $query->row();
	return $SITE->cat_name;
}

function getWebsiteIcon($sit_id)
{
	$CI = get_instance();
	$CI->db->select('sit_image');
	$CI->db->where('sit_id',$sit_id);
	$query = $CI->db->get('tbl_websites');
	$SITE = $query->row();
	return $SITE->sit_image;
}
function getPanel($p_id, $field)
{
	$CI = get_instance();
	$CI->db->select($field);
	$CI->db->where('p_id',$p_id);
	$query = $CI->db->get('tbl_panels');
	$SITE = $query->row();
	return $SITE->$field;
	
}

function getImageSrc($image)
{
	if(is_file($image)) {
		return base_url().$image;
	}else{
		return base_url().'adminimages/no_image.jpg';
	}
}

function checkProfilePicExists ($mem_id)
{
	$CI = get_instance();
	$CI->db->select('img_id');
	$CI->db->where('mem_id',$mem_id);
	$CI->db->where('img_type','profile');
	$query = $CI->db->get('tbl_member_images');
	$profilePic = $query->row();
	return $profilePic;
}

/*function addProfileView($mem_id)
{
	$CI = get_instance();
}*/

function getMemProfilePhoto ($mem_id)
{
	$gender = getUserById($mem_id,'mem_gender');
	$CI = get_instance();
	//$CI->db->select('mem_gender');
	$CI->db->where('mem_id',$mem_id);
	$CI->db->where('img_type','profile');
	$query = $CI->db->get('tbl_member_images');
	$profilePic = $query->row();
	if($profilePic){
		
				if($profilePic->img_status == '0'){
					if($gender=='male'){
						$imgSrc = base_url().'assets/images/approval-male.jpg';
					} else {
						$imgSrc = base_url().'assets/images/approval-female.jpg';
					}
					
				} else {
					$imgSrc = base_url().'uploads/members/'.$profilePic->img_path;
				}
				
			} else {
				if($gender=='male'){
					$imgSrc = base_url().'assets/images/dummy-male.jpg';
				} else {
					$imgSrc = base_url().'assets/images/dummy-female.png';
				}
				
			}
	
	
	return $imgSrc;
}

function getMemPhoto($image,$mem_id = '',$mem_privacy = '')
{
	$CI = get_instance();
	$user_id = $CI->session->userdata('mem_id');
	
	$CI->db->select('mem_gender');
	$CI->db->where('mem_id',$mem_id);
	$query = $CI->db->get('tbl_members');
	$rs = $query->row();
	if($rs->mem_gender == 'male'):
		$noimage = base_url().'assets/images/no-image.jpg';
	else:
		$noimage = base_url().'assets/images/no-image-female.jpg';
	endif;
	
	if($user_id == $mem_id)
	{
		if(is_file($image)) {
			return base_url().$image;
		}else{
			return $noimage;
		}
		
	}
	else if($user_id != $mem_id)
	{
		$CI->db->select('noti_id');
		$CI->db->where(array('profile_id' => $mem_id,'mem_id' => $user_id, 'noti_type' => 'photo', 'noti_status' => '1'));	
		$query = $CI->db->get('notifications');
		if($query->row()):
			if(is_file($image)) {
				return base_url().$image;
			}else{
				return $noimage;
			}
		else:
			return $noimage;
		endif;		
	}else{
		return $noimage;
	}
	
}

function getUser($field)
{
	$CI = get_instance();
	$mem_id = $CI->session->userdata('mem_id');
	$CI->db->select($field);
	$CI->db->where('mem_id',$mem_id);
	$query = $CI->db->get('tbl_members');
	$SITE = $query->row();
	return $SITE->$field;
	
}

function getUserById($mem_id,$field)
{
	$CI = get_instance();
	$mem_id = $mem_id;
	$CI->db->select($field);
	$CI->db->where('mem_id',$mem_id);
	$query = $CI->db->get('tbl_members');
	$SITE = $query->row();
	return $SITE->$field;
	
}

function mem_martial()
{
	return $arry = array(
		'Never Married' => 'Never Married',
		'Married' => 'Married',
		'Widowed' => 'Widowed',
		'Divorced' => 'Divorced',
		'Seperated' => 'Seperated'
	);
}

function mem_serious()
{
	return $arry = array(
		'Very serious' => 'Very serious',
		'Some what and dont belive in them' => 'Some what and dont belive in them'
	);
}

function mem_reg_by()
{
	return $arry = array(
		'Self' => 'Self',
		'Parents' => 'Parents',
		'Guardians' => 'Guardians',
		'Friends' => 'Friends',
		'Others' => 'Others'
	);
}

function mem_ethnicity($val = '')
{
	$CI = get_instance();
	$CI->db->where('list_type','Ethnicity');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	if($val == ''){ return $array; }else{ return $array[$val]; }
	
}

function mem_denomination()
{
	$CI = get_instance();
	$CI->db->where('list_type','Denomination');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	return $array;
}

function mem_silsila()
{
	$CI = get_instance();
	$CI->db->where('list_type','Silsila');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	return $array;
}

function mem_salat()
{
	return $array = array(
		'5 Times' => '5 Times',
		'Does not pray' => 'Does not pray',
		'Friday Only' => 'Friday Only',
		'Eid Only' => 'Eid Only',
		'Couple of Times a week' => 'Couple of Times a week',
		'Once a day' => 'Once a day',
		'5 Times + Tahajud' => '5 Times + Tahajud'
	);
}

function mem_citizenship()
{
	$CI = get_instance();
	$CI->db->where('list_type','Citizenship');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	return $array;
}

function mem_education($val = '')
{
	$CI = get_instance();
	$CI->db->where('list_type','Education');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	if($val == ''){ return $array; }else{ return $array[$val]; }}

function mem_occupation($val = '')
{
	$CI = get_instance();
	$CI->db->where('list_type','Occupation');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	if($val == ''){ return $array; }else{ return $array[$val]; }
}

function mem_islamic_education($val = '')
{
	$CI = get_instance();
	$CI->db->where('list_type','Islamic%20Education');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	if($val == ''){ return $array; }else{ return $array[$val]; }
}


function mem_fasting()
{
	return $array = array(
		'Does not fast at all' => 'Does not fast at all',
		'Fast in Ramadan but not all' => 'Fast in Ramadan but not all',
		'Fast during entire Ramadan' => 'Fast during entire Ramadan',
		'Ramadan + Nafil' => 'Ramadan + Nafil'
	);
}

function mem_language()
{
	$CI = get_instance();
	$CI->db->where('list_type','Language');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	return $array;
}

function mem_country($val = '')
{	
	$CI = get_instance();
	$CI->db->where('list_type','Country');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	if($val == ''){ return $array; }else{ return $array[$val]; } 
}

function mem_height()
{
	return $array = array(
		'4.4' => 'Below 4ft 5in - 134.62cm',
		'4.5' => '4ft 5in - 134.62cm',
		'4.6' => '4ft 6in - 137.16cm',
		'4.7' => '4ft 7in - 139.7cm',
		'4.8' => '4ft 8in - 142.24cm',
		'4.9' => '4ft 9in - 144.78cm',
		'4.10' => '4ft 10in - 147.32cm',
		'4.11' => '4ft 11in - 149.86cm',
		'5' => '5ft - 152.4cm',
		'5.1' => '5ft 1in - 154.94cm',
		'5.2' => '5ft 2in - 157.48cm',
		'5.3' => '5ft 3in - 160.02cm',
		'5.4' => '5ft 4in - 162.56cm',
		'5.5' => '5ft 5in - 165.1cm',
		'5.6' => '5ft 6in - 167.64cm',
		'5.7' => '5ft 7in - 170.18cm',
		'5.8' => '5ft 8in - 172.72cm',
		'5.9' => '5ft 9in - 175.26cm',
		'5.10' => '5ft 10in - 177.8cm',
		'5.11' => '5ft 11in - 180.34cm',
		'6' => '6ft - 182.88cm',
		'6.1' => '6ft 1in - 185.42cm',
		'6.2' => '6ft 2in - 187.96cm',
		'6.3' => '6ft 3in - 190.5cm',
		'6.4' => '6ft 4in - 193.04cm',
		'6.5' => '6ft 5in - 195.58cm',
		'6.6' => '6ft 6in - 198.12cm',
		'6.7' => '6ft 7in - 200.66cm',
		'6.8' => '6ft 8in - 203.2cm',
		'6.9' => '6ft 9in - 205.74cm',
		'6.10' => '6ft 10in - 208.28cm',
		'6.11' => '6ft 11in - 210.82cm',
		'7' => '7ft - 213.36cm',
		'7.1' => '7ft - 213.36cm Plus'
	);
}

function mem_body()
{
	return $array = array(
			'Average' => 'Average',
			'Athletic' => 'Athletic',
			'Slim' => 'Slim',
			'Heavy' => 'Heavy'
	);
}

function mem_complexion()
{
	return $array = array(
			'Very Fair' => 'Very Fair',
			'Fair' => 'Fair',
			'Wheatish' => 'Wheatish',
			'Wheatish Brown' => 'Wheatish Brown',
			'Dark' => 'Dark'
	);
}

function mem_facial()
{
	return $array = array(
			'Clean Shave' => 'Clean Shave',
			'One fist according to Sunna' => 'One fist according to Sunna'
	);
}

function mem_hijab()
{
	return $array = array(
			'Burqa' => 'Burqa',
			'Niqab' => 'Niqab',
			'Hijab' => 'Hijab',
			'Dupatta' => 'Dupatta',
			'None' => 'None'
	);
}

function mem_parent_status()
{
	return $array = array(
			'Employed' => 'Employed',
			'Business' => 'Business',
			'Professional' => 'Professional',
			'Retired' => 'Retired',
			'Not employed' => 'Not employed',
			'Passed Away' => 'Passed Away'
	);
}

function mem_org()
{
	$CI = get_instance();
	$CI->db->where('list_type','Organization');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	return $array;
}

function mem_caste()
{
	$CI = get_instance();
	$CI->db->where('list_type','Caste');
	$query = $CI->db->get('tbl_lists');
	$rows = $query->result();
	foreach($rows as $row){
		$array[$row->list_key] = $row->list_value;  
	}
	
	return $array;
}



?>