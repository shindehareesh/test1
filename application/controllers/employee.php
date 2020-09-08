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
        $this->load->view('employee_view');
    }
   
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function getEmp()
    {
          $data = [];
          $parent_key = '0';
          $row = $this->db->query('SELECT id, name from employee');
            
          if($row->num_rows() > 0)
          {
              $data = $this->membersTree($parent_key);
          }else{
              $data=["id"=>"0","name"=>"No Members presnt in list","text"=>"No Members is presnt in list","nodes"=>[]];
          }
   
          echo json_encode(array_values($data));
	}
	
	public function getManager()
    {
          $empdata = [];
          $parent_key = '0';
          $data = $this->db->query('SELECT id, name from employee WHERE parent="'.$parent_key.'"')->result_array();
                 foreach ($data as $key => $value) {
					$empdata[$key]= array('id'=>$value['id'],'name'=>$value['name']);
				 }
          echo json_encode($empdata);
    }
   
   
    public function membersTree($parent_key)
    {
        $row1 = [];
        $row = $this->db->query('SELECT id, name from employee WHERE parent="'.$parent_key.'"')->result_array();
    
        foreach($row as $key => $value)
        {
           $id = $value['id'];
           $row1[$key]['id'] = $value['id'];
           $row1[$key]['name'] = $value['name'];
           $row1[$key]['text'] = $value['name'];
           $row1[$key]['nodes'] = array_values($this->membersTree($value['id']));
        }
  
        return $row1;
    }
      

	
	public function addemployee()
	{
		if ($this->input->post('name')!="")
		 {			
				$data = array(					
					'name' => $this->input->post('name'),
					'parent' => $this->input->post('parent'),
				);
			
				//print_r($data);die;
				$insert = $this->person->save($data);

				if ($insert) {
					return redirect($this->index());
				}
				
		}
		
		}

	

}
