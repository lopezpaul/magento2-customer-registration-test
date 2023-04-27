<?php declare(strict_types=1);
/**
 * Copyright © 2023 LopezPaul. All rights reserved.
 *
 * @package  LopezPaul_CustomerRegistrationApi
 * @author   Paul Lopez <paul.lopezm@gmail.com>
 */
namespace LopezPaul\CustomerRegistration\Logger;

use Monolog\Logger;
use Magento\Framework\Logger\Handler\Base;

class Handler extends Base
{
    /** @var int $loggerType */
    protected $loggerType = Logger::INFO;

    /** @var string $fileName */
    protected $fileName = '/var/log/lopezpaul.log';
}
