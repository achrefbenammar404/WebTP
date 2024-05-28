# E-commerce Website

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/ecommerce.git
    cd ecommerce
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up the database:
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

4. Run the Symfony server:
    ```bash
    symfony serve
    ```

## Usage

- Open your browser and go to `http://localhost:8000`.

## Testing

- Run tests with:
    ```bash
    php bin/phpunit
    ```
