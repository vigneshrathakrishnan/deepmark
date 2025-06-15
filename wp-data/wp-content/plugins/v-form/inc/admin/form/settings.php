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
<div class="modules-V4">


  <div class="modules-contentvf" data-id="1">

    <div class="css-1q091xc">

      <div class="css-0">
        <div class="css-q919xu">
          <div class="css-ubhhzq"><span>
              <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Description</h2>
            </span></div>
          <div class="css-e92bi9">
            <div class="css-qc14rr">

                  <p><i class="fa fa-lightbulb" aria-hidden="true"></i> This will help you identify the type of form.</p>
                  <textarea class="inpt frmtxtarea"
                    name="formdescription"><?php echo esc_html_e($vfm_formdescription,'vform'); ?></textarea>

            </div>
          </div>
        </div>
      </div>

    </div>
  <br>
    <div class="css-1q091xc">
      <div class="css-0">
          <div class="css-q919xu">
            <div class="css-ubhhzq"><span>
                <div class="css-18cy5i1 css-72qqz6-Text cssforstop" data-zds="true">
                   
                <label class="switch mkstatusduplicate">
                      <input type="checkbox" <?php echo $vf_no_duplicate=='true'?'checked="true"':''; ?> >

                      <div>
                          <span></span>
                      </div>
                  </label> 
                  
                  STOP people from duplicating their entries</div>
              </div>
          </div>
        </div>
    </div>

  </div>

  <div class="modules-contentvf" data-id="2">

    <div class="css-1q091xc">

      <div class="css-0">
        <div class="css-q919xu">


          <div class="css-ubhhzq">
            
            <span>
                <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Create Notification</h2>
                <form id="myvformdata10form">
                <?php wp_nonce_field('myvformdata10','vfm-nonce10'); ?>
              </form>
              
            </span>
            </div>

            <div class="">
              <div class="css-qc14rr">
                
                <button id="createnotifibtn" class="createnotifibtn">Create Notification</button>
                  

              </div>


                 <!-- smtp -->
                <div class="css-ubhhzq">
                  <span>
                    <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Add Your SMTP</h2>
                    <p>
                      Didn't receive emails? Use Brevo SMTP instead.
                        <a href="admin.php?page=vform_addon" target="_blank">Click here for free SMTP</a>.
                      </p>

                    
                  </span>
                </div>

                <div class="css-e92bi9">
                    <div class="css-qc14rr">

                    <div class="vf-mail-smtp-mailers">

                      <label class="vf-mail-smtp-mailer vf-mail-smtp-mailer-mail active" name="default">
                        <div class="vf-mail-smtp-mailer-image">
                          <img src="<?php echo VFORM_PLUGIN_URL."assets/images/addon/"; ?>php.svg" alt="Default (none)">
                        </div>
                        <div class="vf-mail-smtp-mailer-text">
                          <input id="vf-mail-smtp-setting-mailer-mail" data-title="Default (none)" type="radio"
                            name="vf-mail-smtp1" value="default" class="js-vf-mail-smtp-setting-mailer-radio-input" checked="checked">
                          Default (none)
                        </div>
                      </label>

                      <label class="vf-mail-smtp-mailer vf-mail-smtp-mailer-sendinblue" name="smtp">
                        <div class="vf-mail-smtp-mailer-image is-recommended">
                          SMTP
                        </div>
                        <div class="vf-mail-smtp-mailer-text">
                          <input id="vf-mail-smtp-setting-mailer-sendinblue" data-title="smttp" type="radio"
                            name="vf-mail-smtp1" value="smtp" class="js-vf-mail-smtp-setting-mailer-radio-input">
                          SMTP
                        </div>
                      </label>

                      <label class="vf-mail-smtp-mailer vf-mail-smtp-mailer-sendinblue" name="gmail">
                      <div class="vf-mail-smtp-mailer-image">
                        Gmail
                      </div>
                      <div class="vf-mail-smtp-mailer-text">
                        <input id="vf-mail-smtp-setting-mailer-gmail" data-title="gmail" type="radio"
                          name="vf-mail-smtp1" value="gmail" class="js-vf-mail-smtp-setting-mailer-radio-input">
                        Gmail
                      </div>
                    </label>



                    </div>

                    <style>
                      .vf-mail-smtp-mailer-image.is-recommended {
                          background-image: url(<?php echo VFORM_PLUGIN_URL."assets/images/addon/"; ?>recommended.svg);
                      }
                    </style>

                    <div id="vf-mail-con" class="vf-mail-smtp-setting-field">


                      <?php
                          global $wpdb;
                          $table = $wpdb->prefix . 'vform_email_accounts';
                          
                          // Get latest SMTP record with no formid
                          $smtp = $wpdb->get_row(
                              "SELECT * FROM $table ORDER BY id DESC LIMIT 1"
                          );
                          
                          // Set variables with fallbacks
                          $host = isset($smtp->smtp_host) ? esc_attr($smtp->smtp_host) : '';
                          $port = isset($smtp->smtp_port) ? esc_attr($smtp->smtp_port) : '';
                          $username = isset($smtp->smtp_username) ? esc_attr($smtp->smtp_username) : '';
                          $password = isset($smtp->smtp_password) ? esc_attr($smtp->smtp_password) : '';
                          $encryption = isset($smtp->smtp_encryption) ? esc_attr($smtp->smtp_encryption) : 'tls';

                          $service_name = isset($smtp->service_name) ? esc_attr($smtp->service_name) : '';

                      ?>

                      
                        <div class="vf-mail-smtp-setting-label">
                          <label>Host</label>
                          <input type="text" name="vf-smtp-host" value="<?php echo $host; ?>">
                        </div>
                        <br>
                        <div class="vf-mail-smtp-setting-label">
                          <label>Port</label>
                          <input name="vf-smtp-port" type="text" value="<?php echo $port; ?>">
                        </div>
                        <br>
                        <div class="vf-mail-smtp-setting-label">
                          <label>Username</label>
                          <input name="vf-smtp-username" type="text" value="<?php echo $username; ?>">
                        </div>
                        <br>
                        <div class="vf-mail-smtp-setting-label">
                          <label>Password</label>
                          <input name="vf-smtp-password" type="password" value="<?php echo $password; ?>">
                        </div>
                        <br>
                        <div class="vf-mail-smtp-setting-label">
                          <label>Encryption</label>
                          <select name="vf-smtp-encryption">
                            <option value="tls" <?php selected($encryption, 'tls'); ?>>tls (Default)</option>
                            <option value="ssl" <?php selected($encryption, 'ssl'); ?>>ssl</option>
                          </select>
                        </div>


                      
                      <form id="myvformdata110form">
                        <?php wp_nonce_field('myvformdata110','vfm-nonce110');
                        ?>
                      </form>

                      <p class="desc">
                        <b>Brevo SMTP help:</b>
                        <br>
                          Follow this link to get your Brevo SMTP details: <a href="https://app.brevo.com/settings/keys/smtp" target="_blank"
                            >Get SMTP</a>. </p>
                      <p class="desc"> Please make sure you setup this wordpress domain with your Brevo (formerly Sendinblue) in domain area. </p>


                    </div>

                    <div id="vf-gmail-con" class="vf-mail-smtp-setting-field">

                        <div class="vf-mail-smtp-setting-label">
                          <label>Your Email</label>
                          <input name="vf-gmail-username" type="text" value="<?php echo $username; ?>">
                          <small> Gmail address</small>
                        </div>
                        <br>
                        <div class="vf-mail-smtp-setting-label">
                          <label>Password</label>
                          <input name="vf-gmail-password" type="password" value="<?php echo $password; ?>">
                          <small> App password (not your Gmail password) <a href="https://vform.info/installing-the-vforms-plugin/" target="_blank">Click here for documentation</a></small>
                        </div>
                        <br>
                    </div>
                    <button id="createsmtpbtn" class="createsmtpbtn">Save Settings</button>

                    <script>
                      const mailers = document.querySelectorAll('.vf-mail-smtp-mailer');

                      mailers.forEach((label) => {
                        label.addEventListener('click', () => {
                          mailers.forEach((l) => l.classList.remove('active'));
                          label.classList.add('active');
                          var name =label.getAttribute('name');
                          if(name=='default'){
                            document.getElementById('vf-mail-con').style.display="none";
                            document.getElementById('vf-gmail-con').style.display="none";
                          }else if(name=='smtp'){
                            document.getElementById('vf-gmail-con').style.display="none";
                            document.getElementById('vf-mail-con').style.display="block";
                          }else if( name=='gmail'){
                            document.getElementById('vf-mail-con').style.display="none";
                            document.getElementById('vf-gmail-con').style.display="block";
                          }
                        });
                      });

                    </script>


                  <?php
                  if($service_name=='gmail'){
                    echo '<script>jQuery(".vf-mail-smtp-mailer[name=\\"gmail\\"]").click();</script>';
                  }else if($service_name!='' && $service_name!='default'){
                    echo '<script>jQuery(".vf-mail-smtp-mailer[name=\\"smtp\\"]").click();</script>';
                  } 
                  ?>
                        

                  </div>
                </div>
                <!-- smtp -->


         
            
            </div>

       



        </div>
      </div>

      <div class="css-0">
        <div class="css-q919xu">
          <div class="css-ubhhzq"><span>
              <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Notifications</h2>
            </span></div>
            <div class="css-e92bi9">
              <div class="css-qc14rr">
                                    
                                    
                    <div class="vform-notifications-general">


                      <input type="hidden" name="vf_formid" value="<?php echo $id; ?>" id="vfromid">
                      <?php

                            $frmid = sanitize_text_field($id);

                            $form_id = intval($frmid); // Assuming formid is an integer
                            $query = "SELECT * FROM {$wpdb->prefix}vform_notifications WHERE formid = %d ORDER BY id DESC";
                            $frmiddata = $wpdb->get_results($wpdb->prepare($query, $form_id), OBJECT);

                            // $frmiddata = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}vform_notifications  WHERE formid='".$frmid."' ORDER BY id DESC", OBJECT );

                            if(count($frmiddata)==0){
                              echo '<p>No Notifications Found.</p>';
                            }

                            foreach ( $frmiddata as $keyedt=>$valueview ) {

                                $vfid = $valueview->id;
                                $actname = $valueview->action_name;
                                $sendemail = $valueview->send_to_email;
                                $fromname = $valueview->from_name;
                                $fromemail = $valueview->from_email;
                                $subject = $valueview->subject;
                                $replyto = $valueview->reply_to;
                                $mode = $valueview->mode;
                                $dropdown = $valueview->dropdown;
                                
                                // $message = $valueview->message;
                                  $decoded = json_decode($valueview->message, true);
                                  $message = preg_replace('/\\\\+/', '', $decoded);
                        
                        ?>

                      <form id="myvformdata11form">
                        <?php wp_nonce_field('myvformdata11','vfm-nonce11'); ?>
                      </form>


                      <form id="myvformdata12form">
                        <?php wp_nonce_field('myvformdata12','vfm-nonce12'); ?>
                      </form>

                      <div id="frm_form_action_2439"
                        class="widget makenotitogglehome frm_form_action_settings frm_single_email_settings <?php echo $dropdown =='1' ? 'open': '' ; ?> ">
                        <form action="javascript:void(0)" class="vf_notiform" data-id="<?php echo $vfid; ?>">
                          <input type="hidden" name="notifiid" value="<?php echo $vfid; ?>">

                          <input type="hidden" name="vf_dropdown" class="vf_dropdown" value="<?php echo $dropdown; ?>">

                          <div class="widget-top">
                            <div class="widget-title-action">
                              <button type="button" class="widget-action makenotitoggle">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z"
                                    fill="#0F0F0F" />
                                </svg>
                              </button>
                            </div>
                            <span class="frm_email_icons alignright">
                              <a href="javascript:void(0)" class="frm_save_form" title="Save">
                                Save <svg width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M4.89163 13.2687L9.16582 17.5427L18.7085 8" stroke="#000000" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                              </a>

                              <a href="javascript:void(0)" data-removeid="frm_form_action_2439" class="frm_remove_form"
                                data-frmverify="Delete this form action?" data-frmverify-btn="frm-button-red" title="Delete">
                                Delete<svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M10 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                  <path d="M14 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                  <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                  <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#000000"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                  <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                              </a>

                              <!-- <label class="switch frm_toggle_block">
                                <input type="checkbox" class="checkbox" name="vf_mode" value="1"
                                  // echo $mode =='1' ? 'checked': '' ; >
                                <div class="slider"></div>
                              </label> -->
                              <label class="switch frm_toggle_block">
                                Status:<span class="myemailstatus"><?php echo $mode =='1' ? 'Active': 'Inactive' ; ?></span>
                                  <input type="checkbox" name="vf_mode" value="1" <?php echo $mode =='1' ? 'checked="true"': '' ; ?> >
                                  <div>
                                      <span></span>
                                  </div>
                              </label>

                            </span>
                            <div class="widget-title">
                              <h4>
                                <span class="frm_form_action_icon frm-outer-circle ">
                                  <svg class="vfrmsvg" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 7.00005L10.2 11.65C11.2667 12.45 12.7333 12.45 13.8 11.65L20 7" stroke="#000000"
                                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="3" y="5" width="18" height="14" rx="2" stroke="#000000" stroke-width="2"
                                      stroke-linecap="round" />
                                  </svg>
                                </span>
                                <span class="sndeml"><?php echo $actname; ?></span>
                              </h4>
                            </div>
                          </div>
                          <div class="widget-inside frminsidetiggle"
                            style="<?php echo $dropdown =='1' ? 'display:block;': '' ; ?> position:relative;">

                            <div style="display:none;" class="vfoptnfield">
                              <ul id="vf_insidefields" class="vf_insidefields-tabs ">
                                <li class="vf_insidefields-tabs active">
                                  <a href="javascript:void(0)" id="vf_insidefields_tab">
                                    Fields </a>
                                </li>
                                <!-- <li class="vf_insidefields-tabs">
                                        <a href="javascript:void(0)" id="vf_insideadv_tab">
                                          Advanced			</a>
                                      </li> -->
                              </ul>
                              <ul class="makesmarttagpos"></ul>
                            </div>

                            <div class="frm_grid_container frm_no_p_margin">
                              <p class="frm6 frm_form_field">
                                <label for="action_post_title_2439" class="frm_help">
                                  Action Name </label>
                                <input type="text" name="action_name" value="<?php echo $actname; ?>" class="large-text  vf_actionname">
                              </p>
                            </div>

                            <p class="frm_has_shortcodes frm_to_row frm_email_row">
                              <label for="email_to_2439" class="frm_help"> Send To Email Address  </label>
                              <span class="frm-with-right-icon">
                                <svg fill="#000000" data-toppos="158" class="frm-show-box" viewBox="0 0 32 32"
                                  enable-background="new 0 0 32 32" id="Glyph" version="1.1" xml:space="preserve"
                                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_" />
                                  <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_" />
                                  <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_" />
                                  </svg>
                                <input type="text" name="email_to" value="<?php echo $sendemail; ?>" class="frm_not_email_to frm_email_blur large-text  frm_help" id="email_to_2439">
                              </span>
                              <small class="martp">(Use comma for multiple email address)</small>
                            </p>



                            <p class="frm_has_shortcodes frm_from_row frm_email_row">
                              <label for="from_2439" class="frm_help">
                                From Name </label>

                              <span class="frm-with-right-icon"><svg fill="#000000" data-toppos="230" class="frm-show-box"
                                  viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="Glyph" version="1.1" xml:space="preserve"
                                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_" />
                                  <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_" />
                                  <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_" />
                                  </svg>
                                <input type="text" name="from_name" value="<?php echo $fromname; ?>"
                                  class="frm_not_email_to frm_email_blur large-text  frm_help" id="from_2439"></span>
                            </p>


                            <p class="frm_has_shortcodes frm_from_row frm_email_row">
                              <label for="from_2439" class="frm_help">
                                From Email</label>

                              <span class="frm-with-right-icon"><svg fill="#000000" data-toppos="304" class="frm-show-box"
                                  viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="Glyph" version="1.1" xml:space="preserve"
                                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_" />
                                  <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_" />
                                  <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_" />
                                  </svg>
                                <input type="email" name="from_email" value="<?php echo $fromemail; ?>"
                                  class="frm_not_email_to frm_email_blur large-text  frm_help" id="from_2439"></span>

                                  <small>(Having issue with {admin_email} try with your domain name like support@mydomain.com)</small>
                            </p>

                            <p class="frm_has_shortcodes frm_from_row frm_email_row">
                              <label for="from_2439" class="frm_help">
                                Reply-To </label>

                              <span class="frm-with-right-icon"><svg fill="#000000" data-toppos="378" class="frm-show-box"
                                  viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="Glyph" version="1.1" xml:space="preserve"
                                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_" />
                                  <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_" />
                                  <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_" />
                                  </svg>
                                <input type="email" name="replyto" value="<?php echo $replyto; ?>"
                                  class="frm_not_email_to frm_email_blur large-text  frm_help" id="from_2439"></span>
                            </p>


                            <p class="frm_has_shortcodes">
                              <label for="email_subject_2439" class="frm_help">
                                Email Subject </label>
                              <span class="frm-with-right-icon"><svg fill="#000000" data-toppos="430" class="frm-show-box"
                                  viewBox="0 0 32 32" enable-background="new 0 0 32 32" id="Glyph" version="1.1" xml:space="preserve"
                                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                  <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_" />
                                  <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_" />
                                  <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_" />
                                  </svg>

                                <input type="text" name="email_subject" class="frm_not_email_subject large-text  frm_help" title=""
                                  id="email_subject_2439" value="<?php
                                   $vfm_sub = stripslashes($subject);
                                    echo $vfm_sub; ?>"></span>
                            </p>

                            <p class="frm_has_shortcodes">
                              <label for="email_message_2439">
                                Message </label>
                            </p>
                            <div id="wp-email_message_2439-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                              <svg fill="#000000" data-toppos="550" class="frm-show-box" viewBox="0 0 32 32"
                                enable-background="new 0 0 32 32" id="Glyph" version="1.1" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_" />
                                <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_" />
                                <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_" /></svg>



                                <?php
                                  $vfm_emailmsg = stripslashes($message);
                                  $vfm_emailvl = html_entity_decode($vfm_emailmsg);
                                $emailvformeditor=$vfm_emailvl; 
                                wp_editor( $emailvformeditor , 'vformmessagetextarea'.$vfid, $settings = array('textarea_name'=>'vform_email_message','editor_height' => 400) ); 
                                ?>
                                
                              <!-- <textarea id="vform-panel-field-notifications-1-message" name="email_message" rows="6" placeholder="" class="inpt"><?php // echo $message; ?></textarea> -->

                            </div>



                            <div style="clear:both;"></div>
                          </div>
                        </form>
                      </div>

                      <?php } ?>





                      <select style="display:none;" id="vform-notification_enable" name="settings[notification_enable]" class="">
                        <option value="1" <?php echo $vf_notifito == 1 ? 'selected="selected"': ''; ?>>On</option>
                        <option value="0" <?php echo $vf_notifito == 0 ? 'selected="selected"': ''; ?>>Off</option>
                      </select>



                   </div>


            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="modules-contentvf" data-id="3">


      <div class="css-1q091xc">
        <div class="css-0">
          <div class="css-q919xu">
            <div class="css-ubhhzq"><span>
                <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Confirmation</h2>
              </span></div>
            <div class="css-e92bi9">
              <div class="css-qc14rr">

                  <div class="vform-builder-settings-block-content">

                      <div id="vform-panel-field-confirmations-1-type-wrap"
                        class="vform-panel-field vform-panel-field-confirmations-type-wrap vform-panel-field-select">
                        <label for="vform-panel-field-confirmations-1-type">Confirmation Type</label>
                        <select id="vform-panel-field-confirmations-1-type" name="settingsconfirmations"
                          class="vform-panel-field-confirmations-type">
                          <option value="message" <?php echo $vfm_confimation=='message' ? 'selected="selected"':''; ?>>Message
                          </option>
                          <option value="page" <?php echo $vfm_confimation=='page' ? 'selected="selected"':''; ?>>Show Page</option>
                          <option value="redirect" <?php echo $vfm_confimation=='redirect' ? 'selected="selected"':''; ?>>Go to URL
                            (Redirect)</option>

                          <option value="redirect_2" <?php echo $vfm_confimation=='redirect_2' ? 'selected="selected"':''; ?>>User
                            Details On Page (Redirect) **New**</option>

                        </select>
                      </div>
                      <div id="vform-panel-field-confirmations-1-message-wrap" class="vform-panel-field  vform-panel-field-textarea"
                        style="">

                        <div class="wp-core-ui wp-editor-wrap tmce-active" id="vform-panel-field1"
                          <?php echo $vfm_confimation!='message' ? 'style="display:none;"':''; ?>>
                          <label for="vform-panel-field-confirmations-1-message">Confirmation Message</label>
                          <?php
                          if($vfm_confimation=='message'){
                            $vfm_formmsg = stripslashes($vfm_confimation_value);
                            $vfm_vl = html_entity_decode($vfm_formmsg);
                          }
                          $contentvformeditor=$vfm_vl; 
                          wp_editor( $contentvformeditor , 'vformtextarea', $settings = array('textarea_name'=>'myvformtextarea','editor_height' => 100) ); ?>
                        </div>

                        <div id="vform-panel-field2" class="vform-panel-field  vform-panel-field-select"
                          <?php echo $vfm_confimation!='page' ? 'style="display:none;"':''; ?>>
                          <label for="vform-panel-field-confirmations-1-page">Confirmation Page</label>
                          <select id="vform-panel-field-confirmations-1-page" name="settings[confirmations][1][page]"
                            class="vform-panel-field-confirmations-page">

                            <?php
                                
                                $mypages = get_pages( array(
                                      'sort_column' => 'post_date',
                                      'sort_order' => 'desc'
                                  ) );

                                  foreach( $mypages as $page )
                                  {
                                      $title = $page->post_title;
                                      $slug = $page->post_name;

                                      $selected = '';
                                      if($vfm_confimation_value==$slug){
                                        $selected = 'selected="selected"';
                                      }
                                      echo "<option ".$selected." value='".esc_html($slug)."'>".esc_html($title)."</option>";
                                  }
                              ?>


                          </select>
                        </div>
                        <?php
                          if($vfm_confimation=='redirect' || $vfm_confimation=='redirect_2'){
                            $vfm_vl3 = $vfm_confimation_value;
                          }
                        ?>
                        <div id="vform-panel-field3" class="vform-panel-field  vform-panel-field-text"
                          <?php echo ($vfm_confimation!='redirect' && $vfm_confimation!='redirect_2') ? 'style="display:none;"':''; ?>>
                          <label for="vform-panel-field-confirmations-1-redirect">Confirmation Redirect URL</label>
                          <input type="text" id="vform-panel-field-confirmations-1-redirect"
                            name="settings[confirmations][1][redirect]" value="<?php echo esc_html_e($vfm_vl3,'vform'); ?>"
                            placeholder="Example: https://example.com/newpage" class="inpt vform-panel-field-confirmations-redirect">
                        </div>


                      </div>
                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>

  </div>

  <div class="modules-contentvf" data-id="4">


  
    <div class="css-1q091xc ">

    <!-- <h2 class="css-18cy5i1 css-1m3mpn4-Text" data-zds="true">Integrations</h2> -->


        <div class="css-0">
              <div class="css-q919xu">
                <div class="css-ubhhzq"><span>
                    <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Which integration do you want?</h2>
                    <form id="myvformdata9form">
                      <?php wp_nonce_field('myvformdata9','vfm-nonce9'); ?>
                    </form>
                    
                  </span></div>
                  <div class="css-e92bi9">
                    <div class="css-qc14rr">
                      
                        <input type="text" placeholder="" name="integrationrequest" id="integrationrequest">

                        <a href="javascript:void(0)" id="iwantintegration">Send</a>
                        <br>
                        <p class="thankssubm">Thanks your submission is received!</p>

                  </div>
                </div>
              </div>
            </div>
          </div>

        <div>




        <div class="css-1u3f5ze">

          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Email Notification</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>
         
          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">reCAPTCHA/hcaptcha</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">File Upload</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Elementor</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Google Sheet</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

  
        </div>

        <div class="css-1u3f5ze">

          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Conditional Logic</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

          <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">SMTP</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

           <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Webhook</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

           <div class="css-g3razn active">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Zapier</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Active</span></div>
          </div>

          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Paypal</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>

        
          

         
  
        </div>

        <div class="css-1u3f5ze">


          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Slack</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>

         
          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Geo location</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>
          
          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Multi Step Form</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>


          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Survey</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>

          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Active Campaign</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>
  
        </div>

        <div class="css-1u3f5ze">


          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Multi Language</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>
          <div class="css-g3razn">
          <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Gmail</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>

          </div>

          <div class="css-g3razn">
            <div class="css-8ei2ja"><span aria-hidden="true" data-testid="iconContainer" data-zds="true"
                class="css-1i2f4ge-Icon--miscBoltAltFill--animate--24x24--BrandOrange"><svg
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24" size="24"
                  color="BrandOrange" name="miscBoltAltFill">
                  <path fill="#2D2E2E" d="M9 23.66 20.54 9.91H15V.16L3.46 13.91H9v9.75Z"></path>
                </svg></span></div>
            <div class="css-veo0af"><span class="css-48jybu">Stripe</span><span class="css-okrdsg css-1kp0zmh-Text"
                data-zds="true">Coming Soon</span></div>
          </div>
          <div class="css-g3razn" style="opacity:0;"></div>
          <div class="css-g3razn" style="opacity:0;"></div>

         
        </div>
        

    </div>
    <!-- css-1q091x -->


  </div>

  <div class="modules-contentvf" data-id="5">




      <div class="css-1q091xc">
          <div class="css-0">
            <div class="css-q919xu">
              <div class="css-ubhhzq"><span>
                  <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Shortcode For Form <a href="https://wordpress.com/support/wordpress-editor/blocks/shortcode-block/"
                    target="_blank"><svg class="adjstsvg" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20"
                      viewBox="0 0 30 30">
                      <path
                        d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,21h-2v-7h2V21z M15,11.5 c-0.828,0-1.5-0.672-1.5-1.5s0.672-1.5,1.5-1.5s1.5,0.672,1.5,1.5S15.828,11.5,15,11.5z">
                      </path>
                    </svg></a>
                  </h2>
                </span></div>
              <div class="css-e92bi9">
                <div class="css-qc14rr">

                <input type="text" class="vformembed" id="vformembed" value="[vform id=<?php echo $id; ?>]" readonly
                  style="user-select: none; cursor: not-allowed;">
                <button type="submit" class="button" id="copyembed">Copy</button>

                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="css-1q091xc mertop">
          <div class="css-0">
            <div class="css-q919xu">
              <div class="css-ubhhzq"><span>
                  <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Shortcode For User Detail on page <a href="javascript:void(0)" id="userpagehint"><svg class="adjstsvg"
                        xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" viewBox="0 0 30 30">
                        <path
                          d="M15,3C8.373,3,3,8.373,3,15c0,6.627,5.373,12,12,12s12-5.373,12-12C27,8.373,21.627,3,15,3z M16,21h-2v-7h2V21z M15,11.5 c-0.828,0-1.5-0.672-1.5-1.5s0.672-1.5,1.5-1.5s1.5,0.672,1.5,1.5S15.828,11.5,15,11.5z">
                        </path>
                      </svg></a>
                  </h2>
                </span></div>
              <div class="css-e92bi9">
                <div class="css-qc14rr">

                <input type="text" class="vformembed" id="vformembed2" value="[vform_userdetails]" readonly
                    style="user-select: none; cursor: not-allowed;">
                  <button type="submit" class="button" id="copyembed2">Copy</button>

                  <a href="https://youtu.be/8tmUAOXe-c0?si=0LaUjoowbudb6Atd"  class="vewdm" target="_blank">View Demo</a>


                </div>
              </div>
            </div>
          </div>
      </div>
        
      <script>
        document.getElementById("copyembed").addEventListener("click", function () {
          var input = document.getElementById('vformembed');
          input.select(); // Select the text in the input field
          document.execCommand("copy"); // Copy the selected text
        });


        document.getElementById("copyembed2").addEventListener("click", function () {
          var input = document.getElementById('vformembed2');
          input.select(); // Select the text in the input field
          document.execCommand("copy"); // Copy the selected text
        });
      </script>




  </div>

  <div class="modules-contentvf" data-id="6">

    <?php

      $id = intval($id); // Assuming id is an integer
      $query = "SELECT * FROM {$wpdb->prefix}vform WHERE id = %d";
      $vfsec = $wpdb->get_results($wpdb->prepare($query, $id), OBJECT);


      // $vfsec = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}vform WHERE id = '{$id}'", OBJECT );
      foreach ( $vfsec as $key1=>$val1 ) {
        $sectype = $val1->security_type==null ? '1': $val1->security_type;
        $key1 = $val1->rec_site_key==null ? '': $val1->rec_site_key;
        $key2 = $val1->rec_secret_key==null ? '': $val1->rec_secret_key;
        $key11 = $val1->hcap_site_key==null ? '': $val1->hcap_site_key;
        $key22 = $val1->hcap_secret_key==null ? '': $val1->hcap_secret_key;
      }
    ?>


      <div class="css-1q091xc">
          <div class="css-0">
            <div class="css-q919xu">
              <div class="css-ubhhzq"><span>
                  <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Security</h2>
                </span></div>
              <div class="css-e92bi9">
                <div class="css-qc14rr">

                                
                    <div>
                      <ul class="secure-ul">
                        <li class="<?php echo $sectype=='1' || null ? 'active': ''; ?> fr" data-id="1">
                          <img src="<?php echo VFORM_PLUGIN_URL; ?>/assets/images/g-cap.png">
                          reCAPTCHA
                        </li>
                        <li class="sec <?php echo $sectype=='2' ? 'active': ''; ?>" data-id="2">
                          <img src="<?php echo VFORM_PLUGIN_URL; ?>/assets/images/h-cap.png">
                          hcaptcha
                        </li>
                      </ul>
                    </div>


                 <!-- recaptcha -->
                    <div class="g-recapcont">

                        <form id="myvformdata13form">
                          <?php wp_nonce_field('myvformdata13','vfm-nonce13'); ?>
                        </form>

                        <div class="grec-description"
                          <?php echo $sectype=='1' || null ? 'style="display:block;"': 'style="display:none;"'; ?>>
                          <p class="re-main">reCAPTCHA Settings</p>
                          <p>VForms integrates with reCAPTCHA, a complimentary CAPTCHA service that employs an advanced risk analysis
                            engine and adaptive challenges to prevent automated software from engaging in abusive activities on your site.
                            These settings are required only if you decide to use the reCAPTCHA field. <a
                              href="https://www.google.com/recaptcha/admin/create" target="_blank">Get your reCAPTCHA Keys.</a>
                          </p>

                          <p style="color:red;">Note: Please use v2 site and secret key ("I'm not a robot" Checkbox)</p>

                          <div class="re-form">
                            <label for="">Site Key</label>
                            <input type="text" id="rec_site_key" value="<?php echo $key1; ?>">
                          </div>

                          <div class="re-form">
                            <label for="">Secret Key</label>
                            <input type="password" id="rec_secret_key" value="<?php echo $key2; ?>">
                          </div>
                        </div>



                        <div class="hrec-description" <?php echo $sectype=='2' ? 'style="display:block;"': 'style="display:none;"'; ?>>
                          <p class="re-main">hCaptcha Settings</p>
                          <p>VForms integrates with hCaptcha, a complimentary CAPTCHA service that employs an advanced risk analysis
                            engine and adaptive challenges to prevent automated software from engaging in abusive activities on your site.
                            These settings are required only if you decide to use the hCaptcha field. <a
                              href="https://dashboard.hcaptcha.com/sites/new" target="_blank">Get your hCaptcha Keys.</a>
                          </p>

                          <div class="re-form">
                            <label for="">Site Key</label>
                            <input type="text" id="hcap_site_key" value="<?php echo $key11; ?>">
                          </div>

                          <div class="re-form">
                            <label for="">Secret Key</label>
                            <input type="password" id="hcap_secret_key" value="<?php echo $key22; ?>">
                          </div>
                        </div>



                        <input type="hidden" name="whichsecurity" value="<?php echo $sectype; ?>">
                        <button class="g-saveform">Save Settings</button>
                    </div>


                </div>
              </div>
            </div>
          </div>
      </div>

      
  </div>
    
  <!-- 7 -->
  <div class="modules-contentvf" data-id="7">

    <!-- start -->
    <div class="css-1q091xc">
      <div class="css-0">
            <div class="css-q919xu">
              <div class="css-ubhhzq">
                <span>
                  <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Conditional Logic</h2>
                </span>
              </div>

              <div class="css-e92bi9">

                  <div id="logic-container2">
                      <button id="add-logic-group">Add New Logic Group</button>

                      <button id="save-logic">Save Logic</button>
                  </div>
                  
            </div>

          </div>


          <!-- end -->
            
          <!-- <script>
              
          </script> -->

      </div>

      <div class="css-0">
        <div id="logic-container"></div>
      </div>

    </div>
    
  </div>
  <!-- 7 -->

  <!-- 8 -->
  <div class="modules-contentvf" data-id="8">

    <!-- start -->
    <div class="css-1q091xc">
      <div class="css-0">
            <div class="css-q919xu">
              <div class="css-ubhhzq">
                <span>
                  <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Collect Payments Via Stripe or Paypal</h2>
                </span>
              </div>

              <div class="css-e92bi9">

                  <div id="logic-container2">
                      <button id="add-logic-group" style="opacity:0;">sa</button>

                      <div class="upgradenotice">
                          <button id="save-logic">Add Payment Gateway</button>
                      </div>
                  </div>
                  
            </div>

          </div>


          <!-- end -->
      

      </div>

      <div class="css-0">
        <div id="logic-container"></div>
      </div>

    </div>
    
  </div>
  <!-- 8 -->

  <!-- 9 -->
  <div class="modules-contentvf" data-id="9">

    <div class="css-1q091xc" style="grid-template-columns: auto;">
        <div class="css-0">
          <div class="css-q919xu">
            <div class="css-ubhhzq"><span>
                <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Google Sheet</h2>
              </span></div>
            <div class="css-e92bi9">
              <div class="css-qc14rr">

              
              <?php

                $id = intval($id); // Assuming id is an integer
                $query = "SELECT * FROM {$wpdb->prefix}vform WHERE id = %d";
                $vfsec = $wpdb->get_results($wpdb->prepare($query, $id), OBJECT);


                foreach ( $vfsec as $key1=>$val1 ) {
                  $key = $val1->google_sheet=='' ? '': $val1->google_sheet;
                }
                ?>

                  <div class="widefat">

                        <form id="myvformdata133form">
                          <?php wp_nonce_field('myvformdata133','vfm-nonce133'); ?>
                        </form>

                      <div class="grec-description">
                        <p class="re-main">Google Sheet Settings</p>
                        <p>Please check the video before processing.</p>
                        <a href="https://youtu.be/XZIriOPAaqc" target="_blank">Watch the video</a><br>
                        <a href="<?php echo VFORM_PLUGIN_URL; ?>/assets/js/google_app_script_code_vform.txt" download>Download Your Script</a>

                        <div class="re-form">
                          <label for="">Google Apps Script Url</label>
                          <input type="text" id="google_apps_script" value="<?php echo $key; ?>">
                        </div>

                      </div>


                      <button class="gapps-saveform">Save Settings</button>
                  </div>


              </div>
            </div>
          </div>
        </div>
    </div>

    
  </div>
  <!-- 9 -->

  <!-- 10 -->
  <div class="modules-contentvf" data-id="10">

    <div class="css-1q091xc" style="grid-template-columns: auto;">
        <div class="css-0">
          <div class="css-q919xu">
            <div class="css-ubhhzq"><span>
                <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Webhook</h2>
              </span></div>
            <div class="css-e92bi9">
              <div class="css-qc14rr">

              
              <?php

                $id = intval($id); // Assuming id is an integer
                $query = "SELECT * FROM {$wpdb->prefix}vform WHERE id = %d";
                $vfsec = $wpdb->get_results($wpdb->prepare($query, $id), OBJECT);

                foreach ( $vfsec as $key1=>$val1 ) {
                  $webhook_auth = $val1->webhook_auth;
                  $webhook_auth_type = $val1->webhook_auth_type;
                  $webhook_auth_key = $val1->webhook_auth_key;
                  $webhook_auth_secret = $val1->webhook_auth_secret;

                  $key = $val1->webhook_url=='' ? '': $val1->webhook_url;
                }
                ?>

                  <div class="widefat">

                        <form id="myvformdata1331form">
                          <?php wp_nonce_field('myvformdata1331','vfm-nonce1331'); ?>
                        </form>

                      <div class="grec-description">
                        <div class="re-form">
                          <label for="">
                              Webhook Url

                               <input type="checkbox" name="webhook_auth" value="<?php echo $webhook_auth ? $webhook_auth : '' ?>" class=" ms-4" <?php echo $webhook_auth ? 'checked' : '' ?> id="useAuthCheckbox">
                                <label class="form-check-label" for="useAuthCheckbox">Use Authentication</label>

                          </label>
                          <input type="text" id="vform_webhook_url" value="<?php echo $key; ?>">
                        </div>
                      </div>


                        <!-- Use Authentication -->
                        <div id="webhookAuthFields" <?php echo $webhook_auth=='1' ? 'style="display: block;"' : 'style="display: none;"' ?> >
                            <div class="mb-3">
                                <label class="form-label">Webhook Auth Type</label>
                                <select name="webhook_auth_type" class="form-control" id="authTypeSelect">
                                    <option value="">None</option>
                                    <option <?php echo $webhook_auth_type=='bearer' ? 'selected' : '' ?> value="bearer">Bearer Token</option>
                                    <option <?php echo $webhook_auth_type=='basic' ? 'selected' : '' ?> value="basic">Basic Auth</option>
                                    <option <?php echo $webhook_auth_type=='custom' ? 'selected' : '' ?> value="custom">Custom Header</option>
                                </select>
                            </div>

                            <div class="mb-3" id="authKeyGroup" <?= $webhook_auth_type=='bearer' ? 'style="display: none;"' : 'style="display: block;"' ?> >
                                <label class="form-label">Auth Key / Username</label>
                                <input type="text" name="webhook_auth_key" value="<?= $webhook_auth_key ? $webhook_auth_key : '' ?>" class="form-control">
                            </div>

                            <div class="mb-3" id="authSecret">
                                <label class="form-label">Auth Secret / Token / Header Value</label>
                                <input type="text" name="webhook_auth_secret" value="<?= $webhook_auth_secret ? $webhook_auth_secret : '' ?>" class="form-control">
                            </div>
                        </div>
                        <!-- Use Authentication -->

                        

                      <button class="webhook-saveform">Save Settings</button>
                  </div>


              </div>
            </div>
          </div>
        </div>
    </div>


    
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById("useAuthCheckbox");
        const authFields = document.getElementById("webhookAuthFields");
        const authTypeSelect = document.getElementById("authTypeSelect");
        const authKeyGroup = document.getElementById("authKeyGroup");
        const authSecret = document.getElementById("authSecret");
        

        function toggleAuthFields() {
            authFields.style.display = checkbox.checked ? "block" : "none";
        }

        function toggleAuthKey() {
            const type = authTypeSelect.value;
            authSecret.style.display = "block";

            if (type === "basic" || type === "custom") {
                authKeyGroup.style.display = "block";
            }else if(type === ""){
                authSecret.style.display = "none";
                authKeyGroup.style.display = "none";
            } else {
                authKeyGroup.style.display = "none";
            }
        }

        checkbox.addEventListener("change", toggleAuthFields);
        authTypeSelect.addEventListener("change", toggleAuthKey);

        // Initialize visibility on load
        toggleAuthFields();
        toggleAuthKey();

    });
</script>

    
  </div>
  <!-- 10 -->

   <!-- 11 -->
  <div class="modules-contentvf" data-id="11">

    <div class="css-1q091xc" style="grid-template-columns: auto;">
        <div class="css-0">
          <div class="css-q919xu">
            <div class="css-ubhhzq">
              <span>
                <h2 class="css-18cy5i1 css-72qqz6-Text" data-zds="true">Zapier</h2>
              </span>
            </div>
            <div class="css-e92bi9">
              <div class="css-qc14rr">

              
              <?php
                  function vform_generate_api_key() {
                      $api_key = get_option('vform_api_key');
                      if (!$api_key) {
                          $api_key = bin2hex(random_bytes(16)); // 32-character key
                          update_option('vform_api_key', $api_key);
                      }
                      return $api_key;
                  }
                  $api_key = vform_generate_api_key();

                  function getSiteUrl() {
                      $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || 
                                  $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                      
                      $host = $_SERVER['HTTP_HOST'];
                      
                      return $protocol . $host;
                  }

                ?>

                  <div class="widefat">

                      <div class="grec-description">
                        <div class="re-form">
                            Do more with Vform integrations <a href="https://zapier.com/apps/vform/integrations" target="_blank">Search Paring app in zapier</a>
                        </div>
                      </div>

                  </div>
                  <div class="widefat">

                      <div class="grec-description">
                        <div class="re-form">
                          <label for="">API Key</label>
                          <input type="text" disabled  value="<?php echo $api_key; ?>">
                        </div>
                      </div>

                  </div>
                  <div class="widefat">

                      <div class="grec-description">
                        <div class="re-form">
                          <label for="">Site Key</label>
                          <input type="text" disabled  value="<?php echo getSiteUrl(); ?>">
                        </div>
                      </div>

                  </div>
                  


              </div>
            </div>
          </div>
        </div>
    </div>

    
  </div>
  <!-- 10 -->

<link rel="stylesheet" id="conditional-logic-admin" href="<?php echo VFORM_PLUGIN_URL."assets/css/conditional-logic-admin.css?ver=".VFORM_PLUGIN_VERSION; ?>" >



<script src="<?php echo VFORM_PLUGIN_URL."assets/js/conditional-logic-admin.js?ver=".VFORM_PLUGIN_VERSION; ?>"></script>