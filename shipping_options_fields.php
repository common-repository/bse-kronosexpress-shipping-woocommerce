<?php
if (!defined('WPINC')) {
    die;
}

if (!defined('ABSPATH')) {
    exit;
}

class KronosExpressShippingOptionsFields
{
    public $id = '';
    public $that = '';
    public function __construct($shippingid, $shippingoption)
    {
        $this->id = $shippingid;
        $this->that = $shippingoption;
    }
    public function get_options()
    {
        $multiliqualdetection = '';
        if (!function_exists('is_plugin_active')) {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }
        if (is_plugin_active('polylang/polylang.php')) {
            $multiliqualdetection = '<br><strong>Use the "string translation" menu on Polylang to translate the title.</strong>';
        } else if (has_filter('wpml_translate_single_string')) {
            $multiliqualdetection = '<br><strong>Use the "string translation" menu on WPML to translate the title.</strong>';
        }

        return array(
            'displaytitle' => array(
                'title' => __('Title', 'kronosexpress_shipping_woocommerce'),
                'type' => 'text',
                'description' => __('Define what customers see at the checkout as of shipping title. Leave it empty for the default title.' . $multiliqualdetection, 'kronosexpress_shipping_woocommerce'),
                'default' => __($this->that->title, 'kronosexpress_shipping_woocommerce'),
            ),
            'price' => array(
                'title' => __('Flat Rate', 'kronosexpress_shipping_woocommerce'),
                'type' => 'number',
                'description' => __('The shipping cost that will appear on cart and checkout pages. The value must be in format of X.XX ', 'kronosexpress_shipping_woocommerce'),
                'default' => __('0', 'kronosexpress_shipping_woocommerce'),
            ),
            'realtime' => array(
                'title' => __('Get rates in real time', 'kronosexpress_shipping_woocommerce'),
                'type' => 'checkbox',
                'description' => __('The plugin will get prices in realtime on checkout/cart pages and disable flat rate option. '),
                'default' => __('0', 'kronosexpress_shipping_woocommerce'),
            ),
            'realtimefee' => array(
                'title' => __('Handing Fee', 'kronosexpress_shipping_woocommerce'),
                'type' => 'number',
                'description' => __('Fee to charge on top of Realtime price. The value must be in format of X.XX', 'kronosexpress_shipping_woocommerce'),
                'default' => __('0', 'kronosexpress_shipping_woocommerce'),
            ),
            'cartpricerange' => array(
                'title' => __('Rates based on Cart amount', 'kronosexpress_shipping_woocommerce'),
                'type' => 'pricerange',
                'description' => __('Add shipping fees based on cart amount in range from - to. The values must be in format of X.XX', 'kronosexpress_shipping_woocommerce'),
                'default' => '0',
            ),
            'cartpricerange_data' => array(
                'type' => 'multiselect',
                'css' => 'display:none'
            ),
            'taxable' => array(
                'title' => __('Tax status', 'kronosexpress_shipping_woocommerce'),
                'type' => 'select',
                'options' => array(
                    'taxable' => 'Taxable',
                    'none' => 'None',
                ),
                'default' => __('taxable', 'kronosexpress_shipping_woocommerce'),
            ),
            'freeshipping' => array(
                'title' => __('Free Shipping', 'kronosexpress_shipping_woocommerce'),
                'type' => 'number',
                'description' => __('Enter the total cart value, excluding shipping and taxes, where this shipping option will offer free shipping. Leave empty value to disable free shipping'),
                'default' => __('', 'kronosexpress_shipping_woocommerce'),
            ),
            'weightmax' => array(
                'title' => __('Maximum Weight IN KG', 'kronosexpress_shipping_woocommerce'),
                'type' => 'number',
                'description' => __('It will not show on checkout if total weight of all items is more than the specified value <br> Set the value to 0 or empty for unlimited weight.', 'kronosexpress_shipping_woocommerce'),
                'default' => __('0', 'kronosexpress_shipping_woocommerce'),
            ),
        );
    }

    public function validate_options()
    {
        if (!$this->that->instance_id) {
            return $this->that::process_admin_options();
        }
        if (!isset($_REQUEST['instance_id']) || absint($_REQUEST['instance_id']) !== $this->that->instance_id) {
            return false;
        }

        if (!isset($_REQUEST['action']) || $_REQUEST['action'] != 'woocommerce_shipping_zone_methods_save_settings') {
            return false;
        }

        if (isset($_REQUEST['data'])) {
            $post = $_REQUEST['data'];
            if (isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_taxable'])) {
                $tax = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_taxable']);
                if (!($tax == 'taxable' || $tax == 'none')) {
                    $this->that->add_error('Tax Status must be either Taxable or None');
                    return false;
                }
            }
            if (isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_realtime'])) {
                $realtime = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_realtime']);
                if (!($realtime == '1' || $realtime == '0')) {
                    $this->that->add_error("Get Prices Realtime value must be true or false.");
                    return false;
                }
                if (!isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_realtimefee']) || empty($post['woocommerce_kronosexpress_shipping_' . $this->id . '_realtimefee'])) {
                    $post['woocommerce_kronosexpress_shipping_' . $this->id . '_realtimefee'] = '0';
                }
                $realtimefee = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_realtimefee']);
                if (!(is_double($realtimefee) || is_numeric($realtimefee))) {
                    $this->that->add_error('Handling Fees is not valid.');
                    return false;
                }
            } else if (isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_cartpricerange'])) {
                $cartrange = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_cartpricerange']);
                if (!($cartrange == '1' || $cartrange == '0')) {
                    $this->that->add_error("Price based on cart amount value must be true or false.");
                    return false;
                } else {
                    if (isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_cartpricerange_data']) && isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_cartpricerange_data'][0])) {
                        if ($post['woocommerce_kronosexpress_shipping_' . $this->id . '_cartpricerange_data'][0] == '[]') {
                            $this->that->add_error("Price range cannot be empty and shipping fee will not work on checkout.");
                            return false;
                        }
                    }
                    else{
                        $this->that->add_error("Price range cannot be empty and shipping fee will not work on checkout.");
                        return false;
                    }
                }
            } else {
                if (!isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_price']) || empty($post['woocommerce_kronosexpress_shipping_' . $this->id . '_price'])) {
                    $this->that->add_error('Flat rate cost is required.');
                    return false;
                }
            }
            $price = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_price']);
            $weight = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_weightmax']);

            if (!(is_double($price) || is_numeric($price))) {
                $this->that->add_error('Flat rate cost is not valid.');
                return false;
            }
            if (!(is_double($weight) || is_numeric($weight))) {
                $this->that->add_error('Maximum weight is not valid.');
                return false;
            }
            if (isset($post['woocommerce_kronosexpress_shipping_' . $this->id . '_freeshipping'])) {
                $freeshipping = sanitize_text_field($post['woocommerce_kronosexpress_shipping_' . $this->id . '_freeshipping']);
                if (!empty($freeshipping)) {
                    if (!(is_double($freeshipping) || is_numeric($freeshipping))) {
                        $this->that->add_error('Free shipping value is not valid.');
                        return false;
                    }
                }
            }
            $this->that->add_error('Settings have been saved successfully.');
        } else {
        }
    }
}

class KronosExpressShippingAvailabilityAndCalculations
{
    public $id = '';
    public $that = '';
    public function __construct($shippingid, $shippingoption)
    {
        $this->id = $shippingid;
        $this->that = $shippingoption;
    }
    public function is_available($package)
    {

        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        $country = $package["destination"]["country"];
        if (strtoupper($country) != "CY" && strtoupper($country) != 'GR') {
            return false;
        }

        if (!class_exists('KronosExpressAPI')) {
            require dirname(__FILE__) . '/API/request.php';
        }
        $api = new KronosExpressAPI();
        $loc = $api->GetEshopLocation();
        if ($loc == 'CYPRUS' && strpos($this->id, 'economy')) {
            return false;
        }

        if ($plugin->enabled == 'no') {
            return false;
        }

        if ($this->that->weightmax == 0) {
            return true;
        } else if (!$this->that->weightmax) {
            return true;
        }
        $weight = 0;
        foreach ($package['contents'] as $item_id => $values) {
            $_product = $values['data'];
            $weightkg = $_product->get_weight();
            if ($weightkg == '' || $weightkg == null || $weightkg == '0') {
                $weightkg = '0.1';
            }
            $weight = $weight + $weightkg * $values['quantity'];
            if ($weight >= $this->that->weightmax) {
                return false;
            }
        }
        return true;
    }
    public function calculate_shipping($package)
    {

        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        if ($plugin->enabled == 'no') {
            return null;
        }
        if (isset($this->that->freeshipping) && !empty($this->that->freeshipping)) {
            $subtotal = $package['cart_subtotal'];
            if ($subtotal >= $this->that->freeshipping) {
                $this->that->add_rate(array(
                    'id' => $this->that->id,
                    'label' => $this->that->title . ': Free Shipping',
                    'cost' => '0',
                ));
                return;
            }
        }
        $cost = '';
        $weight = 0;
        $cartamount = '0';
        if (isset($package['cart_subtotal'])) {
            $cartamount = $package['cart_subtotal'];
        }

        foreach ($package['contents'] as $item_id => $values) {

            $_product = $values['data'];
            $weightkg = $_product->get_weight();
            if ($weightkg == '' || $weightkg == null || $weightkg == '0') {
                $weightkg = '0.1';
            }
            $weight = $weight + $weightkg * $values['quantity'];
        }
        if (isset($this->that->realtime) && $this->that->realtime == 'yes') {
            $fee = $this->that->realtimefee;
            if (!class_exists('KronosExpressAPI')) {
                require dirname(__FILE__) . '/API/request.php';
            }
            $api = new KronosExpressAPI();
            $country = $package["destination"]["country"];
            $country = strtoupper($country);
            if ($country == "CY") {
                $country = "CYPRUS";
            } else if ($country == "GR") {
                $country = "GREECE";
            }
            if (isset($_POST['payment_method']) && sanitize_text_field($_POST['payment_method']) == 'cod') {
                $cost = $api->GetPrice(strtoupper($this->id), $weight, '1', $country);
            } else {
                $cost = $api->GetPrice(strtoupper($this->id), $weight, '0', $country);
            }
            if (empty($cost)) {
                return null;
            }
            $cost = $cost + $fee;
        } else if (isset($this->that->cartpricerange) && $this->that->cartpricerange == 'yes' && $cartamount != '0') {
            
            if (isset($this->that->cartpricerange_data) && isset($this->that->cartpricerange_data[0]) && $this->that->cartpricerange_data[0] != '[]') {
                $data = json_decode($this->that->cartpricerange_data[0], true);
                foreach ($data as $d) {
                    if ($cartamount <= $d['from']) {
                        $cost = $d['fee'];
                        if ($cost == '0' || $cost == '0.00') {
                            $this->that->add_rate(array(
                                'id' => $this->that->id,
                                'label' => $this->that->title . ': Free Shipping',
                                'cost' => '0',
                            ));
                            return;
                        }
                        break;
                    }
                }
                if (empty($cost)) {
                    return null;
                }
                
            } else {
                return;
            }
        } else {
            $cost = $this->that->price;
        }

        $this->that->add_rate(array(
            'id' => $this->that->id,
            'label' => $this->that->title,
            'cost' => $cost,
        ));
    }
}
