<?php
class User_model extends CI_Model
{
	function login($lastname, $password)
	{
		$this -> db -> select('id, lastname, password');
		$this -> db -> from('users');
		$this -> db -> where('lastname = ' . "'" . $lastname . "'"); 
		$this -> db -> where('password = ' . "'" . $password . "'"); 
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}



            public function set()
            {
                $data= array(
                    //names are corresponding to the names of fields in the input form
                'firstname'=> $this->input->post('firstname'),
                'lastname' =>$this->input->post('lastname'),
                'email' =>$this->input->post('email'),
                'phonenum' =>$this->input->post('phonenum'),
                'notes' =>$this->input->post('notes'),
                'password' =>$this->input->post('password')
                );
                return $this->db->insert('users', $data);
            }

            public function get($id = '0')
            {
                if($id === '0')
                {
                     $query = $this->db->get('users');
                     return $query->result_array();
                }
                else
                {
                      $data = array('id'=>$id);
                      $query = $this->db->get_where('users',$data);
                      return $query->row_array();
                }
            }





}


?>
