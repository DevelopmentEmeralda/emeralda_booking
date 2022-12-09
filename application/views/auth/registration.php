 <?php $this->load->view('templates/header');?>
 <!-- container --> 
  <section class="showcase">
    <div class="container">
      <div class="pb-2 mt-4 mb-2 border-bottom">
      <center> <h2>BOOKING FORM</h2>
        <img src="https://theemeraldaresort.com/wp-content/uploads/2022/06/cropped-WhatsApp_Image_2021-12-08_at_16.49.54-removebg-preview.png" width=50% height=25%>
        </center>
      </div> 
      <form action="<?php print site_url();?>auth/actionRegister" class="remember-login-frm" id="remember-login-frm" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      <div class="row justify-content-center">
		<div class="col-12 col-md-8 col-lg-6 pb-5">
		<div class="row"><ul style="color: #CB0000"><?php echo validation_errors('<li>', '</li>'); ?></div>
        <!--Form with header-->
            <div class="card border-info rounded-0">
                <div class="card-header p-0">
                    <div class="bg-login-page text-white text-center py-2">
                        <h3>
                            <!-- <i class="fa fa-book"></i>  -->
                        &nbsp;</h3>
                    </div>
                </div>
                <div class="card-body p-3">                
                    <!--Body-->
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-bookmark">&nbsp;</i></div>
                            </div>
                            <input type="text" class="form-control" id="nik-id" name="nik_id" placeholder="NIK *" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input type="text" class="form-control" id="full-name" name="full_name" placeholder="Nama Lengkap *" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-envelope-square"></i></div>
                            </div>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email *" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone-square"></i></div>
                            </div>
                            <input type="text" class="form-control" id="contact-no" name="contact_no" placeholder="Contact No*" required>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fab fa-bitbucket"> </i></div>
                            </div>
                            <select name="cluster" id="cluster" class="form-control" required>
                                <option value="1" disabled>Kingstone (Sold Out)</option>
                                <option value="2">Janet</option>
                                <option value="3">Beryl</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-burn">&nbsp; </i></div>
                            </div>
                            <select name="transaksi" id="transaksi" class="form-control" required>
                                <!-- <option value="volvo">Bertanya</option> -->
                                <option value="2">Reservasi</option>
                                <option value="3">Booking</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Upload KTP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            </div>
                            <input type="file" class="form-control" id="file-ktp" name="file_ktp" placeholder="KTP" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Upload NPWP</div>
                            </div>
                            <input type="file" class="form-control" id="file-npwp" name="file_npwp" placeholder="NPWP"  required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Kode Referal&nbsp;&nbsp;&nbsp;</div>
                            </div>
                            <input type="text" class="form-control" id="ref-code" name="ref_code" placeholder="Kode Referal">
                        </div>
                    </div>
                                                       
                    <div class="text-center">
                        <button type="submit" id="contact-send-a" class="btn btn-info btn-block rounded-0 py-2">Register</button>
                    </div>
                    
                </div>
            </div> 
          </div>
        </div>
    </form>
    </div>
  </section>
 <?php $this->load->view('templates/footer');?>        
