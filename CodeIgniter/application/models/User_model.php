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

	public function set($upload_data = ' ')
	{
		$encrypted_pw = md5($this->input->post('password'));
		$data= array(
			//names are corresponding to the names of fields in the input form
			'firstname'=> $this->input->post('firstname'),
			'lastname' =>$this->input->post('lastname'),
			'email' =>$this->input->post('email'),
			'phonenum' =>$this->input->post('phonenum'),
			'notes' =>$this->input->post('notes'),
			'password' => $encrypted_pw
		);

		if($upload_data['file_name'] != ''){
			$data['picture'] = $upload_data['file_name'];
		}

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
	}

	public function check_unique($user_id = '0')
	{
		if($user_id != '0')
		{
			$data=array('email'=> $this->input->post('email'));
			$result1 = $this->db->get_where('users',$data);
			if($result1->row_array() >0 )
			{
				$result=$result1->row_array();
				if($result['id']==$user_id)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return true;
			}
		}
		else
		{
			$data=array('email'=> $this->input->post('email'));
			$result1 = $this->db->get_where('users',$data);
			if($result1->row_array() >0 )
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	//set relationship
	public function set_user_relation($user_id, $view_user_id)
	{
		$data=array('user_id1'=>$user_id, 'user_id2'=>$view_user_id);
		return $this->db->insert('user_rel',$data);
	}

	//check relationship
	public function check_user_relation($user_id, $view_user_id)
	{
		$sql="select * from user_rel where $user_id=user_id1 and $view_user_id=user_id2";
		$query=$this->db->query($sql);
		$result=$query->row_array();
		if($result)
		{
			return "false";
		}
		return "true";
	}

	//search all friend by userid.
	public function get_user_by_view($view_user_id)
	{
		$sql="select A.firstname, A.lastname, A.email, A.id, A.notes from users A, user_rel B where $view_user_id=B.user_id2 and B.user_id1=A.id";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	//delete friend.
	public function delete_friend($user_id,$view_user_id)
	{
		$sql="delete from user_rel where $user_id=user_id1 and $view_user_id=user_id2";
		return $this->db->query($sql);
	}

	//user edit their account.
	public function edit_account($user_id, $upload_data = ' ')
	{
		$data=array(
			'firstname'=> $this->input->post('firstname'),
			'lastname' =>$this->input->post('lastname'),
			'email' =>$this->input->post('email'),
			'phonenum' =>$this->input->post('phonenum'),
			'notes' =>$this->input->post('notes'),
			'password' =>md5($this->input->post('password'))
		);
		if($upload_data['file_name'] != ''){
			$data['picture'] = $upload_data['file_name'];
		}
		$this->db->where('id',$user_id);
		$this->db->update('users',	$data);
	}








            public function set_message(){
              $data = array(
                'user_id1' => $this->input->post('user_id1'),
                'user_id2' => $this->input->post('user_id2'),
                'date' => $this->input->post('date'),
                'time' => $this->input->post('time'),
                'comment' => $this->input->post('message')
              );
              return $this->db->insert('message_board',$data);
            }

              public function get_message($user_id){
              $sql = "select A.*,B.firstname,B.lastname
              from message_board A, users B
              where  A.user_id2 =B.id
              ORDER BY date asc, time asc";
              $query = $this->db->query($sql);
              return $query->result_array();
            }








}
?>
