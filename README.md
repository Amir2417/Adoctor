Immediate Older Version: 1.2.0
Current Version: 1.3.0

Feature Update:
1. Payment Gateway Added.
    * Paypal
    * Stripe
    * Flutterwave
    * SSLCommerz
    * Razorpay
    * Perfect Money
    * Coingate
    
2. Language Update.

1. To Run Project Please Run This Command On Your Terminal
    composer update && composer dumpautoload && php artisan migrate && php artisan passport:install --force
2. To Update Basic Settings Seeder Please Run This Command On Your Terminal
    php artisan db:seed --class=Database\\Seeders\\Update\\BasicSettingsSeeder
3. To Update Payment Gateway Seeder Please Run This Command On Your Terminal
    php artisan db:seed --class=Database\\Seeders\\Admin\\PaymentGatewaySeeder