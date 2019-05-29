## PayPal Commerce Platform Managed path

> **Important:** PayPal Commerce Platform for eCommerce Solution Providers and Marketplaces is a limited-release solution at this time. It is available to select partners for approved use cases. Two versions of the solution are available:
>
>New integrations: [version 2](https://developer.paypal.com/docs/partners/) (from February 2019)
>
>Existing integrations: [version 1](https://developer.paypal.com/docs/partners/v1/) (before February 2019)
>
>New customers should integrate version 2. For more information, reach out to your PayPal account manager.


>This code sample is not upgraded to use [version 2](https://developer.paypal.com/docs/partners/).


## Prerequisites

1. Update PayConfig.php with your  "Partner credentials", "Seller emails" and  "Seller Payer IDs". If you do not have the credentials, please reach out to your PayPal account manager.

2. Verify that all the files are in place by running  and passing the Unit tests (process shown below).

		wget https://phar.phpunit.de/phpunit-5.7.phar 
		(Download a version of PHPunit consisent with your php version)
		
		mv phpunit-5.7.phar /usr/local/bin/phpunit
		
		chmod a+x  /usr/local/bin/phpunit
		
		phpunit --version 
		
		phpunit Tests/unit_test.php


## Quick Start Demo Deployment Using XAMPP


1. Download PHP server.
Use a server such as XAMPP ([https://www.apachefriends.org/index.html]()) to be able to host the Demo code sample.

2. Browse to the ***htdocs*** directory of xampp. Unzip the downloaded demo code folder and place it in this ***htdocs*** directory.

3. Start the Apache server in XAMPP from the XAMPP control panel.

4. Open the website in the browser and access it as: [http://my_domain/php_code_folder_name/index.php]()
   Here, ***my_domain*** will be localhost if hosting on your own machine.
   The ***php_code_folder_name*** is the name of the folder under which the downloaded code resides.

5. Read further instructions when `index.php` in opened in a browser.

## How the code works


The starting point is `index.php`.

## License
Code released under [LICENSE](LICENSE.md)[]([]())
