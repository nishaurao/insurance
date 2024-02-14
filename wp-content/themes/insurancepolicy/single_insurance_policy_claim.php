<?php
/*
Template Name: Insurance Policy Claim
*/

get_header(); 
?>

<div class="mt-2">
    <?php
if (isset($_GET['claimsubmission'])) {
   
    if ($_GET['claimsubmission'] == 'success') {
        echo '
        <div class="alert alert-success" role="alert">
            Insurance Policy Claim submitted successfully.
        </div>';
        
    } else {
        echo '<div class="alert alert-danger" role="alert">Claim Submission failed. Please ensure all fields are correctly 
        filled and the Policy ID is unique.</div>';
    }
}

?>
</div>


<div class="container-fluid px-1 py-5 mx-auto mdb-docs-layout">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
            <h3>Add New Insurance Claim</h3>
            <div class="card " data-mdb-input-init>
                <h5 class="text-center mb-4">Insurance Claim</h5>
                <form class="form-card"  action="<?php echo admin_url('admin-post.php'); ?>" method="post">

                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> 
                        <label class="form-control-label px-3">Claim Policy ID<span class="text-danger"> *</span></label>
                         <input type="number" id="claim_policy_id" required name="claim_policy_id" placeholder="" onblur="validate(1)"> </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> 
                        <label class="form-control-label px-3">Policy Name<span class="text-danger"> *</span></label>
                         <input type="text" id="policy_name" required name="policy_name" placeholder="" onblur="validate(2)"> </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> 
                        <label class="form-control-label px-3">Email<span class="text-danger"> *</span></label> 
                        <input type="email" id="email" required name="email" placeholder="" onblur="validate(3)"> </div>
                    </div>
                    
                    
                    <div class="row justify-content-end">
                    <input type="hidden" name="action" value="insurance_policy_claim_form_submit">
                        <div class="form-group col-sm-6"> <button type="submit" class="btn-block btn-primary">Submit</button> </div>
                    </div>
                </form>
            </div>



