<?php
class Activity_model extends CI_Model
{
            public function __construct()
            {
                $this->load->database();
            }
            public function set_activity($user_id)
            {
                 $data=array(
                   'name' => $this->input->post('name'),
                   'create_user_id' => $user_id,
                   'date' => $this->input->post('date'),
                   'time' => $this->input->post('time'),
                   'description' => $this->input->post('description'),
                   'location_lng' => $this->input->post('location_lng'),
                   'location_lat' => $this->input->post('location_lat'),
                   'catagory' => $this->input->post('catagory')
                 );
                 return $this->db->insert('activity',$data);
            }

            public function get_activity($id = '0')
            {
                  if($id === '0')
                  {
                      $query = $this->db->get('activity');
                      return $query->result_array();
                  }
                  else
                  {
                      $data = array( 'id'=> $id );
                      $query = $this->db->get_where('activity', $data);
                      return $query->row_array();
                  }
            }

            //update a activity.
            public function update_activity($a_id = '0')
            {
                $data=array(
                  'name'=>$this->input->post("name"),
                  'date'=>$this->input->post("date"),
                  'time'=>$this->input->post("time"),
                  'description'=>$this->input->post("description"),
                  'location_lng'=>$this->input->post("location_lng"),
                  'location_lat'=>$this->input->post("location_lat"),
                  'catagory'=>$this->input->post("catagory"),
                );

                $this->db->where('id',$a_id);
                return $this->db->update('activity', $data);
            }

            //new get all activities from this user.
            public function get_created_activity($user_id = '0')
            {
                if($user_id !='0')
                {
                      $data = array('create_user_id' => $user_id);
                      $query = $this->db->get_where('activity', $data);
                      return $query->result_array();
                }
            }
            //new //according to user id, get all activity-user relation from relation table.
            public function get_user_activity($user_id)
            {
                $data = array( 'user_id'=> $user_id );
                $query = $this->db->get_where('user_activity', $data);
                return $query->result_array();
            }
            //new //check whether this relation is already in the relation table.
            public function check_exist($user_id, $activity_id)
            {
                $data['result']=$this->get_user_activity($user_id);
                foreach($data['result'] as $result1)
                {
                  if($result1['activity_id'] === $activity_id)
                  {
                    return false;
                  }
                }
                return true;
            }

            //new //set the relationship between users and activity.
            public function set_rel_user_activity($user_id,$activity_id)
            {
                $data=array('user_id'=>$user_id, 'activity_id'=>$activity_id);
                return $this->db->insert('user_activity',$data);
            }

            //new //remove the relationship between users and activity.
            public function remove_rel_user_activity($u_id,$a_id)
            {
                $sql="delete from user_activity where $u_id=user_id and $a_id=activity_id";
                return $this -> db -> query($sql);
            }

            //new //check the relationship between users and activity.
            public function check_rel_user_activity($u_id,$a_id)
            {
                $sql="select * from user_activity where $u_id=user_id and $a_id=activity_id";
                $query = $this -> db -> query($sql);
                $result=$query->row_array();
                if($result)
                {
                   return $result;
                }
                return null;
            }

            //new //get the activity according to user id.
            public function get_activity_by_user($user_id)
            {
                $sql="select A.name, A.id, A.create_user_id from activity A, user_activity B where $user_id=B.user_id and B.activity_id=A.id";
                $query = $this -> db -> query($sql);
                return $query->result_array();
            }



            public function remove_activity($id = '0')
            {
               $data =array('id'=>$id);
               return $this->db->delete('activity',$data);
            }

            public function get_coordinates(){
              $return = array();
              $this->db->select("id,name,date,time,location_lat,location_lng");
              $this->db->from("activity");
              $query = $this->db->get();
              if ($query->num_rows()>0) {
                foreach ($query->result() as $row) {
                  array_push($return, $row);
                }
              }
              return $return;
            }

            public function get_comments(){
              $query = $this->db->get('comment_board');
              return $query->result_array();
            }
}
?>
