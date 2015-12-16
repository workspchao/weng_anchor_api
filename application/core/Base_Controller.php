<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

// use Aws\Ses\SesClient;
// use Aws\Common\Enum\Region;

use JohnLui\AliyunOSS\AliyunOSS;

// use Config;

class Base_Controller extends CI_Controller {
    
    private $ServerAddress;
    private $AccessKeyId;
    private $AccessKeySecret;
    private $BUCKET;

    public function __construct() {
        parent::__construct();
        
        $this->load->helper('string');

        $language = $this->get_language();
        if ($language == 1) {
            $this->lang->load('common_message', 'chinese');
        } else if ($language == 2) {
            $this->lang->load('common_message', 'english');
        } else {
            $this->lang->load('common_message', 'chinese');
        }
        $this->response_message->set_lang($this->lang);
        
        $this->config->load('oss_config');
        $this->ServerAddress = $this->config->item('ServerAddressInternal') ? $this->config->item('ServerAddressInternal') : $this->config->item('ServerAddress');
        $this->AccessKeyId = $this->config->item('AccessKeyId');
        $this->AccessKeySecret = $this->config->item('AccessKeySecret');
        $this->BUCKET = $this->config->item('BUCKET');
    }

    // Output formats
    private $output_formats = array(
        'json' => 'application/json'
    );

    protected function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    
    /**
     *   Generate random number
     */
    public function generate_random_number($length) {
        $digits = '';
        $numbers = range(0, 9);

        shuffle($numbers);

        for ($i = 0; $i < $length; $i++) {
            $digits .= $numbers[$i];
        }

        return $digits;
    }
    
//    protected function get_lang(){
//        $lang = $this->input->get(LANG);
//        if(empty($lang))
//            $lang = $this->input->post(LANG);
//        
//        $lang = !empty($lang) ? $lang : DEFAULT_LANG;
//        return $lang;
//    }

    protected function get_language() {
        $language = $this->input->get(LANG) ? $this->input->get(LANG) : ($this->input->post(LANG) ? $this->input->post(LANG) : DEFAULT_LANG);
        if (!isset($language) || empty($language))
            $language = DEFAULT_LANG;

        return $language;
    }

    protected function get_limit() {
        $limit = $this->input->get(LIMIT) ? $this->input->get(LIMIT) : ($this->input->post(LIMIT) ? $this->input->post(LIMIT) : DEFAULT_LIMIT);
        if ($limit > MAX_LIMIT)
            $limit = DEFAULT_LIMIT;

        return $limit;
    }

    protected function get_page() {
        $page = $this->input->get(PAGE) ? $this->input->get(PAGE) :  ($this->input->post(PAGE) ? $this->input->post(PAGE) : DEFAULT_PAGE);
        if ($page <= 0)
            $page = DEFAULT_PAGE;

        return $page;
    }

    private function _get_simple_pagination($page, $limit) {
        // Check for valid and limit
        $page = $page < 1 ? 1 : $page;
        $limit = $limit < 1 ? 1 : $limit;
        $offset = (($page * $limit) - $limit);

        return array(LIMIT => $limit, OFFSET => $offset < 1 ? 0 : $offset, PAGE => $page);
    }

    /**
     * @return array with keys: limit, offset, page
     */
    protected function get_pagination() {
        $page = $this->get_page();
        $limit = $this->get_limit();
        $pagination = $this->_get_simple_pagination($page, $limit);

        return $pagination;
    }

    // check the image file type and dimension
    /**
     *
     * @param $var
     */
    protected function check_image($var) {
        $image_info = getimagesize($_FILES[$var]["tmp_name"]);

        $image_width = $image_info[0];
        $image_height = $image_info[1];
        $image_type = $image_info['mime'];

        if ($image_type != 'image/jpeg' && $image_type != 'image/png' && $image_type != 'image/jpg') {
            header("Content-Type: application/json");
            header("Cache-Control: no-store");
            header("HTTP/1.1 " . WA_HEADER_PARAMETER_MISSING_INVALID);

            echo json_encode(array(STATUS_CODE => WA_HEADER_PARAMETER_MISSING_INVALID, MESSAGE => IMAGE_TYPE_ERROR));
            die();
        }

        // if($image_width <= 1500 && $image_height <= 960)
        // {
        // echo json_encode(array('status_code'=>SNB_PARAMETER_MISSING_INVALID, 'message'=>IMAGE_DIMENSION_ERROR));
        // die();
        // }

        if (filesize($_FILES[$var]["tmp_name"]) > 3145728) {
            header("Content-Type: application/json");
            header("Cache-Control: no-store");
            header("HTTP/1.1 " . WA_HEADER_PARAMETER_MISSING_INVALID);

            echo json_encode(array(STATUS_CODE => WA_HEADER_PARAMETER_MISSING_INVALID, MESSAGE => IMAGE_SIZE_ERROR));
            die();
        }

        return true;
    }

    // check email validation
    protected function validate_email($e) {
        return (bool) preg_match("`^[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$`i", trim($e));
    }

    // check ph number
    protected function validate_phone($phone) {
        //SG phone number
        if (strlen($phone) == 8 && is_numeric($phone)) {
            return true;
        }
        //CN phone number
        else if (strlen($phone) == 11 && is_numeric($phone) && preg_match("/1[34578]{1}\d{9}$/", $phone)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check password
     */
    public function validate_password($password) {
        if (strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }

    // check gender
    protected function valid_gender($g) {
        $gender = strtolower($g);

        if ($gender != 'male' && $gender != 'm' && $gender != 'female' && $gender != 'f') {
            return false;
        } else {
            return $gender;
        }
    }

    /**
     * Check dob
     */
    public function is_dob($dob) {
        if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dob)) {
            list($year, $month, $day) = explode('-', $dob);
            $flag = checkdate($month, $day, $year);

            return $flag;
        } else {
            return FALSE;
        }
    }

    public function get_now() {
        return date('Y-m-d H:i:s');
    }
    
    public function get_millisecond()
    {
        $time = explode ( " ", microtime () );
        $millisecond = ceil($time[0] * 1000);
        return $millisecond;
    }

    // // check dob for activeSG
    // public function valid_dob_activeSG($dob) {
    //    $_age = floor( (strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
    //     if ($_age>15 && $_age<121 ) {
    //         return True;
    //     } else {
    //         return False;
    //     }
    // }
    // // check dob for supplementary
    // public function valid_dob_supplementary($dob) {
    //     $_age = floor( (strtotime(date('Y-m-d')) - strtotime($dob)) / 31556926);
    //     if ($_age>-1 && $_age<16 ) {
    //         return True;
    //     } else {
    //         return False;
    //     }
    // }
    // // check nric
    // public function valid_nric($nric,$id_type=NULL) {
    //         $nric = strtoupper($nric);
    //         if ( preg_match('/^[ST][0-9]{7}[JZIHGFEDCBA]$/', $nric) ) 
    //          { // NRIC
    //             $check = "JZIHGFEDCBA";
    //             if(@$id_type)
    //             {
    //                 if($id_type!='e1_sid')
    //                 {
    //                     return false;
    //                 }
    //             }
    //          }
    //          else if ( preg_match('/^[FG][0-9]{7}[XWUTRQPNMLK]$/', $nric) ) 
    //          { // FIN
    //            $check = "XWUTRQPNMLK";
    //            if(@$id_type)
    //             {
    //                if($id_type!='e2_fin')
    //                 {
    //                     return false;
    //                 }
    //             }
    //          } 
    //          else 
    //          {
    //             if($id_type=='e3_others')
    //             {
    //                 return True;
    //             }
    //             else
    //             {
    //                 return False;
    //             }
    //          }
    //           $total = $nric[1]*2
    //             + $nric[2]*7
    //             + $nric[3]*6
    //             + $nric[4]*5
    //             + $nric[5]*4
    //             + $nric[6]*3
    //             + $nric[7]*2;
    //           if ( $nric[0] == "T" OR $nric[0] == "G" ) 
    //           {
    //             // shift 4 places for after year 2000
    //             $total = $total + 4; 
    //           }
    //           if ( $nric[8] == $check[$total % 11] )
    //           {
    //             return TRUE;
    //           } else {
    //             return FALSE;
    //           }
    // }

    /**
     * @params array $data
     * @params int $status_code
     */
    protected function response($data, $status_code = 200) {
        foreach ($data as $k => $v) {
            switch ($k) {
                case 'code':
                    $output_data['code'] = $v;
                    break;

                case 'message':
                    $output_data['message'] = $v;
                    break;

                case 'total':
                    $output_data['total'] = $v;
                    break;

                case 'results':
                    $output_data['results'] = $v;
                    break;

                case 'errors':
                    $output_data['errors'] = $v;
                    break;

                default:
                    $output_data[$k] = $v;
            }
        }

        if (isset($output_data)) {
            // set http response header
            $this->output->set_status_header($status_code);
            $output = json_encode($output_data);
        } else {
            // set http response header
            $this->output->set_status_header(SSC_HEADER_INTERNAL_SERVER_ERROR);
            $output = json_encode(array(MESSAGE => 'Internal server error: Try again later.'));
        }

        // set output content type
        $this->output->set_header('Content-Type: ' . $this->output_formats['json'] . '; charset=utf-8');

        // send output
        $this->output->set_output($output);
    }

    protected function is_required($param = NULL, $rules = NULL, $chekZero = TRUE) {
        if ($param === NULL) {
            $this->invalid_params($rules);
        }

        foreach ($rules as $value) {
            if (!isset($param[$value])) {
                $this->invalid_params($value);
            } else {
                $val = $param[$value];
                if(is_array($val))
                {
                    if(count($val) <= 0)
                        $this->invalid_params($value);
                }
                else
                {
                    $val = trim($val);
                }
                
                if (is_null($val)) {
                    $this->invalid_params($value);
                }

                if ($chekZero) {
                    if (empty($val)) {
                        $this->invalid_params($value);
                    }
                }
            }
        }
    }

    protected function invalid_params($paramName = NULL) {
        header("Content-Type: application/json");
        header("Cache-Control: no-store");
        header("HTTP/1.1 " . WA_HEADER_NOT_FOUND);
        // Output json and die
        echo json_encode(array('status_code' => WA_HEADER_NOT_FOUND, 'message' => $paramName ? "Invalid or missing parameters: $paramName" : "Invalid or missing parameters."));
        die;
    }

    protected function result_not_found($paramName = "Result") {
        header("Content-Type: application/json");
        header("Cache-Control: no-store");
        header("HTTP/1.1 " . WA_HEADER_NOT_FOUND);

        // Output json and die
        echo json_encode(array('status_code' => WA_HEADER_NOT_FOUND, 'message' => "$paramName not found"));
        die;
    }

//    protected function set_elasticache($key, $value)
//    {
//        $server_endpoint = ELASTICACHE_URL;
//        $server_port     = ELASTICACHE_PORT;
//
//        if (version_compare(PHP_VERSION, '5.4.0') < 0)
//        {
//            //PHP 5.3 with php-pecl-memcache
//            $client = new Memcache;
//            $client->connect($server_endpoint, $server_port);
//
//            //If you need debug see $client->getExtendedStats();
//            return $client->set($key, $value, ELASTICACHE_EXPIRY);
//        }
//        else
//        {
//            //PHP 5.4 with php54-pecl-memcached:
//            $client = new Memcached;
//            $client->addServer($server_endpoint, $server_port);
//
//            //If you need debug see $client->getExtendedStats();
//            return $client->set($key, $value, ELASTICACHE_EXPIRY);
//        }
//    }
//
//    protected function get_elasticache($key)
//    {
//        $server_endpoint = ELASTICACHE_URL;
//        $server_port     = ELASTICACHE_PORT;
//
//        $client = new Memcache;
//        $client->connect($server_endpoint, $server_port);
//
//        // Returns FALSE on failure
//        return $client->get($key);
//    }
//
//    protected function delete_elasticache($key)
//    {
//        $server_endpoint = ELASTICACHE_URL;
//        $server_port     = ELASTICACHE_PORT;
//
//        $client = new Memcache;
//        $client->connect($server_endpoint, $server_port);
//
//        // Returns TRUE on success or FALSE on failure.
//        return $client->delete($key);
//    }


    function dump($value) {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }

    // /**
    //  * Require a client
    //  */
    // public function require_client()
    // {
    //     $this->load->model('account/account_model');
    //     if(!$this->account_model->find_client_by_secret(@$this->params('client_secret')))
    //     {
    //         header("Content-Type: application/json");
    //         header("Cache-Control: no-store");
    //         header("HTTP/1.1 ". WA_HEADER_PARAMETER_MISSING_INVALID);
    //         // Output json and die                                  
    //         echo json_encode(array('status_code'=>WA_HEADER_PARAMETER_MISSING_INVALID,'message' => 'Invalid oauth client credentials.'));  
    //         die;  
    //     }
    // }
    // /**
    //  * Require a client and an account
    //  */
    //  public function require_account(){
    //     $accessToken = $this -> input -> get_request_header(X_AUTHORIZATION);
    //     $this->load->model('account/account_model');
    //     $data = $this->account_model->get_profileid_by_accesstoken($accessToken);
    //     if (empty($data)) {
    //         header("Content-Type: application/json");
    //         header("Cache-Control: no-store");
    //         header("HTTP/1.1 " . WA_HEADER_FORBIDDEN);
    //         // Output json and die
    //         echo json_encode(array('status_code' => WA_HEADER_FORBIDDEN, 'message' => 'Invalid oauth token credentials.'));
    //         die ;
    //     }
    // }
    
    /**
     * @return Array with profile_id and access_token: the new access token
     */
    protected function get_profile_id_and_token() {
        $accessToken = $this->input->get_request_header(X_AUTHORIZATION);
        $this->load->model('account/account_model');
        $login_account = $this->account_model->get_profileid_by_accesstoken($accessToken);
        if ($login_account) {
            $token_date = $this->account_model->get_accesstoken_updated_at($accessToken);
            if ($token_date) {
                $created_at = @$token_date->created_at;
                $updated_at = @$token_date->updated_at;
                if ($updated_at) {
                    $d_date = $updated_at;
                } else {
                    $d_date = $created_at;
                }
                $today = date("Y-m-d H:i:s");
                $d_date = date('Y-m-d H:i:s', strtotime($d_date . " +20 minutes"));
                if (strtotime($d_date) < strtotime($today)) {
                    header("Content-Type: application/json");
                    header("Cache-Control: no-store");
                    header("HTTP/1.1 " . WA_HEADER_FORBIDDEN);
                    // Output json and die
                    echo json_encode(array('status_code' => WA_HEADER_FORBIDDEN, 'message' => 'Invalid oauth token credentials.'));
                    die;
                } else {
                    $editData = array();
                    $editData['updated_at'] = date("Y-m-d H:i:s");
                    $this->account_model->common_edit('wa.access_token', 'account_id', $login_account->id, $editData);
                }
            }
            
            $result = array();
            $result['uid'] = $login_account->uid;
            $result['access_token'] = $accessToken;
            return $result;
//            return json_encode($result);
        } else {
            header("Content-Type: application/json");
            header("Cache-Control: no-store");
            header("HTTP/1.1 " . WA_HEADER_FORBIDDEN);
            // Output json and die
            echo json_encode(array('status_code' => WA_HEADER_FORBIDDEN, 'message' => 'Invalid oauth token credentials.'));
            die;
        }
    }
    
    protected function get_loing_account()
    {
        $login_account = $this->get_profile_id_and_token();
        return $login_account;
    }
    
    protected function get_profile_id()
    {
        $login_account = $this->get_loing_account();
        if($login_account && isset($login_account['uid']))
            return $login_account['uid'];
        else
            return 0;
    }

    // /**
    //  * Get the profile id value
    //  */
    // protected function get_profile_id(){
    //     $return = $this->get_profile_id_and_token();
    //     return $return['profile_id'];
    // }
    // /**
    //  * Get account id of the user currently accessing the API
    //  */
    // public function get_account_id() {
    //     echo 'a';
    // }

    protected function no_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
    }

    // /**
    //  * Get error message from database
    //  */
    // public function get_message($code) {
    //     $this -> load -> model('common/common_config_model');
    //     $data=$this -> common_config_model -> get_message($code);
    //     return $data;
    // }

    /**
     * Check whether the value == 'Y'
     * @return TRUE/FALSE
     */
    public function is_yes($value) {
        if ($value == YES_FLAG) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Convert a comma separated string into an array
     * @param String $string
     * @return Array
     */
    protected function _convert_to_array($string, $splitChar = ',') {
        if ($string === NULL) {
            return array();
        }
        $array = explode($splitChar, $string);
        foreach ($array as $key => $value) {
            if (empty($array[$key]) && $array[$key] !== '0') {
                unset($array[$key]);
            }
        }
        $array = array_values($array);
        return $array;
    }

//     public function generate_html_pdf_receive($params, $pdfName, $folderName, $bucketName, $filepath, $viewFileName, $mode = 'P')
//     {
//         $this->output->enable_profiler(false);
//         $this->load->library('s3_image');
//         $this->load->library('parser');
//         require_once(APPPATH . 'third_party/html2pdf/html2pdf.class.php');
//         // page info here, db calls, etc.
//         $html = $this->load->view($viewFileName, $params, true);
//         try
//         {
//             ob_start();
//             $html2pdf = new HTML2PDF($mode, 'A4', 'en', TRUE, 'UTF-8', array(10,10,10,10));
//             $html2pdf->pdf->SetDisplayMode('fullpage');
//             $html2pdf->WriteHTML($html);
//             $html2pdf->Output($filepath, 'F');
//         }
//         catch(HTML2PDF_exception $e)
//         {
//             echo $e;
//             exit;
//         }
// //        $success = $this->s3_image->create_object($folderName . '/' . $pdfName, $filepath, 'html', $bucketName);
// //        if ($success)
// //        {
// //            return TRUE;
// //        }
// //        else
// //        {
// //            return FALSE;
// //        }
//     }

    protected function invalid_params_with_message($message) {
        header("Content-Type: application/json");
        header("Cache-Control: no-store");
        header("HTTP/1.1 " . WA_HEADER_NOT_FOUND);
        echo json_encode(array('status_code' => WA_HEADER_NOT_FOUND, 'message' => $message));
        die;
    }
    
    
    private function _ci_upload($fileParamsName, $newName, $uploadPath = './upload/', $allowedTypes = 'gif|jpg|png', $maxSize = 10240, &$error = '')
    {
        // Load file uploading library
        $this->upload = new CI_Upload(array(
            'file_name' => $newName,
            'overwrite' => true,
            'upload_path' => $uploadPath,
            'allowed_types' => $allowedTypes,
            'max_size' => $maxSize // kilobytes
        ));

        // Try uploading
        if (!$this->upload->do_upload($fileParamsName)) {
            $error = $this->upload->error_msg;
            return false;
        } else {
            // File original path from local server
            $src = $uploadPath . $newName;
            return $src;
        }
    }
    
    private function _oss_upload($srcPath, $newName, $folder = 'upload/')
    {
        try {
            $ossKey = $folder . $newName;
            $oss_result = $this->oss_image->upload($ossKey, $srcPath);
            if($oss_result !== false)
            {
                return $ossKey;
            }
            return false;
        } catch (Exception $ex) {
            log_message('error', $ex);
            return false;
        }
    }
    
    protected function upload_file($field, $newName, $uploadPath, $allowedTypes, $maxSize, $oss_folder)
    {
        if (isset($_FILES[$field])) 
        {
            if(!isset($newName) || $newName === null || empty($newName) || $newName == '')
            {
                $newName = date('YmdHis_') . $this->get_millisecond();
            }
            
            $fullName = $_FILES[$field]['name'];
            $this->dump('fullName' . $fullName);
            $extName = end(explode(".", $fullName));
            $this->dump($extName);
            $extName = strtolower($extName);
            $this->dump($extName);
            $newName = $newName . '.' . $extName;
            exit();
            
            $ci_result = $this->_ci_upload($field, $newName, $uploadPath, $allowedTypes, $maxSize);
            if($ci_result === false)
            {
                return false;
            }
            
//            //#debug code begin# 
//            if(LOCAL_TEST)
//                return $ci_result;
//            //#debug code end# 
            
            $oss_result = $this->_oss_upload($ci_result, $newName, $oss_folder);
            if($oss_result === false)
            {
                return false;
            }

            try
            {
                if (file_exists($ci_result))
                {
                    unlink($ci_result);
                }
            }
            catch(Exception $ex)
            {
                log_message('error', $ex);
            }
            return $oss_result;
        }
        return false;
    }
    
    protected function upload_image($field, $newName, $uploadPath = './upload/images/', $allowedTypes = 'gif|jpg|png', $maxSize = 10240, $oss_folder = 'upload/images/')
    {
        return $this->upload_file($field, $newName, $uploadPath, $allowedTypes, $maxSize, $oss_folder);
    }
    
    /*
    protected function upload_image($fileParamsName, $newName)
    {
        $allowedTypes = 'jpg|png|gif|jpeg|PNG';
        $targetFolder = 'images/';
        $maxSize = 10240;
        
        $this->upload_file($fileParamsName, $newName, null, $targetFolder, $allowedTypes, $maxSize);
    }
    
    private function ci_upload($fileParamsName, $newName, $uploadPath, $allowedTypes, $maxSize, &$error = '') {
        
    }

    public function upload_file($field, $folder = '', $newFileName = '') {
        $error = '';
        $ci_result = $this->ci_upload($field, $newFileName, $uploadPath, $allowedTypes, $maxSize, $error);
        if (!$ci_result) {
            return false;
        }
        
        
        
        
        $ci_result = $this->ci_upload($fileParamsName, $newName, $uploadPath, $allowedTypes, $maxSize, $error);
        if(!ci_result)
        {
            return false;
        }
        
        $this->oss_upload($ci_result, $newName, $targetFolder);
    }
    
    private function oss_upload($srcPath, $newFileName, $targetFolder = 'files/')
    {
        $this->ossClient = AliyunOSS::boot(
            $this->ServerAddress,
            $this->AccessKeyId,
            $this->AccessKeySecret
        );
        
        // $filePath = '/WebSite/Distribution/API/uploads/o/011768c9aa5686308805a9eada872a2e.jpg';
        // $ossKey = 'shop/o/011768c9aa5686308805a9eada872a2e.jpg';
        
        $ossKey = $targetFolder . $newFileName;
        
        $this->ossClient->setBucket(self::BUCKET);
        $this->ossClient->uploadFile($ossKey, $srcPath);
        
        return $ossKey;
    }
    */
    
}

/* End of file Base_Controller.php */
/* Location: ./application/core/Base_Controller.php */