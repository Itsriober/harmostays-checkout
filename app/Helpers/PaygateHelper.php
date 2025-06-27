<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PaygateHelper
{
    protected static $isLaravel = false;

    public static function init()
    {
        // Check if we're in a Laravel environment by checking if the app function exists and works
        try {
            self::$isLaravel = function_exists('app') && app()->bound('log');
        } catch (\Exception $e) {
            self::$isLaravel = false;
        }
    }

    protected static function log($level, $message, $context = [])
    {
        if (self::$isLaravel) {
            try {
                \Illuminate\Support\Facades\Log::$level($message, $context);
            } catch (\Exception $e) {
                // Fallback to console logging if Laravel logging fails
                $contextStr = !empty($context) ? json_encode($context, JSON_PRETTY_PRINT) : '';
                echo "[" . strtoupper($level) . "] $message" . ($contextStr ? "\n$contextStr" : "") . "\n";
            }
        } else {
            // Simple console logging for non-Laravel environment
            $contextStr = !empty($context) ? json_encode($context, JSON_PRETTY_PRINT) : '';
            echo "[" . strtoupper($level) . "] $message" . ($contextStr ? "\n$contextStr" : "") . "\n";
        }
    }

    public static function createWallet($callbackUrl, $walletAddress)
    {
        self::init();
        
        try {
            $client = new Client([
                'timeout' => 30,
                'headers' => [
                    'User-Agent' => 'HarmoStays-Checkout/1.0',
                    'Accept' => 'application/json',
                ]
            ]);
            
            $url = 'https://api.paygate.to/control/wallet.php';
            
            // Ensure callback URL is properly encoded
            $encodedCallback = urlencode($callbackUrl);
            
            $params = [
                'query' => [
                    'address' => $walletAddress,  // Fixed: was 'wallet', should be 'address'
                    'callback' => $encodedCallback,
                ],
                'http_errors' => false,
            ];
            
            self::log('info', 'PayGate API Request', [
                'url' => $url,
                'params' => $params['query']
            ]);
            
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            
            self::log('info', 'PayGate API Response', [
                'status' => $statusCode,
                'body' => $body
            ]);
            
            $data = json_decode($body, true);
            
            // Validate response structure
            if ($statusCode === 200 && $data && isset($data['address_in'], $data['ipn_token'])) {
                return [
                    'status' => $statusCode,
                    'data' => $data,
                    'raw' => $body,
                    'success' => true,
                ];
            } else {
                return [
                    'status' => $statusCode,
                    'data' => $data,
                    'raw' => $body,
                    'success' => false,
                    'error' => 'Invalid response structure or missing required fields',
                ];
            }
            
        } catch (RequestException $e) {
            self::log('error', 'PayGate API Request Exception', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            
            return [
                'status' => 0,
                'data' => null,
                'raw' => 'Request failed: ' . $e->getMessage(),
                'success' => false,
                'error' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            self::log('error', 'PayGate API General Exception', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            
            return [
                'status' => 0,
                'data' => null,
                'raw' => 'Unexpected error: ' . $e->getMessage(),
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    
    public static function checkPaymentStatus($ipnToken)
    {
        self::init();
        
        try {
            $client = new Client([
                'timeout' => 30,
                'headers' => [
                    'User-Agent' => 'HarmoStays-Checkout/1.0',
                    'Accept' => 'application/json',
                ]
            ]);
            
            $url = 'https://api.paygate.to/control/payment-status.php';
            $params = [
                'query' => [
                    'ipn_token' => $ipnToken,
                ],
                'http_errors' => false,
            ];
            
            self::log('info', 'PayGate Status Check Request', [
                'url' => $url,
                'ipn_token' => $ipnToken
            ]);
            
            $response = $client->request('GET', $url, $params);
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            $data = json_decode($body, true);
            
            self::log('info', 'PayGate Status Check Response', [
                'status' => $statusCode,
                'body' => $body
            ]);
            
            return [
                'status' => $statusCode,
                'data' => $data,
                'raw' => $body,
                'success' => $statusCode === 200 && $data !== null,
            ];
            
        } catch (\Exception $e) {
            self::log('error', 'PayGate Payment Status Check Exception', [
                'message' => $e->getMessage(),
                'ipn_token' => $ipnToken
            ]);
            
            return [
                'status' => 0,
                'data' => null,
                'raw' => 'Request failed: ' . $e->getMessage(),
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
