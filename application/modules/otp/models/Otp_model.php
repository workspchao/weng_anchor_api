<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of otp_model
 *
 * @author lichao
 */
class Otp_model extends Base_Common_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    
    public function get_otp_code()
    {
        $now  = date('Y-m-d H:i:s');
        do
        {
            $code = $this->generate_random_number(OTP_NUMBER_LENGTH);
            $this->db->select('id');
            $this->db->from('wa.otp_reference');

            $this->db->where('code', $code);
            $this->db->where('expired_at >=', $now);
            $this->db->limit(1);

            $query = $this->db->get();
            if($query->num_rows() <= 0)
            {
                return $code;
            }
        }
        while(FALSE);
    }

}
