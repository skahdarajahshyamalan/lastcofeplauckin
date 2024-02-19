<?php

function my_custom_plugin_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cofebook';
    $table_name2 = $wpdb->prefix . 'cofebookconfig';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        fullname varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(255) NOT NULL,
        date_time varchar(255) NOT NULL,
        guests varchar(255) NOT NULL,
        descript varchar(255) NOT NULL,
        indor varchar(255) NOT NULL,
        outdor varchar(255) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    $sql2 = "CREATE TABLE $table_name2 (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      config varchar(255) NOT NULL,
      PRIMARY KEY  (id)
  ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql2);
  }
?>