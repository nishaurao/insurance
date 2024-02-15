<?php
/*
Template Name:  single insurance policy 
*/

get_header(); 

?>
<div class="mt-2">
    <?php
if (isset($_GET['submission'])) {
  
    if ($_GET['submission'] == 'success') {
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
            <h3>Add New Insurance Policy</h3>
            <div class="card " data-mdb-input-init>
                <h5 class="text-center mb-4">Insurance Policy</h5>
                <form class="form-card"  action="<?php echo admin_url('admin-post.php'); ?>" method="post">
                    <!-- Add nonce field -->
                    <?php wp_nonce_field( 'save_policy_fields', 'policy_fields_nonce' ); ?>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> 
                            <label class="form-control-label px-3">Policy Name<span class="text-danger"> *</span></label> 
                            <input type="text" id="policy_name" required name="policy_name" placeholder=""  
                            value="<?php echo isset($_POST['policy_name']) ? esc_attr($_POST['policy_name']) : ''; ?>"
                            onblur="validate(1)"> 
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> <label class="form-control-label px-3">Policy ID<span class="text-danger"> *</span></label>
                         <input type="number" id="policy_id" required name="policy_id" placeholder="" 
                         value="<?php echo isset($_POST['policy_id']) ? esc_attr($_POST['policy_id']) : ''; ?>"

                         onblur="validate(2)"> 
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> <label class="form-control-label px-3">Live Date<span class="text-danger"> *</span></label> 
                        <input type="date" id="live_date" required name="live_date" placeholder="" 
                        value="<?php echo isset($_POST['live_date']) ? esc_attr($_POST['live_date']) : ''; ?>"
                        onblur="validate(3)"> 
                    
                    </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex"> <label class="form-control-label px-3">Description<span class="text-danger"> *</span></label> 
                        <textarea rows="5" cols="10" id="description" name="description" placeholder=""
                         onblur="validate(4)"><?php echo isset($_POST['description']) ? esc_attr($_POST['description']) : ''; ?></textarea>
                    </div></div>
                    
                    <div class="row justify-content-end">
                    <input type="hidden" name="action" value="insurance_policy_form_submit">

                        <div class="form-group col-sm-6"> <button type="submit" class="btn-block btn-primary">Submit</button> </div>
                    </div>
                </form>
            </div>
            <?php get_footer(); ?>