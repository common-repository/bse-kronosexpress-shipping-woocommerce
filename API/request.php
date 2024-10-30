<?php
if (!defined('WPINC')) {
    die;
}

if (!defined('ABSPATH')) {
    exit;
}

class KronosExpressAPI
{
    private $hostnew = "https://bsekronosexpresspluginapi.trafficmanager.net/";
    private $host = 'https://services.kronosexpress.com/EshopWS.asmx';
    private $username = '';
    private $password = '';
    private $uniquekey = '';
    private $issandbox = false;
    private $env = 'LIVE';
    public function __construct()
    {
        kronosexpress_initialize();
        $plugin = new KRONOSEXPRESS_SHIPPING_WOOCOMMERCE();
        $this->username = $plugin->apiusername;
        $this->password = $this->generateDigest($plugin->apipassword);
        $this->uniquekey = $plugin->apiuniquekey;

        if (isset($plugin->enabledsandbox) && $plugin->enabledsandbox == 'yes') {
            $this->issandbox = true;
            $this->env = 'DEV';
        }
    }

    public function GetEshopLocation()
    {
        $ln = $this->HttpPostv2('Account/GetEshopLocation', $this->username, $this->password, null, $this->env, $this->generateDigest($this->username . $this->password . $this->env . $this->uniquekey));
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            return $ln;
        } else {
            return '';
        }
    }

    public function GetPrice($service, $weight, $cod, $receivercountry)
    {
        if ($cod == '1') {
            $cod = true;
        } else {
            $cod = false;
        }
        $weight = (double) number_format($weight, 2, '.', '');
        $ln = $this->HttpPostv2('Prices/GetRealTimePrices',
            $this->username,
            $this->password,
            array(
                'service' => $service,
                'weight' => $weight,
                'COD' => $cod,
                'receivercountry' => $receivercountry,
            ),
            $this->env,
            $this->generateDigest
            (
                $this->username .
                $this->password .
                $this->env .
                $service .
                $weight .
                strtolower(var_export($cod, true)) .
                $receivercountry .
                $this->uniquekey
            )
        );
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                return $ln;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function CreateSandboxAccount($email, $firstname, $surname)
    {
        $username = 'kronosexpress_plugin_wordpress';
        $password = '02138471837493824789132';
        $uniquekey = 'dafhaukfdjhadfkjadsfadfnajk';
        if (function_exists('determine_locale')) {
            $locale = determine_locale();
        } else {
            $locale = get_locale();
        }
        if (strlen($locale) > 2) {
            $locale = substr($locale, 0, 2);
        }
        $ln = $this->HttpPostv2('Account/CreateSandbox', $username, $this->generateDigest($password), array('email' => $email, 'firstname' => $firstname, 'surname' => $surname, 'lang' => $locale), $this->env, $this->generateDigest($username . $this->generateDigest($password) . $this->env . $email . $firstname . $surname . $locale . $uniquekey));
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                return (object) array(
                    'Status' => $ln,
                );
            } else {
                return (object) array(
                    'Status' => 'Request failed. Please try again later.',
                );
            }
        } else {
            return (object) array(
                'Status' => 'ok',
            );
        }
    }

    public function CheckCredentials($username, $password, $uniquekey, $dev)
    {
        if ($dev == true) {
            $this->env = 'DEV';
        }
        $ln = $this->HttpPostv2('Users/CheckCredentials', $username, $this->generateDigest($password), null, $this->env, $this->generateDigest($username . $this->generateDigest($password) . $this->env . $uniquekey));
        if ($ln == 'true') {
            return (object) array(
                'Status' => '1',
            );
        } else {
            return (object) array(
                'Status' => '0',
            );
        }
    }

    public function CreateQuotation($name, $company, $tel, $email, $qty, $comments)
    {
        $username = 'kronosexpress_plugin_wordpress';
        $password = '02138471837493824789132';
        $uniquekey = 'dafhaukfdjhadfkjadsfadfnajk';
        if (function_exists('determine_locale')) {
            $locale = determine_locale();
        } else {
            $locale = get_locale();
        }
        if (strlen($locale) > 2) {
            $locale = substr($locale, 0, 2);
        }
        $gr2cy = false;
        $cy2gr = false;
        $cy2cy = true;
        $gr2gr = false;
        $international = false;
        $ln = $this->HttpPostv2(
            'Account/CreateQuotation',
            $username,
            $this->generateDigest($password),
            array(
                'name' => $name,
                'company' => $company,
                'tel' => $tel,
                'email' => $email,
                'gr2cy' => $gr2cy,
                'cy2gr' => $cy2gr,
                'cy2cy' => $cy2cy,
                'gr2gr' => $gr2gr,
                'international' => $international,
                'quantity' => $qty,
                'comments' => $comments,
                'lang' => $locale,
            ),
            $this->env,
            $this->generateDigest(
                $username .
                $this->generateDigest($password) .
                $this->env .
                $name .
                $company .
                $tel .
                $email .
                strtolower(var_export($gr2cy, true)) .
                strtolower(var_export($cy2gr, true)) .
                strtolower(var_export($cy2cy, true)) .
                strtolower(var_export($gr2gr, true)) .
                strtolower(var_export($international, true)) .
                $qty .
                $comments .
                $locale .
                $uniquekey
            )
        );
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                return (object) array(
                    'Status' => $ln,
                );
            } else {
                return (object) array(
                    'Status' => 'error',
                );
            }
        } else {
            return (object) array(
                'Status' => 'Success',
            );
        }
    }

    public function GetURLPrintLabel($awbs)
    {

        $baseurl = $this->hostnew . 'Labels/GetPrintLabels?';
        $env = 'LIVE';
        if ($this->issandbox == true) {
            $env = 'DEV';
        }
        $baseurl .= "username=" . $this->username;
        $baseurl .= '&password=' . $this->password;
        $baseurl .= '&awbs_csv=' . $awbs;
        $baseurl .= '&environment=' . $env;
        $baseurl .= '&hash=' . $this->generateDigest($awbs . $this->uniquekey);
        $baseurl .= '&secondaryhash=' . $this->generateDigest($this->username . $this->password . $env . $awbs . $this->uniquekey);
        return $baseurl;
    }
    public function TrackAndTrace($awb)
    {
        if (function_exists('determine_locale')) {
            $locale = determine_locale();
        } else {
            $locale = get_locale();
        }
        if (strlen($locale) > 2) {
            $locale = substr($locale, 0, 2);
        }
        $ln = $this->HttpPostv2('Track/TrackAndTrace', $this->username, $this->password, array('awb' => $awb, 'langcode' => $locale), $this->env, $this->generateDigest($this->username . $this->password . $this->env . $awb . $locale . $this->uniquekey));
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                $events = [];
                foreach ($ln as $ev) {
                    $events[] = array(
                        'DATE' => (string) $ev['date'],
                        'SETTLEMENTID' => (string) $ev['settlementID'],
                        'STATUS' => (string) $ev['status'],
                    );
                }
                return $events;
            } else {
                return [];
            }
        } else {
            return [];
        }

    }

    public function CancelLabel($awb)
    {
        $reason = 'delete from plugin on ' . get_site_url();
        $ln = $this->HttpPostv2('Labels/CancelAWB', $this->username, $this->password, array('awb' => $awb, 'reason' => $reason), $this->env, $this->generateDigest($this->username . $this->password . $this->env . $awb . $reason . $this->uniquekey));
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                return (object) array(
                    'AWB' => $ln['item1'],
                    'Status' => $ln['item2'],
                );
            } else {
                return (object) array(
                    'AWB' => '',
                    'Status' => 'error',
                );
            }
        } else {
            return (object) array(
                'AWB' => '',
                'Status' => 'error',
            );
        }

    }

    public function GetWarehouses()
    {
        if (function_exists('determine_locale')) {
            $locale = determine_locale();
        } else {
            $locale = get_locale();
        }
        if (strlen($locale) > 2) {
            $locale = substr($locale, 0, 2);
        }
        $ln = $this->HttpPostv2('Locations/GetWarehouses',
            $this->username,
            $this->password,
            array('langcode' => $locale),
            $this->env,
            $this->generateDigest(
                $this->username .
                $this->password .
                $this->env .
                $locale .
                $this->uniquekey)
        );
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                $locations = [];
                try {
                    foreach ($ln as $wh) {
                        $locations[] = array(
                            'CODE' => $wh['item1'],
                            'NAME' => $wh['item2'],
                            'POSTCODE' => $wh['item3'],
                        );
                    }
                    $locations = apply_filters('translate_warehouses_kronosexpress', $locations);
                } catch (Exception $e) {
                    return $locations;
                }
                return $locations;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    public function Sanitize($input)
    {
        $input = str_replace('\r', '', $input);
        $input = str_replace('\n', '', $input);
        $input = str_replace('\t', '', $input);
        $input = str_replace('-', ' ', $input);
        $input = str_replace('-', ' ', $input);
        $input = str_replace('(', ' ', $input);
        $input = str_replace(')', ' ', $input);
        $input = str_replace('<', ' ', $input);
        $input = str_replace('>', ' ', $input);
        $input = str_replace('&', ' ', $input);
        $input = str_replace('%', ' ', $input);
        $input = str_replace('"', ' ', $input);
        $input = str_replace("'", ' ', $input);
        $input = str_replace("+", ' ', $input);
        $input = str_replace(".", ' ', $input);
        $input = str_replace(",", ' ', $input);
        $input = str_replace("-", ' ', $input);
        $input = str_replace(">", ' ', $input);
        return $input;
    }
    public function Announce($code, $fname, $sname, $address, $postcode, $city, $phone, $comments, $weight, $email, $station, $cod = 0, $homedelivery = false, $ar = 0, $type = '002')
    {
        $code = $this->Sanitize($code);
        $fname = $this->Sanitize($fname);
        $sname = $this->Sanitize($sname);
        $address = $this->Sanitize($address);
        $post = $this->Sanitize($postcode);
        $city = $this->Sanitize($city);
        $phone = $this->Sanitize($phone);
        $comments = $this->Sanitize($comments);
        $services = [];
        $servhash = '';
        if ($cod != 0) {
            $services[] = ['code' => '003', 'details' => (string) $cod];
            $servhash .= '003' . (string) $cod;
        }
        if ($homedelivery == true) {
            $services[] = ['code' => '090', 'details' => ''];
            $servhash .= '090' . '';
        } else {
            $services[] = ['code' => '091', 'details' => ''];
            $servhash .= '091' . '';
        }
        if ($ar === 1) {
            $services[] = ['code' => '004', 'details' => ''];
            $servhash .= '004' . '';
        }
        $ln = $this->HttpPostv2('Labels/AnnounceAWB',
            $this->username,
            $this->password,
            array(
                'recipientcode' => $code,
                'recipientname' => $fname,
                'recipientsurname' => $sname,
                'recipientaddress' => $address,
                'recipientpostcode' => $post,
                'recipientcity' => $city,
                'recipientphone' => $phone,
                'comments' => $comments,
                'warehousecode' => $station,
                'weight' => (string) $weight,
                'parceltype' => $type,
                'recipientemail' => $email,
                'services' => $services,
            ),
            $this->env,
            $this->generateDigest
            (
                $this->username . $this->password . $this->env .
                $code . $fname . $sname . $address . $post . $city . $phone . $comments . $station . $weight . $type . $email . $servhash .
                $this->uniquekey
            )
        );
        if (!empty($ln)) {
            $ln = json_decode($ln, true);
            if (!isset($ln['status'])) {
                return (object) array(
                    'AWB' => $ln['item1'],
                    'Status' => $ln['item2'],
                );
            } else {
                return (object) array(
                    'AWB' => '',
                    'Status' => 'error',
                );
            }
        } else {
            return (object) array(
                'AWB' => '',
                'Status' => 'error',
            );
        }
    }

    public function HttpPost($xml)
    {
        $host = $this->host;
        if ($this->issandbox == true) {
            $host = 'http://courier.kronosexpress.com/EshopWS.asmx';
        }
        $url = $host;
        $post_data = array($xml);
        $stream_options = array(
            'http' => array(
                'method' => 'POST',
                'protocol_version' => 1.1,
                'header' => array(
                    'Content-type: text/xml; charset=utf-8',
                    'Content-Length: ' . strlen($xml),
                    'Expect: 100-continue',
                    'Connection: close',
                    'SOAP:Action',
                ),
                'content' => $xml,
            ),
        );
        $context = stream_context_create($stream_options);
        try {
            $response = file_get_contents($url, null, $context);
            return $response;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function HttpPostv2($url1, $username, $password, $data, $env, $hash)
    {
        $host = $this->hostnew;
        $url = $host . $url1;
        if ($this->issandbox == true) {
            $env = 'DEV';
        }
        if ($data == null) {
            $data = array('' => '');
        }
        if (!function_exists("curl_version")) {
            $stream_options = array(
                'http' => array(
                    'method' => 'POST',
                    'protocol_version' => 1.1,
                    'header' => array(
                        'Content-Type: application/json',
                        'Connection: close',
                        'Accept: application/json',
                        'Username: ' . $username,
                        'Password: ' . $password,
                        'Hash: ' . $hash,
                        'Environment: ' . $env,
                    ),
                    'content' => json_encode($data),
                    'ignore_errors' => true,
                ),
            );
            $context = stream_context_create($stream_options);
            try {
                $response = file_get_contents($url, null, $context);
                return $response;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $headers = array(
                "Content-type: application/json",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "Content-length: " . strlen(json_encode($data)),
                'Username: ' . $username,
                'Password: ' . $password,
                'Hash: ' . $hash,
                'Environment: ' . $env,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            try {
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }
            catch (Exception $e) {
                echo $e->getMessage();
                curl_close($ch);
            }
        }
    }

    public function generateDigest($value)
    {
        $hash = hash('sha256', mb_convert_encoding($value, 'UTF-16LE'), true);
        return $this->hexToStr($hash);
    }
    public function hexToStr($string)
    {
        //return bin2hex($string);
        $hex = "";
        for ($i = 0; $i < strlen($string); $i++) {
            if (ord($string[$i]) < 16) {
                $hex .= "0";
            }

            $hex .= dechex(ord($string[$i]));
        }
        return ($hex);
    }
}
