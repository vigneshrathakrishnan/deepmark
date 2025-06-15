<?php
defined('ABSPATH') || die("Nice try");


register_activation_hook(VFORM_PLUGIN_FILE, function(){
	global $wpdb;

	$table_name = $wpdb->prefix . 'vform';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		formname varchar(200) NOT NULL,
		formdescription varchar(1000) NOT NULL,
		formbody longtext NOT NULL,
		status varchar(50) NOT NULL,
		confirmation varchar(200) NULL NULL,
		confirmation_value mediumtext NULL NULL,
		notification_mode varchar(100) NULL NULL,
		send_to varchar(200) NULL NULL,
		email_subject varchar(500) NULL NULL,
		from_name varchar(200) NULL NULL,
		from_email varchar(200) NULL NULL,
		reply_to varchar(200) NULL NULL,
    	message longtext NULL NULL,
		security_type varchar(50) NULL NULL,
		rec_site_key varchar(300) NULL NULL,
		rec_secret_key varchar(300) NULL NULL,
		hcap_site_key varchar(300) NULL NULL,
		hcap_secret_key varchar(300) NULL NULL,
		no_duplicate varchar(50) NULL NULL,
		google_sheet mediumtext NULL NULL,
		webhook_url mediumtext NULL NULL,
		webhook_auth varchar(100) DEFAULT NULL,
        webhook_auth_type varchar(300) DEFAULT NULL,
        webhook_auth_key varchar(300) DEFAULT NULL,
        webhook_auth_secret varchar(300) DEFAULT NULL, 
    	datesubmit TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate;";


	// notification
	$table_namenotifi = $wpdb->prefix . 'vform_notifications';
	$charset_collate_notifi = $wpdb->get_charset_collate();

	$sql_noti = "CREATE TABLE $table_namenotifi (
		id int(11) NOT NULL AUTO_INCREMENT,
		formid int(200) NOT NULL,
		action_name varchar(200) NOT NULL,
		send_to_email varchar(2000) NOT NULL,
		from_name varchar(50) NOT NULL,
		from_email varchar(200) NULL NULL,
		subject varchar(400) NULL NULL,
		message mediumtext NULL NULL,
		reply_to varchar(200) NULL NULL,
		mode varchar(200) NULL NULL,
		dropdown varchar(50) NULL NULL,
    	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate_notifi;";


  // secondtable

  $table_name2 = $wpdb->prefix . 'vform_userinput';
	$charset_collate2 = $wpdb->get_charset_collate();

	$sql2 = "CREATE TABLE $table_name2 (
		id int(11) NOT NULL AUTO_INCREMENT,
		formid varchar(100) NOT NULL,
		maindatabody mediumtext NOT NULL,
		ip varchar(300) NULL NULL,
        browser varchar(300) NULL NULL,
        currentdate varchar(300) NULL NULL,
        timezone varchar(300) NULL NULL,
        currentdate_part2 varchar(300) NULL NULL,
        usertimetakes varchar(300) NULL NULL,
		PRIMARY KEY  (id)
	) $charset_collate2;";


	// thirdtable

	$table_name3 = $wpdb->prefix . 'vfsubscr';
	$charset_collate3 = $wpdb->get_charset_collate();

	$sql3 = "CREATE TABLE $table_name3 (
		id int(11) NOT NULL AUTO_INCREMENT,
		subscription int(11) NOT NULL,
        template_key varchar(300) DEFAULT NULL, 
		PRIMARY KEY  (id)
	) $charset_collate3;";



	// forthtable

	$table_name4 = $wpdb->prefix . 'vform_fields';
	$charset_collate4 = $wpdb->get_charset_collate();

	$sql4 = "CREATE TABLE $table_name4 (
		id int(11) NOT NULL AUTO_INCREMENT,
		formid int(11) NOT NULL,
		ip varchar(200) NULL,
		created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY  (id)
	) $charset_collate4;";

	// conditional form logic
	$table_name5 = $wpdb->prefix . 'vform_conditional_logic';
    $charset_collate5 = $wpdb->get_charset_collate();

    $sql5 = "CREATE TABLE $table_name5 (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        logic_name VARCHAR(255) NOT NULL,
        conditions TEXT NOT NULL,
        hidden_fields TEXT NOT NULL,
		form_id VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate5;";
	// conditional form logic

	// smtp email
	$table_name6 = $wpdb->prefix . 'vform_email_accounts';
    $charset_collate6 = $wpdb->get_charset_collate();

	$sql6 = "CREATE TABLE $table_name6 (
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		account_type ENUM('smtp', 'api') NOT NULL DEFAULT 'smtp',
		service_name VARCHAR(100) DEFAULT NULL,
		smtp_host VARCHAR(255) DEFAULT NULL,
		smtp_port INT DEFAULT NULL,
		smtp_username VARCHAR(255) DEFAULT NULL,
		smtp_password VARCHAR(255) DEFAULT NULL,
		smtp_encryption ENUM('tls', 'ssl', 'none') DEFAULT NULL,	
		api_key TEXT DEFAULT NULL,
		api_domain VARCHAR(255) DEFAULT NULL,	
		from_email VARCHAR(255) NOT NULL,
		from_name VARCHAR(255) DEFAULT NULL,	
		is_active TINYINT(1) DEFAULT 1,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
		PRIMARY KEY (id)
	) $charset_collate6;";
	// stmp email


	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  	dbDelta( $sql );
	dbDelta( $sql_noti );
	dbDelta( $sql2 );
	dbDelta( $sql3 );
	dbDelta( $sql4 );
	dbDelta( $sql5 );
	dbDelta( $sql6 );
});

