# Single Vendor Ecommerce Web Application

This is a single-vendor e-commerce web application developed using Laravel 10. The application was created as part of the Software Engineering Degree Program at the Java Institute for Advanced Technology.

Its features include allowing users to browse products, make purchases, and manage their orders while processing payments. On the vendor side, the application enables the vendor to manage products, orders, payments, customers, shipping, returns, reports, and staff, including the ability to invite staff members to access the backend.This is a single-vendor e-commerce web application developed using Laravel 10.

## Built With

- Laravel 10
- MySQL 8 (SQLite for development)
- Tailwind CSS
- Stripe (Payment Gateway)
- Gmail (Transactional Email)

## Installation

1. Clone the repository
   ```sh
   git clone git@bitbucket.org:skdishansachin/single-vendor-ecommerce.git
   ```

2. Install Composer dependencies
    ```sh
    composer install
    ```

3. Install NPM dependencies
    ```sh
    npm install
    ```

4. Create a copy of your .env file
    ```sh
    cp .env.example .env
    ```

5. Generate an app encryption key
    ```sh
    php artisan key:generate
    ```

6. Run the database migrations
    ```sh
    php artisan migrate
    ```

7. Create a symbolic link
    ```sh
    php artisan storage:link
    ```

8. Create an admin user (checkout the `routes/console.php` command)
    ```
    php artisan user:create
    ```

9. Start the development server
    ```sh
    php artisan serve
    ```

## Testing

1. Run the test
    ```sh
    php artisan test
    ```

Tests are located in the `tests/Feature` directory and using PHPUnit for testing.

## Routes

You can find the list of routes in the `routes/web.php` and `routes/auth.php` files. You also can run `artisan route:list`. Here are the list of routes:

| Method    | Path                                    | Description                                      |
|-----------|-----------------------------------------|--------------------------------------------------|
| GET       | /                                       | Home page                                        |
| GET       | cart/                                   | View the shopping cart                           |
| POST      | cart/                                   | Add item to the cart                             |
| PUT       | cart/                                   | Update cart item                                 |
| DELETE    | cart/product/                           | Remove product from cart                         |
| POST      | checkout/                               | Handle the checkout process                      |
| GET       | checkout/cancel/                        | Cancel the checkout                              |
| GET       | checkout/error/                         | Checkout error page                              |
| GET       | checkout/success/                       | Checkout success page                            |
| GET       | collections/                            | View all collections                             |
| GET       | collections/{collection}/               | View specific collection                         |
| GET       | dashboard/                              | Dashboard overview                               |
| GET       | dashboard/collections/                  | View all collections (admin)                     |
| POST      | dashboard/collections/                  | Create a new collection                          |
| GET       | dashboard/collections/create/           | Create a new collection (form)                   |
| GET       | dashboard/collections/{collection}/     | View specific collection (admin)                 |
| PUT|PATCH  | dashboard/collections/{collection}/     | Update collection details                        |
| DELETE    | dashboard/collections/{collection}/     | Delete a collection                              |
| GET       | dashboard/forgot-password/              | Forgot password form                             |
| GET       | dashboard/invitations/                  | View invitations                                 |
| POST      | dashboard/invitations/                  | Create new invitation                            |
| GET       | dashboard/invitations/create/           | Create new invitation form                       |
| GET       | dashboard/invitations/{invitation}/     | View specific invitation                         |
| PUT       | dashboard/invitations/{invitation}/cancel | Cancel invitation                               |
| PUT       | dashboard/invitations/{invitation}/resend | Resend invitation                               |
| GET       | dashboard/login/                        | Admin login page                                 |
| POST      | dashboard/login/                        | Admin login submit                               |
| POST      | dashboard/logout/                       | Admin logout                                     |
| GET       | dashboard/notifications/                | View notifications                               |
| POST      | dashboard/order/{order}/refund/         | Refund an order                                  |
| GET       | dashboard/orders/                       | View all orders (admin)                          |
| GET       | dashboard/orders/{order}/               | View specific order (admin)                      |
| PUT       | dashboard/orders/{order}/               | Update order (admin)                             |
| GET       | dashboard/products/                     | View all products                                |
| POST      | dashboard/products/                     | Add a new product                                |
| GET       | dashboard/products/create/              | Create new product form                          |
| GET       | dashboard/products/{product}/           | View specific product                            |
| PUT|PATCH  | dashboard/products/{product}/           | Update product details                           |
| DELETE    | dashboard/products/{product}/           | Delete product                                   |
| GET       | dashboard/products/{product}/edit/      | Edit product details                             |
| GET       | dashboard/profile/                      | Edit profile details                             |
| PATCH     | dashboard/profile/                      | Update profile                                   |
| POST      | dashboard/register/                     | Register new user                                |
| GET       | dashboard/register/{token}/             | Register with token                              |
| GET       | dashboard/shipping/                     | View all shipping methods                        |
| POST      | dashboard/shipping/                     | Add new shipping method                          |
| GET       | dashboard/shipping/create/              | Create new shipping method form                  |
| PUT       | dashboard/shipping/{shipping}/          | Update shipping method                           |
| GET       | dashboard/shipping/{shipping}/edit/     | Edit shipping method                             |
| GET       | dashboard/users/                        | View all users (admin)                           |
| GET       | dashboard/users/{user}/                 | View specific user                               |
| PUT       | dashboard/users/{user}/                 | Update user details                              |
| GET       | forgot-password/                        | Forgot password form                             |
| POST      | forgot-password/                        | Send password reset email                        |
| GET       | login/                                  | Login page                                       |
| POST      | login/                                  | Login submit                                     |
| POST      | logout/                                 | Logout                                           |
| GET       | orders/                                 | View user orders                                 |
| PUT       | password/                               | Update password                                  |
| GET       | products/{product}/                     | View product details                             |
| GET       | profile/                                | Edit user profile                                |
| PATCH     | profile/                                | Update user profile                              |
| DELETE    | profile/                                | Delete user profile                              |
| GET       | register/                               | Registration page                                |
| POST      | register/                               | Register new user                                |
| POST      | reset-password/                         | Reset password                                   |
| GET       | reset-password/{token}/                 | Reset password form with token                   |
| GET       | search/                                 | Search products                                  |
| POST      | stripe/webhook/                         | Handle Stripe webhook                            |
