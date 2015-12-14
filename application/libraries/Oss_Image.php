<?php 
require_once "./vendor/autoload.php";
require_once "./system/libraries/Image_lib.php";
require_once "./system/libraries/Upload.php";
use JohnLui\AliyunOSS\AliyunOSS;
// use Config;


class Oss_Image
{
	
	protected $smallDefaultSize;
	protected $mediumDefaultSize;
	protected $bigDefaultSize;
	protected $maxImageSize;

    private $ossClient;

    const BUCKET = 'wei395';
    const UPLOADFOLDER = './uploads/';


	public function __construct($isInternal = false)
    {
		$this->_ci = get_instance();

		$this->_ci->config->load('oss_config');
        $this->smallDefaultSize = $this->_ci->config->item('default_small_image_size');
        $this->mediumDefaultSize = $this->_ci->config->item('default_medium_image_size');
        $this->bigDefaultSize    = $this->_ci->config->item('default_big_image_size');
        $this->ServerAddress    = $this->_ci->config->item('serverAddress');
        $this->AccessKeyId    = $this->_ci->config->item('AccessKeyId');
        $this->AccessKeySecret    = $this->_ci->config->item('AccessKeySecret');


	}


    /**
     * @param string $field
     * @param string $folder
     * @param string $photoname
     * @return string
     */
    public function do_upload_no_resize($field,$folder='',$photoname ='')
    {
        if(!isset($_FILES['photo'])){
            return NULL;
        }

        if ($photoname) {
           $this->upload = new CI_Upload(array(
                    'upload_path'   => './uploads/o/',
                    'file_name'     => $photoname,
                    'overwrite'     => TRUE,
                    'allowed_types' => 'jpg|png|gif',
                    'max_size'      => '8000' // kilobytes
                ));
        }else{
            $this->upload = new CI_Upload(array(
                'upload_path'   => './uploads/o/',
                'encrypt_name'  => TRUE,
                'overwrite'     => FALSE,
                'allowed_types' => 'jpg|png|gif',
                'max_size'      => '8000' // kilobytes
            ));
        }

        if (!$this->upload->do_upload($field))
        {
            return $this->upload->error_msg;
            
        }else{
            $src = $this->upload->data();  

            $this->create_object(self::UPLOADFOLDER.'/o/'.$src['file_name'] , $folder.'/'.$src['file_name']);

        }
    }

    
	public function do_upload_file($field,$folder='',$photoname ='')
	{
        if(!isset($_FILES['photo'])){
            return NULL;
        }


		if ($photoname) {
           $this->upload = new CI_Upload(array(
           			'upload_path'	=> './uploads/o/',
                    'file_name'     => $photoname,
                    'overwrite'     => TRUE,
                    'allowed_types' => 'jpg|png|gif',
                    'max_size'      => '8000' // kilobytes
                ));
        }else{
            $this->upload = new CI_Upload(array(
            	'upload_path'	=> './uploads/o/',
                'encrypt_name'  => TRUE,
                'overwrite'     => FALSE,
                'allowed_types' => 'jpg|png|gif',
                'max_size'      => '8000' // kilobytes
            ));
        }
            // Try uploading
        if (!$this->upload->do_upload($field))
        {
            return $this->upload->error_msg;

        }else{
   			$src = $this->upload->data();  
   			// var_dump($src);exit();
   			// echo $src['full_path'];exit();
   			// echo json_encode($src);exit(); 		
			$smallWidth   =  $this->smallDefaultSize;
            $smallHeight  =  $this->smallDefaultSize;
            $mediumWidth  =  $this->mediumDefaultSize;
            $mediumHeight =  $this->mediumDefaultSize;
            $largeWidth   =  $this->bigDefaultSize;
            $largeHeight  =  $this->bigDefaultSize;

            $s = $this->do_image_resize($src['full_path'], self::UPLOADFOLDER . '/s/' . $src['file_name'], $smallWidth, $smallHeight);
            $m = $this->do_image_resize($src['full_path'], self::UPLOADFOLDER . '/m/' . $src['file_name'], $mediumWidth, $mediumHeight);
            $b = $this->do_image_resize($src['full_path'], self::UPLOADFOLDER . '/b/' . $src['file_name'], $largeWidth, $largeHeight);

            
            if($s){
                $this->create_object(self::UPLOADFOLDER.'/s/'.$src['file_name'] , $folder.'/s/'.$src['file_name']);
                unlink(self::UPLOADFOLDER.'/s/'.$src['file_name']);
            }
            if($m){
                $this->create_object(self::UPLOADFOLDER.'/m/'.$src['file_name'] , $folder.'/m/'.$src['file_name']);
                unlink(self::UPLOADFOLDER.'/m/'.$src['file_name']);
            }
            if($b){
                $this->create_object(self::UPLOADFOLDER.'/b/'.$src['file_name'] , $folder.'/b/'.$src['file_name']);
                unlink(self::UPLOADFOLDER.'/b/'.$src['file_name']);
            }
            if($src)
            {
                $this->create_object(self::UPLOADFOLDER.'/o/'.$src['file_name'] , $folder.'/o/'.$src['file_name']);
                unlink(self::UPLOADFOLDER.'/o/'.$src['file_name']);
            }

            return $src['file_name'];
        }
	}

    public function create_object($filePath,$ossKey)
    {
        $this->ossClient = AliyunOSS::boot(
            $this->ServerAddress,
            $this->AccessKeyId,
            $this->AccessKeySecret
        );


        // $filePath = '/WebSite/Distribution/API/uploads/o/011768c9aa5686308805a9eada872a2e.jpg';
        // $ossKey = 'shop/o/011768c9aa5686308805a9eada872a2e.jpg';
        $this->ossClient->setBucket(self::BUCKET);
        $this->ossClient->uploadFile($ossKey, $filePath);
    }


	public function do_image_resize($src_path, $new_image, $width, $height)
    {
    	// echo $width;exit();
        // $this->load->library('image_lib');
        $this->image_lib = new CI_Image_lib();
        $this->image_lib->initialize(array(
            'image_library'     => 'gd2',
            'source_image'      => $src_path,
            'new_image'         => $new_image,
            'maintain_ratio'    => TRUE,
            'quality'           => '100%',
            'width'             => $width,
            'height'            => $height
        ));

        if (!$this->image_lib->resize())
        {
            return FALSE;
        }

        return TRUE;
    }
	
}
?>