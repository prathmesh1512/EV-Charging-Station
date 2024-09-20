<html>
    <head>
    <title><?php echo PROJECT_NAME; ?> :: Login</title>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
        <style>
    body{
        background-color: #8bc34a;
        }
.divider:after,
.divider:before {
content: "";
flex: 1;
height: 1px;
background: #eee;
}
.h-custom {
height: calc(100% - 73px);
}
@media (max-width: 450px) {
.h-custom {
height: 100%;
}
}            
        </style>
<section class="vh-100">
    <?php echo $this->session->flashdata('alert_msg');?>       
    <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-12 col-lg-6 col-xl-4 offset-xl-1" style="background-color: #eee; margin-top: 20px;">

            <?php echo form_open_multipart('customer_register'); ?>
          <div class="row">
             <div class="col-md-12">
                 <h2 style="text-align: center;">Registration</h2>
             </div>
             <div class="col-md-12">
               <label for="CustName" class="control-label"> <span class="text-danger">*</span>Name</label>
                <div class="form-group">
                    <input type="text" name="CustName" value="<?php echo $this->input->post('CustName'); ?>" class="form-control " id="CustName" required="required" />
                   <span class="text-danger"><?php echo form_error('CustName');?></span>
               </div>
             </div>
             <div class="col-md-12">
               <label for="CustPass" class="control-label"> <span class="text-danger">*</span>Password</label>
                <div class="form-group">
                  <input type="text" name="CustPass" value="<?php echo $this->input->post('CustPass'); ?>" class="form-control " id="CustPass" required="required" />
                   <span class="text-danger"><?php echo form_error('CustPass');?></span>
               </div>
             </div>
             <div class="col-md-12">
               <label for="CustPhone" class="control-label"> <span class="text-danger">*</span>Phone</label>
                <div class="form-group">
                  <input type="text" name="CustPhone" value="<?php echo $this->input->post('CustPhone'); ?>" class="form-control " id="CustPhone" required="required" />
                   <span class="text-danger"><?php echo form_error('CustPhone');?></span>
               </div>
            </div>
             <div class="col-md-12">
               <label for="CustDOB" class="control-label"> <span class="text-danger">*</span>Date Of Birth</label>
                <div class="form-group">
                  <input type="date" name="CustDOB" value="<?php echo $this->input->post('CustDOB'); ?>" class="form-control " id="CustDOB" required="required" />
                   <span class="text-danger"><?php echo form_error('CustDOB');?></span>
               </div>
             </div>
            <div class="col-md-12">
                <label for="CustAddress" class="control-label"> <span class="text-danger">*</span>Address</label>
                <div class="form-group">
                 <textarea name="CustAddress" class="form-control  " id="CustAddress" required="required"><?php echo $this->input->post('CustAddress'); ?></textarea>
                  <span class="text-danger"><?php echo form_error('CustAddress');?></span>
                </div>
              </div>
             <div class="col-md-12">
               <label for="CustPhoto" class="control-label"> <span class="text-danger"></span>Photo</label>
                <div class="form-group">
                  <input type="file" name="CustPhoto" value="<?php echo $this->input->post('CustPhoto'); ?>" class="form-control " id="CustPhoto" required="required" />
                   <span class="text-danger"><?php echo form_error('CustPhoto');?></span>
               </div>
             </div>
             <div class="col-md-12">
                   <button type="submit" class="btn btn-success">  
                   <i class="fa fa-check"></i> Save 
                        </button> 
            </div>
        </div>
            <?php echo form_close(); ?>
</div>
      </div>
    </div>
</section>     
</html>
