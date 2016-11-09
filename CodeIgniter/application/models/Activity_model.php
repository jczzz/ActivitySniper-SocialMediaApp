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
}
?>
