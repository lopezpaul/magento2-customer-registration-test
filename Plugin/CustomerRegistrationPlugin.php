<?php
declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */

namespace LopezPaul\CustomerRegistration\Plugin;

use LopezPaul\CustomerRegistration\Api\CustomerEmailsInterface;
use LopezPaul\CustomerRegistration\Api\CustomerLogsInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * @see \Magento\Customer\Model\AccountManagement::createAccount()
 */
class CustomerRegistrationPlugin
{
    private const XML_PATH_CUSTOMER_SUPPORT_NAME = 'trans_email/ident_support/name';
    private const XML_PATH_CUSTOMER_SUPPORT_EMAIL = 'trans_email/ident_support/email';

    /**
     * @param CustomerLogsInterface $customerLogs
     * @param CustomerEmailsInterface $customerEmails
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly CustomerLogsInterface $customerLogs,
        private readonly CustomerEmailsInterface $customerEmails,
        private readonly ScopeConfigInterface $scopeConfig,
    ) {
    }

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

    /**
     * Write custom log and send email with customer basic info (firstname,lastname,email)
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $result
     * @param CustomerInterface $customer
     * @param string|null $password
     * @param string|null $redirectUrl
     * @return mixed
     */
    public function afterCreateAccount(
        AccountManagementInterface $subject,
        CustomerInterface $result,
        CustomerInterface $customer,
        string|null $password = null,
        string|null $redirectUrl = ''
    ): CustomerInterface {
        $this->customerLogs->write($customer);
        [$name, $email] = $this->getCustomerSupportData();
        $this->customerEmails->notify($customer, $email, $name);
        return $result;
    }

    /**
     * Get customer support name and email from core_config_data table
     *
     * @return array
     */
    private function getCustomerSupportData(): array
    {
        return [
            $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_SUPPORT_NAME) ?? '',
            $this->scopeConfig->getValue(self::XML_PATH_CUSTOMER_SUPPORT_EMAIL) ?? ''
        ];
    }
}
