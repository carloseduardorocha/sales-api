<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Sales API  

Sales API is a project designed to **manage the relationship between sellers and sales** within the company.  
It also features **daily and monthly sales report emails** sent to both sellers and the system administrator.

## 📄 Project Documentation  

- **[Installation Guide](https://github.com/carloseduardorocha/sales-api/wiki/Installation-Guide)** – Step-by-step guide to installing the project in your development environment.  
- **[Endpoints Documentation](https://documenter.getpostman.com/view/15465603/2sAYdZvEV2#1b0488ac-840e-48c4-a60d-216485d4d7cc)** – Detailed information on how to integrate and use the API.  

## 📨 Email Reports System

Sales API has **four scheduled email routines** to ensure consistent communication:

- **Daily Reports**
  - **Admin Report** – sent daily at `01:00`.
  - **Seller Report** – sent daily at `01:30`.
  
- **Monthly Reports**
  - **Admin Report** – sent on the 1st day of each month at `02:00`.
  - **Seller Report** – sent on the 1st day of each month at `02:30`.

> **Important:**  
> To enable the email system, it is **mandatory** to properly configure the email-related environment variables in your `.env` file.

## ⚙ Environment Configuration

### Admin User Credentials

When seeding the database, a default admin user will be created based on the following `.env` variables:

```env
TEST_USER_NAME="Test User"
TEST_USER_EMAIL="test@example.com"
TEST_USER_PASSWORD="MyPassword25!"
```

- These credentials will be used for the login into the system.
- The admin email configured here will also receive the sales report emails.
- **If you want to change the admin information, you must edit it now in the `.env` file before running the seeders.**

### Email Configuration

To properly send emails, configure the following environment variables:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Make sure to adjust these settings according to your email provider or mail server.

## ⚙ Technologies Used  

- [PHP 8.2](https://www.php.net/) – programming language <br/>
- [Laravel 12](https://laravel.com/docs/12.x) – web application PHP framework <br/>