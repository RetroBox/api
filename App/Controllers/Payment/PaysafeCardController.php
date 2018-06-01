<?php

namespace App\Controllers\Payment;

use App\Controllers\Controller;
use DI\Container;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SebastianWalker\Paysafecard\Amount;
use SebastianWalker\Paysafecard\Client;
use SebastianWalker\Paysafecard\Payment;
use Validator\Validator;

class PaysafeCardController extends Controller
{
	public function getUrl(ServerRequestInterface $request, ResponseInterface $response, Client $client)
	{
		$amount = new Amount(5.00, "EUR");
		$payment = new Payment($amount, "customer123");
		$payment->create($client);

		return $response->withJson([
			'success' => true,
			'data' => ['url' => $payment->getAuthUrl()]
		]);
	}

	public function getSuccess(ServerRequestInterface $request, ResponseInterface $response, Logger $logger, Client $client)
	{
		$validator = new Validator($request->getQueryParams());
		$validator->required('mtid');

		$logger->info("NEW   --    success");
		if ($validator->isValid()) {
			$payment = Payment::find($validator->getValue("mtid"), $client);
			$logger->info('retrieve payment details');
			if ($payment->isSuccessful()){
				return $response->withJson([
					'success' => true,
					'payment' => [
						'id' => $payment->getId(),
						'amount' => [
							'currency' => $payment->getAmount()->getCurrency(),
							'amount' => $payment->getAmount()->getAmount()
						],
						'status' => $payment->getStatus(),
						'customer_id' => $payment->getCustomerId()
					]
				]);
			}else{
				return $response->withJson([
					'success' => false,
					'payment' => [
						'id' => $payment->getId(),
						'status' => $payment->getStatus()
					]
				])->withStatus(400);
			}
		}else{
			return $response->withJson([
				'success' => false,
				'errors' => $validator->getErrors()
			])->withStatus(400);
		}
	}

	public function getFailure(ServerRequestInterface $request, ResponseInterface $response)
	{
		return $response->withJson([
			'success' => false,
			'message' => 'Redirect failure of payment'
		]);
	}

	public function getCapturePayment(ServerRequestInterface $request, ResponseInterface $response, Logger $logger)
	{
		$logger->info('new getCapturePayment : ```' . json_encode($request->getQueryParams()) . "```");

		return $response->withJson([
			'success' => true,
			'message' => 'success'
		]);
	}

	public function postCapturePayment(ServerRequestInterface $request, ResponseInterface $response, Client $client, Logger $logger)
	{
		$validator = new Validator($request->getParsedBody());
		$validator->required('mtid');

		$logger->info("NEW       --    body: " . json_encode($request->getParsedBody()));
		if ($validator->isValid()) {

			$logger->info('New payment notification : ' . $validator->getValue("mtid"));

			try {
				// Find the payment the user was redirected from
				$payment = Payment::find($validator->getValue("mtid"), $client);
			} catch (\Exception $e) {

				$logger->error('Payment not found : error : ```' . $e->getMessage() . "```");

				return $response->withJson([
					'success' => false,
					'errors' => [
						$e->getCode() . " " . $e->getMessage()
					]
				])->withStatus(400);

			}

			// Check if the payment was authorized
			if ($payment->isAuthorized()) {
				// ... and capture it
				$payment->capture($client);

				if ($payment->isSuccessful()) {
					$logger->info("SUCCESS: success isSuccessful == true");

					return $response->withJson([
						'success' => true
					]);
				} else {
					return $this->paymentBadStatus($logger, $response, $payment);
				}
			} elseif ($payment->isFailed()) {
				return $this->paymentBadStatus($logger, $response, $payment);
			} else {
				return $this->paymentBadStatus($logger, $response, $payment);
			}
		} else {

			$logger->error("Failed: validator don't succeed");

			return $response->withJson([
				'success' => false,
				'errors' => $validator->getErrors()
			])->withStatus(400);
		}
	}

	private function paymentBadStatus(Logger $logger, ResponseInterface $response, Payment $payment)
	{
		if ($payment->getStatus() == "REDIRECTED") {
			return $response->withJson([
				'success' => true,
				'message' => [
					'Redirect '
				]
			]);
		} else {
			$logger->error('Payment bad status : status : ```' . $payment->getStatus() . "```");

			return $response->withJson([
				'success' => false,
				'errors' => [
					$payment->getStatus()
				]
			])->withStatus(400);

		}

	}
}
