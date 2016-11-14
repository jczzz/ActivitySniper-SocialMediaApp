<?php
class User_model extends CI_Model
{
	function login($email, $password)
	{
		$this -> db -> select('id, email, password');
		$this -> db -> from('users');
		$this -> db -> where('email = ' . "'" . $email . "'"); 
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








            public function delete($id)
            {

                if($id !=1)
                {
                    $data = array('id'=>$id);
                    $query = $this->db->get_where('users',$data);
                    return $this->db->delete('users', $query->row_array());
                }

                //$this -> db -> delete ;
                //$this -> db -> from('users');
                //$this -> db -> where('id = '  . $id ); 
            
            }
            public function check_unique()
            {


                      $data1 = array('email'=>$this->input->post('email'));
                      $check1 = $this->db->get_where('users',$data1);
     
                     if($this->input->post('phonenum')==null)
                     {
                          if($check1->row_array()!=null)
                          {
                            return false; 
                          }
                          else
                          {
                            return true;
                          }           
                     }
                     else
                    {
                      $data2 = array('phonenum'=>$this->input->post('phonenum'));
                      $check2 = $this->db->get_where('users',$data2);

                      if($check1->row_array()!=null or $check2->row_array()!=null)
                      {
                        return false; 
                      }
                      else
                      {
                        return true;
                      }

                    }



            }


}


?>
