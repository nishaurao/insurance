<?php get_header(); ?>
<!-- Display Insuarnce policy--->
<div class="container mt-5">
  <div class="row">
    <div class="col-md-10"><h2>List Insurance Policies</h2></div>
    <div class="col-md-2">
      <a href="insurance/single-insurance-policy">
        <button type="button" class="btn btn-primary me-1" >Add Policies</button>
      </a>
    </div>
  </div>
  <?php
    // this is used for pagination
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $args = array(
      'post_type' => 'policy', // custom post slug
      'posts_per_page' => 5, // Display posts per page 
      'paged'          => $paged, // Current page number
    );
    $query = new WP_Query($args);
    $post_count = $query->found_posts;


    // chekcing if posts exist
    if($query->have_posts()) 
        {
          while($query->have_posts()) 
            { 
              $query->the_post();
            ?>
              <div class="card p-1 mt-4 mb-1" style="box-shadow: 0 3px 12px 0 rgba(0,0,0,0.2) !important;">

                <div class="card-body p-2">
                  <div class="row no-gutters">
                    <div class="col-md-8"><strong><?php the_title(); ?></strong></div>
                    <div class="col-md-4">
                      <strong>Policy ID:</strong> <?php echo get_post_meta( get_the_ID(), 'policy_id', true ); ?>
                        |
                      <strong>Live Date:</strong> <?php echo get_post_meta( get_the_ID(), 'live_date', true ); ?>
                    </div>
                  </div> 
                  <div class="row no-gutters">
                    <div class="col-md-12"><?php the_content(); ?></div>
                  </div>
                </div>
              </div>
                <?php
            }
            // Pagination links
            echo paginate_links( array(
              'prev_text' => __( 'Previous', 'textdomain' ),
              'next_text' => __( 'Next', 'textdomain' ),
              'total'     => $query->max_num_pages,
              ) );
              wp_reset_postdata();
    } 
    else {
    // no posts found
    echo 'No policies found.';
    }
?>
</div>



<!----Display Claims ------>
<?php 

if($post_count > 0)
{?>
<div class="container mt-5" >
  <div class="row mb-2">
    <div class="col-md-10"><h2>List Insurance Policy Claims</h2></div>
    <div class="col-md-2">

      <a href="<?php echo esc_url( home_url( '/single-insurance-claim' ) ); ?>">
        <button type="button" class="btn btn-primary me-1" >Add Policies Claim</button>
      </a>
    </div>
</div>
    <div class="row mb-2">
    <div class="col-md-12 ml-3" id="insurance-policy-claims"> </div>
    
    
  </div>

<?php } ?>

<script type="text/javascript">

const perPage = 1; // Number of items per page
const currentPage = 1; // Initial page number
function fetchData(page) 
{
  fetch('<?php echo get_site_url(); ?>/wp-json/wp/v2/policy_claim?_embed&per_page=${perPage}&page=${page}')
  .then(response => {
     
    return response.json();
  })
  .then(data => {
    if (!data || data.length === 0) {
      document.getElementById('insurance-policy-claims').innerHTML = "No Claims Found";
    }
    else
    { 
    const container = document.getElementById('insurance-policy-claims');
    // Create a table element
    const table = document.createElement('table');
    table.classList.add('table', 'table-striped'); // Add Bootstrap table classes

    // Create the table header
    const tableHeader = document.createElement('thead');
    const headerRow = document.createElement('tr');
    headerRow.innerHTML = `
          <th>Claim ID</th>
          <th>Policy Name</th>
          <th>Email</th>
      `;
    tableHeader.appendChild(headerRow);

      // Append the table header to the table
    table.appendChild(tableHeader);

      // Create a table body
    const tableBody = document.createElement('tbody');
     
      // Loop through the data and create table rows
     data.forEach(claim => {
          const row = document.createElement('tr');
          const id = claim.id;
          const title = claim.title;
          const policyId = claim.policy_id;
          const email = claim.email;

          console.log(claim)
          row.innerHTML = `
              <td>`+claim.claim_policy_id+`</td>
              <td>`+claim.title+`</td>
              <td>`+claim.email+`</td>
          `;
          tableBody.appendChild(row);
      });
      // Append the table body to the table
      table.appendChild(tableBody);

      // Append the table to the container
      container.appendChild(table);
  
    } 
  });
    
  }
  fetchData(currentPage);
</script>
</div>
</div>
<?php get_footer(); ?>
