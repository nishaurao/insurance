<?php 
// Register Custom Post Type for policy
function register_custom_post_type() {
    $labels = array(
        'name'               => 'Policy',
    );
    
    $args = array(
        'labels'             => $labels,
        'description'        => 'Custom post type for policies',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'policy' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor' ),
        'register_meta_box_cb' => 'add_custom_fields_for_policy'
    );
    
    register_post_type( 'policy', $args );
}
add_action( 'init', 'register_custom_post_type' );

// Register Custom Post Type for policy claim
function register_custom_post_claim_type() {
    $labels = array(
        'name'               => 'Policy Claim',
    );
    
    $args = array(
        'labels'             => $labels,
        'description'        => 'Custom post type for policies',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'policy_claim' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor' ),
        'register_meta_box_cb' => 'add_custom_meta_claim'
    );
    
    register_post_type( 'policy_claim', $args );
}
add_action( 'init', 'register_custom_post_claim_type' );





// Add Custom Fields for Policy
function add_custom_fields_for_policy() {
    add_meta_box(
        'policy_fields',
        'Policy Details',
        'render_policy_fields',
        'policy',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_custom_fields_for_policy');

// Add Custom Fields for Policy claim

function add_policy_meta_claim() {
    add_meta_box(
        'policy_meta_box',
        'Policy Claim Details',
        'render_policy_meta_claim',
        'policy_claim',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_policy_meta_claim');



function render_policy_meta_claim($post) {
    // Retrieve existing meta values
    $claim_policy_id = get_post_meta($post->ID, 'claim_policy_id', true);
   
    $email = get_post_meta($post->ID, 'email', true);
    // Output form fields
    ?>
     <p>
        <label for="claim_policy_id">Policy ID:</label><br/>
        <input type="number" id="claim_policy_id" name="claim_policy_id" value="<?php echo esc_attr( $claim_policy_id ); ?>" required>
    </p>
    <p>
        <label for="email">Email:  </label><br/>
        <input type="email" id="email" name="email" value="<?php echo esc_attr( $email ); ?>" required>
    </p>

<?php
}




function render_policy_fields() {
    global $post;

    // Output nonce, as well as fields for data input
    wp_nonce_field( basename( __FILE__ ), 'policy_fields_nonce' );

    // Get saved values
    $policy_id = get_post_meta( $post->ID, 'policy_id', true );
    $live_date = get_post_meta( $post->ID, 'live_date', true );

    ?>
   
    <p>
        <label for="policy_id">Policy ID:</label><br/>
        <input type="number" id="policy_id" name="policy_id" value="<?php echo esc_attr( $policy_id ); ?>" required>
    </p>
    <p>
        <label for="live_date">Live Date:</label><br/>
        <input type="date" id="live_date" name="live_date" value="<?php echo esc_attr( $live_date ); ?>" required>
    </p>
    <?php
}




// Save Custom Fields for Policy
function save_custom_fields_for_policy( $post_id ) {
    // Verify nonce
    if ( !isset( $_POST['policy_fields_nonce'] ) || !wp_verify_nonce( $_POST['policy_fields_nonce'], basename( __FILE__ ) ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Sanitize and validate inputs
    $policy_id = isset( $_POST['policy_id'] ) ? sanitize_text_field( $_POST['policy_id'] ) : '';
    $live_date = isset( $_POST['live_date'] ) ? sanitize_text_field( $_POST['live_date'] ) : '';

    if ( empty( $policy_id ) ) {
        wp_die( 'Please enter a policy ID.' );
    }

    // Check for uniqueness of policy_id
    $existing_posts = get_posts( array(
        'post_type'      => 'policy',
        'post_status'    => 'any',
        'meta_key'       => 'policy_id',
        'meta_value'     => $policy_id,
        'posts_per_page' => -1,
        'exclude'        => array( $post_id ),
    ) );

    if ( $existing_posts ) {
        // If policy_id already exists, display an error and prevent saving
        wp_die( 'Policy ID must be unique.' );
    }

    // Save custom fields
    update_post_meta( $post_id, 'policy_id', $policy_id );
    update_post_meta( $post_id, 'live_date', $live_date );
}
add_action( 'save_post', 'save_custom_fields_for_policy' );


     


function handle_insurance_policy_form_submission() {
    if (isset($_POST['policy_name'], $_POST['policy_id'], $_POST['live_date'])) {
        $policyName = sanitize_text_field($_POST['policy_name']);
        $policyID = sanitize_text_field($_POST['policy_id']);
        $liveDate = sanitize_text_field($_POST['live_date']);
        $description = sanitize_textarea_field($_POST['description']);

        // Validate Policy ID as a unique number
        $existing_posts = get_posts(array(
            'post_type' => 'policy',
            'meta_query' => array(
                array(
                    'key' => 'policy_id',
                    'value' => $policyID,
                )
            )
        ));



        if (!empty($existing_posts)) {
            // Handle the error - Policy ID is not unique
            wp_redirect(add_query_arg('submission', 'failed', wp_get_referer()));
            exit;
        }

        // Insert the post
        $post_id = wp_insert_post(array(
            'post_type' => 'policy',
            'post_title' => $policyName,
            'post_content' => $description,
            'post_status' => 'publish',
            'meta_input' => array(
                'policy_id' => $policyID,
                'live_date' => $liveDate,
            ),
        ));

        if ($post_id) {
            // Redirect on successful insertion
            wp_redirect(add_query_arg('submission', 'success', wp_get_referer()));
            exit;
        }
    }

    // Redirect on failure
    wp_redirect(add_query_arg('submission', 'failed', wp_get_referer()));
    exit;
}







// Save Custom Fields for Policy claim
function save_custom_fields_for_claim( $post_id ) {

    // Check nonce
    if ( !isset( $_POST['policy_fields_claim_nonce'] ) || !wp_verify_nonce( $_POST['policy_fields_claim_nonce'], 'save_policy_claim_fields' ) ) {
        return;
    }

    // Check if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions
    if ( isset( $_POST['post_type'] ) && 'policy_claim' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    // Check if the required fields are present and not empty
    if ( empty( $_POST['claim_policy_id'] ) || empty( $_POST['email'] ) ) {
        wp_die( 'Please enter all required fields.' );
    }

    // Sanitize and save custom fields data
    $claim_policy_id = sanitize_text_field( $_POST['claim_policy_id'] );

    // // Check for uniqueness of claim_policy_id
    // $existing_posts = get_posts( array(
    //     'post_type'      => 'policy_claim',
    //     'post_status'    => 'any',
    //     'meta_key'       => 'claim_policy_id',
    //     'meta_value'     => $claim_policy_id,
    //     'posts_per_page' => -1,
    //     'exclude'        => array( $post_id ),
    // ) );

    // if ( $existing_posts ) {
    //     // If claim_policy_id already exists, display an error and prevent saving
    //     wp_die( 'Claim Policy ID must be unique.' );
    // }

    // Update or add claim_policy_id as post meta
        update_post_meta( $post_id, 'claim_policy_id', $claim_policy_id );

    // Sanitize and validate email field
    $email = sanitize_email( $_POST['email'] );
    if ( !is_email( $email ) ) {
        wp_die( 'Invalid email address format. Please enter a valid email address.' );
    }

    // Save the email address as meta data
    update_post_meta( $post_id, 'email', $email );
}

add_action( 'save_post_policy_claim', 'save_custom_fields_for_claim' );









function handle_insurance_policy_claim_form_submission() {
    if (isset($_POST['claim_policy_id'], $_POST['policy_name'], $_POST['email'])) {
        $claimPolicyName = sanitize_text_field($_POST['policy_name']);
        $claimPolicyID = sanitize_text_field($_POST['claim_policy_id']);
        $email = sanitize_text_field($_POST['email']);

        // Validate Policy ID as a unique number
        $existing_posts = get_posts(array(
            'post_type' => 'policy_claim',
            'meta_query' => array(
                array(
                    'key' => 'claim_policy_id',
                    'value' => $claimPolicyID,
                )
            )
        ));

        if (!empty($existing_posts)) {
            // Handle the error - Policy ID is not unique
            wp_redirect(add_query_arg('claimsubmission', 'failed', wp_get_referer()));
            exit;
        }

        // Insert the post
        $post_id = wp_insert_post(array(
            'post_type' => 'policy_claim',
            'post_title' => $claimPolicyName,
            
            'post_status' => 'publish',
            'meta_input' => array(
                'email' => $email,
                'claim_policy_id' => $claimPolicyID,
            ),
        ));

        if ($post_id) {
            // Redirect on successful insertion
            wp_redirect(add_query_arg('claimsubmission', 'success', wp_get_referer()));
            exit;
        }
    }

    // Redirect on failure
    wp_redirect(add_query_arg('claimsubmission', 'failed', wp_get_referer()));
    exit;
}






add_action('admin_post_insurance_policy_form_submit', 'handle_insurance_policy_form_submission');
add_action('admin_post_insurance_policy_claim_form_submit', 'handle_insurance_policy_claim_form_submission');

add_action('admin_post_nopriv_insurance_policy_form_submit', 'handle_insurance_policy_form_submission'); // For logged-out users
add_action('admin_post_nopriv_insurance_policy_claim_form_submit', 'handle_insurance_policy_claim_form_submission');

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function policy_claim_endpoint_callback($data) {
    $args = array(
        'post_type' => 'policy_claim',
        'posts_per_page' => -1,
    );
    $posts = get_posts($args);
    $response_data = array();
    foreach ($posts as $post) {
        $post_data = array(
            'id' => $post->ID,
            'title' => get_the_title($post->ID),
            'claim_policy_id' => get_post_meta($post->ID, 'claim_policy_id', true),
            'email' => get_post_meta($post->ID, 'email', true),
        );
        $response_data[] = $post_data;
    }

    return rest_ensure_response($response_data);
}


add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/policy_claim', array(
        'methods' => 'GET',
        'callback' => 'policy_claim_endpoint_callback',
        'permission_callback' => '__return_true' 
    ));
});