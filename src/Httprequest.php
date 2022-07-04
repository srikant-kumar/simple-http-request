<?php

/**
 * Description of Httprequest
 * Use this package for making simple &amp; complex http request
 *
 * @author Srikant Kumar
 */

namespace Httprequest;

class Httprequest {

    // Request URL
    private $url;
    // Content Type
    private $content_type = null;
    //Default Time Out
    private $time_out = 15;
    // Request type.
    private $request_method;
    // If the $request method is POST add post data
    private $post_data;
    // User Password will be used for Basic HTTP Authentication.
    private $user_password;
    // Variables used for cookie support.
    private $cookies_enabled = FALSE;
    private $cookie_path;
    //Connection Time Out
    private $connect_timeout = 10;
    // Enable or disable ssl checks.
    private $ssl = FALSE;
    // User agent if we want to send a custom
    private $user_agent = FALSE;
    // HTTP Headers as Array
    private $headers;
    // Execution Time, in ms.
    private $execution_time;
    // HTTP response body.
    private $response_body;
    // HTTP response header.
    private $response_header;
    // HTTP response status code.
    private $http_code;
    // cURL error.
    private $error;

    /**
     * Called when the Request object is created.
     */
    public function __construct($request_url) {
        $this->url = $request_url;
    }

    /* @Override Intial Set Url */

    public function set_request_url(string $request_url) {
        $this->url = $request_url;
    }

    /* Get Request Url */

    public function get_request_url() {
        return $this->url;
    }

    /* Set Content Type */

    public function set_content_type(string $content_type) {
        $this->content_type = $content_type;
    }

    /* Get Content Type */

    public function get_content_type() {
        return $this->content_type;
    }

    /* Set timeout. Timeout value in seconds. */

    public function set_timeout(int $timeout = 10) {
        $this->time_out = $timeout;
    }

    /* Get timeout */

    public function get_timeout() {
        return $this->time_out;
    }

    /**
     * Set a request type (by default, cURL will send a GET request).
     *   GET, POST, DELETE, PUT, etc
     */
    public function set_request_method(string $type) {
        $this->request_method = $type;
    }

    public function get_request_method() {
        return $this->request_method;
    }

    /* Set the POST fields (only used if $this->post_data is 'POST'). */

    public function set_post_data($data) {
        $this->post_data = $data;
    }

    /* Get Post Data */

    public function get_post_data() {
        return $this->post_data;
    }

    /* @param $username & $password will be used for basic auth */

    public function set_basic_auth(string $username, string $password) {
        $this->user_password = $username . ':' . $password;
    }

    /**
     * Enable cookies.
     * @param string $cookie_path : Absolute path to a txt file where cookie information will be stored.
     */
    public function enable_cookies(string $cookie_path) {
        $this->cookies_enabled = TRUE;
        $this->cookie_path = $cookie_path;
    }

    /* Disable cookies */

    public function disable_cookies() {
        $this->cookies_enabled = FALSE;
        $this->cookie_path = '';
    }

    /* Timeout value in seconds */

    public function set_connect_timeout(int $connection_timeout = 10) {
        $this->connect_timeout = $connection_timeout;
    }

    /* Enable SSL */

    public function enable_ssl() {
        $this->ssl = TRUE;
    }

    /* Disable SSL. */

    public function disable_ssl() {
        $this->ssl = FALSE;
    }

    /*  Send custom user agent */

    public function set_user_agent(string $useragent) {
        $this->user_agent = $useragent;
    }

    /* Set HTTP Request Headers */

    public function set_request_headers(array $request_headers = []) {
        if (isset($this->content_type) && !empty($this->content_type)) {
            $request_headers['Content-Type'] = $this->content_type;
        } else if (isset($request_headers['Content-Type'])) {
            $this->content_type = $request_headers['Content-Type'];
        }
        $header_arr = [];
        foreach ($request_headers as $req_key => $req_value) {
            $header_arr[] = $req_key . ': ' . $req_value;
        }
        $this->headers = $header_arr;
    }

    /* Set HTTP Request Headers */

    public function get_request_headers() {
        return $this->headers;
    }

    /*
     * Get connect timeout.
     * Timeout value in seconds.
     */

    public function get_connect_timeout() {
        return $this->connect_timeout;
    }

    /* Get the response body */

    public function get_response() {
        return $this->response_body;
    }

    /* Response header */

    public function get_response_header() {
        return $this->response_header;
    }

    /* Response header */

    public function get_response_header_array() {
        $headers['http_code'] = $this->http_code;
        foreach (explode("\r\n", $this->response_header) as $key => $line) {
            if (!empty($line)) {
                if ($key == 0)
                    $headers['http_status'] = $line;
                else {
                    list ($key, $value) = explode(': ', $line);
                    $headers[$key] = $value;
                }
            }
        }
        return $headers;
    }

    /* Get the HTTP status code for the response */

    public function get_http_code() {
        return $this->http_code;
    }

    /**
     * Get the latency (the total time spent waiting) for the response.
     *
     * @return int
     *   Latency, in milliseconds.
     */
    public function get_excution_time($unit = 'ms') {
        switch ($unit) {
            case 's':
                $time = $this->execution_time;
                break;
            case 'm':
                $time = $this->execution_time / 60;
                break;
            case 'h':
                $time = $this->execution_time / (60 * 60);
                break;

            default:
                $time = $this->execution_time * 1000;
                break;
        }
        return round($time);
    }

    /*   An error message, if any error was given. Otherwise, empty. */

    public function get_error() {
        return $this->error;
    }

    /**
     * Check for content in the HTTP response body.
     *
     * This method should not be called until after execute(), and will only check
     * for the content if the response code is 200 OK.
     * TRUE if $content was found in the response, FALSE otherwise.
     */
    public function check_response_for_content($content = '') {
        if ($this->httpCode == 200 && !empty($this->responseBody)) {
            if (strpos($this->responseBody, $content) !== FALSE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Check a given url with cURL.
     *
     * After this method is completed, the response body, headers, excution_time, etc.
     * will be populated, and can be accessed with the appropriate methods.
     */
    public function run() {
        // -----Set up cURL options-----------.
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->time_out);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        // ------Check Request Type And Add POST method option-----------
        if (isset($this->request_method)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->request_method);
            //Check if method is post & post data is passed
            if ($this->request_method == 'POST' && isset($this->post_data)) {
                $this->post_data = $this->make_post_data($this->post_data);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_data);
            }
        }


        // If Basic Auth Method
        if (isset($this->user_password)) {
            curl_setopt($ch, CURLOPT_USERPWD, $this->user_password);
        }

        // If Cookies is enabled
        if ($this->cookies_enabled) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_path);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_path);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);

        // SSL support.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->ssl);
        // Set a custom UA string so people can identify our requests.
        if ($this->user_agent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
        }
        // Output the header in the response.
        curl_setopt($ch, CURLOPT_HEADER, TRUE);

        //-----Setting Http Header
        if (isset($this->headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);

        // Set the header, response, error and http code.
        $this->response_header = substr($response, 0, $header_size);
        $this->response_body = substr($response, $header_size);
        $this->error = $error;
        $this->http_code = $http_code;

        // Convert the request time to s.
        $this->execution_time = $time;
    }

    //----------Making Post Data according to content type
    private function make_post_data($post_data) {
        switch ($this->content_type) {
            case 'application/json':
                $return_data = json_encode($post_data);
                break;
            case 'application/x-www-form-urlencoded':
                $return_data = http_build_query($post_data);
                break;
            case 'text/plain':
                if (is_array($post_data)) {
                    $return_data = json_encode($post_data);
                } else {
                    $return_data = $post_data;
                }
                break;
            default:
                $return_data = $post_data;
                break;
        }
        return $return_data;
    }

}
