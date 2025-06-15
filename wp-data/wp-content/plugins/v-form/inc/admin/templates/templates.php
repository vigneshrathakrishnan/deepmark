<?php
defined('ABSPATH') || die("Nice try");
global $wpdb;

$id = '';
if ( isset($_GET['id']) ) {
    $id = $_GET['id'];  // Get the raw input

    if ( preg_match('/[<>\"\']/', $id) ) {
        wp_die('Invalid input detected.');
      }
  
    $id = sanitize_text_field( $id ); // Sanitize the input
    $id = esc_html( $id );
}
  
$table = $wpdb->prefix . 'vform_templates';

?>

<div class="wrap">

    <form id="myvformdatatempform">
    <?php wp_nonce_field('myvformdatatemp','vfm-noncetemp'); ?>
    </form>

    <?php if($id==''){

        $table_1 = $wpdb->prefix . 'vfsubscr';
        $last_row = $wpdb->get_row( "SELECT id, template_key FROM $table_1 ORDER BY id DESC LIMIT 1" );
        $existing_key = $last_row->template_key;

        $category = isset($_GET['category']) ? $_GET['category'] : 'all';

      // $templates = $wpdb->get_results("SELECT * FROM $table");

      $page = isset($_GET['temppage']) ? intval($_GET['temppage']) : 1;
      $limit = 12;
      // Define the token and API URL

      if($existing_key!=''){
        $api_url = 'https://templates.vform.info/pro_index.php?page=' . $page . '&limit=' . $limit . '&category=' . urlencode($category);
        $auth_token = $existing_key; // Use a secure, random string in production
      }else{
        $api_url = 'https://templates.vform.info/?page=' . $page . '&limit=' . $limit . '&category=' . urlencode($category);
        $auth_token = '2N1ztQ$57Tp6Hqy!g9RAErQbe7e3&'; // Use a secure, random string in production
      }


      // Send POST request
      $response = wp_remote_post($api_url, [
          'method' => 'POST',
          'body'   => [
              'token' => $auth_token,
              'category' => $category
          ],
          'timeout'   => 15,
      ]);

      $templates = [];
      $total_pages = 1;

      if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (!empty($data['status']) && $data['status'] == 1) {
          $templates = $data['data'];
          $total_pages = ceil($data['total'] / $data['limit']);
        }
      } else {
        echo('Template fetch failed.');
      }

    ?>  


    <!-- category -->
     <?php

     
      


        if($existing_key!=''){
          $response = wp_remote_post('https://templates.vform.info/pro_category.php', [
            'body' => ['token' => $existing_key]
          ]);
        }else{
          $response = wp_remote_post('https://templates.vform.info/category.php', [
            'body' => ['token' => '2N1ztQ$57Tp6Hqy!g9RAErQbe7e3&']
          ]);
        }


        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {

          $body = wp_remote_retrieve_body($response);
          $data = json_decode($body, true);
          
          if (!empty($data['status']) && $data['status'] == 1) {
            $Allcategory = $data['data'];
          }

        }
       $currentCategory = isset($_GET['category']) ? urldecode($_GET['category']) : '';
      
        ?>  
        <div class="vf-templates-cat">

          <ul>
            <li>
              <a href="https://vform.info/product/pro-templates/" target="_blank"><span>🔓 Unlock All templates</span></a>
            </li>
            <?php  if(wp_remote_retrieve_response_code($response)===200){ ?>

            <li>
              <a href="admin.php?page=vform_templates&category=all" 
                <?php echo ($currentCategory == 'all') ? 'class="active"' : ''; ?>>
                All templates
                <span><?php echo array_sum(array_column($Allcategory, 'count')); ?></span>
              </a>
            </li>

            <?php foreach ($Allcategory as $catItem): ?>
              <li>
                <a href="admin.php?page=vform_templates&category=<?php echo urlencode($catItem['category']); ?>" 
                  <?php echo ($currentCategory === $catItem['category']) ? 'class="active"' : ''; ?>>
                  <?php echo htmlspecialchars($catItem['category']); ?>
                  <span><?php echo $catItem['count']; ?></span>
                </a>
              </li>
            <?php endforeach; ?>

            <?php } ?>
          </ul>


          <?php


            $unlkey = '';
            if($existing_key!=''){
              $unlkey = '****************';
            }

          ?>
          <div class="vform_unlock">
             <form id="myvformdatatempkey">
              <?php wp_nonce_field('myvformdatatempkey','vfm-noncetempkey'); ?>
              </form>
              <label>Your Unlock key</label>
              <input name="unlocktemp" value="<?php echo $unlkey; ?>" type="password">
              <button id="vfromtemplateunlock">Unlock</button>
          </div>
        </div>

    <!-- category -->


    <div class="vf-templates-list">
      <?php if (!empty($templates)) : ?>
        <?php foreach ($templates as $template) : ?>
          <div class="vf-template-demo-block">
            <div class="vf-thumb-template">
              <a href="admin.php?page=vform_templates&id=<?php echo $template['id']; ?>">
                <img src="<?php echo 'https://templates.vform.info/images/temp-'.$template['id'].'.jpg'; ?>">
              </a>
            </div>
            <div class="vf-content">
              <header class="vf-entry-header">
                <h3 class="vf-entry-title">
                  <a href="javascript:void(0)"><?php echo esc_html($template['name']); ?></a>
                </h3>
              </header>
            </div>
            <div class="vf-actions">
              <a href="javascript:void(0)" data-id="<?php echo $template['id']; ?>" class="button usemytemplate">Use Template</a>
              <a href="admin.php?page=vform_templates&id=<?php echo $template['id']; ?>" target="_blank" class="button button-light-gray">Preview</a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <p>No templates found.</p>
      <?php endif; ?>
    </div>

     <?php

      if ($total_pages > 1) {
          echo '<div class="pagination">';
          for ($i = 1; $i <= $total_pages; $i++) {
              $class = ($i == $page) ? ' class="current-page"' : '';
              echo '<a href="admin.php?page=vform_templates&temppage=' . $i . '&category=' . $category . '"' . $class . '>' . $i . '</a> ';
          }
          echo '</div>';
      }


      ?>

  <?php }else{
  
  
  // $templates = $wpdb->get_results("SELECT * FROM $table");

  $frmvid = intval($id); // Assuming id is an integer
  // $query = "SELECT * FROM $table WHERE id = %d";
  // $templates = $wpdb->get_results($wpdb->prepare($query, $frmvid), OBJECT);


   $table_1 = $wpdb->prefix . 'vfsubscr';
  $last_row = $wpdb->get_row( "SELECT id, template_key FROM $table_1 ORDER BY id DESC LIMIT 1" );
  $existing_key = $last_row->template_key;
 if($existing_key!=''){
    $response = wp_remote_post('https://templates.vform.info/pro_index.php?id='.$frmvid, [
      'body' => ['token' => $existing_key]
    ]);
  }else{
    $response = wp_remote_post('https://templates.vform.info/?id='.$frmvid, [
      'body' => ['token' => '2N1ztQ$57Tp6Hqy!g9RAErQbe7e3&']
    ]);
  }

  $templates = [];

  if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
      // $templates = json_decode(wp_remote_retrieve_body($response));


    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!empty($data['status']) && $data['status'] == 1) {
      $templates = $data['data'];
    }

  }

  if (!empty($templates)){
    foreach ($templates as $template){

  
  ?>


    <style>

      
/* Style the file upload button */
#vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-fileupload .primary-input::file-selector-button {
  padding: 8px 16px;
  background-color: #4a90e2;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  transition: background-color 0.3s ease;
  margin-right: 10px;
}

#vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-fileupload .primary-input {
    border: 1px solid #ccc;
    padding: 8px;
    border-radius: 6px;
    background-color: #f9f9f9;
    cursor: pointer;
    font-size: 14px;
    width: 100%;
    color: #333;
    height: auto !important;
}
#vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-fileupload .primary-input::file-selector-button:hover {
  background-color: #357ab8;
}
      .vform-error {
            border: 2px dotted red !important;
        }
      .vform-group-vform{
          padding: 10px;
          float: left;
          width: 100%;
          transition: .5s ease;
          position: relative;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> input, #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> select {
          height: 40px;
          width: 100%;
          max-width: 100%;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> textarea{
        width:100%;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> * {
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> input[type="radio"], #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> input[type="checkbox"] {
          border: 1px solid #ccc;
          background-color: #fff;
          width: 14px;
          height: 14px;
          min-width: 14px;
          margin: 0 10px 0 3px;
          display: inline-block;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform .primary-input{
        width: 100%!important;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-termscondition > input {
          max-width: 20px!important;
          height: 20px;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.size-small{
          width:33%!important;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.size-medium{
          width:65%!important;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.size-large{
          width:100%!important;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-simple .vform-first-name, #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-combo-middle-last .vform-first-name{
          width: 100%;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-first-last .vform-middle-name, #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-simple .vform-middle-name, #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-simple .vform-last-name{
        display:none;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-first-last .vform-first-name, #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-first-last .vform-last-name{
        width:48%;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-combo-middle-last .vform-middle-name, #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform.format-selected-combo-middle-last .vform-last-name{
          width: 48%;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-main-submit {
          font-size: 16px;
          background: #ddd;
          border: none;
          padding: 8px 20px;
          color: #000;
          cursor: pointer;
          display: inline-block;
          text-align: center;
      }


      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-address p {
          margin: 5px;
          float: left;
          width: 100%;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform .primary-input[name="state_name[]"] {
          max-width: 57%;
          float: left;
          margin-bottom: 2%;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .vform-group-vform .primary-input[name="zip_code[]"] {
          max-width: 40%;
          float: right;
      }

      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?>  .vform-address p:nth-child(6),#vformgroup<?php echo esc_html_e($frmvid,'vform'); ?>  .vform-address p:nth-child(8) {
          display: none;
      }
      #vformgroup<?php echo esc_html_e($frmvid,'vform'); ?> .primary-input:focus {
          outline: none;
      }

      .vform-group-vform input[type=color], .vform-group-vform input[type=date], .vform-group-vform input[type=datetime-local], .vform-group-vform input[type=datetime], .vform-group-vform input[type=email], .vform-group-vform input[type=month], .vform-group-vform input[type=number], .vform-group-vform input[type=password], .vform-group-vform input[type=search], .vform-group-vform input[type=tel], .vform-group-vform input[type=text], .vform-group-vform input[type=time], .vform-group-vform input[type=url], .vform-group-vform input[type=week], select, textarea{
          height: 40px;
          width: 100%;
          max-width: 100%;
          border-radius: 4px;
          border: 1px solid #8c8f94;
          padding: 0 24px 0 8px;
      }
      .vform-group-vform ul.primary-input {
          margin: 0;
          padding: 0px;
          list-style: none;
      }
      .vform-group-vform textarea{
        height: 100px;
      }
      .validate_vform{
        color:red;
        margin: 10px;
        font-size:14px;
        display:none;
      }
      .vfrm-loader {
        position: relative;
        top: -71px;
        left: 0;
        color: orange;
        display: none;
        width: 100%;
        /* display: flex; */
        justify-content: center;
        cursor: no-drop;
      }
      .myallinone-vform {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
      }
      .vf-template-popup .vf-actions, .vf-temp-name {
          text-align: center;
      }
      .vf-temp-name {
          font-size: 22px;
      }
      .vf-btn-outer-temp{
        margin: auto;
        width: 50%;
        margin-bottom: 20px;
      }
    </style>
   

  <div class="vf-template-popup " >
    
    <div class="vf-template-demo-block vf-btn-outer-temp">
      <p class="vf-temp-name"><?php echo esc_html($template['name']); ?></p>
      <h3 class="vf-actions">
          <a href="javascript:void(0)" data-id="<?php echo $template['id']; ?>" class="button usemytemplate">Use Template</a>
          <a href="admin.php?page=vform_templates" data-id="<?php echo $template['id']; ?>" class="button button-light-gray">Back</a>
      </h3>
    </div>

    <form class="myallinone-vform" action="javascript:void(0)" id="vformgroup<?php echo esc_html_e($frmvid,'vform'); ?>">
      <?php
            
            $mainbody = $template['formbody'];
            $mainbody = stripslashes($mainbody);
            $mainbody = html_entity_decode($mainbody);
            $mainbody = str_replace('disabled=""',"",$mainbody);
            $mainbody = str_replace('<div class="vform-cpy-del"><button type="button" class="sc-properties"><i class="fa fa-cog" aria-hidden="true"></i><span>Properties</span></button><button type="button" class="sc-Remove"><i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span></button></div>',"",$mainbody);
            $mainbody = str_replace('<div class="vform-cpy-del dupleftonly"><button type="button" class="sc-Duplicate"><i class="fa fa-clone" aria-hidden="true"></i><span>Duplicate</span></button></div>',"",$mainbody);        
            $mainbody = str_replace('vform-group-active',"",$mainbody);
            $mainbody = str_replace('vform-group',"vform-group-vform",$mainbody);

            $mainbody = str_replace('ui-sortable ui-droppable',"",$mainbody);
            $mainbody = str_replace('ui-sortable-handle',"",$mainbody);
            
            echo html_entity_decode(esc_html($mainbody,'vform')); 
      ?>
    </form>

  </div>
    
  <?php

      }
    }else{
      echo "No Template Found";
    }


  } 

  ?>
  
</div>

<script>
  jQuery(document).ready(function($) {


    $('.usemytemplate').on('click', function() {
     const $btn = $(this);
       $btn.text('Importing...');
      const templateId = $(this).data('id');
        var nonce =  $('#myvformdatatempform').serialize();
      
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: nonce + '&action=vform_import_template&template_id=' + templateId,
        success: function(response) {
          console.log(response);
          
          var res = JSON.parse(response);

          if(res.status==1) {
             $btn.text('Redirecting...');
            window.location.href="admin.php?page=vform&id="+res.id;
          }else {
             $btn.text('Failed');
            // alert('Failed to import: ' + response.data);
          }
        },
        error: function() {
          // alert('AJAX error while importing template.');
        }
      });

    });

    $('#vfromtemplateunlock').on('click', function() {
      var tempkey = $('[name="unlocktemp"]').val();

        var nonce =  $('#myvformdatatempkey').serialize();
      
        $.ajax({
          url: ajaxurl,
          method: 'POST',
          data: nonce + '&action=vform_templatekey&key=' + tempkey,
          success: function(response) {
            console.log(response);
            
            var res = JSON.parse(response);

            if(res.status==1) {
              window.location.reload();
            }else {
              // alert('Failed to import: ' + response.data);
            }
          },
          error: function() {
            // alert('AJAX error while importing template.');
          }
        });

    });


  });
</script>