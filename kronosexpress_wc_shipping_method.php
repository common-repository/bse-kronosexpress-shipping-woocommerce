<?php

class KRONOSEXPRESS_WC_SHIPPING_METHOD extends WC_Shipping_Method
{
    public function __construct()
    {
    }
    public function init_options()
    {
        $this->enabled = isset($this->instance_settings['enabled']) ? $this->instance_settings['enabled'] : 'yes';
        $this->weightmax = isset($this->instance_settings['weightmax']) ? $this->instance_settings['weightmax'] : '0';
        $this->price = isset($this->instance_settings['price']) ? $this->instance_settings['price'] : '0';
        $this->panel = KRONOSEXPRESS_SHIPPING_WOOCOMMERCE::$instance;
        if (!empty($this->panel)) {
            $this->weightmaxpublic = $this->panel->weightmax;
            $this->enabled = $this->panel->enabled;
        }
        $this->tax_status = isset($this->instance_settings['taxable']) && !empty($this->instance_settings['taxable']) ? $this->instance_settings['taxable'] : 'taxable';
        $this->realtime = isset($this->instance_settings['realtime']) && !empty($this->instance_settings['realtime']) ? $this->instance_settings['realtime'] : 'no';
        $this->realtimefee = isset($this->instance_settings['realtimefee']) && !empty($this->instance_settings['realtimefee']) ? $this->instance_settings['realtimefee'] : '0';
        $this->freeshipping = isset($this->instance_settings['freeshipping']) && !empty($this->instance_settings['freeshipping']) ? $this->instance_settings['freeshipping'] : '';
        $this->cartpricerange = isset($this->instance_settings['cartpricerange']) && !empty($this->instance_settings['cartpricerange']) ? 'yes' : 'no';
        $this->cartpricerange_data = isset($this->instance_settings['cartpricerange_data']) && !empty($this->instance_settings['cartpricerange_data']) ? $this->instance_settings['cartpricerange_data'] : '0';
        $title = isset($this->instance_settings['displaytitle']) && !empty($this->instance_settings['displaytitle']) ? $this->instance_settings['displaytitle'] : $this->title;

        if (is_plugin_active('polylang/polylang.php')) {
            icl_register_string('KronosExpress Plugin', 'Checkout Display Title - ' . $this->method_title, $this->method_title);
            $this->title = pll__($this->method_title);
        } else if (has_filter('wpml_translate_single_string')) {
            do_action('wpml_register_single_string', 'KronosExpress Plugin', 'Checkout Display Title - ' . $this->method_title, $this->method_title);
            $this->title = apply_filters('wpml_translate_single_string', $this->method_title, 'KronosExpress Plugin', 'Checkout Display Title - ' . $this->method_title);
        } else {
            $this->title = $title;
        }
    }
    public function admin_options()
    {
        parent::admin_options();
    }
    function init()
    {
        $this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
        $this->init_settings(); // This is part of the settings API. Loads settings you previously init.
        $this->init_instance_settings();
        add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }
    public function get_admin_options_html()
    {

        if ($this->instance_id) {
            $settings_html = $this->generate_settings_html($this->get_instance_form_fields(), false);
        } else {
            $settings_html = $this->generate_settings_html($this->get_form_fields(), false);
        }
        $str = '<style>
            p.description {
                margin-top: 0px !important;
            }
            .bse_kronosexpress_cartpricerange {
                width: 485px;
            }
            .bse_kronosexpress_cartpricerange > span
            {
                padding: 10px;
                width: 150px;
                display: inline-block;
                font-weight: bold;
                padding-bottom: 0px;
            }
            .bse_kronosexpress_cartpricerange > div > div > input {
                margin: 10px;
                margin-top: 5px;
                margin-bottom: 0px;
                width: 130px !important;
                min-width: 130px !important;
            }
        </style>';
        wp_enqueue_script('kronosexpress_cartpricerange_jquery', plugin_dir_url(__FILE__) . 'scripts/admin/jquery.mask.js', false, 1, true);
        $str .= "<script>
                jQuery('#woocommerce_{$this->id}_realtime').on('change',function()
                {
                    jQuery('#woocommerce_{$this->id}_cartpricerange').prop('checked','');
                    if ( jQuery('#woocommerce_{$this->id}_realtime').prop('checked') == true) {
                        jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeOut();
                        jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeIn();
                    }
                    else {
                        jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeIn();
                        jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeOut();

                    }
                });
                jQuery('#woocommerce_{$this->id}_cartpricerange').on('change',function() { 
                    jQuery('#woocommerce_{$this->id}_realtime').prop('checked','');
                    if (jQuery(this).prop('checked') == true) { 
                        jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeOut();
                        jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeOut();
                    }
                    else {
                        jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeIn();
                        jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeOut();
                    }
                });
                if (jQuery('#woocommerce_{$this->id}_realtime').prop('checked') == true) {
                    jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeOut();
                    jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeIn();
                    jQuery('#woocommerce_{$this->id}_cartpricerange').prop('checked','');
                }
                else if (jQuery('#woocommerce_{$this->id}_cartpricerange').prop('checked') == true) {
                    jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeOut();
                    jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeOut();
                    jQuery('#woocommerce_{$this->id}_realtime').prop('checked','');
                }    
                else {
                   jQuery('#woocommerce_{$this->id}_price').parent().parent().parent().fadeIn();
                   jQuery('#woocommerce_{$this->id}_realtimefee').parent().parent().parent().fadeOut();
                   jQuery('#woocommerce_{$this->id}_realtime').prop('checked','');
                   jQuery('#woocommerce_{$this->id}_cartpricerange').prop('checked','');
                }
                function addCartRange() {
                    jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=to]').each(function() { 
                        if (jQuery(this).data('type') == 'to') {
                            jQuery(this).prop('readonly',true);
                        }
                    });
                    jQuery('.bse_kronosexpress_cartpricerange_remove').each(function() {
                        jQuery(this).fadeOut();
                    });
                    var data = bse_kronosexpress_cartpricerange_data;
                    var lastitem = parseFloat(data[data.length-1].from).toFixed(2);
                    if (isNaN(lastitem)) {
                        lastitem = '0.00';
                    }
                    var html = '<div><input data-type=from type=text value=' + lastitem + ' readonly=readonly /> <input data-type=to onchange=changeCartRange(this) type=text value='+ (parseFloat(lastitem) + 10).toFixed(2) + ' /> <input data-type=fee type=text value=5.00 onchange=\"changeCartRangeFee(this)\" /> <span class=\"dashicons dashicons-remove bse_kronosexpress_cartpricerange_remove\" style=\"vertical-align:middle;color:red;\" onclick=\"removeCartRange(this)\"></span></div>';
                    jQuery('.bse_kronosexpress_cartpricerange_items').append(html);
                    jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=to]').each(function() { 
                        if (jQuery(this).data('type') == 'to') {
                            jQuery(this).mask('0000.00', {reverse: true});
                        }
                    });
                    jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=fee]').each(function() { 
                        if (jQuery(this).data('type') == 'fee') {
                            jQuery(this).mask('0000.00', {reverse: true});
                        }
                    });
                    var d = {
                        'from' : (parseFloat(lastitem) + 10).toFixed(2),
                        'fee' : '5.00'
                    };
                    bse_kronosexpress_cartpricerange_data.push(d);
                    jQuery('#woocommerce_{$this->id}_cartpricerange_data').val(JSON.stringify(bse_kronosexpress_cartpricerange_data));
                }
                function changeCartRange(that) {
                    var data = bse_kronosexpress_cartpricerange_data;
                    var newvalue = parseFloat(jQuery(that).val()).toFixed(2);
                    var previous = bse_kronosexpress_cartpricerange_data[data.length-1];
                    var d = {
                        'from' : newvalue,
                        'fee' : previous.fee
                    };
                    if (bse_kronosexpress_cartpricerange_data.length > 1) {
                        var previous_item = bse_kronosexpress_cartpricerange_data[data.length-2];
                        if (parseFloat(previous_item.from) >= parseFloat(jQuery(that).val())) {
                            alert('The To value must be higher than the previous range entered.');
                            jQuery(that).val((parseFloat(previous_item.from) + 10).toFixed(2));
                            return;
                        }
                    }
                    bse_kronosexpress_cartpricerange_data[data.length-1] = d;
                    jQuery('#woocommerce_{$this->id}_cartpricerange_data').val(JSON.stringify(bse_kronosexpress_cartpricerange_data));
                }
                function changeCartRangeFee(that) {
                    var data = bse_kronosexpress_cartpricerange_data;
                    var newvalue = parseFloat(jQuery(that).val()).toFixed(2);
                    var oldfrom = jQuery(that).parent().children('input[data-type=to]').val();
                    var d = {
                        'from' : oldfrom,
                        'fee' : newvalue
                    };
                    for (var i=0; bse_kronosexpress_cartpricerange_data.length;i++) {
                        if (bse_kronosexpress_cartpricerange_data[i].from == oldfrom) {
                            bse_kronosexpress_cartpricerange_data[i].fee = newvalue;
                            break;   
                        }
                    }
                    jQuery('#woocommerce_{$this->id}_cartpricerange_data').val(JSON.stringify(bse_kronosexpress_cartpricerange_data));
                }
                function removeCartRange(that) {
                    jQuery(that).parent().remove();
                    bse_kronosexpress_cartpricerange_data.pop();
                    jQuery('#woocommerce_{$this->id}_cartpricerange_data').val(JSON.stringify(bse_kronosexpress_cartpricerange_data));
                    var itemscnt = jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=to]').length;
                    var currentcnt = 1;
                    jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=to]').each(function() { 
                        if (jQuery(this).data('type') == 'to') {
                            if (itemscnt == currentcnt) {
                                jQuery(this).prop('readonly',false);
                                jQuery(this).parent().children('.bse_kronosexpress_cartpricerange_remove').fadeIn();
                            }
                            currentcnt++;
                        }
                    });
                    jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=to]').each(function() { 
                        if (jQuery(this).data('type') == 'to') {
                            jQuery(this).mask('0000.00', {reverse: true});
                        }
                    });
                    jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=fee]').each(function() { 
                        if (jQuery(this).data('type') == 'fee') {
                            jQuery(this).mask('0000.00', {reverse: true});
                        }
                    });
                }
                jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=to]').each(function() { 
                    if (jQuery(this).data('type') == 'to') {
                        jQuery(this).mask('0000.00', {reverse: true});
                    }
                });
                jQuery('.bse_kronosexpress_cartpricerange_items').find('input[data-type=fee]').each(function() { 
                    if (jQuery(this).data('type') == 'fee') {
                        jQuery(this).mask('0000.00', {reverse: true});
                    }
                });
        </script>";
        $str .= '<table class="form-table">' . $settings_html . '</table>';
        return $str;
    }

    public function generate_pricerange_html($key, $data)
    {
        $field_key = $this->get_field_key($key);
        $defaults  = array(
            'title'             => '',
            'label'             => '',
            'disabled'          => false,
            'class'             => '',
            'css'               => '',
            'type'              => 'text',
            'desc_tip'          => false,
            'description'       => '',
            'custom_attributes' => array(),
        );

        $data = wp_parse_args($data, $defaults);

        if (!$data['label']) {
            $data['label'] = $data['title'];
        }
        ob_start();
        $bse_kronosexpress_cartpricerange = $this->get_option($key . '_data');
        $array_key = esc_attr($field_key) . '_data[]';
        $array_key_id = esc_attr($field_key) . '_data';
        if (empty($bse_kronosexpress_cartpricerange[0]) || $bse_kronosexpress_cartpricerange[0] == '[]') {
            $bse_kronosexpress_cartpricerange = array(json_encode(array(
                array(
                    'from' => '10.00',
                    'fee' => '5.00'
                ),
                array(
                    'from' => '20.00',
                    'fee' => '8.00'
                )
            )));
        }


?>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="<?php echo esc_attr($field_key); ?>"><?php echo wp_kses_post($data['title']); ?> <?php echo $this->get_tooltip_html($data); // WPCS: XSS ok. 
                                                                                                                ?></label>
            </th>
            <td class="forminp">
                <fieldset>
                    <legend class="screen-reader-text"><span><?php echo wp_kses_post($data['title']); ?></span></legend>
                    <label for="<?php echo esc_attr($field_key); ?>">
                        <input <?php disabled($data['disabled'], true); ?> class="<?php echo esc_attr($data['class']); ?>" type="checkbox" name="<?php echo esc_attr($field_key); ?>" id="<?php echo esc_attr($field_key); ?>" style="<?php echo esc_attr($data['css']); ?>" value="1" <?php checked($this->get_option($key), '1'); ?> <?php echo $this->get_custom_attribute_html($data); // WPCS: XSS ok. 
                                                                                                                                                                                                                                                                                                                                        ?> />
                        <?php echo wp_kses_post($data['label']); ?></label><br />
                    <?php echo $this->get_description_html($data); // WPCS: XSS ok. 
                    ?>
                </fieldset>
                <div class="bse_kronosexpress_cartpricerange">
                    <label style="color:red;display: block;padding: 10px;font-style: italic;">If the actual cart amount is higher than your maximum 'Cart Amount To' value, the shipping method will not be shown on the checkout page.</label>
                    
                    <span>Cart Amount From</span>
                    <span>Cart Amount To</span>
                    <span>Shipping Fee</span>
                    <div class="bse_kronosexpress_cartpricerange_items">
                        <?php $lastvalue = ''; ?>
                        <?php $bse_kronosexpress_cartpricerange = json_decode($bse_kronosexpress_cartpricerange[0], true); ?>
                        <?php for ($i = 0; $i <= count($bse_kronosexpress_cartpricerange) - 1; $i++) : ?>
                            <div>
                                <?php $item = $bse_kronosexpress_cartpricerange[$i]; ?>
                                <?php if (empty($lastvalue)) : ?>
                                    <input data-type="from" type="text" value="0.00" readonly="readonly" />
                                <?php else : ?>
                                    <input data-type="from" type="text" value="<?php echo $lastvalue['from']; ?>" readonly="readonly" />
                                <?php endif; ?>

                                <?php if ($i != count($bse_kronosexpress_cartpricerange) - 1) : ?>
                                    <input data-type="to" type="text" value="<?php echo $item['from']; ?>" onchange="changeCartRange(this)" readonly="readonly" />
                                <?php else : ?>
                                    <input data-type="to" type="text" value="<?php echo $item['from']; ?>" onchange="changeCartRange(this)" />
                                <?php endif; ?>
                                <input data-type="fee" type="text" value="<?php echo $item['fee']; ?>" onchange="changeCartRangeFee(this)" />
                                <?php if ($i == count($bse_kronosexpress_cartpricerange) - 1) : ?>
                                    <span class="dashicons dashicons-remove bse_kronosexpress_cartpricerange_remove" style="vertical-align:middle;color:red;" onclick="removeCartRange(this)"></span>
                                <?php else : ?>
                                    <span class="dashicons dashicons-remove bse_kronosexpress_cartpricerange_remove" style="vertical-align:middle;color:red;display:none" onclick="removeCartRange(this)"></span>
                                <?php endif; ?>
                            </div>
                            <?php $lastvalue = $bse_kronosexpress_cartpricerange[$i]; ?>
                        <?php endfor; ?>
                    </div>
                    <span class="dashicons dashicons-plus-alt" style="margin:0 auto; display:block;color:green;font-size:20px;cursor:pointer;width:100%" onclick="addCartRange()"></span>
                    <label style="color:red;display: block;padding: 10px;font-style: italic;">You can set the Shipping Fee to 0 if you wish to offer free shipping.</label>
                </div>
                <input type="hidden" name="<?php echo $array_key; ?>" value=<?php echo json_encode($bse_kronosexpress_cartpricerange); ?> id="<?php echo $array_key_id; ?>" value=<?php echo json_encode($bse_kronosexpress_cartpricerange); ?> />
                <script>
                    var bse_kronosexpress_cartpricerange_data = <?php echo json_encode($bse_kronosexpress_cartpricerange); ?>
                </script>

            </td>
        </tr>
<?php

        return ob_get_clean();
    }
    function process_admin_options()
    {
        if (!class_exists('KronosExpressShippingOptionsFields')) {
            require dirname(__FILE__) . '/shipping_options_fields.php';
        }
        $options = new KronosExpressShippingOptionsFields(strtolower($this->code), $this);
        if (!empty($options->validate_options())) {
            return false;
        }
        parent::process_admin_options();
    }
    function init_form_fields()
    {
        if (!class_exists('KronosExpressShippingOptionsFields')) {
            require dirname(__FILE__) . '/shipping_options_fields.php';
        }
        $options = new KronosExpressShippingOptionsFields(strtolower($this->code), $this);
        $this->instance_form_fields = $options->get_options();
    }

    public function is_available($package)
    {
        if (!class_exists('KronosExpressShippingAvailabilityAndCalculations')) {
            require dirname(__FILE__) . '/shipping_options_fields.php';
        }
        $options = new KronosExpressShippingAvailabilityAndCalculations(strtolower($this->code), $this);
        return $options->is_available($package);
    }
    public function calculate_shipping($package = array())
    {
        if (!class_exists('KronosExpressShippingAvailabilityAndCalculations')) {
            require dirname(__FILE__) . '/shipping_options_fields.php';
        }
        $options = new KronosExpressShippingAvailabilityAndCalculations(strtolower($this->code), $this);
        $options->calculate_shipping($package);
    }
}
