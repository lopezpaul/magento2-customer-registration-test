# Atwix_CustomerRegistrationTest module

## Description

This module modifies customer registration flow. Once a new customer is being registered, 
the extension checks the First Name field. If the First Name field has whitespaces, 
they must be removed, so the customer entity is saved without whitespaces in the First Name property. 
Once the customer has been successfully registered, the extension invoke these actions:
- Log customer data (current date and time, customer first name, customer last name, customer email)
to separate log file name _atwix.log_ in the _var/log_ directory.
- Send an email with the customer data (customer first name, customer last name, 
customer email) to the Customer Support email address configured in Magento

## Requirement 
- PHP ~8.1.0||~8.2.0
- Magento 2.4.6 CE

## Dependencies

- Magento_Customer
- Magento_Email

## Installation

1. Uncompress file on your main directory of magento installation and automatically it 
will create directories inside `app/code/Atwix` with the name of the extension:
   - *CustomerRegistrationTest*
   - *CustomerRegistrationTestApi*
2. Run `bin/magento setup:upgrade`

