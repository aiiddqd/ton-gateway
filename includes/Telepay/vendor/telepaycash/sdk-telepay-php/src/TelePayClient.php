<?php

namespace TelePay;

class TelePayClient
{
    private $environment;

    /**
     * Constructor for TelePayClient
     * @param TelePayEnvironment $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    /**
     * Info about the current merchant
     */
    public function getMe()
    {
        static $merchantCache;
        if (!$merchantCache) {
            $url = $this->environment->getBaseUrl() . "getMe";
            $response = $this->makeRequest($url);
            $merchantCache = $response;
        }

        return $merchantCache;
    }

    /**
     * Get your merchant wallet assets with corresponding balance
     */
    public function getBalance()
    {
        $url = $this->environment->getBaseUrl() . "getBalance";
        $response = $this->makeRequest($url);
        return $response;
    }

    /**
     * Get assets suported by TelePay
     */
    public function getAssets()
    {
        static $assetCache;
        if (!$assetCache) {
            $url = $this->environment->getBaseUrl() . "getAssets";
            $response = $this->makeRequest($url);
            $assetCache = $response;
        }
        return $assetCache;
    }

    /**
     * Get asset details
     * @param TelePayAssetInput $asset
     */
    public function getAsset($asset)
    {
        $url = $this->environment->getBaseUrl() . "getAsset";
        $assetBody = $asset->getBodyPrepared();
        $response = $this->makeRequest($url, $assetBody, 'GET');
        return $response;
    }

    /**
     * Get your merchant invoices
     */
    public function getInvoices()
    {
        $url = $this->environment->getBaseUrl() . "getInvoices";
        $response = $this->makeRequest($url);
        return $response;
    }

    /**
     * Get invoice details, by its number
     * @param Int $invoiceNumber
     */
    public function getInvoice($invoiceNumber)
    {
        $url = $this->environment->getBaseUrl() . "getInvoice/" . $invoiceNumber;
        $response = $this->makeRequest($url);
        return $response;
    }

    /**
     * Creates an invoice, associated to your merchant
     * @param TelePayInvoiceInput $invoice
     */
    public function createInvoice($invoice)
    {
        $this->validate($invoice->getAsset(), $invoice->getBlockchain(), $invoice->getNetwork());
        $url = $this->environment->getBaseUrl() . "createInvoice";
        $invoiceBody = $invoice->getBodyPrepared();
        $response = $this->makeRequest($url, $invoiceBody, "POST");
        return $response;
    }

    /**
     * Cancel invoice, by its number
     * @param Int $invoiceNumber
     */
    public function cancelInvoice($invoiceNumber)
    {
        $url = $this->environment->getBaseUrl() . "cancelInvoice/" . $invoiceNumber;
        $response = $this->makeRequest($url, null, "POST");
        return $response;
    }

    /**
     * Delete invoice, by its number
     * @param Int $invoiceNumber
     */
    public function deleteInvoice($invoiceNumber)
    {
        $url = $this->environment->getBaseUrl() . "deleteInvoice/" . $invoiceNumber;
        $response = $this->makeRequest($url, null, "POST");
        return $response;
    }

    /**
     * Transfer funds between internal wallets. Off-chain operation
     * @param TelePayTransferInput $transfer
     */
    public function transfer($transfer)
    {
        $this->validate($transfer->getAsset(), $transfer->getBlockchain(), $transfer->getNetwork());
        $url = $this->environment->getBaseUrl() . "transfer";
        $transferBody = $transfer->getBodyPrepared();
        $response = $this->makeRequest($url, $transferBody, "POST");
        return $response;
    }

    /**
     * Get estimated withdraw fee, composed of blockchain fee and processing fee
     * @param TelePayWithdrawInput $withdraw
     */
    public function getWithdrawFee($withdraw)
    {
        $this->validate($withdraw->getAsset(), $withdraw->getBlockchain(), $withdraw->getNetwork());
        $url = $this->environment->getBaseUrl() . "getWithdrawFee";
        $withdrawBody = $withdraw->getBodyPrepared();
        $response = $this->makeRequest($url, $withdrawBody, "POST");
        return $response;
    }

    /**
     * Withdraw funds from merchant wallet to external wallet. On-chain operation
     * @param TelePayWithdrawInput $withdraw
     */
    public function withdraw($withdraw)
    {
        $this->validate($withdraw->getAsset(), $withdraw->getBlockchain(), $withdraw->getNetwork());
        $url = $this->environment->getBaseUrl() . "withdraw";
        $withdrawBody = $withdraw->getBodyPrepared();
        set_time_limit(60);
        $response = $this->makeRequest($url, $withdrawBody, "POST");
        return $response;
    }

    /**
     * Withdraw funds from merchant wallet to external wallet. On-chain operation
     * @param TelePayWithdrawMinimumInput $withdraw
     */
    public function getWithdrawMinimum($withdrawMinimum)
    {
        $this->validate($withdrawMinimum->getAsset(), $withdrawMinimum->getBlockchain(), $withdrawMinimum->getNetwork());
        $url = $this->environment->getBaseUrl() . "getWithdrawMinimum";
        $withdrawBody = $withdrawMinimum->getBodyPrepared();
        $response = $this->makeRequest($url, $withdrawBody, "POST");
        return $response;
    }

    /**
     * Get webhooks
     */
    public function getWebhooks()
    {
        $url = $this->environment->getBaseUrl() . "getWebhooks";
        $response = $this->makeRequest($url);
        return $response;
    }

    /**
     * Get webhook details
     * @param int $webhookId
     */
    public function getWebhook($webhookId)
    {
        $url = $this->environment->getBaseUrl() . "getWebhook/" . $webhookId;
        $response = $this->makeRequest($url);
        return $response;
    }

    /**
     * Create a new webhook
     * @param TelePayWebhookInput $webhook
     */
    public function createWebhook($webhook)
    {
        $url = $this->environment->getBaseUrl() . "createWebhook";
        $webhookBody = $webhook->getBodyPrepared();
        $response = $this->makeRequest($url, $webhookBody, "POST");
        return $response;
    }

    /**
     * Update a webhook
     * @param int $webhookId
     * @param TelePayWebhookInput $webhook
     */
    public function updateWebhook($webhookId, $webhook)
    {
        $url = $this->environment->getBaseUrl() . "updateWebhook/" . $webhookId;
        $webhookBody = $webhook->getBodyPrepared();
        unset($webhookBody['active']);
        $response = $this->makeRequest($url, $webhookBody, "POST");
        return $response;
    }

    /**
     * Deletes a webhook
     * @param int $webhookId
     */
    public function deleteWebhook($webhookId)
    {
        $url = $this->environment->getBaseUrl() .  "deleteWebhook/" . $webhookId;
        $response = $this->makeRequest($url, [], "POST");
        return $response;
    }

    /**
     * Activates a webhook
     * @param int $webhookId
     */
    public function activateWebhook($webhookId)
    {
        $url = $this->environment->getBaseUrl() .  "activateWebhook/" . $webhookId;
        $response = $this->makeRequest($url, [], "POST");
        return $response;
    }

    /**
     * Deactivates a webhook
     * @param int $webhookId
     */
    public function deactivateWebhook($webhookId)
    {
        $url = $this->environment->getBaseUrl() .  "deactivateWebhook/" . $webhookId;
        $response = $this->makeRequest($url, [], "POST");
        return $response;
    }

    /**
     * Validate asset, blockchain and network combination
     * @param string $asset
     * @param string $blockchain
     * @param string $network
     * @return void
     * @throws TelePayException
     */
    public function validate($asset, $blockchain, $network)
    {
        $assetsResponse = $this->getAssets();
        $combinationExist = false;
        foreach ($assetsResponse['assets'] as $assetItem) {
            if ($assetItem['asset'] != $asset || $assetItem['blockchain'] != $blockchain) {
                continue;
            }
            foreach ($assetItem['networks'] as $networkItem) {
                if ($networkItem == $network) {
                    $combinationExist = true;
                    break;
                }
            }
            if ($combinationExist) {
                break;
            }
        }
        if (!$combinationExist) {
            throw new TelePayException(
                "The combination of asset $asset, blockchain $blockchain and network $network does not exist",
                401,
                "INVALID_ASSET_BLOCKCHAIN_NETWORK_COMBINATION"
            );
        }
    }

    private function makeRequest($url, $body = [], $verb = "GET")
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'AUTHORIZATION: ' . $this->environment->getClientSecret()
        ));
        if ($body) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        }
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $verb);
        $response = json_decode(curl_exec($curl), true);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpCode != 200 && $httpCode != 201) {
            if (isset($response['error'])) {
                throw new TelePayException($response['message'], $httpCode, $response['error']);
            }
            throw new TelePayException(json_encode($response), $httpCode);
        }
        return $response;
    }

    /**
     * Validate Webhooks signature
     * @param string $data
     * @param string $signature
     * @return boolean
     */
    public function validateSignature($data, $signature)
    {
        $data = str_replace(["\"", "null"], ["'", "None"], $data);
        $hashSecret = hash('sha1', $this->environment->getClientSecret());
        $hashData = hash('sha512', utf8_encode($data));
        $mySignature = hash('sha512', ($hashSecret . $hashData));
        return $mySignature === $signature;
    }
}
