<?php


namespace App\Services;

use Psr\Log\LoggerInterface;

class GoalSMSService {

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * sendSMS
     * Description : send a sms when a goal is received
     *
     * @param array $goal
     * @return bool
     */
    public function sendSMS(array $goal) : bool
    {
        // here procces with workers, queues for RabbitMQ

        $this->logger->info('message incoming');
        $this->logger->debug( var_export($goal, true));

        return true;
    }
}