<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once "./vendor/autoload.php";
require_once "./system/libraries/Image_lib.php";
require_once "./system/libraries/Upload.php";

use JohnLui\AliyunOSS\AliyunOSS;

// use Config;

class Oss_Image {

    protected $smallDefaultSize;
    protected $mediumDefaultSize;
    protected $bigDefaultSize;
    protected $maxImageSize;
    private $ossClient;
    private $BUCKET;
    private $ServerAddress;
    private $AccessKeyId;
    private $AccessKeySecret;

    const UPLOADFOLDER = './uploads/';

    public function __construct() {
        
        $this->_ci = get_instance();

        $this->_ci->config->load('oss_config');

        $this->smallDefaultSize = $this->_ci->config->item('default_small_image_size');
        $this->mediumDefaultSize = $this->_ci->config->item('default_medium_image_size');
        $this->bigDefaultSize = $this->_ci->config->item('default_big_image_size');

        $this->BUCKET = $this->_ci->config->item('BUCKET');
//        $this->ServerAddress = $this->_ci->config->item('serverAddress');
        $this->ServerAddress = $this->_ci->config->item('ServerAddressInternal') ? $this->_ci->config->item('ServerAddressInternal') : $this->_ci->config->item('ServerAddress');
        $this->AccessKeyId = $this->_ci->config->item('AccessKeyId');
        $this->AccessKeySecret = $this->_ci->config->item('AccessKeySecret');
        
        $this->ossClient = AliyunOSS::boot(
            $this->ServerAddress,
            $this->AccessKeyId,
            $this->AccessKeySecret
        );
        
        log_message('info', 'Oss Image Class Initialized');
    }

    public function upload($ossKey, $filePath) {
        $this->ossClient->setBucket($this->BUCKET);
        return $this->ossClient->uploadFile($ossKey, $filePath);
    }

    /**
     * 直接把变量内容上传到oss
     * @param $osskey
     * @param $content
     */
    public function uploadContent($osskey, $content) {
        $this->ossClient->setBucket($this->BUCKET);
        $this->ossClient->uploadContent($osskey, $content);
    }

    /**
     * 删除存储在oss中的文件
     *
     * @param string $ossKey 存储的key（文件路径和文件名）
     * @return
     */
    public function deleteObject($ossKey) {
        return $this->ossClient->deleteObject($this->BUCKET, $ossKey);
    }

    /**
     * 复制存储在阿里云OSS中的Object
     *
     * @param string $sourceBuckt 复制的源Bucket
     * @param string $sourceKey - 复制的的源Object的Key
     * @param string $destBucket - 复制的目的Bucket
     * @param string $destKey - 复制的目的Object的Key
     * @return Models\CopyObjectResult
     */
    public function copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey) {
        return $this->ossClient->copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey);
    }

    /**
     * 移动存储在阿里云OSS中的Object
     *
     * @param string $sourceBuckt 复制的源Bucket
     * @param string $sourceKey - 复制的的源Object的Key
     * @param string $destBucket - 复制的目的Bucket
     * @param string $destKey - 复制的目的Object的Key
     * @return Models\CopyObjectResult
     */
    public function moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey) {
        return $this->ossClient->moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey);
    }

    public function getUrl($ossKey) {
        $this->ossClient->setBucket($this->BUCKET);
        return $this->ossClient->getUrl($ossKey, new \DateTime("+1 day"));
    }

    public function createBucket($bucketName) {
        return $this->ossClient->createBucket($bucketName);
    }

    public function getAllObjectKey($bucketName) {
        return $this->ossClient->getAllObjectKey($bucketName);
    }

}

?>