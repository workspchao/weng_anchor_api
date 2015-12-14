<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use JohnLui\AliyunOSS\AliyunOSS;

class Test extends Base_Controller {

    private $oosClient;

    public function __construct($isInternal = false)
    {
        parent::__construct();

        $this->_ci = get_instance();
        $this->_ci->config->load('oss_config');
        $this->smallDefaultSize = $this->_ci->config->item('default_small_image_size');
        $this->mediumDefaultSize = $this->_ci->config->item('default_medium_image_size');
        $this->bigDefaultSize    = $this->_ci->config->item('default_big_image_size');
        $this->ServerAddress    = $this->_ci->config->item('serverAddress');
        $this->Bucket  = $this->_ci->config->item('BUCKET');
        $this->AccessKeyId    = $this->_ci->config->item('AccessKeyId');
        $this->AccessKeySecret    = $this->_ci->config->item('AccessKeySecret');
    }

    public function index(){
        var_dump("index");
        exit();
    }

    public function create_object()
    {
        $this->ossClient = AliyunOSS::boot(
            $this->ServerAddress,
            $this->AccessKeyId,
            $this->AccessKeySecret
        );

        $filePath = 'C:\Users\Administrator\Desktop\14009717_1200x1000_0.jpg';
        $ossKey = 'product/011768c9aa5686308805a9eada872a2a.jpg';
        // $filePath = '/WebSite/Distribution/API/uploads/o/011768c9aa5686308805a9eada872a2e.jpg';
        // $ossKey = 'shop/o/011768c9aa5686308805a9eada872a2e.jpg';
        $this->ossClient->setBucket($this->Bucket);
        $this->ossClient->uploadFile($ossKey, $filePath);
    }

}