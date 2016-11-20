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

         //user can create its own activity.
         public function create()
         {
            if($this->session->userdata('logged_in'))
            {
                   $session_data = $this->session->userdata('logged_in');
                   $user_id=$session_data['id'];
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
                    $config['placesAutocompleteBoundsMap'] = TRUE;
                    $this->googlemaps->initialize($config);
                    $data['map'] = $this->googlemaps->create_map();


                    if($this->form_validation->run()==FALSE)
                    {
                         $this->load->view('templates/header',$data);
                         $this->load->view('activity/create',array('error' => ' ' ));
                         $this->load->view('templates/footer', $data);
                    }
                    else
                    {
                      $this->load->library('upload', $this->upload_config());
                      if ((isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) && ! $this->upload->do_upload('userfile'))
                      {
                          $error = array('error' => $this->upload->display_errors());
                          $this->load->view('templates/header',$data);
                          $this->load->view('activity/create',$error);
                          $this->load->view('templates/footer', $data);
                        }else{
                         $data = array('upload_data' => $this->upload->data());

                         $this->activity_model->set_activity($user_id,$data['upload_data']);
                         //add the relationship between the new activity and its user.
                         $this->relate_user_with_new_activity($user_id);

                         $suc="success";
                         redirect("activity/index/$suc");
                       }
                     }
            }
            else
            {
                        redirect('user/login','refresh');
            }

         }

          //add the relationship between the new activity and its owner.
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

          //user can delete their own activities.
          public function delete($id = '0')
          {
               if($this->session->userdata('logged_in'))
               {
                       $data['result']=$this->activity_model->remove_activity($id);
                       $suc="delete";
                       redirect("activity/index/$suc");
               }
               else
               {
                      redirect('user/login','refresh');
               }
          }

         //user's main page: they can see their joined activities.
         public function index($suc = null)
         {
              if($this->session->userdata('logged_in'))
              {
                      $session_data=$this->session->userdata('logged_in');
                      $user_id=$session_data['id'];

                      $data['user_result']=null;
                      $data['success']=null;
                      $data['title']="My Activity List";
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
                     //calendar.
                     date_default_timezone_set("America/Vancouver");
                     $this->load->library('calendar');
                     $set=array();
                     foreach($data['result'] as $a_result)
                     {
                        $a_id=$a_result['id'];
                        $date_day=(int)$this->get_date($a_result['date']);
                        $set[$date_day]="http://localhost:9000/index.php/activity/$a_id";
                     }

                     $data['calendar_1']=$this->calendar->generate(strtotime(date('y')),strtotime(date('m')),$set);
                     $this->load->view('templates/header',$data);
                     $this->load->view("activity/index",$data);
                     $this->load->view('templates/footer', $data);
              }
              else
              {
                     redirect('user/login','refresh');
              }

         }

         //google map add mark for activities.
         public function google_map_add_location($user_id='0' , $input=null)
         {
                $data2['coords']=null;
               if($user_id === '0' && $input==null)
               {
                   $data2['coords'] = $this->activity_model->get_coordinates_1();
               }
               else if($user_id === '0'&& $input!=null)
               {
                   $data2['coords'] = $this->activity_model->search_activity($input);
               }
               else
               {
                    $data2['coords'] = $this->activity_model->get_coordinates_singleUser_1($user_id);
               }
               $this->load->library('googlemaps');
               $config['center'] = '8888 University Drive, Burnaby, BC, Canada';
               // config zoom levels
               if(count($data2['coords']) > 1){
                 $config['zoom'] = "auto";
               }else{
                 if(count($data2['coords']) === 1){
                   $config['center'] = $data2['coords'][0]['address'];
                 }
                 $config['zoom'] = "11";
               }

               $this->googlemaps->initialize($config);

               foreach ($data2['coords'] as $coordinate) {
                 $marker = array();
                 $id=$coordinate['id'];
                 $marker['position'] = $coordinate['address'];
                 $marker['title'] = $coordinate['name'];
                 $marker['animation'] = 'DROP';
                 $marker['infowindow_content'] = $coordinate['name']."<br>".$coordinate['date']."<br>".$coordinate['time']."<br><a href=\"".base_url()."activity/".$coordinate['id']."\">show details</a>" ;
                 date_default_timezone_set("America/Vancouver");
                 $activity_time_stamp = strtotime($coordinate['date']." ".$coordinate['time']);
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
        public function showall()
        {
            if($this->session->userdata('logged_in'))
            {
                   $session_data=$this->session->userdata('logged_in');
                   $user_id=$session_data['id'];

                   $data['success']=null;
                   $data['result1']=null;
                   $data['title']="All Activities";
                   $data['result']=$this->activity_model->get_activity();
                   $data['user_id']=$user_id;
                   $data['array_1']=array();
                   $data['user_result']=null;
                   $this->load->helper('form',$data);
                   if($this->input->post('search')==null )
                   {
                         $data['success']="All Activities in database has been shown.";
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
                         $this->load->view('templates/footer', $data);
                   }
                   else
                   {
                           $data['success']="Activities you chose has been shown.";
                           $data['result']=$this->activity_model->search_activity($this->input->post('search'));
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

                           $data["google"]=$this->google_map_add_location('0',$this->input->post('search'));
                           $this->load->view('templates/header',$data);
                           $this->load->view('activity/show_all',$data);
                           $this->load->view('templates/footer', $data);
                   }
           }
           else
           {
                    redirect('user/login','refresh');
           }

        }

        //user can join another user's activities
        public function join($a_id = '0')
        {
            if($this->session->userdata('logged_in'))
            {
                  $session_data=$this->session->userdata('logged_in');
                  $u_id=$session_data['id'];
                  $this->activity_model->set_rel_user_activity($u_id,$a_id);
                  redirect("activity/index/join");
            }
            else
            {
                  redirect('user/login','refresh');
            }
        }

        //user can join to activites when he is in his friend list.
        public function join_friend_activity($a_id, $user_id)
        {
            if($this->session->userdata('logged_in'))
            {
                  $session_data=$this->session->userdata('logged_in');
                  $view_user_id=$session_data['id'];
                  $this->activity_model->set_rel_user_activity($view_user_id,$a_id);
                  redirect("activity/friendactivity/$user_id");
            }
            else
            {
                  redirect('user/login','refresh');
            }

        }

        //user can remove another user's activities off his list.
        public function remove($a_id = '0')
        {
            if($this->session->userdata('logged_in'))
            {
                $session_data=$this->session->userdata('logged_in');
                $u_id=$session_data['id'];
                $this->activity_model->remove_rel_user_activity($u_id,$a_id);
                redirect("activity/index/remove");
            }
            else
            {
                redirect('user/login','refresh');
            }
        }


        public function view($a_id = '0', $suc=null)
        {
              if($this->session->userdata('logged_in'))
              {
                    $session_data=$this->session->userdata('logged_in');
                    $u_id=$session_data['id'];
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $data['friend']=$suc;

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
                      $address = $data['result']['address'];

                      $config['center'] = $address;
                      $config['zoom'] = "15";
                      $this->googlemaps->initialize($config);

                      $marker = array();
                      $marker['position'] = $address;
                      $marker['title'] = $data['result']['name'];
                      $marker['animation'] = 'DROP';
                      $marker['infowindow_content'] = $data['result']['name']."<br>".$data['result']['date']."<br>".$data['result']['time'];
                      date_default_timezone_set("America/Vancouver");

                      $activity_time_stamp = strtotime($data['result']['date']." ".$data['result']['time']);
                      $current_time_stamp = strtotime(date('Y-m-d H:i:s'));

                      if($activity_time_stamp < $current_time_stamp){
                        $marker['icon'] = 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png';
                      }
                      $this->googlemaps->add_marker($marker);

                      $data['map'] = $this->googlemaps->create_map();

                      $this->load->view('templates/header', $data);
                      $this->load->view("activity/view",$data);
                      $this->load->view('templates/footer', $data);
                    }
                    else
                    {
                      $this->activity_model->set_comment();
                      redirect("activity/view/$a_id");
                    }
              }
              else
              {
                    redirect('user/login','refresh');
              }
        }

        public function view_friend_activity($a_id,$u_id)
        {
              if($this->session->userdata('logged_in'))
              {
                          $session_data=$this->session->userdata('logged_in');
                          $view_user_id=$session_data['id'];

                          $this->load->helper('form');
                          $this->load->library('form_validation');
                          $data['view_user_id']=$view_user_id;
                          $data['success']=null;
                          $data['friend']="friend";
                          $this->form_validation->set_rules('comment','Comment','required');
                          if($this->form_validation->run() === FALSE){

                            $data['result']=$this->activity_model->get_activity($a_id);
                            $data['comments']=$this->activity_model->get_comments();
                            $data['title']=$data['result']['name'];
                            $data['user_id']=$u_id;

                            // google map
                            $this->load->library('googlemaps');
                            $address = $data['result']['address'];

                            $config['center'] = $address;
                            $config['zoom'] = "15";
                            $this->googlemaps->initialize($config);

                            $marker = array();
                            $marker['position'] = $address;
                            $marker['title'] = $data['result']['name'];
                            $marker['animation'] = 'DROP';
                            $marker['infowindow_content'] = $data['result']['name']."<br>".$data['result']['date']."<br>".$data['result']['time'];
                            date_default_timezone_set("America/Vancouver");

                            $activity_time_stamp = strtotime($data['result']['date']." ".$data['result']['time']);
                            $current_time_stamp = strtotime(date('Y-m-d H:i:s'));

                            if($activity_time_stamp < $current_time_stamp){
                              $marker['icon'] = 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png';
                            }
                            $this->googlemaps->add_marker($marker);

                            $data['map'] = $this->googlemaps->create_map();

                            $this->load->view('templates/header', $data);
                            $this->load->view("activity/view",$data);
                            $this->load->view('templates/footer', $data);
                          }
                          else
                          {
                            $this->activity_model->set_comment();
                            redirect("activity/view/$a_id/$u_id");
                          }
              }
              else
              {
                    redirect('user/login','refresh');
              }

          }





        public function edit($a_id = '0')
        {
            if($this->session->userdata('logged_in'))
            {
                    $session_data=$this->session->userdata('logged_in');
                    $u_id=$session_data['id'];
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

                    //google map
                    $this->load->library('googlemaps');
                    $config['center'] = '8888 University Drive, Burnaby, BC, Canada';
                    $config['zoom'] = "auto";
                    $config['places'] = TRUE;
                    $config['placesAutocompleteInputID'] = 'myPlaceTextBox';
                    $config['placesAutocompleteBoundsMap'] = TRUE;
                    $this->googlemaps->initialize($config);
                    $data['map'] = $this->googlemaps->create_map();


                    if($this->form_validation->run()==FALSE)
                    {
                         $this->load->view('templates/header',$data);
                         $this->load->view('activity/edit',array('error' => ' ' ));
                         $this->load->view('templates/footer', $data);
                    }
                    else
                    {
                      $this->load->library('upload', $this->upload_config());
                      if ((isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) && ! $this->upload->do_upload('userfile'))
                      {

                        $error = array('error' => $this->upload->display_errors());
                        $this->load->view('templates/header', $data);
                        $this->load->view('activity/edit',$error);
                        $this->load->view('templates/footer', $data);

                        }else{
                         $data = array('upload_data' => $this->upload->data());

                         $this->activity_model->update_activity($a_id,$data['upload_data']);
                         //print_r($data['upload_data']);
                         redirect("activity/view/$a_id/success");
                       }

                    }
            }
            else
            {
                    redirect('user/login','refresh');
            }
        }

        //see freind activities
        public function friendactivity($user_id)
        {

            if($this->session->userdata('logged_in'))
            {
                      $session_data=$this->session->userdata('logged_in');
                      $view_user_id=$session_data['id'];
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
                      $this->load->view('templates/footer', $data);
            }
            else
            {
                  redirect('user/login','refresh');
            }

        }


        public function get_date($a_date=null)
        {

              $sep_date = explode("/",$a_date);
              if(count($sep_date)>1)
              {
                return $sep_date[2];
              }
              else
              {
                 $sep_date = explode("-",$a_date);
                 return $sep_date[2];
              }

        }

        public function upload_config()
        {
                $config['upload_path']          = '/home/ubuntu/static';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                return $config;

        }
}

?>
