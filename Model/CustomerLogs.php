<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */
namespace LopezPaul\CustomerRegistration\Model;

use LopezPaul\CustomerRegistration\Api\CustomerLogsInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;

class CustomerLogs implements CustomerLogsInterface
{
    /**
     * @param Logger $logger
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly TimezoneInterface $timezone
    ) {
    }

    /**
     * Write customer data on /var/low/lopezpaul.log
     *
     * @param CustomerInterface $customer
     * @return void
     */
    public function write(CustomerInterface $customer):void
    {
        $this->logger->info('Customer created at: ' . $this->timezone->date()->format('Y-m-d H:i:s'));
        $this->logger->info('First Name:' . $customer->getFirstname() ?? '');
        $this->logger->info('Last Name:' . $customer->getLastname() ?? '');
        $this->logger->info('Email:' . $customer->getEmail() ?? '');
    }
}
