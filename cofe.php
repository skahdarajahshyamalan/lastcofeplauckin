<?php

/**
 * @package coffee
 * @version 1.7.2
 */
/*
Plugin Name: Cofebooking
Plugin URI: https://www.linkedin.com/in/skandarajhshyamalan/
Description: The CofeShop Booking System is an online platform designed to streamline the reservation process for customers and manage bookings efficiently for a coffee shop. This system aims to provide a convenient and user-friendly experience for both customers and coffee shop staff.
Version: 1.7.2
Author URI: https://www.linkedin.com/in/skandarajhshyamalan/
*/




require_once plugin_dir_path(__FILE__) . 'activate-plugin.php';
require_once plugin_dir_path(__FILE__) . 'deactivate-plugin.php';
register_deactivation_hook(__FILE__, 'my_custom_plugin_uninstall');
register_activation_hook(__FILE__, 'my_custom_plugin_install');
function example_form_plugin()
{
  $form_action    = get_permalink();
  if (($_SESSION['contact_form_success'])) {
    $contact_form_success = '<p style="color: green">Thank you for Your Messages.</p>';
    unset($_SESSION['contact_form_success']);
  }

  $markup = <<<EOT

<div id="cform">
{$contact_form_success}
<form onsubmit="return validateForm(this);" action="{$form_action}" method="post" enctype="multipart/form-data" style="text-align: left"><div class="mb-3 row">
       <label for="your_name" class="col-sm-2 col-form-label fs-5">Name</label>
       <div class="col-sm-10">
         <input type="text" require class="form-control" id="Name" name="name" placeholder="Your Name">
       </div>
     </div>
     <div class="mb-3 row">
       <label for="Email" class="col-sm-2 col-form-label fs-5">Email</label>
       <div class="col-sm-10">
         <input type="text" require class="form-control" placeholder="Your Email" name="Email" id="Email">
       </div>
     </div>
     <div class="mb-3 row">
       <label for="Phone" class="col-sm-2 col-form-label fs-5">Phone</label>
       <div class="col-sm-10">
         <input type="text" class="form-control" name="Phone" placeholder="Your Phone" id="Phone">
       </div>
     </div>
     <div class="mb-3 row">
       <label for="inputPassword" class="col-sm-2 col-form-label fs-5">From when? </label>
       <div class="col-sm-10 fs-5">
          <input type="text"  class="form-control" name="datetimepicker" id="datetimepicker">
       </div>
     </div>
     <div class="mb-3 row">
     <label for="inputPassword" class="col-sm-2 col-form-label fs-5 placeholder="Guests">Guests</label>
     <div class="col-sm-10">
     <select class="form-control" aria-label="Default select example" name="Guests" id="Guests">
     <option value="1">1</option>
     <option value="2">2</option>
     <option value="3">3</option>
     <option value="4">4</option>
     <option value="5">5</option>
     <option value="6">6</option>
     <option value="7">7</option>
     <option value="8">8</option>
     <option value="9">9</option>
     <option value="10">10</option>
     </select>
     </div>
     <div class="mb-3 row">
     <label for="inputPassword" class="col-sm-2 col-form-label fs-5">Des</label>
     <div class="col-sm-10">
     <textarea class="form-control" name="Des" id="Des" name="Des" placeholder="Des" placeholder="Description" id="exampleFormControlTextarea1" rows="3"></textarea>
     </div>
     </div>
     <div class="mb-3 row">
     <label for="inputPassword" class="col-sm-2 col-form-label fs-5"></label>
     <div class="col-sm-10">
     <div class="row">
     <div class="col-1">
     <input class="form-check-input" type="checkbox" value="1" name="Indoor" id="Indoor">
     <label class="form-check-label" name="Indoor" for="reverseCheck1"> Indoor </label>
     </div>
      <div class="col-1"><input class="form-check-input" value="1" type="checkbox" name="Outdoor" id="Outdoor">
      <label class="form-check-label" name="Out door" id="Outdoor" for="reverseCheck1">Out door</div> 
    </div>
     </div>
     </div>
     </div>
     <div class="col-12">
       <label for="inputPassword" class="col-sm-2 col-form-label fs-5"></label>
       <button type="submit" id="send" name="send" class="btn btn-primary">BOOK A TABLE</button>
      </div>
    </div>  
     
    <input type="hidden" name="contact_form_submitted" value="1">
       </form>
       
    </div>

EOT;

  return $markup;
}

add_shortcode('cofe_code', 'example_form_plugin');
add_action('wp_head', 'contact_form_js');
function contact_form_process()
{
  session_start();
  if (!isset($_POST['contact_form_submitted'])) return;
  $Name  = (isset($_POST['Name']))  ? trim(strip_tags($_POST['Name'])) : null;
  $email   = (isset($_POST['Email']))   ? trim(strip_tags($_POST['Email'])) : null;
  $Phone = (isset($_POST['Phone'])) ? trim(strip_tags($_POST['Phone'])) : null;
  $date_time = (isset($_POST['datetimepicker'])) ? trim(strip_tags($_POST['datetimepicker'])) : null;
  $Guests = (isset($_POST['Guests'])) ? trim(strip_tags($_POST['Guests'])) : null;
  $Des = (isset($_POST['Des'])) ? trim(strip_tags($_POST['Des'])) : null; //
  $Indoor = (isset($_POST['Indoor'])) ? trim(strip_tags($_POST['Indoor'])) : null;
  $Outdoor = (isset($_POST['Outdoor'])) ? trim(strip_tags($_POST['Outdoor'])) : null;


  insert_row_into_custom_table(
    $_POST['name'] == '' ? '' : $_POST['name'],
    $_POST['Email'] == '' ? '' : $_POST['Email'],
    $_POST['Phone'] == '' ? '' : $_POST['Phone'],
    $_POST['datetimepicker'] == '' ? '' : $_POST['datetimepicker'],
    $_POST['Guests'] == '' ? '' : $_POST['Guests'],
    $_POST['Des'] == '' ? '' : $_POST['Des'],
    $_POST['Indoor'] == '' ? '' : $_POST['Indoor'],
    $_POST['Outdoor'] == '' ? '' : $_POST['Outdoor']
  );


  $to = trim(strip_tags($_POST['Email']));
  $subject = 'Cafe Brontos Booking Confirmationamalan';
  $message = "We are thrilled to confirm your reservation at Brontos.
  We are looking forward to welcoming you to Brontos and providing you with a delightful dining experience. Should you have any additional requests or questions, feel free to reach out to us.
  
  Thank you for choosing Cafe Brontos. We appreciate your business and can't wait to serve you.
  
  Team Brontos";
  $headers[] = 'Content-Type: text/html; charset=UTF-8';
  $to_1 = 'orders@cafebrontos.com.au';
  $subject_1 = 'Admin Message';
  $message_1 = 'Reservation Name  :' . $_POST['name'] . ' <br/> Date :' . $_POST['date_time'] . ' <br/> Number of Guests:' . $_POST['Guests'] . '<br/> Special comment : ' . $_POST['Des'] . '';

  $result = wp_mail($to_1, $subject_1, $message_1, $headers);
  $result = wp_mail($to, $subject, $message, $headers);
  $_SESSION['message'] = $_POST;
  $_SESSION['contact_form_success'] = 1;
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit();
}
function insert_row_into_custom_table($name, $email, $phone, $date_time, $Guests, $Des, $Indoor, $Outdoor)
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'cofebook';
  $data = array(
    'fullname'  => $name,
    'email' => $email,
    'phone' => $phone,
    'date_time' => $date_time,
    'guests' => $Guests,
    'descript' => $Des,
    'indor' => $Indoor,
    'outdor' => $Outdoor,

  );

  // Data format (in case you have different data types)
  $data_format = array('%s', '%s', '%s');

  // Insert data into the table
  $wpdb->insert($table_name, $data, $data_format);

  // Check if the insertion was successful
  if ($wpdb->last_error) {
    return false;
  }

  return true;
}

function enqueue_custom_scripts_and_styles()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'cofebookconfig';
  $results = $wpdb->get_results("SELECT config FROM $table_name", ARRAY_A);
  error_log(print_r($results, true));

  if ($wpdb->last_error) {
    error_log('Database query error: ' . $wpdb->last_error);
    return;
  }

  wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.4.min.js', array(), '3.6.4', true);
  wp_enqueue_style('datetimepicker-style', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css', array(), '2.5.20');
  wp_enqueue_script('datetimepicker-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js', array('jquery'), '2.5.20', true);
  wp_enqueue_script('custom-script', plugins_url() . '/cofe_plugin-master/js/cofescript.js', array('jquery', 'datetimepicker-script'), '1.0', true);
  wp_localize_script('custom-script', 'custom_script_vars', array(
    'minDate' => 0, 'allowedTimes' => json_decode($results[0]['config'])
  ));
  wp_enqueue_script('bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '3.6.4', true);
  wp_enqueue_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '2.5.20');
}

// Enqueue Bootstrap CSS
function enqueue_bootstrap_css()
{
  wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
}
add_action('admin_enqueue_scripts', 'enqueue_bootstrap_css');

// Enqueue Bootstrap JavaScript
function enqueue_bootstrap_js()
{
  wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
}
//function datatable




add_action('admin_enqueue_scripts', 'enqueue_bootstrap_js');
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts_and_styles');
add_action('init', 'contact_form_process');











// Add menu item to admin dashboard
function my_plugin_menu()
{
  add_menu_page(
    'My Plugin Settings',
    'Coffe',
    'manage_options',
    'my-plugin-settings',
    'my_plugin_settings_page'
  );
}
add_action('admin_menu', 'my_plugin_menu');

// Create settings page content
function my_plugin_settings_page()
{
?>
  <div class="container">
    <div class="mt-5 mr-10">
      <form>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <p>result</p>
    <table id="example" class="display" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Position</th>
          <th>Office</th>
          <th>Age</th>
          <th>Start date</th>
          <th>Salary</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Tiger Nixon</td>
          <td>System Architect</td>
          <td>Edinburgh</td>
          <td>61</td>
          <td>2011-04-25</td>
          <td>$320,800</td>
        </tr>
        <tr>
          <td>Garrett Winters</td>
          <td>Accountant</td>
          <td>Tokyo</td>
          <td>63</td>
          <td>2011-07-25</td>
          <td>$170,750</td>
        </tr>
        <tr>
          <td>Ashton Cox</td>
          <td>Junior Technical Author</td>
          <td>San Francisco</td>
          <td>66</td>
          <td>2009-01-12</td>
          <td>$86,000</td>
        </tr>
        <tr>
          <td>Cedric Kelly</td>
          <td>Senior Javascript Developer</td>
          <td>Edinburgh</td>
          <td>22</td>
          <td>2012-03-29</td>
          <td>$433,060</td>
        </tr>
        <tr>
          <td>Airi Satou</td>
          <td>Accountant</td>
          <td>Tokyo</td>
          <td>33</td>
          <td>2008-11-28</td>
          <td>$162,700</td>
        </tr>
        <tr>
          <td>Brielle Williamson</td>
          <td>Integration Specialist</td>
          <td>New York</td>
          <td>61</td>
          <td>2012-12-02</td>
          <td>$372,000</td>
        </tr>
        <tr>
          <td>Herrod Chandler</td>
          <td>Sales Assistant</td>
          <td>San Francisco</td>
          <td>59</td>
          <td>2012-08-06</td>
          <td>$137,500</td>
        </tr>
        <tr>
          <td>Rhona Davidson</td>
          <td>Integration Specialist</td>
          <td>Tokyo</td>
          <td>55</td>
          <td>2010-10-14</td>
          <td>$327,900</td>
        </tr>
        <tr>
          <td>Colleen Hurst</td>
          <td>Javascript Developer</td>
          <td>San Francisco</td>
          <td>39</td>
          <td>2009-09-15</td>
          <td>$205,500</td>
        </tr>
        <tr>
          <td>Sonya Frost</td>
          <td>Software Engineer</td>
          <td>Edinburgh</td>
          <td>23</td>
          <td>2008-12-13</td>
          <td>$103,600</td>
        </tr>
        <tr>
          <td>Jena Gaines</td>
          <td>Office Manager</td>
          <td>London</td>
          <td>30</td>
          <td>2008-12-19</td>
          <td>$90,560</td>
        </tr>
        <tr>
          <td>Quinn Flynn</td>
          <td>Support Lead</td>
          <td>Edinburgh</td>
          <td>22</td>
          <td>2013-03-03</td>
          <td>$342,000</td>
        </tr>
        <tr>
          <td>Charde Marshall</td>
          <td>Regional Director</td>
          <td>San Francisco</td>
          <td>36</td>
          <td>2008-10-16</td>
          <td>$470,600</td>
        </tr>
        <tr>
          <td>Haley Kennedy</td>
          <td>Senior Marketing Designer</td>
          <td>London</td>
          <td>43</td>
          <td>2012-12-18</td>
          <td>$313,500</td>
        </tr>
        <tr>
          <td>Tatyana Fitzpatrick</td>
          <td>Regional Director</td>
          <td>London</td>
          <td>19</td>
          <td>2010-03-17</td>
          <td>$385,750</td>
        </tr>
        <tr>
          <td>Michael Silva</td>
          <td>Marketing Designer</td>
          <td>London</td>
          <td>66</td>
          <td>2012-11-27</td>
          <td>$198,500</td>
        </tr>
        <tr>
          <td>Paul Byrd</td>
          <td>Chief Financial Officer (CFO)</td>
          <td>New York</td>
          <td>64</td>
          <td>2010-06-09</td>
          <td>$725,000</td>
        </tr>
        <tr>
          <td>Gloria Little</td>
          <td>Systems Administrator</td>
          <td>New York</td>
          <td>59</td>
          <td>2009-04-10</td>
          <td>$237,500</td>
        </tr>
        <tr>
          <td>Bradley Greer</td>
          <td>Software Engineer</td>
          <td>London</td>
          <td>41</td>
          <td>2012-10-13</td>
          <td>$132,000</td>
        </tr>
        <tr>
          <td>Dai Rios</td>
          <td>Personnel Lead</td>
          <td>Edinburgh</td>
          <td>35</td>
          <td>2012-09-26</td>
          <td>$217,500</td>
        </tr>
        <tr>
          <td>Jenette Caldwell</td>
          <td>Development Lead</td>
          <td>New York</td>
          <td>30</td>
          <td>2011-09-03</td>
          <td>$345,000</td>
        </tr>
        <tr>
          <td>Yuri Berry</td>
          <td>Chief Marketing Officer (CMO)</td>
          <td>New York</td>
          <td>40</td>
          <td>2009-06-25</td>
          <td>$675,000</td>
        </tr>
        <tr>
          <td>Caesar Vance</td>
          <td>Pre-Sales Support</td>
          <td>New York</td>
          <td>21</td>
          <td>2011-12-12</td>
          <td>$106,450</td>
        </tr>
        <tr>
          <td>Doris Wilder</td>
          <td>Sales Assistant</td>
          <td>Sydney</td>
          <td>23</td>
          <td>2010-09-20</td>
          <td>$85,600</td>
        </tr>
        <tr>
          <td>Angelica Ramos</td>
          <td>Chief Executive Officer (CEO)</td>
          <td>London</td>
          <td>47</td>
          <td>2009-10-09</td>
          <td>$1,200,000</td>
        </tr>
        <tr>
          <td>Gavin Joyce</td>
          <td>Developer</td>
          <td>Edinburgh</td>
          <td>42</td>
          <td>2010-12-22</td>
          <td>$92,575</td>
        </tr>
        <tr>
          <td>Jennifer Chang</td>
          <td>Regional Director</td>
          <td>Singapore</td>
          <td>28</td>
          <td>2010-11-14</td>
          <td>$357,650</td>
        </tr>
        <tr>
          <td>Brenden Wagner</td>
          <td>Software Engineer</td>
          <td>San Francisco</td>
          <td>28</td>
          <td>2011-06-07</td>
          <td>$206,850</td>
        </tr>
        <tr>
          <td>Fiona Green</td>
          <td>Chief Operating Officer (COO)</td>
          <td>San Francisco</td>
          <td>48</td>
          <td>2010-03-11</td>
          <td>$850,000</td>
        </tr>
        <tr>
          <td>Shou Itou</td>
          <td>Regional Marketing</td>
          <td>Tokyo</td>
          <td>20</td>
          <td>2011-08-14</td>
          <td>$163,000</td>
        </tr>
        <tr>
          <td>Michelle House</td>
          <td>Integration Specialist</td>
          <td>Sydney</td>
          <td>37</td>
          <td>2011-06-02</td>
          <td>$95,400</td>
        </tr>
        <tr>
          <td>Suki Burks</td>
          <td>Developer</td>
          <td>London</td>
          <td>53</td>
          <td>2009-10-22</td>
          <td>$114,500</td>
        </tr>
        <tr>
          <td>Prescott Bartlett</td>
          <td>Technical Author</td>
          <td>London</td>
          <td>27</td>
          <td>2011-05-07</td>
          <td>$145,000</td>
        </tr>
        <tr>
          <td>Gavin Cortez</td>
          <td>Team Leader</td>
          <td>San Francisco</td>
          <td>22</td>
          <td>2008-10-26</td>
          <td>$235,500</td>
        </tr>
        <tr>
          <td>Martena Mccray</td>
          <td>Post-Sales support</td>
          <td>Edinburgh</td>
          <td>46</td>
          <td>2011-03-09</td>
          <td>$324,050</td>
        </tr>
        <tr>
          <td>Unity Butler</td>
          <td>Marketing Designer</td>
          <td>San Francisco</td>
          <td>47</td>
          <td>2009-12-09</td>
          <td>$85,675</td>
        </tr>
        <tr>
          <td>Howard Hatfield</td>
          <td>Office Manager</td>
          <td>San Francisco</td>
          <td>51</td>
          <td>2008-12-16</td>
          <td>$164,500</td>
        </tr>
        <tr>
          <td>Hope Fuentes</td>
          <td>Secretary</td>
          <td>San Francisco</td>
          <td>41</td>
          <td>2010-02-12</td>
          <td>$109,850</td>
        </tr>
        <tr>
          <td>Vivian Harrell</td>
          <td>Financial Controller</td>
          <td>San Francisco</td>
          <td>62</td>
          <td>2009-02-14</td>
          <td>$452,500</td>
        </tr>
        <tr>
          <td>Timothy Mooney</td>
          <td>Office Manager</td>
          <td>London</td>
          <td>37</td>
          <td>2008-12-11</td>
          <td>$136,200</td>
        </tr>
        <tr>
          <td>Jackson Bradshaw</td>
          <td>Director</td>
          <td>New York</td>
          <td>65</td>
          <td>2008-09-26</td>
          <td>$645,750</td>
        </tr>
        <tr>
          <td>Olivia Liang</td>
          <td>Support Engineer</td>
          <td>Singapore</td>
          <td>64</td>
          <td>2011-02-03</td>
          <td>$234,500</td>
        </tr>
        <tr>
          <td>Bruno Nash</td>
          <td>Software Engineer</td>
          <td>London</td>
          <td>38</td>
          <td>2011-05-03</td>
          <td>$163,500</td>
        </tr>
        <tr>
          <td>Sakura Yamamoto</td>
          <td>Support Engineer</td>
          <td>Tokyo</td>
          <td>37</td>
          <td>2009-08-19</td>
          <td>$139,575</td>
        </tr>
        <tr>
          <td>Thor Walton</td>
          <td>Developer</td>
          <td>New York</td>
          <td>61</td>
          <td>2013-08-11</td>
          <td>$98,540</td>
        </tr>
        <tr>
          <td>Finn Camacho</td>
          <td>Support Engineer</td>
          <td>San Francisco</td>
          <td>47</td>
          <td>2009-07-07</td>
          <td>$87,500</td>
        </tr>
        <tr>
          <td>Serge Baldwin</td>
          <td>Data Coordinator</td>
          <td>Singapore</td>
          <td>64</td>
          <td>2012-04-09</td>
          <td>$138,575</td>
        </tr>
        <tr>
          <td>Zenaida Frank</td>
          <td>Software Engineer</td>
          <td>New York</td>
          <td>63</td>
          <td>2010-01-04</td>
          <td>$125,250</td>
        </tr>
        <tr>
          <td>Zorita Serrano</td>
          <td>Software Engineer</td>
          <td>San Francisco</td>
          <td>56</td>
          <td>2012-06-01</td>
          <td>$115,000</td>
        </tr>
        <tr>
          <td>Jennifer Acosta</td>
          <td>Junior Javascript Developer</td>
          <td>Edinburgh</td>
          <td>43</td>
          <td>2013-02-01</td>
          <td>$75,650</td>
        </tr>
        <tr>
          <td>Cara Stevens</td>
          <td>Sales Assistant</td>
          <td>New York</td>
          <td>46</td>
          <td>2011-12-06</td>
          <td>$145,600</td>
        </tr>
        <tr>
          <td>Hermione Butler</td>
          <td>Regional Director</td>
          <td>London</td>
          <td>47</td>
          <td>2011-03-21</td>
          <td>$356,250</td>
        </tr>
        <tr>
          <td>Lael Greer</td>
          <td>Systems Administrator</td>
          <td>London</td>
          <td>21</td>
          <td>2009-02-27</td>
          <td>$103,500</td>
        </tr>
        <tr>
          <td>Jonas Alexander</td>
          <td>Developer</td>
          <td>San Francisco</td>
          <td>30</td>
          <td>2010-07-14</td>
          <td>$86,500</td>
        </tr>
        <tr>
          <td>Shad Decker</td>
          <td>Regional Director</td>
          <td>Edinburgh</td>
          <td>51</td>
          <td>2008-11-13</td>
          <td>$183,000</td>
        </tr>
        <tr>
          <td>Michael Bruce</td>
          <td>Javascript Developer</td>
          <td>Singapore</td>
          <td>29</td>
          <td>2011-06-27</td>
          <td>$183,000</td>
        </tr>
        <tr>
          <td>Donna Snider</td>
          <td>Customer Support</td>
          <td>New York</td>
          <td>27</td>
          <td>2011-01-25</td>
          <td>$112,000</td>
        </tr>
      </tbody>

    </table>
  </div>

<?php
}

// Register plugin settings
function my_plugin_register_settings()
{
  register_setting('my_plugin_settings_group', 'my_plugin_option');
  add_settings_section('my_plugin_main_settings', 'Main Settings', 'my_plugin_main_settings_callback', 'my-plugin-settings');
  add_settings_field('my_plugin_text_field', 'Text Field', 'my_plugin_text_field_callback', 'my-plugin-settings', 'my_plugin_main_settings');
}
add_action('admin_init', 'my_plugin_register_settings');

// Section callback
function my_plugin_main_settings_callback()
{
  echo '<p>Configure the main settings for the plugin.</p>';
}

// Field callback
function my_plugin_text_field_callback()
{
  $value = get_option('my_plugin_option');
  echo '<input type="text" name="my_plugin_option" value="' . esc_attr($value) . '" />';
}
?>
<?php
 function contact_form_js() { ?>
 <script type="text/javascript">
  var table = $('#example').DataTable();
      function validateForm(form) {
      
        var errors = '';
         
        var regexpEmail = /\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/;
         if (!regexpEmail.test(form.Email.value)) errors += "Error :  your e-mail address format incorrect.\n";
         if (form.Name.value.trim() === '') { errors += "Error: Full name cannot be empty.\n"; }
         if (errors != '') { alert(errors); return false;  }
           return true;     
      }
      </script>
       <?php }
       ?>