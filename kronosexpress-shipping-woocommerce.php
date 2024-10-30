<?php

/*
Plugin Name: BSE Kronos Express Shipping For WooCommerce
Description: BSE Kronos Express Shipping For WooCommerce >2.6.14
Author: B.S.E. Business Solution Enteprises LTD
Author URI: https://www.bse.com.cy
Version: 1.0.15
 * WC requires at least: 2.6.14
 * WC tested up to: 6.5.1
Disclaimer: Use at your own risk. No warranty expressed or implied is provided.

GNU LESSER GENERAL PUBLIC LICENSE
Version 3, 29 June 2007

Copyright (C) 2007 Free Software Foundation, Inc. <https://fsf.org/>
Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

This version of the GNU Lesser General Public License incorporates
the terms and conditions of version 3 of the GNU General Public
License, supplemented by the additional permissions listed below.

0. Additional Definitions.

As used herein, "this License" refers to version 3 of the GNU Lesser
General Public License, and the "GNU GPL" refers to version 3 of the GNU
General Public License.

"The Library" refers to a covered work governed by this License,
other than an Application or a Combined Work as defined below.

An "Application" is any work that makes use of an interface provided
by the Library, but which is not otherwise based on the Library.
Defining a subclass of a class defined by the Library is deemed a mode
of using an interface provided by the Library.

A "Combined Work" is a work produced by combining or linking an
Application with the Library.  The particular version of the Library
with which the Combined Work was made is also called the "Linked
Version".

The "Minimal Corresponding Source" for a Combined Work means the
Corresponding Source for the Combined Work, excluding any source code
for portions of the Combined Work that, considered in isolation, are
based on the Application, and not on the Linked Version.

The "Corresponding Application Code" for a Combined Work means the
object code and/or source code for the Application, including any data
and utility programs needed for reproducing the Combined Work from the
Application, but excluding the System Libraries of the Combined Work.

1. Exception to Section 3 of the GNU GPL.

You may convey a covered work under sections 3 and 4 of this License
without being bound by section 3 of the GNU GPL.

2. Conveying Modified Versions.

If you modify a copy of the Library, and, in your modifications, a
facility refers to a function or data to be supplied by an Application
that uses the facility (other than as an argument passed when the
facility is invoked), then you may convey a copy of the modified
version:

a) under this License, provided that you make a good faith effort to
ensure that, in the event an Application does not supply the
function or data, the facility still operates, and performs
whatever part of its purpose remains meaningful, or

b) under the GNU GPL, with none of the additional permissions of
this License applicable to that copy.

3. Object Code Incorporating Material from Library Header Files.

The object code form of an Application may incorporate material from
a header file that is part of the Library.  You may convey such object
code under terms of your choice, provided that, if the incorporated
material is not limited to numerical parameters, data structure
layouts and accessors, or small macros, inline functions and templates
(ten or fewer lines in length), you do both of the following:

a) Give prominent notice with each copy of the object code that the
Library is used in it and that the Library and its use are
covered by this License.

b) Accompany the object code with a copy of the GNU GPL and this license
document.

4. Combined Works.

You may convey a Combined Work under terms of your choice that,
taken together, effectively do not restrict modification of the
portions of the Library contained in the Combined Work and reverse
engineering for debugging such modifications, if you also do each of
the following:

a) Give prominent notice with each copy of the Combined Work that
the Library is used in it and that the Library and its use are
covered by this License.

b) Accompany the Combined Work with a copy of the GNU GPL and this license
document.

c) For a Combined Work that displays copyright notices during
execution, include the copyright notice for the Library among
these notices, as well as a reference directing the user to the
copies of the GNU GPL and this license document.

d) Do one of the following:

0) Convey the Minimal Corresponding Source under the terms of this
License, and the Corresponding Application Code in a form
suitable for, and under terms that permit, the user to
recombine or relink the Application with a modified version of
the Linked Version to produce a modified Combined Work, in the
manner specified by section 6 of the GNU GPL for conveying
Corresponding Source.

1) Use a suitable shared library mechanism for linking with the
Library.  A suitable mechanism is one that (a) uses at run time
a copy of the Library already present on the user's computer
system, and (b) will operate properly with a modified version
of the Library that is interface-compatible with the Linked
Version.

e) Provide Installation Information, but only if you would otherwise
be required to provide such information under section 6 of the
GNU GPL, and only to the extent that such information is
necessary to install and execute a modified version of the
Combined Work produced by recombining or relinking the
Application with a modified version of the Linked Version. (If
you use option 4d0, the Installation Information must accompany
the Minimal Corresponding Source and Corresponding Application
Code. If you use option 4d1, you must provide the Installation
Information in the manner specified by section 6 of the GNU GPL
for conveying Corresponding Source.)

5. Combined Libraries.

You may place library facilities that are a work based on the
Library side by side in a single library together with other library
facilities that are not Applications and are not covered by this
License, and convey such a combined library under terms of your
choice, if you do both of the following:

a) Accompany the combined library with a copy of the same work based
on the Library, uncombined with any other library facilities,
conveyed under the terms of this License.

b) Give prominent notice with the combined library that part of it
is a work based on the Library, and explaining where to find the
accompanying uncombined form of the same work.

6. Revised Versions of the GNU Lesser General Public License.

The Free Software Foundation may publish revised and/or new versions
of the GNU Lesser General Public License from time to time. Such new
versions will be similar in spirit to the present version, but may
differ in detail to address new problems or concerns.

Each version is given a distinguishing version number. If the
Library as you received it specifies that a certain numbered version
of the GNU Lesser General Public License "or any later version"
applies to it, you have the option of following the terms and
conditions either of that published version or of any later version
published by the Free Software Foundation. If the Library as you
received it does not specify a version number of the GNU Lesser
General Public License, you may choose any version of the GNU Lesser
General Public License ever published by the Free Software Foundation.

If the Library as you received it specifies that a proxy can decide
whether future versions of the GNU Lesser General Public License shall
apply, that proxy's public statement of acceptance of any version is
permanent authorization for you to choose that version for the
Library.

Copyright: © 2019 B.S.E. Business Solution Enterprises LTD (email : info@bse.com.cy). All Rights Reserved.
 */

if (!defined('WPINC')) {
    die;
}

if (!defined('ABSPATH')) {
    exit;
}

add_action('woocommerce_order_status_completed', array('KRONOSEXPRESS_SHIPPING_WOOCOMMERCE', 'order_completed'), 1, 1);

if (in_array('bse-kronosexpress-shipping-woocommerce/kronosexpress-shipping-woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('init', 'load_kronosexpress_shipping_translations');
    function load_kronosexpress_shipping_translations()
    {
        load_plugin_textdomain('kronosexpress_shipping_woocommerce', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
}
/*
 * Check if WooCommerce is active
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    
    function kronosexpress_initialize()
    {

        if (!class_exists('KRONOSEXPRESS_SHIPPING_WOOCOMMERCE')) {
            class KRONOSEXPRESS_SHIPPING_WOOCOMMERCE extends WC_Shipping_Method
            {
                public static $instance = null;

                public function __construct()
                {

                    $this->id = 'kronosexpress_shipping_woocommerce';
                    $this->title = __('KRONOSEXPRESS SHIPPING WOOCOMMERCE');
                    $this->method_title = __('Kronos Express Shipping WooCommerce');
                    $this->init();
                    $this->enabled = $this->settings['enabled'];
                    $this->weightmax = '5000'; //$this->settings['weightmax'];
                    $this->apiusername = $this->settings['apiusername'];
                    $this->apipassword = $this->settings['apipassword'];
                    $this->apiuniquekey = $this->settings['apiuniquekey'];
                    $this->sendemailtracking = isset($this->settings['sendemailtracking']) ? $this->settings['sendemailtracking'] : 'no';
                    $this->enabledsandbox = isset($this->settings['enabledsandbox']) ? $this->settings['enabledsandbox'] : 'no';
                    $this->sendemailtrackingonordercompleted = isset($this->settings['sendemailtrackingonordercompleted']) ? $this->settings['sendemailtrackingonordercompleted'] : 'no';
                    $this->settings['quotation'] = __('Get Account', 'kronosexpress_shipping_woocommerce');
                    $this->settings['sandboxaccount'] = __('Create Sandbox Account', 'kronosexpress_shipping_woocommerce');
                    KRONOSEXPRESS_SHIPPING_WOOCOMMERCE::$instance = $this;
                }
                function init()
                {
                    $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
                    $this->init_settings(); // This is part of the settings API. Loads settings you previously init.
                    add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));

                }
                public static function order_completed($order_id)
                {
                    add_action('woocommerce_email_before_order_table', array('KRONOSEXPRESS_SHIPPING_WOOCOMMERCE', 'order_notes'), 1, 4);
                    remove_action('woocommerce_order_status_completed', array('KRONOSEXPRESS_SHIPPING_WOOCOMMERCE', 'order_completed'));

                }
                public static function order_notes($order, $sent_to_admin, $plain_text, $email)
                {
                    remove_action('woocommerce_email_before_order_table', array('KRONOSEXPRESS_SHIPPING_WOOCOMMERCE', 'order_notes'));
                    $that = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
                    if ($that->enabled == 'no') {
                        return false;
                    }
                    if ($that->sendemailtrackingonordercompleted == 'no') {
                        return false;
                    }
                    $meta = get_post_meta($order->get_id());
                    $m = null;
                    if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                        $m = unserialize($meta['kronosexpress_shipping_method_plugin'][0]);
                        if (!empty($m['kronosexpress_shipping_method_awb'])) {
                            $note = '<blockquote><p style="margin: 0px 0px 16px">' . (string) $m['kronosexpress_shipping_method_awb'] . '<br><a href="https://tracking.kronosexpress.com/tracking_system.aspx?tracking_number=' . (string) $m['kronosexpress_shipping_method_awb'] . '" target="_blank">'.__('Track your parcel','kronosexpress_shipping_woocommerce').'</a></p></blockquote>';
                            echo $note;
                        }
                    }
                }
                function process_admin_options()
                {
                    if (
                        isset($_REQUEST['page']) && $_REQUEST['page'] == 'wc-settings' &&
                        isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'shipping' &&
                        isset($_REQUEST['section']) && $_REQUEST['section'] == 'kronosexpress_shipping_woocommerce'
                    ) {
                        $_POST['woocommerce_kronosexpress_shipping_woocommerce_quotation'] = 'Get Account';
                        $_POST['woocommerce_kronosexpress_shipping_woocommerce_sandboxaccount'] = 'Create Sandbox Account';
                        if (isset($_POST['woocommerce_kronosexpress_shipping_woocommerce_enabled']) && $_POST['woocommerce_kronosexpress_shipping_woocommerce_enabled'] == '1') {
                            if (!class_exists('KronosExpressAPI')) {
                                require dirname(__FILE__) . '/API/request.php';
                            }
                            if (
                                isset($_POST['woocommerce_kronosexpress_shipping_woocommerce_apiusername']) &&
                                !empty($_POST['woocommerce_kronosexpress_shipping_woocommerce_apiusername']) &&
                                isset($_POST['woocommerce_kronosexpress_shipping_woocommerce_apipassword']) &&
                                !empty($_POST['woocommerce_kronosexpress_shipping_woocommerce_apipassword']) &&
                                isset($_POST['woocommerce_kronosexpress_shipping_woocommerce_apiuniquekey']) &&
                                !empty($_POST['woocommerce_kronosexpress_shipping_woocommerce_apiuniquekey'])) {
                                try {
                                    $dev = false;
                                    if (isset($_POST['woocommerce_kronosexpress_shipping_woocommerce_enabledsandbox'])) {
                                        $_POST['woocommerce_kronosexpress_shipping_woocommerce_enabledsandbox'] = '1';
                                        $dev = true;
                                    }
                                    $api = new KronosExpressAPI();
                                    $username = sanitize_email($_POST['woocommerce_kronosexpress_shipping_woocommerce_apiusername']);
                                    $password = sanitize_text_field($_POST['woocommerce_kronosexpress_shipping_woocommerce_apipassword']);
                                    $key = sanitize_text_field($_POST['woocommerce_kronosexpress_shipping_woocommerce_apiuniquekey']);
                                    $res = $api->CheckCredentials($username, $password, $key, $dev);
                                    write_log($res);
                                    if ($res->Status != '1') {
                                        unset($_POST['woocommerce_kronosexpress_shipping_woocommerce_enabled']);
                                        $this->add_error('Username, password and/or unique key is incorrect.');
                                        $this->display_errors();
                                    }
                                } catch (Exception $e) {
                                    unset($_POST['woocommerce_kronosexpress_shipping_woocommerce_enabled']);
                                    $this->add_error($e->getMessage());
                                    $this->display_errors();
                                }
                            } else {
                                unset($_POST['woocommerce_kronosexpress_shipping_woocommerce_enabled']);
                            }
                        }
                    }
                    parent::process_admin_options();
                }
                function init_form_fields()
                {
                    $this->form_fields = array(
                        'shortcode' => array(
                            'title' => __('Tracking System Installation', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'title',
                            'description' => __('You may use the following shortcode [kronosexpress_tracking_system] to add tracking on your website.', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'quotation' => array(
                            'title' => __('Request Quotation', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'button',
                            'description' => __('Send us a request to open an account.', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('Get Account', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'sandboxaccount' => array(
                            'title' => __('Create SandBox', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'button',
                            'description' => __('Create a sandbox account for your development/testing environment.', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('Create Sandbox Account', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'enabled' => array(
                            'title' => __('Enable', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'checkbox',
                            'description' => __('Enable or Disable the plugin', 'kronosexpress_shipping_woocommerce'),
                            'default' => 'no',
                        ),
                        'enabledsandbox' => array(
                            'title' => __('Enable SandBox', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'checkbox',
                            'description' => __('Enable or Disable the sandbox', 'kronosexpress_shipping_woocommerce'),
                            'default' => 'no',
                        ),
                        'apiusername' => array(
                            'title' => __('API Username', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'text',
                            'description' => __('Required Field in order to communicate with the KronosExpress Service', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'apipassword' => array(
                            'title' => __('API Password', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'password',
                            'description' => __('Required Field in order to communicate with the KronosExpress Service', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'apiuniquekey' => array(
                            'title' => __('API Unique Key', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'password',
                            'description' => __('Required Field in order to communicate with the KronosExpress Service', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'sendemailtracking' => array(
                            'title' => __('Tracking Customer Notification (as soon as a shipping label is created or cancelled)', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'checkbox',
                            'description' => __('Enable the option if you would like your customer to receive an email as soon as a Kronos Express shipping label is created or cancelled.', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('no', 'kronosexpress_shipping_woocommerce'),
                        ),
                        'sendemailtrackingonordercompleted' => array(
                            'title' => __('Tracking Customer Notification (when an order is completed)', 'kronosexpress_shipping_woocommerce'),
                            'type' => 'checkbox',
                            'description' => __('Enable the option if you would like your customer to receive a tracking link when an order is marked as completed.', 'kronosexpress_shipping_woocommerce'),
                            'default' => __('no', 'kronosexpress_shipping_woocommerce'),
                        ),
                    );
                }
            }
        }
    }
    function kronosexpresss_shipping_method_door_express()
    {
        if (!class_exists('KRONOSEXPRESS_WC_SHIPPING_METHOD')) {
            require dirname(__FILE__) . '/kronosexpress_wc_shipping_method.php';
        }
        if (!class_exists('KRONOSEXPRESS_Shipping_Method_DEXPRESS')) {
            class KRONOSEXPRESS_Shipping_Method_DEXPRESS extends KRONOSEXPRESS_WC_SHIPPING_METHOD
            {
                public $code = "DEXPRESS";
                public $shippingname = "KRONOSEXPRESS DOOR EXPRESS";
                public $weightmaxpublic = '';
                
                public function __construct($instance_id = 0)
                {
                    $this->id = 'kronosexpress_shipping_dexpress';
                    $this->instance_id = absint($instance_id);
                    $this->method_title = __('KRONOSEXPRESS DOOR EXPRESS', 'kronosexpress_shipping_dexpress');
                    $this->title = __('KRONOSEXPRESS DOOR EXPRESS', 'kronosexpress_shipping_dexpress');
                    $this->method_description = __('KRONOSEXPRESS DOOR EXPRESS', 'kronosexpress_shipping_dexpress');
                    $this->supports = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal',
                    );
                    $this->init();
                    
                    parent::init_options();
                }
                
                
            }
        }
    }
    function kronosexpresss_shipping_method_door_economy()
    {
        if (!class_exists('KRONOSEXPRESS_Shipping_Method_DECONOMY')) {
            class KRONOSEXPRESS_Shipping_Method_DECONOMY extends KRONOSEXPRESS_WC_SHIPPING_METHOD
            {
                public $code = "DECONOMY";
                public $shippingname = "KRONOSEXPRESS DOOR ECONOMY";
                public $weightmaxpublic = '';

                public function __construct($instance_id = 0)
                {
                    $this->id = 'kronosexpress_shipping_deconomy';
                    $this->instance_id = absint($instance_id);
                    $this->method_title = __('KRONOSEXPRESS DOOR ECONOMY', 'kronosexpress_shipping_deconomy');
                    $this->title = __('KRONOSEXPRESS DOOR ECONOMY', 'kronosexpress_shipping_deconomy');
                    $this->method_description = __('KRONOSEXPRESS DOOR ECONOMY', 'kronosexpress_shipping_deconomy');
                    $this->supports = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal',
                    );
                    $this->init();
                    
                    parent::init_options();
                }
                
            }
        }
    }
    function kronosexpresss_shipping_method_point_express()
    {
        if (!class_exists('KRONOSEXPRESS_Shipping_Method_PEXPRESS')) {
            class KRONOSEXPRESS_Shipping_Method_PEXPRESS extends KRONOSEXPRESS_WC_SHIPPING_METHOD
            {
                public $code = "PEXPRESS";
                public $shippingname = "KRONOSEXPRESS POINT EXPRESS";
                public $weightmaxpublic = '';

                public function __construct($instance_id = 0)
                {
                    $this->id = 'kronosexpress_shipping_pexpress';
                    $this->instance_id = absint($instance_id);
                    $this->method_title = __('KRONOSEXPRESS POINT EXPRESS', 'kronosexpress_shipping_pexpress');
                    $this->title = __('KRONOSEXPRESS POINT EXPRESS', 'kronosexpress_shipping_pexpress');
                    $this->method_description = __('KRONOSEXPRESS POINT EXPRESS', 'kronosexpress_shipping_pexpress');
                    $this->supports = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal',
                    );
                    $this->init();
                    parent::init_options();
                }
                
            }

        }
    }
    function kronosexpresss_shipping_method_point_economy()
    {
        if (!class_exists('KRONOSEXPRESS_Shipping_Method_PECONOMY')) {
            class KRONOSEXPRESS_Shipping_Method_PECONOMY extends KRONOSEXPRESS_WC_SHIPPING_METHOD
            {
                public $code = "PECONOMY";
                public $shippingname = "KRONOSEXPRESS POINT ECONOMY";
                public $weightmaxpublic = '';

                public function __construct($instance_id = 0)
                {
                    $this->id = 'kronosexpress_shipping_peconomy';
                    $this->instance_id = absint($instance_id);
                    $this->method_title = __('KRONOSEXPRESS POINT ECONOMY', 'kronosexpress_shipping_peconomy');
                    $this->title = __('KRONOSEXPRESS POINT ECONOMY', 'kronosexpress_shipping_peconomy');
                    $this->method_description = __('KRONOSEXPRESS POINT ECONOMY', 'kronosexpress_shipping_peconomy');
                    $this->supports = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal',
                    );
                    $this->init();
                    parent::init_options();

                }
                
            }
        }
    }
    function kronosexpress_shipping_method_validation($posted)
    {
        try {
            $packages = WC()->shipping->get_packages();
            $chosen_methods = WC()->session->get('chosen_shipping_methods');
            if (is_array($chosen_methods) && (in_array('kronosexpress_shipping_dexpress', $chosen_methods) || in_array('kronosexpress_shipping_deconomy', $chosen_methods) || in_array('kronosexpress_shipping_pexpress', $chosen_methods) || in_array('kronosexpress_shipping_peconomy', $chosen_methods))) {
                foreach ($packages as $i => $package) {
                    $maxweight = '';
                    $methodchosen = '';
                    if ($chosen_methods[$i] == "kronosexpress_shipping_dexpress") {
                        $kronosexpress_Shipping_Method = new KRONOSEXPRESS_Shipping_Method_DEXPRESS();
                        if ($kronosexpress_Shipping_Method->enabled == 'no') {
                            wc_add_notice('Kronos Express service is unavailable at this moment.', 'error');
                        }
                        $maxweight = (int) $kronosexpress_Shipping_Method->weightmax;
                        $methodchosen = 'kronosexpress_shipping_dexpress';
                    } else if ($chosen_methods[$i] == "kronosexpress_shipping_deconomy") {
                        $kronosexpress_Shipping_Method = new KRONOSEXPRESS_Shipping_Method_DECONOMY();
                        if ($kronosexpress_Shipping_Method->enabled == 'no') {
                            wc_add_notice('Kronos Express service is unavailable at this moment.', 'error');
                        }
                        $maxweight = (int) $kronosexpress_Shipping_Method->weightmax;
                        $methodchosen = 'kronosexpress_shipping_deconomy';
                    } else if ($chosen_methods[$i] == "kronosexpress_shipping_pexpress") {
                        if (!isset($_POST['kronosexpress_shipping_pexpress_value']) || $_POST['kronosexpress_shipping_pexpress_value'] == '0' || empty($_POST['kronosexpress_shipping_pexpress_value'])) {
                            $message = __('YOU MUST SELECT A PICKUP LOCATION', 'kronosexpress_shipping_woocommerce');
                            wc_add_notice($message, 'error');
                        } else {
                            $kronosexpress_Shipping_Method = new KRONOSEXPRESS_Shipping_Method_PEXPRESS();
                            if ($kronosexpress_Shipping_Method->enabled == 'no') {
                                wc_add_notice('Kronos Express service is unavailable at this moment.', 'error');
                            }
                            $maxweight = (int) $kronosexpress_Shipping_Method->weightmax;
                            $methodchosen = 'kronosexpress_shipping_pexpress';
                            if (!class_exists('KronosExpressAPI')) {
                                require dirname(__FILE__) . '/API/request.php';
                            }
                            $api = new KronosExpressAPI();
                            $wh = $api->GetWarehouses();
                            $found = false;
                            $stationcode = '';
                            $stationname = '';
                            $userselectedwh = sanitize_text_field($_POST['kronosexpress_shipping_pexpress_value']);
                            foreach ($wh as $w) {
                                if ($w['CODE'] == $userselectedwh) {
                                    $found = true;
                                    $stationcode = (string) $w['CODE'];
                                    $stationname = (string) $w['NAME'];
                                    break;
                                }
                            }
                            if (!$found) {
                                $message = 'ΠΑΡΑΚΑΛΩ ΕΠΙΛΕΞΤΕ ΣΤΑΘΜΟ ΠΑΡΑΛΑΒΗΣ';
                                wc_add_notice($message, 'error');
                            }
                            unset($wh);

                        }
                    } else if ($chosen_methods[$i] == "kronosexpress_shipping_peconomy") {
                        if (!isset($_POST['kronosexpress_shipping_pexpress_value']) || $_POST['kronosexpress_shipping_pexpress_value'] == '0' || empty($_POST['kronosexpress_shipping_pexpress_value'])) {
                            $message = 'ΠΑΡΑΚΑΛΩ ΕΠΙΛΕΞΤΕ ΣΤΑΘΜΟ ΠΑΡΑΛΑΒΗΣ';
                            wc_add_notice($message, 'error');
                        } else {
                            $kronosexpress_Shipping_Method = new KRONOSEXPRESS_Shipping_Method_PECONOMY();
                            if ($kronosexpress_Shipping_Method->enabled == 'no') {
                                wc_add_notice('Kronos Express service is unavailable at this moment.', 'error');
                            }
                            $maxweight = (int) $kronosexpress_Shipping_Method->weightmax;
                            $methodchosen = 'kronosexpress_shipping_peconomy';
                            if (!class_exists('KronosExpressAPI')) {
                                require dirname(__FILE__) . '/API/request.php';
                            }
                            $api = new KronosExpressAPI();
                            $wh = $api->GetWarehouses();
                            $found = false;
                            $stationcode = '';
                            $stationname = '';
                            $userselectedwh = sanitize_text_field($_POST['kronosexpress_shipping_pexpress_value']);
                            foreach ($wh as $w) {
                                if ($w['CODE'] == $userselectedwh) {
                                    $found = true;
                                    $stationcode = (string) $w['CODE'];
                                    $stationname = (string) $w['NAME'];
                                    break;
                                }
                            }
                            if (!$found) {
                                $message = 'ΠΑΡΑΚΑΛΩ ΕΠΙΛΕΞΤΕ ΣΤΑΘΜΟ ΠΑΡΑΛΑΒΗΣ';
                                wc_add_notice($message, 'error');
                            }
                            unset($wh);

                        }
                    } else {
                        continue;
                    }
                    $weight = 0;
                    foreach ($package['contents'] as $item_id => $values) {
                        $_product = $values['data'];
                        $weightkg = $_product->get_weight();
                        if ($weightkg == '' || $weightkg == null || $weightkg == '0') {
                            $weightkg = '0.1';
                        }
                        $weight = $weight + $weightkg * $values['quantity'];
                    }
                    $weight = wc_get_weight($weight, 'kg');
                    if ($maxweight != 0 && empty($maxweight)) {
                        if ($weight > $maxweight) {
                            $message = sprintf(__('Sorry, %d kg exceeds the maximum weight of %d kg for %s', $methodchosen), $weight, $maxweight, $kronosexpress_Shipping_Method->title);
                            $messageType = "error";
                            if (!wc_has_notice($message, $messageType)) {
                                wc_add_notice($message, $messageType);
                            }
                        }
                    }

                    $previousshippingcost = WC()->cart->shipping_total + WC()->cart->shipping_tax_total;
                    $fname = '';
                    $lname = '';
                    $cname = '';
                    if (isset($posted["ship_to_different_address"]) && $posted["ship_to_different_address"] == 1) {
                        $fname = sanitize_text_field($posted["shipping_first_name"]);
                        $lname = sanitize_text_field($posted["shipping_last_name"]);
                        if (isset($posted['shipping_company'])) {
                            $cname = sanitize_text_field($posted["shipping_company"]);
                        }
                    } else {
                        $fname = sanitize_text_field($posted["billing_first_name"]);
                        $lname = sanitize_text_field($posted["billing_last_name"]);
                        if (isset($posted['shipping_company'])) {
                            $cname = sanitize_text_field($posted["shipping_company"]);
                        }
                    }
                    $phone = sanitize_text_field($posted["billing_phone"]);

                    if ($methodchosen == 'kronosexpress_shipping_dexpress' || $methodchosen == 'kronosexpress_shipping_deconomy') {
                        WC()->session->set('kronosexpress_shipping_method_plugin', array(
                            'kronosexpress_shipping_method' => $methodchosen,
                            'kronosexpress_shipping_method_awb' => '',
                        ));
                    } else if ($methodchosen == 'kronosexpress_shipping_pexpress' || $methodchosen == 'kronosexpress_shipping_peconomy') {
                        WC()->session->set('kronosexpress_shipping_method_plugin', array(
                            'kronosexpress_shipping_method' => $methodchosen,
                            'kronosexpress_shipping_method_awb' => '',
                            'kronosexpress_shipping_method_station_code' => $stationcode,
                            'kronosexpress_shipping_method_station_name' => $stationname,
                        ));
                    }
                    // }
                }
            }
        } catch (Exception $ex) {
            $message = sprintf(__('Sorry, the shipping provider is not responding. Please refresh the page.', $methodchosen));
            $messageType = "error";
            if (!wc_has_notice($message, $messageType)) {
                wc_add_notice($message, $messageType);
            }
        }
    }

    add_action('woocommerce_shipping_init', 'kronosexpress_initialize');
    add_action('woocommerce_shipping_init', 'kronosexpresss_shipping_method_door_express');
    add_action('woocommerce_shipping_init', 'kronosexpresss_shipping_method_door_economy');
    add_action('woocommerce_shipping_init', 'kronosexpresss_shipping_method_point_express');
    add_action('woocommerce_shipping_init', 'kronosexpresss_shipping_method_point_economy');
    add_action('woocommerce_after_checkout_validation', 'kronosexpress_shipping_method_validation', 10);

    function add_kronosexpress_shipping_method($methods)
    {
        $methods['kronosexpress_shipping_woocommerce'] = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        $methods['kronosexpress_shipping_dexpress'] = new KRONOSEXPRESS_Shipping_Method_DEXPRESS();
        $methods['kronosexpress_shipping_deconomy'] = new KRONOSEXPRESS_Shipping_Method_DECONOMY();
        $methods['kronosexpress_shipping_pexpress'] = new KRONOSEXPRESS_Shipping_Method_PEXPRESS();
        $methods['kronosexpress_shipping_peconomy'] = new KRONOSEXPRESS_Shipping_Method_PECONOMY();
        return $methods;
    }

    add_action('wp_head', 'refresh_checkout');
    function refresh_checkout()
    {
        if (is_checkout()) {
            wp_enqueue_script('refresh_checkout_load', plugin_dir_url(__FILE__) . 'scripts/client/checkout_load.js', array('jquery'), '1.0', true);
        }
    }

    add_filter('woocommerce_shipping_methods', 'add_kronosexpress_shipping_method');

    add_action('add_meta_boxes', 'order_meta_box_kronosexpress');
    function order_meta_box_kronosexpress()
    {
        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        if ($plugin->enabled == 'no') {
            return false;
        }
        global $woocommerce, $order, $post;
        $meta = get_post_meta($post->ID);
        //if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
        add_meta_box(
            'woocommerce-order-kronosexpress-plugin-print',
            __('Print Kronos Express Label'),
            'order_meta_box_button_submit',
            'shop_order',
            'side',
            'default'
        );
        // } else {
        //     return false;
        // }
    }
    function order_meta_box_button_submit($param)
    {
        $meta = get_post_meta($param->ID);
        $m = null;
        if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
            $m = unserialize($meta['kronosexpress_shipping_method_plugin'][0]);
        }
        outputforms($m, $param->ID);
    }
    function outputforms($m, $id)
    {
        if ($m != null) {
            if (array_key_exists('user_selected', $m)) {
                if (isset($m['user_selected']) && $m['user_selected'] == '0' && $m['kronosexpress_shipping_method_awb'] == '') {
                    $order = wc_get_order($id);
                    $order->delete_meta_data('kronosexpress_shipping_method_plugin');
                    $order->save();
                    $m = null;
                }
            }
        }

        if ($m != null) {

            $method = $m["kronosexpress_shipping_method"];
            $awb = $m["kronosexpress_shipping_method_awb"];
            $nonce = wp_create_nonce('kronosexpress_bulk_actions');
            if (!empty($awb)) {
                $url = admin_url("admin-ajax.php") . '?action=kronosexpress_printlabels_action&ids=' . $id . '&nonce=' . $nonce;
                echo '<button class="button-primary" onclick="kronosexpress_open_tab(this,`' . $url . '`);return false;">Print</button>';
                $url = admin_url("admin-ajax.php") . '?action=kronosexpress_cancellabels_action&ids=' . $id . '&nonce=' . $nonce;
                echo '<button style="margin-left:5px" class="button-primary" onclick="kronosexpress_open_tab(this,`' . $url . '`);return false;">Cancel</button>';
            } else {
                $url = admin_url("admin-ajax.php") . '?action=kronosexpress_printlabels_action&ids=' . $id . '&nonce=' . $nonce;
                echo '<button class="button-primary" onclick="kronosexpress_open_tab(this,`' . $url . '`);return false;">Issue</button>';
                echo '<div style="display:block;padding-top:5px;padding-bottom:5px"><label><input type="checkbox" id="kronosexpress_ar" />Aller-Retour</label></div>';
            }
        } else {
            $nonce = wp_create_nonce('kronosexpress_bulk_actions');
            $url = admin_url("admin-ajax.php") . '?action=kronosexpress_printlabels_action&ids=' . $id . '&nonce=' . $nonce;
            echo '<button class="button-primary" onclick="kronosexpress_open_tab(this,`' . $url . '&method=kronosexpress_shipping_dexpress' . '`);return false;" style="margin-right:5px;">Issue Express</button>';
            echo '<button class="button-primary" onclick="kronosexpress_open_tab(this,`' . $url . '&method=kronosexpress_shipping_deconomy' . '`);return false;">Issue Economy</button>';
            echo '<div style="display:block;padding-top:5px;padding-bottom:5px"><label><input type="checkbox" id="kronosexpress_ar" />Aller-Retour</label></div>';
        }
    }

    add_action('woocommerce_checkout_update_order_meta', function ($order_id, $posted) {
        $order = wc_get_order($order_id);
        $method = WC()->session->get('kronosexpress_shipping_method_plugin');
        if ($method != null && is_array($method)) {
            $order->update_meta_data('kronosexpress_shipping_method_plugin', $method);
            $order->save();
        }
        WC()->session->__unset('kronosexpress_shipping_method_plugin');
    }, 10, 2);

    add_filter('woocommerce_checkout_update_order_review', 'clear_wc_shipping_rates_cache');

    function clear_wc_shipping_rates_cache()
    {
        delete_transient('shipping');
        $packages = WC()->cart->get_shipping_packages();

        foreach ($packages as $key => $value) {
            $shipping_session = "shipping_for_package_$key";
            unset(WC()->session->$shipping_session);
        }

    }

    add_filter('manage_edit-shop_order_columns', 'wc_new_order_column_tracking');
    add_action('manage_shop_order_posts_custom_column', 'wc_new_order_column_tracking_content');

    function wc_new_order_column_tracking_content($column)
    {
        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        if ($plugin->enabled == 'yes') {
            global $post;
            if ('kronosexpresscolumn' === $column) {
                $order = wc_get_order($post->ID);
                $meta = $order->get_meta('kronosexpress_shipping_method_plugin');
                //if (!empty($meta)) {
                outputforms($meta, $post->ID);
                //}
            }
        }
    }

    function wc_new_order_column_tracking($columns)
    {
        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        if ($plugin->enabled == 'no') {
            return $columns;
        }
        foreach ($columns as $column_name => $column_info) {
            $new_columns[$column_name] = $column_info;
            if ('order_total' === $column_name) {
                $new_columns['kronosexpresscolumn'] = __('KronosExpress', 'kronosexpress_shop_order_column');
            }
        }
        return $new_columns;
    }

    add_filter('bulk_actions-edit-shop_order', 'kronosexpress_bulk_actions_registration');
    function kronosexpress_bulk_actions_registration($actions)
    {
        $actions['kronosexpress_bulk_print'] = 'KronosExpress Print';
        $actions['kronosexpress_bulk_print_express'] = 'KronosExpress Print Express';
        $actions['kronosexpress_bulk_print_economy'] = 'KronosExpress Print Economy';
        $actions['kronosexpress_bulk_cancel'] = 'KronosExpress Cancel';
        return $actions;
    }

    function kronosexpress_quotation_sandboxaccount_scripts($hook)
    {
        if (is_admin() && get_current_screen()->id == 'woocommerce_page_wc-settings' && isset($_GET['section']) && $_GET['section'] == 'kronosexpress_shipping_woocommerce') {
            wp_enqueue_script('quotation_and_sandboxaccount', plugin_dir_url(__FILE__) . 'scripts/admin/quotation_and_sandboxaccount.js', false, rand(1000, 9999), true);
            $nonce = wp_create_nonce('quotation_and_sandboxaccount');
            wp_localize_script('quotation_and_sandboxaccount', 'kronosexpress_post_object', array(
                'nonce' => $nonce,
            ));
        } else if (is_admin() && (get_current_screen()->id == 'edit-shop_order' || get_current_screen()->id == 'shop_order')) {
            wp_enqueue_script('edit_shop_order_bulk', plugin_dir_url(__FILE__) . 'scripts/admin/edit_shop_order_bulk.js', false, rand(1000, 9999), true);
            $nonce = wp_create_nonce('kronosexpress_bulk_actions');
            wp_localize_script('edit_shop_order_bulk', 'kronosexpress_ajax_object', array(
                'create_url' => admin_url("admin-ajax.php") . '?action=kronosexpress_printlabels_action&ids=',
                'cancel_url' => admin_url("admin-ajax.php") . '?action=kronosexpress_cancellabels_action&ids=',
                'nonce' => $nonce,
            ));
        }
    }
    add_action('admin_enqueue_scripts', 'kronosexpress_quotation_sandboxaccount_scripts');

    add_shortcode('kronosexpress_tracking_system', 'kronosexpress_shortcode_tracking');
    function kronosexpress_shortcode_tracking()
    {
        ob_start();
        //require dirname(__FILE__) . '/request/tracking-system.php';
        //$track = new Kronosexpress_Tracking_System();
        echo GetHTMLTracking();
        return ob_get_clean();
    }

    add_action('wp_ajax_kronosexpress_tracking_action_submit', 'kronosexpress_tracking_action_submit_function');
    add_action('wp_ajax_nopriv_kronosexpress_tracking_action_submit', 'kronosexpress_tracking_action_submit_function');

    function kronosexpress_tracking_action_submit_function()
    {
        $post = $_POST;
        if (!isset($post['nonce']) || !isset($post['action']) || $post['action'] != 'kronosexpress_tracking_action_submit' || !isset($post['awb'])) {
            echo '';
            wp_die();
        }
        if (!wp_verify_nonce($post['nonce'], 'kronosexpress_tracking_client_js')) {echo '';
            wp_die();}
        if (!class_exists('KronosExpressAPI')) {
            require dirname(__FILE__) . '/API/request.php';
        }
        $awb = isset($post['awb']) ? sanitize_text_field($post['awb']) : '';
        $api = new KronosExpressAPI();
        // $te = $api->TraceEvents();
        // if (!is_array($te) || count($te) == 0) {
        //     echo 'Error: Please try again.';
        //     wp_die();
        // }

        $tt = $api->TrackAndTrace($awb);

        if (!is_array($tt) || count($tt) == 0) {
            echo __('REFERENCE NUMBER DOES NOT EXIST', 'kronosexpress_shipping_woocommerce');
            wp_die();
        }

        // foreach ($tt as $key => $t) {
        //     foreach ($te as $e) {
        //         if ($e['CODE'] == $t['STATUS']) {
        //             $tt[$key]['STATUS'] = $e['DES'];
        //             break;
        //         }
        //     }
        // }
        echo wp_send_json($tt);
        //$res = $api->TrackAndTrace($name, $company, $tel, $email, $qty, $comments);
        //if ($res->Status == 'Success') {echo "ok";} else {echo ($res->Status);}
        wp_die();
    }
    function GetHTMLTracking()
    {
        wp_enqueue_script('kronosexpress_tracking_client_js', plugin_dir_url(__FILE__) . 'scripts/client/tracking.js', array('jquery'), '1.0.0', true);
        $nonce = wp_create_nonce('kronosexpress_tracking_client_js');
        wp_localize_script('kronosexpress_tracking_client_js', 'tracking_var', array(
            'nonce' => $nonce,
            'url' => admin_url("admin-ajax.php"),
            'date' => __('DATE','kronosexpress_shipping_woocommerce'),
            'location' => __('LOCATION','kronosexpress_shipping_woocommerce'),
            'status' => __('STATUS','kronosexpress_shipping_woocommerce'),
            'errormsg' => __('ERROR. PLEASE RETRY','kronosexpress_shipping_woocommerce')
        ));
        wp_enqueue_script('kronosexpress_loading_js', plugin_dir_url(__FILE__) . '/scripts/admin/loading.js', array('jquery'), '3.3.7', true);
        wp_enqueue_style('kronosexpress_loading_css', plugin_dir_url(__FILE__) . '/styles/admin/loading.css', false, '1.0.0', 'all');

        $output = '<div id="spinner" class="loading" style="display: none">';
        $output .= 'Loading...';
        $output .= '</div>';
        $output .= '<div id="requestform" class="fluid">
                    <div class="col-lg-12" style="text-align: center">
                        <div style="padding-top: 20px;font-weight: 600">
                            <label>'. __('Tracking System', 'kronosexpress_shipping_woocommerce') .'</label>
                        </div>
                        <div style="">
                            <div style="padding-top: 10px">
                                <label style="width: 170px; text-align: right">'. __('Reference Number', 'kronosexpress_shipping_woocommerce') .'</label>
                                <input id="awb" type="text" class="form-control search" style="display: inline-block; width: 400px" onkeypress="kronosexpress_tracking_client_key_enter(event,this);" autocomplete="off">
                            </div>
                        </div>
                        <div style="padding-top: 20px">
                            <button id="btnsent" type="button" class="form-control fa fa-save" style="font-size: 15px; max-width: 200px; display: block; margin: 0 auto" onclick="request(); return false;"><span style="padding-left: 5px">'. __('SUBMIT', 'kronosexpress_shipping_woocommerce') .'</span></button>
                        </div>
                    </div>
                </div>

                <div class="fluid" id="tbl_tracking_kronosexpress" style="display:none;margin-top:20px">


                </div>
        ';

        return $output;
    }
    function load_js_checkout()
    {
        if (is_checkout()) {
            if (!class_exists('KronosExpressAPI')) {
                require dirname(__FILE__) . '/API/request.php';
            }
            kronosexpress_initialize();
            $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
            if ($plugin->enabled == 'yes') {
                wp_enqueue_script('show_pickup_points', plugin_dir_url(__FILE__) . 'scripts/client/show_pickup_points.js', array('jquery'), '1.1', true);
                wp_enqueue_script('update_order_when_payment_changed', plugin_dir_url(__FILE__) . 'scripts/client/checkout.js', array('jquery'), '1.0', true);
            }
        }
    };
    function action_woocommerce_after_shipping_rate($method, $index)
    {
        if (is_checkout()) {
            if (!class_exists('KronosExpressAPI')) {
                require dirname(__FILE__) . '/API/request.php';
            }
            kronosexpress_initialize();
            $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
            if ($plugin->enabled == 'yes') {
                if ($method->id == 'kronosexpress_shipping_pexpress' || $method->id == 'kronosexpress_shipping_peconomy') {
                    wp_enqueue_script('show_pickup_points', plugin_dir_url(__FILE__) . 'scripts/client/show_pickup_points.js', array('jquery'), '1.0', true);
                }
            }
            wp_enqueue_script('update_order_when_payment_changed', plugin_dir_url(__FILE__) . 'scripts/client/checkout.js', array('jquery'), '1.0', true);
        }
    };
    function after_shipping_add_kronosexpress_locations()
    {
        if (!class_exists('KronosExpressAPI')) {
            require dirname(__FILE__) . '/API/request.php';
        }
        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        if ($plugin->enabled == 'yes') {
            $api = new KronosExpressAPI();
            $wh = $api->GetWarehouses();
            $nicarray = [];
            $limarray = [];
            $lcaarray = [];
            $parray = [];
            $ammarray = [];
            $optgroups = [];
            
            


            $optgroups['default'] = __('PICKUP LOCATION', 'kronosexpress_shipping_woocommerce');
            $optgroups['nic'] = __('Nicosia', 'kronosexpress_shipping_woocommerce');
            $optgroups['lim'] = __('Limassol', 'kronosexpress_shipping_woocommerce');
            $optgroups['lca'] = __('Larnaca', 'kronosexpress_shipping_woocommerce');
            $optgroups['ph'] = __('Paphos', 'kronosexpress_shipping_woocommerce');
            $optgroups['fam'] = __('Famagusta', 'kronosexpress_shipping_woocommerce');


            $optgroups = apply_filters('translate_optgroups_kronosexpress', $optgroups);
            foreach ($wh as $w) {
                $postcode = $w['POSTCODE'];
                switch ($postcode) {
                    case "2000":
                        $nicarray[] = $w;
                        break;
                    case "3000":
                        $limarray[] = $w;
                        break;
                    case "5000":
                        $ammarray[] = $w;
                        break;
                    case "6000":
                        $lcaarray[] = $w;
                        break;
                    case "8000":
                        $parray[] = $w;
                        break;
                    default:
                        break;
                }
            }
            echo '<tr id="kronosexpress-shipping-points" style="display:none;"><td colspan=2>';
            echo '<select name="kronosexpress_shipping_pexpress_value" style="width: 100%;display:block">';
            echo '<option value="0">' . $optgroups['default'] . '</option>';
            echo '<optgroup label="' . $optgroups['nic'] . '">';
            foreach ($nicarray as $w) {
                echo '<option value="' . $w['CODE'] . '">' . $w['NAME'] . '</option>';
            }
            echo '</optgroup>';
            echo '<optgroup label="' . $optgroups['lim'] . '">';
            foreach ($limarray as $w) {
                echo '<option value="' . $w['CODE'] . '">' . $w['NAME'] . '</option>';
            }
            echo '</optgroup>';
            echo '<optgroup label="' . $optgroups['lca'] . '">';
            foreach ($lcaarray as $w) {
                echo '<option value="' . $w['CODE'] . '">' . $w['NAME'] . '</option>';
            }
            echo '</optgroup>';
            echo '<optgroup label="' . $optgroups['ph'] . '">';
            foreach ($parray as $w) {
                echo '<option value="' . $w['CODE'] . '">' . $w['NAME'] . '</option>';
            }
            echo '</optgroup>';
            echo '<optgroup label="' . $optgroups['fam'] . '">';
            foreach ($ammarray as $w) {
                echo '<option value="' . $w['CODE'] . '">' . $w['NAME'] . '</option>';
            }
            echo '</optgroup>';
            echo '</select>';
            echo '</td></tr>';
            unset($wh);
        }
    }
    add_action('woocommerce_review_order_after_shipping', 'after_shipping_add_kronosexpress_locations', 10);
    //add_action('woocommerce_after_shipping_rate', 'action_woocommerce_after_shipping_rate', 10, 2);
    add_action('wp_head', 'load_js_checkout');

    add_action('wp_ajax_kronosexpress_printlabels_action', 'kronosexpress_printlabels_submit');
    function kronosexpress_printlabels_submit()
    {
        if ((current_user_can('administrator') || current_user_can('manage_woocommerce')) && isset($_GET['ids']) && !empty($_GET['ids']) && isset($_GET['nonce']) && !empty($_GET['nonce'])) {

            if (!wp_verify_nonce($_GET['nonce'], 'kronosexpress_bulk_actions')) {
                return null;
            }

            kronosexpress_initialize();
            $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
            if ($plugin->enabled == 'no') {
                echo __('The plugin must be enabled', 'kronosexpress_shipping_woocommerce');
                exit();
            }
            $sentemailbool = 0;
            if ($plugin->sendemailtracking == 'yes') {
                $sentemailbool = 1;
            }
            $errors = '';
            $ids = explode(',', $_GET['ids']);
            if (count($ids) == 1) {
                if (!intval($ids[0])) {
                    echo 'Order is invalid';
                    exit();
                }
                $meta = get_post_meta($ids[0]);
                $order = wc_get_order($ids[0]);
                if (!array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                    $methodchosen = isset($_GET['method']) ? $_GET['method'] : '';
                    if ($methodchosen != '') {
                        $order->update_meta_data('kronosexpress_shipping_method_plugin', array(
                            'kronosexpress_shipping_method' => $methodchosen,
                            'kronosexpress_shipping_method_awb' => '',
                            'user_selected' => '0',
                        ));
                        $order->save();
                        $meta = get_post_meta($ids[0]);
                    } else {
                        echo 'You must select delivery method, either express or economy for the order number: ' . $ids[0] . '.';
                        exit();
                    }
                }

                if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                    $order = wc_get_order($ids[0]);
                    $meta1 = $order->get_meta('kronosexpress_shipping_method_plugin');
                    if (!class_exists('KronosExpressAPI')) {
                        require dirname(__FILE__) . '/API/request.php';
                    }

                    $code = $order->get_customer_id();
                    $fname = $order->get_shipping_first_name();
                    $sname = $order->get_shipping_last_name();
                    if (!empty($order->get_shipping_company())) {
                        $sname = $fname . ' ' . $sname;
                        $fname = $order->get_shipping_company();
                    }
                    $address = $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2() . ' ' . $order->get_shipping_state();
                    $postcode = $order->get_shipping_postcode();
                    $city = $order->get_shipping_city();
                    $country = $order->get_shipping_country();
                    if (strtoupper($country) != 'CY') {
                        echo 'The selected service is only for Cyprus.';
                        exit();
                    }
                    $phone = $order->get_billing_phone();
                    $comments = 'Order Number: ' . $order->get_order_number() . ' - Comments: ' . $order->get_customer_note();
                    $email = $order->get_billing_email();
                    $total_weight = 0;
                    foreach ($order->get_items() as $item_id => $product_item) {
                        $quantity = $product_item->get_quantity();
                        $product = $product_item->get_product();
                        $product_weight = $product->get_weight();
                        if ($product_weight == '' || $product_weight == null || $product_weight == '0') {
                            $product_weight = '0.1';
                        }
                        $total_weight += floatval($product_weight * $quantity);
                    }
                    $weight = wc_get_weight($total_weight, 'kg');

                    $paymentmethod = $order->get_payment_method();
                    $cod = 0;
                    if ($paymentmethod == 'cod') {
                        $cod = $order->get_total();
                    }

                    $api = new KronosExpressAPI();
                    if (empty($meta1['kronosexpress_shipping_method_awb'])) {
                        $stationcode = 'NH';
                        $todoor = true;
                        $type = '002';
                        if ($meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_pexpress' || $meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_peconomy') {
                            $stationcode = $meta1['kronosexpress_shipping_method_station_code'];
                            $todoor = false;
                        }
                        $loc = $api->GetEshopLocation();
                        if ($loc != 'CYPRUS') {
                            if ($meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_dexpress' || $meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_pexpress') {
                                $type = '003';
                            } else if ($meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_deconomy' || $meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_peconomy') {
                                $type = '004';
                            }
                        }
                        if (!is_double($weight)) {
                            $weight = number_format((float) $weight, 2, '.', '');
                        }
                        if ($cod >= 0) {
                            if (!is_double($cod)) {
                                $cod = number_format((float) $cod, 2, '.', '');
                            }
                        }
                        $address = str_replace('-', ' ', $address);
                        $address = str_replace('-', ' ', $address);
                        $address = str_replace('(', ' ', $address);
                        $address = str_replace(')', '', $address);
                        $address = str_replace('<', ' ', $address);
                        $address = str_replace('>', ' ', $address);
                        $address = str_replace('&', ' ', $address);
                        $address = str_replace('%', ' ', $address);
                        $address = str_replace('"', '', $address);
                        $address = str_replace("'", '', $address);
                        $ar = isset($_GET['ar']) ? 1 : 0;
                        $awb = $api->Announce($code, $fname, $sname, $address, $postcode, $city, $phone, $comments, $weight, $email, $stationcode, $cod, $todoor, $ar, $type);
                        if ($awb->Status == 'Success') {
                            $meta1['kronosexpress_shipping_method_awb'] = (string) $awb->AWB;
                            $order->update_meta_data('kronosexpress_shipping_method_plugin', $meta1);
                            $order->add_order_note((string) $awb->AWB . '<br><a href="https://tracking.kronosexpress.com/tracking_system.aspx?tracking_number=' . (string) $awb->AWB . '" target="_blank">'. __('Track your parcel','kronosexpress_shipping_woocommerce') .'</a>', $sentemailbool,true);
                            $order->save();
                            $url = $api->GetURLPrintLabel($awb->AWB);
                            if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                                echo 'Something went wrong. Please try again.';
                                exit();
                            }

                            wp_redirect($url);
                            exit();
                        } else {

                            echo 'Something went wrong. Please try again.';
                            exit();
                        }
                    } else {
                        $url = $api->GetURLPrintLabel($meta1['kronosexpress_shipping_method_awb']);
                        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                            echo 'Something went wrong. Please try again.';
                            exit();
                        }
                        wp_redirect($url);
                        exit();
                    }
                }
            } else {
                if (!class_exists('KronosExpressAPI')) {
                    require dirname(__FILE__) . '/API/request.php';
                }

                $awbs = '';
                $wrongawbs = '';
                foreach ($ids as $i) {
                    if (!intval($i)) {

                        continue;
                    }
                    $meta = get_post_meta($i);
                    $order = wc_get_order($i);
                    if (!array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                        $methodchosen = isset($_GET['method']) ? $_GET['method'] : '';
                        if ($methodchosen != '') {
                            $order->update_meta_data('kronosexpress_shipping_method_plugin', array(
                                'kronosexpress_shipping_method' => $methodchosen,
                                'kronosexpress_shipping_method_awb' => '',
                                'user_selected' => '0',
                            ));
                            $order->save();
                            $meta = get_post_meta($i);
                        } else {
                            echo 'You must select delivery method, either express or economy for the order number: ' . $i . '.<br>';
                            $errors = '0';
                            continue;
                        }
                    }
                    if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                        $meta1 = $order->get_meta('kronosexpress_shipping_method_plugin');
                        $order = wc_get_order($i);
                        $code = $order->get_customer_id();
                        $fname = $order->get_shipping_first_name();
                        $sname = $order->get_shipping_last_name();
                        if (!empty($order->get_shipping_company())) {
                            $sname = $fname . ' ' . $sname;
                            $fname = $order->get_shipping_company();
                        }
                        $address = $order->get_shipping_address_1() . ' ' . $order->get_shipping_address_2() . ' ' . $order->get_shipping_state();
                        $postcode = $order->get_shipping_postcode();
                        $city = $order->get_shipping_city();
                        $country = $order->get_shipping_country();
                        if (strtoupper($country) != 'CY') {
                            echo 'The order number: ' . $i . ' has invalid country. Only allowed country is Cyprus';
                            $errors = '0';
                            continue;
                        }
                        $phone = $order->get_billing_phone();
                        $comments = 'Order Number: ' . $order->get_order_number() . ' - Comments: ' . $order->get_customer_note();
                        $email = $order->get_billing_email();
                        $total_weight = 0;
                        foreach ($order->get_items() as $item_id => $product_item) {
                            $quantity = $product_item->get_quantity();
                            $product = $product_item->get_product();
                            $product_weight = $product->get_weight();
                            if ($product_weight == '' || $product_weight == null || $product_weight == '0') {
                                $product_weight = '0.1';
                            }
                            $total_weight += floatval($product_weight * $quantity);
                        }
                        $weight = wc_get_weight($total_weight, 'kg');

                        $paymentmethod = $order->get_payment_method();
                        $cod = 0;
                        if ($paymentmethod == 'cod') {
                            $cod = $order->get_total();
                        }

                        $api = new KronosExpressAPI();
                        if (empty($meta1['kronosexpress_shipping_method_awb'])) {
                            $stationcode = 'NH';
                            $todoor = true;
                            $type = '002';
                            if ($meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_pexpress' || $meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_peconomy') {
                                $stationcode = $meta1['kronosexpress_shipping_method_station_code'];
                                $todoor = false;
                            }
                            $loc = $api->GetEshopLocation();
                            if ($loc != 'CYPRUS') {
                                if ($meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_dexpress' || $meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_pexpress') {
                                    $type = '003';
                                } else if ($meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_deconomy' || $meta1['kronosexpress_shipping_method'] == 'kronosexpress_shipping_peconomy') {
                                    $type = '004';
                                }
                            }
                            if (!is_double($weight)) {
                                $weight = number_format((float) $weight, 2, '.', '');
                            }
                            if ($cod >= 0) {
                                if (!is_double($cod)) {
                                    $cod = number_format((float) $cod, 2, '.', '');
                                }
                            }
                            $address = str_replace('-', ' ', $address);
                            $address = str_replace('-', ' ', $address);
                            $address = str_replace('(', ' ', $address);
                            $address = str_replace(')', '', $address);
                            $address = str_replace('<', ' ', $address);
                            $address = str_replace('>', ' ', $address);
                            $address = str_replace('&', ' ', $address);
                            $address = str_replace('%', ' ', $address);
                            $address = str_replace('"', '', $address);
                            $address = str_replace("'", '', $address);
                            $ar = isset($_GET['ar']) ? 1 : 0;
                            $awb = $api->Announce($code, $fname, $sname, $address, $postcode, $city, $phone, $comments, $weight, $email, $stationcode, $cod, $todoor, $ar, $type);
                            if ($awb->Status == 'Success') {
                                $meta1['kronosexpress_shipping_method_awb'] = (string) $awb->AWB;
                                $order->update_meta_data('kronosexpress_shipping_method_plugin', $meta1);
                                $order->add_order_note((string) $awb->AWB . '<br><a href="https://tracking.kronosexpress.com/tracking_system.aspx?tracking_number=' . (string) $awb->AWB . '" target="_blank">'.__('Track your parcel','kronosexpress_shipping_woocommerce') .'</a>', $sentemailbool, true);
                                $order->save();
                                $awbs .= (string) $awb->AWB . ',';
                            } else {
                                $wrongawbs .= (string) $awb->AWB . ',';
                            }
                        } else {
                            $awbs .= $meta1['kronosexpress_shipping_method_awb'] . ',';
                        }
                    }
                }
                if (isset($api)) {
                    $url = $api->GetURLPrintLabel($awbs);
                    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                        echo 'Something went wrong. Please try again.';
                        exit();
                    }
                }
                if (isset($url) && $errors == '0') {
                    echo '<script type="text/javascript"> document.addEventListener("DOMContentLoaded", function(event) {
                    window.open("' . $url . '","_blank")});  </script>';
                } else if (isset($url) && $errors == '') {
                    wp_redirect($url);
                }
                exit();
            }
        }
    }

    add_action('wp_ajax_kronosexpress_cancellabels_action', 'kronosexpress_cancellabels_submit');
    function kronosexpress_cancellabels_submit()
    {
        if ((current_user_can('administrator') || current_user_can('manage_woocommerce')) && isset($_GET['ids']) && !empty($_GET['ids']) && isset($_GET['nonce']) && !empty($_GET['nonce'])) {

            if (!wp_verify_nonce($_GET['nonce'], 'kronosexpress_bulk_actions')) {
                return null;
            }
            kronosexpress_initialize();
            $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
            if ($plugin->enabled == 'no') {
                echo __('The plugin must be enabled', 'kronosexpress_shipping_woocommerce');
                exit();
            }
            $sentemailbool = 0;
            if ($plugin->sendemailtracking == 'yes') {
                $sentemailbool = 1;
            }
            $ids = explode(',', $_GET['ids']);
            if (count($ids) == 1) {
                if (!intval($ids)) {
                    echo 'Invalid Order Number';
                    exit();
                }
                $meta = get_post_meta($ids[0]);
                if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                    $order = wc_get_order($ids[0]);
                    $meta1 = $order->get_meta('kronosexpress_shipping_method_plugin');
                    if (!class_exists('KronosExpressAPI')) {
                        require dirname(__FILE__) . '/API/request.php';
                    }
                    //$api = new KronosExpressAPI('speedex', '1234', 'wehaui31u98uadfh18h');
                    $api = new KronosExpressAPI();
                    if (empty($meta1['kronosexpress_shipping_method_awb'])) {
                        echo 'There is not a voucher created for this order. Please create one first.';
                        exit();
                    } else {
                        $res = $api->CancelLabel($meta1['kronosexpress_shipping_method_awb']);
                        if ($res->Status == 'Success') {
                            $order->add_order_note(__('The voucher ','kronosexpress_shipping_woocommerce') . $meta1['kronosexpress_shipping_method_awb'] . __(' has been cancelled.','kronosexpress_shipping_woocommerce'), $sentemailbool, true);
                            echo 'The voucher ' . $meta1['kronosexpress_shipping_method_awb'] . ' has been cancelled. Please close this window';
                            $meta1['kronosexpress_shipping_method_awb'] = '';
                            if (array_key_exists('user_selected', $meta1)) {
                                $order->delete_meta_data('kronosexpress_shipping_method_plugin');
                            } else {
                                $order->update_meta_data('kronosexpress_shipping_method_plugin', $meta1);
                            }
                            $order->save();
                        } else if ($res->Status == 'InvalidAWB') {
                            echo 'The voucher is not correct.';
                        } else if ($res->Status == 'HasMovement') {
                            echo 'The voucher has already been received by Kronos Express and cannot be cancelled.';
                        } else {
                            $meta1['kronosexpress_shipping_method_awb'] = '';
                            if (array_key_exists('user_selected', $meta1)) {
                                $order->delete_meta_data('kronosexpress_shipping_method_plugin');
                            } else {
                                $order->update_meta_data('kronosexpress_shipping_method_plugin', $meta1);
                            }
                            $order->save();
                            echo 'The voucher ' . $meta1['kronosexpress_shipping_method_awb'] . ' does not exists.', PHP_EOL;
                            echo 'Please Print a new one.';
                        }
                        //echo $res->Status;
                        exit();
                    }
                }
            } else {
                if (!class_exists('KronosExpressAPI')) {
                    require dirname(__FILE__) . '/API/request.php';
                }
                $awbs = [];
                foreach ($ids as $i) {
                    if (!intval($i)) {
                        $awbs[] = array(
                            'OrderNumber' => $i,
                            'Status' => 'Invalid',
                        );
                        continue;
                    }
                    $meta = get_post_meta($i);
                    if (array_key_exists('kronosexpress_shipping_method_plugin', $meta)) {
                        $order = wc_get_order($i);
                        $meta1 = $order->get_meta('kronosexpress_shipping_method_plugin');

                        $api = new KronosExpressAPI();
                        if (empty($meta1['kronosexpress_shipping_method_awb'])) {
                            $awbs[] = array(
                                'OrderNumber' => $i,
                                'Status' => 'There is not a voucher created for this order. Please create one first.',
                            );
                        } else {
                            $res = $api->CancelLabel($meta1['kronosexpress_shipping_method_awb']);
                            if ($res->Status == 'Success') {
                                $order->add_order_note(__('The voucher ','kronosexpress_shipping_woocommerce') . $meta1['kronosexpress_shipping_method_awb'] . __(' has been cancelled.','kronosexpress_shipping_woocommerce'), $sentemailbool,true);
                                $meta1['kronosexpress_shipping_method_awb'] = '';

                                if (array_key_exists('user_selected', $meta1)) {
                                    $order->delete_meta_data('kronosexpress_shipping_method_plugin');
                                } else {
                                    $order->update_meta_data('kronosexpress_shipping_method_plugin', $meta1);
                                }
                                $order->save();
                                $awbs[] = array(
                                    'OrderNumber' => $i,
                                    'Status' => 'The voucher ' . $meta1['kronosexpress_shipping_method_awb'] . ' has been cancelled. Please close this window',
                                );
                                //echo 'The voucher can been cancelled. Please close this window';
                            } else if ($res->Status == 'InvalidAWB') {
                                $awbs[] = array(
                                    'OrderNumber' => $i,
                                    'Status' => 'The voucher is not correct.',
                                );
                                //echo 'The voucher is not correct.';
                            } else if ($res->Status == 'HasMovement') {
                                $awbs[] = array(
                                    'OrderNumber' => $i,
                                    'Status' => 'The voucher has already been received by Kronos Express and cannot be cancelled.',
                                );
                            } else {
                                $meta1['kronosexpress_shipping_method_awb'] = '';
                                if (array_key_exists('user_selected', $meta1)) {
                                    $order->delete_meta_data('kronosexpress_shipping_method_plugin');
                                } else {
                                    $order->update_meta_data('kronosexpress_shipping_method_plugin', $meta1);
                                }
                                $order->save();
                                $awbs[] = array(
                                    'OrderNumber' => $i,
                                    'Status' => 'The voucher ' . $meta1['kronosexpress_shipping_method_awb'] . ' does not exists. Please Print a new one.',
                                );
                            }
                        }
                    }
                }
                echo '<table border=1>';
                echo '<thead>';
                echo '<tr>';
                echo '<td>OrderNumber</td>';
                echo '<td>Status</td>';
                echo '</thead>';
                echo '</tr>';
                echo '<tbody>';
                foreach ($awbs as $a) {
                    echo '<tr>';
                    echo '<td>' . $a['OrderNumber'] . '</td>';
                    echo '<td>' . $a['Status'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                exit();
            }
        }
    }
    if (!function_exists('write_log')) {
        function write_log($log)
        {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

    add_action('wp_ajax_kronosexpress_create_sandbox_action', 'kronosexpress_create_sandbox_function');
    function kronosexpress_create_sandbox_function()
    {
        $post = $_POST;
        if (!isset($post['nonce']) || !isset($post['action']) || $post['action'] != 'kronosexpress_create_sandbox_action') {
            echo '';
            wp_die();
        }
        if (!wp_verify_nonce($post['nonce'], 'kronosexpress_sandbox_js')) {echo '';
            wp_die();}

        if (!class_exists('KronosExpressAPI')) {
            require dirname(__FILE__) . '/API/request.php';
        }
        $api = new KronosExpressAPI();
        $firstname = isset($post['firstname']) ? sanitize_text_field($post['firstname']) : '';
        $surname = isset($post['surname']) ? sanitize_text_field($post['surname']) : '';
        $email = isset($post['email']) ? sanitize_email($post['email']) : '';
        $res = $api->CreateSandboxAccount($email, $firstname, $surname);
        if ($res->Status == 'ok') {echo "ok";} else {echo (string) $res->Status;}
        wp_die();
    }
    add_action('wp_ajax_kronosexpress_quotation_action_submit', 'kronosexpress_quotation_submit_function');
    function kronosexpress_quotation_submit_function()
    {
        $post = $_POST;
        if (!isset($post['nonce']) || !isset($post['action']) || $post['action'] != 'kronosexpress_quotation_action_submit') {
            echo '';
            wp_die();
        }
        if (!wp_verify_nonce($post['nonce'], 'kronosexpress_quotation_js')) {echo '';
            wp_die();}

        if (!class_exists('KronosExpressAPI')) {
            require dirname(__FILE__) . '/API/request.php';
        }
        $email = isset($post['email']) ? sanitize_text_field($post['email']) : '';
        $name = isset($post['name']) ? sanitize_text_field($post['name']) : '';
        $company = isset($post['company']) ? sanitize_text_field($post['company']) : '';
        $tel = isset($post['tel']) ? sanitize_text_field($post['tel']) : '';
        $qty = isset($post['quantity']) ? sanitize_text_field($post['quantity']) : '';
        $comments = isset($post['comments']) ? sanitize_text_field($post['comments']) : '';
        if (strlen($comments) > 200) {
            $comments = substr($comments, 0, 200 - 1);
        }
        // if (!intval($qty)) {
        //     echo 'Quantity is not correct.';
        //     wp_die();
        // }
        // if (!empty($email)) {
        //     if (!is_email($email)) {
        //         echo 'Email address is not correct';
        //         wp_die();
        //     } else {
        $email = sanitize_email($email);
        //     }
        // }
        $api = new KronosExpressAPI();
        $res = $api->CreateQuotation($name, $company, $tel, $email, $qty, $comments);
        if ($res->Status == 'Success') {echo "ok";} else {echo ($res->Status);}
        wp_die();
    }

    add_action('admin_menu', 'kronosexpress_create_sandbox_and_quotation_menu');
    function kronosexpress_create_sandbox_and_quotation_menu()
    {
        add_submenu_page(
            null,
            'Kronos Express Sandbox',
            'Kronos Express Sandbox',
            'manage_options',
            'kronosexpress_create_sandbox_page',
            'kronosexpress_create_sandbox_cb'
        );
        add_submenu_page(
            null,
            'Kronos Express Quotation',
            'Kronos Express Quotation',
            'manage_options',
            'kronosexpress_quotation_page',
            'kronosexpress_quotation_cb'
        );
    }
    function kronosexpress_create_sandbox_cb()
    {
        if (!wp_verify_nonce($_GET['nonce'], 'quotation_and_sandboxaccount')) {return null;}
        wp_enqueue_script('jquery');
        wp_enqueue_script('kronosexpress_bootstrap_js', plugin_dir_url(__FILE__) . '/scripts/admin/bootstrap.min.js', array('jquery'), '3.3.7', true);
        wp_enqueue_script('kronosexpress_loading_js', plugin_dir_url(__FILE__) . '/scripts/admin/loading.js', array('jquery'), '3.3.7', true);
        wp_enqueue_script('kronosexpress_sandbox_js', plugin_dir_url(__FILE__) . '/scripts/admin/sandbox.js', array('jquery'), '1.0.0', true);
        $nonce = wp_create_nonce('kronosexpress_sandbox_js');
        wp_localize_script('kronosexpress_sandbox_js', 'sandbox_var', array(
            'nonce' => $nonce,
            'url' => admin_url("admin-ajax.php"),
        ));

        wp_enqueue_style('kronosexpress_fontawesome_css', plugin_dir_url(__FILE__) . '/styles/admin/fontawesome.css', false, '4.7.0', 'all');
        wp_enqueue_style('kronosexpress_bootstrap_css', plugin_dir_url(__FILE__) . '/styles/admin/bootstrap.css', false, '3.3.7', 'all');
        wp_enqueue_style('kronosexpress_loading_css', plugin_dir_url(__FILE__) . '/styles/admin/loading.css', false, '1.0.0', 'all');

        echo '<div id="spinner" class="loading" style="display: none">';
        echo 'Loading...';
        echo '</div>';
        echo '<div id="requestform" class="fluid">
                    <div class="col-lg-12" style="text-align: center">
                        <div style="padding-top: 20px;font-weight: 600">
                            <label>' . __('CREATE SANDBOX ACCOUNT', 'kronosexpress_shipping_woocommerce') . ' </label>
                        </div>
                        <div style="">
                            <div style="padding-top: 10px">
                                <label style="width: 170px; text-align: right">' . __('* NAME', 'kronosexpress_shipping_woocommerce') . ':</label>
                                <input id="firstname" type="text" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                            </div>
                            <div style="padding-top: 10px">
                                <label style="width: 170px; text-align: right">' . __('* SURNAME', 'kronosexpress_shipping_woocommerce') . ':</label>
                                <input id="surname" type="text" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                            </div>
                            <div style="padding-top: 10px">
                                <label style="width: 170px; text-align: right">* EMAIL:</label>
                                <input id="email" type="email" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                            </div>
                        </div>
                        <div style="padding-top: 20px">
                            <button id="btnsent" type="button" class="form-control fa fa-save" style="color: black; font-size: 15px; max-width: 200px; display: block; margin: 0 auto" onclick="request(); return false;"><span style="padding-left: 5px">' . __('SUBMIT', 'kronosexpress_shipping_woocommerce') . '</span></button>
                        </div>
                    </div>
                </div>

                <div  class="fluid" id="success" style="display:none">
                    <div class="col-lg-12" style="text-align: center">
                        <div style="padding-top: 20px;font-weight: 500">
                            <label>' . __('Thank you. Please check your email!', 'kronosexpress_shipping_woocommerce') . '</label>
                        </div>
                    </div>

                    <div class="col-lg-12" style="text-align: center">
                        <div style="padding-top: 20px;font-weight: 500">
                        <button type="button" class="form-control fa fa-close" style="color: black; font-size: 15px; max-width: 200px; display: block; margin: 0 auto" onclick="window.close();"><span style="padding-left: 5px">' . __('CLOSE', 'kronosexpress_shipping_woocommerce') . '</span></button>
                        </div>
                    </div>

                </div>
        ';

    }
    function kronosexpress_quotation_cb()
    {
        if (!wp_verify_nonce($_GET['nonce'], 'quotation_and_sandboxaccount')) {return null;}
        wp_enqueue_script('jquery');
        wp_enqueue_script('kronosexpress_bootstrap_js', plugin_dir_url(__FILE__) . '/scripts/admin/bootstrap.min.js', array('jquery'), '3.3.7', true);
        wp_enqueue_script('kronosexpress_loading_js', plugin_dir_url(__FILE__) . '/scripts/admin/loading.js', array('jquery'), '3.3.7', true);

        wp_enqueue_script('kronosexpress_quotation_js', plugin_dir_url(__FILE__) . '/scripts/admin/quotation.js', array('jquery'), '1.0.0', true);
        $nonce = wp_create_nonce('kronosexpress_quotation_js');
        wp_localize_script('kronosexpress_quotation_js', 'quotation_var', array(
            'nonce' => $nonce,
            'url' => admin_url("admin-ajax.php"),
        ));

        wp_enqueue_style('kronosexpress_fontawesome_css', plugin_dir_url(__FILE__) . '/styles/admin/fontawesome.css', false, '4.7.0', 'all');
        wp_enqueue_style('kronosexpress_bootstrap_css', plugin_dir_url(__FILE__) . '/styles/admin/bootstrap.css', false, '3.3.7', 'all');
        wp_enqueue_style('kronosexpress_loading_css', plugin_dir_url(__FILE__) . '/styles/admin/loading.css', false, '1.0.0', 'all');

        echo '<div id="spinner" class="loading" style="display: none">';
        echo 'Loading...';
        echo '</div>';
        echo '<div id="requestform" class="fluid">
        <div class="col-lg-12" style="text-align: center">
            <div style="padding-top: 20px;font-weight: 600">
                <label>' . __('ACCOUNT REQUEST', 'kronosexpress_shipping_woocommerce') . '</label>
            </div>
            <div style="">
                <label style="margin-top: 20px; font-weight: 500">' . __('CONTACT DETAILS', 'kronosexpress_shipping_woocommerce') . '</label>
                <div style="padding-top: 10px">
                    <label style="width: 170px; text-align: right">' . __('* NAME', 'kronosexpress_shipping_woocommerce') . ':</label>
                    <input id="name" type="text" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                </div>
                <div style="padding-top: 10px">
                    <label style="width: 170px; text-align: right">' . __('COMPANY', 'kronosexpress_shipping_woocommerce') . ':</label>
                    <input id="company" type="text" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                </div>
                <div style="padding-top: 10px">
                    <label style="width: 170px; text-align: right">' . __('* TELEPHONE', 'kronosexpress_shipping_woocommerce') . ':</label>
                    <input id="tel" type="text" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                </div>
                <div style="padding-top: 10px">
                    <label style="width: 170px; text-align: right">* EMAIL:</label>
                    <input id="email" type="email" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" autocomplete="off">
                </div>
            </div>
            <div style="max-width: 800px; margin: 0 auto; color: lightgray">
                <hr style="border-width: 2px">
            </div>
            <div style="">
                <label style="margin-top: 0px; font-weight: 500">' . __('NUMBER OF ORDERS', 'kronosexpress_shipping_woocommerce') . '</label>
                <div style="padding-top: 10px">
                    <label style="width: 170px; text-align: right">' . __('MONTHLY', 'kronosexpress_shipping_woocommerce') . ':</label>
                    <input id="quantity" type="number" class="form-control search" style="display: inline-block; width: 400px" onkeypress="" min="0" value="0" autocomplete="off">
                </div>
            </div>
            <div style="max-width: 800px; margin: 0 auto; color: lightgray">
                <hr style="border-width: 2px">
            </div>
            <div style="">
                <label style="margin-top: 0px; font-weight: 500">' . __('COMMENTS', 'kronosexpress_shipping_woocommerce') . '</label>
                <div style="padding-top: 10px">
                    <textarea id="comments" class="form-control search" style="display: inline-block; width: 400px" cols="20" rows="7" onkeypress="" autocomplete="off"></textarea>
                </div>
            </div>

            <div style="padding-top: 20px">
                <button id="btnsent" type="button" class="form-control fa fa-save" style="color: black; font-size: 15px; max-width: 200px; display: block; margin: 0 auto" onclick="request(); return false;"><span style="padding-left: 5px">' . __('SUBMIT', 'kronosexpress_shipping_woocommerce') . '</span></button>
            </div>
        </div>
    </div>

    <div  class="fluid" id="success" style="display:none">
        <div class="col-lg-12" style="text-align: center">
            <div style="padding-top: 20px;font-weight: 500">
                <label>' . __('Thank you. Your application has been submitted. We will contact you as soon as possible!', 'kronosexpress_shipping_woocommerce') . '</label>
            </div>
        </div>

        <div class="col-lg-12" style="text-align: center">
            <div style="padding-top: 20px;font-weight: 500">
            <button type="button" class="form-control fa fa-close" style="color: black; font-size: 15px; max-width: 200px; display: block; margin: 0 auto" onclick="window.close();"><span style="padding-left: 5px">' . __('CLOSE', 'kronosexpress_shipping_woocommece') . '</span></button>
            </div>
        </div>

    </div>
';

    }
}
