<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_model extends Base_Common_Model {

    const CODE_CONTACT_MOBILE_INVALID           = 1001;
    const CODE_EMAIL_INVALID                    = 1002;
    const CODE_ACCOUNT_INVALID                  = 1003;
    
    const CODE_CONTACT_MOBILE_ALREADY_EXISTS    = 1004;
    const CODE_EMAIL_ALREADY_EXISTS             = 1005;
    const CODE_LOGIN_ACCOUNT_ALREADY_EXISTS     = 1006;
    
    const CODE_ACCOUNT_CREATED_SUCCESSFULLY     = 1007;
    const CODE_ACCOUNT_CREATED_FAILED           = 1008;
    const CODE_ACCOUNT_NOT_EXISTS               = 1009;
    
    const CODE_LOGIN_SUCCESS                    = 1010;
    const CODE_USERNAME_INVALID                 = 1021;
    const CODE_PASSWORD_INVALID                 = 1022;
    
    const CODE_INVALID_TOKEN                    = 1028;

//    const CODE_PASSWORD_EXPIRED = 1508;
//    const CODE_USER_NOT_FOUND   = 1020;
//    const CODE_USER_FOUND       = 1020;
//    const CODE_INVALID_GENDER   = 1025;
//
//    /////////Waitun
//    const CODE_DATA_LISTING     = 1023;
//    const CODE_INVALID_PASSWORD = 1015;
//    const CODE_INVALID_EMAIL    = 1002;
//    const CODE_INVALID_MOBILE   = 1001;
//    const CODE_INVALID_NRIC     = 1071;
//
//    const CODE_EMAIL_EXIST      = 1003;
//    const CODE_MOBILE_EXIST     = 1004;
//    const CODE_IDENTITY_EXIST   = 1016;
//    const CODE_MEMBER_LISTING   = 1036;
//    const CODE_MEMBER_NOT_FOUND   = 1020;
//    const CODE_MEMBER_PROFILE   = 1022;
//    const CODE_SWITCH_ACCOUNT   = 1038;
//    const CODE_EXCEED_AGE   = 1039;
//    const CODE_MEMBER_CONVERSION  = 1040;
//    const CODE_MEMBER_UPDATE   = 1041;
//    const CODE_MEMBER_DELETE   = 1042;
//    const CODE_MEMBER_SUSPEND   = 1045;
//    const CODE_MEMBER_REINSTATE   = 1055;
//    const CODE_ADMIN_LEVEL_2   = 1061;
//    const CODE_ADMIN_LEVEL_2_DELETE   = 1062;
//    const CODE_MEMBER_TERMINATE   = 1063;
//    const CODE_POSTAL_CODE_INFO = 1104;
//    const CODE_POSTAL_CODE_NOT_FOUND = 1106;
//    const CODE_EWALLET_CREATE  = 1046;
//    const CODE_EWALLET_FAIL  = 1047;
//    const CODE_EWALLET_NOT_FOUND  = 1048;
//    const CODE_EWALLET_LISTING  = 1049;
//    const CODE_EWALLET_PIN_CREATE  = 1050;
//    const CODE_EWALLET_PIN_FAIL  = 1051;
//    const CODE_EWALLET_PIN_UPDATE  = 1052;
//    const CODE_EWALLET_TOP_UP  = 1053;
//    const CODE_SHOPPING_CART_NOT_FOUND  = 1057;
//    const CODE_SHOPPING_CART_LISTING  = 1056;
//    const CODE_SHOPPING_CART_TOP_UP  = 1058;
//    const CODE_DEVICE_TOKEN_SUCCESSFUL  = 1059;
//    const CODE_DEVICE_TOKEN_DEREGISTER=1060;
//    const CODE_SHOPPING_CART_CLEAR  = 1064;
//    const CODE_SHOPPING_CART_ITEM_DELETE  = 1065;
//    const CODE_INITIAL_CREDIT = 1066;
//    const CODE_INITIAL_CREDIT_UPDATE = 1067;
//    const CODE_ACTIVITY_LISTING = 1068;
//    const CODE_ACTIVITY_NOT_FOUND = 1069;
//    const CODE_ACTIVITY_DETAIL = 1070;
//    const CODE_ORGANIZATION_LISTING = 1072;
//    const CODE_ORGANIZATION_NOT_FOUND = 1073;
//    const CODE_PARTICIPANT_LISTING = 1074;
//    const CODE_PARTICIPANT_NOT_FOUND = 1075;
//    const CODE_CONDITION_GROUP_LISTING = 1076;
//    const CODE_CONDITION_GROUP_NOT_FOUND = 1077;
//    const CODE_CONDITION_CODE_LISTING = 1078;
//    const CODE_CONDITION_CODE_NOT_FOUND = 1079;
//    const CODE_ROLE_LISTING = 1080;
//    const CODE_ROLE_NOT_FOUND = 1081;
//    const CODE_CREATE_ADD_ON = 1082;
//    const CODE_ADD_ON_FAIL = 1083;
//    const CODE_ADD_ON_LISTING = 1084;
//    const CODE_ADD_ON_NOT_FOUND = 1085;
//    const CODE_UPDATE_ADD_ON = 1086;
//    const CODE_UPDATE_ADD_ON_FAIL = 1087;
//    const CODE_ADD_ON_DETAIL = 1088 ;
//    const CODE_ADD_ON_DELETE = 1089 ;
//    const CODE_ACCOUNT_ADD_ON_CREATE = 1092;
//    const CODE_ACCOUNT_ADD_ON_FAIL = 1093 ;
//    const CODE_ADD_ON_NO_CONDITION = 1094 ;
//    const CODE_ADD_ON_NOT_APPLICABLE = 1096 ;
//    const CODE_PLATFORM_LISTING = 1101 ;
//    const CODE_PLATFORM_NOT_FOUND = 1102 ;
//    const CODE_RELATED_ACCOUNT_LISTING   = 1037;
//    const CODE_SINGPASS_VER = 1112;
//    const CODE_SINGPASS_VER_SUCCESS = 1113;
//    const CODE_PAYMENT_MODE = 1124;
//    const CODE_ORG_DETAIL = 1125;
//    const CODE_ORG_CREATE = 1126;
//    const CODE_ORG_EXIST = 1127;
//    const CODE_EMPLOYEE_EXIST = 1129;
//    const CODE_EMPLOYEE_IMPORT = 1130;
//    const CODE_EWALLET_TOPUP_FAIL = 1103;
//    const CODE_CHECKOUT_SP_SUCCESSFUL = 1200;
//    const CODE_CHECKOUT_SP_FAIL       = 1205;
//    const CODE_SHOPPING_CART_DETAIL = 1098 ;
//    const CODE_ACCOUNT_CREATE = 1005 ;
//    const CODE_MEMBER_SUSPEND_PENDING   = 1136;
//    const CODE_STAFF_NOT_FOUND   = 1140;
//    const CODE_APPROVE_STAFF   = 1139;
//    const CODE_ORGANIZATION_UPDATE   = 1144;
//    const CODE_SHOPPING_CART_ADD_ON  = 1095;
//    const CODE_ORGANIZATION_CONTACT_UPDATE   = 1146;
//    const CODE_CONTACT_PERSON_NOT_FOUND   = 1147;
//    const CODE_CONTACT_PERSON_CREATE   = 1148;
//    const CODE_CONTACT_PERSON_DELETE   = 1149;
//    const CODE_WITHDRAW_SUCCESS   = 1156;
//    const CODE_WITHDRAW_FAIL   = 1157;
//    const CODE_VENUE_LISTING   = 1159;
//    const CODE_VENUE_NOT_FOUND   = 1160;
//    const CODE_OTP_FAIL   = 1162;
//    const INCORRECT_PASSWORD = 'Incorrect Password';
//    const PASSWORD_SUCCESSFULL = 'Password has been changed Successfully';
//    const PASSWORD_FAIL = 'Password not updated';
//
//
//    //////
//    const SUSPEND_STATUS     = 'suspend_status';
//
//    const DEFAULT_PUBLIC_COUNTDOWN      = 'PT10M'; //10 minutes
//    const DEFAULT_PUBLIC_COUNTDOWN_POS  ='PT20M'; //10 minutes
//
//
//
//    ///////
//    //const COMMON_SERVICE_URL=  'http://10.0.20.49/common_service/index.php/';
//    //const S3_IMAGE_URL=  'https://s3-ap-southeast-1.amazonaws.com/sscdev/';
//    const admin_URL=  'http://10.208.74.7';
//    const S3_FOLDER = 'account';
//
//    //const S3_FOLDER = 'sscdev/account/';
//
//    /**
//     * Channel constants
//     */
//    const CHANNEL_PUBLIC_USER   = 'public_user';
//    const CHANNEL_EWALLET_CODE  = 'ewallet';
//    const CHANNEL_EWALLET_SSC_CODE = 'ssc_credit';
//    const CHANNEL_CORPORATE_USER   = 'corporate_user';
//    const CHANNEL_ORG_EWALLET_CODE     = 'org_ewallet';
//    const CHANNEL_ORG_CORPORATE_CODE   = 'org_corporate';
//
//
//    const TRUE_ACTIVE         = 'Y';
//    const FALSE_ACTIVE        = 'N';
//    const LOGIN_ACTION        = 'login';
//    const LOGOUT_ACTION       = 'logout';
//    const UNKNOWN_CITIZENSHIP = 'Unknown citizenship';
//
//    const PASS_FOLDER = 'vcard/o';
//    const ROLE_NON_MEMBER = '4';
//
//    /**
//     * Pass Constants
//     */
//    const PASS_PREFIX   = 'VCARD';
//
//     /**
//     * add on type
//     */
//    const ADD_ON_AGE         = '101';
//    const ADD_ON_DAY         = '102';
//    const ADD_ON_TIME        = '103';
//
//    const ACTION_CREATE = 'C';
//    const ACTION_UPDATE = 'U';
//    const ACTION_DELETE = 'D';
//
//
//    /**
//     * Function constants
//     */
//    const FUNCTION_REGISTER_USER    = 'register_user';
//    const FUNCTION_CREATE_ACTIVESG  = 'create_activitySG';
//    const FUNCTION_ADMIN_MEMBER_SEARCH  = 'admin_member_search';
//    const FUNCTION_UPDATE_PROFILE    = 'update_profile';
//    const FUNCTION_SUSPEND_STATUS    = 'get_suspend_status';
//
//
//     /**
//     * Segment
//     */
//     const SEG_WALLET_TOPUP    = '562';

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->db = $this->load->database('default', TRUE);
        
        $this->load->helper('string');
        $this->load->model('common_flag');
        $this->load->model('otp/otp_model');
    }

    public function generate_salt() {
        return random_string('alnum', 8);
    }

    public function generate_password($password, $salt) {
        $ps = $password . '.' . $salt;
        $password = sha1($ps);
        return $password;
    }

//    private function _count_error_login($uid, $account_id = null)
//    {
//        $this->db->select('count(id) as count');
//        $this->db->from('wa.common_log');
//        $this->db->where('uid', $uid);
//        $this->db->where('action', Common_flag::COMMON_LOG_ACTION_LOGIN_FAILD);
//        $this->db->where(sprintf('id > IFNULL((SELECT id FROM wa.common_log WHERE uid = %s AND action = \'%s\' ORDER BY id DESC LIMIT 1),0)',$uid,Common_flag::COMMON_LOG_ACTION_LOGIN));
//        
//        $query = $this->db->get();
//        
//        if ($query && $query->num_rows()) {
//            return (int) $query->row()->count;
//        } else {
//            return 0;
//        }
//    }

    
    
    /* ************************************************************************************************** */
    
    private function _login($username, $password, $isAdmin = false, $login_type = Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE) {
        
        // security in place
        $username = $this->mmsencrypt->hash($username.$login_type);

        $now = date('Y-m-d H:i:s');

        $this->db->select('la.id as login_account_id, la.user_name, la.`password`, la.uid');
        $this->db->select('u.salt, u.`name`, u.is_admin, u.mebership_id');
        $this->db->from('wa.login_account as la');
        $this->db->join('wa.user as u', 'u.id = la.uid');
        $this->db->where('la.user_name', $username);
        $this->db->where('la.is_active', Common_flag::LOGIN_ACCOUNT_IS_ACTIVE_ACTIVE);

        if (isset($login_type)) {
            $this->db->where('la.login_type', $login_type);
        }

        $this->db->where('la.deleted_at IS NULL');
        $this->db->where('u.deleted_at IS NULL');
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            
            $result = $query->row();
            if ($isAdmin) {
                if ($result->is_admin != Common_flag::FLAG_YES_TINYINT) {
                    $this->response_message->set_message_with_code(self::CODE_USERNAME_INVALID);
                    return FALSE;
                }
            } else {
                if ($result->is_admin != Common_flag::FLAG_NO_TINYINT) {
                    $this->response_message->set_message_with_code(self::CODE_USERNAME_INVALID);
                    return FALSE;
                }
            }
            

            $saltedPassword = $this->generate_password($password, $result->salt);
            $ipAddress = $this->get_ip_address();

            // check the password
            if ($result->password != $saltedPassword) {
                // need to log as invalid
                $this->common_log($result->login_account_id, $result->uid, $ipAddress, common_flag::COMMON_LOG_ACTION_LOGIN_FAILD);
                
                //check max login faild count
                

                $this->response_message->set_message_with_code(self::CODE_PASSWORD_INVALID);
                return FALSE;
            }

            $this->common_log($result->login_account_id, $result->uid, $ipAddress, Common_flag::COMMON_LOG_ACTION_LOGIN);

            $access_token = $this->generate_token();
            $data_result = array();
            $data_result['access_token'] = $access_token;

            if (!$this->check_accesstoken($result->login_account_id)) {
                $data = array();
                $data['account_id'] = $result->login_account_id;
                $data['access_token'] = $access_token;
                $data['created_at'] = $now;

                //Save to database
                $account_id = $this->common_add('wa.access_token', $data);
            }

//            //SSO LOGIN
//            $data_acc = $this->get_all_accountid_by_user($result->uid);
//            if ($data_acc) {
//                foreach ($data_acc as $row_cer) {
//                    $a_id = $row_cer['id'];
//                    $this->common_edit('wa.access_token', 'account_id', $a_id, $data_result);
//                }
//            } else {
//                $this->common_edit('wa.access_token', 'account_id', $result->login_account_id, $data_result);
//            }
            
            $this->common_edit('wa.access_token', 'account_id', $result->login_account_id, $data_result);

            $accessToken = $access_token;

            $results = array();
            $results['token'] = $access_token;
            $results['name'] = $result->name;
            $results['mebership_id'] = $result->mebership_id;
            if($isAdmin)
                $results['is_admin'] = $isAdmin;

            $this->response_message->set_message_with_code(self::CODE_LOGIN_SUCCESS, array(RESULTS => $results));
            return TRUE;
        } else {
            $this->response_message->set_message_with_code(self::CODE_USERNAME_INVALID);
            return FALSE;
        }
    }

    public function admin_login($username, $password, $loginType) {
        
        return $this->_login($username, $password, true, $loginType);
    }

    public function user_login($username, $password, $login_type) {
        return $this->_login($username, $password, false, $login_type);
    }
    
    public function login_account_exists($username, $login_type = Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE){
        
        $username = $this->mmsencrypt->hash($username.$login_type);
        
        $this->db->select('la.id as login_account_id, la.user_name, la.`password`, la.uid');
        $this->db->from('wa.login_account as la');
        $this->db->where('la.user_name', $username);
        $this->db->where('la.is_active', Common_flag::LOGIN_ACCOUNT_IS_ACTIVE_ACTIVE);
        if (isset($login_type)) {
            $this->db->where('la.login_type', $login_type);
        }
        $this->db->where('la.deleted_at IS NULL');
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE){
                $this->response_message->set_message_with_code(self::CODE_CONTACT_MOBILE_ALREADY_EXISTS);
            }
            else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_EMAIL){
                $this->response_message->set_message_with_code(self::CODE_EMAIL_ALREADY_EXISTS);
            }
//            else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_USERNAME){
//                $this->response_message->set_message_with_code(self::CODE_LOGIN_ACCOUNT_ALREADY_EXISTS);
//            }
//            else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_WECHAT){
//                $this->response_message->set_message_with_code(self::CODE_LOGIN_ACCOUNT_ALREADY_EXISTS);
//            }
//            else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_QQ){
//                $this->response_message->set_message_with_code(self::CODE_LOGIN_ACCOUNT_ALREADY_EXISTS);
//            }
//            else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_WEIBO){
//                $this->response_message->set_message_with_code(self::CODE_LOGIN_ACCOUNT_ALREADY_EXISTS);
//            }
//            else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_FACEBOOK){
//                $this->response_message->set_message_with_code(self::CODE_LOGIN_ACCOUNT_ALREADY_EXISTS);
//            }
            else {
                $this->response_message->set_message_with_code(self::CODE_LOGIN_ACCOUNT_ALREADY_EXISTS);
            }
            return TRUE;
        }
        $this->response_message->set_message_with_code(self::CODE_ACCOUNT_NOT_EXISTS);
        return FALSE;
    }
    
    public function send_otpcode($otpType, $username, $contact_mobile, $email, $uid) {
        
        $params['expired_at'] = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s'))));
        $params['code']       = $this->otp_model->get_otp_code();
        
        $code                 = $params['code'];
        
        switch($otpType){
            case Common_flag::OTP_TYPE_SMS:
                $this->is_required($this->input->post(), array('contact_mobile'));
                $contact_mobile = $this->input->post('contact_mobile');
                
                
                break;
            case Common_flag::OTP_TYPE_EMAIL:
                $this->is_required($this->input->post(), array('email'));
                $email = $this->input->post('email');
                
                break;
            default:
                break;
        }

				

				
//
//				if(isset($msg->otp_subject))
//				{
//					$subject = $msg->otp_subject;
//				}
//				else
//				{
//					$subject = "One Time Password";
//				}
//
//				if(isset($msg->otp_content))
//				{
//					$msg = sprintf($msg->otp_content, $code);
//				}
//				else
//				{
//					$msg = "Your OTP code is " . $code;
//				}
//
//				$value = $this->common_config_model->get_core_config_data(self::NO_REPLY_EMAIL);
//				if($value)
        
    }
    
    public function create_user($data_user, $data_login_account){
        
        $uid = $this->common_add('wa.user',$data_user);
        
        if($uid){
            $data_login_account['uid'] = $uid;
            $login_account_id = $this->common_add('wa.login_account',$data_login_account);
            
            if($login_account_id){
                $this->response_message->set_message_with_code(self::CODE_ACCOUNT_CREATED_SUCCESSFULLY, array(RESULTS => $data_result));
            }
            else{
                $this->common_delete_logic('wa.login_account',$data_login_account);
                $this->response_message->set_message_with_code(self::CODE_ACCOUNT_CREATED_FAILED);
            }
        }
        else{
            $this->response_message->set_message_with_code(self::CODE_ACCOUNT_CREATED_FAILED);
            return FALSE;
        }
        return $uid;
    }

//    public function otp_send(){
//        $this->is_required($this->input->post(), array('otp_type', 'profile_id'));
//
//		$otpType = $this->input->post('otp_type');
//        $profileId = $this->input->post('profile_id');
//
//		$params['expired_at'] = date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime(date('Y-m-d H:i:s'))));
//		$params['code']       = $this->otp_model->get_otp_code();
//		$code                 = $params['code'];
//
//
//        $this->load->library('MMSEncrypt');
//		switch ($otpType)
//		{
//			case EMAIL:
//
//				$this->is_required($this->input->post(), array('email'));
//
//				$useremail = $this->input->post('email');
//
//				// get the OTP content from Database
//				$msg = $this->otp_model->get_otp_content();
//
//				if(isset($msg->otp_subject))
//				{
//					$subject = $msg->otp_subject;
//				}
//				else
//				{
//					$subject = "One Time Password";
//				}
//
//				if(isset($msg->otp_content))
//				{
//					$msg = sprintf($msg->otp_content, $code);
//				}
//				else
//				{
//					$msg = "Your OTP code is " . $code;
//				}
//
//				$value = $this->common_config_model->get_core_config_data(self::NO_REPLY_EMAIL);
//				if($value)
//		
//    }
//    
//    public function otp_validate(){
//        
//    }
    
    
    
    
    
    
    
    
//    ////common use
//    public function get_combo_data($para) {
//        $this->db->select('code_name as id,display_name');
//
//        $this->db->from('ssc_common.cd_sys_code');
//        $this->db->where('code_name', $para);
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return @$query->row()->display_name;
//        } else {
//            return NULL;
//        }
//    }
//    
//    /**
//     * @since  Modified 18 Dec, access control with timing
//     * @param  [type] $profile_id [description]
//     * @return [type]             [description]
//     */
//    public function get_admin_venue($profile_id) {
//        $venues = $this->subscriberVenueListing($profile_id);
//
//        if ($venues) {
//            $message = $this->common_config_model->get_message(self::CODE_VENUE_LISTING);
//            $this->response_message->set_message(self::CODE_VENUE_LISTING, $message, array(RESULTS => $venues));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_VENUE_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_VENUE_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     *
//     * Copied from public app -> Admin_account_model
//     * with little modification
//     *
//     */
//
//    /**
//     * Temporary, since this is another module
//     * can be cached
//     */
//    protected function venueBookingOfficeListing() {
//        $cacheKey = __METHOD__ . '_ALL';
//
//        if (!$result = $this->get_elasticache($cacheKey)) {
//            $result = $this->__venueBookingOfficeListing();
//            $this->set_elasticache($cacheKey, $result);
//        }
//
//        return $result;
//    }
//
//    protected function __venueBookingOfficeListing() {
//        // $this->db = $this->load->database('ssc_fac', TRUE);
//
//        $this->db->select('venue_id, name');
//        $this->db->from('ssc_fac.fac_venue');
//        $this->db->where('deleted_at IS NULL');
//        $this->db->where('is_active', 'Y');
//        // $this->db->where('is_booking_office', 'Y');
//        $this->db->order_by('name', 'ASC');
//
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        } else {
//            return false;
//        }
//    }
//
//    protected function subscriberVenueListing($subcriberId) {
//        $bookingOffices = $this->venueBookingOfficeListing();
//        $subcriberVenues = $this->subscriberVenueMapping($subcriberId);
//
//        if ($subcriberVenues && $bookingOffices) {
//            $subcriberVenuesIds = array();
//
//            foreach ($subcriberVenues as $venue) {
//                $subcriberVenuesIds[] = $venue['venue_id'];
//            }
//
//            $venues = array();
//
//            foreach ($bookingOffices as $office) {
//                if (in_array($office['venue_id'], (array) $subcriberVenuesIds)) {
//                    $venues[] = $office;
//                }
//            }
//
//            return $venues;
//        } else {
//            return array();
//        }
//    }
//
//    protected function subscriberVenueMapping($subcriberId) {
//        $this->db->select('sumv.fac_venue_id as venue_id');
//        $this->db->select('effective_from, effective_to');
//        $this->db->from('subscriber_user AS su');
//        $this->db->join('subscriber_user_map_venue AS sumv', 'su.id = sumv.subscriber_user_id');
//        $this->db->where('su.profile_id', $subcriberId);
//        $this->db->where('su.deleted_at IS NULL');
//        $this->db->where('sumv.deleted_at IS NULL');
//        $this->db->where(sprintf('(effective_from <= "%s" OR effective_from IS NULL)', $this->_getNow()));
//        $this->db->where(sprintf('(effective_to   >= "%s" OR effective_to IS NULL)', $this->_getNow()));
//
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        } else {
//            return false;
//        }
//    }
//
//    private $date;
//
//    protected function _getNow() {
//        if (is_null($this->date)) {
//            $this->date = new DateTime();
//        }
//
//        return $this->date->format('Y-m-d H:i:s');
//    }
//
    /**
     *
     * End Copied from public app -> Admin_account_model
     *
     */
    public function get_all_accountid_by_user($uid) {

        $this->db->select('id, user_name, password, uid');
        $this->db->from('wa.login_account');
        $this->db->where('uid', $uid);
        $this->db->where('deleted_at is NULL');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

//
//    /**
//     * @author YE LIN HTUN
//     * @since 3 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function account_search($keyword) {
//        $this->db->select('u.id,u.name,u.id_type,u.identity_number,u.objectives,u.address,u.gender,u.citizenship_id as citizenship,u.race_id as race,u.dob,u.preferred_contact_mode_id as preferred_contact_mode,u.profile_picture,u.email,u.contact_mobile,u.employment_status_id,pur.role_name,pur.id as role_id,u.sports_interest_other,u.postal_code,u.verified_singpass');
//
//        $this->db->from('ssc_member.login_account AS la');
//        $this->db->join('ssc_member.user_profile AS u', 'u.id = la.profile_id');
//        $this->db->join('ssc_member.public_user_map_role AS pumr', 'pumr.profile_id = u.id');
//        $this->db->join('ssc_member.public_user_role AS pur', 'pumr.role_id = pur.id');
//
//        $where = "(u.name LIKE '%$keyword%' OR u.identity_number LIKE '$keyword' OR u.email LIKE '$keyword' OR u.contact_mobile LIKE '$keyword')";
//        $this->db->where($where);
//        $this->db->where('la.verified', self::TRUE_ACTIVE);
//        $this->db->where('la.deleted_at', NULL);
//        $this->db->where('u.deleted_at', NULL);
//        $this->db->where('pumr.deleted_at', NULL);
//        $this->db->where('pur.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//
//            foreach ($query->result_array() as $row_cer) {
//
//                $profile_id = $row_cer['id'];
//                if (@$row_cer['id_type']) {
//                    $para = $row_cer['id_type'];
//                    $row_cer['id_type'] = $this->get_combo_data($para);
//                }
//                if (@$row_cer['race']) {
//                    $para = $row_cer['race'];
//                    $row_cer['race'] = $this->get_combo_data($para);
//                }
//                if (@$row_cer['citizenship']) {
//                    $para = $row_cer['citizenship'];
//                    $row_cer['citizenship'] = $this->get_combo_data($para);
//                }
//                if (@$row_cer['preferred_contact_mode']) {
//                    $para = $row_cer['preferred_contact_mode'];
//                    $row_cer['preferred_contact_mode'] = $this->get_combo_data($para);
//                }
//
//                if (@$row_cer['employment_status_id']) {
//                    $para = $row_cer['employment_status_id'];
//                    $row_cer['employment_status_id'] = $this->get_combo_data($para);
//                }
//            }
//            /////Get sport interest
//            $this->db->select('s.category_id as id,s.category_name as display_name');
//            $this->db->from('ssc_member.account_sports_interest a');
//            $this->db->join('ssc_fac.fac_activity_category s', 's.category_id = a.sports_interest_id');
//            $this->db->where('s.deleted_at is NULL');
//            $this->db->where('a.deleted_at is NULL');
//            $this->db->where('a.profile_id', $profile_id);
//            $query1 = $this->db->get();
//            if ($query1->num_rows() > 0) {
//                $row_cer['sports_interest'] = $query1->result_array();
//            } else {
//                $row_cer['sports_interest'] = '';
//            }
//
//            //return $query->row();
//            $image = $this->get_folders(self::S3_FOLDER);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_PROFILE);
//            $this->response_message->set_message(self::CODE_MEMBER_PROFILE, $message, array(RESULTS => $row_cer, FOLDER => $image));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author YE LIN HTUN
//     * @since 3 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function account_list_search($keyword, $limit, $page) {
//        $offset = ($page - 1) * $limit;
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email,
//                            up.contact_mobile,
//                            up.contact_home,
//                            up.address,
//                            up.occupation,
//                            up.salutation,
//                            up.objectives,
//                            up.gender,
//                            up.identity_number,
//                            up.dob,
//                            up.sports_interest_other,
//                            up.verified,
//                            up.citizenship_id,
//                            pur.role_name,
//                            pur.id AS role_id');
//
//        $this->db->from('ssc_member.login_account AS la');
//        $this->db->join('ssc_member.user_profile AS up', 'up.id = la.profile_id');
//        $this->db->join('ssc_member.public_user_map_role AS pumr', 'pumr.profile_id = up.id');
//        $this->db->join('ssc_member.public_user_role AS pur', 'pumr.role_id = pur.id');
//
//        $where = "(up.name LIKE '%$keyword%' OR up.email LIKE '%$keyword%' OR up.contact_mobile LIKE '%$keyword%')";
//        $this->db->where($where);
//        $this->db->where('la.verified', self::TRUE_ACTIVE);
//        $this->db->where('la.deleted_at', NULL);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('pumr.deleted_at', NULL);
//        $this->db->where('pur.deleted_at', NULL);
//
//        $this->db->limit($limit, $offset);
//
//        $this->db->group_by("la.profile_id");
//        $this->db->order_by("up.name", "ASC");
//
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            $rows = $query->result();
//            $result = array();
//
//            foreach ($rows as $value) {
//                $value->citizenship_name = self::UNKNOWN_CITIZENSHIP;
//
//                // currently loyality and ewallet point return 0
//                // need to update
//                $value->loyality_point = 0;
//                $value->ewallet = 0;
//
//                if (isset($value->citizenship_id)) {
//                    $this->db->select('display_name');
//                    $this->db->from('ssc_common.cd_sys_code');
//                    $this->db->where('id', $value->citizenship_id);
//                    $sysCode = $this->db->get();
//
//                    if ($sysCode->num_rows() > 0) {
//                        $sysCodeRow = $sysCode->row();
//                        if (isset($sysCodeRow->display_name)) {
//                            $value->citizenship_name = $sysCodeRow->display_name;
//                        }
//                    }
//                }
//            }
//
//            $message = $this->common_config_model->get_message(self::CODE_USER_FOUND);
//            $this->response_message->set_message(self::CODE_USER_FOUND, $message, array(RESULTS => $rows));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author YE LIN HTUN
//     * @since 3 FEB 2014
//     *
//     * @param int $accountId
//     * @param string $ipAddress
//     * @param string $action
//     */
//    private function _login_log($accountId, $profileId, $ipAddress, $action) {
//        $this->db->set('account_id', $accountId);
//        $this->db->set('ip_address', $ipAddress);
//        $this->db->set('profile_id', $profileId);
//        $this->db->set('action', $action);
//        $this->db->set('created_at', date('Y-m-d H:i:s'));
//
//        $this->db->insert('ssc_member.login_log');
//    }
//
//
//    /**
//     * Get the Unique access token
//     *
//     * @author YE LIN HTUN
//     * @since 3 FEB 2014
//     *
//     * @return string
//     */
//    private function _get_unique_access_token() {
//        $flag = TRUE;
//        do {
//            $accessToken = $this->generate_token();
//            $this->db->select('*');
//
//            $this->db->from('ssc_member.access_token');
//
//            $this->db->where('deleted_at', NULL);
//            $this->db->where('access_token', $accessToken);
//
//            $query = $this->db->get();
//
//            if ($query->num_rows() > 0) {
//                $flag = TRUE;
//            } else {
//                $flag = FALSE;
//            }
//        } while ($flag);
//
//        return $accessToken;
//    }
//
//    public function check_otp($isEmail, $otpCode) {
//        $now = date('Y-m-d H:i:s');
//        $this->db->select('*');
//
//        $this->db->from('user_profile');
//
//        if ($isEmail) {
//            $this->db->where('email_verification_code', $otpCode);
//            $this->db->where('email_verification_code_expiry_at <=', $now);
//        } else {
//            $this->db->where('contact_verification_code', $otpCode);
//            $this->db->where('contact_verification_code_expiry_at <=', $now);
//        }
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $temp = array(
//                STATUS_CODE => '1000',
//                'message' => ''
//            );
//
//            $this->response_message->set_error_message();
//            return $query->row();
//        } else {
//            $this->set_error_message('400', 'error');
//            return FALSE;
//        }
//    }
//
//    public function verified_opt($isEmail, $userId) {
//        $params['amended_date'] = date('Y-m-d H:i:s');
//
//        if ($isEmail) {
//            $params['email_is_verified'] = 1;
//        } else {
//            $params['contact_is_verified'] = 1;
//        }
//
//        $this->db->where('id', $userId);
//        if ($this->db->update('user_profile', $params)) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    /////////////////////////////////Wai Tun/////////////////////////////////////////////
//

    public function check_unique($contact_mobile = NULL, $email = NULL) {
        
        if ($contact_mobile) {
            $contact_mobile_hashmap = $this->mmsencrypt->hash($contact_mobile);
            
            $this->db->select('id');
            $this->db->from('wa.user');
            $this->db->where('deleted_at is NULL');
//            $this->db->where('contact_mobile', $contact_mobile);
            $this->db->where('contact_mobile_hashmap', $contact_mobile_hashmap);
            $this->db->limit(1);
            
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $this->response_message->set_message_with_code(self::CODE_CONTACT_MOBILE_ALREADY_EXISTS);
                return TRUE;
            }
        }
        
        if ($email) {
            $email_hashmap = $this->mmsencrypt->hash($email);
            
            $this->db->select('id');
            $this->db->from('wa.user');
            $this->db->where('deleted_at is NULL');
//            $this->db->where('email', $email);
            $this->db->where('email_hashmap', $email_hashmap);
            $this->db->limit(1);
            
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
//                return $query->row();
                $this->response_message->set_message_with_code(self::CODE_EMAIL_ALREADY_EXISTS);
                return TRUE;
            }
        }

        return FALSE;
    }
    
    
//
//    public function check_unique_email($email) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('email', $email);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_unique_emailbyid($email, $profile_id) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('email', $email);
//        $this->db->where('id !=', $profile_id);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_EMAIL_EXIST);
//            $this->response_message->set_message(self::CODE_EMAIL_EXIST, $message);
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_unique_identity($identity_number) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('identity_number', $identity_number);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_IDENTITY_EXIST);
//            $this->response_message->set_message(self::CODE_IDENTITY_EXIST, $message);
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_unique_mobilenumber($contact_mobile) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('contact_mobile', $contact_mobile);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_MOBILE_EXIST);
//            $this->response_message->set_message(self::CODE_MOBILE_EXIST, $message);
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_unique_mobilenumberbyid($contact_mobile, $profile_id) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('contact_mobile', $contact_mobile);
//        $this->db->where('id !=', $profile_id);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_MOBILE_EXIST);
//            $this->response_message->set_message(self::CODE_MOBILE_EXIST, $message);
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_facebook($facebook_id) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('facebook_id', $facebook_id);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    /**
//     * [get_admin_username description]
//     * @return [type] [description]
//     */
//    public function get_admin_login_profile_by_username($userName) {
//        $this->db->select(' la.id AS login_account_id,
//                        la.user_name,
//                        la.profile_id,
//                        up.salt,
//                        up.name,
//                        up.email
//                        ');
//        $this->db->select('su.status, la.expired_at');
//        $this->db->from('login_account AS la');
//        $this->db->join('user_profile AS up', 'up.id = la.profile_id');
//        $this->db->join('subscriber_user AS su', 'su.profile_id = up.id');
//        $this->db->where('la.user_name', $userName);
//        $this->db->where('la.active', 'Y');
//        $this->db->where('la.deleted_at IS NULL');
//        $this->db->where('up.deleted_at IS NULL');
//        $this->db->where('su.deleted_at IS NULL');
//        $this->db->limit(1);
//
//        $query = $this->db->get();
//
//        if ($query && $query->num_rows()) {
//            $result = $query->row();
//            return $result;
//        } else {
//            return false;
//        }
//    }
//
//
//    public function generate_salt() {
//        return random_string('alnum', 8);
//    }
//
//    public function find_salt($user_name) {
//        $this->db->select('salt');
//        $this->db->from('ssc_member.login_account l');
//        $this->db->join('ssc_member.user_profile u', 'u.id = l.profile_id');
//
//        $this->db->where('user_name', $user_name);
//        $this->db->where('l.deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->salt;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function get_account_contact($profile_id) {
//        $this->db->select('email,contact_mobile,address,facebook_id,identity_number,salt,house_block_no,street_name,floor_no,unit_no,building_name,postal_code');
//        $this->db->from('user_profile');
//
//        $this->db->where('id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    // need to separate this since its a different from public user
//    public function get_admin_profile($profile_id) {
//        $result = $this->_get_admin_profile($profile_id);
//
//        if ($result) {
//            // #6580
//            if (stripos($result['role_types'], 'SYSTEM_ADMIN') !== false) {
//                $result['is_system_admin'] = 'Y';
//            } else {
//                $result['is_system_admin'] = 'N';
//            }
//
//            // we dont need this, right?
//            unset($result['role_types']);
//
//            $image = $this->get_folders(self::S3_FOLDER);
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_PROFILE);
//            $this->response_message->set_message(self::CODE_MEMBER_PROFILE, $message, array(RESULTS => $result, FOLDER => $image));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function _get_admin_profile($profile_id) {
//        // $this->db->select('u.id, u.name, u.email');
//        // // $this->db->select("GROUP_CONCAT(DISTINCT aumr.role_id
//        //              // ORDER BY aumr.role_id ASC SEPARATOR ',') AS role_ids");
//        // $this->db->select('GROUP_CONCAT(DISTINCT arm.role_type) AS role_types');
//        // $this->db->from('ssc_member.user_profile u');
//        // $this->db->join('ssc_member.subscriber_user su', 'u.id = su.profile_id');
//        // $this->db->join('ssc_member.admin_user_map_role aumr', 'aumr.profile_id = su.profile_id', 'left');
//        // $this->db->join('ssc_member.admin_role_master arm', 'arm.role_id = aumr.role_id', 'left');
//        // $this->db->where('u.id', $profile_id);
//        // $this->db->where('u.deleted_at is NULL');
//        // $this->db->where('su.deleted_at is NULL');
//
//
//        $slq = "SELECT
//                    u.id,
//                    u.name,
//                    u.email,
//                    GROUP_CONCAT(DISTINCT arm.role_type) AS role_types
//                FROM
//                    ssc_member.user_profile u
//                JOIN ssc_member.subscriber_user su ON u.id = su.profile_id
//                LEFT JOIN ssc_member.admin_user_map_role aumr ON aumr.profile_id = su.profile_id
//                LEFT JOIN ssc_member.admin_role_master arm ON arm.role_id = aumr.role_id
//                WHERE
//                    u.id = $profile_id
//                AND u.deleted_at IS NULL
//                AND su.deleted_at IS NULL";
//
//        // $query   = $this->db->get();
//
//        $query = $this->db->query($slq);
//
//
//        if ($query->num_rows() > 0) {
//            $result = $query->row_array();
//            return $result;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function get_profile($profile_id) {
//        $this->db->select('u.id,u.name,u.id_type,u.identity_number,u.objectives,u.postal_code,u.house_block_no,u.street_name,u.floor_no,u.unit_no,u.building_name,u.gender,u.citizenship_id as citizenship,u.race_id as race,u.dob,u.preferred_contact_mode_id as preferred_contact_mode,u.profile_picture,u.email,u.contact_mobile,u.employment_status_id,r.role_name,r.id as role_id,u.sports_interest_other,u.postal_code,u.dnc_email,u.dnc_mobile_number,u.dnc_phone_call,u.dnc_postage_mail,u.verified_singpass');
//        $this->db->select('u.channel_id, u.created_at');
//        $this->db->from('ssc_member.user_profile u');
//        $this->db->join('ssc_member.public_user_map_role pr', 'u.id = pr.profile_id');
//        $this->db->join('ssc_member.public_user_role r', 'r.id = pr.role_id');
//
//        $this->db->where('u.id', $profile_id);
//        $this->db->where('u.verified', 'Y');
//        $this->db->where('u.deleted_at is NULL');
//        $this->db->where('r.deleted_at is NULL');
//        $this->db->where('pr.deleted_at is NULL');
//
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//
//            foreach ($query->result_array() as $row_cer) {
//                if (@$row_cer['id_type']) {
//                    $para = $row_cer['id_type'];
//                    $row_cer['id_type'] = $this->get_combo_data($para);
//                }
//                if (@$row_cer['race']) {
//                    $para = $row_cer['race'];
//                    $row_cer['race'] = $this->get_combo_data($para);
//                }
//                if (@$row_cer['citizenship']) {
//                    $para = $row_cer['citizenship'];
//                    $row_cer['citizenship'] = $this->get_combo_data($para);
//                }
//                if (@$row_cer['preferred_contact_mode']) {
//                    $para = $row_cer['preferred_contact_mode'];
//                    $row_cer['preferred_contact_mode'] = $this->get_combo_data($para);
//                }
//
//                if (@$row_cer['employment_status_id']) {
//                    $para = $row_cer['employment_status_id'];
//                    $row_cer['employment_status_id'] = $this->get_combo_data($para);
//                }
//
//                //////contact mobile
//                if (!@$row_cer['contact_mobile']) {
//                    $this->db->select('s.contact_mobile');
//                    $this->db->from('ssc_member.subscriber_user s');
//                    $this->db->where('s.profile_id', $profile_id);
//                    $query9 = $this->db->get();
//                    if ($query9->num_rows() > 0) {
//                        $row_cer['contact_mobile'] = $query9->row()->contact_mobile;
//                    }
//                }
//            }
//            /////Get sport interest
//            $this->db->select('s.category_id as id,s.category_name as display_name');
//            $this->db->from('ssc_member.account_sports_interest a');
//            $this->db->join('ssc_fac.fac_activity_category s', 's.category_id = a.sports_interest_id');
//            $this->db->where('s.deleted_at is NULL');
//            $this->db->where('a.deleted_at is NULL');
//            $this->db->where('a.profile_id', $profile_id);
//            $query1 = $this->db->get();
//            if ($query1->num_rows() > 0) {
//                $row_cer['sports_interest'] = $query1->result_array();
//            } else {
//                $row_cer['sports_interest'] = NULL;
//            }
//
//            if ($row_cer['channel_id']) {
//                $this->load->model('account/channel_model');
//                $row_cer['channel'] = $this->channel_model->find($row_cer['channel_id']);
//                unset($row_cer['channel_id']);
//            }
//
//            ///check user is subscriber_user
//            $this->db->select('id,staff_nric,employee_id,salutation_id,contact_mobile');
//            $this->db->from('ssc_member.subscriber_user');
//            $this->db->where('profile_id', $profile_id);
//            $this->db->where('deleted_at is NULL');
//            $query3 = $this->db->get();
//            if ($query3->num_rows() > 0) {
//                if ($query3->row()->contact_mobile) {
//                    $row_cer['contact_mobile'] = $query3->row()->contact_mobile;
//                }
//                $row_cer['identity_number'] = $query3->row()->staff_nric;
//                $row_cer['employee_id'] = $query3->row()->employee_id;
//                $row_cer['salutation_id'] = $query3->row()->salutation_id;
//            }
//
//            /////////////check venue
//            $this->db->select('fv.venue_id,fv.name');
//            $this->db->from('ssc_member.subscriber_user s');
//            $this->db->join('ssc_member.subscriber_user_map_venue sumv', 'sumv.subscriber_user_id = s.id');
//            $this->db->join('ssc_fac.fac_venue fv', 'sumv.fac_venue_id = fv.venue_id');
//            $this->db->where('s.profile_id', $profile_id);
//            $this->db->where('s.deleted_at is NULL');
//            $query2 = $this->db->get();
//            if ($query2->num_rows() > 0) {
//                $row_cer['venue'] = $query2->row();
//            }
//
//            ////////////parent info
//            $this->db->select('parent_name,parent_identity_number,parent_contact_mobile,parent_email');
//            $this->db->from('ssc_member.relationship');
//            $this->db->where('supplementary_user_profile_id', $profile_id);
//            $this->db->where('profile_id', '0');
//
//            $query3 = $this->db->get();
//            if ($query3->num_rows() > 0) {
//                $row_cer['parent_info'] = $query3->row();
//            }
//
//            $this->load->model('account/addon_model', 'adm');
//
//            $row_cer['schemes'] = $this->adm->getAccountAddon($profile_id);
//
//            // get account attributes
//            $this->load->model('account/account_attributes_model');
//            $row_cer['attributes'] = $this->account_attributes_model->get_attributes($profile_id);
//
//
//            //return $query->row();
//            $image = $this->get_folders(self::S3_FOLDER);
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_PROFILE);
//            $this->response_message->set_message(self::CODE_MEMBER_PROFILE, $message, array(RESULTS => $row_cer, FOLDER => $image));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function check_account($user_name, $password) {
//        $this->db->select('profile_id,id');
//        $this->db->from('ssc_member.login_account');
//
//        $this->db->where('user_name', $user_name);
//        $this->db->where('password', $password);
//        $this->db->where('active', 'Y');
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_accountbyfacebook($facebook_id) {
//        $this->db->select('profile_id,id');
//        $this->db->from('ssc_member.login_account');
//
//        $this->db->where('user_name', $facebook_id);
//        $this->db->where('is_facebook', 'Y');
//        $this->db->where('active', 'Y');
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_accountbyidentity_number($identity_number) {
//        $this->db->select('profile_id,id');
//        $this->db->from('ssc_member.login_account');
//
//        $this->db->where('user_name', $identity_number);
//        //$this->db->where('is_singpass', 'Y');
//        //$this->db->where('active', 'Y');
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
    public function get_profileid_by_accesstoken($access_token) {

        $this->db->select('l.uid,l.id');
        $this->db->from('wa.access_token AS a');
        $this->db->join('wa.login_account AS l', 'l.id = a.account_id');
        
        if($access_token == null)
            $this->db->where('1=2');
        else
            $this->db->where('a.access_token', $access_token);
        
        $this->db->where('a.deleted_at is NULL');
        $this->db->where('l.deleted_at is NULL');
        $this->db->limit(1);

        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            $this->response_message->set_message_with_code(self::CODE_INVALID_TOKEN);
            return FALSE;
        }
    }
//
//    public function get_acccountid($user_name, $profile_id) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.login_account');
//
//        $this->db->where('user_name', $user_name);
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->id;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function get_identity($profile_id) {
//        $this->db->select('identity_number');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->identity_number;
//        } else {
//            return FALSE;
//        }
//    }
//
//
//    ///////////////////
//    /**
//     * Get ID Type
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    public function get_ID_type() {
//        $result = $this->common_config_model->get_group_data_mms('ID Type');
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    /**
//     * Get Race
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    public function get_race() {
//        $result = $this->common_config_model->get_group_data_mms('Race');
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    /**
//     * Get salutation
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    public function get_salutation() {
//        $result = $this->common_config_model->get_group_data_mms('Salutation');
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    /**
//     * Get Citizenship
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    public function get_citizenship() {
//        $result = $this->common_config_model->get_group_data_mms('Citizenship');
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    /**
//     * Get Employment Status
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    public function get_employment_status() {
//        $result = $this->common_config_model->get_group_data_mms('Employment_status');
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    /**
//     * Get preferred contact mode
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    public function get_preferred_contact_mode() {
//        $result = $this->common_config_model->get_group_data_mms('Preferred_contact_mode');
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    /**
//     * Get sport interest
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    /* public function get_sports_interest()
//      {
//      $result=$this->common_config_model->get_group_data('Sports Interest');
//
//      $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//      $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//      return TRUE;
//      } */
//    public function get_sports_intrest12() {
//        $this->db->select('a.sports_interest_id as id,f.category_name as display_name,count(a.sports_interest_id) as count_sp');
//        $this->db->from('ssc_member.account_sports_interest a');
//        $this->db->join('ssc_fac.fac_activity_category f', 'f.category_id = a.sports_interest_id');
//        $this->db->where('a.deleted_at is NULL');
//        $this->db->where('f.deleted_at is NULL');
//        $this->db->group_by("a.sports_interest_id");
//        $this->db->order_by("count_sp", "desc");
//        $this->db->limit(12);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result();
//        } else {
//            return FALSE;
//        }
//    }
//
//    /**
//     * VALID PASSWORD
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    /* public function validate_password($password)
//      {
//
//      if($this->validate_password($password))
//      {
//      return TRUE;
//      }
//      else
//      {
//      $message = $this->common_config_model->get_message(self::CODE_INVALID_PASSWORD);
//      $this->response_message->set_message(self::CODE_INVALID_PASSWORD, $message);
//      return FALSE;
//      }
//      } */
//
//    /**
//     * VALID EMAIL
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    /* public function validate_email($email)
//      {
//      if($this->validate_email($email))
//      {
//      return TRUE;
//      }
//      else
//      {
//      $message = $this->common_config_model->get_message(self::CODE_INVALID_EMAIL);
//      $this->response_message->set_message(self::CODE_INVALID_EMAIL, $message);
//      return FALSE;
//      }
//      } */
//
//    /**
//     * VALID MOBILE
//     * @author Wai Tun
//     * @since 9 FEB 2014
//     */
//    /* public function validate_phone($contact_mobile)
//      {
//      if($this->validate_phone($contact_mobile))
//      {
//      return TRUE;
//      }
//      else
//      {
//      $message = $this->common_config_model->get_message(self::CODE_INVALID_MOBILE);
//      $this->response_message->set_message(self::CODE_INVALID_MOBILE, $message);
//      return FALSE;
//      }
//      } */
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _admin_member_search($keyword, $search, $user_type = NULL) {
//        // search first for blacklisted id
//        $blacklistedId = $this->_get_blacklist_member('profile_id');
//
//        $data_return = array();
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email,
//                            up.contact_mobile,
//                            up.contact_home,
//                            up.address,
//                            up.gender,
//                            up.dob,
//                            up.identity_number,
//                            pur.role_name');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.public_user_map_role AS pumr', 'pumr.profile_id = up.id');
//        $this->db->join('ssc_member.public_user_role AS pur', 'pumr.role_id = pur.id');
//
//        //$this->db->where('la.user_name', $keyword);
//        $arr_search = explode(',', $search);
//        $arr_keyword = explode(',', $keyword);
//
//        $count = count($arr_search);
//        for ($i = 0; $i < $count; $i++) {
//            if ($arr_search[$i] == 'id') {
//                $this->db->like('up.identity_number', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'name') {
//                $this->db->like('up.name', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'email') {
//                $this->db->like('up.email', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'mobile_number') {
//                $this->db->like('up.contact_mobile', @$arr_keyword[$i], 'both');
//            }
//        }
//
//        if (@$user_type) {
//            if ($user_type == 'member') {
//                $st = '(pumr.role_id=2 or pumr.role_id=3)';
//                $this->db->where($st);
//            } else {
//                $st = '(pumr.role_id=1 or pumr.role_id=4)';
//                $this->db->where($st);
//            }
//        }
//
//        // any blacklisted id, we removed first
//        if ($blacklistedId) {
//            $this->db->where_not_in('up.id', $blacklistedId);
//        }
//
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('pumr.deleted_at', NULL);
//        $this->db->where('pur.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                //////check age
//                if (@$row_cer['dob']) {
//                    $dob = $row_cer['dob'];
//                    $age = floor((strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
//                } else {
//                    $age = '-';
//                }
//
//                $row_cer['age'] = $age;
//
//                /////
//                $id = $row_cer['id'];
//                $this->db->select('suspend_status');
//                $this->db->from('ssc_member.suspend_users');
//                $this->db->where('profile_id', $id);
//                $this->db->where('deleted_at is NULL');
//                $query1 = $this->db->get();
//                if ($query1->num_rows() > 0) {
//                    if ($query1->row()->suspend_status != '1' && $query1->row()->suspend_status != '2') {
//                        $data_return[] = $row_cer;
//                    }
//                } else {
//                    $data_return[] = $row_cer;
//                }
//            }
//
//            return $data_return;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function admin_member_search_by_pagination($keyword, $search, $user_type = NULL, $page, $limit) {
//        $result = $this->_admin_member_search($keyword, $search, $user_type);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * [_get_blacklist_member description]
//     * @param  boolean $filterBy [description]
//     * @return [type]            [description]
//     */
//    protected function _get_blacklist_member($filterBy = false) {
//        if (!$result = $this->get_elasticache('MEMBER_BLACKLIST')) {
//            $result = $this->__get_blacklist_member($filterBy);
//            $this->set_elasticache('MEMBER_BLACKLIST', $result, 30);
//        }
//
//        return $result;
//    }
//
//    protected function __get_blacklist_member($filterBy = false) {
//        $this->db->select('id, profile_id');
//        $this->db->from('ssc_member.black_lists');
//        // $this->db->where('profile_id', $data['profile_id']);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//
//        if ($query && $query->num_rows()) {
//            $result = $query->result();
//
//            if ($filterBy) {
//                $return = array();
//
//                foreach ($result as $r) {
//                    $return[] = $r->$filterBy;
//                }
//
//                return $return;
//            } else {
//                return $result;
//            }
//        } else {
//            return array();
//        }
//    }
//
//    /* public function admin_member_search($keyword,$search)
//      {
//      $result = $this->_admin_member_search($keyword,$search);
//
//      if (!empty($result)) {
//      $total = count($result);
//      //$result = $this->_filter_with_pagination($result, $page, $limit);
//
//      $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING );
//      $this->response_message->set_message(self::CODE_MEMBER_LISTING , $message, array(RESULTS=> $result, TOTAL => $total));
//      return TRUE;
//
//      } else {
//      $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//      $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//      return FALSE;
//
//      }
//      } */
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _member_search_all($keyword) {
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email,
//                            up.contact_mobile,
//                            up.contact_home,
//                            up.address,
//                            up.gender,
//                            up.identity_number,
//                            up.profile_picture,
//                            pur.id as role_id,
//                            pur.role_name');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.public_user_map_role AS pumr', 'pumr.profile_id = up.id');
//        $this->db->join('ssc_member.public_user_role AS pur', 'pumr.role_id = pur.id');
//        //$this->db->where('la.user_name', $keyword);
//        //$this->db->like('up.identity_number', $keyword, 'both');
//        //$this->db->or_like('up.name', $keyword, 'both');
//        // $this->db->or_like('up.email', $keyword, 'both');
//        // $this->db->or_like('up.contact_mobile', $keyword, 'both');
//
//        $where = "(up.identity_number LIKE '%$keyword%' OR up.email LIKE '$keyword' OR up.contact_mobile LIKE '$keyword')";
//        $this->db->where($where);
//
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('pumr.deleted_at', NULL);
//        $this->db->where('pur.deleted_at', NULL);
//
//        $this->db->order_by("up.name", "asc");
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//            return $row;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function member_search_all($keyword, $page, $limit) {
//        $result = $this->_member_search_all($keyword);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $image = $this->get_folders(self::S3_FOLDER);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total, FOLDER => $image));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function update_profile($profile_id, $data) {
//        $ipAddress = $this->input->ip_address();
//        $oldAccountContact = $this->get_account_contact($profile_id);
//
//        /**
//         * update 510
//         * allow update of parent info for supplementary
//         */
//        // $role_id = $this->account_model->check_member_role($profile_id);
//        $this->load->model('account/login_model', 'alm');
//
//        // if after updating the new profile resulting in this account to be a supplementary / junior
//        // remove the email and mobile login from this account
//        if ($data['dob'] && $this->is_dob_supplementary($data['dob'])) {
//            $this->load->model('account/relationship_model', 'arm');
//
//            if (isset($data['email'])) {
//                $email = $data['email'];
//            } else {
//                $email = null;
//            }
//
//            if (isset($data['contact_mobile'])) {
//                $contact_mobile = $data['contact_mobile'];
//            } else {
//                $contact_mobile = null;
//            }
//
//            $relationshipData['parent_name'] = $data['parent_name'];
//            $relationshipData['parent_identity_number'] = $data['parent_identity_number'];
//            $relationshipData['parent_contact_mobile'] = $data['parent_contact_mobile'];
//            $relationshipData['parent_email'] = $data['parent_email'];
//            $relationshipData['email'] = $email;
//            $relationshipData['contact_mobile'] = $contact_mobile;
//
//            // supplementary we dont store the email and contact mobile in the user profile
//            $data['email'] = null;
//            $data['contact_mobile'] = null;
//
//            // update supplementary table detail
//            $this->arm->updateDetail($profile_id, $relationshipData);
//        }
//
//        // we also dont want any parent information to be stored in user profile
//        unset($data['parent_name']);
//        unset($data['parent_identity_number']);
//        unset($data['parent_contact_mobile']);
//        unset($data['parent_email']);
//
//        // setup attributes
//        if (isset($data['attributes'])) {
//            $this->load->model('account/account_attributes_model');
//            $this->account_attributes_model->update_attributes($profile_id, $data['attributes']);
//            unset($data['attributes']);
//        }
//
//        $result = $this->common_edit('ssc_member.user_profile', 'id', $profile_id, $data);
//
//        if (!$this->check_account_role($profile_id, $data['id_type'])) {
//            $this->update_role($profile_id, $data['id_type']);
//        }
//
//        if ($result) {
//            $tmpPassword = $this->alm->getPassword($profile_id);
//
//            if (!empty($oldAccountContact->email)) {
//                $login = $this->alm->getLogin($profile_id, $oldAccountContact->email);
//
//                if (isset($data['email']) && !empty($data['email'])) {
//                    if ($login) {
//                        if ($oldAccountContact->email != $data['email']) {
//                            $this->alm->editLogin($login['id'], $data['email']);
//                        }
//                    } else {
//                        $this->alm->createLogin($profile_id, $data['email'], $tmpPassword, 'Y', 'Y');
//                    }
//                } else {
//                    if ($login) {
//                        $this->alm->removeLogin($login['id']);
//                    }
//                }
//            }
//
//            if (!empty($oldAccountContact->contact_mobile)) {
//                $login = $this->alm->getLogin($profile_id, $oldAccountContact->contact_mobile);
//
//                if (isset($data['contact_mobile']) && !empty($data['contact_mobile'])) {
//                    if ($login) {
//                        if ($oldAccountContact->contact_mobile != $data['contact_mobile']) {
//                            $this->alm->editLogin($login['id'], $data['contact_mobile']);
//                        }
//                    } else {
//                        $this->alm->createLogin($profile_id, $data['contact_mobile'], $tmpPassword, 'Y', 'Y');
//                    }
//                } else {
//                    if ($login) {
//                        $this->alm->removeLogin($login['id']);
//                    }
//                }
//            }
//
//            if (!empty($oldAccountContact->identity_number)) {
//                $login = $this->alm->getLogin($profile_id, $oldAccountContact->identity_number);
//
//                if (isset($data['identity_number']) && !empty($data['identity_number'])) {
//                    if ($login) {
//                        if ($oldAccountContact->identity_number != $data['identity_number']) {
//                            $this->alm->editLogin($login['id'], $data['identity_number']);
//
//                            // edit vcard
//                            $photo_url = $this->generate_qrcode($data['identity_number']);
//
//                            if ($photo_url) {
//                                $data = array();
//                                $data['vcard_file'] = $photo_url;
//
//                                $this->account_model->common_edit('user_profile', 'id', $profile_id, $data);
//                            } else {
//                                log_message('error', 'Unable to generate new vcard qrcode for profile_id: ' . $profile_id);
//                            }
//                        }
//                    } else {
//                        $this->alm->createLogin($profile_id, $data['identity_number'], $tmpPassword, 'Y', 'Y');
//                    }
//                } else {
//                    if ($login) {
//                        $this->alm->removeLogin($login['id']);
//                    }
//                }
//            }
//
//            //add history
//            $this->add_history($profile_id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $ipAddress, self::ACTION_UPDATE);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_UPDATE);
//            $this->response_message->set_message(self::CODE_MEMBER_UPDATE, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * [verified_singpass description]
//     *
//     * @param  [type]  $profile_id      [description]
//     * @return [type]                   [description]
//     */
//    public function verified_singpass_by_nric($profile_id) {
//        $sflag = 3;  // TODO: Magic Number
//        // Given a nric, Find the account
//        // If account doesnt exits, return exception 'Account not found'
//        // check if account has been verified,
//        // If already verified, return exception 'Already Verified'
//        // check if account is allowed to be verified
//        // If not allowed, return exception 'Account cannot be verified'
//        // Change the role id
//        // Grant the money
//        $ipAddress = $this->input->ip_address();
//
//        $this->db->select('up.id, role_id, dob, verified_singpass');
//        $this->db->from('ssc_member.user_profile up');
//        $this->db->join('ssc_member.public_user_map_role pumr', 'up.id = pumr.profile_id');
//        $this->db->where('up.id', $profile_id);
//        $this->db->where('verified', 'Y');
//        $this->db->where('up.deleted_at IS NULL');
//        $this->db->where('pumr.deleted_at IS NULL');
//
//        $query = $this->db->get();
//
//        // We check first
//        if (!$query->num_rows()) {
//            $message = 'Account not found.';
//            $this->response_message->set_message(self::CODE_SINGPASS_VER_SUCCESS, $message);
//            return FALSE;
//        }
//
//        // We check first if this account has been verified
//        if ($query->row()->verified_singpass != 0) {
//            $message = 'Account is already verified.';
//            $this->response_message->set_message(self::CODE_SINGPASS_VER_SUCCESS, $message);
//            return FALSE;
//        } else {
//            // TODO: Need to update the role id since verification successful
//            // Now only role id 4 can be verified
//            // checking role id is replaced to check if role id is 4
//            // in case there are people with role 2 and 3 left over
//            $role_id = $query->row()->role_id; // $this->_get_role($profile_id);
//            $dob = $query->row()->dob; // $this->get_dob($profile_id);
//
//            if (in_array($role_id, array(2, 3, 4))) {
//                // modify the status
//                $data4 = array();
//                $data4['verified_singpass'] = $sflag;
//                $data4['updated_at'] = date('Y-m-d H:i:s');
//                $data4['updated_by'] = $this->adminId;
//                $this->account_model->common_edit('user_profile', 'id', $profile_id, $data4);
//
//                //add history
//                $this->account_model->add_history($profile_id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $ipAddress, self::ACTION_UPDATE);
//
//                $_age = floor((strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
//
//                if ($_age > 18) {
//                    $possible_role_id = 2;
//                } else {
//                    $possible_role_id = 3;
//                }
//
//                // only update if the role is changed
//                if ($role_id != $possible_role_id) {
//                    $this->_update_role($profile_id, $possible_role_id);
//                }
//
//                // start grant money
//                $amount = $this->get_initial_amount($role_id);
//
//                if (!$amount) {
//                    $amount = 100;
//                }
//
//                log_message('error', 'verified_singpass' . $profile_id . ' with: ' . $amount . 'status:' . $sflag);
//
//                $this->load->model('account/account_ewallet_model');
//                $flag = $this->account_ewallet_model->active_sg_topup($profile_id, $amount);
//                $sg50flag = $this->account_ewallet_model->active_sg_grant($profile_id);
//
//                $message = 'Account has been verified.';
//                // $message = 'Your account has been verified and ActiveSG $ has been credited into your eWallet.';
//                $this->response_message->set_message(self::CODE_SINGPASS_VER_SUCCESS, $message);
//                return TRUE;
//            } else {
//                $message = 'Account is not eligible for singpass verification.';
//                $this->response_message->set_message(self::CODE_SINGPASS_VER_SUCCESS, $message);
//                return FALSE;
//            }
//        }
//    }
//
//    public function _update_role($profile_id, $role_id, $updated_by = NULL) {
//        $data = array();
//        $data['role_id'] = $role_id;
//        $data['updated_at'] = date('Y-m-d H:i:s');
//        $data['updated_by'] = $updated_by ? $updated_by : $profile_id;
//        $ipAddress = $this->input->ip_address();
//
//        if ($this->account_model->common_edit('ssc_member.public_user_map_role', 'profile_id', $profile_id, $data)) {
//            $this->save_log('profile_id', $profile_id, 'ssc_member.public_user_map_role', 'ssc_log.hist_public_user_map_role', $ipAddress, self::ACTION_UPDATE, NULL, array('deleted_at IS NULL' => NULL));
//        } else {
//            // unable to edit the role
//            // TODO: Maybe Log the error
//        }
//    }
//
//    /**
//     * [is_verified_singpass description]
//     * @param  [type]  $profileId [description]
//     * @return boolean            [description]
//     */
//    public function is_verified_singpass($profileId) {
//        $this->db->select('verified_singpass');
//        $this->db->from('ssc_member.user_profile');
//        $this->db->where('id', $profileId);
//        $this->db->where('deleted_at IS NULL');
//
//        $query = $this->db->get();
//
//        if ($query && $query->num_rows()) {
//            $result = $query->row();
//
//            if ($result->verified_singpass != 0) {
//                return true;
//            }
//
//            return false;
//        } else {
//            return false;
//        }
//    }
//
//    /**
//     * given an idtype, check the membership for this profile id
//     * @param  [type] $profile_id [description]
//     * @param  [type] $id_type    [description]
//     * @return [type]             [description]
//     */
//    public function check_account_role($profile_id, $id_type) {
//        $dob = $this->_get_dob($profile_id);
//        $isVerifiedSingpass = $this->is_verified_singpass($profile_id);
//
//        if (!$dob)
//            return;
//
//        // todo: something duplicated
//        // $_age = floor( (strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
//
//        $this->db->select('id, profile_id, role_id');
//        $this->db->from('public_user_map_role');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//        switch ($id_type) {
//            case 'e1_sid':
//                if (!$isVerifiedSingpass) {
//                    $this->db->where('role_id', 4);
//                } else if ($this->is_dob_supplementary($dob)) {
//                    $this->db->where('role_id', 3);
//                } else {
//                    $this->db->where('role_id', 2);
//                }
//                break;
//            case 'e2_fin':
//                $this->db->where('role_id', 1);
//                break;
//            case 'e3_others':
//            default:
//                $this->db->where('role_id', 1);
//                break;
//        }
//
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            return $query->row_array();
//        } else {
//            return false;
//        }
//    }
//
//    public function update_role($profile_id, $id_type) {
//        switch ($id_type) {
//            case 'e1_sid':
//                $dob = $this->_get_dob($profile_id);
//                $isVerifiedSingpass = $this->is_verified_singpass($profile_id);
//
//                if (!$dob)
//                    return;
//
//                // todo: something duplicated
//                // $_age = floor( (strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
//                if (!$isVerifiedSingpass) {
//                    $data['role_id'] = 4; // todo: magic number
//                } else if ($this->is_dob_supplementary($dob)) {
//                    $data['role_id'] = 3; // todo: magic number
//                } else {
//                    $data['role_id'] = 2; // todo: magic number
//                }
//
//                break;
//            case 'e2_fin':
//            case 'e3_others':
//            default:
//                $data['role_id'] = 1; // todo: magic number
//                break;
//        }
//
//        $data['updated_at'] = date('Y-m-d H:i:s');
//        $data['updated_by'] = $this->adminId;
//
//        if ($this->common_edit('public_user_map_role', 'profile_id', $profile_id, $data)) {
//            $ipAddress = $this->input->ip_address();
//            $this->save_log('profile_id', $profile_id, 'ssc_member.public_user_map_role', 'ssc_log.hist_public_user_map_role', $ipAddress, self::ACTION_UPDATE);
//        }
//    }
//
//    protected function is_dob_supplementary($dob) {
//        // todo: something duplicated
//        $_age = floor((strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
//
//        if ($_age < 18) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    public function account_delete($profile_id) {
//        //clear account login table
//        $data = $this->common_delete('ssc_member.user_profile', 'id', $profile_id);
//        $this->common_delete('ssc_member.login_account', 'profile_id', $profile_id);
//        $this->common_delete('ssc_member.public_user_map_role', 'profile_id', $profile_id);
//        $this->common_delete('ssc_member.ordinary_hirer', 'profile_id', $profile_id);
//
//        if ($data) {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_DELETE);
//            $this->response_message->set_message(self::CODE_MEMBER_DELETE, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     *
//     * @param $profile_id
//     *
//     * @return bool
//     */
//    public function organization_contact_person($profile_id) {
//        $this->db->select('a.id,a.profile_id,o.contact_person,o.email,a.uen, o.contact_mobile');
//
//        $this->db->from('ssc_member.adv_priority_hirer a');
//        $this->db->join('ssc_member.organization_contacts o', 'o.adv_id = a.id');
//        $this->db->where('a.profile_id', $profile_id);
//        $this->db->where('a.deleted_at', NULL);
//        $this->db->where('o.deleted_at', NULL);
//        $this->db->limit(1);
//
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _admin_supplementary_member_search($keyword, $search) {
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email,
//                            up.contact_mobile,
//                            up.contact_home,
//                            up.address,
//                            up.gender,
//                            up.identity_number,
//                            pur.role_name');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.public_user_map_role AS pumr', 'pumr.profile_id = up.id');
//        $this->db->join('ssc_member.public_user_role AS pur', 'pumr.role_id = pur.id');
//
//        //$this->db->where('la.user_name', $keyword);
//        $arr_search = explode(',', $search);
//        $arr_keyword = explode(',', $keyword);
//
//        $count = count($arr_search);
//        for ($i = 0; $i < $count; $i++) {
//            if ($arr_search[$i] == 'id') {
//                $this->db->like('up.identity_number', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'name') {
//                $this->db->like('up.name', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'email') {
//                $this->db->like('up.email', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'mobile_number') {
//                $this->db->like('up.contact_mobile', @$arr_keyword[$i], 'both');
//            }
//        }
//
//        $this->db->where('pur.id', 3);
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('pumr.deleted_at', NULL);
//        $this->db->where('pur.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//            return $row;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function admin_supplementary_member_search($keyword, $search) {
//        $result = $this->_admin_supplementary_member_search($keyword, $search);
//
//        if (!empty($result)) {
//            $total = count($result);
//            //$result = $this->_filter_with_pagination($result, $page, $limit);
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function admin_supplementary_member_search_by_pagination($keyword, $search, $page, $limit) {
//        $result = $this->_admin_supplementary_member_search($keyword, $search);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _subscriber_user_search($keyword) {
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.subscriber_user AS s', 's.profile_id = up.id');
//
//        //$this->db->where('la.user_name', $keyword);
//        $this->db->like('up.email', $keyword);
//
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('s.deleted_at', NULL);
//
//        $this->db->order_by("up.name", "asc");
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//            return $row;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function subscriber_user_search($keyword, $page, $limit) {
//        $result = $this->_subscriber_user_search($keyword);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_STAFF_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_STAFF_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _suspend_user_search($keyword, $search, $status) {
//        $data_return = array();
//
//        if ($status == 1) {
//            $this->db->select(' up.id,
//                                up.name,
//                                up.email,
//                                up.contact_mobile,
//                                up.contact_home,
//                                up.address,
//                                up.gender,
//                                up.dob,
//                                up.identity_number,
//                                s.suspended_date_from,
//                                s.suspended_date_to,
//                                s.auto_reinstate,
//                                u1.name as admin_level1,
//                                s.suspend_status');
//
//            $this->db->from('ssc_member.user_profile AS up');
//            $this->db->join('ssc_member.suspend_users AS s', 's.profile_id = up.id');
//            $this->db->join('ssc_member.user_profile AS u1', 's.admin_level1 = u1.id');
//        } else {
//            $this->db->select(' up.id,
//                                    up.name,
//                                    up.email,
//                                    up.contact_mobile,
//                                    up.contact_home,
//                                    up.address,
//                                    up.gender,
//                                    up.dob,
//                                    up.identity_number,
//                                    s.suspended_date_from,
//                                    s.suspended_date_to,
//                                    s.auto_reinstate,
//                                    u1.name as admin_level1,
//                                    u2.name as admin_level2,
//                                    s.suspend_status');
//
//            $this->db->from('ssc_member.user_profile AS up');
//            $this->db->join('ssc_member.suspend_users AS s', 's.profile_id = up.id');
//            $this->db->join('ssc_member.user_profile AS u1', 's.admin_level1 = u1.id');
//            $this->db->join('ssc_member.user_profile AS u2', 's.admin_level2 = u2.id');
//        }
//
//
//        //$this->db->where('la.user_name', $keyword);
//        $arr_search = explode(',', $search);
//        $arr_keyword = explode(',', $keyword);
//
//        $count = count($arr_search);
//        for ($i = 0; $i < $count; $i++) {
//            if ($arr_search[$i] == 'id') {
//                $this->db->like('up.identity_number', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'name') {
//                $this->db->like('up.name', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'email') {
//                $this->db->like('up.email', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'mobile_number') {
//                $this->db->like('up.contact_mobile', @$arr_keyword[$i], 'both');
//            }
//        }
//        $this->db->where('s.suspend_status', $status);
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('s.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                if (@$row_cer['suspend_status'] == 1) {
//                    $row_cer['suspend_status'] = 'Pending';
//                } else if (@$row_cer['suspend_status'] == 2) {
//                    $row_cer['suspend_status'] = 'Suspend';
//                } else if (@$row_cer['suspend_status'] == 3) {
//                    $row_cer['suspend_status'] = 'Reinstate';
//                }
//                $data_return[] = $row_cer;
//            }
//            return $data_return;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function suspend_user_search($keyword, $search, $status, $page, $limit) {
//        $result = $this->_suspend_user_search($keyword, $search, $status);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function suspend_by_level1($data, $adminId) {
//
//        $this->db->select('id');
//        $this->db->from('ssc_member.reporting_relation');
//        $this->db->where('sub_id', $adminId);
//        $this->db->where('deleted_at is NULL');
//
//        $query1 = $this->db->get();
//        if ($query1->num_rows() < 1) {
//            $message = $this->common_config_model->get_message('1131');
//            $this->response_message->set_message('1131', $message);
//            return FALSE;
//        }
//
//        ///this user suspend ready or not
//        $this->db->select('id');
//        $this->db->from('ssc_member.suspend_users');
//        $this->db->where('profile_id', $data['profile_id']);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $id = $this->common_edit('ssc_member.suspend_users', 'profile_id', $data['profile_id'], $data);
//
//            if ($id) {
//                /////add to history
//                $data1 = array();
//                $data1['profile_id'] = $data['profile_id'];
//                $data1['suspend_status'] = $data['suspend_status'];
//                $data1['suspended_reason'] = $data['suspended_reason'];
//                $data1['admin'] = $data['admin_level1'];
//                $data1['created_by'] = $data['admin_level1'];
//                $data1['created_at'] = date('Y-m-d H:i:s');
//                $this->common_add('ssc_member.suspend_user_history', $data1);
//
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_SUSPEND_PENDING);
//                $this->response_message->set_message(self::CODE_MEMBER_SUSPEND_PENDING, $message);
//                return TRUE;
//            } else {
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//                $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//                return FALSE;
//            }
//        } else {
//            $data['created_at'] = date('Y-m-d H:i:s');
//            $id = $this->common_add('ssc_member.suspend_users', $data);
//
//            if ($id) {
//                /////add to history
//                $data1 = array();
//                $data1['profile_id'] = $data['profile_id'];
//                $data1['suspend_status'] = $data['suspend_status'];
//                $data1['suspended_reason'] = $data['suspended_reason'];
//                $data1['admin'] = $data['admin_level1'];
//                $data1['created_by'] = $data['admin_level1'];
//                $data1['created_at'] = date('Y-m-d H:i:s');
//                $this->common_add('ssc_member.suspend_user_history', $data1);
//
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_SUSPEND_PENDING);
//                $this->response_message->set_message(self::CODE_MEMBER_SUSPEND_PENDING, $message);
//                return TRUE;
//            } else {
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//                $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//                return FALSE;
//            }
//        }
//    }
//
//    public function suspend_approve_by_level_search($data) {
//
//        $id = $this->common_edit('ssc_member.suspend_users', 'profile_id', $data['profile_id'], $data);
//
//        /////add to history
//        $data['created_at'] = date('Y-m-d H:i:s');
//        $id = $this->common_add('ssc_member.suspend_user_history', $data);
//
//
//        if ($id) {
//            $data1 = array();
//            $data1['active'] = 'N';
//
//            $this->common_edit('ssc_member.login_account', 'profile_id', $data['profile_id'], $data1);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_SUSPEND);
//            $this->response_message->set_message(self::CODE_MEMBER_SUSPEND, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function reinstate_user($data) {
//
//        $id = $this->common_edit('ssc_member.suspend_users', 'profile_id', $data['profile_id'], $data);
//
//        /////add to history
//        $data11 = array();
//        $data11['profile_id'] = $data['profile_id'];
//        $data11['suspend_status'] = $data['suspend_status'];
//        $data11['suspended_reason'] = @$data['suspended_reason'];
//        $data11['admin'] = $data['reinstate_by'];
//        $data11['updated_by'] = $data['reinstate_by'];
//        $data11['created_at'] = date('Y-m-d H:i:s');
//
//        $this->common_add('ssc_member.suspend_user_history', $data11);
//
//        $data1 = array();
//        $data1['active'] = 'Y';
//
//        $this->common_edit('ssc_member.login_account', 'profile_id', $data['profile_id'], $data1);
//
//
//        if ($id) {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_REINSTATE);
//            $this->response_message->set_message(self::CODE_MEMBER_REINSTATE, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function subscriber_user_level2_search($admin_id) {
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.reporting_relation AS s', 's.sup_id = up.id');
//
//        //$this->db->where('la.user_name', $keyword);
//
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('s.deleted_at', NULL);
//        $this->db->where('s.sub_id', $admin_id);
//
//        $this->db->order_by("up.name", "asc");
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_APPROVE_STAFF);
//            $this->response_message->set_message(self::CODE_APPROVE_STAFF, $message);
//            return FALSE;
//        }
//    }
//
//    public function add_subscriber_user_level2($data) {        ///this user suspend ready or not
//        ////check
//        $this->db->select('id');
//        $this->db->from('ssc_member.reporting_relation');
//        $this->db->where('sub_id', $data['sub_id']);
//        $this->db->where('sup_id', $data['sup_id']);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_ADMIN_LEVEL_2);
//            $this->response_message->set_message(self::CODE_ADMIN_LEVEL_2, $message);
//            return TRUE;
//        } else {
//            $data['created_at'] = date('Y-m-d H:i:s');
//            $id = $this->common_add('ssc_member.reporting_relation', $data);
//
//            if ($id) {
//                $message = $this->common_config_model->get_message(self::CODE_ADMIN_LEVEL_2);
//                $this->response_message->set_message(self::CODE_ADMIN_LEVEL_2, $message);
//                return TRUE;
//            } else {
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//                $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//                return FALSE;
//            }
//        }
//    }
//
//    public function subscriber_user_level2_delete($level1_id, $level2_id) {
//        //clear account login table
//        $key = array();
//        $key['sub_id'] = $level1_id;
//        $key['sup_id'] = $level2_id;
//
//        $value = array($level1_id, $level2_id);
//        $data = $this->common_delete('ssc_member.reporting_relation', $key, $value);
//
//        if ($data) {
//            $message = $this->common_config_model->get_message(self::CODE_ADMIN_LEVEL_2_DELETE);
//            $this->response_message->set_message(self::CODE_ADMIN_LEVEL_2_DELETE, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function terminate_user($data) {        ///this user suspend ready or not
//        ////check
//        $this->db->select('id');
//        $this->db->from('ssc_member.black_lists');
//        $this->db->where('profile_id', $data['profile_id']);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_TERMINATE);
//            $this->response_message->set_message(self::CODE_MEMBER_TERMINATE, $message);
//            return TRUE;
//        } else {
//            $data['created_at'] = date('Y-m-d H:i:s');
//            $id = $this->common_add('ssc_member.black_lists', $data);
//
//            if ($id) {
//                $data1 = array();
//                $data1['active'] = 'N';
//                $data1['verified'] = 'N';
//
//                $this->common_edit('ssc_member.login_account', 'profile_id', $data['profile_id'], $data1);
//
//                $data2 = array();
//                // $data2['verified']='N';
//                $data2['blacklist'] = 'Y';
//
//
//                $this->common_edit('ssc_member.user_profile', 'id', $data['profile_id'], $data2);
//
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_TERMINATE);
//                $this->response_message->set_message(self::CODE_MEMBER_TERMINATE, $message);
//                return TRUE;
//            } else {
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//                $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//                return FALSE;
//            }
//        }
//    }
//
//    public function suspend_approve_by_level2($data, $adminId) {
//        $this->db->select('r.id');
//        $this->db->from('ssc_member.reporting_relation as r');
//        $this->db->join('ssc_member.suspend_users AS b', 'r.sub_id = b.admin_level1');
//
//        $this->db->where('r.sup_id', $adminId);
//        $this->db->where('b.profile_id', $data['profile_id']);
//
//        $this->db->where('r.deleted_at is NULL');
//
//        $query1 = $this->db->get();
//        if ($query1->num_rows() < 1) {
//            $message = $this->common_config_model->get_message('1131');
//            $this->response_message->set_message('1131', $message);
//            return FALSE;
//        }
//
//        $id = $this->common_edit('ssc_member.suspend_users', 'profile_id', $data['profile_id'], $data);
//
//        /////add to history
//        $data1 = array();
//        $data1['profile_id'] = $data['profile_id'];
//        $data1['suspend_status'] = $data['suspend_status'];
//        $data1['suspended_reason'] = @$data['suspended_reason'];
//        $data1['admin'] = $data['admin_level2'];
//        $data1['updated_by'] = $data['admin_level2'];
//        $data1['created_at'] = date('Y-m-d H:i:s');
//
//        $id = $this->common_add('ssc_member.suspend_user_history', $data1);
//
//        $data1 = array();
//        $data1['active'] = 'N';
//
//        $this->common_edit('ssc_member.login_account', 'profile_id', $data['profile_id'], $data1);
//
//
//        if ($id) {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_SUSPEND);
//            $this->response_message->set_message(self::CODE_MEMBER_SUSPEND, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /////terminate user
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _terminate_user_search($keyword, $search) {
//
//        $this->db->select(' up.id,
//                                up.name,
//                                up.email,
//                                up.contact_mobile,
//                                up.contact_home,
//                                up.address,
//                                up.gender,
//                                up.dob,
//                                up.identity_number,
//                                b.created_at,
//                                b.blacklist_reason
//                                ');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.black_lists AS b', 'b.profile_id = up.id');
//
//
//        //$this->db->where('la.user_name', $keyword);
//        $arr_search = explode(',', $search);
//        $arr_keyword = explode(',', $keyword);
//
//        $count = count($arr_search);
//        for ($i = 0; $i < $count; $i++) {
//            if ($arr_search[$i] == 'id') {
//                $this->db->like('up.identity_number', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'name') {
//                $this->db->like('up.name', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'email') {
//                $this->db->like('up.email', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'mobile_number') {
//                $this->db->like('up.contact_mobile', @$arr_keyword[$i], 'both');
//            }
//        }
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('b.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function terminate_user_search($keyword, $search, $page, $limit) {
//        $result = $this->_terminate_user_search($keyword, $search);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function check_member_role($profile_id) {
//        //////CHECK USER ROLE
//        $this->db->select('role_id');
//        $this->db->from('ssc_member.public_user_map_role');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->role_id;
//        }
//    }
//
//    public function check_organisation_role($profile_id) {
//        //////CHECK ORGANISATION ROLE
//        $this->db->select('hirer_cat_id');
//        $this->db->from('ssc_member.adv_priority_hirer');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->hirer_cat_id;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function is_adv_hirer($profile_id) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.adv_priority_hirer');
//        $this->db->where('profile_id', $profile_id);
//        //$this->db->where('active',YES_FLAG);
//        // $this->db->where('verified',YES_FLAG);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function change_member_role($profile_id, $data) {
//
//        $data = $this->common_edit('public_user_map_role', 'profile_id', $profile_id, $data);
//        //print_r($data);die;
//        $this->common_delete('relationship', 'supplementary_user_profile_id', $profile_id);
//
//        if ($data) {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_CONVERSION);
//            $this->response_message->set_message(self::CODE_MEMBER_CONVERSION, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function check_unique_identity1($identity_number) {
//        $this->db->select('id');
//        $this->db->from('user_profile');
//
//        $this->db->where('identity_number', $identity_number);
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_unique_email1($email) {
//        $this->db->select('id');
//        $this->db->from('user_profile');
//
//        $this->db->where('email', $email);
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function check_unique_mobilenumber1($contact_mobile) {
//        $this->db->select('id');
//        $this->db->from('user_profile');
//
//        $this->db->where('contact_mobile', $contact_mobile);
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function ewallet_create($profile_id, $ewallet_code) {
//
//        $data = array();
//        $data['account_id'] = $profile_id;
//        $data['ewallet_code'] = $ewallet_code;
//        $data['created_by'] = $profile_id;
//        $data['profile_type'] = self::CHANNEL_PUBLIC_USER;
//
//        //print_r($data);die;
//
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->create_ewallet($data);
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            //$message = $this->common_config_model->get_message(self::CODE_EWALLET_FAIL);
//            //$this->response_message->set_message(self::CODE_EWALLET_FAIL, $message);
//            return FALSE;
//        } else {
//            //$this->_response_with_code(self::CODE_EWALLET_CREATE, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//        /* $this->load->helper('util');
//          $result = doCurl(COMMON_SERVICE_URL."wallet/create", $data, 'POST');
//          print_r($result);die;
//          if (isset($result['http_status_code']) && $result['http_status_code'] == 200)
//          {
//          $message = $this->common_config_model->get_message(self::CODE_EWALLET_CREATE);
//          $this->response_message->set_message(self::CODE_EWALLET_CREATE, $message, array(ACCESS_TOKEN=>$access_token));
//          return TRUE;
//          }
//          else
//          {
//          $message = $this->common_config_model->get_message(self::CODE_EWALLET_FAIL);
//          $this->response_message->set_message(self::CODE_EWALLET_FAIL, $message);
//          return FALSE;
//          } */
//    }
//
//    public function ewallet_update($profile_id, $ewallet_code, $amount) {
//        $data = array();
//        $data['account_id'] = $profile_id;
//        $data['ewallet_code'] = $ewallet_code;
//        $data['amount'] = $amount;
//
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->update_ewallet($data);
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            //$message = $this->common_config_model->get_message(self::CODE_EWALLET_FAIL);
//            //$this->response_message->set_message(self::CODE_EWALLET_FAIL, $message);
//            return FALSE;
//        } else {
//            //$this->_response_with_code(self::CODE_EWALLET_CREATE, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    public function ewallet_pin_setup($profile_id, $access_token, $data) {
//        $this->load->model('common/common_service_model');
//        //print_r($data);die;
//        $jsonResponse = $this->common_service_model->ewallet_pin_setup($data);
//
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_EWALLET_PIN_FAIL);
//            $this->response_message->set_message(self::CODE_EWALLET_PIN_FAIL, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_EWALLET_PIN_CREATE, array(RESULTS => $jsonResponse, ACCESS_TOKEN => $access_token));
//            return TRUE;
//        }
//    }
//
//    public function ewallet_pin_reset($profile_id, $access_token, $data) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->ewallet_pin_reset($data);
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_EWALLET_PIN_FAIL);
//            $this->response_message->set_message(self::CODE_EWALLET_PIN_FAIL, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_EWALLET_PIN_CREATE, array(RESULTS => $jsonResponse, ACCESS_TOKEN => $access_token));
//            return TRUE;
//        }
//    }
//
//    ////shopping cart topup pos
//    public function shopping_cart_topup_pos($profile_id, $shopping_cart_items, $lat = NULL, $long = NULL, $adminId) {
//        $goId = $adminId;
//
//        $srtTime = $this->_get_expiry_date_pos();
//        $this->load->model('common/common_service_model');
//        /////////
//        $response = $this->common_service_model->add_to_cart($goId, 'pos', $profile_id, $srtTime, $shopping_cart_items);
//        //print_r($jsonResponse);die;
//        if (!$response) {
//            //Problem with e wallet
//            if ($this->response_message->get_status_code() == SSC_HEADER_INTERNAL_SERVER_ERROR) {
//                $this->_response_with_code(self::CODE_SHOPPING_CART_NOT_FOUND);
//            }
//            return FALSE;
//        }
//
//        $statusCode = $response[STATUS_CODE];
//        $results = $response[RESULTS];
//
//
//        $this->_response_with_code(self::CODE_SHOPPING_CART_TOP_UP, array(RESULTS => $results));
//        return TRUE;
//        /* if($jsonResponse === FALSE) {
//
//          $message = $this->common_config_model->get_message(self::CODE_SHOPPING_CART_NOT_FOUND);
//          $this->response_message->set_message(self::CODE_SHOPPING_CART_NOT_FOUND, $message);
//          return FALSE;
//          }
//          else
//          {
//          $this->_response_with_code(self::CODE_SHOPPING_CART_TOP_UP, array(RESULTS => $jsonResponse));
//          return TRUE;
//          } */
//    }
//
//    ////shopping cart clear
//    public function shopping_cart_clear($profile_id, $shopping_cart_id) {
//
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->shopping_cart_clear($profile_id, $shopping_cart_id);
//
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_SHOPPING_CART_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_SHOPPING_CART_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_SHOPPING_CART_CLEAR, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    ////shopping cart clear
//    public function delete_shopping_cart_item($profile_id, $shopping_cart_id, $shopping_cart_item_id) {
//
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->delete_shopping_cart_item($profile_id, $shopping_cart_id, $shopping_cart_item_id);
//
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_SHOPPING_CART_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_SHOPPING_CART_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_SHOPPING_CART_ITEM_DELETE, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    public function find_account_salt($profile_id) {
//        $this->db->select('salt');
//        $this->db->from('user_profile');
//
//        $this->db->where('id', $profile_id);
//        $this->db->where('verified', 'Y');
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->salt;
//        } else {
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since 3 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function get_initial_credit() {
//        $this->db->select('m.role_id as role_id,p.role_name,m.initial_credit');
//
//        $this->db->from('ssc_member.membership_config AS m');
//        $this->db->join('ssc_member.public_user_role AS p', 'p.id = m.role_id');
//
//        $this->db->where('m.deleted_at', NULL);
//        $this->db->where('p.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_INITIAL_CREDIT);
//            $this->response_message->set_message(self::CODE_INITIAL_CREDIT, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function update_initial_credit($role_id_list, $initial_credit_list) {
//        $arr_role = explode(",", $role_id_list);
//        $arr_credit = explode(",", $initial_credit_list);
//
//        $count = count($arr_role);
//
//        for ($i = 0; $i < $count; $i++) {
//            $data = array();
//            $data['initial_credit'] = $arr_credit[$i];
//            $this->common_edit('membership_config', 'role_id', $arr_role[$i], $data);
//        }
//        //print_r($data);die;
//        $message = $this->common_config_model->get_message(self::CODE_INITIAL_CREDIT_UPDATE);
//        $this->response_message->set_message(self::CODE_INITIAL_CREDIT_UPDATE, $message);
//        return TRUE;
//    }
//
//    private function _get_expiry_date() {
//
//        $defaultCountdown = $this->common_config_model->get_core_config_data(Common_config_model::CORE_CONFIG_DEFAULT_COUNTDOWN_CODE);
//        if ($defaultCountdown != NULL && is_numeric($defaultCountdown)) {
//            $defaultCountdown = 'PT' . $defaultCountdown . 'M';
//        } else {
//            $defaultCountdown = self::DEFAULT_PUBLIC_COUNTDOWN;
//        }
//        $srtTime = new DateTime();
//        $srtTime->add(new DateInterval($defaultCountdown));
//
//        return $srtTime;
//        //10 minutes
//    }
//
//    private function _get_expiry_date_pos() {
//
//        $defaultCountdown = $this->common_config_model->get_core_config_data(self::DEFAULT_PUBLIC_COUNTDOWN_POS);
//        if ($defaultCountdown != NULL && is_numeric($defaultCountdown)) {
//            $defaultCountdown = 'PT' . $defaultCountdown . 'M';
//        } else {
//            $defaultCountdown = self::DEFAULT_PUBLIC_COUNTDOWN_POS;
//        }
//        $srtTime = new DateTime();
//        $srtTime->add(new DateInterval($defaultCountdown));
//
//        return $srtTime;
//        //10 minutes
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _subscriber_listingby_venue($venue_id) {
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.subscriber_user AS s', 's.profile_id = up.id');
//        $this->db->join('ssc_member.subscriber_user_map_venue AS m', 'm.subscriber_user_id = s.id');
//
//        //$this->db->where('la.user_name', $keyword);
//        $this->db->where('m.fac_venue_id', $venue_id);
//
//        $this->db->where('up.verified', self::TRUE_ACTIVE);
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('s.deleted_at', NULL);
//        $this->db->where('m.deleted_at', NULL);
//
//
//        $this->db->order_by("up.name", "asc");
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function participants_listing($organization_id) {
//        $this->db->select(' id,
//                            profile_id,
//                            adv_id,
//                            name,
//                            email,
//                            contact_mobile,
//                            employee_id');
//
//        $this->db->from('ssc_member.employee');
//        //$this->db->join('ssc_member.employee AS ra', 'ra.profile_id = up.id');
//        //$this->db->join('ssc_member.adv_priority_hirer AS a', 'a.id = ra.adv_id');
//        $this->db->like('adv_id', $organization_id);
//
//        //$this->db->where('up.verified', self::TRUE_ACTIVE);
//        //$this->db->where('up.deleted_at', NULL);
//        //$this->db->where('a.deleted_at', NULL);
//        $this->db->where('deleted_at', NULL);
//
//        //$this->db->order_by("up.name", "asc");
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_PARTICIPANT_LISTING);
//            $this->response_message->set_message(self::CODE_PARTICIPANT_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_PARTICIPANT_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_PARTICIPANT_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    ////activity listing
//    public function activity_listing_by_profile_id($profile_id) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->get_activity_listing($profile_id);
//
//        // print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_ACTIVITY_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ACTIVITY_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_ACTIVITY_LISTING, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    /*
//     * Abdul Shamadhu
//     * Date : 26-01-2015
//     * Member Transaction History Listing Start
//     */
//
//    public function get_paymentmodes() {
//        $this->db->select('d.payment_mode_id,d.payment_name,d.payment_code');
//        $this->db->from('ssc_payment.payment_mode AS d');
//        $this->db->where('d.is_active', 'Y');
//        $this->db->where('d.deleted_at is NULL');
//        $query = $this->db->get();
//
//        $this->db->select('c.id as payment_mode_id,c.code_name as payment_name,c.display_name as payment_code');
//        $this->db->from('ssc_common.cd_sys_code AS c');
//        $this->db->where('c.group_id', 30);
//        $this->db->where('c.deleted_at is NULL');
//        $query2 = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            $qry1 = $query->result_array();
//            $qry2 = $query2->result_array();
//            $result = array_merge($qry1, $qry2);
//            $message = $this->common_config_model->get_message(self::CODE_PAYMENT_MODE);
//            $this->response_message->set_message(self::CODE_PAYMENT_MODE, $message, array(RESULTS => $result));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//            $this->response_message->set_message(self::CODE_DATA_LISTING, $message);
//            return FALSE;
//        }
//    }
//
//    public function member_transaction_history($profile_id, array $sys_code_ids = NULL, array $payment_mode_ids = NULL, $date_from = NULL, $date_to = NULL, $page = NULL, $limit = NULL) {
//        $this->load->model('common/common_service_model');
//        //echo '<pre>';print_r($payment_mode_ids);exit;
//        $jsonResponse = $this->common_service_model->get_member_transaction_history_listing($profile_id, $sys_code_ids, $payment_mode_ids, $date_from, $date_to, $page, $limit);
//        // print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//            $message = $this->common_config_model->get_message(self::CODE_ACTIVITY_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ACTIVITY_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_ACTIVITY_LISTING, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    ////org ewallet listing
//    public function ewallet_listing_grant($organization_id, $include_grant) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->get_ewallet_listing_grant($organization_id, 'corporate_user', $include_grant);
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//            $message = $this->common_config_model->get_message(self::CODE_EWALLET_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_EWALLET_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_EWALLET_LISTING, array(RESULTS => $jsonResponse[RESULTS]));
//            return TRUE;
//        }
//    }
//
//    public function org_transaction_history($org_id = NULL, $profile_id = NULL, array $payment_mode_ids = NULL, $date_from = NULL, $date_to = NULL, $page = NULL, $limit = NULL) {
//        $this->db->select('d.receiptID,d.refundID,d.transaction_at,d.ewallet_type,d.ewallet_name,d.transaction_type_id,d.amount,d.last_balance');
//        $this->db->from('ssc_payment.ewallet_movement_record AS d');
//        $this->db->where('d.amount <>', 0.0);
//        $this->db->where('d.deleted_at is NULL');
//
//        if (isset($org_id) && $org_id != NULL) {
//            $this->db->where('d.org_id', $org_id);
//        }
//
//        if (isset($profile_id) && $profile_id != NULL) {
//            $this->db->where('d.profile_id', $profile_id);
//        }
//
//        if (isset($payment_mode_ids) && $payment_mode_ids[0] != "NULL") {
//            $this->db->where_in('d.ewallet_type', $payment_mode_ids);
//        }
//
//        if ((isset($date_from) && $date_from != NULL) && (isset($date_to) && $date_to != NULL)) {
//            $whereQuery = "(DATE(`d`.`transaction_at`) >= '$date_from' AND DATE(`d`.`transaction_at`) <= '$date_to')";
//            $this->db->where($whereQuery);
//        }
//        $this->db->order_by('d.transaction_at', 'DESC');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $result = $query->result_array();
//            $total = count($result);
//            //echo "<pre>";print_r($result);exit;
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//            $message = $this->common_config_model->get_message(self::CODE_ACTIVITY_LISTING);
//            $this->response_message->set_message(self::CODE_ACTIVITY_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_ACTIVITY_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ACTIVITY_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /*
//     * Abdul Shamadhu
//     * Date : 26-01-2015
//     * Member Transaction History Listing End
//     */
//
//    ////Detail activity
//    public function activity_detail($invoice_id) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->get_invoice_details($invoice_id);
//
//        // print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_ACTIVITY_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ACTIVITY_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_ACTIVITY_DETAIL, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    ////shopping cart check+pout
//    /* public function checkout($profileId, $shoppingCartId, $payment_code,$amount,$ewalletPassCode=NULL,$transaction_id=NULL){
//
//      $totalAmount = $amount;
//
//      if($payment_code=='ewallet')
//      {
//      $paymentDetails = array(
//      array(
//      'payment_code'      => 'ewallet',
//      'ewallet_passcode'  => $ewalletPassCode,
//      'amount'            => $totalAmount));
//      }
//      else if($payment_code=='credit_card')
//      {
//      $paymentDetails = array(
//      array(
//      'payment_code'      => 'credit_card',
//      'transaction_id'    => $transaction_id,
//      'amount'            => $totalAmount));
//      }
//      else if($payment_code=='cash')
//      {
//      $paymentDetails = array(
//      array(
//      'payment_code'      => 'cash',
//      'amount'            => $totalAmount));
//      }
//      else if($payment_code=='cheque')
//      {
//      $paymentDetails = array(
//      array(
//      'payment_code'      => 'cheque',
//      'amount'            => $totalAmount));
//      }
//      else if($payment_code=='enets')
//      {
//      $paymentDetails = array(
//      array(
//      'payment_code'      => 'enets',
//      //'transaction_id'    => @$transaction_id,
//      'amount'            => $totalAmount));
//      }
//
//      return $this->_checkout($profileId, $shoppingCartId, $paymentDetails);
//
//      } */
//
//    public function checkout($ipAddress, $shopping_cart_id, array $payment_list, $organization_id = NULL, $adminId, $profile_id, $venue_id) {
//        $paymentDetails = json_encode($payment_list);
//
//        //print_r($paymentDetails);die;
//
//        $this->load->model('common/common_service_model');
//        $response = $this->common_service_model->checkout($ipAddress, $shopping_cart_id, $profile_id, $paymentDetails, $venue_id);
//
//        if (!$response) {
//            //Problem with e wallet
//            if ($this->response_message->get_status_code() == SSC_HEADER_INTERNAL_SERVER_ERROR) {
//                $this->_response_with_code(self::CODE_CHECKOUT_SP_FAIL);
//            }
//            return FALSE;
//        }
//
//        $statusCode = $response[STATUS_CODE];
//        $results = $response[RESULTS];
//
//
//        $this->_response_with_code($statusCode, array(RESULTS => $results));
//        return TRUE;
//    }
//
//    private function _checkout($profileId, $shoppingCartId, $paymentList) {
//
//        $paymentDetails = json_encode($paymentList);
//        $this->load->model('common/common_service_model');
//        $response = $this->common_service_model->checkout($shoppingCartId, $profileId, $paymentDetails);
//
//        /* if($jsonResponse === FALSE) {
//
//          $message = $this->common_config_model->get_message(self::CODE_CHECKOUT_SP_FAIL);
//          $this->response_message->set_message(self::CODE_CHECKOUT_SP_FAIL, $message);
//          return FALSE;
//          }
//          else
//          {
//          $this->_response_with_code(self::CODE_CHECKOUT_SP_SUCCESSFUL, array(RESULTS => $jsonResponse));
//          return TRUE;
//          } */
//        if (!$response) {
//            //Problem with e wallet
//            if ($this->response_message->get_status_code() == SSC_HEADER_INTERNAL_SERVER_ERROR) {
//                $this->_response_with_code(self::CODE_CHECKOUT_SP_FAIL);
//            }
//            return FALSE;
//        }
//
//        $statusCode = $response[STATUS_CODE];
//        $results = $response[RESULTS];
//
//
//        $this->_response_with_code($statusCode, array(RESULTS => $results));
//        return TRUE;
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function condition_group_listing() {
//        $this->db->select(' id,
//                            condition_group_code,
//                            display_name');
//
//        $this->db->from('ssc_common.condition_group');
//        $this->db->where('deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_CONDITION_GROUP_LISTING);
//            $this->response_message->set_message(self::CODE_CONDITION_GROUP_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_CONDITION_GROUP_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_CONDITION_GROUP_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function condition_code_listing($condition_group_code) {
//        $this->db->select(' id,
//                            condition_code_code,
//                            condition_code_rule,
//                            display_name');
//
//        $this->db->from('ssc_common.condition_code');
//        $this->db->where('condition_group_code', $condition_group_code);
//        $this->db->where('deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_CONDITION_CODE_LISTING);
//            $this->response_message->set_message(self::CODE_CONDITION_CODE_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_CONDITION_CODE_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_CONDITION_CODE_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function role_listing() {
//        $this->db->select(' id,
//                            role_name');
//
//        $this->db->from('ssc_member.public_user_role');
//        $this->db->where('is_org', 'Y');
//        $this->db->where('deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_ROLE_LISTING);
//            $this->response_message->set_message(self::CODE_ROLE_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_ROLE_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ROLE_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function all_role_listing() {
//        $this->db->select(' id,
//                            role_name');
//
//        $this->db->from('ssc_member.public_user_role');
//        $this->db->where('deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_ROLE_LISTING);
//            $this->response_message->set_message(self::CODE_ROLE_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_ROLE_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ROLE_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /////create add on
//    public function create_add_on($data_b, $role_id, $condition_group = NULL, $condition_code = NULL, $admin) {
//        //////add member benefit
//        $data_b['created_at'] = date('Y-m-d H:i:s');
//        $data_b['created_by'] = $admin;
//        $benefit_id = $this->common_add('ssc_member.member_benefits', $data_b);
//
//        /////add member add on
//        $data_a = array();
//        $data_a['benefit_id'] = $benefit_id;
//        $data_a['role_id'] = $role_id;
//        $data_a['created_at'] = date('Y-m-d H:i:s');
//        $data_a['created_by'] = $admin;
//        $add_on_id = $this->common_add('ssc_member.member_add_on', $data_a);
//
//        if (!$condition_group) {
//            $data_c = array();
//            $data_c['add_on_id'] = $add_on_id;
//            $data_c['condition_group_code'] = NULL;
//            $data_c['condition_code'] = NULL;
//            $data_c['created_at'] = date('Y-m-d H:i:s');
//            $data_c['created_by'] = $admin;
//            $this->common_add('ssc_member.member_add_on_conditions', $data_c);
//        } else {
//            /////add member add on condition
//            $arr_condition_group = explode(",", $condition_group);
//            $arr_condition_code = explode(",", $condition_code);
//
//            $count = count($arr_condition_group);
//            for ($i = 0; $i < $count; $i++) {
//                $data_c = array();
//                $data_c['add_on_id'] = $add_on_id;
//                $data_c['condition_group_code'] = $arr_condition_group[$i];
//                $data_c['condition_code'] = $arr_condition_code[$i];
//                $data_c['created_at'] = date('Y-m-d H:i:s');
//                $data_c['created_by'] = $admin;
//                $this->common_add('ssc_member.member_add_on_conditions', $data_c);
//            }
//        }
//
//        if ($add_on_id) {
//            $message = $this->common_config_model->get_message(self::CODE_CREATE_ADD_ON);
//            $this->response_message->set_message(self::CODE_CREATE_ADD_ON, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_FAIL);
//            $this->response_message->set_message(self::CODE_ADD_ON_FAIL, $message);
//            return FALSE;
//        }
//    }
//
//    ///////add on listing
//    public function _add_on_listing() {
//        $data_return = array();
//        $this->db->select(' id,
//                            name,
//                            price,
//                            swim_pass,
//                            swim_expired_period,
//                            gym_pass,
//                            gym_expired_period');
//
//        $this->db->from('ssc_member.member_benefits');
//        $this->db->where('deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row) {
//                if ($row['swim_pass'] == '-1') {
//                    $row['swim_pass'] = 'Unlimited';
//                }
//                if ($row['gym_pass'] == '-1') {
//                    $row['gym_pass'] = 'Unlimited';
//                }
//                $data_return[] = $row;
//            }
//
//            return $data_return;
//        } else {
//
//            return FALSE;
//        }
//    }
//
//    public function add_on_listing($page, $limit) {
//        $result = $this->_add_on_listing();
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_LISTING);
//            $this->response_message->set_message(self::CODE_ADD_ON_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ADD_ON_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /////update add on
//    public function update_add_on($id, $data_b, $role_id, $condition_group, $condition_code, $admin) {
//        //////update member benefit
//        $data_b['updated_by'] = $admin;
//        $this->common_edit('ssc_member.member_benefits', 'id', $id, $data_b);
//
//        /////update member add on
//        $data_a = array();
//        $data_a['role_id'] = $role_id;
//        $data_a['updated_by'] = $admin;
//        $this->common_edit('ssc_member.member_add_on', 'benefit_id', $id, $data_a);
//
//        /////get add_on_id by benefit id
//        $this->db->select('id');
//        $this->db->from('ssc_member.member_add_on');
//        $this->db->where('benefit_id', $id);
//        $this->db->where('deleted_at', NULL);
//        $query = $this->db->get();
//        $add_on_id = $query->row()->id;
//        $this->common_delete('member_add_on_conditions', 'add_on_id', $add_on_id);
//
//        /////add member add on condition
//        $arr_condition_group = explode(",", $condition_group);
//        $arr_condition_code = explode(",", $condition_code);
//
//        $count = count($arr_condition_group);
//        for ($i = 0; $i < $count; $i++) {
//            $data_c = array();
//            $data_c['add_on_id'] = $add_on_id;
//            $data_c['condition_group_code'] = $arr_condition_group[$i];
//            $data_c['condition_code'] = $arr_condition_code[$i];
//            $data_c['created_at'] = date('Y-m-d H:i:s');
//            $data_c['created_by'] = $admin;
//            $this->common_add('ssc_member.member_add_on_conditions', $data_c);
//        }
//
//        if ($add_on_id) {
//            $message = $this->common_config_model->get_message(self::CODE_UPDATE_ADD_ON);
//            $this->response_message->set_message(self::CODE_UPDATE_ADD_ON, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_UPDATE_ADD_ON_FAIL);
//            $this->response_message->set_message(self::CODE_UPDATE_ADD_ON_FAIL, $message);
//            return FALSE;
//        }
//    }
//
//    ///////add on detail
//    public function add_on_detail($id) {
//
//        $this->db->select(' b.id,
//                            b.name,
//                            b.price,
//                            b.swim_pass,
//                            b.swim_expired_period,
//                            b.swim_passtype_id,
//                            b.gym_pass,
//                            b.gym_passtype_id,
//                            b.gym_expired_period,
//                            a.id as add_on_id,
//                            a.role_id,
//                            b.add_on_type,
//                            b.description as mobile_description,
//                            b.web_description,
//                            b.display_seq
//                            ');
//
//        $this->db->from('ssc_member.member_benefits AS b');
//        $this->db->join('ssc_member.member_add_on As a', 'a.benefit_id = b.id');
//
//        $this->db->where('b.id', $id);
//        $this->db->where('b.deleted_at', NULL);
//        $this->db->where('a.deleted_at', NULL);
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            $row = $query->row();
//            $add_on_id = $row->add_on_id;
//
//            $this->db->select('id,
//                               condition_group_code,
//                               condition_code');
//
//            $this->db->from('ssc_member.member_add_on_conditions');
//            $this->db->where('add_on_id', $add_on_id);
//            $this->db->where('deleted_at', NULL);
//            $query = $this->db->get();
//            $condition = $query->result_array();
//
//
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_DETAIL);
//            $this->response_message->set_message(self::CODE_ADD_ON_DETAIL, $message, array(RESULTS => $row, 'conditions' => $condition));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ADD_ON_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    /////delete add on
//    public function add_on_delete($id) {
//
//        $id = $this->common_delete('ssc_member.member_benefits', 'id', $id);
//
//        if ($id) {
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_DELETE);
//            $this->response_message->set_message(self::CODE_ADD_ON_DELETE, $message);
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_UPDATE_ADD_ON_FAIL);
//            $this->response_message->set_message(self::CODE_UPDATE_ADD_ON_FAIL, $message);
//            return FALSE;
//        }
//    }
//
//    /////delete add on
//    public function join_add_on($profile_id, $add_on_type, $admin_id) {
//        $dob = $this->_get_dob($profile_id);
//        $role = $this->_get_role($profile_id);
//        $success = 0;
//        $role_found = 0;
//
//        if ($dob) {
//            $age = $this->calculate_age($dob);
//            $this->db->select('b.id,b.price,b.swim_pass,b.swim_expired_period,b.swim_passtype_id,b.gym_pass,b.gym_passtype_id,b.gym_expired_period,c.add_on_id,c.condition_group_code,c.condition_code,a.role_id');
//            $this->db->from('ssc_member.member_benefits AS b');
//            $this->db->join('ssc_member.member_add_on As a', 'a.benefit_id = b.id');
//            $this->db->join('ssc_member.member_add_on_conditions As c', 'c.add_on_id = a.id');
//
//            $this->db->where('b.add_on_type', $add_on_type);
//            $this->db->where('c.deleted_at', NULL);
//            $this->db->where('b.deleted_at', NULL);
//            $this->db->where('a.deleted_at', NULL);
//            $query = $this->db->get();
//
//            //print_r($query->result_array());die;
//
//            if ($query->num_rows() > 0) {
//                foreach ($query->result_array() as $row_cer) {
//                    ///////check role first
//                    $role_id = $row_cer['role_id'];
//                    $arr_role = explode(',', $role_id);
//                    $count_r = count($arr_role);
//                    for ($i = 0; $i < $count_r; $i++) {
//                        if ($arr_role[$i] == $role) {
//                            $role_found = 1;
//                        }
//                    }
//
//
//                    if ($role_found == 0) {
//                        $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_APPLICABLE);
//                        $this->response_message->set_message(self::CODE_ADD_ON_NOT_APPLICABLE, $message);
//                        return FALSE;
//                    }
//                    /////////
//
//                    $benefit_id = $row_cer['id'];
//                    $condition_group_code = $row_cer['condition_group_code'];
//                    if (!$condition_group_code) {
//                        $ipAddress = $this->input->ip_address();
//
//                        //////////save swim pass to database
//                        $swim_pass = @$row_cer['swim_pass']; //
//                        if (@$swim_pass != NULL && @$swim_pass > 0) {
//                            $swim_expired_period = $row_cer['swim_expired_period'];
//                            $month = "+" . $swim_expired_period . " month";
//
//                            $date = new DateTime();
//                            $date->add(DateInterval::createFromDateString($month));
//                            ////////////////////////
//                            $swim_passtype_id = $row_cer['swim_passtype_id']; //
//                            $data = $this->facility_model->issue_pass($ipAddress, $admin_id, $profile_id, $swim_passtype_id, (int) $swim_pass, $date);
//                            if ($data) {
//                                $success = 1;
//                            }
//                        }
//
//                        //////////save swim pass to database
//                        $gym_pass = @$row_cer['gym_pass']; //
//                        if (@$gym_pass != NULL && @$gym_pass > 0) {
//                            $gym_expired_period = $row_cer['gym_expired_period'];
//                            $month = "+" . $gym_expired_period . " month";
//
//                            $date = new DateTime();
//                            $date->add(DateInterval::createFromDateString($month));
//                            ////////////////////////
//                            $gym_passtype_id = $row_cer['gym_passtype_id']; //
//                            $data = $this->facility_model->issue_pass($ipAddress, $admin_id, $profile_id, $gym_passtype_id, (int) $gym_pass, $date);
//                            if ($data) {
//                                $success = 1;
//                            }
//                        }
//
//                        if ($success == 1) {
//                            ////save account addon relation table
//                            $data_c = array();
//                            $data_c['benefit_id'] = $benefit_id;
//                            $data_c['profile_id'] = $profile_id;
//                            $data_c['created_at'] = date('Y-m-d H:i:s');
//                            $data_c['created_by'] = $admin_id;
//                            $this->common_add('ssc_member.member_addon_relation', $data_c);
//
//                            $message = $this->common_config_model->get_message(self::CODE_ACCOUNT_ADD_ON_CREATE);
//                            $this->response_message->set_message(self::CODE_ACCOUNT_ADD_ON_CREATE, $message);
//                            return TRUE;
//                        } else {
//                            $message = $this->common_config_model->get_message(self::CODE_ACCOUNT_ADD_ON_FAILL);
//                            $this->response_message->set_message(self::CODE_ACCOUNT_ADD_ON_FAIL, $message);
//                            return FALSE;
//                        }
//                    } else if ($condition_group_code == self::ADD_ON_AGE) {
//                        $condition_code = $row_cer['condition_code'];
//                        $price = $row_cer['price'];
//                        $ipAddress = $this->input->ip_address();
//
//                        $result = $this->_is_valid_condition($condition_code, $age);
//                        if ($result) {
//                            //////////save swim pass to database
//                            $swim_pass = @$row_cer['swim_pass']; //
//                            if (@$swim_pass != NULL && @$swim_pass > 0) {
//                                $swim_expired_period = $row_cer['swim_expired_period'];
//                                $month = "+" . $swim_expired_period . " month";
//
//                                $date = new DateTime();
//                                $date->add(DateInterval::createFromDateString($month));
//                                ////////////////////////
//                                $swim_passtype_id = $row_cer['swim_passtype_id']; //
//                                $data = $this->facility_model->issue_pass($ipAddress, $admin_id, $profile_id, $swim_passtype_id, (int) $swim_pass, $date);
//                                if ($data) {
//                                    $success = 1;
//                                }
//                            }
//
//                            //////////save swim pass to database
//                            $gym_pass = @$row_cer['gym_pass']; //
//                            if (@$gym_pass != NULL && @$gym_pass > 0) {
//                                $gym_expired_period = $row_cer['gym_expired_period'];
//                                $month = "+" . $gym_expired_period . " month";
//
//                                $date = new DateTime();
//                                $date->add(DateInterval::createFromDateString($month));
//                                ////////////////////////
//                                $gym_passtype_id = $row_cer['gym_passtype_id']; //
//                                $data = $this->facility_model->issue_pass($ipAddress, $admin_id, $profile_id, $gym_passtype_id, (int) $gym_pass, $date);
//                                if ($data) {
//                                    $success = 1;
//                                }
//                            }
//
//                            if ($success == 1) {
//                                ////save account addon relation table
//                                $data_c = array();
//                                $data_c['benefit_id'] = $benefit_id;
//                                $data_c['profile_id'] = $profile_id;
//                                $data_c['created_at'] = date('Y-m-d H:i:s');
//                                $data_c['created_by'] = $admin_id;
//                                $this->common_add('ssc_member.member_addon_relation', $data_c);
//
//                                $message = $this->common_config_model->get_message(self::CODE_ACCOUNT_ADD_ON_CREATE);
//                                $this->response_message->set_message(self::CODE_ACCOUNT_ADD_ON_CREATE, $message);
//                                return TRUE;
//                            } else {
//                                $message = $this->common_config_model->get_message(self::CODE_ACCOUNT_ADD_ON_FAILL);
//                                $this->response_message->set_message(self::CODE_ACCOUNT_ADD_ON_FAIL, $message);
//                                return FALSE;
//                            }
//                        } else {
//                            ///invalid condition
//                            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NO_CONDITION);
//                            $this->response_message->set_message(self::CODE_ADD_ON_NO_CONDITION, $message);
//                            return FALSE;
//                        }
//                    } else {
//                        //no condition
//                        $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NO_CONDITION);
//                        $this->response_message->set_message(self::CODE_ADD_ON_NO_CONDITION, $message);
//                        return FALSE;
//                    }
//                }//for each
//            }//no data
//            else {
//                //add on not found
//                $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_FOUND);
//                $this->response_message->set_message(self::CODE_ADD_ON_NOT_FOUND, $message);
//                return FALSE;
//            }
//        }
//    }
//
//    public function _get_dob($profile_id) {
//        $this->db->select('u.dob');
//        $this->db->from('ssc_member.user_profile u');
//        $this->db->where('u.id', $profile_id);
//        $this->db->where('u.verified', 'Y');
//        $this->db->where('u.deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return @$query->row()->dob;
//        } else {
//            return False;
//        }
//    }
//
//    public function _get_role($profile_id) {
//        $this->db->select('role_id');
//        $this->db->from('ssc_member.public_user_map_role');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//        $this->db->limit(1);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return @$query->row()->role_id;
//        } else {
//            return False;
//        }
//    }
//
//    public function _has_ordinary_hirer($profile_id) {
//        $this->db->select('id');
//        $this->db->from('ssc_member.ordinary_hirer');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//        $this->db->limit(1);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return @$query->row()->id;
//        } else {
//            return False;
//        }
//    }
//
//    public function get_add_on_type() {
//        $this->db->select('max(add_on_type) as add_on_type');
//        $this->db->from('ssc_member.member_benefits');
//        $this->db->where('deleted_at is NULL');
//        $this->db->limit(1);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return @$query->row()->add_on_type;
//        } else {
//            return False;
//        }
//    }
//
//    public function calculate_age($dob) {
//        $age = floor((strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
//        return $age;
//    }
//
//    /////account addon search
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function _account_addon_search($keyword, $search) {
//        $data_return = array();
//        $this->db->select(' up.id,
//                            up.name,
//                            up.email,
//                            up.contact_mobile,
//                            up.contact_home,
//                            up.address,
//                            up.gender,
//                            up.identity_number
//                            ');
//
//        $this->db->from('ssc_member.user_profile AS up');
//        $this->db->join('ssc_member.member_addon_relation AS b', 'b.profile_id = up.id');
//
//
//        //$this->db->where('la.user_name', $keyword);
//        $arr_search = explode(',', $search);
//        $arr_keyword = explode(',', $keyword);
//
//        $count = count($arr_search);
//        for ($i = 0; $i < $count; $i++) {
//            if ($arr_search[$i] == 'id') {
//                $this->db->like('up.identity_number', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'name') {
//                $this->db->like('up.name', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'email') {
//                $this->db->like('up.email', @$arr_keyword[$i], 'both');
//            }
//            if ($arr_search[$i] == 'mobile_number') {
//                $this->db->like('up.contact_mobile', @$arr_keyword[$i], 'both');
//            }
//        }
//        $this->db->where('up.deleted_at', NULL);
//        $this->db->where('b.deleted_at', NULL);
//
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                $profile_id = $row_cer['id'];
//                $result = $this->facility_model->get_all_passes($profile_id);
//                if (empty($result)) {
//                    //return FALSE;
//                } else {
//                    $data = $this->response_message->get_message();
//                    $data1 = $data['results'];
//                    $row_cer['passes'] = $data1;
//                    $data_return[] = $row_cer;
//                }
//            }
//            return $data_return;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function account_addon_search($keyword, $search, $page, $limit) {
//        $result = $this->_account_addon_search($keyword, $search);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_LISTING);
//            $this->response_message->set_message(self::CODE_MEMBER_LISTING, $message, array(RESULTS => $result, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function test_data(array $addons) {
//        print_r($addons);
//        foreach ($addons as $addon) {
//
//            $item_id = $addon->id;
//            $p_id = $addon->profile_id;
//
//            $fruits[] = array("id" => $item_id, "p_id" => $p_id);
//            print_r($fruits);
//
//            //////call and save to database
//            echo $item_id;
//            die;
//        }
//    }
//
//    /**
//     * @author Wai Tun
//     * @since  9 FEB 2014
//     *
//     * @param $keyword
//     * @return Array|FALSE
//     */
//    public function platform_listing() {
//        $this->db->select('platform');
//        $this->db->from('ssc_member.registration_channel');
//        $this->db->where('deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->result_array();
//
//            $message = $this->common_config_model->get_message(self::CODE_PLATFORM_LISTING);
//            $this->response_message->set_message(self::CODE_PLATFORM_LISTING, $message, array(RESULTS => $row));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_PLATFORM_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_PLATFORM_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    ////common use
//    public function get_initial_amount($role_id) {
//        $this->db->select('initial_credit');
//
//        $this->db->from('ssc_member.membership_config');
//        $this->db->where('role_id', $role_id);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        return @$query->row()->initial_credit;
//    }
//
//    public function _related_account_listing($profile_id) {
//        $role_id = $this->_get_role($profile_id);
//        if ($role_id == 2) {
//            $this->db->select('u.id,u.name,u.identity_number,r.role_name,u.profile_picture,u.email,u.contact_mobile,u.gender');
//            $this->db->from('relationship re');
//            $this->db->join('user_profile u', 'u.id = re.supplementary_user_profile_id');
//            $this->db->join('public_user_map_role p', 'u.id = p.profile_id');
//            $this->db->join('public_user_role r', 'p.role_id = r.id');
//
//            $this->db->where('re.profile_id', $profile_id);
//            $this->db->where('u.verified', 'Y');
//            $this->db->where('re.deleted_at is NULL');
//            $this->db->where('u.deleted_at is NULL');
//            $this->db->where('p.deleted_at is NULL');
//            $this->db->where('r.deleted_at is NULL');
//        } else if ($role_id == 3) {
//            $this->db->select('u.id,u.name,u.identity_number,r.role_name,u.profile_picture,u.email,u.contact_mobile,u.gender');
//            $this->db->from('relationship re');
//            $this->db->join('user_profile u', 'u.id = re.profile_id');
//            $this->db->join('public_user_map_role p', 'u.id = p.profile_id');
//            $this->db->join('public_user_role r', 'p.role_id = r.id');
//
//            $this->db->where('re.supplementary_user_profile_id', $profile_id);
//            $this->db->where('u.verified', 'Y');
//            $this->db->where('re.deleted_at is NULL');
//            $this->db->where('u.deleted_at is NULL');
//            $this->db->where('p.deleted_at is NULL');
//            $this->db->where('r.deleted_at is NULL');
//        }
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->result_array();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function related_account_listing($profile_id, $page, $limit) {
//        $result = $this->_related_account_listing($profile_id);
//
//        if (!empty($result)) {
//            $total = count($result);
//            $image = $this->get_folders(self::S3_FOLDER);
//            $result = $this->_filter_with_pagination($result, $page, $limit);
//
//            $message = $this->common_config_model->get_message(self::CODE_RELATED_ACCOUNT_LISTING);
//            $this->response_message->set_message(self::CODE_RELATED_ACCOUNT_LISTING, $message, array(RESULTS => $result, FOLDER => $image, TOTAL => $total));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    ////shopping cart extend expire
//    public function generate_qrcode($identity_number) {
//        $this->load->model('common/common_service_model');
//        $dateTime = new DateTime();
//        $uniqueCode = self::PASS_PREFIX . '-' . $identity_number . '-' . $dateTime->format('ymdHis');
//        $response = $this->common_service_model->generate_qr($uniqueCode, self::PASS_FOLDER);
//        if (!$response || !isset($response[RESULTS])) {
//            //Unable to generate QR code
//            return false;
//        }
//        $qrFile = $response[RESULTS];
//        return @$qrFile;
//    }
//
//    public function get_address_by_postalcode($postalcode) {
//        $address = $this->_get_address_by_postalcode($postalcode);
//
//        if ($address) {
//            $message = $this->common_config_model->get_message(self::CODE_POSTAL_CODE_INFO);
//            $this->response_message->set_message(self::CODE_POSTAL_CODE_INFO, $message, array(RESULTS => $address));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_POSTAL_CODE_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_POSTAL_CODE_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function _get_address_by_postalcode($postal_code) {
//        $cacheKey = 'postalcode-' . $postal_code;
//
//        if (!$address = $this->get_elasticache($cacheKey)) {
//            $address = $this->__get_address_by_postalcode($postal_code);
//            $this->set_elasticache($cacheKey, $address);
//        }
//
//        return $address;
//    }
//
//    protected function __get_address_by_postalcode($postal_code) {
//        $this->db->select('blk, buildingname, streetname, addresstype, latitude, longitude');
//        $this->db->from('postalcode');
//        $this->db->where('postcode', $postal_code);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function create_admin_user($data) {
//        $name = $data['name'];
//        $email = $data['email'];
//
//        if ($data['contact_mobile']) {
//            $contact_mobile = $data['contact_mobile'];
//        } else {
//            $contact_mobile = '';
//        }
//
//        $dob = $data['dob'];
//        $gender = $data['gender'];
//        $password1 = $data['password'];
//        $venue = $data['venue'];
//        $role = $data['role'];
//        $group_id = $data['group_id'];
//
//        $staff_nric = $data['staff_nric'];
//        $employee_id = $data['employee_id'];
//        $salutation_id = $data['salutation_id'];
//
//        ///check valid NRIC
//        if ($staff_nric) {
//            if (!$this->valid_nric($staff_nric)) {
//                $message = $this->common_config_model->get_message(self::CODE_INVALID_NRIC);
//                $this->response_message->set_message(self::CODE_INVALID_NRIC, $message);
//                return FALSE;
//            }
//        }
//
//        ///check staff_nric is unique
//        if ($staff_nric) {
//            $check_nric = $this->check_unique_staff_nric($staff_nric);
//            if ($check_nric) {
//                $message = $this->common_config_model->get_message(self::CODE_IDENTITY_EXIST);
//                $this->response_message->set_message(self::CODE_IDENTITY_EXIST, $message);
//                return FALSE;
//            }
//        }
//
//        //echo $this->input->post('group_id');die;
//        if (!$this->validate_email($email)) {
//            $message = $this->common_config_model->get_message(self::CODE_INVALID_EMAIL);
//            $this->response_message->set_message(self::CODE_INVALID_EMAIL, $message);
//            return FALSE;
//        }
//        //check valid mobile number?
//        if ($contact_mobile) {
//            if (!$this->validate_phone($contact_mobile)) {
//                $message = $this->common_config_model->get_message(self::CODE_INVALID_MOBILE);
//                $this->response_message->set_message(self::CODE_INVALID_MOBILE, $message);
//                return FALSE;
//            }
//        }
//
//        if ($dob && !$this->is_dob($dob)) {
//            $message = $this->common_config_model->get_message('1164');
//            $this->response_message->set_message('1164', $message);
//            return FALSE;
//        }
//
//        if ($gender != 'M' && $gender != 'F') {
//            $message = $this->common_config_model->get_message(self::CODE_INVALID_GENDER);
//            $this->response_message->set_message(self::CODE_INVALID_GENDER, $message);
//            return FALSE;
//        }
//
//        if ($password1) {
//            //check valid password?
//            // if(!$this->validate_password($password1))
//            // {
//            //     $message = $this->common_config_model->get_message(self::CODE_INVALID_PASSWORD);
//            //     $this->response_message->set_message(self::CODE_INVALID_PASSWORD, $message);
//            //     return FALSE;
//            // }
//            $this->load->library('PasswordPolicy');
//            // $this->passwordpolicy->set_password_history($result);
//            $this->passwordpolicy->set_name_email($name, $email);
//            $isValid = $this->passwordpolicy->validate($password1);
//
//            if (!$isValid) {
//                $this->response_message->set_message(1500, $this->passwordpolicy->get_error_message());
//                return FALSE;
//            }
//
//            $password_p = $password1;
//        } else {
//            //generate password
//            $password_p = $this->account_model->generate_salt();
//        }
//
//        ///generate the password
//        $salt = $this->generate_salt();
//        $password = $this->generate_password($password_p, $salt);
//
//        ///////data array for user profile table
//        $data = array();
//        $data['name'] = @$name;
//        $data['email'] = $email ? $email : NULL;
//        $data['gender'] = $gender ? $gender : NULL;
//        $data['dob'] = $dob ? $dob : NULL;
//        $data['salt'] = $salt;
//        $data['verified'] = 'Y';
//
//
//        ////////check email,mobile no,identity number is unique
//        $check_data = $this->check_unique(NULL, NULL, $email, NULL);
//        //print_r($check_data);die;
//        if ($check_data) {
//            //print_r($check_data);die;
//            if ($check_data->verified == 'N') {//not verified
//                $profile_id = $check_data->id;
//                //Before data save, clear account login table
//                $this->save_log('profile_id', $check_data->id, 'ssc_member.login_account', 'ssc_log.hist_login_account', $this->input->ip_address(), self::ACTION_DELETE);
//                $this->common_delete('login_account', 'profile_id', $check_data->id);
//
//                //update the database
//                // log_message('error', 'account_model:create_admin_user:4439 updating profile_id' . $check_data->id. ' with: '. print_r($data, TRUE));
//                $this->common_edit('user_profile', 'id', $check_data->id, $data);
//                $this->save_log('id', $check_data->id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $this->input->ip_address(), self::ACTION_UPDATE);
//            } else {//verified
//                if (@$email) {
//                    $check_email = $this->check_unique_email($email);
//                    if ($check_email) {
//                        $message = $this->common_config_model->get_message(self::CODE_EMAIL_EXIST);
//                        $this->response_message->set_message(self::CODE_EMAIL_EXIST, $message);
//                        return FALSE;
//                    }
//                }
//            }
//        } else {//no data
//            //Save to database
//            $data['created_at'] = date('Y-m-d H:i:s');
//            $data['platform'] = 'admin';
//
//            $profile_id = $this->common_add('ssc_member.user_profile', $data);
//            $this->save_log('id', $profile_id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $this->input->ip_address(), self::ACTION_CREATE);
//
//            // admin user is no more having public user role
//            // ///////data array for public user role
//            // $data=array();
//            // $data['profile_id']=@$profile_id;
//            // $data['role_id']=1;
//            // $data['created_at']=date('Y-m-d H:i:s');
//            // //Save to database
//            // $this->common_add('ssc_member.public_user_map_role',$data);
//            // ///////data array for ordinery hier
//            // $data=array();
//            // $data['profile_id']=@$profile_id;
//            // $data['created_at']=date('Y-m-d H:i:s');
//            // $data['active']='Y';
//            // $data['verified']='Y';
//            // //Save to database
//            // $this->common_add('ssc_member.ordinary_hirer',$data);
//        }
//
//        ///////data array for login account table
//        if ($email) {
//            $this->load->model('account/login_model', 'alm');
//            $this->load->model('account/access_token_model', 'atm');
//            $this->alm->setAdminId($this->_getAdminId());
//            $this->alm->setIsAdminAccount();
//
//            $account_id = $this->alm->createLogin($profile_id, $email, $password, 'Y', 'Y');
//
//            /////create access token
//            $access_token = $this->generate_token();
//            $this->atm->createToken($account_id, $access_token);
//        }
//
//        // save the password to the history
//        $this->load->model('account/account_password_model');
//        $this->account_password_model->insert_password_history($profile_id, $password, $salt, $this->_getAdminId());
//
//        /////save subscriber user
//        $data_s = array();
//        $data_s['profile_id'] = $profile_id;
//        $data_s['subscriber_id'] = 1;
//        $data_s['group_id'] = $group_id ? $group_id : NULL;
//
//        $data_s['staff_nric'] = $staff_nric ? $staff_nric : NULL;
//        $data_s['employee_id'] = $employee_id ? $employee_id : NULL;
//        $data_s['salutation_id'] = $salutation_id ? $salutation_id : NULL;
//        $data_s['contact_mobile'] = $contact_mobile ? $contact_mobile : NULL;
//
//        $data_s['active'] = 'Y';
//        $data_s['status'] = 'active';
//        $data_s['created_at'] = date('Y-m-d H:i:s');
//        $data_s['created_by'] = $this->_getAdminId();
//
//        //print_r($data_s);die;
//
//        $subscriber_id = $this->common_add('subscriber_user', $data_s);
//        $this->save_log('id', $subscriber_id, 'ssc_member.subscriber_user', 'ssc_log.hist_subscriber_user', $this->input->ip_address(), self::ACTION_CREATE);
//        /////save user role
//        $this->addAdminUserMapRole($profile_id, explode(",", $role));
//
//        /////save user venue
//        $this->addSubscriberUserMapVenue($subscriber_id, $venue, $this->_getAdminId());
//
//        if (!$password1) {
//            $url = self::admin_URL;
//            ///////send email
//            $description = "Dear " . $name . ",<br><br>Your account has been created.<br>Please login to your account using the following details:<br><br>User name: " . $email . "<br>Password: " . $password_p . "<br>URL: " . $url . "<br><br>All the best,<br>iAPPS Helpdesk";
//
//            $params = array();
//            $params['notification_type'] = 'email';
//            $params['recipient_id'] = $email;
//            $params['notification_text'] = $description;
//            $params['send_from'] = 'admin';
//            //$params['account_id']   = $profile_id;
//            $params['notification_subject'] = '[ActiveSG] Sucessfully registered';
//
//            //print_r($params);die;
//            $result11 = $this->notification_send($params);
//            //echo $result11;
//            //$this->load->helper('util');
//            //$result = doCurl(COMMON_SERVICE_URL."notification/i/send", $params, 'POST');
//        }
//
//        $message = $this->common_config_model->get_message(self::CODE_ACCOUNT_CREATE);
//        $this->response_message->set_message(self::CODE_ACCOUNT_CREATE, $message);
//        return TRUE;
//    }
//
//    public function addAdminUserMapRole($profileId, array $roles) {
//        $count = count($roles);
//        $data = array();
//        $now = date('Y-m-d H:i:s');
//
//        for ($i = 0; $i < $count; $i++) {
//            $data_r = array();
//            $data_r['profile_id'] = $profileId;
//            $data_r['role_id'] = $roles[$i];
//            $data_r['created_at'] = $now;
//            $data_r['created_by'] = $this->_getAdminId();
//
//            $data[] = $data_r;
//        }
//
//        if (!empty($data) && $this->db->insert_batch('ssc_member.admin_user_map_role', $data)) {
//            $this->save_log('profile_id', $profileId, 'ssc_member.admin_user_map_role', 'ssc_log.hist_admin_user_map_role', $this->input->ip_address(), self::ACTION_CREATE);
//            return true;
//        } else {
//            log_message('error', 'There is an error on inserting batch admin_user_map_role with values of: ' . json_encode($data));
//        }
//    }
//
//    public function addSubscriberUserMapVenue($subscriberId, $venue, $created_by) {
//        $venues = json_decode($venue);
//        $now = date('Y-m-d H:i:s');
//        $data = array();
//        if (count($venues) > 0) {
//            foreach ($venues as $k => $v) {
//                $data_v = array();
//                $data_v['subscriber_user_id'] = $subscriberId;
//                $data_v['fac_venue_id'] = $k;
//                $data_v['effective_from'] = $v->effective_from;
//                $data_v['effective_to'] = $v->effective_to;
//                $data_v['created_at'] = $now;
//                $data_v['created_by'] = $created_by;
//                $data[] = $data_v;
//            }
//        }
//        if (!empty($data) && $this->db->insert_batch('ssc_member.subscriber_user_map_venue', $data)) {
//            $this->save_log('subscriber_user_id', $subscriberId, 'ssc_member.subscriber_user_map_venue', 'ssc_log.hist_subscriber_user_map_venue', $this->input->ip_address(), self::ACTION_CREATE);
//            return true;
//        } else {
//            log_message('error', 'There is an error on inserting batch subscriber_user_map_venue with values of: ' . json_encode($data));
//        }
//    }
//
//    public function is_access($function, $adminID = NULL) {
//        $accessable = $this->_is_accessable($function, $adminID);
//        if (!$accessable) {
//            $this->_response_with_code(self::CODE_FORBIDDEN_FUNCTION);
//            return FALSE;
//        } else {
//            $message = $this->common_config_model->get_message('1122');
//            $this->response_message->set_message('1122', $message);
//            return TRUE;
//        }
//    }
//
//    ///////////////////
//    /**
//     * Get suspend_status
//     * @author Wai Tun
//     * @since 21 March 2014
//     */
//    public function get_suspend_status($adminId) {
//        $accessable = $this->_is_accessable(self::FUNCTION_SUSPEND_STATUS, $adminId);
//
//
//        if (!$accessable) {
//            return FALSE;
//        }
//
//        $fields = array();
//
//        if (isset($accessable->results)) {
//            $accR = $accessable->results;
//            if (isset($accR->fields)) {
//                $fields = $accR->fields;
//            }
//        }
//
//        $result = $this->common_config_model->get_group_data(self::SUSPEND_STATUS);
//
//        $result = $this->_filter_attributes($result, $fields, array(
//            'id',
//            'display_name'
//        ));
//
//        $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//        $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $result));
//        return TRUE;
//    }
//
//    ////otp_send
//    public function otp_send($data) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->otp_send($data);
//
//        //print_r($jsonResponse);
//        if ($jsonResponse === FALSE) {
//            return FALSE;
//        } else {
//            return TRUE;
//        }
//    }
//
//    ////otp_send
//    public function otp_validate($data) {
//        $this->load->model('common/common_service_model');
//        $response = $this->common_service_model->otp_validate($data);
//
//        if (!$response) {
//            //Problem with e wallet
//            if ($this->response_message->get_status_code() == SSC_HEADER_INTERNAL_SERVER_ERROR) {
//                $this->_response_with_code(self::CODE_OTP_FAIL);
//            }
//            return FALSE;
//        } else {
//            return TRUE;
//        }
//    }
//
//    ////otp_send
//    public function notification_send($data) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->notification_send($data);
//
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//            return FALSE;
//        } else {
//            return TRUE;
//        }
//    }
//
//    public function organization_ewallet_topup($adminId, $organization_id, $item_id, $item_name, $origin_price, $lat, $long, $profile_id) {
//        $srtTime = $this->_get_expiry_date_pos();
//        ///////get segment
//        $seg_id = self::SEG_WALLET_TOPUP;
//        $segment = $this->common_config_model->get_segment_code(
//                NULL, NULL, NULL, NULL, $seg_id, NULL
//        );
//
//        $shopping_cart_items = ' [{         "item_id": ' . $item_id . ',         "quantity": 1,         "original_price": "' . $origin_price . '",         "item_name": "' . $item_name . '",         "item_description": "",         "is_taxable": "N",         "coa": "' . $segment . '",         "sys_code_id": 110     }] ';
//        //print_r($shopping_cart_items);die;
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->add_to_cart($adminId, 'admin', $profile_id, $srtTime, $shopping_cart_items, $lat, $long, $organization_id);
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_EWALLET_TOPUP_FAIL);
//            $this->response_message->set_message(self::CODE_EWALLET_TOPUP_FAIL, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_SHOPPING_CART_TOP_UP, array(RESULTS => $jsonResponse));
//            return TRUE;
//        }
//    }
//
//    ////shopping cart detail
//    public function shoppingcart_detail($shopping_cart_id) {
//
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->get_shopping_cart_details($shopping_cart_id);
//
//
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_SHOPPING_CART_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_SHOPPING_CART_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $result = $jsonResponse[RESULTS];
//            $pid = $result['profile_id'];
//            $org_id = $result['org_id'];
//
//            $created_by = $result['created_by'];
//            $created_by_name = $this->get_username($created_by);
//
//            $o_data = $this->org_detail($org_id);
//            // print_r($o_data->organisation_id);die;
//            $result['organisation_id'] = $o_data->organisation_id;
//            $result['organisation_name'] = $o_data->organisation_name;
//            $result['contact_person'] = $o_data->contact_person;
//            $result['contact'] = $o_data->contact;
//            $result['uen'] = $o_data->uen;
//            $result['contact_mobile'] = $o_data->contact_mobile;
//            $result['created_by_name'] = $created_by_name;
//
//            $this->_response_with_code(self::CODE_SHOPPING_CART_DETAIL, array(RESULTS => $result));
//            return TRUE;
//        }
//    }
//
//    public $venueId = '';
//
//    public function shoppingcart_checkout($ipAddress, $shopping_cart_id, array $payment_list, $organization_id = NULL, $adminId, $profile_id) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->admin_checkout($ipAddress, $profile_id, $adminId, $organization_id, $payment_list, $shopping_cart_id, $this->venueId);
//        // print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_CHECKOUT_SP_FAIL);
//            $this->response_message->set_message(self::CODE_CHECKOUT_SP_FAIL, $message);
//            return FALSE;
//        } else {
//            $result = $jsonResponse[RESULTS];
//
//            $this->_response_with_code(self::CODE_CHECKOUT_SP_SUCCESSFUL, array(RESULTS => $result));
//            return TRUE;
//        }
//    }
//
//    public function org_detail($org_id) {
//        $this->db->select(' a.id as organisation_id,
//                            a.name as organisation_name,
//                            a.uen,
//                            o.contact_person,
//                            o.contact_mobile,
//                            o.email as contact');
//
//        $this->db->from('ssc_member.adv_priority_hirer a');
//        $this->db->join('ssc_member.organization_contacts o', 'o.adv_id = a.id');
//        $this->db->where('a.id', $org_id);
//        $this->db->where('a.deleted_at', NULL);
//        $this->db->where('o.deleted_at', NULL);
//        $this->db->limit(1);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $row = $query->row();
//            return $row;
//        } else {
//            return false;
//        }
//    }
//
//    public function reject_suspend($data, $adminId) {
//        ///this user suspend ready or not
//        $this->db->select('id');
//        $this->db->from('ssc_member.suspend_users');
//        $this->db->where('profile_id', $data['profile_id']);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $id = $this->common_edit('ssc_member.suspend_users', 'profile_id', $data['profile_id'], $data);
//
//            if ($id) {
//                $message = $this->common_config_model->get_message('1134');
//                $this->response_message->set_message('1134', $message);
//                return TRUE;
//            } else {
//                $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//                $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//                return FALSE;
//            }
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    ////org ewallet listing
//    public function ewallet_listing($organization_id) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->get_ewallet_listing($organization_id, 'corporate_user');
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_EWALLET_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_EWALLET_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_EWALLET_LISTING, array(RESULTS => $jsonResponse[RESULTS]));
//            return TRUE;
//        }
//    }
//
//    ////user ewallet listing
//    public function individual_ewallet_listing($profile_id) {
//        $this->load->model('common/common_service_model');
//        $jsonResponse = $this->common_service_model->get_ewallet_listing($profile_id);
//        //print_r($jsonResponse);die;
//        if ($jsonResponse === FALSE) {
//
//            $message = $this->common_config_model->get_message(self::CODE_EWALLET_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_EWALLET_NOT_FOUND, $message);
//            return FALSE;
//        } else {
//            $this->_response_with_code(self::CODE_EWALLET_LISTING, array(RESULTS => $jsonResponse[RESULTS]));
//            return TRUE;
//        }
//    }
//
//    public function suspend_history($profile_id) {
//        $data_return = array();
//        $this->db->select('suspended_reason,suspend_status,created_at,admin');
//        $this->db->from('suspend_user_history');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//        $this->db->where('suspended_reason is not NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//
//            foreach ($query->result_array() as $row_cer) {
//                $suspend_status = $row_cer['suspend_status'];
//                if ($suspend_status == 1) {
//                    $row_cer['suspend_status'] = 'Pending';
//                } else if ($suspend_status == 2) {
//                    $row_cer['suspend_status'] = 'Suspend';
//                } else {
//                    $row_cer['suspend_status'] = 'Reinstate';
//                }
//
//                //////admin name
//                if (@$row_cer['admin']) {
//                    $admin_id = $row_cer['admin'];
//                }
//                $this->db->select('name');
//                $this->db->from('user_profile');
//                $this->db->where('id', $admin_id);
//                $this->db->where('deleted_at is NULL');
//                $query1 = $this->db->get();
//                if ($query1->num_rows() > 0) {
//                    $row_cer['admin_name'] = $query1->row()->name;
//                }
//
//                /////////
//                $data_return1 = array();
//                $data_return1['suspended_reason'] = $row_cer['suspended_reason'];
//                $data_return1['suspend_status'] = $row_cer['suspend_status'];
//                $data_return1['created_at'] = $row_cer['created_at'];
//                $data_return1['admin_name'] = $row_cer['admin_name'];
//                $data_return[] = $data_return1;
//            }
//            $message = $this->common_config_model->get_message('1137');
//            $this->response_message->set_message('1137', $message, array(RESULTS => $data_return));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message('1138');
//            $this->response_message->set_message('1138', $message);
//            return FALSE;
//        }
//    }
//
//    /**
//     * Get Activity listing
//     * @author Wai Tun
//     * @since 1 Apr 2014
//     */
//    public function category_activity_listing() {
//        $this->db->select('category_id,category_name');
//        $this->db->from('ssc_fac.fac_activity_category');
//        $this->db->where('deleted_at is NULL');
//        $this->db->where('is_active', YES_FLAG);
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_DATA_LISTING);
//            $this->response_message->set_message(self::CODE_DATA_LISTING, $message, array(RESULTS => $query->result_array()));
//            return TRUE;
//        } else {
//            $message = $this->common_config_model->get_message('1123');
//            $this->response_message->set_message('1123', $message);
//            return FALSE;
//        }
//    }
//
//

    public function check_token($access_token) {
        $this->db->select('id');
        $this->db->from('wa.access_token');
        $this->db->where('access_token', $access_token);
        $this->db->where('deleted_at is NULL');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_accesstoken($account_id) {
        $this->db->select('access_token');
        $this->db->from('wa.access_token');

        $this->db->where('account_id', $account_id);
        $this->db->where('deleted_at is NULL');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->access_token;
        } else {
            return FALSE;
        }
    }

//
//    public function add_history($id, $o_table, $h_table, $ipAddress, $action) {
//        //LOG
//        $this->save_log('id', $id, $o_table, $h_table, $ipAddress, $action);
//    }
//
//    ////add_on_listing
//    public function account_add_on_listing($profile_id) {
//
//        $data_return1 = array();
//        $dob = $this->_get_dob($profile_id);
//        $role = $this->_get_role($profile_id);
//        $success = 0;
//        $role_found = 0;
//
//
//        $this->db->select(' b.id,b.name,b.price,b.swim_pass,b.swim_expired_period,b.swim_passtype_id,b.gym_pass,b.gym_passtype_id,b.gym_expired_period,c.add_on_id,c.condition_group_code,c.condition_code,a.role_id,b.add_on_type');
//        $this->db->from('ssc_member.member_benefits AS b');
//        $this->db->join('ssc_member.member_add_on As a', 'a.benefit_id = b.id');
//        $this->db->join('ssc_member.member_add_on_conditions As c', 'c.add_on_id = a.id');
//
//        //$this->db->where('b.add_on_type', $add_on_type);
//        $this->db->where('c.deleted_at', NULL);
//        $this->db->where('b.deleted_at', NULL);
//        $this->db->where('a.deleted_at', NULL);
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                ///////check role first
//                $add_on_type = $row_cer['add_on_type'];
//                $role_id = $row_cer['role_id'];
//                $arr_role = explode(',', $role_id);
//                $count_r = count($arr_role);
//                for ($i = 0; $i < $count_r; $i++) {
//                    if ($arr_role[$i] == $role) {
//                        $role_found = 1;
//                    }
//                }
//
//
//                if ($role_found == 0) {
//                    $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_APPLICABLE);
//                    $this->response_message->set_message(self::CODE_ADD_ON_NOT_APPLICABLE, $message);
//                    return FALSE;
//                }
//                /////////
//
//                $benefit_id = $row_cer['id'];
//                $name = $row_cer['name'];
//                $condition_group_code = $row_cer['condition_group_code'];
//                if (!$condition_group_code) {
//                    if ($add_on_type == 1) {
//                        $data_return = array();
//                        $data_return['benefit_id'] = $row_cer['id'];
//                        $data_return['name'] = $row_cer['name'];
//                        $data_return['price'] = $row_cer['price'];
//                        //////
//                        $gym_expired_period = $row_cer['gym_expired_period'];
//                        $month = "+" . $gym_expired_period . " month";
//
//                        $today = date("Y-m-d H:i:s");
//                        $date = strtotime($month, strtotime($today));
//                        $date = date('Y-m-d H:i:s', $date);
//
//                        ////////
//                        $data_return['expired_date'] = $date;
//                        $data_return['add_on_type'] = $add_on_type;
//                        $data_return1[] = $data_return;
//                    } else {
//                        $data_return = array();
//                        $data_return['benefit_id'] = $row_cer['id'];
//                        $data_return['name'] = $row_cer['name'];
//                        $data_return['price'] = $row_cer['price'];
//
//                        //////
//                        $swim_expired_period = $row_cer['swim_expired_period'];
//                        $month = "+" . $swim_expired_period . " month";
//
//                        $today = date("Y-m-d H:i:s");
//                        $date = strtotime($month, strtotime($today));
//                        $date = date('Y-m-d H:i:s', $date);
//
//                        $data_return['expired_date'] = $date;
//                        $data_return['add_on_type'] = $add_on_type;
//                        $data_return1[] = $data_return;
//                    }
//                } else if ($condition_group_code == self::ADD_ON_AGE) {
//                    if (!$dob) {
//                        $message = $this->common_config_model->get_message(self::CODE_DOB_NULL);
//                        $this->response_message->set_message(self::CODE_DOB_NULL, $message);
//                        return FALSE;
//                    }
//
//                    $age = $this->calculate_age($dob);
//
//                    $condition_code = $row_cer['condition_code'];
//                    $price = $row_cer['price'];
//                    $ipAddress = $this->input->ip_address();
//
//                    $result = $this->_is_valid_condition($condition_code, $age);
//
//                    if ($result) {
//                        if ($add_on_type == 1) {
//                            $data_return = array();
//                            $data_return['benefit_id'] = $row_cer['id'];
//                            $data_return['name'] = $row_cer['name'];
//                            $data_return['price'] = $row_cer['price'];
//                            //////
//                            $gym_expired_period = $row_cer['gym_expired_period'];
//                            $month = "+" . $gym_expired_period . " month";
//
//                            $today = date("Y-m-d H:i:s");
//                            $date = strtotime($month, strtotime($today));
//                            $date = date('Y-m-d H:i:s', $date);
//
//                            ////////
//                            $data_return['expired_date'] = $date;
//                            $data_return['add_on_type'] = $add_on_type;
//                            $data_return1[] = $data_return;
//                        } else {
//                            $data_return = array();
//                            $data_return['benefit_id'] = $row_cer['id'];
//                            $data_return['name'] = $row_cer['name'];
//                            $data_return['price'] = $row_cer['price'];
//                            //////
//                            $swim_expired_period = $row_cer['swim_expired_period'];
//                            $month = "+" . $swim_expired_period . " month";
//
//                            $today = date("Y-m-d H:i:s");
//                            $date = strtotime($month, strtotime($today));
//                            $date = date('Y-m-d H:i:s', $date);
//
//                            $data_return['expired_date'] = $date;
//                            $data_return['add_on_type'] = $add_on_type;
//                            $data_return1[] = $data_return;
//                        }
//                    }
//                }
//            }//for each
//            ////
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_LISTING);
//            $this->response_message->set_message(self::CODE_ADD_ON_LISTING, $message, array(RESULTS => $data_return1));
//            return TRUE;
//        }//no data
//        else {
//            //add on not found
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ADD_ON_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    ////add_on_listing
//    public function account_add_on_listing_pos($profile_id) {
//
//        $data_return1 = array();
//        $dob = $this->_get_dob($profile_id);
//        $role = $this->_get_role($profile_id);
//        $success = 0;
//        $role_found = 0;
//
//
//        $this->db->select(' b.id,b.name,b.price,b.swim_pass,b.swim_expired_period,b.swim_passtype_id,b.gym_pass,b.gym_passtype_id,b.gym_expired_period,c.add_on_id,c.condition_group_code,c.condition_code,a.role_id,b.add_on_type');
//        $this->db->from('ssc_member.member_benefits AS b');
//        $this->db->join('ssc_member.member_add_on As a', 'a.benefit_id = b.id');
//        $this->db->join('ssc_member.member_add_on_conditions As c', 'c.add_on_id = a.id');
//
//        //$this->db->where('b.add_on_type', $add_on_type);
//        $this->db->where('c.deleted_at', NULL);
//        $this->db->where('b.deleted_at', NULL);
//        $this->db->where('a.deleted_at', NULL);
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                ///////check role first
//                $add_on_type = $row_cer['add_on_type'];
//                $role_id = $row_cer['role_id'];
//                $arr_role = explode(',', $role_id);
//                $count_r = count($arr_role);
//                for ($i = 0; $i < $count_r; $i++) {
//                    if ($arr_role[$i] == $role) {
//                        $role_found = 1;
//                    }
//                }
//
//
//                if ($role_found == 0) {
//                    $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_APPLICABLE);
//                    $this->response_message->set_message(self::CODE_ADD_ON_NOT_APPLICABLE, $message);
//                    return FALSE;
//                }
//                /////////
//
//                $benefit_id = $row_cer['id'];
//                $name = $row_cer['name'];
//                $condition_group_code = $row_cer['condition_group_code'];
//                if (!$condition_group_code) {
//                    if ($add_on_type == 1) {
//                        $data_return = array();
//                        $data_return['product_id'] = $row_cer['id'];
//                        $data_return['product_name'] = $row_cer['name'];
//                        $data_return['product_price'] = $row_cer['price'];
//                        //////
//                        $gym_expired_period = $row_cer['gym_expired_period'];
//                        $month = "+" . $gym_expired_period . " month";
//
//                        $today = date("Y-m-d H:i:s");
//                        $date = strtotime($month, strtotime($today));
//                        $date = date('Y-m-d H:i:s', $date);
//
//                        ////////
//                        $data_return['expired_date'] = $date;
//                        $data_return['add_on_type'] = $add_on_type;
//                        $data_return['product_code'] = 109;
//
//                        $data_return1[] = $data_return;
//                    } else {
//                        $data_return = array();
//                        $data_return['product_id'] = $row_cer['id'];
//                        $data_return['product_name'] = $row_cer['name'];
//                        $data_return['product_price'] = $row_cer['price'];
//
//                        //////
//                        $swim_expired_period = $row_cer['swim_expired_period'];
//                        $month = "+" . $swim_expired_period . " month";
//
//                        $today = date("Y-m-d H:i:s");
//                        $date = strtotime($month, strtotime($today));
//                        $date = date('Y-m-d H:i:s', $date);
//
//                        $data_return['expired_date'] = $date;
//                        $data_return['add_on_type'] = $add_on_type;
//                        $data_return['product_code'] = 109;
//
//                        $data_return1[] = $data_return;
//                    }
//                } else if ($condition_group_code == self::ADD_ON_AGE) {
//                    if (!$dob) {
//                        $message = $this->common_config_model->get_message(self::CODE_DOB_NULL);
//                        $this->response_message->set_message(self::CODE_DOB_NULL, $message);
//                        return FALSE;
//                    }
//
//                    $age = $this->calculate_age($dob);
//
//                    $condition_code = $row_cer['condition_code'];
//                    $price = $row_cer['price'];
//                    $ipAddress = $this->input->ip_address();
//
//                    $result = $this->_is_valid_condition($condition_code, $age);
//
//                    if ($result) {
//                        if ($add_on_type == 1) {
//                            $data_return = array();
//                            $data_return['product_id'] = $row_cer['id'];
//                            $data_return['product_name'] = $row_cer['name'];
//                            $data_return['product_price'] = $row_cer['price'];
//                            //////
//                            $gym_expired_period = $row_cer['gym_expired_period'];
//                            $month = "+" . $gym_expired_period . " month";
//
//                            $today = date("Y-m-d H:i:s");
//                            $date = strtotime($month, strtotime($today));
//                            $date = date('Y-m-d H:i:s', $date);
//
//                            ////////
//                            $data_return['expired_date'] = $date;
//                            $data_return['add_on_type'] = $add_on_type;
//                            $data_return['product_code'] = 109;
//
//                            $data_return1[] = $data_return;
//                        } else {
//                            $data_return = array();
//                            $data_return['product_id'] = $row_cer['id'];
//                            $data_return['product_name'] = $row_cer['name'];
//                            $data_return['product_price'] = $row_cer['price'];
//                            //////
//                            $swim_expired_period = $row_cer['swim_expired_period'];
//                            $month = "+" . $swim_expired_period . " month";
//
//                            $today = date("Y-m-d H:i:s");
//                            $date = strtotime($month, strtotime($today));
//                            $date = date('Y-m-d H:i:s', $date);
//
//                            $data_return['expired_date'] = $date;
//                            $data_return['add_on_type'] = $add_on_type;
//                            $data_return['product_code'] = 109;
//
//                            $data_return1[] = $data_return;
//                        }
//                    }
//                }
//            }//for each
//            ////
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_LISTING);
//            $this->response_message->set_message(self::CODE_ADD_ON_LISTING, $message, array(RESULTS => $data_return1));
//            return TRUE;
//        }//no data
//        else {
//            //add on not found
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ADD_ON_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    ////shopping cart topup pos
//    public function add_on_shopping_cart($profile_id, $benefit_id, $lat = NULL, $long = NULL, $adminId) {
//
//        $dob = $this->_get_dob($profile_id);
//        $role = $this->_get_role($profile_id);
//        $success = 0;
//        $role_found = 0;
//
//        ////////CHECK ADDON RELATION
//        /* $today=date('Y-m-d H:i:s');
//          $this->db->select('id');
//          $this->db->from('ssc_member.member_addon_relation');
//          $this->db->where('benefit_id', $benefit_id);
//          $this->db->where('deleted_at', NULL);
//          $query2 = $this->db->get(); */
//
//        $today = date('Y-m-d H:i:s');
//        $st = "expired_at > '{$today}'";
//        $this->db->select('id');
//        $this->db->from('ssc_member.member_addon_relation');
//        $this->db->where('benefit_id', $benefit_id);
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at', NULL);
//        $this->db->where($st);
//
//        $query1 = $this->db->get();
//        if ($query1->num_rows() > 0) {
//            $message = $this->common_config_model->get_message(self::CODE_ADDON_ALREADY_BUY);
//            $this->response_message->set_message(self::CODE_ADDON_ALREADY_BUY, $message);
//            return FALSE;
//        }
//
//        $this->db->select(' b.id,b.add_on_type,b.name,b.price,b.swim_pass,b.swim_expired_period,b.swim_passtype_id,b.gym_pass,b.gym_passtype_id,b.gym_expired_period');
//        $this->db->from('ssc_member.member_benefits AS b');
//        $this->db->where('b.id', $benefit_id);
//        $this->db->where('b.deleted_at', NULL);
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//
//                $benefit_id = $row_cer['id'];
//                $name = $row_cer['name'];
//                //$condition_group_code=$row_cer['condition_group_code'];
//
//                $price = $row_cer['price'];
//                $ipAddress = $this->input->ip_address();
//
//                if ($row_cer['add_on_type'] == 1) {
//                    ////////////////////
//                    $gym_expired_period = $row_cer['gym_expired_period'];
//                    $month = "+" . $gym_expired_period . " month";
//
//                    $today = date("Y-m-d H:i:s");
//                    $date = strtotime($month, strtotime($today));
//                    $date = date('Y-m-d H:i:s', $date);
//                } else {
//                    ////////////////////
//                    $swim_expired_period = $row_cer['swim_expired_period'];
//                    $month = "+" . $swim_expired_period . " month";
//
//                    $today = date("Y-m-d H:i:s");
//                    $date = strtotime($month, strtotime($today));
//                    $date = date('Y-m-d H:i:s', $date);
//                }
//
//                ////////////////////////
//                $addon_type = $row_cer['add_on_type'];
//                ///add to shopping cart
//                $option = ',          "option": {"profile_id":"' . $profile_id . '",    "expired_date":"' . $date . '",    "add_on_type":"' . $addon_type . '"}';
//                //$st='{"item_id":'.$benefit_id.', "quantity":1, "original_price":'.$price.', "item_name":'.$name.',"item_description":add_on, "sys_code_id":109 }';
//                $shopping_cart_items = ' [{         "item_id": ' . $benefit_id . ',         "quantity": 1,         "original_price": "' . $price . '",         "item_name": "' . $name . '",         "item_description": "' . $profile_id . '"' . $option . ',         "sys_code_id": 109     }] ';
//
//                $srtTime = $this->_get_expiry_date_pos();
//
//                $this->load->model('common/common_service_model');
//                $response = $this->common_service_model->add_to_cart($adminId, 'pos', $profile_id, $srtTime, $shopping_cart_items, $lat, $long);
//                if (!$response) {
//                    //Problem with e wallet
//                    if ($this->response_message->get_status_code() == SSC_HEADER_INTERNAL_SERVER_ERROR) {
//                        $this->_response_with_code(self::CODE_SHOPPING_CART_NOT_FOUND);
//                    }
//                    return FALSE;
//                }
//
//                $statusCode = $response[STATUS_CODE];
//                $results = $response[RESULTS];
//
//
//                $this->_response_with_code(self::CODE_SHOPPING_CART_ADD_ON, array(RESULTS => $results));
//                return TRUE;
//                /* if($jsonResponse === FALSE) {
//
//                  $message = $this->common_config_model->get_message(self::CODE_SHOPPING_CART_NOT_FOUND);
//                  $this->response_message->set_message(self::CODE_SHOPPING_CART_NOT_FOUND, $message);
//                  return FALSE;
//                  }
//                  else
//                  {
//                  $this->_response_with_code(self::CODE_SHOPPING_CART_ADD_ON, array(RESULTS => $jsonResponse));
//                  return TRUE;
//
//                  } */
//            }//for each
//        }//no data
//        else {
//            //add on not found
//            $message = $this->common_config_model->get_message(self::CODE_ADD_ON_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_ADD_ON_NOT_FOUND, $message);
//            return FALSE;
//        }
//    }
//
//    public function terminate_user_detail($profile_id) {
//        $data_return = array();
//        $data_return2 = array();
//
//        //////profile data
//        $this->db->select('u.id,u.name,u.identity_number,r.id as role_id,r.role_name,u.profile_picture');
//        $this->db->from('user_profile u');
//        $this->db->join('public_user_map_role p', 'u.id = p.profile_id');
//        $this->db->join('public_user_role r', 'p.role_id = r.id');
//
//        $this->db->where('u.id', $profile_id);
//        $this->db->where('u.deleted_at is NULL');
//        $this->db->where('p.deleted_at is NULL');
//        $this->db->where('r.deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                //return $query->row();
//                $data_return2 = $row_cer;
//                $image = $this->get_folders(self::S3_FOLDER);
//                $data_return2['folder'] = $image;
//            }
//        }
//
//
//
//        $this->db->select('blacklist_reason,created_at,created_by');
//        $this->db->from('ssc_member.black_lists');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//        $this->db->limit(1);
//        $query1 = $this->db->get();
//
//        if ($query1->num_rows() > 0) {
//            //////admin name
//            foreach ($query1->result_array() as $row_cer1) {
//                if (@$row_cer1['created_by']) {
//                    $admin_id = $row_cer1['created_by'];
//
//                    $this->db->select('name');
//                    $this->db->from('user_profile');
//                    $this->db->where('id', $admin_id);
//                    $this->db->where('deleted_at is NULL');
//                    $query2 = $this->db->get();
//                    if ($query2->num_rows() > 0) {
//                        $row_cer1['admin_name'] = $query2->row()->name;
//                    }
//                }
//                $data_return2['terminate_history'] = $row_cer1;
//            }
//        } else {
//            $message = $this->common_config_model->get_message(self::CODE_MEMBER_NOT_FOUND);
//            $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND, $message);
//            return FALSE;
//        }
//
//        $this->db->select('suspended_reason,suspend_status,created_at,admin');
//        $this->db->from('suspend_user_history');
//        $this->db->where('profile_id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//        $this->db->where('suspended_reason is not NULL');
//        $query = $this->db->get();
//
//        if ($query->num_rows() > 0) {
//            foreach ($query->result_array() as $row_cer) {
//                $suspend_status = $row_cer['suspend_status'];
//                if ($suspend_status == 1) {
//                    $row_cer['suspend_status'] = 'Pending';
//                } else if ($suspend_status == 2) {
//                    $row_cer['suspend_status'] = 'Suspend';
//                } else {
//                    $row_cer['suspend_status'] = 'Reinstate';
//                }
//
//                //////admin name
//                if (@$row_cer['admin']) {
//                    $admin_id = $row_cer['admin'];
//
//                    $this->db->select('name');
//                    $this->db->from('user_profile');
//                    $this->db->where('id', $admin_id);
//                    $this->db->where('deleted_at is NULL');
//                    $query1 = $this->db->get();
//                    if ($query1->num_rows() > 0) {
//                        $row_cer['admin_name'] = $query1->row()->name;
//                    }
//                }
//
//                /////////
//                $data_return1 = array();
//                $data_return1['suspended_reason'] = $row_cer['suspended_reason'];
//                $data_return1['suspend_status'] = $row_cer['suspend_status'];
//                $data_return1['created_at'] = $row_cer['created_at'];
//                $data_return1['admin_name'] = $row_cer['admin_name'];
//                $data_return[] = $data_return1;
//            }
//
//            $data_return2['suspend_history'] = $data_return1;
//        } else {
//            $data_return2['suspend_history'] = NULL;
//        }
//
//        $message = $this->common_config_model->get_message('1145');
//        $this->response_message->set_message('1145', $message, array(RESULTS => $data_return2));
//        return TRUE;
//    }
//
//    public function get_username($profile_id) {
//        $this->db->select('name');
//        $this->db->from('ssc_member.user_profile');
//        $this->db->where('id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->name;
//        } else {
//            return false;
//        }
//    }
//
    
    /**
     * Get updated date for access token
     * @author Wai Tun
     * @since 9 FEB 2014
     */
    public function get_accesstoken_updated_at($accessToken) {
        $this->db->select('updated_at,created_at');
        $this->db->from('wa.access_token');
        if($accessToken == null){
            $this->db->where('1=2');
        }
        else
        {
            $this->db->where('access_token', $accessToken);
        }
        $this->db->where('deleted_at is NULL');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
//
//    public function get_name($profile_id) {
//        $this->db->select('name');
//        $this->db->from('ssc_member.user_profile');
//
//        $this->db->where('id', $profile_id);
//        $this->db->where('deleted_at is NULL');
//
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row()->name;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function withdraw($data) {
//        $this->load->model('common/common_service_model');
//        $response = $this->common_service_model->withdraw($data);
//        //$response = $this->common_service_model->checkout($shoppingCartId, $profileId, $paymentDetails);
//        if (!$response) {
//            //Problem with e wallet
//            if ($this->response_message->get_status_code() == SSC_HEADER_INTERNAL_SERVER_ERROR) {
//                $this->_response_with_code(self::CODE_WITHDRAW_FAIL);
//            }
//            return FALSE;
//        } else {
//            $statusCode = @$response[STATUS_CODE];
//            //$results = @$response[RESULTS];
//
//
//            $this->_response_with_code($statusCode);
//            return TRUE;
//        }
//    }
//
//    public function check_unique_staff_nric($identity_number) {
//        $this->db->select('id');
//        $this->db->from('subscriber_user');
//        $this->db->where('staff_nric', $identity_number);
//        $this->db->where('deleted_at is NULL');
//        $query = $this->db->get();
//        if ($query->num_rows() > 0) {
//            return $query->row();
//        } else {
//            return FALSE;
//        }
//    }
//
//    /*
//     *  Change password by admin - Prasanna
//     */
//
//    public function changepwd($profile_id, $old_password, $new_password) {
//
//        $mysqlQuery = " SELECT  `la`.`id` AS `login_account_id`,
//                                `la`.`user_name`,
//                                `la`.`password`,
//                                `la`.`profile_id`,
//                                `up`.`salt`,
//                                `su`.`password_expired_date`
//                                 FROM `ssc_member`.`login_account` AS `la`
//                        JOIN `ssc_member`.`subscriber_user` AS `su` ON `su`.`profile_id` = `la`.`profile_id`
//                        JOIN `ssc_member`.`user_profile` AS `up` ON `up`.`id` = `su`.`profile_id`
//                        WHERE `la`.`profile_id` = " . $profile_id . "
//                        AND `la`.`active` = '" . self::TRUE_ACTIVE . "'
//                        AND `la`.`deleted_at` IS NULL
//                        AND `up`.`deleted_at` IS NULL
//                        AND `su`.`deleted_at` IS NULL Limit 1";
//        $query = $this->db->query($mysqlQuery);
//
//        if ($query->num_rows() > 0) {
//            $result = $query->row();
//
//            $saltedPassword = $this->generate_password($old_password, $result->salt);
//            if ($result->password == $saltedPassword) {
//                // lets see if it match the policy
//                $this->load->library('PasswordPolicy');
//                $this->load->model('account/account_password_model');
//
//                $isValid = $this->account_password_model->validate_password($profile_id, $new_password);
//
//                if (!$isValid) {
//                    $this->response_message->set_message(1500, $this->passwordpolicy->get_error_message());
//                    return FALSE;
//                }
//
//                $salt = $this->generate_salt();
//                $data['password'] = $this->generate_password($new_password, $salt);
//
//                $this->load->model('account/login_model');
//                $this->login_model->setAdminId($this->_getAdminId());
//                $this->login_model->setIsAdminAccount();
//                $this->login_model->editLogin($result->login_account_id, null, $data['password']);
//
//                // save the password to the history
//                $this->account_password_model->insert_password_history($profile_id, $data['password'], $salt, $this->_getAdminId());
//
//                $param['salt'] = $salt;
//                $this->db->where('id', $profile_id);
//
//                // log_message('error', 'account_model:changepwd:6279 updating profile_id' . $profile_id. ' with: '. print_r($param, TRUE));
//                $res = $this->db->update('user_profile', $param);
//
//                if ($this->db->affected_rows()) {
//                    $this->save_log('id', $profile_id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $this->input->ip_address(), 'U');
//                }
//
//                $this->_response_with_code(self::PASSWORD_SUCCESSFULL, array(RESULTS => true));
//                return TRUE;
//            } else {
//                $this->_response_with_code(self::INCORRECT_PASSWORD, array(RESULTS => false));
//                return FALSE;
//            }
//        }
//    }
//
//    /*  public function add_token_cache($result,$access_token)
//      {
//      $cacheKey = 'ACCESSTOKEN-' . $access_token ;
//      $this->set_elasticache($cacheKey, $result ,ELASTICACHE_EXPIRY_ONE_MINUTE * 20 );
//      //$result=$this->get_elasticache($cacheKey);
//      //print_r($result);die;
//
//      }
//      public function get_token_cache($access_token)
//      {
//      $cacheKey = 'ACCESSTOKEN-' . $access_token ;
//      $result=$this->get_elasticache($cacheKey);
//      if ($result)
//      {
//      $this->set_elasticache($cacheKey, $result ,ELASTICACHE_EXPIRY_ONE_MINUTE * 20 );
//      }
//
//      return $result;
//      } */
//
//    public function check_relationship($profile_id, $adminId) {
//        $ipAddress = $this->input->ip_address();
//
//        $role_id = $this->_get_role($profile_id);
//        if ($role_id == 2) {
//            $this->db->select('id');
//            $this->db->from('relationship');
//            $this->db->where('supplementary_user_profile_id', $profile_id);
//            $this->db->where('deleted_at is NULL');
//            $query = $this->db->get();
//            if ($query->num_rows() > 0) {
//                $id = $query->row()->id;
//                $this->common_delete('relationship', 'id', $id);
//                //add history
//                $this->add_history($id, 'ssc_member.relationship', 'ssc_log.hist_relationship', $ipAddress, self::ACTION_UPDATE);
//            }
//        } else if ($role_id == 3) {
//            $this->db->select('id');
//            $this->db->from('relationship');
//            $this->db->where('supplementary_user_profile_id', $profile_id);
//            $this->db->where('deleted_at is NULL');
//            $query = $this->db->get();
//            if ($query->num_rows() < 1) {
//                $data = array();
//                $data['supplementary_user_profile_id'] = $profile_id;
//                $data['created_at'] = date('Y-m-d H:i:s');
//                $data['created_by'] = $adminId;
//                $id = $this->common_add('ssc_member.relationship', $data);
//                //add history
//                $this->add_history($id, 'ssc_member.relationship', 'ssc_log.hist_relationship', $ipAddress, self::ACTION_CREATE);
//            }
//        }
//
//        return true;
//    }
//
//    /**
//     * TODO: This part needs abstraction, as a base account model
//     */
//    var $adminId = '';
//
//    public function _getAdminId() {
//        return $this->adminId;
//    }
//
//    public function setAdminId($adminId) {
//        return $this->adminId = $adminId;
//    }
//
//    /**
//     * Add supplementary data
//     *
//     * @package Membership
//     * @subpackage Supplementary
//     */
//    public function addSupplementaryRelationship($profile_id, $supplementary_profile_id, $parent_name, $parent_identity_number, $parent_contact_mobile, $parent_email, $email, $contact_mobile) {
//        if (empty($parent_identity_number)) {
//            $parent_identity_number = NULL;
//        }
//
//        if (empty($parent_contact_mobile)) {
//            $parent_contact_mobile = NULL;
//        }
//
//        if (empty($parent_email)) {
//            $parent_email = NULL;
//        }
//
//        if (empty($email)) {
//            $email = NULL;
//        }
//
//        if (empty($contact_mobile)) {
//            $contact_mobile = NULL;
//        }
//
//        $data['profile_id'] = $profile_id;
//        $data['supplementary_user_profile_id'] = $supplementary_profile_id;
//
//        $data['email'] = $email;
//        $data['contact_mobile'] = $contact_mobile;
//        $data['parent_identity_number'] = $data['parent_identity_number'];
//        $data['parent_contact_mobile'] = $data['parent_contact_mobile'];
//        $data['parent_email'] = $data['parent_email'];
//
//        $data['created_at'] = date('Y-m-d H:i:s');
//
//        if (empty($profile_id)) {
//            $data['created_by'] = $supplementary_profile_id;
//        }
//
//        $r = $this->account_model->common_add('relationship', $data);
//
//        $this->save_log('id', $r, 'ssc_member.relationship', 'ssc_log.hist_relationship', $this->input->ip_address(), self::ACTION_CREATE);
//    }
//
//    /**
//     * [addOrdinaryHirer description]
//     * @param [type] $profile_id [description]
//     */
//    public function addOrdinaryHirer($profile_id) {
//        $data = array();
//        $data['profile_id'] = $profile_id;
//        $data['created_at'] = date('Y-m-d H:i:s');
//        $data['created_by'] = $this->_getAdminId();
//        $data['active'] = 'Y';
//        $data['verified'] = 'Y';
//        $ipAddress = $this->input->ip_address();
//
//        try {
//            $oh = $this->account_model->common_add('ordinary_hirer', $data);
//            $this->save_log('id', $oh, 'ssc_member.ordinary_hirer', 'ssc_log.hist_ordinary_hirer', $ipAddress, self::ACTION_CREATE);
//        } catch (Exception $e) {
//            log_message('error', $e->getMessage());
//        }
//    }
//
//    /**
//     * [addPublicMapRole description]
//     * @param [type] $profile_id [description]
//     * @param [type] $role_id    [description]
//     */
//    public function addPublicMapRole($profile_id, $role_id) {
//        $data1 = array();
//        $data1['profile_id'] = $profile_id;
//        $data1['role_id'] = $role_id;
//        $data1['created_at'] = date('Y-m-d H:i:s');
//        $data1['created_by'] = $this->_getAdminId();
//        $ipAddress = $this->input->ip_address();
//
//        try {
//            $pr = $this->account_model->common_add('public_user_map_role', $data1);
//            $this->save_log('id', $pr, 'ssc_member.public_user_map_role', 'ssc_log.hist_public_user_map_role', $ipAddress, self::ACTION_CREATE);
//        } catch (Exception $e) {
//            log_message('error', $e->getMessage());
//        }
//    }
//
//    public function ace_admin_user($data) {
//        //echo '<pre>'; print_r($data); die;
//        $name = $data['name'];
//        $email = $data['email'];
//
//        if ($data['contact_mobile']) {
//            $contact_mobile = $data['contact_mobile'];
//        } else {
//            $contact_mobile = '';
//        }
//
//        $dob = $this->formatAceDOB($data['dob']);
//        $gender = $this->formatAceGender($data['gender']);
//        $password1 = $data['password'];
//        $venue = $data['venue'];
//        $role = $data['role'];
//        $group_id = $data['group_id'];
//
//        $staff_nric = $data['staff_nric'];
//        $employee_id = $data['employee_id'];
//        $salutation_id = $data['salutation_id'];
//
//        $citizenship_id = $this->formatAceCitizenship($data['citizenship_id']);
//        $race_id = $this->formatAceRace($data['race_id']);
//        $education_level = $this->formatAceEducation($data['education_level']);
//
//        $ro_id = $data['ro_id'];
//        $hod_id = $data['hod_id'];
//
//        $position = $data['position'];
//        $cost_center_id = $data['cost_center_id'];
//        $cost_center_description = $data['cost_center_description'];
//        $id_type = $data['id_type'];
//        $designation = $data['designation'];
//
//
//        $password_p = $this->account_model->generate_salt();
//        ///generate the password
//        $salt = $this->generate_salt();
//        $password = $this->generate_password($password_p, $salt);
//
//        ///////data array for user profile table
//        $data = array();
//        $data['name'] = @$name;
//        $data['email'] = $email ? $email : NULL;
//        $data['gender'] = $gender ? $gender : NULL;
//        $data['dob'] = $dob ? $dob : NULL;
//        $data['salt'] = $salt;
//        $data['citizenship_id'] = $citizenship_id ? $citizenship_id : NULL;
//        $data['race_id'] = $race_id ? $race_id : NULL;
//        $data['education_level'] = $education_level ? $education_level : NULL;
//        $data['id_type'] = $id_type ? $id_type : NULL;
//        $data['verified'] = 'Y';
//
//        ////////check email,mobile no,identity number is unique
//        $check_data = $this->check_unique(NULL, NULL, $email, NULL);
//        //print_r($check_data);die;
//        if ($check_data) {
//            //print_r($check_data);die;
//            if ($check_data->verified == 'N') {//not verified
//                $profile_id = $check_data->id;
//                //Before data save, clear account login table
//                $this->save_log('profile_id', $check_data->id, 'ssc_member.login_account', 'ssc_log.hist_login_account', $this->input->ip_address(), self::ACTION_DELETE);
//                $this->common_delete('login_account', 'profile_id', $check_data->id);
//                //update the database
//                // log_message('error', 'account_model:create_admin_user:4439 updating profile_id' . $check_data->id. ' with: '. print_r($data, TRUE));
//                $this->common_edit('user_profile', 'id', $check_data->id, $data);
//                $this->save_log('id', $check_data->id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $this->input->ip_address(), self::ACTION_UPDATE);
//            } else {//verified
//                if (@$email) {
//                    $check_email = $this->check_unique_email($email);
//                    if ($check_email) {
//                        $message = $this->common_config_model->get_message(self::CODE_EMAIL_EXIST);
//                        $this->response_message->set_message(self::CODE_EMAIL_EXIST, $message);
//                        return FALSE;
//                    }
//                }
//            }
//        } else {//no data
//            //Save to database
//            $data['created_at'] = date('Y-m-d H:i:s');
//            $data['platform'] = 'admin';
//
//            $profile_id = $this->common_add('ssc_member.user_profile', $data);
//            $this->save_log('id', $profile_id, 'ssc_member.user_profile', 'ssc_log.hist_user_profile', $this->input->ip_address(), self::ACTION_CREATE);
//        }
//
//        ///////data array for login account table
//        if ($email) {
//            $this->load->model('account/login_model', 'alm');
//            $this->load->model('account/access_token_model', 'atm');
//
//            $account_id = $this->alm->createLogin($profile_id, $email, $password, 'Y', 'Y');
//
//            /////create access token
//            $access_token = $this->generate_token();
//            $this->atm->createToken($account_id, $access_token);
//        }
//
//        // save the password to the history
//        //$this->load->model('account/account_password_model');
//        //$this->account_password_model->insert_password_history($profile_id, $password, $salt, $this->_getAdminId());
//        //$this->login_model->setAdminId($this->_getAdminId());
//        /////save subscriber user
//        $data_s = array();
//        $data_s['profile_id'] = $profile_id;
//        $data_s['subscriber_id'] = 1;
//        $data_s['group_id'] = $group_id ? $group_id : NULL;
//
//        $data_s['staff_nric'] = $staff_nric ? $staff_nric : NULL;
//        $data_s['employee_id'] = $employee_id ? $employee_id : NULL;
//        $data_s['salutation_id'] = $salutation_id ? $salutation_id : NULL;
//        $data_s['contact_mobile'] = $contact_mobile ? $contact_mobile : NULL;
//        $data_s['designation'] = $designation ? $designation : NULL;
//        $data_s['position'] = $position ? $position : NULL;
//        $data_s['cost_center_id'] = $cost_center_id ? $cost_center_id : NULL;
//        $data_s['cost_center_description'] = $cost_center_description ? $cost_center_description : NULL;
//        $data_s['status'] = 'active';
//        $data_s['active'] = 'Y';
//        $data_s['created_at'] = date('Y-m-d H:i:s');
//        $data_s['created_by'] = '1';
//
//        //print_r($data_s);die;
//        $this->load->model('accesscontrol/users_model');
//
//        $subscriber_id = $this->common_add('subscriber_user', $data_s);
//        $this->save_log('id', $subscriber_id, 'ssc_member.subscriber_user', 'ssc_log.hist_subscriber_user', $this->input->ip_address(), self::ACTION_CREATE);
//        /////save user role
//        $this->addAdminUserMapRole($profile_id, explode(",", $role));
//
//        /////tag hod and ro
//        $this->admin_map_ro_hod($profile_id, $ro_id, $hod_id);
//
//        /////save user venue
//        $venue_array[$venue]['effective_from'] = date('Y-m-d');
//        $m_date = new DateTime("+6 months");
//        $venue_array[$venue]['effective_to'] = $m_date->format('Y-m-d');
//        $venues = json_encode($venue_array);
//        $this->addSubscriberUserMapVenue($subscriber_id, $venues, '1');
//        $mail = true;
//        if ($mail) {
//            $url = self::admin_URL;
//            ///////send email
//            $description = "Dear " . $name . ",<br><br>Your account has been created.<br>Please login to your account using the following details:<br><br>User name: " . $email . "<br>Password: " . $password_p . "<br>URL: " . $url . "<br><br>All the best,<br>iAPPS Helpdesk";
//
//            $params = array();
//            $params['notification_type'] = 'email';
//            $params['recipient_id'] = $email;
//            $params['notification_text'] = $description;
//            $params['send_from'] = 'admin';
//            //$params['account_id']   = $profile_id;
//            $params['notification_subject'] = '[ActiveSG] Sucessfully registered';
//
//            //print_r($params);die;
//            $result11 = $this->notification_send($params);
//        }
//
//        $message = $this->common_config_model->get_message(self::CODE_ACCOUNT_CREATE);
//        $this->response_message->set_message(self::CODE_ACCOUNT_CREATE, $message);
//        return TRUE;
//    }
//
//    /**
//     * Format date of birth data from ace 'dmY' to mms dob format 'Y-m-d'
//     */
//    protected function formatAceDOB($dob) {
//        $date = DateTime::createFromFormat('dmY', $dob);
//
//        if ($date) {
//            return $date->format('Y-m-d');
//        }
//
//        return NULL;
//    }
//
//    /**
//     * Format ace NATIONALITY to conform with mms citizenship_id
//     *
//     * @param  string $citizenship_id [description]
//     * @return string                 [description]
//     */
//    protected function formatAceCitizenship($citizenship_id) {
//        if ($citizenship_id == '2') {
//            // return 'SINGAPOREAN'; // prev ace data balue
//            return 'b1_scitizen';
//        }
//
//        return 'b3_foreigner';
//    }
//
//    /**
//     * Format ace RACE_ID to conform with mms race_id
//     *
//     * @param  [type] $race_id [description]
//     * @return string          a1_chinese, a2_malay, a3_indian, a4_eurasian
//     */
//    protected function formatAceRace($race_id) {
//        if ($race_id == '396') {
//            return 'a1_chinese';
//        }
//
//        return '';
//    }
//
//    /**
//     * Format ace EDUCATIONAL_LEVEL_ID to conform with mms education_level
//     *
//     * @param  string $education_level [description]
//     * @return string                  'DEGREE AND ABOVE' etc
//     */
//    protected function formatAceEducation($education_level) {
//        return $education_level;
//    }
//
//    /**
//     * Format ace GENDER_ID to conform with mms gender
//     *
//     * @param  [type] $gender [description]
//     * @return [type]         [description]
//     */
//    protected function formatAceGender($gender) {
//        if ($gender == '24') {
//            return 'M';
//        } elseif ($gender == '25') {
//            return 'F';
//        }
//
//        return '';
//    }
//
//    public function admin_map_ro_hod($profile_id, $ro = NULL, $hod = NULL) {
//        $data['created_at'] = date('Y-m-d H:i:s');
//        $data['created_by'] = '1';
//        if ($ro != NULL) {
//            $data['profile_id'] = $profile_id;
//            $data['tag_type'] = 'RO';
//            $data['tag_id'] = $ro;
//            $this->db->insert('ssc_member.admin_level_tagging', $data);
//            $last_id = $this->db->insert_id();
//            $this->save_log('id', $last_id, 'ssc_member.admin_level_tagging', 'ssc_log.hist_admin_level_tagging', '127.0.0.1', 'C');
//        }
//        if ($hod !== NULL) {
//            $data['profile_id'] = $profile_id;
//            $data['tag_type'] = 'HOD';
//            $data['tag_id'] = $hod;
//            $this->db->insert('ssc_member.admin_level_tagging', $data);
//            $last_id = $this->db->insert_id();
//            $this->save_log('id', $last_id, 'ssc_member.admin_level_tagging', 'ssc_log.hist_admin_level_tagging', '127.0.0.1', 'C');
//        }
//    }
}

/* End of file account_model.php */
/* Location: ./application/modules/account/models/account_model.php */
