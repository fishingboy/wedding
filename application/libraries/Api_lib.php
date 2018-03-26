<?php

use \Firebase\JWT\JWT;
Use Curl\Curl;

/**
 * API 相關函式
 * @package Libraries
 */
class Api_lib
{
    /**
     * CI 實體
     * @var object
     */
    private $CI;

    /**
     * JSON 資料
     * @var array
     */
    private $json_data = null;

    /**
     * API 輸出的格式
     *
     *     json        : json 格式 <br>
     *     json_pretty : 可閱讀的 json 格式 <br>
     *     return      : 直接回傳不輸出畫面 <br>
     *     print_r     : php print_r 格式 <br>
     *     var_dump    : php var_dump 格式 <br>
     *
     * @var string
     */
    private $format = 'json';

    /**
     * JSONP 的 callback 名稱
     * @var string
     */
    private $callback = 'zuvio_callback';

    /**
     * Debug 模式
     * @var boolean
     */
    private $debug = false;

    private $jwt_key = '94crazyloveqqzuvio55667788QqQqQqQq';

    /**
     * 是否是 Restful API
     * @var boolean
     */
    private $is_restful;

    /**
     * 呼叫完 API 後的 http status code
     * @var integer
     */
    private $http_status_code;

    /**
     * 取得呼叫 API 的 response_body (json 或 xml)
     * @var string
     */
    private $response_body;

    /**
     * CURL 錯誤
     * @var string
     */
    private $curl_error;

    /**
     * 建構子
     */
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->format = $this->CI->input->get_post('_format');
        $this->callback = $this->CI->input->get_post('callback');
        $this->debug = $this->CI->input->get_post('_debug');
	$this->CI->load->library("Status_error_code");
        // 判斷是不是 restful api
        $is_restful = false;
        $this->is_restful = (get_parent_class($this->CI) == 'REST_Controller');
    }

    /**
     * API 結果輸出
     * @param  array  $data       要輸出的資料
     * @param  array  $data_type  強制的型態轉換
     * @return array              處理完的資料
     */
    public function output($data, $data_types = [])
    {
        // 資料
        if (is_array($data)) {
            $ret = $data;
        } else {
            $ret['msg'] = 'OK';
        }

        // 狀態判斷
        $status = ($data) ? true : false;
        $ret = array_merge(['status' => $status], $ret);

        // 資料
        if (gettype($data) == 'string') {
            $ret['msg'] = $data;
        } else {
            $ret['msg'] = 'OK';
        }

        // 形態轉換 (暫時只支援第一層的轉換)
        if (count($data_types)) {
            $this->convertVarType($ret, $data_types);
        }

        // 輸出格式
        $this->outputFormat($ret);
        exit;
    }

    /**
     * 輸出錯誤訊息
     * @param  string  $msg         錯誤訊息
     * @param  integer $http_code   http code
     * @return void
     */
    public function outputError($msg, $http_code = 0)
    {
        $code = null;
        if (is_array($msg)) {
            $code = $msg['code'];
            $msg  = $msg['msg'];
        }

        // restful api 回應
        if ($this->is_restful) {
            $code = $code ? $code : 400;
            $this->CI->response($this->CI->status_error_code->getErrorMsg($code, $msg), $code);
        }

        $data = [
            'status' => false,
            'msg'    => ($msg) ? $msg : "no message!"
        ];

        // 把錯誤訊息全部倒出來
        if ($this->debug) {
            $data['real_errors'] = ErrorStack::getAll();
        }

        // 錯誤代碼
        if ($code) {
            $data['code'] = $code;
        }

        // todo : 已加上客制的 header，之後可以把 error msg 建好替換掉下面的 Not Found
        if ($http_code) {
            header("HTTP/1.1 {$http_code} Not Found");
        }

        // 記錄 log
        // $this->logError($msg);

        // 輸出錯誤
        $this->outputFormat($data);
        exit;
    }

    /**
     * 寫入 log
     * @param  string $msg 錯誤訊息
     */
    private function logError($msg)
    {
        // API 網址
        $api_url = $this->CI->uri->uri_string;

        // 輸入參數
        $input = json_encode($this->getAllData());

        // 錯誤訊息
        $error_stack = json_encode(ErrorStack::getAll());

        // 送參數方式: JSON / POST
        $method = $this->isJsonType() ? 'JSON' : 'POST';

        // 組合 log 訊息
        $log_msgs[] = "[API_LIB] - [$api_url]";
        $log_msgs[] = "outputError : {$msg}";
        $log_msgs[] = "input : {$input}";
        $log_msgs[] = "method : {$method}";
        $log_msgs[] = "ErrorStack : {$error_stack}";
        $log_msg = implode(' - ', $log_msgs);

        // 寫入 log
        log_message('error', $log_msg);
    }

    /**
     * 依格式輸出
     * @param  array $ret           資料
     * @return void
     */
    private function outputFormat($ret)
    {
        // 輸出格式
        switch ($this->format) {
            // json 格式
            default:
            case 'json':
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($ret);
                break;

            // 輸出可閱讀的 json 格式
            case 'json_pretty':
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($ret, JSON_PRETTY_PRINT);
                break;

            case 'jsonp':
                header("Content-Type:text/html; charset=utf-8");
                $json = json_encode($ret);
                echo "{$this->callback}({$json});";
                break;

            // php 的 print_r
            case 'print_r':
                header("Content-Type:text/html; charset=utf-8");
                echo "<pre>" . print_r($ret, TRUE). "</pre>";
                break;

            // php 的 var_dump
            case 'var_dump':
                header("Content-Type:text/html; charset=utf-8");
                var_dump($ret);
                break;
        }
    }

    /**
     * 取得 POST 參數
     *
     * 驗證失敗直接輸出錯誤
     *
     * @param  string   $key           允許的參數
     * @param  string   $rules_string  驗證規則
     * @param  boolean  $xss_clean     是否做 xss 清除
     * @param  mixed    $default       預設值
     * @return mixed                   參數
     */
    public function getParam($key, $rules_string = "", $xss_clean = null, $default = null)
    {
        // 取得參數
        $value = $this->getData($key, $xss_clean);

        // 驗證參數
        if ($rules_string) {
            $status = $this->validationParam($key, $value, $rules_string);
            if (false === $status) {
                $this->outputError(ErrorStack::pop());
            }
        }

        // 預設值
        if ($value === null || $value === '') {
            $value = $default;
        }

        return $value;
    }

    /**
     * 取得 POST Array 參數
     *
     * 驗證失敗直接輸出錯誤
     *
     * @param  string   $key           參數名稱
     * @param  array    $rules         驗證規則
     * @example <code>
     *          $rules = [
     *              'type' => 'key_array',
     *              'array' => [
     *                   'id' => [
     *                       'rules'      => 'required|integer',
     *                       'xss_clean'  => true|false,
     *                       'default'    => {default_value}
     *                   ],
     *                   'name' => [
     *                       'rules'      => 'required|integer',
     *                       'xss_clean' => true|false,
     *                       'default'    => {default_value}
     *                   ],
     *                   'options' => [
     *                         'type' => 'normal_array',
     *                         'array' => [
     *                                'id' => [
     *                                      'rules'      => 'required|integer',
     *                                      'xss_clean' => true|false,
     *                                      'default'    => {default_value}
     *                                  ]
     *                         ]
     *                   ]
     *               ]
     *          ]
     *          </code>
     * @return mixed                   參數
     */
    public function getArrayParam($key, $rules = null)
    {
        // 取得參數
        $value = $this->getData($key, false);
        if ( ! $value && isset($rules['required']) && $rules['required']) {
            $this->outputError("陣列不存在 {$key} !");
        }

        // 驗證參數
        if ($value) {
            $status = $this->validationArrayParam($key, $value, $rules);
            if (false === $status) {
                $this->outputError(ErrorStack::pop());                
            }
        }

        // 預設值
        if ($value === null || $value === '') {
            $value = [];
        }

        return $value;
    }

    /**
     * 驗證參數
     * @param  string  $key           參數名稱
     * @param  mixed   $value         參數
     * @param  string  $rules_string  驗證規則
     * @return JSON
     */
    public function validationParam($key, $value, $rules_string = "")
    {
        // 借用 CI_Form_validation 的驗證機制
        static $validation;
        if ( ! $validation) {
            $this->CI->load->library('form_validation');
            $validation = new MY_Form_validation();
        }

        if ($rules_string == "") {
            return true;
        }

        // 陣列處理
        if (is_array($value)) {
            $rules_string = str_replace("required|", '', $rules_string);
            $rules_string = str_replace("required", '', $rules_string);

            foreach ($value as $k => $v) {
                // 無法判斷 key value 陣列
                if (is_string($k)) {
                    return true;
                }

                // 拆成個別驗證
                $status = $this->validationParam($key, $v, $rules_string);
                if (false === $status) {
                    return false;
                }
            }
            return true;
        }

        // 驗證參數
        $rules = explode('|', $rules_string);

        // 必要參數
        if (in_array('required', $rules)) {
            $result = $validation->required($value);
            if ( ! $result) {
                ErrorStack::push("必要參數未傳：{$key}");
                return false;
            }
        }

        if ( ! $value) {
            return null;
        }

        foreach ($rules as $rule) {
            $param = false;
            if (preg_match("/(.*?)\[(.*)\]/", $rule, $match)) {
                $rule   = $match[1];
                $param  = $match[2];
            }

            if (method_exists($validation, $rule)) {
                $result = $validation->$rule($value, $param);
                if ( ! $result) {
                    $error_str = "參數驗證錯誤：{$key} => {$rule}";
                    $error_str .= ($param) ? ":{$param}" : "";
                    ErrorStack::push($error_str);
                    return false;
                }
            } elseif ($rule != "") {
                ErrorStack::push("驗證規則不存在：{$key} => {$rule}");
                return false;
            }
        }
        return true;
    }

    /**
     * 驗證參數
     * @param  string  $key           參數名稱
     * @param  mixed   $value         參數
     * @param  array   $rules         驗證規則
     * @return boolean
     */
    public function validationArrayParam($key, & $value, $rules)
    {
        $type = isset($rules['type']) ? $rules['type'] : 'value';
        switch ($type) {
            // 值
            case "value":
                // xss_clean
                if ( ! isset($rules['xss_clean']) || $rules['xss_clean']) {
                    $value = $this->CI->security->xss_clean($value);
                }

                // 格式驗證
                if (isset($rules['rules'])) {
                    $rules_string = $rules['rules'];
                    $status = $this->validationParam($key, $value, $rules_string);
                    if (false === $status) {
                        return false;
                    }
                }

                // 指定預設值
                if (isset($rules['default']) && ($value === null || $value == '')) {
                    $value = $rules['default'];
                }
                break;

            // 關聯式陣列
            case "key_array":
                $array = $rules['array'];
                foreach ($array as $sub_key => $sub_rules) {
                    if (isset($value[$sub_key])) {
                        $status = $this->validationArrayParam("{$key}[{$sub_key}]", $value[$sub_key], $sub_rules);
                        if (false === $status) {
                            return false;
                        }
                    } else {
                        // 陣列為必填
                        if (isset($sub_rules['type']) && isset($sub_rules['required']) && $sub_rules['required']) {
                            ErrorStack::push("陣列不存在 {$key}[{$sub_key}] !!");
                            return false;
                        } elseif (isset($sub_rules['rules']) && strpos($sub_rules['rules'], 'required') !== false) {
                            ErrorStack::push("必傳參數 {$key}[{$sub_key}] 未傳!!");
                            return false;
                        }

                        // 指定預設值
                        if (isset($sub_rules['default'])) {
                            $value[$sub_key] = $sub_rules['default'];
                        }
                    }
                }
                break;

            // 一般陣列
            case "normal_array":
                $sub_rules = $rules['array'];
                foreach ($value as $index => $sub_array) {
                    foreach ($sub_rules as $sub_key => $sub_rule) {
                        if (isset($sub_array[$sub_key])) {
                            $this->validationArrayParam("{$key}[{$index}][$sub_key]", $value[$index][$sub_key], $sub_rules[$sub_key]);
                        } else {
                            // 陣列為必填
                            if (isset($sub_rules['type'])) {
                                ErrorStack::push("陣列不存在 {$key}[{$sub_key}] !!");
                                return false;
                            } elseif (isset($sub_rules[$sub_key]['rules']) && strpos($sub_rules[$sub_key]['rules'], 'required') !== false) {
                                ErrorStack::push("必傳參數 {$key}[{$index}][{$sub_key}] 未傳!!");
                                return false;
                            }

                            // 指定預設值
                            if (isset($sub_rules[$sub_key]['default'])) {
                                $value[$index][$sub_key] = $sub_rules[$sub_key]['default'];
                            }
                        }
                    }
                }
                break;
        }
        return true;
    }

    /**
     * 取得 JSON 資料
     * @return array
     */
    public function getJsonData()
    {
        if ($this->json_data === null) {
            $json = file_get_contents("php://input",'r');
            $json_data = json_decode($json, true);
            if ( ! $json_data) {
                $this->outputError('JSON 資料未傳送！');
            }

            $this->json_data = $json_data;
        }
        return $this->json_data;
    }

    /**
     * 取得所有參數
     * @return array
     */
    public function getAllData()
    {
        if ($this->isJsonType()) {
            $_JSON = $this->getJsonData();
            return $_JSON;
        } else {
            return array_merge($_POST, $_GET);
        }
    }

    /**
     * 取得資料
     * @param  string   $key        參數名稱
     * @param  boolean  $xss_clean  是否需要 xss 過瀘
     * @return mixed
     */
    public function getData($key, $xss_clean = true)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($this->isJsonType()) {
            $_JSON = $this->getJsonData();
            if ( ! isset($_JSON[$key])) {
                return null;
            }

            return ($xss_clean) ? $this->CI->security->xss_clean($_JSON[$key]) : $_JSON[$key];
        } else {
            if ($method == 'GET' || $method == 'POST') {
                return $this->CI->input->get_post($key, $xss_clean);
            } else if ($this->is_restful) {
                switch ($method) {
                    case "GET":
                        return $this->CI->get($key);
                        break;

                    case "POST":
                        return $this->CI->post($key);
                        break;

                    case "PUT":
			return $this->CI->put($key);
                        break;

                    case "DELETE":
                        return $this->CI->delete($key);
                        break;

                    default:
                        return null;
                        break;
                }
            } else {
                return null;
            }
        }
    }

    /**
     * 判斷 Content-Type 是不是 JSON 格式
     * @return boolean
     */
    private function isJsonType()
    {
        static $status;

        if ($this->CI->input->is_cli_request()) {
            return false;
        }

        if ($status === null) {
            $headers = getallheaders();
            foreach ($headers as $key => $value) {
                if (strtolower($key) == "content-type") {
                    $value = strtolower($value);
                    if (false !== strpos($value, 'application/json')) {
                        $status = true;
                        return true;
                    }
                }
            }
            $status = false;
        }

        return $status;
    }

    /**
     * 轉換資料型態
     * @param  array  $ret         資料
     * @param  array  $data_types  欲轉換的形態
     */
    private function convertVarType(& $ret, $data_types)
    {
        foreach ($data_types as $key => $type) {
            if ( ! isset($ret[$key])) {
                continue;
            }

            switch ($type) {
                case "integer":
                    $ret[$key] = intval($ret[$key]);
                    break;

                case "float":
                    $ret[$key] = floatval($ret[$key]);
                    break;

                case "boolean":
                    $ret[$key] = boolval($ret[$key]);
                    break;

                case "string":
                    $ret[$key] = strval($ret[$key]);
                    break;
            }
        }
    }

    /**
     * 加上分頁參數
     * @param  array   $data      資料
     * @param  integer $page      頁數
     * @param  integer $page_size 分頁數
     * @param  integer $count     總數
     */
    public function appendPageAttrs(& $data, $page, $page_size, $count)
    {
        $data['count']      = $count;
        $data['page_size']  = $page_size;
        $data['curr_page']  = $page;
        $data['total_page'] = ceil($count / $page_size);
    }

    public function getJWT($data = [], $key = "", $expired_time = 172800)
    {
        // $expired_time = 172800;
        $token = [
            "iat" => time(),
            "exp" => time() + $expired_time,
        ];
        $token = array_merge($token, $data);
        $key = $key ? $key : $this->jwt_key;
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }

    public function validJWT($jwt = '', $key = "")
    {
        // 自動取得 REST_Controller 的 api_token
        if ( ! $jwt && get_parent_class($this->CI) == 'REST_Controller') {
            $jwt = $this->CI->get('api_token');
            if ( ! $jwt) {
                $method = $this->CI->get_method();
                if (method_exists($this->CI, $method)) {
                    $jwt = $this->CI->$method('api_token');
                }
            }
        }

        // $leeway in seconds
        $key = $key ? $key : $this->jwt_key;
        JWT::$leeway = 2;
        // decode
        try {
            $decoded = JWT::decode($jwt, $key, ['HS256']);
        } catch (Exception $e) {
            ErrorStack::push($e->getMessage());
            return false;
        }
        return $decoded;
    }

    /**
     * CURL 取得資料
     * @param  string $url 網址
     * @return string      回應內容
     */
    public function curlPost($url, $data = [], & $http_status_code = null, & $response_body = null, $timeout = 600)
    {
        $url = trim($url);
        $curl = curl_init($url);
        if (substr($url, 0, 5) == "https") {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
        }
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);

        // post 參數
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        // 執行 curl
        $data = curl_exec($curl);

        // 檢查是否有錯誤
        $this->curl_error = "";
        if (false === $data) {
            $this->curl_error = curl_error($curl);;
        }

        // 取得 response code
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->http_status_code = $http_status_code;

        // 取得 response body
        $response_body = file_get_contents("php://input",'r');
        $this->response_body = $response_body;

        // json decode
        if ($data) {
            $tmp = json_decode($data, true);
            if ($tmp) {
                $data = $tmp;
            }
        }

        return $data;
    }

    /**
     * CURL 取得資料(送 json DATA)
     * @param  string $url 網址
     * @return string      回應內容
     */
    public function curlJson($url, $data, & $http_status_code = null, & $response_body = null)
    {
        $url = trim($url);
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);

        $curl = curl_init($url);
        if (substr($url, 0, 5) == "https") {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        } else {
            curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
        }
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 600);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
        ]);

        // post 參數
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        // 執行 curl
        $data = curl_exec($curl);

        // 檢查是否有錯誤
        $this->curl_error = "";
        if (false === $data) {
            $this->curl_error = curl_error($curl);;
        }

        // 取得 response code
        $http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->http_status_code = $http_status_code;

        // 取得 response body
        $response_body = file_get_contents("php://input",'r');
        $this->response_body = $response_body;

        // json decode
        if ($data) {
            $tmp = json_decode($data, true);
            if ($tmp) {
                $data = $tmp;
            }
        }

        return $data;
    }


    /**
     * 取得呼叫 API 的 HTTP STATUS CODE
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->http_status_code;
    }

    /**
     * 取得呼叫 API 的 HTTP STATUS BODY (json 或 xml)
     * @return string
     */
    public function getResponseBody()
    {
        return $this->response_body;
    }

    /**
     * 取得 curl 錯誤
     * @return string
     */
    public function getCurlError()
    {
        return $this->curl_error;
    }

    /**
     * 驗證 SSO 請求
     * @param $sso_id
     * @param $sso_token
     */
    public function validSSO($sso_id, $sso_token, $from_system)
    {
        // 驗證是否正確
        $curl = new Curl();
        $systems = $this->CI->config->item('zuvio_sso_systems');
        $host = $systems[$from_system];
        if ( ! $host) {
            $this->outputError("SSO 遠端主機不存在！");
        }

        // 打 API 回去驗證 SSO 請求是否正確
        $sso_valid_url = "$host/sso/valid/{$sso_id}/{$sso_token}";
        $response = $curl->get($sso_valid_url);
        if ( ! $response || $curl->httpStatusCode != 200) {
            $this->outputError("SSO 請求錯誤 #1111！");
            return false;
        }
        if (isset($response->error) && $response->error) {
            $this->outputError("SSO 請求錯誤 #2222！");
            return false;
        }

        return $response;
    }

    
}

if (!function_exists('getallheaders'))
{
    /**
     * 取得 header (nginx 沒有此 function)
     */
    function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

