<?php
defined('ABSPATH') || die("Nice try");
global $wpdb;


$frmvid =  $atts['id'];


if(isset($frmvid)){

  $frmvid = intval($frmvid); // Assuming id is an integer
  $query = "SELECT * FROM {$wpdb->prefix}vform WHERE id = %d";
  $vformdata = $wpdb->get_results($wpdb->prepare($query, $frmvid), OBJECT);

  if(!empty($vformdata)){
      
      // $vformdata = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}vform WHERE id='".$frmvid."'", OBJECT );
      foreach ( $vformdata as $keyone=>$valueone ) {

        if($vformdata[$keyone]->status=='true'){

            $mainbody = $vformdata[$keyone]->formbody;
            $mainbody = stripslashes($mainbody);
            $mainbody = html_entity_decode($mainbody);
            $mainbody = str_replace('disabled=""',"",$mainbody);
            $mainbody = str_replace('<div class="vform-cpy-del"><button type="button" class="sc-properties"><i class="fa fa-cog" aria-hidden="true"></i><span>Properties</span></button><button type="button" class="sc-Remove"><i class="fa fa-trash" aria-hidden="true"></i><span>Delete</span></button></div>',"",$mainbody);
            $mainbody = str_replace('<div class="vform-cpy-del dupleftonly"><button type="button" class="sc-Duplicate"><i class="fa fa-clone" aria-hidden="true"></i><span>Duplicate</span></button></div>',"",$mainbody);        
            $mainbody = str_replace('vform-group-active',"",$mainbody);
            $mainbody = str_replace('vform-group',"vform-group-vform",$mainbody);

            $mainbody = str_replace('ui-sortable ui-droppable',"",$mainbody);
            $mainbody = str_replace('ui-sortable-handle',"",$mainbody);

            $sectype = $valueone->security_type==null ? '1': $valueone->security_type;
            $key1 = $valueone->rec_site_key==null ? '': $valueone->rec_site_key;
            $key11 = $valueone->hcap_site_key==null ? '': $valueone->hcap_site_key;

            if($key11!='' && $key11!=null && $sectype=='2'){
              echo '<script src="https://js.hcaptcha.com/1/api.js?hl=en" async defer></script>
              <script type="text/javascript">
              var yourFunction = function () {
                  var widgetID = hcaptcha.render("captcha-1", { sitekey: "'.$key11.'" });
              };
              </script>';
          }

          if($key1!='' && $key1!=null && $sectype=='1'){
              echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
          }

        }

      }



      if (!function_exists('vformget_client_ip')) {
        function vformget_client_ip() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }
    }

    $ip = vformget_client_ip();


      $browser = $_SERVER['HTTP_USER_AGENT'];
    ?>
    <style>

     .fivestar-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        width:100%;
      }

      .fivestar-rating input {
        display: none!important;
      }

      .fivestar-rating label {
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
      }

      /* Highlight stars on hover */
      .fivestar-rating label:hover,
      .fivestar-rating label:hover ~ label {
        color: gold;
      }

      /* Highlight selected stars */
      .fivestar-rating input:checked ~ label {
        color: #ccc; /* Reset */
      }

      .fivestar-rating input:checked + label,
      .fivestar-rating input:checked + label ~ label {
        color: gold;
      }

      .nps-scale {
          display: flex;
          justify-content: flex-start;
          gap: 5px;
          margin-top: 10px;
          flex-direction: row;
          flex-wrap: wrap;
          width: 100%;
      }

      .nps-scale label {
        border: 1px solid #ccc;
        /* padding: 10px 12px; */
        cursor: pointer;
        user-select: none;
        background: #fff;
        font-weight: 500;
        transition: all 0.2s;
      }

      .nps-scale input {
        display: none!Important;
      }

      .nps-scale input:checked + span {
        background-color: #0066cc;
        color: white;
        font-weight: bold;
      }

      .nps-scale label span {
        display: inline-block;
        /* width: 24px; */
        text-align: center;
        padding: 10px 17px;
      }
      .nps-slider-group {
        width: 300px;
        margin: 20px auto;
        font-family: sans-serif;
      }

      .nps-slider{
          width: 100% !important;
          margin-top: 10px;
          border: 2px solid #e2e2e2;
          height: 10px !important;
          border-radius: 8px;
      }

      .slider-value {
        margin-top: 5px;
        font-weight: bold;
        text-align: left;
        /* color: #007bff; */
      }
      
    

      .vform-fileupload .primary-input {
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

      /* Style the file upload button */
      .vform-fileupload .primary-input::file-selector-button {
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

      .vform-fileupload .primary-input::file-selector-button:hover {
        background-color: #357ab8;
      }

      .vform-phone-with-code {
        display: flex;
        gap: 10px;
        width:100%;
      }

      .country-code-select {
        width: 100px!important;
        padding: 5px;
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
        width: 100%;
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






      /* country code */
      .country-dropdown-wrapper {
        position: relative;
        width: 100%;
      }
      .country-search {
        width: 15% !important;
      }
      .country-list {
        position: absolute;
        top: 100%;
        left: 0;
        width: 13%;
        display: none;
        max-height: 180px;
        border: none !important;
        border-radius: 6px;
        overflow-y: auto;
        background-color: #fff;
        padding: 0;
        margin: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        list-style: none;
      }
      .country-list li {
        padding: 10px 12px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s ease;
      }
      .country-list li:hover {
        background-color: #f1f1f1;
      }
      .vform-phone-with-code > div {
          width: 100%;
          margin-top: 0px !important;
      }
      /* country code */

    </style>
    <style>

      .dot-spinner {
        --uib-size: 2.8rem;
        --uib-speed: .9s;
        --uib-color: #183153;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        height: var(--uib-size);
        width: var(--uib-size);
      }

      .dot-spinner__dot {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        height: 100%;
        width: 100%;
      }

      .dot-spinner__dot::before {
        content: '';
        height: 20%;
        width: 20%;
        border-radius: 50%;
        background-color: var(--uib-color);
        transform: scale(0);
        opacity: 0.5;
        animation: pulse0112 calc(var(--uib-speed) * 1.111) ease-in-out infinite;
        box-shadow: 0 0 20px rgba(18, 31, 53, 0.3);
      }

      .dot-spinner__dot:nth-child(2) {
        transform: rotate(45deg);
      }

      .dot-spinner__dot:nth-child(2)::before {
        animation-delay: calc(var(--uib-speed) * -0.875);
      }

      .dot-spinner__dot:nth-child(3) {
        transform: rotate(90deg);
      }

      .dot-spinner__dot:nth-child(3)::before {
        animation-delay: calc(var(--uib-speed) * -0.75);
      }

      .dot-spinner__dot:nth-child(4) {
        transform: rotate(135deg);
      }

      .dot-spinner__dot:nth-child(4)::before {
        animation-delay: calc(var(--uib-speed) * -0.625);
      }

      .dot-spinner__dot:nth-child(5) {
        transform: rotate(180deg);
      }

      .dot-spinner__dot:nth-child(5)::before {
        animation-delay: calc(var(--uib-speed) * -0.5);
      }

      .dot-spinner__dot:nth-child(6) {
        transform: rotate(225deg);
      }

      .dot-spinner__dot:nth-child(6)::before {
        animation-delay: calc(var(--uib-speed) * -0.375);
      }

      .dot-spinner__dot:nth-child(7) {
        transform: rotate(270deg);
      }

      .dot-spinner__dot:nth-child(7)::before {
        animation-delay: calc(var(--uib-speed) * -0.25);
      }

      .dot-spinner__dot:nth-child(8) {
        transform: rotate(315deg);
      }

      .dot-spinner__dot:nth-child(8)::before {
        animation-delay: calc(var(--uib-speed) * -0.125);
      }

      @keyframes pulse0112 {
        0%,
        100% {
          transform: scale(0);
          opacity: 0.5;
        }

        50% {
          transform: scale(1);
          opacity: 1;
        }
      }

    </style>
    <form action="javascript:void(0)" class="myallinone-vform" data-id="<?php echo esc_html_e($frmvid,'vform'); ?>" id="vformgroup<?php echo esc_html_e($frmvid,'vform'); ?>" method="POST" enctype="multipart/form-data">
    <?php echo html_entity_decode(esc_html($mainbody,'vform')); ?>
    <input type='hidden' name="formid" value="<?php echo esc_html_e($frmvid,'vform'); ?>" />
    <input type="hidden" name="ip" value="<?php echo esc_html_e($ip,'vform');?>">
    <input type="hidden" name="browser" value="<?php echo esc_html_e($browser,'vform'); ?>">
    <input type="hidden" name="currentdate" value="<?php echo esc_html_e(date("F j, Y, g:i a"),'vform'); ?>">
    <input type="hidden" name="timezone" value="<?php echo esc_html_e(date_default_timezone_get(),'vform'); ?>">
    <input id="currentdate_part2" type="hidden" name="currentdate_part2" value="">

    <?php wp_nonce_field('myvformfrontsave','vfm-nonce'); ?>
    </form>

    <div class="vfrm-loader" data-id="<?php echo esc_html_e($frmvid,'vform'); ?>">
      <div class="dot-spinner">
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
          <div class="dot-spinner__dot"></div>
      </div>
    </div>

    <div class="confirmation_vform" data-id="<?php echo esc_html_e($frmvid,'vform'); ?>"></div>
    <div class="validate_vform" data-id="<?php echo esc_html_e($frmvid,'vform'); ?>">*Form Fields Are Required!</div>

    <form id="myvformdata7form">
    <?php wp_nonce_field('myvformdata7','vfm-nonce7'); ?>
    </form>

    <script>
      jQuery(function($){
        $(document).ready(function(){

            var userdata1 = new Date();
            var countalltime;
            function chkusertime(Christmas){
                var diffMs = (Christmas - userdata1);
                var diffDays = Math.floor(diffMs / 86400000);
                var diffHrs = Math.floor((diffMs % 86400000) / 3600000);
                var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000);
                var seconds = Math.round(diffMs / (1000) % 60);
                countalltime = {
                  "days":diffDays,
                  "hours":diffHrs,
                  "minute":diffMins,
                  "second":seconds
                };
              }

            $('#currentdate_part2').val(new Date());

            function sanitizeInput(input) {
              return input?.replace(/<[^>]*>/g, '');
            }


            function convertSizeToBytes(sizeText) {
                var sizeUnits = { KB: 1024, MB: 1024 * 1024, GB: 1024 * 1024 * 1024 };
                var unitMatch = sizeText.match(/([0-9.]+)([KMGB]+)$/i);

                if (unitMatch) {
                    var size = parseFloat(unitMatch[1]);
                    var unit = unitMatch[2].toUpperCase();
                    return size * (sizeUnits[unit] || 1);
                }
                return parseInt(sizeText, 10); // Fallback if no unit
            }

            $('#vformgroup<?php echo esc_html_e($frmvid, 'vform'); ?> [type="submit"]').click(function (e) {
                e.preventDefault(); // Prevent form submission by default
                var valid = true;


                // var errorMessages = [];

                // Validate required fields
                var valid = true;
                var formSelector = '#vformgroup<?php echo esc_attr($frmvid); ?>';
                var errorSelector = '.validate_vform[data-id="<?php echo esc_attr($frmvid); ?>"]';

                $(formSelector + ' [required]').each(function () {
                  var $field = $(this);
                  var type = $field.attr('type');
                  var name = $field.attr('name');
                  var isValid = true;

                  if (type === 'checkbox' || type === 'radio') {
                    // Check if at least one checkbox/radio with the same name is checked
                    if ($(`${formSelector} [name="${name}"]:checked`).length === 0) {
                      isValid = false;
                    }
                  } else {
                    if ($field.val().trim() === '') {
                      isValid = false;
                    }
                  }

                  if (!isValid) {
                    valid = false;
                    $field.addClass('vform-error');
                  } else {
                    $field.removeClass('vform-error');
                  }
                });

                if (!valid) {
                  $(errorSelector).show();
                  return false;
                } else {
                  $(errorSelector).hide();
                }


                

                // hCaptcha validation if present
                if (jQuery('.h-captcha').length) {
                    var hcaptchaResponse = document.querySelector('.h-captcha textarea[name="h-captcha-response"]').value;
                    if (hcaptchaResponse === '') {
                        alert('Please complete the hCaptcha.');
                        return;
                    }
                }

                var fileValidationErrors = [];

                // Define a list of disallowed file extensions
                var disallowedFileTypes = ['html', 'htm', 'js', 'css', 'php', 'exe', 'sh', 'bat', 'py', 'rb', 'pl'];


                jQuery('.vform-fileupload').each(function () {
                    var fileInput = jQuery(this).find('.primary-input')[0];

                    // Read constraints for allowed file types and max file size
                    var allowedFileTypes = jQuery(this)
                        .find('input[name^="custom_file_constraints"][name$="[allowed_file_types]"]')
                        .val()
                        .split(',');

                    var maxFileSizeText = jQuery(this)
                        .find('input[name^="custom_file_constraints"][name$="[max_file_size]"]')
                        .val();

                    var maxFileSize = convertSizeToBytes(maxFileSizeText);

                    if (fileInput.files && fileInput.files.length > 0) {
                        for (var i = 0; i < fileInput.files.length; i++) {
                            var file = fileInput.files[i];
                            var fileExtension = file.name.split('.').pop().toLowerCase();

                            // Check if file type is disallowed
                            if (disallowedFileTypes.includes(fileExtension)) {
                                fileValidationErrors.push(`Disallowed file type: ${file.name}`);
                                continue;
                            }

                            // Check file type
                            if (!allowedFileTypes.includes(fileExtension)) {
                                fileValidationErrors.push(`Invalid file type: ${file.name}`);
                            }

                            // Check file size
                            if (file.size > maxFileSize) {
                                fileValidationErrors.push(
                                    `File size exceeds ${maxFileSizeText}: ${file.name}`
                                );
                            }
                        }
                    }
                });

                if (fileValidationErrors.length > 0) {
                    alert(fileValidationErrors.join('\n'));
                    return;
                }

                // Proceed with form data submission
                var vformfrmid = '<?php echo esc_html_e($frmvid, 'vform'); ?>';
                var thfrid = '#vformgroup' + vformfrmid;
                var formData = new FormData();

                var valid_number = false;

                jQuery('.primary-input[type="file"]').each(function () {
                  var inputName = $(this).attr('name');

                  if (this.files && this.files.length > 0) {
                  } else {
                          formData.append('file_empty', '1');
                  }
              });


                
                jQuery('.primary-input').each(function () {
                  var inputName = $(this).attr('name'); // Extract the input field name
                      if (this.files && this.files.length > 0) {
                          for (var i = 0; i < this.files.length; i++) {
                              formData.append(inputName, this.files[i]); // Use the dynamic input name
                          }
                      }

                      var min = parseInt($(this).attr('min'));
                      var max = parseInt($(this).attr('max'));
                      var value = parseInt($(this).val());

                      if (value < min || value > max) {
                        alert('Please enter a number between ' + min + ' and ' + max);
                        valid_number = true;
                      }

                  });
                  
                  if(valid_number){
                    return;
                  }

                var userdata2 = new Date();
                chkusertime(userdata2);
                countalltime = JSON.stringify(countalltime);

                formData.append('action', 'myvformfrontsave');
                formData.append('mainformdata', 'param=save_vform&vfid=' + vformfrmid + '&usertimetakes='+countalltime+'&' + $(thfrid).serialize());

                // Show loader and disable button
                $('.vfrm-loader[data-id="<?php echo esc_html_e($frmvid, 'vform'); ?>"]').css('display', 'flex');
                $(this).attr('disabled', true);

                // Send the AJAX request
                jQuery.ajax({
                    url: ajax_object,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                      var data = jQuery.parseJSON(response);
                        if(data.status==1){
                        // console.log(data);
                        $('.vfrm-loader[data-id="<?php echo esc_html_e($frmvid,'vform'); ?>"]').hide();


                        var res1 = data.confirmation;
                        var res2 = data.confirmation_value;
                        var Title = $('<textarea />').html(res2).text();

                            switch (res1) {
                              case 'message':
                              $('.confirmation_vform[data-id="<?php echo esc_html_e($frmvid,'vform'); ?>"]').html(Title);
                              $('.myallinone-vform[data-id="<?php echo esc_html_e($frmvid,'vform'); ?>"]').remove();
                                break;
                            case 'page':
                              window.location.href="/"+res2;
                              break;
                            case 'redirect':
                              window.location.href=res2;
                              break;
                              case 'redirect_2':
                                var inserted_id = data.inserted_id;
                              window.location.href=res2+'?id='+inserted_id;
                              break;
                              default:
                              $('.confirmation_vform[data-id="<?php echo esc_html_e($frmvid,'vform'); ?>"]').html('Thanks For your Response!');
                              $('.myallinone-vform[data-id="<?php echo esc_html_e($frmvid,'vform'); ?>"]').remove();
                            }

                        }else{
                          alert('!Oops Something went Wrong.');
                        }


                        
                    }
                });
            });

            
            var nonce = $('#myvformdata7form').serialize();
            var vformfrmid ='<?php echo esc_html_e($frmvid,'vform'); ?>';
            var postdata = "action=myvformconversion&param=save_vform&vfid="+vformfrmid+"&ip="+$('[name="ip"]').val()+"&"+nonce;

            jQuery.post(ajax_object,postdata,function(response){

              var data = jQuery.parseJSON(response);
              if(data.status==1){
                // console.log(data);
              }
            });


            // Check if .datetime-input exists
            if (document.querySelector('.datetime-input')) {
                var pluginUrl = pluginData.pluginUrl;

                // Add CSS
                if (!document.querySelector('link[href="' + pluginUrl + 'assets/css/vform-datetimepicker.css"]')) {
                  var link = document.createElement('link');
                  link.rel = 'stylesheet';
                  link.href = pluginUrl + 'assets/css/vform-datetimepicker.css';
                  $('.vform-mainfields-inside').append(link);
                }

                // Add JS
                if (!document.querySelector('script[src="' + pluginUrl + 'assets/js/vform-datetimepicker.js"]')) {
                  var script = document.createElement('script');
                  script.src = pluginUrl + 'assets/js/vform-datetimepicker.js';
                  script.defer = true; // Optional: delay execution until DOM is parsed
                  $('.vform-mainfields-inside').append(script);

                }
              }








        });
      });
    </script>

    <script>
      document.querySelectorAll('.nps-slider').forEach(slider => {
        slider.addEventListener('input', function () {
          const outputId = this.getAttribute('data-target');
          document.getElementById(outputId).textContent = this.value;
        });
      });
    </script>


    
    <!-- country list -->
    
     <script>

        document.addEventListener('DOMContentLoaded', function () {
          if (document.querySelector('.country-search')) {
            if (typeof pluginData !== 'undefined' && pluginData.pluginUrl) {
              const scriptUrl = pluginData.pluginUrl + 'assets/js/countrycodes.js';

              if (!document.querySelector('script[src="' + scriptUrl + '"]')) {
                const script = document.createElement('script');
                script.src = scriptUrl;
                script.type = 'text/javascript';
                script.defer = true;
                document.head.appendChild(script);


                setTimeout(() => {
                    function countryCodeToFlagEmoji(countryCode) {
                      return countryCode.toUpperCase().replace(/./g, char =>
                        String.fromCodePoint(127397 + char.charCodeAt())
                      );
                    }

                    document.querySelectorAll('.vform-phone-with-code').forEach(wrapper => {
                      const input = wrapper.querySelector('.country-search');
                      const list = wrapper.querySelector('.country-list');
                      const selectedCode = wrapper.querySelector('.selected-code');

                      function renderList(filter = '') {
                        list.innerHTML = '';
                        const filterLower = filter.toLowerCase();

                        Object.entries(dialCodes)
                          .filter(([country, code]) =>
                            country.toLowerCase().includes(filterLower) || code.includes(filter)
                          )
                          .forEach(([country, code]) => {
                            const li = document.createElement('li');
                            li.textContent = `${countryCodeToFlagEmoji(country)} ${code} (${country})`;
                            li.onclick = () => {
                              selectedCode.value = code;
                              input.value = '';
                              list.style.display = 'none';
                            };
                            list.appendChild(li);
                          });

                        if (!list.children.length) {
                          const li = document.createElement('li');
                          li.textContent = 'No results found';
                          list.appendChild(li);
                        }
                      }

                      input.addEventListener('input', (e) => {
                        if (input.value.trim() !== '') {
                          list.style.display = 'block';
                          renderList(e.target.value);
                        } else {
                          list.style.display = 'none';
                        }
                      });

                      // Hide list on click outside
                      document.addEventListener('click', function (e) {
                        if (!wrapper.contains(e.target)) {
                          list.style.display = 'none';
                        }
                      });

                      renderList(); // Initial render
                    });
                  }, 50);

              
                }
            } else {
              // console.warn('pluginData is not defined');
            }
          }
        });




         
        </script>
      <!-- country list -->


    <?php
  }else{
    echo "No Vform Found";
  }

}
?>
