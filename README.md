# CRM API – Installation & Testing

## 🛠 Installation


```bash
git clone https://github.com/Lizwis/crm-api.git
cd crm-api

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate:fresh --seed

php artisan test

php artisan serve

```