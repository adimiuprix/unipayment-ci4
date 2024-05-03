<?php

namespace App\Controllers;
use UniPayment\Client\UniPaymentClient;
use UniPayment\Client\Model\CreateInvoiceRequest;

class Home extends BaseController
{
    public function index(): string
    {
        return view('payform');
    }

    public function createInvoice()
    {
        // Ganti dengan kredensial yang sesuai
        $client_id = '03e56c38-3016-48da-9cf7-d7532aefab37';
        $client_secret = '9dvP94EykB2zErzmHB7naAb8LxH4CLhou';
        $app_id = '4e9a85e3-1ebb-4bad-b309-ae3525c41573';

        // Persiapkan data untuk membuat faktur
        $createInvoiceRequest = new CreateInvoiceRequest();
        $createInvoiceRequest->setAppId($app_id);
        $createInvoiceRequest->setPriceAmount("5.00");
        $createInvoiceRequest->setPriceCurrency("USD");
        $createInvoiceRequest->setNetwork("NETWORK_BSC");
        $createInvoiceRequest->setPayCurrency("UTT");
        $createInvoiceRequest->setNotifyUrl("https://faithful-terrier-logically.ngrok-free.app/notify");
        $createInvoiceRequest->setRedirectUrl("https://faithful-terrier-logically.ngrok-free.app/");
        $createInvoiceRequest->setOrderId("B36P66E567TV4EDVC4956VC76UN");
        $createInvoiceRequest->setTitle("Ini WORK");
        $createInvoiceRequest->setDescription("idhieihtieusfhiesutheisfne irhfeis hfiesheish enis");

        // Inisialisasi klien UniPayment
        $client = new UniPaymentClient();
        $client->getConfig()->setClientId($client_id);
        $client->getConfig()->setClientSecret($client_secret);
        $client->getConfig()->setIsSandbox(true);

        // Membuat faktur
        $invoice_response = $client->createInvoice($createInvoiceRequest);
        $invoice_url = $invoice_response['data']['invoice_url'];

        return redirect()->to($invoice_url);
    }

    public function handleIPN()
    {
        $content = file_get_contents("php://input");
        $filename = WRITEPATH . 'input_data.json';

        $data = [
            "input_data" => $content
        ];

        $json_data = json_encode($data, JSON_PRETTY_PRINT);

        file_put_contents($filename, $json_data);
    }
}