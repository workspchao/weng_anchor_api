<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Porduct_category_model
 *
 * @author lichao
 */
class Product_type_model extends Base_Common_Model {

    const CODE_PRODUCT_TYPE_LIST_SUCCESSFULLY = 1111;
    const CODE_PRODUCT_TYPE_LIST_NOT_FOUND = 1112;
    const CODE_PRODUCT_TYPE_ADD_INVALID_PARAMS = 1113;
    const CODE_PRODUCT_TYPE_ADD_SUCCESSFULLY = 1114;
    const CODE_PRODUCT_TYPE_ADD_FAILED = 1115;
    const CODE_PRODUCT_TYPE_DETAIL_SUCCESSFULLY = 1116;
    const CODE_PRODUCT_TYPE_DETAIL_FAILED = 1117;
    const CODE_PRODUCT_TYPE_UPDATE_SUCCESSFULLY = 1118;
    const CODE_PRODUCT_TYPE_UPDATE_FAILED = 1119;
    const CODE_PRODUCT_TYPE_DELETE_SUCCESSFULLY = 1120;
    const CODE_PRODUCT_TYPE_DELETE_FAILED = 1121;

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->db = $this->load->database('default', TRUE);

        $this->load->helper('string');
        $this->load->model('common_flag');
    }

    public function getList($lang, $page, $limit, $parent_id) {
        $offset = ($page - 1) * $limit;

        $this->db->select("product_type.id,
                            product_type_lang.`lang`,
                            product_type_lang.`name`,
                            product_type_lang.`desc`,
                            product_type.sort,
                            product_type.icon_url,
                            product_type.created_at,
                            product_type.updated_at,
                            product_type.created_by,
                            product_type.updated_by");
        $this->db->from('wa.product_type');
        $this->db->join('wa.product_type_lang', 'product_type_lang.id = product_type.id');
        $this->db->where('product_type_lang.lang', $lang);
        $this->db->where('product_type.deleted_at IS NULL');
        $this->db->order_by('product_type.sort', ASC);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $results = $query->result();
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_LIST_SUCCESSFULLY, array(RESULTS => $results));
            return true;
        }

        $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_LIST_NOT_FOUND);
        return false;
    }

    public function create($lang, $name, $desc, $icon_url, $sort, $createdBy, $langList) {

        $data = array();
        $data['name'] = $name;
        $data['desc'] = $desc;
        $data['icon_url'] = $icon_url;
        $data['sort'] = $sort;
        $data['created_at'] = $this->get_now();
        $data['created_by'] = $createdBy;

        $id = $this->common_add('wa.product_type', $data);

        foreach ($langList as $key => $value) {
            $data_lang = array();
            $data_lang['id'] = $id;
            $data_lang['lang'] = $value->lang;
            $data_lang['name'] = $value->name;
            $data_lang['desc'] = $value->desc;
            $data_lang['created_at'] = $this->get_now();
            $data_lang['created_by'] = $createdBy;
            $this->common_add('wa.product_type_lang', $data_lang);
        }

        if ($id) {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_ADD_SUCCESSFULLY);
            return true;
        } else {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_ADD_FAILED);
            return false;
        }
    }

    public function getDetail($lang, $id) {
        $this->db->select("product_type.id,
                            product_type.`name`,
                            product_type.`desc`,
                            product_type.icon_url,
                            product_type.sort,
                            product_type.created_at,
                            product_type.updated_at,
                            product_type.created_by,
                            product_type.updated_by");
        $this->db->from('wa.product_type');
        $this->db->where('product_type.id', $id);
        $this->db->where('product_type.deleted_at IS NULL');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results['type'] = $query->row();

            $this->db->select('product_type_lang.`lang`,
                            product_type_lang.`name`,
                            product_type_lang.`desc`');
            $this->db->from('wa.product_type_lang');
            $this->db->where('product_type_lang.id', $id);

            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $results['type_lang'] = $query->result();
            }

            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_DETAIL_SUCCESSFULLY, array(RESULTS => $results));
            return true;
        }

        $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_DETAIL_FAILED);
        return false;
    }

    public function update($lang, $id, $name, $desc, $icon_url, $sort, $updatedBy, $langList) {
        $data_category = array();
//        $data_category['id'] = $id;
        $data_category['name'] = $name;
        $data_category['desc'] = $desc;
        
        if(isset($icon_url) && $icon_url != null){
            $data_category['icon_url'] = $icon_url;
        }
        
        $data_category['sort'] = $sort;
        $data_category['updated_by'] = $updatedBy;

        $affected_rows = $this->common_edit('wa.product_type', 'id', $id, $data_category);

        foreach ($langList as $key => $value) {

            $data_category_lang = array();
            $data_category_lang['id'] = $id;
            $data_category_lang['lang'] = $value->lang;
            $data_category_lang['name'] = $value->name;
            $data_category_lang['desc'] = $value->desc;
            $data_category_lang['updated_by'] = $updatedBy;

            $data_category_lang_key = array();
            $data_category_lang_key['id'] = $id;
            $data_category_lang_key['lang'] = $value->lang;

            $exists = $this->common_exists_with_multiKey('wa.product_type_lang', $data_category_lang_key);
            if (!$exists) {
                $this->common_add('wa.product_type_lang', $data_category_lang);
            } else {
                $this->common_edit_with_multiKey('wa.product_type_lang', $data_category_lang_key, $data_category_lang);
            }
        }

        if ($affected_rows) {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_UPDATE_SUCCESSFULLY);
            return true;
        } else {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_UPDATE_FAILED);
            return false;
        }
    }

    public function delete($id) {
        if($this->common_delete_logic('wa.product_type', 'id', $id))
        {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_DELETE_SUCCESSFULLY);
            return true;
        }
        else
        {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_TYPE_DELETE_FAILED);
            return false;
        }
    }

}
