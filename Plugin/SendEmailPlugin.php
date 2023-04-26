<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */
namespace LopezPaul\CustomerRegistration\Plugin;

use LopezPaul\CustomerRegistrationApi\Api\ConfigManagerInterface;
use LopezPaul\CustomerRegistrationApi\Api\CustomerEmailsInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * @see \Magento\Customer\Model\AccountManagement::createAccount()
 */
class SendEmailPlugin
{
    private const XML_PATH_CUSTOMER_SUPPORT_NAME = 'trans_email/ident_support/name';
    private const XML_PATH_CUSTOMER_SUPPORT_EMAIL = 'trans_email/ident_support/email';

    /**
     * @param CustomerEmailsInterface $customerEmails
     * @param ConfigManagerInterface $configManager
     */
    public function __construct(
        private CustomerEmailsInterface $customerEmails,
        private ConfigManagerInterface $configManager
    ) {
    }

    /**
     * Send an email with basic customer data to customer support email
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
    ):CustomerInterface {
        [$name,$email] = $this->getCustomerSupportData();
        $this->customerEmails->notify($customer, $email, $name);
        return $result;
    }

    /**
     * Get customer support name and email from core_config_data table
     *
     * @return array
     */
    private function getCustomerSupportData():array
    {
        return [
            $this->configManager->get(self::XML_PATH_CUSTOMER_SUPPORT_NAME) ?? '',
            $this->configManager->get(self::XML_PATH_CUSTOMER_SUPPORT_EMAIL) ?? ''
        ];
    }
}
