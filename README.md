# Magento 2 Backend Module

# Installation Instruction

<b>Manual Installation</b>

- Copy the content of the repo to the <b>app/code/LoopDeveloper/MiniTracker</b>
- Run command: <b>php bin/magento setup:upgrade</b>
- Run command: <b>php bin/magento setup:static-content:deploy</b>
- Now flush cache: <b>php bin/magento cache:flush</b>


<b>Steps to check functionality</b>

- Add any product to cart
- It will get response from post request like tracking code & message and will add it database custom table
- You can check entries in admin grid as well
- Also you can check data records using REST API with url <b>Website_Url/rest/V1/tracking</b>