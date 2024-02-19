<?php

function my_custom_plugin_uninstall() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cofebook';
    $table_name1 = $wpdb->prefix . 'cofebookconfig';
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $sql1 = "DROP TABLE IF EXISTS $table_name1;";
    $wpdb->query($sql);
    $wpdb->query($sql1);
  }
?>