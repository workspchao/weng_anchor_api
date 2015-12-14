<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Base_Common_Model extends Base_Model {

    // const CONDITION_RANGE        = 'condition_type_range';
    // const CONDITION_DATE_RANGE   = 'condition_type_date_range';
    // const CONDITION_TIME_RANGE   = 'condition_type_time_range';
    // const CONDITION_IS_IN        = 'condition_type_is_in';
    // const CONDITION_EQUALS       = 'condition_type_equals';
    // const CONDITION_NOT_EQUAL    = 'condition_type_not_equals';
    // const CONDITION_GREATER_THAN = 'condition_type_greater_than';
    // const CONDITION_LESS_THAN    = 'condition_type_less_than';
    // const ACTION_CREATE = 'C';
    // const ACTION_UPDATE = 'U';
    // const ACTION_DELETE = 'D';
    // const NO_OF_DIGIT = 6;
    // const CODE_FORBIDDEN_FUNCTION = 10403;
    // const CODE_FORBIDDEN_VENUE    = 10401;
    // const S3_BASE_URL = 's3_base_url';
    // const S3_BUCKET   = 's3_bucket';


    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Get the User IP address
     * @return string
     */
    protected function get_ip_address() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    protected function get_now() {
//        return $this->date->format('Y-m-d H:i:s');
        return date("Y-m-d H:i:s");
    }

    /**
     * @param int $accountId
     * @param int $userId
     * @param string $ipAddress
     * @param string $action
     */
    protected function common_log($accountId, $userId, $ipAddress, $action) {
        $this->db->set('account_id', $accountId);
        $this->db->set('uid', $userId);
        $this->db->set('ip_address', $ipAddress);
        $this->db->set('action', $action);
        $this->db->set('created_at', date('Y-m-d H:i:s'));
        $this->db->set('flag', $accountId);

        $this->db->insert('wa.common_log');
    }

    public function common_add($tableName, $data) {
        $this->db->insert($tableName, $data);
        return $this->db->insert_id();
    }

    public function common_edit($tableName, $key, $value, $data) {
        $data['updated_at'] = date("Y-m-d H:i:s");
        $this->db->where($key, $value);
        if ($this->db->update($tableName, $data)) {
            return $this->db->affected_rows();
        } else {
            return FALSE;
        }
    }

    public function common_edit_without_date($tableName, $key, $value, $data) {
        $this->db->where($key, $value);
        if ($this->db->update($tableName, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function common_delete_logic($tableName, $key, $value) {
        $this->db->where($key, $value);
        if ($this->db->update($tableName, array('deleted_at' => date("Y-m-d H:i:s")))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Generate access token
     */
    public function generate_token() {
        /////create access token
        $this->load->model('account/account_model');
        $ac_flag = 0;
        $access_token = md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
        while ($ac_flag < 1) {
            $has_token = $this->account_model->check_token($access_token);
            if ($has_token) {
                $access_token = md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
            } else {
                $ac_flag = 1;
            }
        }
        return $access_token;
        //return md5(base64_encode(pack('N6', mt_rand(), mt_rand(), mt_rand(), mt_rand(), mt_rand(), uniqid())));
    }
    
    

    //    public function common_select_all($tableName)
    //    {
    //        return $this->db->get_where($tableName, array('deleted_at' => NULL))->result();
    //    }
    //    public function common_select_where($tableName, $key, $value)
    //    {
    //        return $this->db->get_where($tableName, array($key => $value, 'deleted_at' => NULL))->result();
    //    }
    //    public function common_select_row($tableName, $key, $value)
    //    {
    //        return $this->db->get_where($tableName, array($key => $value, 'deleted_at' => NULL))->row();
    //    }
    //    public function common_select_without_date($tableName, $key, $value)
    //    {
    //        return $this->db->get_where($tableName, array($key => $value))->result();
    //    }
    //    public function common_select_limit($tableName, $key, $value, $limit, $offset)
    //    {
    //        return $this->db->get_where($tableName, array($key => $value, 'deleted_at' => NULL), $limit, $offset)->result();
    //    }
    //    public function common_select_limit_total($tableName, $key, $value)
    //    {
    //        return $this->db->get_where($tableName, array($key => $value, 'deleted_at' => NULL))->num_rows();
    //    }
    //    public function common_permanent_delete($tableName, $key, $value)
    //    {
    //        $this->db->where($key, $value);
    //        if ($this->db->delete($tableName))
    //        {
    //            return $this->db->affected_rows();
    //        }
    //        else
    //        {
    //            return FALSE;
    //        }
    //    }
    //    /**
    //     *   Generate random password for forgot password
    //     */
    //    public function generate_password()
    //    {
    //        return random_string('alnum', 8);
    //    }
    //    /**
    //     *   Generate random password for forgot password
    //     */
    //    public function generate_device_verified_key()
    //    {
    //        return random_string('nozero', 6);;
    //    }
    //    private function _get_core_config_data($code)
    //    {
    //     $this->load->model('common/common_config_model');
    //     return $this->common_config_model->get_core_config_data($code);
    //    }
    //    /**
    //     * @param $tableKey : Primary key Name
    //     * @param $tableId : Primary Key Value
    //     * @param $fromTableName : From Table Name (Primary Table)
    //     * @param $toTableName : To Table Name (Log Table)
    //     * @param $ipAddress : IP Address
    //     * @param $action : 'create', 'update', 'delete'
    //     * @param array $option : Other Option value
    //     *
    //     * @return INT | FALSE
    //     */
    //    public function save_log($tableKey, $tableId, $fromTableName, $toTableName, $ipAddress, $action, $option = NULL, $whereOptions = NULL)
    //    {
    //        $this->db->select('*');
    //        $this->db->from($fromTableName);
    //        $this->db->where($tableKey, $tableId);
    //        if(is_array($whereOptions)){
    //            foreach($whereOptions as $where => $value){
    //                if (is_array($value) && !empty($value)) {
    //                    $this->db->where_in($where, $value);
    //                } else {
    //                    $this->db->where($where, $value);
    //                }
    //            }
    //        }
    //        $query = $this->db->get();
    //        if ($query->num_rows() > 0)
    //        {
    //            $fieldList = $this->db->list_fields($fromTableName);
    //            $rowList   = $query->result();
    //            $params    = NULL;
    //            $this->db->trans_start();
    //            foreach($rowList as $row)
    //            {
    //                foreach ($fieldList as $field)
    //                {
    //                    $params[$field] = $row->$field;
    //                }
    //                if ($params)
    //                {
    //                    $params['ip_address'] = $ipAddress;
    //                    $params['action']     = $action;
    //                    if ($option)
    //                    {
    //                        foreach ($option as $key => $value)
    //                        {
    //                            $params[$key] = $value;
    //                        }
    //                    }
    //                    $this->db->insert($toTableName, $params, FALSE);
    //                }
    //            }
    //            $this->db->trans_complete();
    //            if ($this->db->trans_status() == FALSE)
    //            {
    //                return FALSE;
    //            }
    //            else
    //            {
    //                try {
    //                    // write to audit log
    //                    openlog('audit_log', LOG_CONS | LOG_NDELAY | LOG_PID,LOG_LOCAL4);
    //                    $params = $this->_mask_sensitive_fields($params);
    //                    if(isset($params['created_by']) && !empty($params['created_by']) && (strtoupper($params['action']) == 'C'))
    //                    {
    //                        syslog(LOG_INFO,$params['created_by']." | Create | ".$fromTableName." | ".var_export($params, true));
    //                    } else if (isset($params['updated_by']) && !empty($params['updated_by'])) 
    //                    {
    //                        syslog(LOG_INFO,$params['updated_by']." | Update | ".$fromTableName." | ".var_export($params, true));
    //                    } else {
    //                        syslog(LOG_INFO,var_export($params, true));
    //                    }
    //                } catch (Exception $e) {
    //                    log_message('error','Save Log - Caught exception: '.$e->getMessage());
    //                    return FALSE; //TO MAKE SURE SO THAT THE MAIN PROCESS STILL CAN PROCEED
    //                }                
    //                closelog();
    //                return TRUE;
    //            }
    //        }
    //        else
    //        {
    //            $message = $this->common_config_model->get_message(self::CODE_SAVE_LOG_ERROR);
    //            try {
    //                // write to audit log
    //                openlog('audit_log', LOG_CONS | LOG_NDELAY | LOG_PID,LOG_LOCAL4);
    //                syslog(LOG_INFO,$message); 
    //                closelog();
    //            } catch (Exception $e) {
    //                log_message('error','Save Log - Caught exception: '.$e->getMessage());
    //                return FALSE; //RETURN value TO MAKE SURE SO THAT THE MAIN PROCESS STILL CAN PROCEED
    //            } 
    //            $this->response_message->set_message(self::CODE_SAVE_LOG_ERROR, $message);
    //            return FALSE;
    //        }
    //    }
    //    /**
    //     * @param $tableKey : Primary key Name
    //     * @param $tableId : Primary Key Value
    //     * @param $fromTableName : From Table Name (Primary Table)
    //     * @param $toTableName : To Table Name (Log Table)
    //     * @param $ipAddress : IP Address
    //     * @param $action : 'create', 'update', 'delete'
    //     * @param array $option : Other Option value
    //     *
    //     * @return INT | FALSE
    //     */
    //    public function save_log_without_transaction($tableKey, $tableId, $fromTableName, $toTableName, $ipAddress, $action, $insertOption = NULL, $whereOptions = NULL)
    //    {
    //        $this->db->select('*');
    //        $this->db->from($fromTableName);
    //        $this->db->where($tableKey, $tableId);
    //        if(is_array($whereOptions)){
    //            foreach($whereOptions as $where => $value){
    //                $this->db->where($where, $value);
    //            }
    //        }
    //        $query = $this->db->get();
    //        if ($query->num_rows() > 0)
    //        {
    //            $fieldList = $this->db->list_fields($fromTableName);
    //            $rowList   = $query->result();
    //            $params    = NULL;
    //            foreach ($rowList as $row)
    //            {
    //                foreach ($fieldList as $field)
    //                {
    //                    $params[$field] = $row->$field;
    //                }
    //                if ($params)
    //                {
    //                    $params['ip_address'] = $ipAddress;
    //                    $params['action']     = $action;
    //                    if ($insertOption)
    //                    {
    //                        foreach ($insertOption as $key => $value)
    //                        {
    //                            $params[$key] = $value;
    //                        }
    //                    }
    //                    $this->db->insert($toTableName, $params, FALSE);
    //                    if($this->db->insert_id() > 0){
    //                        return TRUE;
    //                    }
    //                }
    //            }
    //            try {
    //                // write to audit log
    //                openlog('audit_log', LOG_CONS | LOG_NDELAY | LOG_PID,LOG_LOCAL4);
    //                $params = $this->_mask_sensitive_fields($params);
    //                if(isset($params['created_by']) && !empty($params['created_by']) && (strtoupper($params['action']) == 'C'))
    //                {
    //                    syslog(LOG_INFO,$params['created_by']." | Create | ".$fromTableName." | ".var_export($params, true));
    //                } else if (isset($params['updated_by']) && !empty($params['updated_by'])) 
    //                {
    //                    syslog(LOG_INFO,$params['updated_by']." | Update | ".$fromTableName." | ".var_export($params, true));
    //                } else {
    //                    syslog(LOG_INFO,var_export($params, true));
    //                }
    //            } catch (Exception $e) {
    //                log_message('error','Save Log - Caught exception: '.$e->getMessage());
    //                return FALSE; //TO MAKE SURE SO THAT THE MAIN PROCESS STILL CAN PROCEED
    //            }
    //            closelog();
    //            return TRUE;
    //        }
    //        else
    //        {
    //            try {
    //                // write to audit log
    //                openlog('audit_log', LOG_CONS | LOG_NDELAY | LOG_PID,LOG_LOCAL4);
    //                syslog(LOG_INFO,"save_log_without_transaction for table ".$fromTableName." FAILED"); 
    //                closelog();
    //            } catch (Exception $e) {
    //                log_message('error','Save Log - Caught exception: '.$e->getMessage());
    //                return FALSE; //RETURN value TO MAKE SURE SO THAT THE MAIN PROCESS STILL CAN PROCEED
    //            } 
    //            return FALSE;
    //        }
    //    }
    //    #This is to mask the sensitive fields before saving to log - to conform to Security requirement
    //    #Return new $params with all sensitive fields masked
    //    protected function _mask_sensitive_fields($params){
    //        if(isset($params['email']) && !empty($params['email'])){
    //            $params['email'] = 'XXXXXXXX';
    //        }
    //        if(isset($params['contact_mobile']) && !empty($params['contact_mobile'])){
    //            $params['contact_mobile'] = 'XXXXXXXX';
    //        }
    //        if(isset($params['identity_number']) && !empty($params['identity_number'])){
    //            $params['identity_number'] = 'XXXXXXXX';
    //        }
    //        if(isset($params['dob']) && !empty($params['dob'])){
    //            $params['dob'] = 'XXXXXXXX';
    //        }
    //        if(isset($params['postal_code']) && !empty($params['postal_code'])){
    //            $params['postal_code'] = 'XXXXXXXX';
    //        }
    //        if(isset($params['unit_no']) && !empty($params['unit_no'])){
    //            $params['unit_no'] = 'XXXXXXXX';
    //        }
    //        return $params;
    //    }
    //    /**
    //     * Helper function to set response message and get error message from the
    //     * database
    //     */
    //    protected function _response_with_code($statusCode, $options = NULL)
    //    {
    //        $this->response_message->set_message($statusCode, $this->_get_message_with_code($statusCode), $options);
    //    }
    //    /**
    //     * Helper function to get message from code
    //     * @param $code , int
    //     * @return String
    //     */
    //    protected function _get_message_with_code($code)
    //    {
    //        $this->load->model('common/common_config_model');
    //        $message = $this->common_config_model->get_message($code);
    //        return $message;
    //    }
    //    /**
    //     * @return array with page and limit of items\
    //     */
    //    protected function _filter_with_pagination($target, $page, $limit)
    //    {
    //        if ($target == NULL || !is_array($target))
    //        {
    //            return array();
    //        }
    //        $results = array_chunk($target, $limit);
    //        if (isset($results[$page - 1]))
    //        { // -1 since array starts from 1
    //            return $results[$page - 1];
    //        }
    //        else
    //        {
    //            return array();
    //        }
    //    }
    //    /**
    //     * Check a condition
    //     * Returns TRUE if the condition pass
    //     * @param String $conditionCode
    //     * @param mixed $value
    //     * @return Boolean
    //     */
    //    protected function _is_valid_condition($conditionCode, $value)
    //    {
    //        //TODO cache
    //        $this->db->select('ssc_common.condition_group.condition_type_id,
    //                       ssc_common.condition_code.condition_code_rule,
    //                       ssc_common.cd_sys_code.code_name,
    //                       ssc_common.condition_code.condition_code_code');
    //        $this->db->join('ssc_common.condition_group', 'condition_group.condition_group_code = condition_code.condition_group_code');
    //        $this->db->join('ssc_common.cd_sys_code', 'cd_sys_code.id = condition_group.condition_type_id');
    //        $this->db->where('ssc_common.condition_code.condition_code_code', $conditionCode);
    //        $this->db->where('ssc_common.condition_group.deleted_at');
    //        $this->db->where('ssc_common.condition_code.deleted_at');
    //        $condition = $this->db->get('ssc_common.condition_code')->row();
    //        if (empty($condition) && isset($condition->condition_code_rule))
    //        {
    //            //Invalid condition, skip
    //            return TRUE;
    //        }
    //        $rule = json_decode($condition->condition_code_rule);
    //        if (!$rule)
    //        {
    //            // Invalid condition format
    //        }
    //        switch ($condition->code_name)
    //        {
    //            case self::CONDITION_RANGE:
    //                if (!isset($rule->min_value) || !isset($rule->max_value))
    //                {
    //                    // Invalid condition format
    //                    break;
    //                }
    //                if ($value < $rule->min_value || $value >= $rule->max_value)
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            case self::CONDITION_EQUALS:
    //                if (!isset($rule->value))
    //                {
    //                    // Invalid condition
    //                    break;
    //                }
    //                if ($value != $rule->value)
    //                {
    //                    return FALSE;
    //                }
    //            case self::CONDITION_DATE_RANGE:
    //                if (!isset($rule->min_date) || !isset($rule->max_date))
    //                {
    //                    // Invalid condition format
    //                    break;
    //                }
    //                if ($value < $rule->min_date || $value >= $rule->max_date)
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            case self::CONDITION_TIME_RANGE:
    //                if (!isset($rule->min_time) || !isset($rule->max_time))
    //                {
    //                    // Invalid condition format
    //                    break;
    //                }
    //                if ($value < $rule->min_time || $value >= $rule->max_time)
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            case self::CONDITION_GREATER_THAN:
    //                if (!isset($rule->value))
    //                {
    //                    // Invalid condition
    //                    break;
    //                }
    //                if ($value <= $rule->value)
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            case self::CONDITION_LESS_THAN:
    //                if (!isset($rule->value))
    //                {
    //                    // Invalid condition
    //                    break;
    //                }
    //                if ($value >= $rule->value)
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            case self::CONDITION_NOT_EQUAL:
    //                if (!isset($rule->value))
    //                {
    //                    // Invalid condition
    //                    break;
    //                }
    //                if ($value == $rule->value)
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            case self::CONDITION_IS_IN:
    //                if (!isset($rule->is_in))
    //                {
    //                    //Invalid day condition format
    //                    break;
    //                }
    //                $values = $rule->is_in;
    //                $values = explode(',', $values);
    //                if (!empty($values) && !in_array($value, $values))
    //                {
    //                    return FALSE;
    //                }
    //                break;
    //            default:
    //                //Unknown condition, do not filter
    //                break;
    //        }
    //        return TRUE;
    //    }
    //    /**
    //     * Get the function id for access control based on the code supplied
    //     * Returns FALSE if the function does not exist
    //     * @param $functionCode
    //     *
    //     * @return FALSE|int
    //     */
    //    protected function _get_function_id($functionCode)
    //    {
    //        $this->db->select('function_id');
    //        $this->db->where('code', $functionCode);
    //        $this->db->where('deleted_at');
    //        $function = $this->db->get('ssc_member.admin_function_master')->row();
    //        if (!$function || !isset($function->function_id))
    //        {
    //            return FALSE;
    //        }
    //        return $function->function_id;
    //    }
    //    /**
    //     * @param $functionCode
    //     * @param $adminId
    //     *
    //     * @return bool
    //     */
    //    protected function _is_accessable($functionCode, $adminId)
    //    {
    //        $this->load->model('accesscontrol/accesscontrol_model');
    //        $functionId = $this->_get_function_id($functionCode);
    //        if (!$functionId)
    //        {
    //            return FALSE;
    //        }
    //        if (!$this->accesscontrol_model->accessable($functionId, $adminId))
    //        {
    //            return FALSE;
    //        }
    //        $result = $this->response_message->get_message();
    //        $result = to_object($result);
    //        return $result;
    //    }
    //    /**
    //     * @param array $result
    //     * @param array $fields
    //     * @param array $except
    //     *
    //     * @return array
    //     */
    //    protected function _filter_attributes(array $result, array $fields, array $except = array())
    //    {
    //        $this->load->model('accesscontrol/accesscontrol_model');
    //        //turn except fields to map
    //        $exceptFields = array();
    //        foreach ($except as $ex)
    //        {
    //            $exceptFields[$ex] = TRUE;
    //        }
    //        $return       = array();
    //        $valueFilters = array();
    //        //Determine the key to be maintained
    //        foreach ($fields as $f)
    //        {
    //            //Do filters first since it will affect the size of the array
    //            if (isset($f->field_type) && $f->field_type == Accesscontrol_model::FIELD_TYPE_FILTER && isset($f->field_attributes) && !empty($f->field_attributes)
    //            )
    //            {
    //                if (isset($f->code))
    //                {
    //                    $key                = $f->code;
    //                    $exceptFields[$key] = TRUE;
    //                }
    //                $valueFilters[] = $f;
    //            }
    //            else if (isset($f->field_type) && $f->field_type == Accesscontrol_model::FIELD_TYPE_FIELD)
    //            {
    //                //Add this to the list of field filter
    //                if (isset($f->code))
    //                {
    //                    $key                = $f->code;
    //                    $exceptFields[$key] = TRUE;
    //                }
    //            }
    //        }
    //        if (!empty($valueFilters))
    //        {
    //            // Need to filter the results with the value
    //            // Loop through all the main results
    //            $count = sizeof($result);
    //            for ($i = 0; $i < $count; $i++)
    //            {
    //                $row = $result[$i];
    //                foreach ($valueFilters as $f)
    //                {
    //                    if (isset($f->field_type) && $f->field_type == Accesscontrol_model::FIELD_TYPE_FILTER && isset($f->field_attributes) && !empty($f->field_attributes)
    //                    )
    //                    {
    //                        if (isset($f->code))
    //                        {
    //                            $idKeyToCompare = $f->code;
    //                            //Loop all the attributes
    //                            foreach ($f->field_attributes as $attr)
    //                            {
    //                                if (isset($attr->code_id) && isset($attr->code_name))
    //                                {
    //                                    //If there's a matching allowed id, add this row to return statement
    //                                    if (isset($row->$idKeyToCompare) && ($row->$idKeyToCompare == $attr->code_id || $row->$idKeyToCompare == $attr->code_name))
    //                                    {
    //                                        //Filter the keys
    //                                        $row      = $this->_filter_keys($row, $exceptFields);
    //                                        $return[] = $row;
    //                                        break;
    //                                    }
    //                                }
    //                            }
    //                        }
    //                    }
    //                }
    //            }
    //        }
    //        else
    //        {
    //            // Do not need to filter by values
    //            foreach ($result as $row)
    //            {
    //                //Filter the keys
    //                $row      = $this->_filter_keys($row, $exceptFields);
    //                $return[] = $row;
    //            }
    //        }
    //        return $return;
    //    }
    //    /**
    //     * Filter the key for to be removed from this object
    //     * @param $row
    //     * @param $fields
    //     *
    //     * @return mixed
    //     */
    //    private function _filter_keys($row, $fields)
    //    {
    //        foreach ($row as $k => $value)
    //        {
    //            if (!isset($fields[$k]))
    //            {
    //                unset($row->$k);
    //            }
    //        }
    //        return $row;
    //    }
    //    /**
    //     * @param       $accessableResults
    //     * @param array $result
    //     * @param       $zoneKey
    //     * @param       $srcKey
    //     * @param       $venueKey
    //     *
    //     * @return array
    //     */
    //    protected function _filter_access_level($accessableResults, array $result, $zoneKey = 'venue_zone_id', $srcKey = 'venue_src_id', $venueKey = 'venue_id')
    //    {
    //        if (isset($accessableResults->access_level) && isset($accessableResults->access_id))
    //        {
    //            $accessLevel = $accessableResults->access_level;
    //            $accessId    = $accessableResults->access_id;
    //            if (empty($accessId) || !is_array($accessId))
    //            {
    //                return $result;
    //            }
    //            //Change access ids to hashmap for better performance
    //            $filterIds = array();
    //            foreach ($accessId as $ac)
    //            {
    //                $filterIds[$ac] = TRUE;
    //            }
    //            switch ($accessLevel)
    //            {
    //                case Accesscontrol_model::ALL_ACCESS_LEVEL:
    //                    //Can access all level, do not need to check
    //                    return $result;
    //                case Accesscontrol_model::ZONE_ACCESS_LEVEL:
    //                    //Filter
    //                    return $this->_filter_access_key($result, $filterIds, $zoneKey);
    //                case Accesscontrol_model::SRC_ACCESS_LEVEL:
    //                    return $this->_filter_access_key($result, $filterIds, $srcKey);
    //                case Accesscontrol_model::VENUE_ACCESS_LEVEL:
    //                    return $this->_filter_access_key($result, $filterIds, $venueKey);
    //                default:
    //                    return $result;
    //            }
    //        }
    //        else
    //        {
    //            return $result;
    //        }
    //    }
    //    /**
    //     * @param array $result
    //     * @param array $filterIds
    //     * @param       $compareKey
    //     *
    //     * @return array
    //     */
    //    private function _filter_access_key(array $result, array $filterIds, $compareKey)
    //    {
    //        foreach ($result as $k => $v)
    //        {
    //            if (isset($v->$compareKey))
    //            {
    //                $value = $v->$compareKey;
    //                //Compare this to the filter ids
    //                if (!isset($filterIds[$value]) || $filterIds[$value] != TRUE)
    //                {
    //                    //Does not have any matching values, remove this object
    //                    unset($result[$k]);
    //                }
    //            }
    //        }
    //        $r = array_values($result);
    //        return $r;
    //    }
    //    /**
    //     * @param $accessableResults
    //     */
    //    protected function _get_allowed_venue($accessableResults)
    //    {
    //        $this->load->model('facility/facility_model');
    //        $allowedVenueIndex = array();
    //        if (isset($accessableResults->access_level) && isset($accessableResults->access_id))
    //        {
    //            $accessLevel = $accessableResults->access_level;
    //            $accessId    = $accessableResults->access_id;
    //            if (empty($accessId) || !is_array($accessId))
    //            {
    //                //No access levels, returns empty index
    //                return $allowedVenueIndex;
    //            }
    //            switch ($accessLevel)
    //            {
    //                case Accesscontrol_model::ALL_ACCESS_LEVEL:
    //                    //Can access all level, do not need to check
    //                    return TRUE;
    //                case Accesscontrol_model::ZONE_ACCESS_LEVEL:
    //                    //Get all venues under this zone id
    //                    $venues = $this->facility_model->get_venue_by_zone($accessId);
    //                    if (!$venues || !is_array($venues))
    //                    {
    //                        //No venues under this zone, returns empty index
    //                        return $allowedVenueIndex;
    //                    }
    //                    foreach ($venues as $v)
    //                    {
    //                        $allowedVenueIndex[$v->venue_id] = TRUE;
    //                    }
    //                    return $allowedVenueIndex;
    //                case Accesscontrol_model::SRC_ACCESS_LEVEL:
    //                    //Get all venues under this src id
    //                    $venues = $this->facility_model->get_venue_by_src($accessId);
    //                    if (!$venues || !is_array($venues))
    //                    {
    //                        //No venues under this src, returns empty index
    //                        return $allowedVenueIndex;
    //                    }
    //                    foreach ($venues as $v)
    //                    {
    //                        $allowedVenueIndex[$v->venue_id] = TRUE;
    //                    }
    //                    return $allowedVenueIndex;
    //                case Accesscontrol_model::VENUE_ACCESS_LEVEL:
    //                    //Use the access id as the venue id, since it's a venue level id
    //                    foreach ($accessId as $a)
    //                    {
    //                        $allowedVenueIndex[$a] = TRUE;
    //                    }
    //                    return $allowedVenueIndex;
    //                default:
    //                    return $allowedVenueIndex;
    //            }
    //        }
    //        else
    //        {
    //            return $allowedVenueIndex;
    //        }
    //    }
    //    protected function _get_allowed_venue_info($accessableResults, $is_booking_office = NULL)
    //    {
    //        $this->load->model('facility/facility_model');
    //        $allowedVenueIndex = $this->_get_allowed_venue($accessableResults);
    //        if( count($allowedVenueIndex) > 0 OR $allowedVenueIndex === TRUE )
    //        {
    //            $venueIndex = array();
    //            if( is_array($allowedVenueIndex) )
    //            {
    //                $venueIndex = $allowedVenueIndex;
    //            }
    //            if( $venueInfoList = $this->facility_model->get_venue_info_by_index(array_keys($venueIndex), $is_booking_office) )
    //            {
    //                return $venueInfoList;
    //            }
    //        }
    //        return FALSE;
    //    }
    //    /*
    //    public function get_increment_id($attribute)
    //    {
    //        $this->db->select('*');
    //        $this->db->from('ssc_common.increment_table');
    //        $this->db->where('attribute', $attribute);
    //        $this->db->where('deleted_at', NULL);
    //        $query = $this->db->get();
    //        if ($query->num_rows() > 0)
    //        {
    //            $result = $query->row();
    //            $toDate     = date('Y-m-d H:i:s');
    //            $todayDay   = date("d", strtotime($toDate));
    //            $todayMonth = date("m", strtotime($toDate));
    //            $todayYear  = date("Y", strtotime($toDate));
    //            $lastIncDate  = $result->last_increment_date;
    //            $lastIncDay   = date("d", strtotime($lastIncDate));
    //            $lastIncMonth = date("m", strtotime($lastIncDate));
    //            $lastIncYear  = date("Y", strtotime($lastIncDate));
    //            if ($todayYear > $lastIncYear)
    //            {
    //                $incNumber = str_pad(1, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
    //                $this->_reset_increment_id($attribute);
    //            }
    //            else
    //            {
    //                if ($todayMonth > $lastIncMonth)
    //                {
    //                    $incNumber = str_pad(1, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
    //                    $this->_reset_increment_id($attribute);
    //                }
    //                else
    //                {
    //                    if ($todayDay > $lastIncDay)
    //                    {
    //                        $incNumber = str_pad(1, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
    //                        $this->_reset_increment_id($attribute);
    //                    }
    //                    else
    //                    {
    //                        $incNumber = str_pad($result->value, self::NO_OF_DIGIT, '0', STR_PAD_LEFT);
    //                        $this->set_increment_id($attribute, 1);
    //                    }
    //                }
    //            }
    //            return date("Y") . date("m") . date("d") . $result->prefix . $incNumber;
    //        }
    //        else
    //        {
    //            return FALSE;
    //        }
    //    }
    //    private function _reset_increment_id($attribute)
    //    {
    //        $date = date('Y-m-d');
    //        $this->db->set('value', 2);
    //        $this->db->set('last_increment_date', $date);
    //        $this->db->set('updated_at', date('Y-m-d H:i:s'));
    //        $this->db->where('attribute', $attribute);
    //        $this->db->where('deleted_at', NULL);
    //        if ($this->db->update('ssc_common.increment_table'))
    //        {
    //            return $this->db->affected_rows();
    //        }
    //        else
    //        {
    //            return FALSE;
    //        }
    //    }
    //    public function set_increment_id($attribute, $value)
    //    {
    //        $date = date('Y-m-d');
    //        $this->db->set('value', "value + $value", FALSE);
    //        $this->db->set('last_increment_date', $date);
    //        $this->db->set('updated_at', date('Y-m-d H:i:s'));
    //        $this->db->where('attribute', $attribute);
    //        $this->db->where('deleted_at', NULL);
    //        if ($this->db->update('ssc_common.increment_table'))
    //        {
    //            return $this->db->affected_rows();
    //        }
    //        else
    //        {
    //            return FALSE;
    //        }
    //    }
    //    */
    //   /**
    //     * Get the folders used for the images link
    //     */
    //    public function get_folders($folderName){
    //     $s3BaseUrl = $this->get_s3_base_url();
    //     $bucketName = $this->get_bucket_name();
    //        $folders = array(
    //            SMALL    => $s3BaseUrl .'/'. $bucketName . '/' . $folderName . '/' . SMALL . '/',
    //            MEDIUM   => $s3BaseUrl .'/'. $bucketName . '/' . $folderName . '/' . MEDIUM . '/',
    //            BIG      => $s3BaseUrl .'/'. $bucketName . '/' . $folderName . '/' . BIG . '/',
    //            ORIGINAL => $s3BaseUrl .'/'. $bucketName . '/' . $folderName . '/' . ORIGINAL . '/'
    //        );
    //        return $folders;
    //    }
    // public function get_single_folder($folderName) {
    // 	$s3BaseUrl = $this->get_s3_base_url();
    // 	$bucketName = $this->get_bucket_name();
    // 	return $s3BaseUrl .'/'. $bucketName . '/' . $folderName . '/';
    // }
    //    /**
    //     * @param $bucketName
    //     */
    // public function get_bucket_name() {
    // 	$bucketName = $this->_get_core_config_data(self::S3_BUCKET);
    // 	return $bucketName;
    // }
    // /**
    //  * @param $bucketName
    //  */
    // public function get_s3_base_url() {
    // 	$s3BaseUrl = $this->_get_core_config_data(self::S3_BASE_URL);
    // 	if(!$s3BaseUrl){
    // 		//Use the default s3 base url
    // 		$s3BaseUrl = S3_BASE_URL;
    // 	}
    // 	return $s3BaseUrl;
    // }
    // /**
    //  * @param $adminId
    //  *
    //  * @return bool
    //  */
    // protected function get_admin_profile($adminId){
    // 	$this->db->select('name, email');
    // 	$this->db->where('id', $adminId);
    // 	$result = $this->db->get('ssc_member.user_profile')->row();
    // 	if (empty($result)) {
    // 		return FALSE;
    // 	} else {
    // 		return $result;
    // 	}
    // }
    //    public function generate_html_pdf_receive($params, $pdfName, $filepath, $viewFileName, $mode = 'P')
    //    {
    //        ini_set('memory_limit', '-1');      
    //        ini_set('max_input_time', '-1');      
    //        ini_set('max_execution_time', '-1'); 
    //        $this->output->enable_profiler(false);
    //        // $this->load->library('s3_image');
    //        $this->load->library('parser');
    //        require_once(APPPATH . 'third_party/html2pdf/html2pdf.class.php');
    //        // page info here, db calls, etc.
    //        $html = $this->load->view($viewFileName, $params, true);
    //        try
    //        {   
    //            ob_start();
    //            $html2pdf = new HTML2PDF($mode, 'A4', 'en', TRUE, 'UTF-8', array(10,10,10,10));
    //            $html2pdf->pdf->SetDisplayMode('fullpage');
    //            $html2pdf->WriteHTML($html);
    //            // $html2pdf->Output('ActiveSG_disbursement_report.pdf', 'F');
    //            $html2pdf->Output($filepath, 'F');
    //        }
    //        catch(HTML2PDF_exception $e)
    //        {   
    //            echo $e;
    //            exit;
    //        }
    //    }
}

/* End of file Base_Common_Model.php */
/* Location: ./application/core/Base_Common_Model.php */