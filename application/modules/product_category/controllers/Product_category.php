<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Produtct_category
 *
 * @author lichao
 */
class Product_category extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Product_category_model');
    }
    
    public function categoryList()
    {
        $lang = $this->get_language();
        $page = $this->get_page();
        $limit = $this->get_limit();
        $parent_id = $this->input->post('parent_id') ? $this->input->post('parent_id') : NULL;
        
        if($parent_id == NULL){
            $parent_id = 0;
        }
        
        if($this->Product_category_model->categoryList($lang, $page, $limit, $parent_id))
        {
            $this->response($this->response_message->get_message());
        }
        else
        {
            $this->response($this->response_message->get_message(),WA_HEADER_NOT_FOUND);
        }
    }
    
    public function categoryCreate()
    {
        $this->is_required($this->input->post(), array('name', 'desc', 'parent_id', 'lang_list'), false);
        
        $lang = $this->get_language();
        
        $name = $this->input->post('name');
        $desc = $this->input->post('desc');
        $parent_id = $this->input->post('parent_id');
        $sort = $this->input->post('sort');
        $lang_list = $this->input->post('lang_list');
        
        $name = !empty($name) ? $name : null;
        $desc = !empty($desc) ? $desc : null;
        $parent_id = !empty($parent_id) ? $parent_id : 0;
        $sort = !empty($sort) ? $sort : 0;
        $lang_list = !empty($lang_list) ? $lang_list : null;
        
        $created_by = $this->get_profile_id();
        
        $lang_list = json_decode($lang_list);
        if(!$lang_list){
            $this->invalid_params('lang_list');
            return;
        }
        
        $icon_url = null;
        if(isset($_FILES['icon']))
            $icon_url = $this->upload_image ('icon', null);
        
        if($parent_id == null)
        {
            $parent_id = 0;
        }
        
        if($this->Product_category_model->categoryCreate($lang, $name, $desc, $parent_id, $sort, $icon_url, $created_by, $lang_list)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), WA_HEADER_NOT_FOUND);
        }
    }
    
    public function categoryDetail()
    {
        $this->is_required($this->input->post(), array('id'));
        
        $lang = $this->get_language();
        $id = $this->input->post('id') ? $this->input->post('id') : null;
        
        if($this->Product_category_model->categoryDetail($lang, $id)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), WA_HEADER_NOT_FOUND);
        }
    }
    
    public function categoryUpdate()
    {
        $this->is_required($this->input->post(), array('id', 'name', 'desc', 'parent_id', 'lang_list'), false);
        
        $lang = $this->get_language();
        
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $desc = $this->input->post('desc');
        $parent_id = $this->input->post('parent_id');
        $sort = $this->input->post('sort');
        $lang_list = $this->input->post('lang_list');
        
        $id = !empty($id) ? $id : null;
        $name = !empty($name) ? $name : null;
        $desc = !empty($desc) ? $desc : null;
        $parent_id = !empty($parent_id) ? $parent_id : 0;
        $sort = !empty($sort) ? $sort : 0;
        $lang_list = !empty($lang_list) ? $lang_list : null;
        
        $updated_by = $this->get_profile_id();
        
        $lang_list = json_decode($lang_list);
        if(!$lang_list){
            $this->invalid_params('lang_list');
            return;
        }
        
        $icon_url = null;
        if(isset($_FILES['icon']))
            $icon_url = $this->upload_image ('icon', null);
        
        if($parent_id == null)
        {
            $parent_id = 0;
        }
        
        if($this->Product_category_model->categoryUpdate($lang, $id, $name, $desc, $parent_id, $sort, $icon_url, $updated_by, $lang_list)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), WA_HEADER_NOT_FOUND);
        }
    }
    
    public function categoryDelete()
    {
        $this->is_required($this->input->post(), array('id'));
        
        $lang = $this->get_language();
        $id = $this->input->post('id');
        $id = !empty($id) ? $id : null;
        
        if($this->Product_category_model->categoryDelete($id)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), WA_HEADER_NOT_FOUND);
        }
    }
    
}
