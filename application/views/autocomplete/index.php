<?php
$this->load->view('templates/header');
?>
<script src="<?php echo HTTP_JS_PATH; ?>typeahead.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h2>Autocomplete Search with Dynamic Data using CodeIgniter and Bootstrap Typeahead</h2>                 
    </div>
</div>

<div class="row">
    <div class="col-lg-12">        
        <a href="#" class="pull-right btn btn-info btn-xs" style="margin: 2px;"><i class="fa fa-mail-reply"></i> Back To Tutorial</a>                
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12">
        <span id="success-msg"></span>
    </div>
</div>
 <form class="dynamic-autocomplete-frm" id="dynamic-dependent-frm">
    <input type="hidden" name="autocomplete" id="field-autocomplete">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <input type="text" name="add_autocomplete" class="form-control" id="add-autocomplete" placeholder="Enter Country Name">
            </div>
        </div>
    </div>

</form>
<?php
$this->load->view('templates/footer');
?>