<?php

namespace App\Payment\Application\Command;

use App\Payment\Application\Constants\PaymentTestData;
use App\Payment\Application\Resource\PaymentResource;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

#[AsCommand(
    name: 'payment:process',
    description: 'Processing a payment with given provider',
)]
class ProcessPaymentCommand extends Command
{
    private PaymentResource $paymentResource;

    public function __construct(PaymentResource $paymentResource)
    {
        $this->paymentResource = $paymentResource;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('provider', InputArgument::REQUIRED, 'Available payment providers: (aci or shift4)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $provider = $input->getArgument('provider');

        $data = match ($provider) {
            'aci' => PaymentTestData::DATA_ACI,
            'shift4' => PaymentTestData::DATA_SHIFT4,
            default => throw new \InvalidArgumentException('Unsupported provider'),
        };

        $request = new Request([], [], [], [], [], [], json_encode($data));
        $request->attributes->set('provider', $provider);

        try {
            $response = $this->paymentResource->processPayment($request);

            if ($response instanceof JsonResponse) {
                if ($response->getStatusCode() !== Response::HTTP_OK) {
                    $this->formatValidationErrors(json_decode($response->getContent(), true), $output);
                    return Command::FAILURE;
                }

                $output->writeln($response->getContent());
            } else {
                $output->writeln('Failed to process payment');
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function formatValidationErrors($data, $output) : void 
    {
        if (isset($data['errors'])) {
            foreach ($data['errors'] as $field => $messages) {
                foreach ($messages as $message) {
                    $output->writeln(sprintf("Error in field '%s': %s\n", $field, $message));
                }
            }
        }

        if (isset($data['status']) && $data['status'] === 'error' && isset($data['message'])) {
            $output->writeln($data['message']);
        }
    }
}
