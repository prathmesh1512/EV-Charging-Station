<?php 

class Customers extends CI_Controller{
 function __construct()
 {
       parent::__construct();
       if(!$this->session->userdata('authid')){
            redirect('sign-in');
        }                     
      $this->load->model('Customers_model');
 } 
 /*
* Listing of customers
 */
public function index()
{
  try{
      $data['noof_page'] = 0;
     $data['customers'] = $this->Customers_model->get_all_customers();
      $data['_view'] = 'customers/index';
      $this->load->view('layouts/main',$data);
    } catch (Exception $ex) {
      throw new Exception('Customers Controller : Error in index function - ' . $ex);
  }  
}
 /*
  * Adding a new customers
  */
 function add()
 {  
try{
      $params = array(
       'CustName'=> $this->input->post('CustName'),
       'CustPass'=> $this->input->post('CustPass'),
       'CustDOB'=> $this->input->post('CustDOB'),          
       'CustPhone'=> $this->input->post('CustPhone'),
       'CustAddress'=> $this->input->post('CustAddress'),
       'CustBalance'=>'',
        );
       $this->load->library('upload');
       $this->load->library('form_validation');
        $foldername='CustPhoto';
        $fileuploaddire='./resource/'.$foldername;
        $directory=base_url('resource/').$foldername;
        if (!is_dir($fileuploaddire)) {
         mkdir($fileuploaddire, 0777, true);
        }
        $CustPhoto="";
        if (!empty($_FILES['CustPhoto']['name']))
        { 
            $filename =time().$_FILES['CustPhoto']['name'];
            $CustPhoto = str_replace(' ','_',$filename);
            $config['file_name'] = $CustPhoto; 
            $config['upload_path']=$fileuploaddire;
            $config['allowed_types']='pdf|doc|docx|docs|jpg|jpeg|png|';
             $config['max_length']='100000';
            $this->upload->initialize($config);
            if(!$this->upload->do_upload('CustPhoto'))
            {
                $error =$this->upload->display_errors();
                                                    // print_r($error);
                $msg='File Can not Upload ..Please upload pdf |doc |docs|jpg|jpeg|png  type only and Maximum file size 25MB '.$error;
                $this->session->set_flashdata('CustPhoto',$msg);
                 $this->form_validation->set_rules('CustPhoto',$msg,'required');
            }
            else 
            {
            }
        }
        else
        {
               //$this->form_validation->set_rules('CustPhoto','file','required');
                $this->session->set_flashdata('CustPhoto','File required');
        }
        $params['CustPhoto'] =$CustPhoto;
       $this->form_validation->set_rules('CustName','Customer Name','required');
       $this->form_validation->set_rules('CustPass','Customer Pass','required');
       $this->form_validation->set_rules('CustPhone','Customer Phone','required|numeric|exact_length[10]');
       $this->form_validation->set_rules('CustDOB','Customer DOB','required');
       $this->form_validation->set_rules('CustAddress','Customer Address','required');
        if($this->form_validation->run())  
        {  
            $idcustomers= $this->Customers_model->add_customers($params);
            $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully added.</div>');
            redirect('customers/index');
        }
        else
        { 
           $data['_view'] = 'customers/add';
            $this->load->view('layouts/main',$data);
        }
  } catch (Exception $ex) {
    throw new Exception('Customers Controller : Error in add function - ' . $ex);
  }  
 }  
  /*
  * Editing a customers
 */
 public function edit($idcustomers)
 {   
  try{
   $data['customers'] = $this->Customers_model->get_customers($idcustomers);
       $this->load->library('upload');
       $this->load->library('form_validation');
     if(isset($data['customers']['idcustomers']))
      {
        $params = array(
           'CustName'=> $this->input->post('CustName'),
           'CustPass'=> $this->input->post('CustPass'),
           'CustPhone'=> $this->input->post('CustPhone'),
           'CustDOB'=> $this->input->post('CustDOB'),
           'CustAddress'=> $this->input->post('CustAddress'),
            'CustBalance'=>'',
        );
      $foldername='CustPhoto';
      $fileuploaddire='./resource/'.$foldername;
      $directory=base_url('resource/').$foldername;
      if (!is_dir($fileuploaddire)) {
         mkdir($fileuploaddire, 0777, true);
      }
      $CustPhoto="";
      if (!empty($_FILES['CustPhoto']['name']))
      { 
          $filename =time().$_FILES['CustPhoto']['name'];
          $CustPhoto = str_replace(' ','_',$filename);
          $config['file_name'] = $CustPhoto; 
          $config['upload_path']=$fileuploaddire;
          $config['allowed_types']='pdf|doc|docx|docs|jpg|jpeg|png|';
          $config['max_length']='100000';
          $this->upload->initialize($config);
          if(!$this->upload->do_upload('CustPhoto'))
          {
              $error =$this->upload->display_errors();
                                                    // print_r($error);
              $msg='File Can not Upload ..Please upload pdf |doc |docs|jpg|jpeg|png  type only and Maximum file size 25MB '.$error;
              $this->session->set_flashdata('CustPhoto',$msg);
                $this->form_validation->set_rules('CustPhoto',$msg,'required');
              }
              else 
              {
          $pathn=FCPATH.'resource/CustPhoto/'.$data['customers']['CustPhoto'];
         if(is_file($pathn))
           unlink($pathn);   
                $params['CustPhoto'] =$CustPhoto;
              }
       }
       else
       {
        }
               $this->form_validation->set_rules('CustName','CustName','required');
               $this->form_validation->set_rules('CustPass','CustPass','required');
               $this->form_validation->set_rules('CustDOB','Customer DOB','required');               
               $this->form_validation->set_rules('CustPhone','CustPhone','required');
               $this->form_validation->set_rules('CustAddress','CustAddress','required');
         if($this->form_validation->run())  
           {  
           $this->Customers_model->update_customers($idcustomers,$params);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully updated.</div>');
                redirect('customers/index');
           }
           else
          {
              $data['_view'] = 'customers/edit';
              $this->load->view('layouts/main',$data);
          }
  }
  else
  show_error('The customers you are trying to edit does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Customers Controller : Error in edit function - ' . $ex);
  }  
} 
/*
  * Deleting customers
  */
  function remove($idcustomers)
   {
    try{
      $customers = $this->Customers_model->get_customers($idcustomers);
  // check if the customers exists before trying to delete it
       if(isset($customers['idcustomers']))
       {
         $this->Customers_model->delete_customers($idcustomers);
             $this->session->set_flashdata('alert_msg','<div class="alert alert-success text-center">Succesfully Removed.</div>');
          $pathn=FCPATH.'resource/CustPhoto/'.$customers['CustPhoto'];
         if(is_file($pathn))
           unlink($pathn);   
           redirect('customers/index');
       }
       else
       show_error('The customers you are trying to delete does not exist.');
  } catch (Exception $ex) {
    throw new Exception('Customers Controller : Error in remove function - ' . $ex);
  }  
  }
  /*
  * View more a customers
 */
 public function view_more($idcustomers)
 {   
try{
   $data['customers'] = $this->Customers_model->get_customers($idcustomers);
     if(isset($data['customers']['idcustomers']))
      {
              $data['_view'] = 'customers/view_more';
              $this->load->view('layouts/main',$data);
      }
      else
        show_error('The customers you are trying to view more does not exist.');
    } catch (Exception $ex) {
    throw new Exception('Customers Controller : Error in View more function - ' . $ex);
  }  
} 
 /*
* Listing of customers
 */
public function search_by_clm()
{
    $column_name= $this->input->post('column_name');
    $value_id= $this->input->post('value_id');
     $data['noof_page'] = 0;
     $params = array();
    $data['customers'] = $this->Customers_model->get_all_customers_by_cat($column_name,$value_id);
      $data['_view'] = 'customers/index';
      $this->load->view('layouts/main',$data);
}
 /*
* get search values by column- customers
 */
public function get_search_values_by_clm()
{
    $clm_name= $this->input->post('clm_name');
    $value= $this->input->post('value');
    $id= $this->input->post('id');
        $params = array(
        $clm_name=>$value,
        );
           $this->Customers_model->update_customers($id,$params);
   $data['noof_page'] = 0;
  $data['customers'] = $this->Customers_model->get_all_customers();
  $this->load->view('customers/index',$data);
}
 }
