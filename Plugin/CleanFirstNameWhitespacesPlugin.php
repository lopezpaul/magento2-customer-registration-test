<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */
namespace LopezPaul\CustomerRegistration\Plugin;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * @see \Magento\Customer\Model\AccountManagement::createAccount()
 */
class CleanFirstNameWhitespacesPlugin
{
    /**
     * Remove spaces in customer first name
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $customer
     * @param string|null $password
     * @param string|null $redirectUrl
     * @return array
     */
    public function beforeCreateAccount(
        AccountManagementInterface $subject,
        CustomerInterface $customer,
        string|null $password = null,
        string|null $redirectUrl = ''
    ): array {
        $firstName = str_replace(' ', '', $customer->getFirstname() ?? null);
        $customer->setFirstname($firstName);
        return [$customer, $password, $redirectUrl];
    }
}
