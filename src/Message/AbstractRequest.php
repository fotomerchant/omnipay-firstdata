<?php
namespace Omnipay\Payeezy\Message;

/**
 * Payeezy Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    /** @var string Method used to calculate the hmac strings. */
    const METHOD_POST = 'POST';

    /** @var string Content type use to calculate the hmac string */
    const CONTENT_TYPE = 'application/json';

    /** @var string live endpoint URL base */
    protected $liveEndpoint = 'https://api.payeezy.com/v1/transactions/';

    /** @var string test endpoint URL base */
    protected $testEndpoint = 'https://api-cert.payeezy.com/v1/transactions/';

    /**
     * Get API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * Set API Key
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * Get API Secret
     *
     * @return string
     */
    public function getApiSecret()
    {
        return $this->getParameter('apiSecret');
    }

    /**
     * Set API Secret
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setApiSecret($value)
    {
        return $this->setParameter('apiSecret', $value);
    }

    /**
     * Get Merchant Token
     *
     * @return string
     */
    public function getMerchantToken()
    {
        return $this->getParameter('merchantToken');
    }

    /**
     * Set Merchant Token
     *
     * @param string $value
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function setMerchantToken($value)
    {
        return $this->setParameter('merchantToken', $value);
    }

    /**
     * Get the transaction headers.
     *
     * @return array
     */
    protected function getHeaders()
    {
        return array(
            'Content-Type'  => self::CONTENT_TYPE,
            'apikey'        => $this->getApiKey(),
            'token'         => $this->getMerchantToken(),
        );
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function hmacAuthorizationTokenHeaders($payload)
    {
        $payload = json_encode($payload, JSON_FORCE_OBJECT);
        $nonce = strval(hexdec(bin2hex(openssl_random_pseudo_bytes(4, $cstrong))));
        $timestamp = strval(time()*1000); //time stamp in milli seconds
        $data = $this->getApiKey() . $nonce . $timestamp . $this->getMerchantToken() . $payload;
        $hashAlgorithm = "sha256";
        $hmac = hash_hmac($hashAlgorithm, $data, $this->getApiSecret(), false); // HMAC Hash in hex
        $authorization = base64_encode($hmac);

        return array(
            'Authorization' => $authorization,
            'nonce' => $nonce,
            'timestamp' => $timestamp,
        );
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * @param mixed $data
     *
     * @return Response
     */
    public function sendData($data)
    {
        $headers  = $this->getHeaders();
        $endpoint = $this->getEndpoint();

        $hmacAuthHeaders = $this->hmacAuthorizationTokenHeaders($data);
        $headers = array_merge($headers, $hmacAuthHeaders);

        $httpResponse = $this->httpClient->request(
            'POST',
            $endpoint,
            $headers,
            json_encode($data)
        );

        /*
         * To fix the following API issue:
         *
         * [curl] 60: SSL certificate problem: self signed certificate in certificate chain [url] https://api-cert.payeezy.com/v1/transactions/
         * [curl] 60: Peer's certificate issuer has been marked as not trusted by the user. [url] https://api.payeezy.com/v1/transactions/
         */
        // $client->getCurlOptions()->set(CURLOPT_SSL_VERIFYPEER, false);

        return $this->createResponse($httpResponse->getBody()->getContents());
    }

    /**
     * Get the endpoint URL for the request.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * Create the response object.
     *
     * @param $data
     *
     * @return Response
     */
    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
