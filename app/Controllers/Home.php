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
        $client_id = '9983cf6e-f1af-4fb2-8f05-01918fe72cd5';
        $client_secret = '7Tr7fjfZKp2QTBroL2CvkytBEaqVyaAHW';
        $app_id = '79226fc8-6c07-4137-9ab3-fc442b7a5af9';

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
        $json_data = json_encode($content, JSON_PRETTY_PRINT);

        $filename = WRITEPATH . 'input_data.json';

        file_put_contents($filename, $json_data);
    }
}