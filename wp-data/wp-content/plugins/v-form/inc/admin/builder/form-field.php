<?php 
$id  = '';

if ( isset($_GET['id']) ) {
    $id = $_GET['id'];
  
    if ( preg_match('/[<>\"\']/', $id) ) {
        wp_die('Invalid input detected.');
      }
  
    $id = sanitize_text_field( $id );
    $id = esc_html( $id );
  }
  ?>
<div id="middle-panel">

    <!-- form page -->
    <div class="vform-mainproperties">
        <button type="button" class="vfmn-properties">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Properties</span></button>
    </div>
    <div id="vform-mainfields" >
        <?php $vfm_formbody = stripslashes($vfm_formbody); echo html_entity_decode($vfm_formbody); ?>
    </div>
    <!-- form page -->
    
</div>