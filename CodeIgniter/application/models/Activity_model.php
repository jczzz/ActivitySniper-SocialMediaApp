<?php
class Activity_model extends CI_Model
{
            public function __construct()
            {
                $this->load->database();
            }
            public function set_activity()
            {
                 $data=array(
                   'name' => $this->input->post('name'),
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
                      return $query->db->row_array();
                  }
            }
}
?>
