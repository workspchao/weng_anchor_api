<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PasswordPolicy
{
    protected   $ci;
    protected   $rules = array();
    protected   $_error_messages = array();

    protected   $options = array();

    public function __construct($config = array())
    {
        $this->ci =& get_instance();

        // initiate the rules
        $this->rules = $config;

        $this->options['passwordHistories'] = array();
        $this->options['name']  = '';
        $this->options['email'] = '';

        // setup the message, so that the message is taking from outside
        $this->_setup_error_message();
    }

    /**
     * TO validate the password with the password rules
     * @return [type] [description]
     */
    public function validate($password)
    {
        $errorFlag = false;
        // $password = trim($password);

        if (empty($password) || !is_string($password)) return false;

        // pre first rule, space
        if ( preg_match('/\s/', $password) ) {
            // set message
            $this->_error_messages[] = $this->_get_error_message('space');
            $errorFlag = true;
        }

        // first rule, length
        if ( ! (strlen($password) >= 8 && strlen($password) <= 32) ) {
            // set message
            $this->_error_messages[] = $this->_get_error_message('length');
            $errorFlag = true;
        }

        // second rule, lowercase
        if ( ! preg_match('/[a-z]/', $password)) {
            $this->_error_messages[] = $this->_get_error_message('lowercase');
            $errorFlag = true;
        }

        // contain uppercase
        if ( ! (preg_match('/[A-Z]/', $password)) ) {
            $this->_error_messages[] = $this->_get_error_message('uppercase');
            $errorFlag = true;
        }

        // contain numeric
        if ( ! (preg_match('/[0-9]/', $password)) ) {
            $this->_error_messages[] = $this->_get_error_message('numeric');
            $errorFlag = true;
        }

        // contain special
        if ( ! (preg_match('/[\!@#\$%\^\&\*_\+\=\-\.\?]/', $password)) ) {
            $this->_error_messages[] = $this->_get_error_message('special');
            $errorFlag = true;
        }

        // contain consecutive
        if ( (preg_match('/(.)\1{2,}/', $password)) ) {
            $this->_error_messages[] = $this->_get_error_message('consecutive');
            $errorFlag = true;
        }

        // contain name email
        $words  = preg_split('/[\s\,\'\!@#\$%\^\&\*_\+\=\-\.\?]+/', $this->options['name']);
        $words1 = preg_split('/[\s\,\'\!@#\$%\^\&\*_\+\=\-\.\?]+/', $this->options['email']);
        $words = array_merge($words, $words1);

        foreach ($words as $word) {
            if (stripos(strtolower($password), strtolower($word)) !== false) {
                 // password contains part of name or email, return error
                $this->_error_messages[] = $this->_get_error_message('contain_name_email');
                $errorFlag = true;
                break;
            }
        }

        // old password
        foreach ($this->options['passwordHistories'] as $passwordHistory) {
            $oldPassword    = $passwordHistory->password;
            $salt           = $passwordHistory->salt;
            $hashedPassword = sha1($password . '.' . $salt); // FIXME: logic is defined somewhere else too

            if (strcasecmp($oldPassword, $hashedPassword) === 0) { // password is the same as one of the previous password
                $this->_error_messages[] = $this->_get_error_message('contain_old_password');
                $errorFlag = true;
                break;
            }
        }


        return !$errorFlag;
    }

    /**
     * unused
     * @return [type] [description]
     */
    protected function _execute()
    {
        foreach ($this->rules as $rule) {
            if ( !method_exists($this, $rule)) {
                // If our own wrapper function doesn't exist we see if a native PHP function does.
                // Users can use any native PHP function call that has one param.
                if (function_exists($rule))
                {
                    $result = $rule($postdata);
                }
                else
                {
                    log_message('debug', "Unable to find validation rule: ".$rule);
                }

                continue;
            }

            $result = $this->$rule($postdata, $param);

            if ($result === FALSE)
            {
                if ( ! isset($this->_error_messages[$rule]))
                {
                    if (FALSE === ($line = $this->CI->lang->line($rule)))
                    {
                        $line = 'Unable to access an error message corresponding to your field name.';
                    }
                }
                else
                {
                    $line = $this->_error_messages[$rule];
                }

                // Is the parameter we are inserting into the error message the name
                // of another field?  If so we need to grab its "field label"
                // if (isset($this->_field_data[$param]) AND isset($this->_field_data[$param]['label']))
                // {
                //     $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                // }

                // Build the error message
                $message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if ( ! isset($this->_error_array[$row['field']]))
                {
                    $this->_error_array[$row['field']] = $message;
                }

                return;
            }
        }
    }

    // setup default message and rules
    protected function _setup_error_message()
    {
        $this->rules['space']                = array('code' => '1551',
                                                     'message' => 'Password must not contains space.');
        $this->rules['length']               = array('code' => '1501',
                                                     'message' => 'Password length must be greater than 8 and less than 32 characters.');
        $this->rules['lowercase']            = array('code' => '1502',
                                                     'message' => 'Password must contain at least 1 lowercase characters.');
        $this->rules['uppercase']            = array('code' => '1503',
                                                     'message' => 'Password must contain at least 1 uppercase characters.');
        $this->rules['numeric']              = array('code' => '1504',
                                                     'message' => 'Password must contain at least 1 number.');
        $this->rules['special']              = array('code' => '1505',
                                                     'message' => 'Password must contain at least 1 special characters (! @ # $ % ^ & * = - _ . ?).');
        $this->rules['consecutive']          = array('code' => '1531',
                                                     'message' => 'Password must not contain more than two consecutive identical characters.');
        $this->rules['contain_name_email']   = array('code' => '1506',
                                                     'message' => 'Password contains part of name or email.');
        $this->rules['contain_old_password'] = array('code' => '1507',
                                                     'message' => 'Your new password cannot be the same as your previous 5 passwords.');
    }

    protected function _get_error_message($key = '')
    {
        if (empty($key)) {
            // return default message
            return 'Default error message on password policy.';
        }

        if (!isset($this->rules[$key]) || !isset($this->rules[$key]['message']) || empty($this->rules[$key]['message'])) {
            // return default message
            return 'Default error message on password policy.';
        }

        return $this->rules[$key]['message'];
    }

    /**
     * [get_error_message description]
     * @return [type] [description]
     */
    public function get_error_message()
    {
        // No errrors, validation passes!
        if (count($this->_error_messages) === 0)
        {
            return '';
        }

        $prefix = '';
        $suffix = '';

        // Generate the error string
        $str = '';

        foreach ($this->_error_messages as $val)
        {
            if ($val != '')
            {
                $str .= $prefix.$val.$suffix."\n";
            }
        }

        return $str;
    }

    /**
     * [set_password_history description]
     * @param array $passwordHistories [description]
     */
    public function set_password_history(array $passwordHistories = array())
    {
        if (is_array($passwordHistories)) {
            $this->options['passwordHistories'] = $passwordHistories;
        } else {
            $this->options['passwordHistories'] = array();
        }
    }

    /**
     * [set_name_email description]
     * @param string $name  [description]
     * @param string $email [description]
     */
    public function set_name_email($name = '', $email = '')
    {
        $this->options['name']   = $name;
        $this->options['email']  = $email;
    }

    /**
     * [get_password_expiry description]
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public function get_password_expiry($date = null)
    {
        if (!is_numeric($date)) {
            $date = 90;
        }

        return date('Y-m-d 23:59:59', strtotime('+'. $date .' days'));
    }
}

/* End of file PasswordPolicy.php */
/* Location: ./application/libraries/PasswordPolicy.php */
