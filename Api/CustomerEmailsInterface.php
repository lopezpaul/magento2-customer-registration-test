<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */

namespace LopezPaul\CustomerRegistration\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface CustomerEmailsInterface
{

    /**
     * Send an email with basic customer information using custom template
     *
     * @param CustomerInterface $customer
     * @param string $toEmail
     * @param string $toName
     * @return void
     */
    public function notify(CustomerInterface $customer, string $toEmail, string $toName = ''):void;
}
