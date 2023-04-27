<h1 align="center">LopezPaul_CustomerRegistration</h1> 
<div align="center">
    <img src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true&style=flat-square" alt="Supported Magento Versions" />
    <a href="https://opensource.org/licenses/MIT" target="_blank">
        <img src="https://img.shields.io/badge/license-MIT-blue.svg" />
    </a>
</div>

## Summary

This module modifies customer registration flow. Once a new customer is being registered, 
the extension checks the First Name field. If the First Name field has whitespaces, 
they must be removed, so the customer entity is saved without whitespaces in the First Name property. 
Once the customer has been successfully registered, the extension invoke these actions:
- Log customer data (current date and time, customer first name, customer last name, customer email)
to separate log file name _lopezpaul.log_ in the _var/log_ directory.
- Send an email with the customer data (customer first name, customer last name, 
customer email) to the Customer Support email address configured in Magento

## Requirements

- PHP ~8.1.0||~8.2.0
- Magento 2.4.6 CE

## Dependencies

- Magento_Customer
- Magento_Email

## Installation

```
composer require lopezpaul/module-customer-registration
bin/magento module:enable LopezPaul_CustomerRegistration 
bin/magento setup:upgrade
```

## License

[MIT](https://opensource.org/licenses/MIT)
