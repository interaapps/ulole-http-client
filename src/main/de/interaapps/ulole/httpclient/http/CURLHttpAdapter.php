<?php /** @noinspection PhpComposerExtensionStubsInspection */

namespace de\interaapps\ulole\httpclient\http;

use de\interaapps\ulole\httpclient\exceptions\HttpException;
use de\interaapps\ulole\httpclient\HttpClient;
use de\interaapps\ulole\httpclient\HttpRequest;
use de\interaapps\ulole\httpclient\HttpResponse;

class CURLHttpAdapter implements HttpAdapter {
    /**
     * @throws HttpException
     */
    public function do(HttpClient $client, HttpRequest $request): HttpResponse {
        $curlReq = curl_init();

        curl_setopt($curlReq, CURLOPT_URL, $request->getUrl());
        curl_setopt($curlReq, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($curlReq, CURLOPT_RETURNTRANSFER, true);

        if ($request->getTimeout() !== null)
            curl_setopt($curlReq, CURLOPT_TIMEOUT_MS, $request->getTimeout());

        curl_setopt($curlReq, CURLOPT_FOLLOWLOCATION, $request->isFollowingRedirects());

        $headers = [];
        foreach ($request->getHeaders() as $key => $val) {
            $headers[] = "$key: $val";
        }

        curl_setopt($curlReq, CURLOPT_HTTPHEADER, $headers);

        if ($request->getBody() !== null && in_array($request->getMethod(), ["POST", "PUT", "PATCH"])) {
            curl_setopt($curlReq, CURLOPT_POSTFIELDS, $request->getBody());
        }

        $headers = [];
        curl_setopt($curlReq, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2)
                    return $len;
                $headers[strtolower(trim($header[0]))] = trim($header[1]);
                return $len;
            }
        );


        $body = curl_exec($curlReq);
        if ($body === false)
            throw new HttpException(curl_error($curlReq));

        curl_close($curlReq);

        $status = curl_getinfo($curlReq, CURLINFO_HTTP_CODE);

        return new HttpResponse($client, $status, $body, $headers);
    }
}