<?php

namespace Kang\LaravelMobileDetect;

use Illuminate\Config\Repository;

class MobileDetect
{
    public $userAgent = null;
    public $httpHeaders;
    protected $detectionType = 'mobile'; // mobile, extended @todo: refactor this.
    // Arrays holding all detection rules.
    protected $mobileDetectionRules = null;
    protected $mobileDetectionRulesExtended = null;

    protected $phoneDevices;
    protected $tabletDevices;
    protected $operatingSystems;
    protected $userAgents;
    protected $utilities;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->phoneDevices = config('mobiledetect.phoneDevice');
        $this->tabletDevices = config('mobiledetect.tabletDevices');
        $this->operatingSystems = config('mobiledetect.operatingSystems');
        $this->userAgents = config('mobiledetect.userAgents');
        $this->utilities = config('mobiledetect.utilities');

        $this->setHttpHeaders();
        $this->setUserAgent();

        $this->setMobileDetectionRules();
        $this->setMobileDetectionRulesExtended();
    }

    public function setHttpHeaders($httpHeaders = null)
    {
        if (!empty($httpHeaders)) {
            $this->httpHeaders = $httpHeaders;
        } else {
            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) == 'HTTP_') {
                    $this->httpHeaders[$key] = $value;
                }
            }
        }
    }

    public function setUserAgent($userAgent = null)
    {
        if (!empty($userAgent)) {
            $this->userAgent = $userAgent;
        } else {
            $this->userAgent = isset($this->httpHeaders['HTTP_USER_AGENT']) ? $this->httpHeaders['HTTP_USER_AGENT'] : null;

            if (empty($this->userAgent)) {
                $this->userAgent = isset($this->httpHeaders['HTTP_X_DEVICE_USER_AGENT']) ? $this->httpHeaders['HTTP_X_DEVICE_USER_AGENT'] : null;
            }
            // Header can occur on devices using Opera Mini (can expose the real device type). Let's concatenate it (we need this extra info in the regexes).
            if (!empty($this->httpHeaders['HTTP_X_OPERAMINI_PHONE_UA'])) {
                $this->userAgent .= ' '.$this->httpHeaders['HTTP_X_OPERAMINI_PHONE_UA'];
            }
        }
    }
    /**
     * Method sets the mobile detection rules.
     *
     * This method is used for the magic methods $detect->is*()
     */
    public function setMobileDetectionRules(){
        // Merge all rules together.
        $this->mobileDetectionRules = array_merge(
            $this->phoneDevices,
            $this->tabletDevices,
            $this->operatingSystems,
            $this->userAgents
        );
    }

    /**
     * Method sets the mobile detection rules + utilities.
     * The reason this is separate is because utilities rules
     * don't necessary imply mobile.
     *
     * This method is used inside the new $detect->is('stuff') method.
     *
     * @return bool
     */
    public function setMobileDetectionRulesExtended(){

        // Merge all rules together.
        $this->mobileDetectionRulesExtended = array_merge(
            $this->phoneDevices,
            $this->tabletDevices,
            $this->operatingSystems,
            $this->userAgents,
            $this->utilities
        );
    }

    /**
     * Check the HTTP headers for signs of mobile.
     * This is the fastest mobile check possible; it's used
     * inside isMobile() method.
     *
     * @return bool
     */
    public function checkHttpHeadersForMobile()
    {
        if (
            isset($this->httpHeaders['HTTP_ACCEPT']) &&
                (strpos($this->httpHeaders['HTTP_ACCEPT'], 'application/x-obml2d') !== false || // Opera Mini; @reference: http://dev.opera.com/articles/view/opera-binary-markup-language/
                 strpos($this->httpHeaders['HTTP_ACCEPT'], 'application/vnd.rim.html') !== false || // BlackBerry devices.
                 strpos($this->httpHeaders['HTTP_ACCEPT'], 'text/vnd.wap.wml') !== false ||
                 strpos($this->httpHeaders['HTTP_ACCEPT'], 'application/vnd.wap.xhtml+xml') !== false) ||
            isset($this->httpHeaders['HTTP_X_WAP_PROFILE']) || // @todo: validate
            isset($this->httpHeaders['HTTP_X_WAP_CLIENTID']) ||
            isset($this->httpHeaders['HTTP_WAP_CONNECTION']) ||
            isset($this->httpHeaders['HTTP_PROFILE']) ||
            isset($this->httpHeaders['HTTP_X_OPERAMINI_PHONE_UA']) || // Reported by Nokia devices (eg. C3)
            isset($this->httpHeaders['HTTP_X_NOKIA_IPADDRESS']) ||
            isset($this->httpHeaders['HTTP_X_NOKIA_GATEWAY_ID']) ||
            isset($this->httpHeaders['HTTP_X_ORANGE_ID']) ||
            isset($this->httpHeaders['HTTP_X_VODAFONE_3GPDPCONTEXT']) ||
            isset($this->httpHeaders['HTTP_X_HUAWEI_USERID']) ||
            isset($this->httpHeaders['HTTP_UA_OS']) || // Reported by Windows Smartphones.
            isset($this->httpHeaders['HTTP_X_MOBILE_GATEWAY']) || // Reported by Verizon, Vodafone proxy system.
            isset($this->httpHeaders['HTTP_X_ATT_DEVICEID']) || // Seend this on HTC Sensation. @ref: SensationXE_Beats_Z715e
            //HTTP_X_NETWORK_TYPE = WIFI
            (isset($this->httpHeaders['HTTP_UA_CPU']) &&
                    $this->httpHeaders['HTTP_UA_CPU'] == 'ARM'          // Seen this on a HTC.
            )
        ) {
            return true;
        }

        return false;
    }

    public function setDetectionType($type = null){

        $this->detectionType = (!empty($type) ? $type : 'mobile');

    }
    /**
     * Check if the device is mobile.
     * Returns true if any type of mobile device detected, including special ones.
     *
     * @param null $userAgent   deprecated
     * @param null $httpHeaders deprecated
     *
     * @return bool
     */
    public function isMobile($userAgent = null, $httpHeaders = null)
    {
        if ($httpHeaders) {
            $this->setHttpHeaders($httpHeaders);
        }
        if ($userAgent) {
            $this->setUserAgent($userAgent);
        }

        $this->setDetectionType('mobile');

        if ($this->checkHttpHeadersForMobile()) {
            return true;
        } else {
            return $this->matchDetectionRulesAgainstUA();
        }
    }
}
