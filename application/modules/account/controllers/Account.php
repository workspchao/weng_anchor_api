<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Base_Controller {

    // const LIMIT = 10;
    // const PAGE  = 1;

    // //////////////Waitun
    // const CODE_INVALID_GENDER     = 1025;
    // const CODE_MEMBER_ADD_SUCCESS = 1027;
    // const CODE_INVALID_PASSWORD = 1015;
    // const CODE_INVALID_EMAIL    = 1002;
    // const CODE_INVALID_MOBILE   = 1001;
    // const CODE_MEMBER_NOT_FOUND   = 1020;
    // const CODE_INVALID_CSV    =1128;

    //  /**
    //  * Channel constants
    //  */
    // const CHANNEL_PUBLIC_USER   = 'public_user';
    // const CHANNEL_EWALLET_CODE  = 'ewallet';
    // const CHANNEL_EWALLET_SSC_CODE = 'ssc_credit';


    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('account/account_model');
        $this->load->model('account/access_token_model');
    }

    ////////////////
    ////For Admin///
    ////////////////

    public function admin_login()
    {
        $this->is_required($this->input->post(), array('username', 'password'));
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if($this->account_model->admin_login($username, $password)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
        }
    }
    
//    public function create_user(){
//        $this->is_required($this->input->post(), array('username'));
//        
//        if($this->account_model->create_user($username)){
//            $this->response($this->response_message->get_message());
//        }
//        else{
//            $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//        }
//    }
    
    
    ////////////////
    ////For Membership///
    ////////////////
    
    public function user_login(){
        $this->is_required($this->input->post(), array('username', 'password'));
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $login_type = $this->input->post('login_type') ? $this->input->post('login_type') : Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE;

        if($this->account_model->user_login($username, $password, $login_type)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
        }
    }
    
    public function user_exists(){
        $this->is_required($this->input->post(), array('username'));
        
        $username = $this->input->post('username');
        $loginType = $this->input->post('login_type') ? $this->input->post('login_type') : Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE;
        
        if($this->account_model->login_account_exists($username,$loginType)){
            $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
        }
        else
        {
            $this->response($this->response_message->get_message(), HEADER_SUCCESS);
        }
    }
    
    public function user_send_otpcode(){
        
        $this->is_required($this->input->post(), array('otp_type'));
        
        $otpType = $this->input->post('otp_type');
        $username = $this->input->post('username');
        $contact_mobile = $this->input->post('contact_mobile');
        $email = $this->input->post('email');
        $uid = $this->input->post('uid');
        
        $this->account_model->send_otpcode($otpType,$username,$contact_mobile,$email,$uid);
        
    }
    
    public function user_register()
    {
//        $ipAddress = $this->input->ip_address();

        $inputs = array('username', 'password', 'platform', 'login_type');
        $this->is_required($this->input->post(), $inputs);
        
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $platform = $this->input->post('platform') ? $this->input->post('platform') : NULL;
        $login_type = $this->input->post('login_type') ? $this->input->post('login_type') : Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE;
        
        $contact_mobile = $this->input->post('contact_mobile') ? $this->input->post('contact_mobile') : NULL;
        $name = $this->input->post('name') ? $this->input->post('name') : NULL;
        $email = $this->input->post('email') ? $this->input->post('email') : NULL;
        
        if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE){
            $contact_mobile = $username;
        }
        else if($login_type == Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_EMAIL){
            $email = $username;
        }
        
        //check login account exists
        if($this->account_model->login_account_exists($username, $login_type)){
            $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
            return;
        }
        
        //check valid mobile number?
        if(!empty($contact_mobile) && !$this->validate_phone($contact_mobile))
        {
            $this->response_message->set_message_with_code(Account_model::CODE_CONTACT_MOBILE_INVALID);
            $this->response($this->response_message->get_message(), HEADER_PARAMETER_MISSING_INVALID);
            return;
        }
        
        //check valid email?
        if(!empty($email) && !$this->validate_email($email))
        {
            $this->response_message->set_message_with_code(Account_model::CODE_EMAIL_INVALID);
            $this->response($this->response_message->get_message(), HEADER_PARAMETER_MISSING_INVALID);
            return;
        }
        
        ///generate the password
        $salt       = $this->account_model->generate_salt();
        $password   = $this->account_model->generate_password($password,$salt);
        
        ///////data array for user profile table
        $data_user                      = array();
        $data_user['name']              = $name;
        $data_user['email']             = $this->mmsencrypt->encrypt($email);
        $data_user['email_hashmap']     = $this->mmsencrypt->hash($email);
        $data_user['contact_mobile']    = $this->mmsencrypt->encrypt($contact_mobile);
        $data_user['contact_mobile_hashmap'] = $this->mmsencrypt->hash($contact_mobile);
        $data_user['salt']              = $salt;
        $data_user['is_admin']          = Common_flag::FLAG_NO_TINYINT;
        $data_user['reg_platform']      = $platform;
        $data_user['mebership_id']      = Common_flag::USER_MEMBERSHIP_ID_NO_MEMBER; // default is 1.no-member;
        
        ////////check email,mobile no is unique
        $check_data = $this->account_model->check_unique($contact_mobile,$email);
        if($check_data)
        {
            // if already exists
            $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
            return;
        }
        
        //else not exists then save to database
        $data_user['created_at'] = $this->get_now();
//            $data_user['created_by'] = ;

        ///////data array for login account table
        $data_login_account = array();
        $data_login_account['user_name'] = $this->mmsencrypt->hash($username.$login_type);
        $data_login_account['password'] = $password;
//        $data_login_account['uid'] = $uid;
        $data_login_account['login_type'] = Common_flag::LOGIN_ACCOUNT_LOGIN_TYPE_COMMON_CONTACT_MOBILE;
        $data_login_account['is_active'] = Common_flag::LOGIN_ACCOUNT_IS_ACTIVE_ACTIVE;
        $data_login_account['created_at'] = $this->get_now();

        $login_account_id = $this->account_model->user_register($data_user, $data_login_account);
        
        $access_token = $this->account_model->generate_token();

        /////create access token
        $this->access_token_model->createToken($login_account_id, $access_token);

        // //////////////////////create ewallet//////////////////////
        // $ewallet = $this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_CODE);
        // $ewallet = $this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_SSC_CODE);
        // /////////////////////end ewallet//////////////////////

        // ///////send email
        // $description="Dear ".$this->input->post('name').",<br><br>Your account has been created.<br>Please login to your account using your NRIC and the below password:<br> ".$password_p."<br><br>All the best,<br>iAPPS Helpdesk";

        // $params                         = array();
        // $params['notification_type']    = 'email';
        // $params['recipient_id']         = $this->input->post('email');
        // $params['notification_text']    = $description;
        // $params['send_from']            = 'admin';
        // //$params['account_id']         = $profile_id;
        // $params['notification_subject'] = '[ActiveSG] Sucessfully registered';

        // $this->account_model->notification_send($params);
        
        $data_result = array();
        $data_result['access_token'] = $access_token;

        $this->response_message->set_message_with_code(Account_model::CODE_ACCOUNT_CREATED_SUCCESSFULLY, array(RESULTS => $data_result));
        $this->response($this->response_message->get_message(), HEADER_SUCCESS);
        return;
    }
    
    
    
    
    

//     public function get_admin_venue()
//     {
//         //$this->is_required($this->input->post(), array('venue_id', 'user_name', 'password'));
//         $profile_id = $this->get_profile_id();
//         // $this->is_required($this->input->post(), array('user_name'));
//         // $userName = $this->input->post('user_name');

//         if($this->account_model->get_admin_venue($profile_id))
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     ////////////////
//     ////For POS ////
//     ////////////////

//     public function account_search()
//     {
//         $this->is_required($this->input->get(), array('keyword'));
//         $keyword = $this->input->get('keyword');
//         if($this->account_model->account_search($keyword))
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     public function account_list_search()
//     {
//         $this->is_required($this->input->get(), array('keyword'));
//         $page    = $this->input->get('page') ? $this->input->get('page') : self::PAGE;
//         $limit   = $this->input->get('limit') ? $this->input->get('limit') : self::LIMIT;
//         $keyword = $this->input->get('keyword');

//         if($this->account_model->account_list_search($keyword, $limit, $page))
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     ////////////////////////////////////////
//     //////////Membership Module/////////////
//     ////////////////////////////////////////
//     public function register_user()
//     {
//         $adminId = $this->get_profile_id();
//         $data    = $this->account_model->is_access(self::FUNCTION_REGISTER_USER, $adminId);
//         if (!$data) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $ipAddress = $this->input->ip_address();

//         $inputs = array(
//             'identity_number', 'id_type', 'name',
//                         'platform',
//                         'contact_mobile',  'email'
//                         );
//         $this->is_required($this->input->post(), $inputs);

//         //check valid mobile number?
//         if(!$this->validate_phone($this->input->post('contact_mobile')))
//         {
//             $this->response_message->set_message('1001',$this->get_message(1001));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //check valid email?
//         if(!$this->validate_email($this->input->post('email')))
//         {
//             $this->response_message->set_message('1002',$this->get_message('1002'));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         // if($this->input->post('id_type')!='e3_others')
//         // {
//         //     //////check identity or not
//         //     //echo $this->input->post('identity number');die;
//         //     if (!$this->valid_nric($this->input->post('identity_number'),$this->input->post('id_type')))
//         //     {
//         //         $this->response_message->set_message('1071',$this->get_message(1071));
//         //         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//         //         return;
//         //     }
//         // }

//         if (!$this->valid_ic($this->input->post('id_type'), $this->input->post('identity_number'))) {
//             $this->response_message->set_message('1071',$this->get_message(1071));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //generate password
//         $password_p = $this->account_model->generate_salt();
//         ///generate the password
//         $salt       = $this->account_model->generate_salt();
//         $password   = $this->account_model->generate_password($password_p,$salt);


//         ///////data array for user profile table
//         $data                      = array();
//         $data['name']              = $this->input->post('name');
//         $data['email']             = $this->input->post('email')? $this->input->post('email'):NULL;
//         $data['contact_mobile']    = $this->input->post('contact_mobile')? $this->input->post('contact_mobile'):NULL;
//         $data['id_type']           = $this->input->post('id_type')? $this->input->post('id_type'):NULL;
//         $data['identity_number']   = $this->input->post('identity_number')? $this->input->post('identity_number'):NULL;
//         $data['salt']              = $salt;
//         ///DNC
//         $data['dnc_email']         = $this->input->post('dnc_email')? $this->input->post('dnc_email'):'N';
//         $data['dnc_mobile_number'] = $this->input->post('dnc_mobile_number')? $this->input->post('dnc_mobile_number'):'N';
//         $data['dnc_phone_call']    = $this->input->post('dnc_phone_call')? $this->input->post('dnc_phone_call'):'N';
//         $data['dnc_postage_mail']  = $this->input->post('dnc_postage_mail')? $this->input->post('dnc_postage_mail'):'N';
//         $data['channel_id']        = $this->input->post('channel_id')? $this->input->post('channel_id'):NULL;
//         $data['verified']          = 'Y';

//         $this->account_model->setAdminId($adminId);
//         $this->login_model->setAdminId($adminId);

//         ////////check email,mobile no,identity number is unique
//         $check_data=$this->account_model->check_unique($this->input->post('identity_number'),$this->input->post('contact_mobile'),$this->input->post('email'),NULL);
//         if($check_data)
//         {
//             //print_r($check_data);die;
//             if($check_data->verified=='N')//not verified
//             {
//                 $profile_id=$check_data->id;
//                 //Before data save, clear account login table
//                 $this->account_model->common_delete('login_account','profile_id',$check_data->id);
//                 //update the database
//                 // log_message('error', 'account:register_user:285  updating profile_id: '. $check_data->id . ' with '. print_r($data, TRUE));
//                 $this->account_model->common_edit('user_profile','id',$check_data->id,$data);
//                 $this->account_model->add_history($profile_id,'ssc_member.user_profile','ssc_log.hist_user_profile', $ipAddress,self::ACTION_UPDATE);

//                 $rr=$this->account_model->_get_role($profile_id);
//                 if(!$rr)
//                 {
//                     if ($this->input->post('id_type')=='e1_sid') {
//                         $this->account_model->addPublicMapRole($profile_id, 4);  // TODO: magic constant // Changed since RoleChange
//                     } else {
//                         $this->account_model->addPublicMapRole($profile_id, 1); // TODO: MAgic Constant
//                     }
//                 }

//                 //////ordinary hirer have or not for this user
//                 $oo=$this->account_model->_has_ordinary_hirer($profile_id);
//                 if(!$oo)
//                 {
//                     $this->account_model->addOrdinaryHirer($profile_id);
//                 }
//             }
//             else//verified
//             {
//                 if(@$this->input->post('email'))
//                 {
//                     $check_email=$this->account_model->check_unique_email(@$this->input->post('email'));
//                     if($check_email)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }
//                 if(@$this->input->post('contact_mobile'))
//                 {
//                     $check_mobile=$this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));
//                     if($check_mobile)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }
//                 if(@$this->input->post('identity_number'))
//                 {
//                     $check_identity=$this->account_model->check_unique_identity($this->input->post('identity_number'));
//                     if($check_identity)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }
//             }
//         }
//         else//no data
//         {
//             //Save to database
//             $data['created_at'] = date('Y-m-d H:i:s');
//             $data['created_by'] = $adminId;

//             $data['platform']  = $this->input->post('platform');

//             $profile_id = $this->account_model->common_add('ssc_member.user_profile',$data);

//              ////upload photo
//             if (isset($_FILES['photo_file'])) {
//                 //////s3 config
//                 $this->load->library('s3_image');
//                 $this->s3_image = new S3_Image();

//                 $folder       = self::S3_FOLDER;
//                 $s3_bucket=$this->account_model->get_bucket_name();
//                 $maxImageSize = 8000;

//                 $sizes = array(
//                     's_width'  => 200,
//                     's_height' => 200,
//                     'm_width'  => 400,
//                     'm_height' => 400,
//                     'l_width'  => 800,
//                     'l_height' => 800
//                 );

//                 $name                          = $profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//                 $photo_url                     = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);

//                 $data_image                    =array();
//                 $data_image['profile_picture'] =$photo_url;
//                 $this->account_model->common_edit('ssc_member.user_profile','id',$profile_id,$data_image);
//             }

//             $photo_url = $this->account_model->generate_qrcode($this->input->post('identity_number'));

//             if ($photo_url) {
//                 $data11               = array();
//                 $data11['vcard_file'] = @$photo_url;
//                 $update               = $this->account_model->common_edit('user_profile','id',$profile_id,$data11);
//             }

//             $this->account_model->add_history($profile_id,'ssc_member.user_profile','ssc_log.hist_user_profile', $ipAddress,self::ACTION_CREATE);

//             ///////data array for public user role
//             $data = array();

//             if ($this->input->post('id_type')=='e1_sid') {
//                 $data['role_id'] = 4; // TODO: magic number // changed after RoleChange
//             } else {
//                 $data['role_id'] = 1;
//             }

//             ///////data array for ordinery hier
//             $this->account_model->addOrdinaryHirer($profile_id);
//             $this->account_model->addPublicMapRole($profile_id, $data['role_id']);
//         }

//         $access_token = $this->account_model->generate_token();

//         ///////data array for login account table
//         if ($this->input->post('email')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('email'), $password, 'Y', 'Y');

//             /////create access token
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         if ($this->input->post('identity_number')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('identity_number'), $password, 'Y', 'Y');

//             /////create access token
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         if ($this->input->post('contact_mobile')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('contact_mobile'), $password, 'Y', 'Y');

//             /////create access token
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         //////////////////////create ewallet//////////////////////
//         $ewallet = $this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_CODE);
//         $ewallet = $this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_SSC_CODE);
//         /////////////////////end ewallet//////////////////////

//         ///////send email
//         $description="Dear ".$this->input->post('name').",<br><br>Your account has been created.<br>Please login to your account using your NRIC and the below password:<br> ".$password_p."<br><br>All the best,<br>iAPPS Helpdesk";

//         $params                         = array();
//         $params['notification_type']    = 'email';
//         $params['recipient_id']         = $this->input->post('email');
//         $params['notification_text']    = $description;
//         $params['send_from']            = 'admin';
//         //$params['account_id']         = $profile_id;
//         $params['notification_subject'] = '[ActiveSG] Sucessfully registered';

//         $this->account_model->notification_send($params);

//         $this->response_message->set_message('1005', $this->get_message(1005), array(RESULTS => $profile_id));
//         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//         return;
//     }


//     /**
//      *
//      */
//     public function get_template_create_user()
//     {
//         // define the template that is acceptable for member upload
//         // as per 13 mar, this includes:
//         // name, email, identity_number, contact_mobile, contact_home, dob
//         // identity_type, citizenship, race, employment
//         // postalcode, floor no, unit no
//         // dnc phone, dnc sms

//         $this->load->model('account/account_setting_model');

//         $template = $this->account_setting_model->get_template();

//         $this->response_message->set_message(Account_model::CODE_DATA_LISTING,
//             $this->get_message(Account_model::CODE_DATA_LISTING),
//             array(RESULTS => $template));

//         $this->response($this->response_message->get_message());
//     }

//     /**
//      *
//      */
//     public function create_public_user()
//     {
//         $ipAddress = $this->input->ip_address();
//         $adminId = $this->get_profile_id();
//         $data    = $this->account_model->is_access(self::FUNCTION_REGISTER_USER, $adminId);

//         if (!$data) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $this->load->model('account/account_setting_model');

//         $inputs = array( 'name', 'id_type', 'identity_number',
//                         'gender', 'dob', 'citizenship',
//                         'password'
//         );

//         $this->is_required($this->input->post(), $inputs);

//         foreach ( array('id_type'       => 'convert_id_type_to_id',
//                          'citizenship'  => 'convert_citizenship_to_id',
//                          'race'         => 'convert_race_to_id',
//                          'employment'   => 'convert_employment_to_id'
//                 ) as $key => $value) {
//             // no value, no check
//             if (!$this->input->post($key)) {
//                 continue;
//             }

//             if (!($this->account_setting_model->check_combo_data($value, $this->input->post($key)))) {
//                 $this->response_message->set_message(1163, $this->get_message(1163).': ' . ucwords(str_ireplace('_', ' ', $key)));
//                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                 return;
//             }
//         }

//         $_POST['id_type']              = $this->account_setting_model->check_combo_data('convert_id_type_to_id', $this->input->post('id_type'));
//         $_POST['race_id']              = $this->account_setting_model->check_combo_data('convert_race_to_id', $this->input->post('race'));
//         $_POST['citizenship_id']       = $this->account_setting_model->check_combo_data('convert_citizenship_to_id', $this->input->post('citizenship'));
//         $_POST['employment_status_id'] = $this->account_setting_model->check_combo_data('convert_employment_to_id', $this->input->post('employment'));

//         // address
//         $address = $this->account_model->_get_address_by_postalcode($this->input->post('postal_code'));

//         //check valid mobile number?
//         if ($this->input->post('contact_mobile') && !$this->validate_phone($this->input->post('contact_mobile')))
//         {
//             $this->response_message->set_message('1001',$this->get_message(1001));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //check valid email?
//         if ($this->input->post('email') && !$this->validate_email($this->input->post('email')))
//         {
//             $this->response_message->set_message('1002',$this->get_message('1002'));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //check valid ic?
//         if (!$this->valid_nric($this->input->post('identity_number'), $this->input->post('id_type'))) {
//             $this->response_message->set_message('1071',$this->get_message(1071));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //generate password
//         $password_p = $this->input->post('password');
//         $salt       = $this->account_model->generate_salt();
//         $password   = $this->account_model->generate_password($password_p,$salt);

//         ///////data array for user profile table
//         $data                              = array();
//         $data['name']                      = $this->input->post('name');
//         $data['email']                     = $this->input->post('email') ? $this->input->post('email') : NULL;
//         $data['contact_mobile']            = $this->input->post('contact_mobile') ? $this->input->post('contact_mobile') : NULL;
//         $data['contact_home']              = $this->input->post('contact_home') ? $this->input->post('contact_home') : NULL;
//         $data['id_type']                   = $this->input->post('id_type') ? $this->input->post('id_type') : NULL;
//         $data['identity_number']           = $this->input->post('identity_number') ? $this->input->post('identity_number') : NULL;
//         $data['dnc_email']                 = 'Y'; // $this->input->post('dnc_email') ? $this->input->post('dnc_email') : 'N';
//         $data['dnc_mobile_number']         = $this->input->post('dnc_mobile_number') ? $this->input->post('dnc_mobile_number') : 'N';
//         $data['dnc_phone_call']            = $this->input->post('dnc_phone_call') ? $this->input->post('dnc_phone_call') : 'N';
//         $data['dnc_postage_mail']          = 'N'; // $this->input->post('dnc_postage_mail') ? $this->input->post('dnc_postage_mail') : 'N';
//         $data['platform']                  = 'Admin';
//         // $data['channel_id']                = $this->input->post('channel_id') ? $this->input->post('channel_id') : NULL;
//         $data['verified']                  = 'Y';
//         $data['gender']                    = $this->account_setting_model->convert_gender($this->input->post('gender'));
//         $data['dob']                       = $this->input->post('dob');
//         $data['citizenship_id']            = $this->input->post('citizenship_id') ? $this->input->post('citizenship_id') : NULL;
//         $data['race_id']                   = $this->input->post('race_id') ? $this->input->post('race_id') : NULL;
//         // $data['preferred_contact_mode_id'] = $this->input->post('preferred_contact_mode_id')? $this->input->post('preferred_contact_mode_id'):NULL;
//         // $data['sports_interest_other']     = $this->input->post('sports_interest_other')? $this->input->post('sports_interest_other'):NULL;
//         // $data['share_social']              = $this->input->post('share_social');
//         // $data['subscribe_newsletter']      = $subscribe_newsletter;
//         $data['postal_code']               = $this->input->post('postal_code')? $this->input->post('postal_code'):NULL;
//         $data['house_block_no']            = $address ? $address->blk : NULL;
//         $data['street_name']               = $address ? $address->streetname : NULL;
//         $data['unit_no']                   = $this->input->post('unit_no')? $this->input->post('unit_no'):NULL;
//         $data['floor_no']                  = $this->input->post('floor_no')? $this->input->post('floor_no'):NULL;
//         $data['building_name']             = $address ? $address->buildingname : NULL;
//         $data['salt']                      = $salt;
//         $data['created_at']                = date('Y-m-d H:i:s');
//         $data['created_by']                = $adminId;

//         $this->account_model->setAdminId($adminId);
//         $this->login_model->setAdminId($adminId);

//         ////////check email,mobile no,identity number is unique
//         $check_data = $this->account_model->check_unique($this->input->post('identity_number'),$this->input->post('contact_mobile'),$this->input->post('email'),NULL);

//         if($check_data)
//         {
//             if($check_data->verified=='N')//not verified
//             {
//                 $profile_id = $check_data->id;
//                 //Before data save, clear account login table
//                 $this->account_model->common_delete('login_account','profile_id', $profile_id);

//                 //update the database
//                 $data['created_at']                = date('Y-m-d H:i:s');
//                 $data['created_by']                = $adminId;
//                 $data['updated_at']                = date('Y-m-d H:i:s');
//                 $data['updated_by']                = $adminId;

//                 $this->account_model->common_edit('user_profile','id', $profile_id, $data);
//                 $this->account_model->add_history($profile_id,'ssc_member.user_profile','ssc_log.hist_user_profile', $ipAddress, self::ACTION_UPDATE);

//                 // by right, we need to remove everything related to the previous account
//                 if ($this->account_model->_get_role($profile_id)) {
//                     $this->account_model->common_delete('ssc_member.public_user_map_role', 'profile_id', $profile_id);
//                 }

//                 if ($this->input->post('id_type') == 'e1_sid') {
//                     $data['role_id'] = 4; // TODO: magic number // changed after RoleChange
//                 } else {
//                     $data['role_id'] = 1;
//                 }

//                 $this->account_model->addPublicMapRole($profile_id, $data['role_id']);

//                 //////ordinary hirer have or not for this user
//                 $oo = $this->account_model->_has_ordinary_hirer($profile_id);

//                 if(!$oo)
//                 {
//                     $this->account_model->addOrdinaryHirer($profile_id);
//                 }
//             }
//             else//verified
//             {
//                 if ($this->input->post('identity_number'))
//                 {
//                     $check_identity = $this->account_model->check_unique_identity($this->input->post('identity_number'));

//                     if ($check_identity)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }

//                 if ($this->input->post('email'))
//                 {
//                     $check_email = $this->account_model->check_unique_email($this->input->post('email'));

//                     if ($check_email)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }

//                 if ($this->input->post('contact_mobile'))
//                 {
//                     $check_mobile = $this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));

//                     if ($check_mobile)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }
//             }
//         }
//         else//no data
//         {
//             // generate the qrcode
//             $photo_url = $this->account_model->generate_qrcode($this->input->post('identity_number'));

//             if ($photo_url) {
//                 $data['vcard_file'] = $photo_url;
//             }

//             //Save to database
//             $profile_id = $this->account_model->common_add('ssc_member.user_profile',$data);

//              ////upload photo
//             // if (isset($_FILES['photo_file'])) {
//             //     $this->_upload_profile_picture();
//             // }

//             $this->account_model->add_history($profile_id,'ssc_member.user_profile','ssc_log.hist_user_profile', $ipAddress,self::ACTION_CREATE);

//             if ($this->input->post('id_type')=='e1_sid') {
//                 $data['role_id'] = 4; // TODO: magic number // changed after RoleChange
//             } else {
//                 $data['role_id'] = 1;
//             }

//             ///////data array for ordinery hier
//             $this->account_model->addOrdinaryHirer($profile_id);
//             $this->account_model->addPublicMapRole($profile_id, $data['role_id']);
//         }

//         $access_token = $this->account_model->generate_token();

//         ///////data array for login account table
//         if ($this->input->post('email')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('email'), $password, 'Y', 'Y');
//             $this->access_token_model->createToken($account_id, $access_token);

//             // add sending email registration notification
//             $this->load->model('account/account_registration_notification_model');
//             $account             = array();
//             $account['name']     = $data['name'];
//             $account['email']    = $this->input->post('email'); // only for development
//             $account['password'] = $this->input->post('password'); // need to include the original password
//             $account['role_id']  = $data['role_id'];
//             $account['dob']      = $data['dob'];
//             $this->account_registration_notification_model->sendSuccessEmailRegistration($account);
//         }

//         if ($this->input->post('identity_number')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('identity_number'), $password, 'Y', 'Y');
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         if ($this->input->post('contact_mobile')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('contact_mobile'), $password, 'Y', 'Y');
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         //////////////////////create ewallet//////////////////////
//         $this->account_model->create_public_wallet($profile_id);
//         /////////////////////end ewallet//////////////////////

//         $result = array('name' => $this->input->post('name'), 'identity_number' => $this->input->post('contact_mobile'), 'profile_id' => $profile_id);

//         $this->response_message->set_message('1005', $this->get_message(1005), array(RESULTS => $result));
//         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//         return;
//     }

//     /**
//      *
//      */
//     protected function _upload_profile_picture()
//     {
//         //////s3 config
//         $this->load->library('s3_image');
//         $this->s3_image = new S3_Image();

//         $folder       = self::S3_FOLDER;
//         $s3_bucket=$this->account_model->get_bucket_name();
//         $maxImageSize = 8000;

//         $sizes = array(
//             's_width'  => 200,
//             's_height' => 200,
//             'm_width'  => 400,
//             'm_height' => 400,
//             'l_width'  => 800,
//             'l_height' => 800
//         );

//         $name                          = $profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//         $photo_url                     = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);

//         $data_image                    =array();
//         $data_image['profile_picture'] =$photo_url;
//         $this->account_model->common_edit('ssc_member.user_profile','id',$profile_id,$data_image);
//     }

//     public function create_activitySG()
//     {
//         $adminId = $this->get_profile_id();
//         $data    = $this->account_model->is_access(self::FUNCTION_CREATE_ACTIVESG , $adminId);
//         $ipAddress = $this->input->ip_address();

//         if(!$data) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $inputs = array(
//             'identity_number',
//             'name', 'gender', 'race_id', 'dob', 'citizenship_id',
//                         'postal_code',  'house_block_no',  'street_name',
//                         'platform', 'share_social',
//                         'contact_mobile',  'email'
//                         );
//         $this->is_required($this->input->post(), $inputs);

//         if ($this->input->post('gender')!='M' &&
//             $this->input->post('gender')!='F') {
//             $this->response_message->set_message(self::CODE_INVALID_GENDER,$this->get_message(self::CODE_INVALID_GENDER));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         if (!$this->is_dob($this->input->post('dob'))) {
//             $this->invalid_params('dob (eg. 1985-09-09)');
//         }

//         if (!$this->valid_dob_activeSG($this->input->post('dob'))) {
//             $this->invalid_params('dob (age>=16 and age<121)');
//         }

//         //////check identity or not
//         // if (!$this->valid_nric($this->input->post('identity_number'),'e1_sid'))
//         // {
//         //     $this->response_message->set_message('1071',$this->get_message(1071));
//         //     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//         //     return;
//         // }

//         if (!$this->valid_ic('e1_sid', $this->input->post('identity_number'))) {
//             $this->response_message->set_message('1071',$this->get_message(1071));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $acc2 = $this->account_model->check_unique_identity($this->input->post('identity_number'));

//         if ($acc2) {
//             $this->response_message->set_message('1016',$this->get_message('1016'));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //check valid email?
//         if (!$this->validate_email($this->input->post('email'))) {
//             $this->response_message->set_message(self::CODE_INVALID_EMAIL,$this->get_message(self::CODE_INVALID_EMAIL));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $acc=$this->account_model->check_unique_email($this->input->post('email'));

//         if (@$acc) {
//             $this->response_message->set_message('1003',$this->get_message('1003'));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //check valid mobile number?
//         if (!$this->validate_phone($this->input->post('contact_mobile'))) {
//             $this->response_message->set_message(self::CODE_INVALID_MOBILE,$this->get_message(self::CODE_INVALID_MOBILE));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $acc1 = $this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));

//         if ($acc1) {
//             $this->response_message->set_message('1004',$this->get_message('1004'));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }


//         if (!$this->input->post('subscribe_newsletter')) {
//             $subscribe_newsletter = 'N';
//         } else {
//             $subscribe_newsletter = $this->input->post('subscribe_newsletter');
//         }

//         $data                              = array();
//         $data['identity_number']           = $this->input->post('identity_number');
//         $data['name']                      = $this->input->post('name');
//         $data['gender']                    = $this->input->post('gender');
//         $data['dob']                       = $this->input->post('dob');
//         $data['citizenship_id']            = $this->input->post('citizenship_id');
//         $data['race_id']                   = $this->input->post('race_id');
//         $data['id_type']                   = 'e1_sid';
//         $data['preferred_contact_mode_id'] = $this->input->post('preferred_contact_mode_id')? $this->input->post('preferred_contact_mode_id'):NULL;
//         $data['sports_interest_other']     = $this->input->post('sports_interest_other')? $this->input->post('sports_interest_other'):NULL;
//         $data['share_social']              = $this->input->post('share_social');
//         $data['subscribe_newsletter']      = $subscribe_newsletter;
//         /////
//         $data['postal_code']               = $this->input->post('postal_code')? $this->input->post('postal_code'):NULL;
//         $data['house_block_no']            = $this->input->post('house_block_no')? $this->input->post('house_block_no'):NULL;
//         $data['street_name']               = $this->input->post('street_name')? $this->input->post('street_name'):NULL;
//         $data['unit_no']                   = $this->input->post('unit_no')? $this->input->post('unit_no'):NULL;
//         $data['floor_no']                  = $this->input->post('floor_no')? $this->input->post('floor_no'):NULL;
//         $data['building_name']             = $this->input->post('building_name')? $this->input->post('building_name'):NULL;
//         ///DNC
//         $data['dnc_email']                 = $this->input->post('dnc_email')? $this->input->post('dnc_email'):'N';
//         $data['dnc_mobile_number']         = $this->input->post('dnc_mobile_number')? $this->input->post('dnc_mobile_number'):'N';
//         $data['dnc_phone_call']            = $this->input->post('dnc_phone_call')? $this->input->post('dnc_phone_call'):'N';
//         $data['dnc_postage_mail']          = $this->input->post('dnc_postage_mail')? $this->input->post('dnc_postage_mail'):'N';
//         // $data['id_type']                   = $this->input->post('id_type')? $this->input->post('id_type'):NULL;
//         $data['email']                     = $this->input->post('email');
//         $data['contact_mobile']            = $this->input->post('contact_mobile');

//         if ($this->input->post('channel_id')) {
//             $data['channel_id'] = $this->input->post('channel_id');
//         }

//         if ($this->input->post('contact_home')) {
//             $data['contact_home'] = $this->input->post('contact_home');
//         }

//         if ($this->input->post('employment_status_id')) {
//             $data['employment_status_id'] = $this->input->post('employment_status_id');
//         }

//         //generate password
//         $password_p = $this->account_model->generate_salt();
//         ///generate the password
//         $salt       = $this->account_model->generate_salt();
//         $password   = $this->account_model->generate_password($password_p, $salt);


//         //Save to database
//         $data['created_at'] = date('Y-m-d H:i:s');
//         $data['created_by'] = $adminId;
//         $data['verified']   = 'Y';
//         $data['salt']       = $salt;

//         ////////////////////////////
//         ////////check email,mobile no,identity number is unique
//         $check_data=$this->account_model->check_unique(@$this->input->post('identity_number'),@$this->input->post('contact_mobile'),@$this->input->post('email'),NULL);
//         //print_r($check_data);die;
//         if($check_data)
//         {
//             if($check_data->verified=='N')//not verified
//             {
//                 $profile_id = $check_data->id;
//                 //Before data save, clear account login table
//                 $this->account_model->common_delete('ssc_member.login_account','profile_id',$check_data->id);
//                 //update the database
//                 // log_message('error', 'account:create_ActivitySG:823 updating profile_id' . $check_data->id . ' with: '. print_r($data, TRUE));
//                 $this->account_model->common_edit('ssc_member.user_profile','id',$check_data->id,$data);

//                 ///////////////
//                 $rr = $this->account_model->_get_role($profile_id);

//                 if (!$rr) {
//                     $this->account_model->addPublicMapRole($profile_id, 4); // TODO: magic constant // Changed since RoleChange
//                 }

//                 //////ordinary hirer have or not for this user
//                 $oo = $this->account_model->_has_ordinary_hirer($profile_id);

//                 if (!$oo) {
//                     $this->account_model->addOrdinaryHirer($profile_id);
//                 }
//             }
//             else//verified
//             {
//                 if ($this->input->post('email')) {
//                     $check_email = $this->account_model->check_unique_email(@$this->input->post('email'));

//                     if ($check_email) {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }

//                 if($this->input->post('contact_mobile')) {
//                     $check_mobile = $this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));

//                     if ($check_mobile) {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }

//                 if($this->input->post('identity_number')) {
//                     $check_identity = $this->account_model->check_unique_identity($this->input->post('identity_number'));

//                     if ($check_identity) {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                 }
//             }
//         }
//         else//no data
//         {
//             $profile_id = $this->account_model->common_add('ssc_member.user_profile',$data);

//             $this->account_model->addPublicMapRole($profile_id, 4);

//             ///////data array for ordinery hier
//             $this->account_model->addOrdinaryHirer($profile_id);
//         }

//         $access_token = $this->account_model->generate_token();

//         ///////data array for login account table
//         if ($this->input->post('email')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('email'), $password, 'Y', 'Y');
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         if ($this->input->post('contact_mobile')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('contact_mobile'), $password, 'Y', 'Y');
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//         if ($this->input->post('identity_number')) {
//             $account_id = $this->login_model->createLogin($profile_id, $this->input->post('identity_number'), $password, 'Y', 'Y');
//             $this->access_token_model->createToken($account_id, $access_token);
//         }

//          /////////////////////////////////////
//          ////upload photo
//         if (isset($_FILES['photo_file'])) {
//             $this->load->library('s3_image');
//             $this->s3_image = new S3_Image();

//             $folder       = 'account';
//             $s3_bucket=$this->account_model->get_bucket_name();
//             $maxImageSize = 8000;

//             $sizes = array(
//                 's_width'  => 200,
//                 's_height' => 200,
//                 'm_width'  => 400,
//                 'm_height' => 400,
//                 'l_width'  => 800,
//                 'l_height' => 800
//             );

//             $name                      = $profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//             $photo_url                 = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);
//             $data12                    = array();
//             $data12['profile_picture'] = $photo_url;

//             $this->account_model->common_edit('user_profile','id',$profile_id,$data12);
//         }

//         //////////////create vcard
//         $photo_url = $this->account_model->generate_qrcode($this->input->post('identity_number'));

//         if ($photo_url) {
//             $data11               = array();
//             $data11['vcard_file'] = $photo_url;
//             $update               = $this->account_model->common_edit('user_profile','id',$profile_id,$data11);
//         }

//         $this->account_model->add_history($profile_id,'ssc_member.user_profile','ssc_log.hist_user_profile', $ipAddress,self::ACTION_CREATE);

//         /////////////////////////////////////
//         $ewallet = $this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_CODE);
//         $ewallet = $this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_SSC_CODE);
//         /////////////////////end ewallet//////////////////////

//         ////////////////////////////
//          ///////send email
//         $description="Dear ".$this->input->post('name').",<br><br>Your account has been created.<br>Please login to your account using your NRIC and the below password:<br> ".$password_p."<br><br>All the best,<br>iAPPS Helpdesk";

//         $params = array();
//         $params['notification_type']    = 'email';
//         $params['recipient_id']         = $this->input->post('email');
//         $params['notification_text']    = $description;
//         $params['send_from']            = 'admin';
//         //$params['account_id']         = $profile_id;
//         $params['notification_subject'] = '[ActiveSG] Sucessfully registered';

//         $this->account_model->notification_send($params);

//         /////////////////////////////

//         $result               = array();
//         $result['profile_id'] = $profile_id;
//         $this->response_message->set_message(self::CODE_MEMBER_ADD_SUCCESS, $this->get_message(self::CODE_MEMBER_ADD_SUCCESS), array(RESULTS => $result));
//         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//         return;
//     }

//     /*
//         Get ID type
//     */
//     public function get_ID_type()
//     {
//         if($this->account_model->get_ID_type())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         Get race
//     */
//     public function get_race()
//     {
//         if($this->account_model->get_race())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     /*
//         Get saluation
//     */
//     public function get_salutation()
//     {
//         if($this->account_model->get_salutation())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     /*
//         Get citizenship
//     */
//     public function get_citizenship()
//     {
//         if($this->account_model->get_citizenship())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     /*
//         Get employment status
//     */
//     public function get_employment_status()
//     {
//         if($this->account_model->get_employment_status())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     /*
//         Get preferred contact mode
//     */
//     public function get_preferred_contact_mode()
//     {
//         if($this->account_model->get_preferred_contact_mode())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     ///get admin profile
//     public function admin_profile()
//     {
//         $data=$this->get_profile_id_and_token();
//         $profile_id=$data['profile_id'];
//         $access_token=$data['access_token'];

//         ///get profile data
//         $result=$this->account_model->get_admin_profile($profile_id);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         Profile
//     */
//     public function profile()
//     {
//         $this->is_required($this->input->get(), array('profile_id'));

//         ///get profile data
//         $result=$this->account_model->get_profile($this->input->get('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         Get sports interest
//     */
//     public function get_sports_interest()
//     {
//         ///get profile data
//         $result=$this->account_model->get_sports_intrest12();

//         $this->response_message->set_message('1023', $this->get_message(1023),array(RESULTS => $result));
//         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//         return;
//     }

//     /*
//         Get initial credit
//     */
//     public function get_initial_credit()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_INITIAL_CREDIT, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         if($this->account_model->get_initial_credit())
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     /*
//         Update initial credit
//     */
//     public function update_initial_credit()
//     {
//         $this->is_required($this->input->post(), array('role_id_list','initial_credit_list'));
//         $credit = $this->account_model->update_initial_credit($this->input->post('role_id_list'), $this->input->post('initial_credit_list'));
//         if($credit)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }

//     }

//     /**
//      *
//      */
//     protected function valid_ic($id_type, $identity_number)
//     {
//         if ($id_type == 'e3_others') {
//             return true;
//         }

//         if ($id_type == 'e1_sid' || $id_type = 'e2_fin') {
//             if (strlen($identity_number) == 9) {
//                 return true;
//             }
//         }

//         return false;
//     }

//     /*
//         Update My profile
//     */
//     public function update_profile()
//     {
//         $adminId = $this->get_profile_id();
//         $data    = $this->account_model->is_access(self::FUNCTION_UPDATE_MEMBER_PROFILE, $adminId);

//         if (!$data) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $inputs = array(
//             'profile_id',
//             'identity_number',
//             'id_type',
//             'name', 'gender', 'race_id', 'dob', 'citizenship_id',
//                         'postal_code',  'house_block_no',  'street_name'
//                         // 'contact_mobile',  'email'
//                         );

//         $this->is_required($this->input->post(), $inputs);

//         $profile_id   = $this->input->post('profile_id');
//         $access_token = '';

//         ///check member role
//         // $role_id = $this -> account_model -> check_member_role($profile_id);

//         if ($this->input->post('gender')!='M' && $this->input->post('gender')!='F') {
//             $this->response_message->set_message(self::CODE_INVALID_GENDER,$this->get_message(self::CODE_INVALID_GENDER));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         if (!$this->is_dob($this->input->post('dob'))) {
//             $this->invalid_params('dob (eg. Data format:2000-09-09)');
//         }

//         // if ($this->valid_dob_supplementary($this->input->post('dob'))) {
//         //     $role_id=3;
//         // } else {
//         //     $role_id=2;
//         // }

//         if(!$this->input->post('identity_number'))
//         {
//             $this->invalid_params('identity_number');
//         }

//         // if (!$this->valid_nric($this->input->post('identity_number'),$this->input->post('id_type')))
//         // {
//         //     $this->response_message->set_message('1071',$this->get_message(1071));
//         //     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//         //     return;
//         // }

//         // special checking for admin
//         if (!$this->valid_ic($this->input->post('id_type'), $this->input->post('identity_number'))) {
//             $this->response_message->set_message('1071',$this->get_message(1071));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $data_acc = $this->account_model->check_accountbyidentity_number($this->input->post('identity_number'));

//         if ($data_acc) {
//             if($profile_id != $data_acc->profile_id) {
//                 $this->response_message->set_message('1016',$this->get_message('1016'));
//                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                 return;
//             }
//         }


//         $data                              = array();
//         $data['citizenship_id']            = $this->input->post('citizenship_id');
//         $data['id_type']                   = $this->input->post('id_type');
//         $data['identity_number']           = strtoupper($this->input->post('identity_number'));
//         $data['name']                      = $this->input->post('name')? $this->input->post('name'):NULL;
//         $data['gender']                    = $this->input->post('gender')? $this->input->post('gender'):NULL;
//         $data['dob']                       = $this->input->post('dob')? $this->input->post('dob'):NULL;
//         $data['race_id']                   = $this->input->post('race_id')? $this->input->post('race_id'):NULL;
//         $data['preferred_contact_mode_id'] = $this->input->post('preferred_contact_mode_id')? $this->input->post('preferred_contact_mode_id'):NULL;
//         $data['postal_code']               = $this->input->post('postal_code');
//         $data['house_block_no']            = $this->input->post('house_block_no');
//         $data['street_name']               = $this->input->post('street_name');

//         // dnc
//         $data['dnc_email']         = $this->input->post('dnc_email')? $this->input->post('dnc_email'):'N';
//         $data['dnc_mobile_number'] = $this->input->post('dnc_mobile_number')? $this->input->post('dnc_mobile_number'):'N';
//         $data['dnc_phone_call']    = $this->input->post('dnc_phone_call')? $this->input->post('dnc_phone_call'):'N';
//         $data['dnc_postage_mail']  = $this->input->post('dnc_postage_mail')? $this->input->post('dnc_postage_mail'):'N';

//         // parent info
//         $data['parent_name']            = $this->input->post('parent_name');
//         $data['parent_identity_number'] = $this->input->post('parent_identity_number');
//         $data['parent_contact_mobile']  = $this->input->post('parent_contact_mobile');
//         $data['parent_email']           = $this->input->post('parent_email');

//         // user attributes
//         // string of array of json format
//         $data['attributes']             = $this->input->post('attributes');

//         if ($this->input->post('unit_no') !== false) {
//             $data['unit_no'] = $this->input->post('unit_no');
//         }

//         if ($this->input->post('floor_no') !== false) {
//             $data['floor_no'] = $this->input->post('floor_no');
//         }

//         if ($this->input->post('building_name') !== false) {
//             $data['building_name'] = $this->input->post('building_name');
//         }

//         if ($this->input->post('email') != '')
//         {
//             $check_email = $this->account_model->check_unique_emailbyid($this->input->post('email'), $profile_id);

//             if($check_email)
//             {
//                 $this->response_message->set_message('1003',$this->get_message(1003));
//                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                 return;
//             }

//             $data['email'] = $this->input->post('email');
//         } else {
//             $data['email'] = '';
//         }

//         if($this->input->post('contact_mobile') != '')
//         {
//             $check_mobile = $this->account_model->check_unique_mobilenumberbyid($this->input->post('contact_mobile'), $profile_id);

//             if($check_mobile)
//             {
//                 $this->response_message->set_message('1004',$this->get_message(1004));
//                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                 return;
//             }

//             $data['contact_mobile'] = $this->input->post('contact_mobile');
//         } else {
//             $data['contact_mobile'] = '';
//         }

//         if($this->input->post('employment_status_id'))
//         {
//             $data['employment_status_id'] = $this->input->post('employment_status_id');
//         }

//         // quick hack to remove unwanted character
//         $data['sports_interest_other'] = $this->input->post('sports_interest_other');
//         $data['sports_interest_other'] = str_replace(array('<', '>'), '', $data['sports_interest_other']);

//         ////upload photo
//          if (isset($_FILES['photo_file']))
//         {
//             $this->load->library('s3_image');
//             $this->s3_image = new S3_Image();

//             /**
//              * //TODO Need to change to constants
//              */
//             $folder       = 'account';
//             $s3_bucket    = $this->account_model->get_bucket_name();
//             $maxImageSize = 8000;

//             $sizes = array(
//                 's_width'  => 200,
//                 's_height' => 200,
//                 'm_width'  => 400,
//                 'm_height' => 400,
//                 'l_width'  => 800,
//                 'l_height' => 800
//             );

//             $name                    = $profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//             $photo_url               = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);
//             $data['profile_picture'] = $photo_url;
//         }

//         $this->load->model('account/login_model', 'lm');
//         $this->lm->setAdminId($adminId);

//         if($this->account_model->update_profile($profile_id,$data,$access_token))
//         {
//             ///////////Update Role
//             // $data11=array();
//             // $data11['role_id']=$role_id;
//             // $this->account_model->common_edit('ssc_member.public_user_map_role','profile_id',$profile_id,$data11);
//             ///////////Check and update relationship
//             $this->account_model->check_relationship($profile_id, $adminId);

//             ///////////Update sport interest
//             $this->account_model->common_delete('account_sports_interest','profile_id',$profile_id);
//             ////add sport interest
//             if($this->input->post('sports_interest'))
//             {
//                 $pieces = explode(",", $this->input->post('sports_interest'));
//                 $count=count($pieces);
//                 //echo $count;die;
//                 for($i=0;$i<$count;$i++)
//                 {
//                     $data3=array();
//                     $data3['profile_id']=@$profile_id;
//                     $data3['sports_interest_id']=$pieces[$i];
//                     $data3['created_at']=date('Y-m-d H:i:s');

//                     $this->account_model->common_add('account_sports_interest',$data3);
//                 }
//             }
//             $this->response($this->response_message->get_message());
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//     }

//     ///account search by search type
//     public function admin_member_search()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_ADMIN_MEMBER_SEARCH_MEMBER, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $this->is_required($this->input->get(), array('keyword','search_type'));

//         $search_type = $this->input->get('search_type');
//         $keyword = $this->input->get('keyword');

//         if(@$this->input->get('user_type'))
//         {
//             $user_type = $this->input->get('user_type');
//         }
//         else
//         {
//             $user_type = NULL;
//         }

//         $pagination = $this->get_pagination();
//         $account=$this->account_model->admin_member_search_by_pagination($keyword,$search_type,$user_type,$pagination[PAGE], $pagination[LIMIT]);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }

//         /*$account=$this->account_model->admin_member_search($keyword,$search_type);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }*/
//     }

//     ///supplementary member search by search type
//     public function admin_supplementary_member_search()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_SUPPLEMENTARY_SEARCH, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->get(), array('keyword','search_type'));

//         $search_type = $this->input->get('search_type');
//         $keyword = $this->input->get('keyword');

//         $pagination = $this->get_pagination();

//         $account=$this->account_model->admin_supplementary_member_search_by_pagination($keyword,$search_type,$pagination[PAGE], $pagination[LIMIT]);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     //////////POS Member Search
//     public function member_search_all()
//     {
//         $this->is_required($this->input->get(), array('keyword'));
//         $keyword = $this->input->get('keyword');

//         ///////using pagination
//         $pagination = $this->get_pagination();

//         $account = $this->account_model->member_search_all($keyword,$pagination[PAGE], $pagination[LIMIT]);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     //////////ACCOUNT DELETE
//     public function account_delete()
//     {
//         $this->is_required($this->input->post(), array('profile_id'));
//         $profile_id=$this->input->post('profile_id');

//         $account = $this->account_model->account_delete($profile_id);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }


//     ///subscriber user search
//     public function subscriber_user_search()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_SUBSCRIBER_SEARCH, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->get(), array('keyword'));
//         $keyword = $this->input->get('keyword');

//         ///////using pagination
//         $pagination = $this->get_pagination();

//         $account = $this->account_model->subscriber_user_search($keyword,$pagination[PAGE], $pagination[LIMIT]);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     ///suspend user search
//     public function suspend_user_search()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_SUSPEND_USER_SEARCH_SUSPENSE, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $this->is_required($this->input->get(), array('keyword','search_type','status'));

//         $search_type = $this->input->get('search_type');
//         $keyword = $this->input->get('keyword');
//         $status = $this->input->get('status');

//         $pagination = $this->get_pagination();

//         /*if($status=='0')
//         {
//             $account=$this->account_model->admin_member_search_by_pagination($keyword,$search_type,$pagination[PAGE], $pagination[LIMIT]);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }
//         }
//         else
//         {*/
//             $account=$this->account_model->suspend_user_search($keyword,$search_type,$status,$pagination[PAGE], $pagination[LIMIT]);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }
//         //}
//     }

//     ///suspend user search
//     public function reinstate_user_search()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_REINSTATE_USER_SEARCH,$adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $this->is_required($this->input->get(), array('keyword','search_type','status'));

//         $search_type = $this->input->get('search_type');
//         $keyword = $this->input->get('keyword');
//         $status = $this->input->get('status');

//         $pagination = $this->get_pagination();

//         /*if($status=='0')
//         {
//             $account=$this->account_model->admin_member_search_by_pagination($keyword,$search_type,$pagination[PAGE], $pagination[LIMIT]);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }
//         }
//         else
//         {*/
//             $account=$this->account_model->suspend_user_search($keyword,$search_type,$status,$pagination[PAGE], $pagination[LIMIT]);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }
//         //}
//     }

//     ///suspend user search
//     public function suspend_by_level1()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_SUSPEND_LEVEL1, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->post(), array('profile_id','suspended_reason','auto_reinstate'));

//         if($this->input->post('auto_reinstate')=='N')
//         {
//             $this->is_required($this->input->post(), array('start_from','start_to'));
//         }

//         $data=array();
//         $data['profile_id']=@$this->input->post('profile_id');
//         $data['suspended_reason']=@$this->input->post('suspended_reason');
//         $data['auto_reinstate']=@$this->input->post('auto_reinstate');
//         $data['suspended_date_from']=@$this->input->post('start_from')? $this->input->post('start_from'):NULL;
//         $data['suspended_date_to']=@$this->input->post('start_to')? $this->input->post('start_to'):NULL;
//         $data['admin_level1']=$adminId;
//         $data['created_by']=$adminId;
//         $data['suspend_status']=1;

//             $account=$this->account_model->suspend_by_level1($data,$adminId);
//             if($account)
//             {
//                 /////send email to level2

//                 //////
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }

//     }

//     ///suspend user search
//     public function suspend_approve_by_level2()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_SUSPEND_LEVEL2, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->post(), array('profile_id'));

//         $data=array();
//         $data['profile_id']=@$this->input->post('profile_id');
//         $data['admin_level2']=$adminId;
//         $data['updated_by']=$adminId;
//         $data['suspend_status']=2;
//         if($this->input->post('suspended_reason'))
//         {
//             $data['suspended_reason']=$this->input->post('suspended_reason');
//         }

//         //print_r($data);die;

//             $account=$this->account_model->suspend_approve_by_level2($data,$adminId);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }

//     }

//     ///suspend user search
//     public function reinstate_user()
//     {
//         $adminId   = $this->get_profile_id();
//         $this->is_required($this->input->post(), array('profile_id'));

//         $data=array();
//         $data['profile_id']=@$this->input->post('profile_id');
//         $data['reinstate_by']=$adminId;
//         $data['updated_by']=$adminId;
//         $data['suspend_status']=3;
//         if($this->input->post('suspended_reason'))
//         {
//             $data['suspended_reason']=$this->input->post('suspended_reason');
//         }


//         $account=$this->account_model->reinstate_user($data);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }

//     }


//     ///subscriber user search
//     public function subscriber_user_level2_search()
//     {
//         $this->is_required($this->input->get(), array('level1_id'));

//         $account = $this->account_model->subscriber_user_level2_search($this->input->get('level1_id'));
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     ///suspend user search
//     public function add_subscriber_user_level2()
//     {
//         $this->is_required($this->input->post(), array('level1_id','level2_id'));

//         $data=array();
//         $data['sub_id']=@$this->input->post('level1_id');
//         $data['sup_id']=@$this->input->post('level2_id');
//         $data['created_by']=@$this->input->post('level1_id');;

//             $account=$this->account_model->add_subscriber_user_level2($data);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }

//     }

//     public function subscriber_user_level2_delete()
//     {
//         $this->is_required($this->input->post(), array('level1_id','level2_id'));

//         $account = $this->account_model->subscriber_user_level2_delete($this->input->post('level1_id'),$this->input->post('level2_id'));
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     ///suspend user search
//     public function terminate_user()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_TERMINATE_USER, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->post(), array('admin_id','profile_id','blacklist_reason'));

//         $data=array();
//         $data['profile_id']=@$this->input->post('profile_id');
//         $data['blacklist_reason']=@$this->input->post('blacklist_reason');
//         $data['created_by']=$adminId;

//             $account=$this->account_model->terminate_user($data);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }

//     }

//     ///suspend user search
//     public function terminate_user_search()
//     {

//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_TERMINATE_USER_SEARCH, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->get(), array('keyword','search_type'));

//         $search_type = $this->input->get('search_type');
//         $keyword = $this->input->get('keyword');

//         $pagination = $this->get_pagination();

//             $account=$this->account_model->terminate_user_search($keyword,$search_type,$pagination[PAGE], $pagination[LIMIT]);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }
//         //}
//     }

//     /*
//         member conversation
//     */
//     public function member_conversion_supplementary()
//     {
//                     $this->is_required($this->input->post(), array('profile_id','otp_mode'));
//                     $profile_id=$this->input->post('profile_id');
//                     //////check email
//                      if(!$this->input->post('email'))
//                      {
//                         if(!$this->input->post('contact_mobile'))
//                         {
//                             $this->invalid_params('email or mobile number');
//                         }
//                         else
//                         {
//                             //check valid mobile number?
//                             if(!$this->validate_phone($this->input->post('contact_mobile')))
//                             {
//                                 $this->response_message->set_message('1001',$this->get_message(1001));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }
//                             $acc1=$this->account_model->check_unique_mobilenumberbyid($this->input->post('contact_mobile'),$profile_id);
//                             if($acc1)
//                             {
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }
//                         }
//                      }
//                      else
//                      {
//                         //check valid email?
//                         if(!$this->validate_email($this->input->post('email')))
//                         {
//                             $this->response_message->set_message('1002',$this->get_message('1002'));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                         //////check email
//                         $acc=$this->account_model->check_unique_emailbyid($this->input->post('email'),$profile_id);
//                         if($acc)
//                             {
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }

//                      }

//                      //check mobile number
//                      if($this->input->post('contact_mobile'))
//                      {
//                         //check valid mobile number?
//                             if(!$this->validate_phone($this->input->post('contact_mobile')))
//                             {
//                                 $this->response_message->set_message('1001',$this->get_message(1001));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }
//                             $acc1=$this->account_model->check_unique_mobilenumberbyid($this->input->post('contact_mobile'),$profile_id);
//                             if($acc1)
//                             {
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }

//                      }

//                       /////////OTP checking
//                          if($this->input->post('otp_mode')=='email')
//                          {
//                              if(!$this->input->post('email'))
//                              {
//                                 $this->response_message->set_message('1014',$this->get_message(1014));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                              }
//                          }
//                          else if($this->input->post('otp_mode')=='sms')
//                          {
//                              if(!$this->input->post('contact_mobile'))
//                              {
//                                 $this->response_message->set_message('1006',$this->get_message(1006));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                              }
//                         }


//         ///check member role
//         $role_id = $this -> account_model -> check_member_role($this->input->post('profile_id'));
//        // echo $role_id;die;
//         if($role_id==3)
//         {
//                     /////////OTP Sending
//                      if($this->input->post('otp_mode')=='email')
//                      {
//                             $params = array();
//                             $params['otp_type']  = 'email';
//                             $params['profile_id']= @$profile_id;
//                             $params['email']     = $this->input->post('email');

//                             $result=$this->account_model->otp_send($params);

//                             $this->response_message->set_message('1031', $this->get_message(1031), array(RESULTS => $params));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//                             return;

//                             //print_r($result);die;
//                      }
//                      else if($this->input->post('otp_mode')=='sms')
//                      {
//                             $params = array();
//                             $params['otp_type']   = 'sms';
//                             $params['profile_id']= @$profile_id;
//                             $params['mobile_number']      = $this->input->post('contact_mobile');

//                             $result=$this->account_model->otp_send($params);

//                             $this->response_message->set_message('1032', $this->get_message(1032), array(RESULTS => $params));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//                             return;
//                      }
//         }
//         else
//         {
//             $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND,$this->get_message(self::CODE_MEMBER_NOT_FOUND));
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             return;
//         }

//     }

//     /*
//         verify_OTP
//     */
//     public function verify_OTP()
//     {
//         if(!$this->input->post('profile_id'))
//         {
//             $this->invalid_params('profile_id');
//         }

//         $profile_id=$this->input->post('profile_id');

//         $acc=$this -> account_model ->get_account_contact($profile_id);

//         //print_r($acc);die;

//         if(!$this->input->post('email') && !$this->input->post('contact_mobile'))
//         {
//             $this->invalid_params('email or mobile number');
//         }

//         ///////For email
//         if($this->input->post('email'))
//         {
//             $acc_email=$acc->email;
//             if(!$this->input->post('otp_code'))
//             {
//                 $this->invalid_params('otp_code');
//             }

//             $params = array();
//             $params['otp_code']   = $this->input->post('otp_code');
//             $params['profile_id']   = $this->input->post('profile_id');
//             $params['authentication_id']   = $this->input->post('email');
//             $result=$this->account_model->otp_validate($params);
//             //print_r($result);die;

//             if (@$result)
//             {

//                 $data=array();
//                 $data['role_id']=2;
//                 //print_r($data);die;
//                 $result=$this -> account_model -> change_member_role($this->input->post('profile_id'),$data);
//                 if(empty($result))
//                 {
//                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                     return;
//                 }
//                 else
//                 {
//                     ///user profile
//                      $data1=array();
//                      $data1['email']=$this->input->post('email');
//                     log_message('error', 'account:verify OTP:823 updating profile_id' . $this->input->post('profile_id') . ' with: '. print_r($data1, TRUE));
//                      $this->account_model->common_edit('ssc_member.user_profile','id',$this->input->post('profile_id'),$data1);


//                      if($acc_email)
//                      {
//                          $data2=array();
//                          $data2['user_name']=$this->input->post('email');
//                          $this->account_model->common_edit('ssc_member.login_account','user_name',$acc_email,$data2);

//                      }

//                     $this->response($this->response_message->get_message());
//                     return;
//                 }

//             }
//             else
//             {
//                 $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND,$this->get_message(self::CODE_MEMBER_NOT_FOUND));
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//                 return;
//             }
//         }

//     ////for mobile number
//         if($this->input->post('contact_mobile'))
//         {
//             $acc_contact_mobile=$acc->contact_mobile;
//             if(!$this->input->post('otp_code'))
//             {
//                 $this->invalid_params('otp_code');
//             }

//             $params = array();
//             $params['otp_code']   = $this->input->post('otp_code');
//             $params['profile_id']   = $this->input->post('profile_id');
//             $params['authentication_id']   = $this->input->post('contact_mobile');


//             $result=$this->account_model->otp_validate($params);

//             if (@$result)
//             {
//                 $data=array();
//                 $data['role_id']=2;
//                 //print_r($data);die;
//                 $result=$this -> account_model -> change_member_role($this->input->post('profile_id'),$data);
//                 if(empty($result))
//                 {
//                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                     return;
//                 }
//                 else
//                 {

//                     ///user profile
//                      $data1=array();
//                      $data1['contact_mobile']=$this->input->post('contact_mobile');
//                      $this->account_model->common_edit('ssc_member.user_profile','id',$this->input->post('profile_id'),$data1);

//                     ///login account

//                      if(@$acc_contact_mobile)
//                      {
//                         $data2=array();
//                         $data2['user_name']=$this->input->post('contact_mobile');
//                         $this->account_model->common_edit('ssc_member.login_account','user_name',$acc_contact_mobile,$data2);
//                      }

//                     ///
//                     $this->response($this->response_message->get_message());
//                     return;
//                 }
//             }
//             else
//             {
//                 $this->response_message->set_message(self::CODE_MEMBER_NOT_FOUND,$this->get_message(self::CODE_MEMBER_NOT_FOUND));
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//                 return;
//             }
//         }

//     }

//     /*
//         activity listing
//     */
//     public function activity_listing_by_profile_id()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_ACTIVITY_LISTING, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         if(!$this->input->post('profile_id'))
//         {
//             $this->invalid_params('profile_id');
//         }

//         ///get profile data
//         $result=$this->account_model->activity_listing_by_profile_id($this->input->post('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//      * Abdul Shamadhu
//      * Date : 26-01-2015
//      * Member Transaction History Listing Start
//      */

//     public function payment_modes() {
//         $adminId = $this->get_profile_id();
//         $result = $this->account_model->get_paymentmodes();
//         if (empty($result)) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//         } else {
//             $this->response($this->response_message->get_message());
//         }
//     }

//     public function member_transaction_history() {
//         $adminId = $this->get_profile_id();
//         $data = $this->account_model->is_access(self::FUNCTION_ACTIVITY_LISTING, $adminId);
//         if (!$data) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         if (!$this->input->get('profile_id')) {
//             $this->invalid_params('profile_id');
//         }
//         $profile_id = $this->input->get('profile_id') ? $this->input->get('profile_id') : NULL;
//         $sys_code_id = $this->input->get('sys_code_ids') ? $this->input->get('sys_code_ids') : NULL;
//         $payment_mode_id = $this->input->get('payment_mode_ids') ? $this->input->get('payment_mode_ids') : NULL;
//         $date_from = $this->input->get('date_from') ? $this->input->get('date_from') : NULL;
//         $date_to = $this->input->get('date_to') ? $this->input->get('date_to') : NULL;

//         $page = $this->input->get('page') ? $this->input->get('page') : NULL;
//         $limit = $this->input->get('limit') ? $this->input->get('limit') : NULL;

//         $sys_code_ids = $this->_convert_to_array($sys_code_id);
//         $payment_mode_ids = $this->_convert_to_array($payment_mode_id);

//         ///get profile data
//         $result = $this->account_model->member_transaction_history($profile_id, $sys_code_ids, $payment_mode_ids, $date_from, $date_to,$page, $limit);
//         if (empty($result)) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         } else {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }


//     public function ewallet_listing_grant() {
//         $this->is_required($this->input->post(), array('organization_id'));
//         $organization_id = $this->input->post('organization_id');
//         $include_grant = $this->input->post('include_grant');
//         ///get ewallet data
//         $result = $this->account_model->ewallet_listing_grant($organization_id, $include_grant);
//         if (empty($result)) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         } else {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function org_transaction_history() {
//         $adminId = $this->get_profile_id();
// //        $data = $this->account_model->is_access(self::FUNCTION_ACTIVITY_LISTING, $adminId);
// //        if (!$data) {
// //            $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
// //            return;
// //        }
//         $org_id = $this->input->get('org_id') ? $this->input->get('org_id') : NULL;
//         $profile_id = $this->input->get('profile_id') ? $this->input->get('profile_id') : NULL;
//         $payment_mode_id = $this->input->get('payment_mode_ids') ? $this->input->get('payment_mode_ids') : NULL;
//         $date_from = $this->input->get('date_from') ? $this->input->get('date_from') : NULL;
//         $date_to = $this->input->get('date_to') ? $this->input->get('date_to') : NULL;
//         $page = $this->input->get('page') ? $this->input->get('page') : NULL;
//         $limit = $this->input->get('limit') ? $this->input->get('limit') : NULL;
//         $payment_mode_ids = $this->_convert_to_array($payment_mode_id);

//         ///get profile data
//         $result = $this->account_model->org_transaction_history($org_id, $profile_id, $payment_mode_ids, $date_from, $date_to,$page, $limit);
//         if (empty($result)) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         } else {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//      * Abdul Shamadhu
//      * Date : 26-01-2015
//      * Member Transaction History Listing End
//      */



//     /*
//         activity listing
//     */
//     public function activity_detail()
//     {
//         if(!$this->input->post('invoice_id'))
//         {
//             $this->invalid_params('invoice_id');
//         }

//         ///get profile data
//         $result=$this->account_model->activity_detail($this->input->post('invoice_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     ////////////////////////////////////////////////////////////////////////////
//     /*
//         Unused
//         Account signup
//     */
//     public function account_signup()
//     {

//         $this->load->library('s3_image');
//         $this->s3_image = new S3_Image();

//             $folder       = 'account';
//             $s3_bucket=$this->account_model->get_bucket_name();
//             $maxImageSize = 8000;

//                 $sizes = array(
//                 's_width'  => 200,
//                 's_height' => 200,
//                 'm_width'  => 400,
//                 'm_height' => 400,
//                 'l_width'  => 800,
//                 'l_height' => 800
//             );

//         //check agree term and condition or not
//         if(!$this->input->post('term_condition')){
//             $this->invalid_params('term_condition');
//         }
//         else if($this->input->post('term_condition')!="Y")
//         {
//             $this->invalid_params('term_condition');
//         }

//         //check login type
//         if(!$this->input->post('login_type')){
//             $this->invalid_params('login_type');
//         }

//         //check name
//         if(!$this->input->post('name')){
//             $this->invalid_params('name');
//         }

//         //check platform
//         if(!$this->input->post('platform')){
//             $this->invalid_params('platform');
//         }
//         else
//         {
//             if($this->input->post('platform')!='iOS' && $this->input->post('platform')!='Android' && $this->input->post('platform')!='Web' && $this->input->post('platform')!='POS')
//             {
//                 $this->invalid_params('platform');
//             }
//         }

//         if(!$this->input->post('id_type'))
//         {
//             $this->invalid_params('id_type');
//         }

//         //echo $this->input->post('name');die;
//         switch ($this->input->post('login_type'))
//         {

//             case LOGIN_TYPE_NORMAL:
//                  {
//                     if($this->input->post('platform')!='POS')
//                      {
//                          if(!$this->input->post('otp_mode'))
//                          {
//                                 $this->invalid_params('otp_mode');
//                          }
//                     }


//                       if(!$this->input->post('contact_mobile'))
//                      {
//                             $this->invalid_params('contact_mobile');
//                      }
//                      else
//                      {
//                         //check valid mobile number?
//                         if(!$this->validate_phone($this->input->post('contact_mobile')))
//                         {
//                             $this->response_message->set_message('1001',$this->get_message(1001));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                      }

//                      if(@$this->input->post('email'))
//                      {
//                         //check valid email?
//                         if(!$this->validate_email($this->input->post('email')))
//                         {
//                             $this->response_message->set_message('1002',$this->get_message('1002'));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                      }

//                      //check password
//                      if(!$this->input->post('password')){
//                         $this->invalid_params('password');
//                      }
//                      else
//                      {
//                         //check valid password?
//                         if(!$this->validate_password($this->input->post('password')))
//                         {
//                             $this->response_message->set_message('1015',$this->get_message(1015));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                      }

//                      if(!$this->input->post('retype_password')){
//                         $this->invalid_params('retype_password');
//                      }
//                      else
//                      {
//                         if($this->input->post('password')!=$this->input->post('retype_password'))
//                         {
//                             $this->response_message->set_message('1017',$this->get_message(1017));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                      }

//                     if($this->input->post('platform')=='POS')
//                      {
//                         if(!$this->input->post('id_type'))
//                         {
//                             $this->invalid_params('id_type');
//                         }
//                      }

//                     //check id type
//                      if($this->input->post('id_type'))
//                      {
//                         if(!$this->input->post('identity_number'))
//                         {
//                             $this->invalid_params('identity_number');
//                         }

//                         if($this->input->post('id_type')!='e3_others')
//                         {
//                             //////check identity or not
//                             if (!$this->valid_nric($this->input->post('identity_number'),$this->input->post('id_type')))
//                             {
//                                 $this->response_message->set_message('1071',$this->get_message(1071));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }
//                         }
//                      }


//                      if($this->input->post('platform')!='POS')
//                      {
//                           /////////OTP checking
//                          if($this->input->post('otp_mode')=='email')
//                          {
//                              if(!$this->input->post('email'))
//                              {
//                                 $this->response_message->set_message('1014',$this->get_message(1014));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                              }
//                          }
//                          else if($this->input->post('otp_mode')=='sms')
//                          {
//                              if(!$this->input->post('contact_mobile'))
//                              {
//                                 $this->response_message->set_message('1006',$this->get_message(1006));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                              }
//                         }
//                     }

//                      ///generate the password
//                      $salt=$this->account_model->generate_salt();
//                      $password=$this->account_model->generate_password($this->input->post('password'),$salt);

//                      ///////data array for user profile table
//                      $data=array();
//                      $data['name']=@$this->input->post('name');
//                      $data['email']=$this->input->post('email')? $this->input->post('email'):NULL;
//                      $data['contact_mobile']=$this->input->post('contact_mobile')? $this->input->post('contact_mobile'):NULL;
//                      $data['id_type']=$this->input->post('id_type')? $this->input->post('id_type'):NULL;
//                      $data['identity_number']=$this->input->post('identity_number')? strtoupper($this->input->post('identity_number')):NULL;
//                      $data['salt']=$salt;
//                       ///DNC
//                     $data['dnc_email']=$this->input->post('dnc_email')? $this->input->post('dnc_email'):'N';
//                     $data['dnc_mobile_number']=$this->input->post('dnc_mobile_number')? $this->input->post('dnc_mobile_number'):'N';
//                     $data['dnc_phone_call']=$this->input->post('dnc_phone_call')? $this->input->post('dnc_phone_call'):'N';
//                     $data['dnc_postage_mail']=$this->input->post('dnc_postage_mail')? $this->input->post('dnc_postage_mail'):'N';

//                      ////////check email,mobile no,identity number is unique
//                      $check_data=$this->account_model->check_unique($this->input->post('identity_number'),$this->input->post('contact_mobile'),$this->input->post('email'),NULL);

//                      if($check_data)
//                      {
//                         if($check_data->verified=='N')//not verified
//                         {
//                             $profile_id=$check_data->id;
//                             //Before data save, clear account login table
//                             $this->account_model->common_delete('login_account','profile_id',$check_data->id);
//                             //update the database
//                             log_message('error', 'account:account_signup:3207 updating profile_id' . $check_data->id. ' with: '. print_r($data, TRUE));
//                             $this->account_model->common_edit('user_profile','id',$check_data->id,$data);
//                         }
//                         else//verified
//                         {
//                             if($this->input->post('email'))
//                             {
//                                 $check_email=$this->account_model->check_unique_email($this->input->post('email'));
//                                 if($check_email)
//                                 {
//                                     $this->response_message->set_message('1003',$this->get_message(1003));
//                                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                     return;
//                                 }
//                             }
//                             if($this->input->post('contact_mobile'))
//                             {
//                                 $check_mobile=$this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));
//                                 if($check_mobile)
//                                 {
//                                     $this->response_message->set_message('1004',$this->get_message(1004));
//                                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                     return;
//                                 }
//                             }
//                             if($this->input->post('identity_number'))
//                             {
//                                 $check_identity=$this->account_model->check_unique_identity($this->input->post('identity_number'));
//                                 if($check_identity)
//                                 {
//                                     $this->response_message->set_message('1016',$this->get_message(1016));
//                                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                     return;
//                                 }
//                             }
//                         }
//                      }
//                      else//no data
//                      {
//                         //Save to database
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['platform']=$this->input->post('platform');
//                         $profile_id=$this->account_model->common_add('user_profile',$data);
//                         ////upload photo
//                         if (isset($_FILES['photo_file']))
//                         {
//                             $name = $profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//                             $photo_url = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);

//                             $data_image=array();
//                             $data_image['profile_picture']=$photo_url;
//                             $this->account_model->common_edit('user_profile','id',$profile_id,$data_image);

//                         }

//                         $photo_url=$this->account_model->generate_qrcode($this->input->post('identity_number'));
//                         if($photo_url)
//                         {
//                             $data11=array();
//                             $data11['vcard_file']=@$photo_url;
//                             $update=$this->account_model->common_edit('user_profile','id',$profile_id,$data11);
//                         }


//                         ///////data array for public user role
//                         $data=array();
//                         $data['profile_id']=@$profile_id;
//                         if($this->input->post('id_type')=='e1_sid')
//                         {
//                             $data['role_id']=4;
//                         }
//                         else
//                         {
//                             $data['role_id']=1;
//                         }
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $this->account_model->common_add('public_user_map_role',$data);

//                         ///////data array for ordinery hier
//                         $data=array();
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');


//                         //Save to database
//                         $this->account_model->common_add('ordinary_hirer',$data);
//                      }

//                      ///////data array for login account table
//                      if($this->input->post('email'))
//                      {
//                         $data=array();
//                         $data['user_name']=@$this->input->post('email');
//                         $data['password']=@$password;
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $account_id=$this->account_model->common_add('login_account',$data);

//                         /*
//                         /////create access token
//                         $data=array();
//                         $data['account_id']=@$account_id;
//                         $data['access_token']=$this->account_model->generate_token();
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $account_id=$this->account_model->common_add('access_token',$data);
//                         */


//                      }

//                      if($this->input->post('contact_mobile'))
//                      {
//                         $data=array();
//                         $data['user_name']=@$this->input->post('contact_mobile');
//                         $data['password']=@$password;
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $account_id=$this->account_model->common_add('login_account',$data);

//                      }



//             if($this->input->post('platform')!='POS')
//             {


//                     if($this->input->post('identity_number'))
//                      {
//                         $data=array();
//                         $data['user_name']=@$this->input->post('identity_number');
//                         $data['password']=@$password;
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $account_id=$this->account_model->common_add('login_account',$data);

//                      }
//                      /////////OTP Sending
//                      if($this->input->post('otp_mode')=='email')
//                      {
//                             $params = array();
//                             $params['otp_type']   = 'email';
//                             $params['profile_id']= $profile_id;
//                             $params['email']      = $this->input->post('email');

//                             $result=$this->account_model->otp_send($params);

//                             //print_r($result);die;
//                      }
//                      else if($this->input->post('otp_mode')=='sms')
//                      {
//                             $params = array();
//                             $params['otp_type']   = 'sms';
//                             $params['profile_id']= $profile_id;
//                             $params['mobile_number']      = $this->input->post('contact_mobile');

//                            $result=$this->account_model->otp_send($params);
//                     }


//                      $result=array();
//                      $result['profile_id']=$profile_id;
//                      $result['email']=$this->input->post('email')? $this->input->post('email'):NULL;
//                      $result['contact_mobile']=$this->input->post('contact_mobile')? $this->input->post('contact_mobile'):NULL;

//                      ////////call OTP API

//                      $this->response_message->set_message('1018', $this->get_message(1018), array(RESULTS => $result));
//                      $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//                      return;

//             }
//             else
//             {
//                      $data4=array();
//                      $data4['verified']='Y';
//                      $this->account_model->common_edit('user_profile','id',$profile_id,$data4);

//                      if($this->input->post('identity_number'))
//                      {
//                         $data=array();
//                         $data['user_name']=@$this->input->post('identity_number');
//                         $data['password']=@$password;
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['verified']='Y';
//                         $data['active']='Y';
//                         //Save to database
//                         $account_id=$this->account_model->common_add('login_account',$data);

//                      }

//                         //////////////////////create ewallet//////////////////////
//                         $ewallet=$this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_CODE);
//                         $ewallet=$this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_SSC_CODE);
//                         /////////////////////end ewallet//////////////////////


//                      $result=array();
//                      $result['profile_id']=$profile_id;
//                      ////////call OTP API

//                         $this->response_message->set_message('1005', $this->get_message(1005), array(RESULTS => $result));
//                         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//                         return;

//             }


//                  }
//                  break;

//             default:
//                 $this->response_message->set_message('1019',$this->get_message(1019));
//                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                 return;
//                 break;
//         }

//     }

//     public function reset_password()
//     {
//         $this->is_required($this->input->post(), array('new_password', 'profile_id'));
//         $profile_id=$this->input->post('profile_id');

//         $salt=$this -> account_model -> find_account_salt($profile_id);
//         $new_password=$this -> account_model -> generate_password($this->input->post('new_password'),$salt);

//         $data1=array();
//         $data1['password']=$new_password;
//         $this->account_model->common_edit('login_account','profile_id',$profile_id,$data1);

//         $this->response_message->set_message('1012', $this->get_message(1012));
//         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//         return;

//     }

//     public function subscriber_listingby_venue()
//     {
//         $this->is_required($this->input->post(), array('venue_id'));
//         ///get ewallet data
//         $result=$this->account_model-> _subscriber_listingby_venue($this->input->post('venue_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function participants_listing()
//     {
//         $this->is_required($this->input->post(), array('organization_id'));
//         ///get ewallet data
//         $result=$this->account_model->participants_listing($this->input->post('organization_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         @deprecated Belongs to public
//         directActiveSG
//     */
//     public function directActiveSG()
//     {
//     }


//     public function condition_group_listing()
//     {
//         ///get ewallet data
//         $result=$this->account_model->condition_group_listing();
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function condition_code_listing()
//     {
//         $this->is_required($this->input->get(), array('condition_group_code'));

//         $result=$this->account_model->condition_code_listing($this->input->get('condition_group_code'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function role_listing()
//     {
//         ///get ewallet data
//         $result=$this->account_model->role_listing();
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function get_all_pass_type()
//     {
//         $this->is_required($this->input->get(), array('isUnlimited'));

//         ///get ewallet data
//         $result=$this->facility_model->get_all_pass_type($this->input->get('isUnlimited'));

//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function create_add_on()
//     {
//         $this->is_required($this->input->post(), array('name','price','role_id'));
//         if($this->input->post('swim_pass')=='' && $this->input->post('gym_pass')=='')
//         {
//             $this->invalid_params('swim_pass or gym_pass');
//         }
//         $admin=1;

//         $data_b=array();
//         $data_b['name']=$this->input->post('name');
//         $data_b['price']=$this->input->post('price');
//         $data_b['add_on_type']=$this->input->post('add_on_type');
//         $data_b['web_description']=$this->input->post('web_description')? $this->input->post('web_description'):NULL;
//         $data_b['description']=$this->input->post('mobile_description')? $this->input->post('mobile_description'):NULL;
//         $data_b['display_seq']=$this->input->post('display_seq')? $this->input->post('display_seq'):1000;

//         ////check add on type already have
//         if($this->input->post('swim_pass'))
//         {
//             if(!$this->input->post('swim_expired_period'))
//             {
//                 $this->invalid_params('swim_expired_period');
//             }
//             if(!$this->input->post('swim_passtype_id'))
//             {
//                 $this->invalid_params('swim_passtype_id');
//             }

//             $data_b['swim_pass']=$this->input->post('swim_pass');
//             $data_b['swim_expired_period']=$this->input->post('swim_expired_period');
//             $data_b['swim_passtype_id']=$this->input->post('swim_passtype_id');

//         }

//         if($this->input->post('gym_pass'))
//         {
//             if(!$this->input->post('gym_expired_period'))
//             {
//                 $this->invalid_params('gym_expired_period');
//             }
//             if(!$this->input->post('gym_passtype_id'))
//             {
//                 $this->invalid_params('gym_passtype_id');
//             }

//             $data_b['gym_pass']=$this->input->post('gym_pass');
//             $data_b['gym_expired_period']=$this->input->post('gym_expired_period');
//             $data_b['gym_passtype_id']=$this->input->post('gym_passtype_id');
//         }

//         //print_r($data_b);die;

//         /////////////
//         $result=$this->account_model->create_add_on($data_b,$this->input->post('role_id'),@$this->input->post('condition_group'),@$this->input->post('condition_code'),$admin);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function add_on_listing()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_ADDON_LISTING, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $pagination = $this->get_pagination();
//         $result=$this->account_model->add_on_listing($pagination[PAGE], $pagination[LIMIT]);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function update_add_on()
//     {
//         $this->is_required($this->input->post(), array('id','name','price','role_id','condition_group','condition_code','add_on_type'));
//         if($this->input->post('swim_pass')=='' && $this->input->post('gym_pass')=='')
//         {
//             $this->invalid_params('swim_pass or gym_pass');
//         }
//         $admin=1;

//         $data_b=array();
//         $data_b['name']=$this->input->post('name');
//         $data_b['price']=$this->input->post('price');
//         $data_b['add_on_type']=$this->input->post('add_on_type');

//         if($this->input->post('web_description'))
//         {
//             $data_b['web_description']=$this->input->post('web_description');
//         }
//         if($this->input->post('mobile_description'))
//         {
//             $data_b['description']=$this->input->post('mobile_description');
//         }
//         if($this->input->post('display_seq'))
//         {
//             $data_b['display_seq']=$this->input->post('display_seq');
//         }


//         if($this->input->post('swim_pass'))
//         {
//             if(!$this->input->post('swim_expired_period'))
//             {
//                 $this->invalid_params('swim_expired_period');
//             }
//             if(!$this->input->post('swim_passtype_id'))
//             {
//                 $this->invalid_params('swim_passtype_id');
//             }

//             $data_b['swim_pass']=$this->input->post('swim_pass');
//             $data_b['swim_expired_period']=$this->input->post('swim_expired_period');
//             $data_b['swim_passtype_id']=$this->input->post('swim_passtype_id');

//         }
//         else
//         {
//             $data_b['swim_pass']=NULL;
//             $data_b['swim_expired_period']=NULL;
//             $data_b['swim_passtype_id']=NULL;
//         }

//         if($this->input->post('gym_pass'))
//         {
//             if(!$this->input->post('gym_expired_period'))
//             {
//                 $this->invalid_params('gym_expired_period');
//             }
//             if(!$this->input->post('gym_passtype_id'))
//             {
//                 $this->invalid_params('gym_passtype_id');
//             }

//             $data_b['gym_pass']=$this->input->post('gym_pass');
//             $data_b['gym_expired_period']=$this->input->post('gym_expired_period');
//             $data_b['gym_passtype_id']=$this->input->post('gym_passtype_id');
//         }
//         else
//         {
//             $data_b['gym_pass']=NULL;
//             $data_b['gym_expired_period']=NULL;
//             $data_b['gym_passtype_id']=NULL;
//         }

//         //print_r($data_b);die;
//         /////////////
//         $result=$this->account_model->update_add_on($this->input->post('id'),$data_b,$this->input->post('role_id'),$this->input->post('condition_group'),$this->input->post('condition_code'),$admin);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function add_on_detail()
//     {
//         $this->is_required($this->input->post(), array('id'));
//         $result=$this->account_model->add_on_detail($this->input->post('id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function add_on_delete()
//     {
//         $this->is_required($this->input->post(), array('id'));
//         $result=$this->account_model->add_on_delete($this->input->post('id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function join_add_on()
//     {
//         $this->is_required($this->input->post(), array('profile_id','add_on_type'));
//         ///check condition
//         $admin=1;
//         $result=$this->account_model->join_add_on($this->input->post('profile_id'),$this->input->post('add_on_type'),$admin);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     public function get_account_add_on()
//     {

//         $this->is_required($this->input->post(), array('profile_id'));

//         $result=$this->facility_model->get_all_passes($this->input->post('profile_id'));

//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function account_addon_search()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_ACCOUNT_ADDON_SEARCH, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         $this->is_required($this->input->get(), array('keyword','search_type'));

//         $search_type = $this->input->get('search_type');
//         $keyword = $this->input->get('keyword');

//         $pagination = $this->get_pagination();

//             $account=$this->account_model->account_addon_search($keyword,$search_type,$pagination[PAGE], $pagination[LIMIT]);
//             if($account)
//             {
//                 $this->response($this->response_message->get_message());
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//             }
//     }

//     public function test_data()
//     {
//         $profile_id='100007756689217';
//         $account[]=$this->account_model->check_accountbyfacebook($profile_id);
//         $this->account_model->test_data($account);
//     }

//     public function platform_listing()
//     {
//         $result=$this->account_model->platform_listing();
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         Related account listing
//     */
//     public function related_account_listing()
//     {
//         $adminId   = $this->get_profile_id();
//         $data=$this->account_model->is_access(self::FUNCTION_RELATED_LISTING, $adminId);
//         if(!$data)
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         //$this->require_account();
//         $this->is_required($this->input->get(), array('profile_id'));
//         $profile_id=$this->input->get('profile_id');

//         $pagination = $this->get_pagination();
//         ///get profile data
//         $result=$this->account_model->related_account_listing($profile_id,$pagination[PAGE], $pagination[LIMIT]);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         booking listing
//     */
//     public function booking_listing()
//     {
//         //$this->require_account();
//         $this->is_required($this->input->get(), array('profile_id'));
//         $profile_id=$this->input->get('profile_id');

//         $pagination = $this->get_pagination();
//         /*///get profile data
//         $result=$this->account_model->booking_listing($profile_id,$pagination[PAGE], $pagination[LIMIT]);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }*/
//     }

//     /*
//         address by postal code
//     */
//     public function get_address_by_postalcode()
//     {
//         if(!$this->input->post('postal_code'))
//         {
//             $this->invalid_params('postal_code');
//         }
//         ///get address
//         $result=$this->account_model->get_address_by_postalcode($this->input->post('postal_code'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function check_accessiable()
//     {
//             $this->is_required($this->input->post(), array('function_code'));
//             $adminId   = $this->get_profile_id();
//             $data=$this->account_model->is_access($this->input->post('function_code'), $adminId);
//             if(!$data)
//             {
//                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                 return;
//             }
//             else
//             {
//                 $this->response($this->response_message->get_message());
//                 return;
//             }
//     }

//     public function create_admin_user()
//     {
//         $this->is_required($this->input->post(), array('name', 'email', 'role','gender','dob','venue'));
//         //check valid email?
//         $data=array();
//         $data['name']=$this->input->post('name');
//         $data['email']=$this->input->post('email');
//         $data['contact_mobile']=$this->input->post('contact_mobile')?$this->input->post('contact_mobile'):NULL;
//         $data['dob']=$this->input->post('dob');
//         $data['gender']=$this->input->post('gender');
//         $data['venue']=$this->input->post('venue');
//         $data['staff_nric']=$this->input->post('identity_number')?$this->input->post('identity_number'):NULL;
//         $data['employee_id']=$this->input->post('employee_id')?$this->input->post('employee_id'):NULL;
//         $data['salutation_id']=$this->input->post('salutation_id')?$this->input->post('salutation_id'):NULL;

//         $data['password']=$this->input->post('password')? $this->input->post('password'):NULL;
//         $data['role']=$this->input->post('role')? $this->input->post('role'):NULL;
//         $data['group_id']=$this->input->post('group_id')? $this->input->post('group_id'):NULL;


//         $result=$this->account_model->create_admin_user($data);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         Get suspend_status
//     */
//     public function get_suspend_status()
//     {
//         $adminId   = $this->get_profile_id();
//         if($this->account_model->get_suspend_status($adminId))
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//         else{
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//     }

//     public function all_role_listing()
//     {
//         ///get ewallet data
//         $result=$this->account_model->all_role_listing();
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function organization_ewallet_topup()
//     {
//         $adminId   = $this->get_profile_id();
//         $this->is_required($this->input->post(), array('item_id','item_name','origin_price','organization_id','profile_id'));
//         $lat    = $this->input->post('lat')?$this->input->post('lat'):NULL;
//         $long   = $this->input->post('long')?$this->input->post('long'):NULL;

//         //print_r($data);die;
//         ///get ewallet data
//         $result=$this->account_model->organization_ewallet_topup($adminId,$this->input->post('organization_id'),$this->input->post('item_id'),$this->input->post('item_name'),$this->input->post('origin_price'),$lat,$long,$this->input->post('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function shoppingcart_detail()
//     {
//         $adminId   = $this->get_profile_id();
//         $this->is_required($this->input->post(), array('shopping_card_id'));

//         $result=$this->account_model->shoppingcart_detail($this->input->post('shopping_card_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /**
//      * Checkout the shopping cart pos
//      */
//     /*public function checkout(){
//         $this->is_required($this->input->post(), array('profile_id','shopping_cart_id', 'payment_code','amount'));

//         $profileId = $this->input->post('profile_id');
//         $shoppingCartId = $this->input->post('shopping_cart_id');
//         $payment_code = $this->input->post('payment_code');
//         $amount = $this->input->post('amount');

//         if($this->account_model->checkout($profileId, $shoppingCartId, $payment_code,$amount,@$this->input->post('ewallet_passcode'),@$this->input->post('transaction_id'))){
//             $this->response( $this->response_message->get_message());
//         }else{
//             $this->response( $this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID); //TODO
//         }
//     }*/

//     public function checkout(){
//         $adminId   = $this->get_profile_id();
//         $ipAddress = $this->input->ip_address();
//         $this->is_required($this->input->post(), array('shopping_cart_id','profile_id','venue_id'));
//         $paymentList        = $this->input->post('payment_list');

//         $paymentList = json_decode($paymentList);
//         if(!$paymentList){
//             $this->invalid_params('payment_list');
//         }

//         $org_id=NULL;
//         $result=$this->account_model->checkout($ipAddress,$this->input->post('shopping_cart_id'),$paymentList,$org_id,$adminId,$this->input->post('profile_id'),$this->input->post('venue_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     ///org
//     public function shoppingcart_checkout()
//     {
//         $adminId   = $this->get_profile_id();
//         $ipAddress = $this->input->ip_address();
//         $this->is_required($this->input->post(), array('shopping_card_id','organisation_id','profile_id'));
//         $paymentList        = $this->input->post('payment_list');
//         $this->account_model->venueId = $this->input->post('login_venue_id');

//         $paymentList = json_decode($paymentList);
//         if(!$paymentList){
//             $this->invalid_params('payment_list');
//         }
//         $result=$this->account_model->shoppingcart_checkout($ipAddress,$this->input->post('shopping_card_id'),$paymentList,$this->input->post('organisation_id'),$adminId,$this->input->post('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }

//     }

//     ///suspend user search
//     public function reject_suspend()
//     {
//         $adminId   = $this->get_profile_id();
//         $this->is_required($this->input->post(), array('profile_id'));

//         $data=array();
//         $data['profile_id']=@$this->input->post('profile_id');
//         $data['updated_by']=$adminId;
//         $data['deleted_at']=date('Y-m-d H:i:s');

//         $account=$this->account_model->reject_suspend($data,$adminId);
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }

//     }

//     /*public function suspend_user_history()
//     {
//         //$this->require_account()
//         $this->is_required($this->input->post(), array('profile_id'));
//         $pagination = $this->get_pagination();
//         ///get profile data
//         $result=$this->account_model->suspend_user_history($pagination[PAGE], $pagination[LIMIT]);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }*/

//     /*
//         org ewallet_listing
//     */

//     public function ewallet_listing()
//     {
//         $this->is_required($this->input->post(), array('organization_id'));
//         $organization_id=$this->input->post('organization_id');

//         ///get ewallet data
//         $result=$this->account_model->ewallet_listing($organization_id);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         individual ewallet_listing
//     */

//     public function individual_ewallet_listing()
//     {
//         $this->is_required($this->input->post(), array('profile_id'));
//         $profile_id=$this->input->post('profile_id');

//         ///get ewallet data
//         $result=$this->account_model->individual_ewallet_listing($profile_id);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     ///suspend history
//     public function suspend_history()
//     {
//         $adminId   = $this->get_profile_id();
//         $this->is_required($this->input->post(), array('profile_id'));

//         $account=$this->account_model->suspend_history($this->input->post('profile_id'));
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     ///
//     public function category_activity_listing()
//     {
//         $account=$this->facility_model->get_all_activity_type();
//         if($account)
//         {
//             $this->response($this->response_message->get_message());
//         }
//         else
//         {
//             $this->response($this->response_message->get_message(), HEADER_NOT_FOUND);
//         }
//     }

//     /*
//         Create junior account
//     */
//     public function create_junior_account()
//     {
//         $adminId   = $this->get_profile_id();

//         $ipAddress      = $this->input->ip_address();

//         $inputs = array(
//             'nric',
//             'name', 'gender', 'race_id', 'dob', 'citizenship_id',
//                         'parent_name',  'parent_contact_mobile',  'parent_identity_number',
//                         'postal_code',  'house_block_no',  'street_name',
//                         'platform',
//                         'contact_mobile',  'email'
//                         );
//         $this->is_required($this->input->post(), $inputs);

//         //////check identity or not
//         // if (!$this->valid_nric($this->input->post('nric')))
//         // {
//         //     $this->response_message->set_message('1071',$this->get_message(1071));
//         //     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//         //     return;
//         // }


//         if ($this->input->post('gender')!='M' &&
//             $this->input->post('gender')!='F') {
//             $this->response_message->set_message(self::CODE_INVALID_GENDER,$this->get_message(self::CODE_INVALID_GENDER));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         if (!$this->is_dob($this->input->post('dob')))
//         {
//             $this->invalid_params('dob (eg. Data format:1985-09-09)');
//         }
//         if (!$this->valid_dob_supplementary($this->input->post('dob')))
//         {
//             $this->invalid_params('dob (age<16 and age>0)');
//         }

//         //check valid email?
//         if (!$this->validate_email($this->input->post('email'))) {
//             $this->response_message->set_message('1002',$this->get_message('1002'));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $check_email = $this->account_model->check_unique_email(@$this->input->post('email'));

//         if ($check_email) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         //check valid mobile number?
//         if (!$this->validate_phone($this->input->post('contact_mobile'))) {
//             $this->response_message->set_message('1001',$this->get_message(1001));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $check_mobile = $this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));

//         if ($check_mobile) {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         if (!$this->valid_ic('e1_sid', $this->input->post('nric'))) {
//             $this->response_message->set_message('1071',$this->get_message(1071));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         ///////unique or not
//         $check_identity = $this->account_model->check_unique_identity($this->input->post('nric'));

//         if ($check_identity) {
//             $this->response_message->set_message('1016',$this->get_message(1016));
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }

//         $password_p = $this->account_model->generate_salt();
//         ///generate the password
//         $salt       = $this->account_model->generate_salt();
//         $password   = $this->account_model->generate_password($password_p,$salt);


//         $data                              = array();
//         $data['identity_number']           = strtoupper($this->input->post('nric'));
//         $data['name']                      = $this->input->post('name');
//         $data['gender']                    = $this->input->post('gender');
//         $data['dob']                       = $this->input->post('dob');
//         $data['citizenship_id']            = $this->input->post('citizenship_id');
//         $data['race_id']                   = $this->input->post('race_id');
//         $data['preferred_contact_mode_id'] = $this->input->post('preferred_contact_mode_id')? $this->input->post('preferred_contact_mode_id'):NULL;
//         $data['sports_interest_other']     = $this->input->post('sports_interest_other')? $this->input->post('sports_interest_other'):NULL;
//         ///DNC
//         $data['dnc_email']                 = $this->input->post('dnc_email')? $this->input->post('dnc_email'):'N';
//         $data['dnc_mobile_number']         = $this->input->post('dnc_mobile_number')? $this->input->post('dnc_mobile_number'):'N';
//         $data['dnc_phone_call']            = $this->input->post('dnc_phone_call')? $this->input->post('dnc_phone_call'):'N';
//         $data['dnc_postage_mail']          = $this->input->post('dnc_postage_mail')? $this->input->post('dnc_postage_mail'):'N';
//         $data['platform']                  = $this->input->post('platform');
//         $data['salt']                      = $salt;
//         $data['verified']                  = 'Y';
//         $data['created_at']                = date('Y-m-d H:i:s');
//         $data['created_by']                = $adminId;
//         $data['postal_code']               = $this->input->post('postal_code')? $this->input->post('postal_code'):NULL;
//         $data['house_block_no']            = $this->input->post('house_block_no')? $this->input->post('house_block_no'):NULL;
//         $data['street_name']               = $this->input->post('street_name')? $this->input->post('street_name'):NULL;
//         $data['unit_no']                   = $this->input->post('unit_no')? $this->input->post('unit_no'):NULL;
//         $data['floor_no']                  = $this->input->post('floor_no')? $this->input->post('floor_no'):NULL;
//         $data['building_name']             = $this->input->post('building_name')? $this->input->post('building_name'):NULL;
//         $data['email']                     = $this->input->post('email');
//         $data['contact_mobile']            = $this->input->post('contact_mobile');

//         if ($this->input->post('channel_id')) {
//             $data['channel_id'] = $this->input->post('channel_id');
//         }

//         if ($this->input->post('contact_home')) {
//             $data['contact_home'] = $this->input->post('contact_home');
//         }

//         ////add new profile
//         $s_profile_id = $this->account_model->common_add('user_profile',$data);

//         ////upload photo
//         if (isset($_FILES['photo_file']))
//         {
//             $this->load->library('s3_image');
//             $this->s3_image = new S3_Image();

//             $folder         = 'account';
//             $s3_bucket      = $this->account_model->get_bucket_name();
//             $maxImageSize   = 8000;

//             $sizes = array(
//                 's_width'  => 200,
//                 's_height' => 200,
//                 'm_width'  => 400,
//                 'm_height' => 400,
//                 'l_width'  => 800,
//                 'l_height' => 800
//             );

//             $name                          = $s_profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//             $photo_url                     = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);

//             $data_image                    = array();
//             $data_image['profile_picture'] = $photo_url;
//             $this->account_model->common_edit('user_profile','id',$s_profile_id,$data_image);
//         }

//         if ($photo_url = $this->account_model->generate_qrcode($this->input->post('nric'))) {
//             $data11               = array();
//             $data11['vcard_file'] = $photo_url;
//             $update               = $this->account_model->common_edit('user_profile','id',$s_profile_id,$data11);
//         }

//         ///save log
//         $this->account_model->add_history($s_profile_id,'ssc_member.user_profile','ssc_log.hist_user_profile', $ipAddress,self::ACTION_CREATE);

//         ////add sport interest
//         if($this->input->post('sports_interest'))
//         {
//             $pieces = explode(",", $this->input->post('sports_interest'));
//             $count  = count($pieces);

//             for($i=0;$i<$count;$i++) {
//                 $data3                       =array();
//                 $data3['profile_id']         =@$s_profile_id;
//                 $data3['sports_interest_id'] =$pieces[$i];
//                 $data3['created_at']         =date('Y-m-d H:i:s');

//                 $asi=$this->account_model->common_add('account_sports_interest',$data3);

//                 ///save log
//                 $this->account_model->add_history($asi,'ssc_member.account_sports_interest','ssc_log.hist_account_sports_interest', $ipAddress,self::ACTION_CREATE);
//             }
//         }

//         // TODO: missing created by
//         $this->account_model->setAdminId($adminId);
//         $this->account_model->addOrdinaryHirer($s_profile_id);
//         $this->account_model->addPublicMapRole($s_profile_id, 4); // TODO: magic constant // Changed since RoleChange

//         ////add account login
//         $account_id = $this->login_model->createLogin($s_profile_id, $this->input->post('nric'), $password, 'Y', 'Y');

//         ////add relationship
//         $this->account_model->addSupplementaryRelationship( 0,
//                                                             $s_profile_id,
//                                                             $this->input->post('parent_name'),
//                                                             $this->input->post('parent_identity_number'),
//                                                             $this->input->post('parent_contact_mobile'),
//                                                             $this->input->post('parent_email'),
//                                                             $this->input->post('email'),
//                                                             $this->input->post('contact_mobile')
//                                                            );

//         /////create access token
//         $access_token = $this->account_model->generate_token();

//         $data                 = array();
//         $data['account_id']   = $account_id;
//         $data['access_token'] = $access_token;
//         $data['created_at']   = date('Y-m-d H:i:s');
//         $data['created_by']   = $adminId;

//         //Save to database
//         $at=$this->account_model->common_add('access_token',$data);

//          ///save log
//         $this->account_model->add_history($at,'ssc_member.access_token','ssc_log.hist_access_token', $ipAddress,self::ACTION_CREATE);


//         //////////////////////create ewallet//////////////////////
//         $ewallet=$this->account_model->ewallet_create($s_profile_id,self::CHANNEL_EWALLET_CODE);
//         $ewallet=$this->account_model->ewallet_create($s_profile_id,self::CHANNEL_EWALLET_SSC_CODE);
//         /////////////////////end ewallet//////////////////////
//         //////////////topup ewallet
//         //$amount=100;
//         //$ewallet=$this->account_model->ewallet_update($s_profile_id,self::CHANNEL_EWALLET_SSC_CODE,$amount);
//         /////////////

//         //////////////////////////////////////////////////////////////////
//           ///////send email
//         $description="Dear ".$this->input->post('name').",<br><br>Your account has been created.<br>Please login to your account using your NRIC and the below password:<br> ".$password_p."<br><br>All the best,<br>iAPPS Helpdesk";

//         $params                         = array();
//         $params['notification_type']    = 'email';
//         $params['recipient_id']         = $this->input->post('email');
//         $params['notification_text']    = $description;
//         $params['send_from']            = 'admin';
//         //$params['account_id']         = $profile_id;
//         $params['notification_subject'] = '[ActiveSG] Sucessfully registered';

//         $this->account_model->notification_send($params);
//         //////////////////////////////////////////////////////////////////

//         ////return value
//         $data         = array();
//         //$data       =$this->get_profile_id_and_token();
//         $profile_id   = $s_profile_id;
//         $access_token = $access_token;

//         $this->response_message->set_message('1029', $this->get_message(1029), array(ACCESS_TOKEN =>@$access_token));
//         $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//         return;
//     }

//     public function account_add_on_listing()
//     {
//         $this->is_required($this->input->post(), array('profile_id'));
//         //$this->is_required($this->input->post(), array('add_on_type'));

//         $result=$this->account_model->account_add_on_listing($this->input->post('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function account_add_on_listing_pos()
//     {
//         $this->is_required($this->input->post(), array('profile_id'));
//         //$this->is_required($this->input->post(), array('add_on_type'));

//         $result=$this->account_model->account_add_on_listing_pos($this->input->post('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         shopping_cart_add_on
//     */

//     public function addon_shopping_cart()
//     {
//         $adminId   = $this->get_profile_id();
//         $this->is_required($this->input->post(), array('profile_id'));
//         $this->is_required($this->input->post(), array('benefit_id'));

//         $lat        = $this->input->post('lat')?$this->input->post('lat'):NULL;
//         $long       = $this->input->post('long')?$this->input->post('long'):NULL;

//         $result=$this->account_model->add_on_shopping_cart($this->input->post('profile_id'),$this->input->post('benefit_id'),$lat,$long,$adminId);
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     /*
//         Terminate
//     */
//     public function terminate_user_detail()
//     {
//         $this->is_required($this->input->get(), array('profile_id'));

//         ///get profile data
//         $result=$this->account_model->terminate_user_detail($this->input->get('profile_id'));
//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//     public function register_user_ican()
//     {
//                     $adminId   = $this->get_profile_id();
//                     $data=$this->account_model->is_access(self::FUNCTION_REGISTER_USER, $adminId);
//                     if(!$data)
//                     {
//                         $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                         return;
//                     }
//                     //////s3 config
//                     $this->load->library('s3_image');
//                     $this->s3_image = new S3_Image();

//                     $folder       = self::S3_FOLDER;
//                     $s3_bucket=$this->account_model->get_bucket_name();
//                     $maxImageSize = 8000;

//                         $sizes = array(
//                         's_width'  => 200,
//                         's_height' => 200,
//                         'm_width'  => 400,
//                         'm_height' => 400,
//                         'l_width'  => 800,
//                         'l_height' => 800
//                     );

//                     if(!$this->input->post('id_type'))
//                     {
//                         $this->invalid_params('id_type');
//                     }
//                     //check name
//                     if(!$this->input->post('name')){
//                         $this->invalid_params('name');
//                      }

//                     if(!$this->input->post('contact_mobile'))
//                      {
//                             $this->invalid_params('contact_mobile');
//                      }
//                      else
//                      {
//                         //check valid mobile number?
//                         if(!$this->validate_phone($this->input->post('contact_mobile')))
//                         {
//                             $this->response_message->set_message('1001',$this->get_message(1001));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                      }

//                      if(!$this->input->post('email'))
//                      {
//                             $this->invalid_params('email');
//                      }
//                      else
//                      {
//                         //check valid email?
//                         if(!$this->validate_email($this->input->post('email')))
//                         {
//                             $this->response_message->set_message('1002',$this->get_message('1002'));
//                             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                             return;
//                         }
//                      }

//                      if($this->input->post('id_type'))
//                      {
//                         if(!$this->input->post('identity_number'))
//                         {
//                             $this->invalid_params('identity_number');
//                         }

//                         if($this->input->post('id_type')!='e3_others')
//                         {
//                             //////check identity or not
//                             //echo $this->input->post('identity number');die;
//                             if (!$this->valid_nric($this->input->post('identity_number'),$this->input->post('id_type')))
//                             {
//                                 $this->response_message->set_message('1071',$this->get_message(1071));
//                                 $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                 return;
//                             }
//                         }

//                      }

//                      if(!$this->input->post('platform')){
//                             $this->invalid_params('platform');
//                      }

//                      //generate password
//                      $password_p=$this->account_model->generate_salt();
//                      ///generate the password
//                      $salt=$this->account_model->generate_salt();
//                      $password=$this->account_model->generate_password($password_p,$salt);


//                      ///////data array for user profile table
//                      $data=array();
//                      $data['name']=@$this->input->post('name');
//                      $data['email']=$this->input->post('email')? $this->input->post('email'):NULL;
//                      $data['contact_mobile']=$this->input->post('contact_mobile')? $this->input->post('contact_mobile'):NULL;
//                      $data['id_type']=$this->input->post('id_type')? $this->input->post('id_type'):NULL;
//                      $data['identity_number']=$this->input->post('identity_number')? strtoupper($this->input->post('identity_number')):NULL;
//                      $data['salt']=$salt;
//                      $data['r_password']=$password_p;

//                      ///DNC
//                      $data['dnc_email']=$this->input->post('dnc_email')? $this->input->post('dnc_email'):'N';
//                      $data['dnc_mobile_number']=$this->input->post('dnc_mobile_number')? $this->input->post('dnc_mobile_number'):'N';
//                      $data['dnc_phone_call']=$this->input->post('dnc_phone_call')? $this->input->post('dnc_phone_call'):'N';
//                      $data['dnc_postage_mail']=$this->input->post('dnc_postage_mail')? $this->input->post('dnc_postage_mail'):'N';

//                      //$data['verified']='Y';

//                      //print_r($data);die;

//                      ////////check email,mobile no,identity number is unique
//                      $check_data=$this->account_model->check_unique($this->input->post('identity_number'),$this->input->post('contact_mobile'),$this->input->post('email'),NULL);
//                      if($check_data)
//                      {
//                         //print_r($check_data);die;
//                         if($check_data->verified=='N')//not verified
//                         {
//                             $profile_id=$check_data->id;
//                             //Before data save, clear account login table
//                             $this->account_model->common_delete('login_account','profile_id',$check_data->id);
//                             //update the database
//                             log_message('error', 'account:register_user_ican:6194 updating profile_id' . $check_data->id. ' with: '. print_r($data, TRUE));
//                             $this->account_model->common_edit('user_profile','id',$check_data->id,$data);
//                         }
//                         else//verified
//                         {
//                             if(@$this->input->post('email'))
//                             {
//                                 $check_email=$this->account_model->check_unique_email(@$this->input->post('email'));
//                                 if($check_email)
//                                 {
//                                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                     return;
//                                 }
//                             }
//                             if(@$this->input->post('contact_mobile'))
//                             {
//                                 $check_mobile=$this->account_model->check_unique_mobilenumber($this->input->post('contact_mobile'));
//                                 if($check_mobile)
//                                 {
//                                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                     return;
//                                 }
//                             }
//                             if(@$this->input->post('identity_number'))
//                             {
//                                 $check_identity=$this->account_model->check_unique_identity($this->input->post('identity_number'));
//                                 if($check_identity)
//                                 {
//                                     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//                                     return;
//                                 }
//                             }
//                         }
//                      }
//                      else//no data
//                      {
//                         //Save to database
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['created_by']=$adminId;
//                         $data['platform']=@$this->input->post('platform');

//                         $profile_id=$this->account_model->common_add('ssc_member.user_profile',$data);

//                          ////upload photo
//                         if (isset($_FILES['photo_file']))
//                         {
//                             $name = $profile_id.'_'.strtotime(date('Y-m-d H:i:s'));
//                             $photo_url = $this->s3_image->do_s3_upload_file($name, 'photo_file', $sizes, $folder, $s3_bucket, $maxImageSize);

//                             $data_image=array();
//                             $data_image['profile_picture']=$photo_url;
//                             $this->account_model->common_edit('ssc_member.user_profile','id',$profile_id,$data_image);

//                         }

//                         //////////////create vcard
//                         /*$this->s3_image = new S3_Image();

//                             $folder       = 'vcard';
//                             $s3_bucket=$this->account_model->get_bucket_name();
//                             $maxImageSize = 8000;

//                                 $sizes = array(
//                                 's_width'  => 200,
//                                 's_height' => 200,
//                                 'm_width'  => 400,
//                                 'm_height' => 400,
//                                 'l_width'  => 800,
//                                 'l_height' => 800
//                             );
//                         ////////
//                         $text=@$this->input->post('identity_number');
//                         $qr_code    = @$profile_id.'_'.strtotime(date('Y-m-d H:i:s')).'.png';
//                         $qr = new BarcodeQR();
//                         $qr->text($text);
//                         $result=$qr->draw(250, "./upload/qrcode/" . $qr_code);
//                         $photo_url = $this->s3_image->do_s3_upload_file_from_local($qr_code,$sizes, $folder, $s3_bucket, $maxImageSize);
//                         if($photo_url)
//                         {
//                             $data11=array();
//                             $data11['vcard_file']=@$photo_url;
//                             $this->account_model->common_edit('user_profile','id',$profile_id,$data11);
//                         }*/
//                         $photo_url=$this->account_model->generate_qrcode($this->input->post('identity_number'));
//                         if($photo_url)
//                         {
//                             $data11=array();
//                             $data11['vcard_file']=@$photo_url;
//                             $update=$this->account_model->common_edit('user_profile','id',$profile_id,$data11);
//                         }

//                         ///////data array for public user role
//                         $data=array();
//                         $data['profile_id']=@$profile_id;
//                         if($this->input->post('id_type')=='e1_sid')
//                         {
//                             $data['role_id']=4;
//                         }
//                         else
//                         {
//                             $data['role_id']=1;
//                         }
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['created_by']=$adminId;

//                         //Save to database
//                         $this->account_model->common_add('ssc_member.public_user_map_role',$data);

//                         ///////data array for ordinery hier
//                         $data=array();
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['created_by']=$adminId;
//                         //$data['active']='Y';
//                         //$data['verified']='Y';

//                         //Save to database
//                         $this->account_model->common_add('ssc_member.ordinary_hirer',$data);
//                      }

//                      ///////data array for login account table
//                      if($this->input->post('email'))
//                      {
//                         $data=array();
//                         $data['user_name']=@$this->input->post('email');
//                         $data['password']=@$password;
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['created_by']=$adminId;
//                         //$data['active']='Y';
//                         //$data['verified']='Y';


//                         //Save to database
//                         $account_id=$this->account_model->common_add('ssc_member.login_account',$data);

//                         /////create access token
//                             $ac_flag=0;
//                             $access_token=$this->account_model->generate_token();
//                             /*while ($ac_flag < 1)
//                             {
//                                 $has_token=$this->account_model->check_token($access_token);
//                                 if($has_token)
//                                 {
//                                     $access_token=$this->account_model->generate_token();
//                                 }
//                                 else
//                                 {
//                                     $ac_flag=1;
//                                 }
//                             }*/
//                         /////create access token
//                         $data=array();
//                         $data['account_id']=@$account_id;
//                         $data['access_token']=$access_token;
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $this->account_model->common_add('ssc_member.access_token',$data);

//                      }


//                      if($this->input->post('identity_number'))
//                      {
//                         $data=array();
//                         $data['user_name']=@$this->input->post('identity_number');
//                         $data['password']=@$password;
//                         $data['profile_id']=@$profile_id;
//                         $data['created_at']=date('Y-m-d H:i:s');
//                         $data['created_by']=$adminId;
//                         //$data['active']='Y';
//                         //$data['verified']='Y';


//                         //Save to database
//                             $account_id=$this->account_model->common_add('ssc_member.login_account',$data);
//                             $ac_flag=0;
//                             $access_token=$this->account_model->generate_token();
//                             /*while ($ac_flag < 1)
//                             {
//                                 $has_token=$this->account_model->check_token($access_token);
//                                 if($has_token)
//                                 {
//                                     $access_token=$this->account_model->generate_token();
//                                 }
//                                 else
//                                 {
//                                     $ac_flag=1;
//                                 }
//                             }*/
//                         /////create access token
//                         $data=array();
//                         $data['account_id']=@$account_id;
//                         $data['access_token']=$access_token;
//                         $data['created_at']=date('Y-m-d H:i:s');

//                         //Save to database
//                         $this->account_model->common_add('ssc_member.access_token',$data);

//                      }

//                       //////////////////////create ewallet//////////////////////
//                       $ewallet=$this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_CODE);
//                       $ewallet=$this->account_model->ewallet_create($profile_id,self::CHANNEL_EWALLET_SSC_CODE);
//                         /////////////////////end ewallet//////////////////////



//                              ///////send email
//                             /*$description="Dear ".$this->input->post('name').",<br><br>Your account has been created.<br>Please login to your account using your NRIC and the below password:<br> ".$password_p."<br><br>All the best,<br>iAPPS Helpdesk";

//                             $params = array();
//                             $params['notification_type']   = 'email';
//                             $params['recipient_id']   = $this->input->post('email');
//                             $params['notification_text']  = $description;
//                             $params['send_from']   = 'admin';
//                             //$params['account_id']   = $profile_id;
//                             $params['notification_subject']   = '[ActiveSG] Sucessfully registered';

//                             $this->account_model->notification_send($params);*/

//                             //$this->load->helper('util');
//                             //$result = doCurl(COMMON_SERVICE_URL."notification/i/send", $params, 'POST');


//                      $this->response_message->set_message('1005', $this->get_message(1005), array(RESULTS => $profile_id));
//                      $this->response($this->response_message->get_message(), SSC_HEADER_SUCCESS);
//                      return;

//     }

//     public function test_access_token_date()
//     {
//             $token_date=$this->account_model->get_accesstoken_updated_at($this->input->post('access_token'));
//             if($token_date)
//             {
//                 $created_at=@$token_date->created_at;
//                 $updated_at=@$token_date->updated_at;
//                 if($updated_at)
//                 {
//                     $d_date=$updated_at;
//                 }
//                 else
//                 {
//                     $d_date=$created_at;
//                 }
//                 $today = date("Y-m-d H:i:s");
//                 $d_date = date('Y-m-d H:i:s', strtotime($d_date . " +20 minutes"));
//                 if(strtotime($d_date)<strtotime($today))
//                 {
//                     echo 'error';die;
//                 }
//                 echo 'ok';die;
//             }
//     }

//     /*
//         Get channels
//     */
//     public function withdraw()
//     {
//         $adminId   = $this->get_profile_id();
//         // $data=$this->account_model->is_access(self::FUNCTION_REGISTER_USER, $adminId);
//         // if(!$data)
//         // {
//         //     $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//         //     return;
//         // }

//         $this->is_required($this->input->post(), array('withdraw_amount','withdraw_mode','is_org'));
//         $data=array();
//         if($this->input->post('is_org')=='Y')
//         {
//             if(!$this->input->post('organization_id'))
//             {
//                 $this->invalid_params('organization_id');
//             }
//             else
//             {
//                 $data['org_id']=$this->input->post('organization_id');
//                 $data['profile_id']=$this->input->post('organization_id');
//             }
//         }
//         else
//         {
//             if(!$this->input->post('profile_id'))
//             {
//                 $this->invalid_params('profile_id');
//             }
//             else
//             {
//                 $data['profile_id']=$this->input->post('profile_id');
//             }
//         }

//         $data['created_by']=$adminId;
//         $data['withdraw_amount']=$this->input->post('withdraw_amount');
//         $data['withdraw_mode']=$this->input->post('withdraw_mode');
//         $data['is_org']=$this->input->post('is_org');

//         $result=$this->account_model->withdraw($data);

//         if(empty($result))
//         {
//             $this->response($this->response_message->get_message(), SSC_HEADER_PARAMETER_MISSING_INVALID);
//             return;
//         }
//         else
//         {
//             $this->response($this->response_message->get_message());
//             return;
//         }
//     }

//         /*
//          *  Change password by admin - Prasanna
//         */

//         public function changepwd() {
//             $this->is_required($this->input->post(), array('old_password', 'new_password'));
//             $old_password=$this->input->post('old_password');
//             $new_password=$this->input->post('new_password');
//             $profile_id=$this->get_profile_id();

//             if ($this->account_model->changepwd($profile_id,$old_password, $new_password)) {
//                 $this->response($this->response_message->get_message());
//             } else {
//                 $this->response($this->response_message->get_message());
//             }

//         }

}


/* End of file account.php */
/* Location: ./application/controllers/account.php */
