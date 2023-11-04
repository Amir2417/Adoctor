Immediate Older Version: 1.0.0
Current Version: 1.1.0

Feature Update:
1. Language directory added.
2. Support Ticket message send without reload the page.
3. tawk-to extention update

1. To Run Project Please Run This Command On Your Terminal
    composer update && composer dumpautoload && php artisan migrate
2. To Update Language Seeder Please Run This Command On Your Terminal
    php artisan db:seed --class=Database\\Seeders\\Admin\\LanguageSeeder
3. To Update SiteSection Seeder Please Run This Command On Your Terminal
    php artisan db:seed --class=Database\\Seeders\\Admin\\SiteSectionsSeeder
4. To Update Basic Settings Seeder Please Run This Command On Your Terminal
    php artisan db:seed --class=Database\\Seeders\\Admin\\BasicSettingsSeeder