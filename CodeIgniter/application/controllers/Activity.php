<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends CI_Controller
{
         public function __construct()
         {
               parent::__construct();
               $this->load->model('activity_model');
               $this->load->model('user_model');
               $this->load->helper('url_helper');
               $this->load->helper('url');
         }

         public function create($location=null, $user_id='0')
         {
               $data['location']=$location;
               $data['user_id']=$user_id;
               $this->load->helper('form',$data);
               $this->load->library('form_validation');
               $data['title']="New Activity";

               $this->form_validation->set_rules('name', 'activity_name', 'required');
               $this->form_validation->set_rules('date', 'activity_date', 'required');
               $this->form_validation->set_rules('time', 'activity_time', 'required');
               $this->form_validation->set_rules('catagory', 'catagory', 'required');

                //google map
                $this->load->library('googlemaps');
                $config['center'] = '8888 University Drive, Burnaby, BC, Canada';
                $config['zoom'] = "auto";

                $config['places'] = TRUE;

                $config['placesAutocompleteInputID'] = 'myPlaceTextBox';
                $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
                //$config['placesAutocompleteOnChange'] = 'alert(document.getElementById(\'myPlaceTextBox\').value);';

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
                     $this->activity_model->set_activity($user_id);
                     //add the relationship between the new activity and its user.
                     $this->relate_user_with_new_activity($user_id);

                     $suc="success";
                     redirect("activity/index/$suc/$user_id");
                }

         }
         //add the relationship between the new activity and its user.
        public function relate_user_with_new_activity($user_id)
        {
             //get all activities from this user.
             $data['result']=$this->activity_model->get_created_activity($user_id);
             //check whether this relation is already exist in the relation table.
             foreach($data['result'] as $result1)
             {
                $check=$this->activity_model->check_exist($user_id,$result1['id']);
                //if not in the relation table, add to it.
                if($check === TRUE)
                {
                  $this->activity_model->set_rel_user_activity($user_id,$result1['id']);
                  break;
                }
             }
        }

          public function delete($id = '0', $user_id = '0')
          {
             $data['result']=$this->activity_model->remove_activity($id);
             $suc="delete";
             redirect("activity/index/$suc/$user_id");
          }

         public function index($suc = null, $user_id = '0')
         {

                date_default_timezone_set("America/Vancouver");

                 $this->load->library('calendar');
                 $data['calendar_1']=$this->calendar->generate(strtotime(date('y')),strtotime(date('m')));
                 $data['user_result']=null;
                 $data['success']=null;
                 $data['title']="Activity List";
                 $data['result']=null;
                 $data['result1']=null;
                 //show activities in databases.
                 $data['result']=$this->activity_model->get_activity_by_user($user_id);

                 $data['user_id']=$user_id;

                 foreach($data['result'] as $a_result)
                 {
                      $data['user_result'][]=$this->activity_model->get_owner_email($a_result['id']);
                 }

                 if($suc === "success")
                 {
                    $data['success']="Activity has been created.";
                 }
                 if($suc === "delete")
                 {
                   $data['success']="Activity has been deleted.";
                 }
                 if($suc === "join")
                 {
                   $data['success']="Activity has been added.";
                 }
                 if($suc === "remove")
                 {
                   $data['success']="Activity has been removed.";
                 }
                 if($suc === "friend")
                 {
                   $data['success']="Add a friend successful!";
                 }
                 if($suc === "deletefriend")
                 {
                    $data['success']="delete a friend successful!";
                 }

                $data["google"]=$this->google_map_add_location($user_id);

                $this->load->view('templates/header',$data);
                $this->load->view("activity/index",$data);
         }

         //google map add mark for activities.
         public function google_map_add_location($user_id)
         {
               $coords = $this->activity_model->get_coordinates_singleUser($user_id);

               $this->load->library('googlemaps');
               $config['center'] = '8888 University Drive, Burnaby, BC, Canada';

               // config zoom levels
               if(count($coords) > 1){
                 $config['zoom'] = "auto";
               }else{
                 if(count($coords) === 1){
                   $config['center'] = $coords['0']->location_lat.','.$coords['0']->location_lng;
                 }
                 $config['zoom'] = "11";
               }



               $this->googlemaps->initialize($config);



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

               return $data;
         }

        //show all activities in database.
        public function showall($user_id = '0')
        {
            $data['success']=null;
            $data['result1']=null;
            $data['title']="All Activities";
            $data['result']=$this->activity_model->get_activity();
            $data['success']="All Activities in database has been shown.";
            $data['user_id']=$user_id;
            $data['array_1']=array();
            $data['user_result']=null;
            foreach($data['result'] as $result_1)
            {
                $data['result1']=$this->activity_model->check_rel_user_activity($user_id,$result_1['id']);
                if($data['result1'] === null)
                {
                    $data['array_1'][]="true";
                }
                else
                {
                    $data['array_1'][]="flase";
                }
            }

            foreach($data['result'] as $a_result)
            {
                 $data['user_result'][]=$this->activity_model->get_owner_email($a_result['id']);
            }

            $data["google"]=$this->google_map_add_location();

            $this->load->view('templates/header',$data);
            $this->load->view('activity/show_all',$data);
        }

         //use for user join another user's activities
        public function join($a_id = '0', $u_id='0')
        {
           $this->activity_model->set_rel_user_activity($u_id,$a_id);
           redirect("activity/index/join/$u_id");
        }

        //user can join to activites when he is in his friend list.
        public function join_friend_activity($a_id, $view_user_id, $user_id)
        {
            $this->activity_model->set_rel_user_activity($view_user_id,$a_id);
            redirect("activity/friendactivity/$user_id/$view_user_id");
        }

        //user can remove another user's activities off his list.
        public function remove($a_id = '0', $u_id='0')
        {
          $this->activity_model->remove_rel_user_activity($u_id,$a_id);
          redirect("activity/index/remove/$u_id");
        }

        public function view($a_id = '0', $u_id ='0',$suc=null,$view_user_id=null)
        {
              $this->load->helper('form');
              $this->load->library('form_validation');
              $data['friend']=$suc;
              $data['view_user_id']=$view_user_id;


              $this->form_validation->set_rules('comment','Comment','required');
              if($this->form_validation->run() === FALSE){



                $data['success']=null;
                if($suc === "success")
                {
                   $data['success']="your activity has been edited.";
                }

                $data['result']=$this->activity_model->get_activity($a_id);
                $data['comments']=$this->activity_model->get_comments();

                $data['title']=$data['result']['name'];
                $data['user_id']=$u_id;


                // google map
                $this->load->library('googlemaps');
                $lng = $data['result']['location_lng'];
                $lat = $data['result']['location_lat'];

                $config['center'] = $lat.','.$lng;
                $config['zoom'] = "15";
                $this->googlemaps->initialize($config);

                $marker = array();
                $marker['position'] = $lat.','.$lng;
                $marker['title'] = $data['result']['name'];
                $marker['animation'] = 'DROP';
                $marker['infowindow_content'] = $data['result']['name']."<br>".$data['result']['date']."<br>".$data['result']['time']."<br> <a href=\"".base_url()."activity/".$data['result']['id']."\">show details</a>";
                date_default_timezone_set("America/Vancouver");

                $activity_time_stamp = strtotime($data['result']['date']." ".$data['result']['time']);
                $current_time_stamp = strtotime(date('Y-m-d H:i:s'));

                if($activity_time_stamp < $current_time_stamp){
                  $marker['icon'] = 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png';
                }
                $this->googlemaps->add_marker($marker);

                $data['map'] = $this->googlemaps->create_map();

                $this->load->view("activity/view",$data);
              }
              elseif ($view_user_id != null)
              {
                $this->activity_model->set_comment();
                redirect("activity/view/$a_id/$u_id/friend/$view_user_id");
              }
              else
              {
                $this->activity_model->set_comment();
                redirect("activity/view/$a_id/$u_id");
              }

        }

        public function edit($a_id = '0', $u_id ='0')
        {
            $data['result']=$this->activity_model->get_activity($a_id);
            $data['a_id']=$a_id;
            $data['u_id']=$u_id;

            $this->load->helper('form',$data);
            $this->load->library('form_validation');
            $data['title']="Edit your activity";


            $this->form_validation->set_rules('name', 'activity_name', 'required');
            $this->form_validation->set_rules('date', 'activity_date', 'required');
            $this->form_validation->set_rules('time', 'activity_time', 'required');
            $this->form_validation->set_rules('catagory', 'catagory', 'required');

            if($this->form_validation->run()==FALSE)
            {
                 $this->load->view('templates/header',$data);
                 $this->load->view('activity/edit');
            }
            else
            {
                 $this->activity_model->update_activity($a_id);
                 redirect("activity/view/$a_id/$u_id/success");
            }

        }

        //see freind activities
        public function friendactivity($user_id, $view_user_id)
        {
            $data['user_id']=$user_id;
            $data['view_user_id']=$view_user_id;
            $data['user_infor']=$this->user_model->get($user_id);
            $data['result']=$this->activity_model->get_activity_by_user($user_id);
            $data['title']=$data['user_infor']['firstname'].",".$data['user_infor']['lastname'];
            $data['user_result']=null;
            $data['array_1']=null;
            $data['result_1']=null;

            foreach($data['result'] as $a_result)
            {
                $data['user_result'][]=$this->activity_model->get_owner_email($a_result['id']);
                $data['result1']=$this->activity_model->check_rel_user_activity($view_user_id,$a_result['id']);
                if($data['result1'] === null)
                {
                    $data['array_1'][]="true";
                }
                else
                {
                    $data['array_1'][]="flase";
                }
            }

            $this->load->view("templates/header",$data);
            $this->load->view("activity/friendactivity",$data);
        }



        public function location($user_id = '0')
        {

              $data['user_id']=$user_id;
              $this->load->helper('form');
              $this->load->library('form_validation');
              $this->form_validation->set_rules('location', 'location', 'required');
              if($this->form_validation->run()==FALSE)
              {
                   $this->load->view("activity/select_location",$data);
              }
              else
              {
                 $location=$this->input->post("location");
                 redirect("activity/create/$location/$user_id");
              }
        }
}

?>
