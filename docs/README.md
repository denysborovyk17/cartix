# Документація проєкту Cartix

Ласкаво просимо до технічної документації системи. Тут зібрані всі ключові архітектурні рішення та опис бізнес-логіки.

## Структура директорії

[docs/](../docs)  
├── [ADR/](adr)  
│   ├── [0001: Архітектура кошика](adr/0001-cart-system-architecture.md)  
│   ├── [0002: Скидання пароля](adr/0002-custom-reset-password.md)  
│   ├── [0003: Пошук Laravel Scout](adr/0003-laravel-scout-search-system.md)  
│   └── [0004: Пошук та фільтрація](adr/0004-custom-search-and-filter-system.md)  
│   └── [0005: Списання товару зі складу](adr/0005-move-stock-deductions-to-payment-confirmation.md)  
│   └── [0006: Емуляція платіжної системи](adr/0006-custom-emulation-payment-system.md)  
├── [Architecture/](architecture)  
│   └── [Concepts](architecture/concepts.md)  
├── [Assets/](assets)  
│   └── [Request Flow](assets/request-flow.png)  
├── [Database/](database)  
│   ├── [Carts](database/carts.md)  
│   ├── [Orders](database/orders.md)  
│   ├── [Products](database/products.md)  
│   └── [Users](database/users.md)  
├── [Use Cases/](use-cases)  
│   ├── [Cart](use-cases/cart.md)  
│   ├── [Order](use-cases/order.md)  
│   └── [Reset Password](use-cases/reset-password.md)  
└── [README](README.md)
