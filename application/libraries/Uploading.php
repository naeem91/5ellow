<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Class Name: MyEmail 
* Responsibility: Performs email related functions
*
* Methods:
* - send verification email
* - send email
* 
* Last Updated: August 4,2012 
*/

class Uploading
{
    public function __construct()
    {
		//get CI's reference to use CI's libraries
		$this->CI = & get_instance();
    }
	public function file_upload($file)
	{
		$config['upload_path'] = './uploads/files';
		$config['allowed_types'] = 'pdf|ppt|zip|txt|doc|docx|word|rar';
		$config['max_size']	= '10000';
		/*$config['max_width']  = '1024';
		$config['max_height']  = '768';*/

		$this->CI->load->library('upload', $config);

		if ( ! $this->CI->upload->do_upload())
		{
			$error = array('error' => $this->CI->upload->display_errors());

			return $error;
		}
		else
		{
			return 'uploaded';
		}
	}
	public function photo_upload($photo,$name)
	{
		
		
		$this->name = $name;
		
		
		$config['upload_path'] = './uploads/photos';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '5000';
		$config['max_width']  = '1524';
		$config['max_height']  = '1000';
		
		//$config['file_name'] = $n;
		
		$this->CI->load->library('upload',$config);		
		
		
		/*$this->do_upload($photo);
		return $this->CI->upload->data();*/
		return $this->do_upload($photo);
	}
	private function do_upload()
	{
		
		if ( ! $this->CI->upload->do_upload())
		{
		
			$error = array('error' => $this->CI->upload->display_errors());
			return $error;
		}
		else
		{
			//if upload succesful, store image in different dimensions
			$this->make_pics($this->name);
			
			return 'uploaded';
		}
	}
	
	function make_pics($image_name)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = TRUE;
		//$config['create_thumb'] = TRUE;
		$config['width'] = 80;
		$config['height'] = 100;
		$config['new_image'] = "./uploads/thumbs/";
		
		$this->CI->load->library('image_lib',$config);
				
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
		unset($config);
		
		
		//make photo gallery thumbs		
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 180;
		$config['height'] = 200;  
		$config['new_image'] = "./uploads/gallery_thumbs/";
		    
		$this->CI->image_lib->initialize($config);		
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
		unset($config);
		
		//make info-page photo	
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 200;
		$config['height'] = 288;  
		$config['new_image'] = "./uploads/info_photos/";
		    
		$this->CI->image_lib->initialize($config);		
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
		unset($config);
		
		//make info-page photo	
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 65;
		$config['height'] = 65;  
		$config['new_image'] = "./uploads/post_thumbs/";
		    
		$this->CI->image_lib->initialize($config);		
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
		unset($config);
		
		$img_data = $this->CI->upload->data();
		
		//make large-view photo	
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = TRUE;
		
		if($img_data['image_height'] > 550)
		{
			if($img_data['image_width'] > 800)
			{
				$config['width'] = 800;
			}
			
			$config['height'] = 550;	
		}
		  
		$config['new_image'] = "./uploads/large_photos/";
		    
		$this->CI->image_lib->initialize($config);		
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
		unset($config);
		
		$img_data = $this->CI->upload->data();
		
		//make group-cover photo	
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = FALSE;
		
		$config['width'] = 820;
		$config['height'] = 200;
		/*if($img_data['image_height'] > 200)
		{
			if($img_data['image_width'] > 820)
			{
				$config['width'] = 820;
			}
			
			$config['height'] = 200;	
		}*/
		  
		$config['new_image'] = "./uploads/group_covers/";
		    
		$this->CI->image_lib->initialize($config);		
		$this->CI->image_lib->resize();
		$this->CI->image_lib->clear();
		unset($config);
		
		//make stream-photos
		$config['image_library'] = 'gd2';
		$config['source_image'] = "./uploads/photos/".$image_name;
		$config['maintain_ratio'] = TRUE;
		  
		if($img_data['image_width'] > 500 || $img_data['image_height'] > 400)
		{
			$config['width'] = 500;
			$config['height'] = 400;
		}
		  
		$config['new_image'] = "./uploads/stream_photos/";
		    
		$this->CI->image_lib->initialize($config);		
		$this->CI->image_lib->resize();
					
	}		
}






