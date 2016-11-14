<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends CI_Controller
{
         public function __construct()
         {
               parent::__construct();
               $this->load->model('activity_model');
               $this->load->helper('url_helper');
               $this->load->helper('url');

         }
         public function create($location=null)
         {
                $data['location']=$location;
                $this->load->helper('form',$data);
                $this->load->library('form_validation');

                $this->form_validation->set_rules('name', 'activity_name', 'required');
                $this->form_validation->set_rules('date', 'activity_date', 'required');
                $this->form_validation->set_rules('time', 'activity_time', 'required');
                $this->form_validation->set_rules('catagory', 'catagory', 'required');

                $data['title']="New Activity";





                //google map
                $this->load->library('googlemaps');
                $config['center'] = '8041 12th ave, Burnaby, BC, Canada';
                $config['zoom'] = "auto";

                $config['places'] = TRUE;

                $config['placesAutocompleteInputID'] = 'myPlaceTextBox';
                $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
                $config['placesAutocompleteOnChange'] = 'alert(document.getElementById(\'myPlaceTextBox\').value);';

                $this->googlemaps->initialize($config);

                $coords = $this->activity_model->get_coordinates();

                foreach ($coords as $coordinate) {
                  $marker = array();
                  $marker['position'] = $coordinate->location_lat.','.$coordinate->location_lng;
                  $marker['title'] = $coordinate->name;
                  $marker['animation'] = 'DROP';
                  $marker['infowindow_content'] = $coordinate->name."<br>".$coordinate->date."<br>".$coordinate->time."<br> <a href=\"".base_url()."activity/".$coordinate->id."\">show details</a>";
                  date_default_timezone_set("America/Vancouver");

                  $activity_time_stamp = strtotime($coordinate->date." ".$coordinate->time);
                  $current_time_stamp = strtotime(date('Y-m-d H:i:s'));

                  if($activity_time_stamp < $current_time_stamp){
                    $marker['icon'] = 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png';
                  }

                  $this->googlemaps->add_marker($marker);
                }

                $data['map'] = $this->googlemaps->create_map();




                if($this->form_validation->run()==FALSE)
                {
                     $this->load->view('templates/header',$data);
                     $this->load->view('activity/create');
                }
                else
                {
                     $this->activity_model->set_activity();
                     $suc="success";
                     redirect("activity/index/$suc");
                }
         }

         public function delete($id = '0')
         {
            $data['result']=$this->activity_model->remove_activity($id);
            $suc="delete";
            redirect("activity/index/$suc");
         }

         public function index($suc = null)
         {
                $data['success']=null;
                $data['title']="Activity List";
                $data['result']=$this->activity_model->get_activity();
                if($suc === "success")
                {
                   $data['success']="Activity has been created.";
                }
                if($suc === "delete")
                {
                  $data['success']="Activity has been deleted.";
                }

                //google map
                $this->load->library('googlemaps');
                $config['center'] = '8041 12th ave, Burnaby, BC, Canada';
                $config['zoom'] = "auto";
                $this->googlemaps->initialize($config);

                $coords = $this->activity_model->get_coordinates();

                foreach ($coords as $coordinate) {
                  $marker = array();
                  $marker['position'] = $coordinate->location_lat.','.$coordinate->location_lng;
                  $marker['title'] = $coordinate->name;
                  $marker['animation'] = 'DROP';
                  $marker['infowindow_content'] = $coordinate->name."<br>".$coordinate->date."<br>".$coordinate->time."<br> <a href=\"".base_url()."activity/".$coordinate->id."\">show details</a>";
                  date_default_timezone_set("America/Vancouver");

                  $activity_time_stamp = strtotime($coordinate->date." ".$coordinate->time);
                  $current_time_stamp = strtotime(date('Y-m-d H:i:s'));

                  if($activity_time_stamp < $current_time_stamp){
                    $marker['icon'] = 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png';
                  }

                  $this->googlemaps->add_marker($marker);
                }





                $data['map'] = $this->googlemaps->create_map();

                print_r($data['map']['markers']);


                print_r(date('Y-m-d H:i:s'));
                echo '<br/>';
                print_r($coordinate->date." ".$coordinate->time);
                echo '<br/> activity:' ;
                print_r($activity_time_stamp);
                echo '<br/> current:';
                print_r($current_time_stamp);
                echo '<br/>';
                print_r(date('Y-m-d H:i:s'));


                $this->load->view('templates/header',$data);
                $this->load->view("activity/index",$data);
         }

         public function view($id = '0')
         {
                $data['result']=$this->activity_model->get_activity($id);
                $data['title']=$data['result']['name'];
                //$this->load->view("templates/header",$data);
                $this->load->view("activity/view",$data);
         }

         public function location()
         {

                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('location', 'location', 'required');
                if($this->form_validation->run()==FALSE)
                {
                     $this->load->view("activity/select_location");
                }
                else
                {
                   $location=$this->input->post("location");
                   redirect("activity/create/$location");
                }


         }


}

?>
