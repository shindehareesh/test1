<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('employee_model','person');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->view('employee_view');

	}

	public function ajax_list()
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) 
		{
			$no++;
			$row = array();
			$row[] = $person->name;
			$row[] = $person->email;
			$row[] = $person->address;
			$row[] = $person->contact;
			$row[] = $person->dob;
			$row[] = '<img src="'."".base_url($person->image)."".'"   width="100px" height="100px">';


			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->person->get_by_id($id);
		echo json_encode($data);
	}

	
	public function addemployee()
	{

				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('userfile'))
                {
						$error = array('upload_error' => $this->upload->display_errors());
						//print_r($error);die;

                        $this->load->view('employee_view', $error);
                }
                else
                {
					$check=$this->check_duplicate_email($this->input->post('email'));
					$uploaddata = $this->upload->data();
					//print_r($uploaddata);
					 $imagename='uploads/'.$uploaddata['raw_name'].''.$uploaddata['file_ext'];
				
					if ($check !=1) {
						$data = array(
							'name' => $this->input->post('name'),
							'email' => $this->input->post('email'),
							'contact' => $this->input->post('contact'),
							'address' => $this->input->post('address'),
							'dob' => $this->input->post('dob'),
							'image' => $imagename

						);
			
					//print_r($data);die;
					$insert = $this->person->save($data);
					//echo json_encode(array("status" => TRUE));
                        $this->load->view('employee_view');
					}
					else{
						$error = array('email_error' => 'email already present');
						//print_r($error);die;

                        $this->load->view('employee_view', $error);
					}					
						
                }
		
	}

	public function check_duplicate_email($post_email) {
		return $this->person->checkDuplicateEmail($post_email);
		}

	public function ajax_update()
	{
		$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'address' => $this->input->post('address'),
				'contact' => $this->input->post('contact'),
				'dob' => $this->input->post('dob'),
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		$this->load->view('employee_view');
	}

	public function ajax_delete($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
