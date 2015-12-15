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
class Product_type extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Product_type_model');
    }
    
    public function getList()
    {
        $lang = $this->get_language();
        $page = $this->get_page();
        $limit = $this->get_limit();
        
        if($this->Product_type_model->getList($lang, $page, $limit))
        {
            $this->response($this->response_message->get_message());
        }
        else
        {
            $this->response($this->response_message->get_message(),WA_HEADER_NOT_FOUND);
        }
    }
    
    public function create()
    {
        $this->is_required($this->input->post(), array('name', 'desc', 'lang_list'), false);
        
        $lang = $this->get_language();
        $name = $this->input->post('name') ? $this->input->post('name') : null;
        $desc = $this->input->post('desc') ? $this->input->post('desc') : null;
        $sort = $this->input->post('sort') ? $this->input->post('sort') : null;
        $icon_url = null;
        
        $lang_list = $this->input->post('lang_list') ? $this->input->post('lang_list') : null;
        $lang_list = json_decode($lang_list);
        if(!$lang_list){
            $this->invalid_params('lang_list');
            return;
        }
        
        $created_by = $this->get_profile_id();
        
        if(isset($_FILES['icon']))
            $icon_url = $this->upload_image('icon', null);
        
        if($this->Product_type_model->create($lang, $name, $desc, $icon_url, $sort, $created_by, $lang_list)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), WA_HEADER_NOT_FOUND);
        }
    }
    
    public function getDetail()
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
    
    public function update()
    {
        $this->is_required($this->input->post(), array('id', 'name', 'desc', 'lang_list'), false);
        
        $lang = $this->get_language();
        $id = $this->input->post('id') ? $this->input->post('id') : null;
        $name = $this->input->post('name') ? $this->input->post('name') : null;
        $desc = $this->input->post('desc') ? $this->input->post('desc') : null;
        $sort = $this->input->post('sort') ? $this->input->post('sort') : null;
        $icon_url = null;
        
        $lang_list = $this->input->post('lang_list') ? $this->input->post('lang_list') : null;
        $updated_by = $this->get_profile_id();
        
        $lang_list = json_decode($lang_list);
        if(!$lang_list){
            $this->invalid_params('lang_list');
            return;
        }
        
        if(isset($_FILES['icon']))
            $icon_url = $this->upload_image('icon', null);
        
        if($this->Product_type_model->update($lang, $id, $name, $desc, $icon_url, $updated_by, $lang_list)){
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
        $id = $this->input->post('id') ? $this->input->post('id') : null;
        
        if($this->Product_category_model->categoryDelete($id)){
            $this->response($this->response_message->get_message());
        }
        else{
            $this->response($this->response_message->get_message(), WA_HEADER_NOT_FOUND);
        }
    }
    
}
