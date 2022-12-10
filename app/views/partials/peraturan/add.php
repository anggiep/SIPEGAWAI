<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Peraturan</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="peraturan-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("peraturan/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="jam_masuk">Jam Masuk <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-jam_masuk" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('jam_masuk',""); ?>" type="time" name="jam_masuk" placeholder="Enter Jam Masuk" data-enable-time="true" data-min-date="" data-max-date=""  data-alt-format="H:i" data-date-format="H:i:S" data-inline="false" data-no-calendar="true" data-mode="single" /> 
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="jam_plg">Jam Plg <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="ctrl-jam_plg" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('jam_plg',""); ?>" type="time" name="jam_plg" placeholder="Enter Jam Plg" data-enable-time="true" data-min-date="" data-max-date=""  data-alt-format="H:i" data-date-format="H:i:S" data-inline="false" data-no-calendar="true" data-mode="single" /> 
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="jml_cuti_tahunan">Jml Cuti Tahunan <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-jml_cuti_tahunan"  value="<?php  echo $this->set_field_value('jml_cuti_tahunan',"12"); ?>" type="number" placeholder="Enter Jml Cuti Tahunan" step="1"  required="" name="jml_cuti_tahunan"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="jml_cuti_besar">Jml Cuti Besar <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-jml_cuti_besar"  value="<?php  echo $this->set_field_value('jml_cuti_besar',"12"); ?>" type="number" placeholder="Enter Jml Cuti Besar" step="1"  required="" name="jml_cuti_besar"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="jml_cuti_bersama">Jml Cuti Bersama <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-jml_cuti_bersama"  value="<?php  echo $this->set_field_value('jml_cuti_bersama',"12"); ?>" type="number" placeholder="Enter Jml Cuti Bersama" step="1"  required="" name="jml_cuti_bersama"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="jml_cuti_hamil">Jml Cuti Hamil <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-jml_cuti_hamil"  value="<?php  echo $this->set_field_value('jml_cuti_hamil',"12"); ?>" type="number" placeholder="Enter Jml Cuti Hamil" step="1"  required="" name="jml_cuti_hamil"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="jml_cuti_sakit">Jml Cuti Sakit <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-jml_cuti_sakit"  value="<?php  echo $this->set_field_value('jml_cuti_sakit',"12"); ?>" type="number" placeholder="Enter Jml Cuti Sakit" step="1"  required="" name="jml_cuti_sakit"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="jml_cuti_penting">Jml Cuti Penting <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-jml_cuti_penting"  value="<?php  echo $this->set_field_value('jml_cuti_penting',"12"); ?>" type="number" placeholder="Enter Jml Cuti Penting" step="1"  required="" name="jml_cuti_penting"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="syarat_bulan_cuti_tahunan">Syarat Bulan Cuti Tahunan <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-syarat_bulan_cuti_tahunan"  value="<?php  echo $this->set_field_value('syarat_bulan_cuti_tahunan',"0"); ?>" type="number" placeholder="Enter Syarat Bulan Cuti Tahunan" step="1"  required="" name="syarat_bulan_cuti_tahunan"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="syarat_bulan_cuti_besar">Syarat Bulan Cuti Besar <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-syarat_bulan_cuti_besar"  value="<?php  echo $this->set_field_value('syarat_bulan_cuti_besar',"0"); ?>" type="number" placeholder="Enter Syarat Bulan Cuti Besar" step="1"  required="" name="syarat_bulan_cuti_besar"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="created_at">Created At <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-created_at"  value="<?php  echo $this->set_field_value('created_at',""); ?>" type="text" placeholder="Enter Created At"  required="" name="created_at"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="updated_at">Updated At <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="input-group">
                                                                                            <input id="ctrl-updated_at" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('updated_at',""); ?>" type="datetime"  name="updated_at" placeholder="Enter Updated At" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                <div class="form-ajax-status"></div>
                                                                                <button class="btn btn-primary" type="submit">
                                                                                    Submit
                                                                                    <i class="fa fa-send"></i>
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
