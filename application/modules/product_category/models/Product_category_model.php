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
class Product_category_model extends Base_Common_Model {

    const CODE_PRODUCT_CATEGORY_LIST_SUCCESSFULLY = 1100;
    const CODE_PRODUCT_CATEGORY_LIST_NOT_FOUND = 1101;
    const CODE_PRODUCT_CATEGORY_ADD_INVALID_PARAMS = 1102;
    const CODE_PRODUCT_CATEGORY_ADD_SUCCESSFULLY = 1103;
    const CODE_PRODUCT_CATEGORY_ADD_FAILED = 1104;
    const CODE_PRODUCT_CATEGORY_DETAIL_SUCCESSFULLY = 1105;
    const CODE_PRODUCT_CATEGORY_DETAIL_FAILED = 1106;
    const CODE_PRODUCT_CATEGORY_UPDATE_SUCCESSFULLY = 1107;
    const CODE_PRODUCT_CATEGORY_UPDATE_FAILED = 1108;
    const CODE_PRODUCT_CATEGORY_DELETE_SUCCESSFULLY = 1109;
    const CODE_PRODUCT_CATEGORY_DELETE_FAILED = 1110;

    function __construct() {
        // Call the Model constructor
        parent::__construct();

        $this->db = $this->load->database('default', TRUE);

        $this->load->helper('string');
        $this->load->model('common_flag');
    }

    public function categoryList($lang, $page, $limit, $parent_id) {
        $offset = ($page - 1) * $limit;

        $this->db->select("product_category.id,
                            product_category.is_parent,
                            product_category.parent_id,
                            product_category.icon_url,
                            product_category.sort,
                            product_category.created_at,
                            product_category.updated_at,
                            product_category.created_by,
                            product_category.updated_by,
                            product_category_lang.`lang`,
                            product_category_lang.`name`,
                            product_category_lang.`desc`");
        $this->db->from('wa.product_category');
        $this->db->join('wa.product_category_lang', 'product_category_lang.id = product_category.id');
        $this->db->where('product_category_lang.lang', $lang);
        $this->db->where('product_category.deleted_at IS NULL');
        
        if ($parent_id === null || $parent_id === '' || $parent_id === 0) {
            $this->db->where('product_category.parent_id', 0);
        }
        else{
            $this->db->where('product_category.parent_id', $parent_id);
        }
        
        $this->db->order_by('product_category.sort', ASC);
        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $results = $query->result();
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_LIST_SUCCESSFULLY, array(RESULTS => $results));
            return true;
        }

        $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_LIST_NOT_FOUND);
        return false;
    }

    public function categoryCreate($lang, $name, $desc, $parentId, $sort, $icon_url, $createdBy, $langList) {

        $data_category = array();
        $data_category['name'] = $name;
        $data_category['desc'] = $desc;
        $data_category['is_parent'] = 0;
        $data_category['parent_id'] = $parentId;
        $data_category['sort'] = $sort;
        $data_category['icon_url'] = $icon_url;
        $data_category['created_at'] = $this->get_now();
        $data_category['created_by'] = $createdBy;

        $id = $this->common_add('wa.product_category', $data_category);

        if ($parentId) {
            $data_category = array();
            $data_category['is_parent'] = Common_flag::FLAG_YES_TINYINT;

            $this->common_edit('wa.product_category', 'id', $parentId, $data_category);
        }

        foreach ($langList as $key => $value) {
            $data_category_lang = array();
            $data_category_lang['id'] = $id;
            $data_category_lang['lang'] = $value->lang;
            $data_category_lang['name'] = $value->name;
            $data_category_lang['desc'] = $value->desc;
            $data_category_lang['created_at'] = $this->get_now();
            $data_category_lang['created_by'] = $createdBy;
            $this->common_add('wa.product_category_lang', $data_category_lang);
        }

        if ($id) {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_ADD_SUCCESSFULLY);
            return true;
        } else {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_ADD_FAILED);
            return false;
        }
    }

    public function categoryDetail($lang, $id) {
        $this->db->select("product_category.id,
                            product_category.`name`,
                            product_category.`desc`,
                            product_category.is_parent,
                            product_category.parent_id,
                            product_category.icon_url,
                            product_category.sort,
                            product_category.created_at,
                            product_category.updated_at,
                            product_category.created_by,
                            product_category.updated_by");
        $this->db->from('wa.product_category');
        $this->db->where('product_category.id', $id);
        $this->db->where('product_category.deleted_at IS NULL');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results['category'] = $query->row();

            $this->db->select('product_category_lang.`lang`,
                            product_category_lang.`name`,
                            product_category_lang.`desc`');
            $this->db->from('wa.product_category_lang');
            $this->db->where('product_category_lang.id', $id);

            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $results['categroy_lang'] = $query->result();
            }

            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_DETAIL_SUCCESSFULLY, array(RESULTS => $results));
            return true;
        }

        $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_DETAIL_FAILED);
        return false;
    }

    public function categoryUpdate($lang, $id, $name, $desc, $parentId, $sort, $icon_url, $updatedBy, $langList) {
        
        $data_category = array();
        $data_category['name'] = $name;
        $data_category['desc'] = $desc;
        $data_category['parent_id'] = $parentId;
        $data_category['sort'] = $sort;
        
        if(isset($icon_url) && $icon_url != null){
            $data_category['icon_url'] = $icon_url;
        }
        $data_category['updated_by'] = $updatedBy;

        $affected_rows = $this->common_edit('wa.product_category', 'id', $id, $data_category);

        if ($parentId) {
            $data_category = array();
            $data_category['is_parent'] = Common_flag::FLAG_YES_TINYINT;

            $this->common_edit('wa.product_category', 'id', $parentId, $data_category);
        }

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

            $exists = $this->common_exists_with_multiKey('wa.product_category_lang', $data_category_lang_key);
            if (!$exists) {
                $this->common_add('wa.product_category_lang', $data_category_lang);
            } else {
                $this->common_edit_with_multiKey('wa.product_category_lang', $data_category_lang_key, $data_category_lang);
            }
        }

        if ($affected_rows) {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_UPDATE_SUCCESSFULLY);
            return true;
        } else {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_UPDATE_FAILED);
            return false;
        }
    }

    public function categoryDelete($id) {
        if($this->common_delete_logic('wa.product_category', 'id', $id))
        {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_DELETE_SUCCESSFULLY);
            return true;
        }
        else
        {
            $this->response_message->set_message_with_code(self::CODE_PRODUCT_CATEGORY_DELETE_FAILED);
            return false;
        }
    }

}
