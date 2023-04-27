<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistration
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */

namespace LopezPaul\CustomerRegistration\Model;

use LopezPaul\CustomerRegistration\Api\CustomerEmailsInterface;
use LopezPaul\CustomerRegistration\Logger\Logger;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CustomerEmails implements CustomerEmailsInterface
{
    private const EMAIL_TEMPLATE_NEW_CUSTOMER = 'new_customer';
    private const XML_PATH_STORE_OWNER_NAME = 'trans_email/ident_general/name';
    private const XML_PATH_STORE_OWNER_EMAIL = 'trans_email/ident_general/email';

    /**
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param Logger $logger
     */
    public function __construct(
        private readonly TransportBuilder $transportBuilder,
        private readonly StoreManagerInterface $storeManager,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly Logger $logger
    ) {
    }

    /**
     * Write customer data on /var/log/lopezpaul.log
     *
     * @param CustomerInterface $customer
     * @param string $toEmail
     * @param string $toName
     * @return void
     */
    public function notify(CustomerInterface $customer, string $toEmail, string $toName = ''): void
    {
        $vars = [
            'first_name' => $customer->getFirstname() ?? '',
            'last_name' => $customer->getLastname() ?? '',
            'email' => $customer->getEmail() ?? ''
        ];
        try {
            $this->sendEmail(self::EMAIL_TEMPLATE_NEW_CUSTOMER, $toEmail, $toName, $vars);
        } catch (MailException|LocalizedException|NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * Send email
     *
     * @param string $template
     * @param string $email
     * @param string $name
     * @param array $vars
     * @return void
     * @throws LocalizedException
     * @throws MailException
     * @throws NoSuchEntityException
     */
    private function sendEmail(string $template, string $email, string $name = '', array $vars = []): void
    {
        $storeId = $this->storeManager->getStore()->getId() ?? 1;
        $from = $this->getStoreOwnerData();

        $transport = $this->transportBuilder->setTemplateIdentifier($template)
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $storeId
                ]
            )
            ->setTemplateVars($vars)
            ->setFromByScope($from)
            ->addTo($email, $name)
            ->getTransport();
        $transport->sendMessage();
    }

    /**
     * Get customer support name and email
     *
     * @return array
     */
    private function getStoreOwnerData(): array
    {
        return [
            'name' => $this->scopeConfig->getValue(self::XML_PATH_STORE_OWNER_NAME) ?? '',
            'email' => $this->scopeConfig->getValue(self::XML_PATH_STORE_OWNER_EMAIL) ?? ''
        ];
    }
}
