<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	class Group extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			
			$this->load->model('group/group_model');
			$this->load->model('media/photo_model');
			
			$this->load->library('uploading');
			$this->load->library('form_validation');
	
		}
		public function create_group()
		{
			$uid = $this->session->userdata('userid');
			$group_display = $this->input->post('display');
			$group_name = $this->input->post('name');
			$desc = $this->input->post('desc');
			
			
			
			$iserror = FALSE;
			$error = array();
			
			
			$group_data = array('group_name'=>$group_name,'group_display_name'=>$group_display,'group_description'=>$desc,'group_creator'=>$uid);
			
			if(isset($_FILES['userfile']['name']))
			{
				$cover_photo = $this->input->post('userfile');
				$file_name = $_FILES['userfile']['name'];
				
				$isUploaded = $this->uploading->photo_upload($cover_photo,$file_name);
				
				if($isUploaded == 'uploaded')
				{
					//if photo upload succesfull, save its record in database
					$photo_data['user_id'] = $this->session->userdata('userid');
					$photo_data['photo_name'] = $file_name;
					$photo_id = $this->photo_model->create($photo_data);
			
					//make it group cover
					$group_data['group_cover'] = $photo_id;
				}
				else
				{
					$iserror = TRUE;
					$error = $isUploaded;
				}
			}
			else
			{
					//set a default photo as group photo
					$photo_data['user_id'] = $this->session->userdata('userid');
					$photo_data['photo_name'] = "group_default.jpg";
					$photo_id = $this->photo_model->create($photo_data);
			
					//make it group cover
					$group_data['group_cover'] = $photo_id;
			}
			if($iserror == TRUE)
			{
				$error['is_error'] = $iserror;
				echo json_encode($error);
				return;
			}
			
			$result = $this->group_model->create_group($group_data);
			if($result != FALSE)
			{
				$this->make_group_member($result,$uid);
				$data = array('is_error'=>$iserror);
				echo json_encode($data);		
			}
		}
		public function update_group()
		{
			$group_display = $this->input->post('display');
			$desc = $this->input->post('desc');
			$gid = $this->input->post('group-id');
			
			//echo $gid;
			
			$iserror = FALSE;
			$error = array();
			$pname = FALSE;
			
			$group_data = array('group_display_name'=>$group_display,'group_description'=>$desc);
			
			if(isset($_FILES['userfile']['name']))
			{
				$cover_photo = $this->input->post('userfile');
				$file_name = $_FILES['userfile']['name'];
				
				$isUploaded = $this->uploading->photo_upload($cover_photo,$file_name);
				
				if($isUploaded == 'uploaded')
				{
					//if photo upload succesfull, save its record in database
					$photo_data['user_id'] = $this->session->userdata('userid');
					$photo_data['photo_name'] = $file_name;
					$photo_id = $this->photo_model->create($photo_data);
			
					//make it group cover
					$group_data['group_cover'] = $photo_id;
					
					$pname = $file_name;
				}
				else
				{
					$iserror = TRUE;
					$error = $isUploaded;
				}
			}
			
			if($iserror == TRUE)
			{
				$error['is_error'] = $iserror;
				echo json_encode($error);
				return;
			}
			
			$result = $this->group_model->update_group($gid,$group_data);
			if($result != FALSE)
			{
				
				$data = array('is_error'=>$iserror,'pname'=>$pname);
				echo json_encode($data);		
			}
		}
		public function make_group_member($group_id = FALSE,$uid = FALSE)
		{
	
			if($group_id == FALSE && $uid == FALSE)
			{				
				$group_id = $this->input->post('group');
				$uid = $this->input->post('user');
				
				if($this->group_model->is_member($group_id,$uid) == TRUE)
				{
					echo "FALSE";
				}
				else
				{
					if($this->group_model->make_member($group_id,$uid) == TRUE)
					{
						echo "TRUE";
					}
					else
					{
						echo "error";
					}
				}
			}
			else
			{
				$this->group_model->make_member($group_id,$uid);
			}
		}
		public function delete_group_member()
		{
			$gid = $this->input->post('group');
			$uid = $this->input->post('user');
			
			if($this->group_model->delete_member($gid,$uid) == TRUE)
			{
				echo TRUE;
			}
			else
			{
				echo FALSE;
			}
		}

		public function group_name()
		{
			$this->form_validation->set_rules('name', 'name', 'trim|required|is_unique[group.group_name]');
		
			if ($this->form_validation->run() == FALSE)
			{
				echo "false";
			}
			else
			{
				echo "true";
			}
		}
		
	}