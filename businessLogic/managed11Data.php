<?php
    require_once('paypalConfig.php');
//Integrated Sign Up Partner Referral Request Data
    $mamRequestData = '{
                         "owner_info": {
                           "email": "'.SELLER_1_EMAIL.'",
                           "name": {
                             "given_name": "Lily",
                             "surname": "Smith"
                           },
                           "country_code_of_nationality": "'.COUNTRY_CODE.'",
                           "addresses": [
                             {
                               "type": "HOME",
                               "line1": "2255 North First Street",
                               "line2": "Bldg 17",
                               "city": "San Jose",
                               "state": "CA",
                               "country_code": "US",
                               "postal_code": "95131"
                             }
                           ],
                           "date_of_birth": "1990-01-01",
                           "ssn": "123456789",
                           "phones": [
                             {
                               "type": "HOME",
                               "country_code": "1",
                               "national_number": "4089671000",
                               "extension_number": "0"
                             },
                             {
                               "type": "MOBILE",
                               "country_code": "1",
                               "national_number": "4089671000",
                               "extension_number": "0"
                             }
                           ]
                         },
                         "business_info": {
                           "type": "INDIVIDUAL",
                           "names": [
                             {
                               "type": "LEGAL",
                               "name": "'.SELLER1_NAME.'"
                             },
                             {
                               "type": "DOING_BUSINESS_AS",
                               "name": "'.PARTNER_NAME.'"
                             }
                           ],
                           "employer_identification_number": "113704566",
                           "addresses": [
                             {
                               "type": "WORK",
                               "line1": "2211 North First Street",
                               "line2": "Bldg 17",
                               "city": "San Jose",
                               "state": "CA",
                               "country_code": "US",
                               "postal_code": "95131"
                             }
                           ],
                           "phones": [
                             {
                               "type": "WORK",
                               "country_code": "1",
                               "national_number": "4089671000",
                               "extension_number": "0"
                             },
                             {
                               "type": "BUSINESS",
                               "country_code": "1",
                               "national_number": "4089671000"
                             }
                           ],
                           "category": "1010",
                           "sub_category": "2114",
                           "date_business_established": "2001-01-17",
                           "date_of_registration": "2011-04-17",
                           "dispute_email": "disputes@gfmps.com",
                           "business_sales_details": {
                             "sales_venues": [
                               {
                                 "type": "ANOTHER_MARKET_PLACE",
                                 "description": "gfmps"
                               }
                             ],
                             "website": "'.PARTNER_DOMAIN.'"
                           },
                           "customer_service": {
                             "email": "support@gfmps.com",
                             "phone": {
                               "country_code": "1",
                               "national_number": "4089671000",
                               "extension_number": "0"
                             }
                           }
                         },
                         "account_status": "A",
                         "account_currency": "USD",
                         "financial_info": {
                           "bank_accounts": [
                             {
                               "transfer_type": "NORMAL",
                               "account_number": 1496187963828,
                               "account_type": "CHECKING",
                               "currency_code": "USD",
                               "identifiers": [
                                 {
                                   "type": "ROUTING_NUMBER_1",
                                   "value": "325272063"
                                 }
                               ],
                               "branch_location": {
                                 "city": "San Jose",
                                 "country_code": "US"
                               }
                             }
                           ]
                         },
                         "payment_receiving_preferences": {
                           "block_unconfirmed_us_address_payments": false,
                           "block_non_us_payments": false,
                           "block_echeck_payments": false,
                           "block_cross_currency_payments": false,
                           "block_send_money_payments": false,
                           "display_instructions_text_input": true,
                           "cc_soft_descriptor": "'.SELLER1_VAR.'",
                           "cc_soft_descriptor_extended": "'.SELLER1_NAME.'"
                         },
                         "account_relations": [
                           {
                             "type": "PARTNER"
                           }
                         ],
                         "account_permissions": [
                           {
                             "permissions": [
                               "EXPRESS_CHECKOUT",
                               "RECURRING_PAYMENT",
                               "EXTENDED_PRO_PROCESSING",
                               "EXCEPTION_PROCESSING",
                               "DISPUTE_RESOLUTION",
                               "SETTLEMENT_REPORTING",
                               "SHARED_REFUND"
                             ]
                           }
                         ],
                         "timezone": "America/Los_Angeles",
                         "partner_merchant_external_id": "'.SELLER1_VAR.'",
                         "loginable": false,
                         "partner_tax_reporting": true
                       }';


    //Set Risk Transaction Context Request Data
    $riskRequestData =
        '{
            "additional_data":[
                {
                    "key":"sender_account_id",
                    "value":"'.SELLER_1_EMAIL.'"
                },
                {
                    "key":"sender_first_name",
                    "value":"'.SELLER_1_EMAIL.'"
                },
                {
                    "key":"sender_last_name",
                    "value":"'.SELLER_1_EMAIL.'"
                },
                {
                    "key":"sender_create_date",
                    "value":"2016-08-29T03: 42: 34Z"
                },
                {
                    "key":"seller_account_id",
                    "value":"'.SELLER_1_EMAIL.'"
                },
                {
                    "key":"seller_create_date",
                    "value":"2016-08-29T03: 42: 34Z"
                },
                {
                    "key":"transaction_is_tangible",
                    "value":"TRUE"
                }
            ]
        }';

    $createOrderRequestData = '{
                                 "purchase_units": [
                                   {
                                     "reference_id": "'.SELLER1_NAME.'",
                                     "description": "Fashion goods from the Watch Shop",
                                     "custom": "'.PARTNER_CUSTOM.'",
                                     "invoice_number": "'.PARTNER_CUSTOM.'",
                                     "payment_descriptor": "'.PARTNER_NAME.'",
                                     "payment_linked_group": 1,
                                     "amount": {
                                       "currency": "'.CURRENCY_CODE.'",
                                       "details": {
                                         "shipping": "0.00",
                                         "subtotal": "100.00",
                                         "tax": "0.00"
                                       },
                                       "total": "100.00"
                                     },
                                     "payee": {
                                       "email": "'.SELLER_1_EMAIL.'"
                                     },
                                     "partner_fee_details": {
                                       "amount": {
                                         "currency": "'.CURRENCY_CODE.'",
                                         "value": "10.80"
                                       },
                                       "receiver": {
                                         "email": "'.PARTNER_EMAIL.'"
                                       }
                                     },
                                     "items": [
                                       {
                                         "name": "Studded Watch",
                                         "description": "",
                                         "currency": "USD",
                                         "price": "100.00",
                                         "quantity": "1",
                                         "sku": "sku01",
                                         "category": "PHYSICAL",
                               	       "supplementary_data": [],
                               	       "postback_data": [],
                               	       "item_option_selections": []
                                       }
                                     ],
                                     "shipping_address":
                                     {
                                       "recipient_name": "John Doe",
                                       "default_address": false,
                                       "preferred_address": false,
                                       "primary_address": false,
                                       "disable_for_transaction": false,
                                       "line1": "2211 N First Street",
                                       "line2": "Building 17",
                                       "city": "San Jose",
                                       "country_code": "US",
                                       "postal_code": "95131",
                                       "state": "CA",
                                       "phone": "(123) 456-7890"
                                   },
                                      "shipping_method": "United Postal Service"
                                   },
                                   {
                                     "reference_id": "{{pu2}}",
                                     "description": "PU2 description",
                                     "custom": "'.PARTNER_CUSTOM.'",
                                     "invoice_number": "'.PARTNER_CUSTOM.'",
                                     "payment_descriptor": "'.PARTNER_NAME.'",
                                     "amount": {
                                       "currency": "'.CURRENCY_CODE.'",
                                       "details": {
                                         "shipping": "0.00",
                                         "subtotal": "300.00",
                                         "tax": "0.00"
                                       },
                                       "total": "300.00"
                                     },
                                     "payee": {
                                       "email": "'.SELLER_2_EMAIL.'"
                                     },
                                     "partner_fee_details": {
                                       "amount": {
                                         "currency": "'.CURRENCY_CODE.'",
                                         "value": "23.80"
                                       },
                                       "receiver": {
                                         "email": "'.PARTNER_EMAIL.'"
                                       }
                                     },
                                     "items": [
                                       {
                                         "name": "DSLR Camera",
                                         "description": "",
                                         "currency": "USD",
                                         "price": "300.00",
                                         "quantity": "1",
                                         "sku": "sku02",
                                         "category": "PHYSICAL",
                               	       "supplementary_data": [],
                               	       "postback_data": [],
                               	       "item_option_selections": []
                                       }
                                     ],
                                     "shipping_address":
                                     {
                                       "recipient_name": "John Doe",
                                       "default_address": false,
                                       "preferred_address": false,
                                       "primary_address": false,
                                       "disable_for_transaction": false,
                                       "line1": "2211 N First Street",
                                       "line2": "Building 17",
                                       "city": "San Jose",
                                       "country_code": "US",
                                       "postal_code": "95131",
                                       "state": "CA",
                                       "phone": "(123) 456-7890"
                                   },
                                      "shipping_method": "United Postal Service"
                                   }
                                 ],
                                 "redirect_urls": {
                                   "return_url": "'.CHECKOUT_RETURN_URL.'",
                                   "cancel_url": "'.CHECKOUT_START_URL.'"
                                 }
                               }';
    //Pay for Order Request Data
    $payForOrderRequestData = '{
                      "disbursement_mode": "DELAYED"
                    }';

    //Disburse Request Data
    $disburseRequestData =
        '{
            "reference_id":"<capture-id>",
            "reference_type":"TRANSACTION_ID"
        }';

    //Refund Request Data
    $refundRequestData =
        '{
            "amount":{
                "currency":"<currency>",
                "details":{
                },
                "total":"<total>"
            },
            "invoice_number":"'.PARTNER_INVOICE.'",
            "custom":"'.PARTNER_CUSTOM.'"
        }';


?>

