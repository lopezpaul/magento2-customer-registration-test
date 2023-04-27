<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */

namespace LopezPaul\CustomerRegistration\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface CustomerLogsInterface
{
    /**
     * Write customer data on /var/low/lopezpaul.log
     *
     * @param CustomerInterface $customer
     * @return void
     */
    public function write(CustomerInterface $customer):void;
}
