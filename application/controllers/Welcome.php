<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
			$row[] = $person->image;


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

	// public function ajax_add()
	// {
	// 	$data = array(
	// 			'firstName' => $this->input->post('firstName'),
	// 			'lastName' => $this->input->post('lastName'),
	// 			'gender' => $this->input->post('gender'),
	// 			'address' => $this->input->post('address'),
	// 			'dob' => $this->input->post('dob'),
	// 		);
	// 	$insert = $this->person->save($data);
	// 	echo json_encode(array("status" => TRUE));
	// }

	

	public function addemployee($post)
	{
		$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'contact' => $this->input->post('contact'),
				'address' => $this->input->post('address'),
				'dob' => $this->input->post('dob'),
			);
		$insert = $this->person->save($post);
		//echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'firstName' => $this->input->post('firstName'),
				'lastName' => $this->input->post('lastName'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'dob' => $this->input->post('dob'),
			);
		$this->person->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
