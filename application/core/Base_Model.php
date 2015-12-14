<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Base_model extends CI_Model {

//    public $db_suffix = 'sg';
//    public $errors;
//
//    const NO_OF_DIGIT = 6;
//    const ELASTIC_CACHE_URL = 'elastic_cache_url';

    function __construct() {
        parent::__construct();

        // date_default_timezone_set('Asia/Singapore');
        // $this->db_base = $this->load->database('ssc_common', TRUE);
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

// 	/**
// 	 * Helper function for inserting and updating
// 	 */
// 	public function prepare_modification($data)
// 	{
// 		$flag = FALSE;
// 		foreach($data as $k => $v)
// 		{
// 			if($v)
// 			{
// 				$this->db->set($k, $v);
// 				$flag = TRUE;
// 			}
// 		}
// 		return $flag;
// 	}
// //	/**
// //	 * @param targetFolder: Path to the folder, including bucket name
// //	 */
// //	protected function get_folders($targetFolder){
// //		$data = array(
// //					'small' => S3_BASE_URL . $targetFolder .'s/',
// //					'medium' => S3_BASE_URL . $targetFolder .'m/',
// //					'big' => S3_BASE_URL . $targetFolder .'b/',
// //					'original' => S3_BASE_URL . $targetFolder .'o/',
// //					);
// //		return $data;
// //	}
// 	 /**
//     *   Generate random string
//     */
//     public function generate_random_string($length)
//     {
//         $characters = '0123456789bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ';
//         $randomString = '';
//         for ($i = 0; $i < $length; $i++)
//         {
//             $randomString .= $characters[rand(0, strlen($characters) - 1)];
//         }
//         return $randomString;
//     }


    public function validate($obj) {
        $this->errors = NULL;
        if (!empty($obj) && is_array($obj)) {
            foreach ($obj as $item) {
                $rules = array_keys($item['rule']);

                foreach ($rules as $rule) {
                    if (is_numeric($rule)) {
                        $rule = $item['rule'][$rule];
                    }

                    switch ($rule) {
                        case 'required' : $this->is_required($item);
                            break;
                        case 'min_length' : $this->min_length($item);
                            break;
                        case 'max_length' : $this->max_length($item);
                            break;
                        case 'numeric' : $this->is_numeric($item);
                            break;
                    }

                    if (isset($this->errors[$item['field']])) {
                        break;
                    }
                }
            }
        }

        return FALSE;
    }

    /**
     * Is required validation
     */
    private function is_required($item) {
        if (!$item['value'] || empty($item['value'])) {
            $this->errors[$item['field']]['validation'] = SNB_IS_REQUIRED;
            $this->errors[$item['field']]['msg'] = 'This field is required';
        }
    }

    /**
     * Min length validation
     */
    private function min_length($item) {
        if ($item['value'] && strlen($item['value']) < $item['rule']['min_length']) {
            $this->errors[$item['field']]['validation'] = SNB_MIN_LENGTH;
            $this->errors[$item['field']]['msg'] = 'The field is too short (minimun is ' . $item['rule']['min_length'] . ' characters)';
        }
    }

    /**
     * Max length validation
     */
    private function max_length($item) {
        if ($item['value'] && strlen($item['value']) > $item['rule']['max_length']) {
            $this->errors[$item['field']]['validation'] = SNB_MAX_LENGTH;
            $this->errors[$item['field']]['msg'] = 'The field is too long (maximum is ' . $item['rule']['max_length'] . ' characters)';
        }
    }

    /**
     * Is numeric validation
     */
    private function is_numeric($item) {
        if ($item['value'] && !is_numeric($item['value'])) {
            $this->errors[$item['field']]['validation'] = SNB_IS_NUMERIC;
            $this->errors[$item['field']]['msg'] = 'The field is not a number';
        }
    }

// 	/**
// 	 * method to masks the string
// 	 *
// 	 * @param string $string the string to mask
// 	 * @param string $mask_char the character to be used to mask with
// 	 * @param int $percent the percent of the string to be masked
// 	 */
// 	protected function mask($string, $mask_char, $percent=50 )
// 	{
// 	        // list( $user, $domain ) = preg_split("/@/", $email );
// 	        $len = strlen( $string );
// 	        $mask_count = floor( $len * $percent /100 );
// 	        $offset = floor( ( $len - $mask_count ) / 2 );
// 	        $masked = substr( $string, 0, $offset )
// 	                .str_repeat( $mask_char, $mask_count )
// 	                .substr( $string, $mask_count+$offset );
// 	        return $masked;
// 	}
// 	private function _get_elastic_cache_url()
// 	{
// 		$this->db->select('value');
// 		$this->db->where('unique_code', self::ELASTIC_CACHE_URL);
// 		$this->db->where('deleted_at', NULL);
// 		$row = $this->db->get('ssc_common.core_config_data')->row();
// 		if (isset($row->value))
// 		{
// 			return $row->value;
// 		}
// 		else
// 		{
// 			return FALSE;
// 		}
// 	}
// 	/**
//      * Set the elasticache key value, this function is returns FALSE for testing environment
//      * @param key, key to be used to store elasticache
//      * @param value, value to be stored
//      * @param expiry, how long the elasticache should be stored (in seconds)
//      */
//     protected function set_elasticache($key, $value, $expiry = ELASTICACHE_EXPIRY)
//     {
// 		switch (ENVIRONMENT) {
//                 case 'production' :
//                 case 'development':
//                         break;
//                 case 'testing' :
//                         return FALSE;
//                 default :
//                         exit('The application environment is not set correctly.');
//         }
// 	    if(!$server_endpoint = $this->_get_elastic_cache_url())
// 	    {
// 		    return FALSE;
// 	    }
//         $server_port     = ELASTICACHE_PORT;
//         if (version_compare(PHP_VERSION, '5.4.0') < 0)
//         {
//             //PHP 5.3 with php-pecl-memcache
//             $client = new Memcache;
//             $client->connect($server_endpoint, $server_port);
//             //If you need debug see $client->getExtendedStats();
//             return $client->set($key, $value, $expiry);
//         }
//         else
//         {
//             //PHP 5.4 with php54-pecl-Memcache:
//             $client = new Memcache;
//             $client->addServer($server_endpoint, $server_port);
//             //If you need debug see $client->getExtendedStats();
//             return $client->set($key, $value, $expiry);
//         }
//     }
// 	/**
//      * Get the elasticache value, this function is returns FALSE for testing environment
//      * @param key, key to be used to retrieve cache
//      */
//     protected function get_elasticache($key)
//     {
//     	switch (ENVIRONMENT) {
//                 case 'production' :
//                 case 'development':
//                         break;
//                 case 'testing' :
//                         return FALSE;
//                 default :
//                         exit('The application environment is not set correctly.');
//         }
// 	    if(!$server_endpoint = $this->_get_elastic_cache_url())
// 	    {
// 		    return FALSE;
// 	    }
//         $server_port     = ELASTICACHE_PORT;
//         if (version_compare(PHP_VERSION, '5.4.0') < 0)
//         {
//             //PHP 5.3 with php-pecl-memcache
//             $client = new Memcache;
//             $client->connect($server_endpoint, $server_port);
//         }
//         else
//         {
//             //PHP 5.4 with php54-pecl-Memcache:
//             $client = new Memcache;
//             $client->addServer($server_endpoint, $server_port);
//         }
//         // Returns FALSE on failure
//         return $client->get($key);
//     }
// 	/**
//      * Delete the elasticache, this function is returns FALSE for testing environment
//      * @param key, key to be used to delete cache
//      */
//     protected function delete_elasticache($key)
//     {
//     	switch (ENVIRONMENT) {
//                 case 'production' :
//                 case 'development':
//                         break;
//                 case 'testing' :
//                         return FALSE;
//                 default :
//                         exit('The application environment is not set correctly.');
//         }
// 	    if(!$server_endpoint = $this->_get_elastic_cache_url())
// 	    {
// 		    return FALSE;
// 	    }
//         $server_port     = ELASTICACHE_PORT;
//         if (version_compare(PHP_VERSION, '5.4.0') < 0)
//         {
//             //PHP 5.3 with php-pecl-memcache
//             $client = new Memcache;
//             $client->connect($server_endpoint, $server_port);
//         }
//         else
//         {
//             //PHP 5.4 with php54-pecl-Memcache:
//             $client = new Memcache;
//             $client->addServer($server_endpoint, $server_port);
//         }
//         // Returns TRUE on success or FALSE on failure.
//         return $client->delete($key);
//     }
//     /**
//      * check the json format
//      */
//     protected function is_json($string)
//     {
//         json_decode($string);
//         return (json_last_error() == JSON_ERROR_NONE);
//     }
//     // check email validation
//     protected function validate_email($e) {
//         return (bool)preg_match("`^[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_\`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$`i", trim($e));
//     }
//     // check ph number
//     protected function validate_phone($phone) {
//         if (strlen($phone) == 8 && is_numeric($phone)) {
//             return true;
//         } else {
//             return false;
//         }
//     }
//     /**
//      * Check dob
//      */
//     public function is_dob($dob)
//     {
//         if ( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dob) ) {
//                     list($year , $month , $day) = explode('-',$dob);
//                     $flag=checkdate($month , $day , $year);
//                return $flag;
//             }
//             else
//             {
//                return FALSE;
//             }
//     }
//      /**
//      * Check password
//      */
//     public function validate_password($password)
//     {
//        if(strlen($password)<8)
//         {
//             return false;
//         }
//         else
//         {
//             return true;
//         }
//     }
//     // check nric
//     public function valid_nric($nric,$id_type=NULL) {
//             $nric = strtoupper($nric);
//             if ( preg_match('/^[ST][0-9]{7}[JZIHGFEDCBA]$/', $nric) ) 
//              { // NRIC
//                 $check = "JZIHGFEDCBA";
//                 if(@$id_type)
//                 {
//                     if($id_type!='e1_sid')
//                     {
//                         return false;
//                     }
//                 }
//              }
//              else if ( preg_match('/^[FG][0-9]{7}[XWUTRQPNMLK]$/', $nric) ) 
//              { // FIN
//                $check = "XWUTRQPNMLK";
//                if(@$id_type)
//                 {
//                    if($id_type!='e2_fin')
//                     {
//                         return false;
//                     }
//                 }
//              } 
//              else 
//              {
//                 return false;
//              }
//               $total = $nric[1]*2
//                 + $nric[2]*7
//                 + $nric[3]*6
//                 + $nric[4]*5
//                 + $nric[5]*4
//                 + $nric[6]*3
//                 + $nric[7]*2;
//               if ( $nric[0] == "T" OR $nric[0] == "G" ) 
//               {
//                 // shift 4 places for after year 2000
//                 $total = $total + 4; 
//               }
//               if ( $nric[8] == $check[$total % 11] )
//               {
//                 return TRUE;
//               } else {
//                 return FALSE;
//               }
//     }
//     public function get_increment_id($attribute)
//     {
// //        $this->db->select('*');
// //
// //        $this->db->from('ssc_common.increment_table');
// //
// //        $this->db->where('attribute', $attribute);
// //        $this->db->where('deleted_at', NULL);
//         //      $query = $this->db->get();
//         //use another db reference to avoid mess up with other db transaction
//         $this->db_base->trans_start();
//         $query = $this->db_base->query("select * from ssc_common.increment_table where attribute = '"
//             . $attribute . "' and deleted_at is null for update" );
//         if ($query->num_rows() > 0)
//         {
//             $result = $query->row();
//             $toDate     = date('Y-m-d H:i:s');
//             $todayDay   = date("d", strtotime($toDate));
//             $todayMonth = date("m", strtotime($toDate));
//             $todayYear  = date("Y", strtotime($toDate));
//             $lastIncDate  = $result->last_increment_date;
//             $lastIncDay   = date("d", strtotime($lastIncDate));
//             $lastIncMonth = date("m", strtotime($lastIncDate));
//             $lastIncYear  = date("Y", strtotime($lastIncDate));
//             if ($todayYear > $lastIncYear)
//             {
//                 $incNumber = str_pad(1, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
//                 $this->_reset_increment_id($attribute);
//             }
//             else
//             {
//                 if ($todayMonth > $lastIncMonth)
//                 {
//                     $incNumber = str_pad(1, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
//                     $this->_reset_increment_id($attribute);
//                 }
//                 else
//                 {
//                     if ($todayDay > $lastIncDay)
//                     {
//                         $incNumber = str_pad(1, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
//                         $this->_reset_increment_id($attribute);
//                     }
//                     else
//                     {
//                         $incNumber = str_pad($result->value, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
//                         $this->set_increment_id($attribute, 1);
//                     }
//                 }
//             }
//             $this->db_base->trans_complete();
//             return date("Y") . date("m") . date("d") . $result->prefix . $incNumber;
//         }
//         else
//         {
//             $this->db_base->trans_rollback();
//             return FALSE;
//         }
//     }
//     private function _reset_increment_id($attribute)
//     {
//         $date = date('Y-m-d');
//         $this->db_base->set('value', 2);
//         $this->db_base->set('last_increment_date', $date);
//         $this->db_base->set('updated_at', date('Y-m-d H:i:s'));
//         $this->db_base->where('attribute', $attribute);
//         $this->db_base->where('deleted_at', NULL);
//         if ($this->db_base->update('ssc_common.increment_table'))
//         {
//             return $this->db_base->affected_rows();
//         }
//         else
//         {
//             return FALSE;
//         }
//     }
//     public function set_increment_id($attribute, $value)
//     {
//         $date = date('Y-m-d');
//         $this->db_base->set('value', "value + $value", FALSE);
//         $this->db_base->set('last_increment_date', $date);
//         $this->db_base->set('updated_at', date('Y-m-d H:i:s'));
//         $this->db_base->where('attribute', $attribute);
//         $this->db_base->where('deleted_at', NULL);
//         if ($this->db_base->update('ssc_common.increment_table'))
//         {
//             return $this->db_base->affected_rows();
//         }
//         else
//         {
//             return FALSE;
//         }
//     }
}

/* End of file Base_Model.php */
/* Location: ./application/core/Base_Model.php */