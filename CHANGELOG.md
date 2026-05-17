# Список змін (Changelog)

Усі помітні зміни в цьому проекті будуть відображатися в цьому файлі.

Формат базується на [Keep a Changelog](https://keepachangelog.com/uk/1.1.0/),
і цей проект дотримується [Семантичного версіонування](https://semver.org/lang/uk/).

## [Unreleased]

### Додано
-

### Виправлено
-

### Змінено
-

### Видалено
-

## [0.1.0] - 2026-05-04

### Додано
- `OptionSeeder` для заповнення БД опціями.
- Встановлено значення за замовчуванням для status = pending у моделях замовлень.
- Типізацію повернення до міграційних методів.

### Змінено
- `ProductFactory` з генерацією варіантів продукту через декартовий добуток використовуючи опції.
- `DatabaseSeeder` з підключенням нового `Seeder` та `Factory`.

## [0.2.0] - 2026-05-08

### Додано
- Бібліотеку `moneyphp/money` для кращої роботи з цінами.

### Змінено
- URL для пошуку продукту за `slug` тепер без `slug` категорії.
- Формат зберігання ціни, з цілих чисел до копійок.

## [0.3.0] - 2026-05-09

### Додано
- Репозиторії `ProductRepository` та `CartRepository` для абстракції роботи з БД.
- `MoneyFormatterService` для централізованого форматування грошових значень.
- Метод розрахунку загальної вартості кошика в `CartService`.

### Змінено
- Формат ключів у `JSON`-відповідях `CartController` (перехід на camelCase).
- Рефакторинг логіки кошика з використанням сервісів.

### Виправлено
- Помилки в роботі методів додавання, змінення кількості та видалення товарів кошика.

## [0.4.0] - 2026-05-13

### Додано
- `Enums` такі як: `OrderStatus` та `PaymentStatus`.
- `CartRepository` який знаходить існуючий кошик або створює новий.
- `CurrentCartService` який використовує `CartRepository` для знаходження поточного кошика користувача по `session_id` або `user_id`.
- Метод `calculateCartItemTotal` для підрахунку кількості товарів у кошику.
- Ресурс `CartItemResource` який повертає дані про товар в кошику.
- Завантаження змінної про поточний кошик в загальний Blade-шаблон через `AppServiceProvider`.

### Змінено
- Назву міграції яка змінює тип ціни та знижки з `decimal` до `integer` в таблиці `product_variants`.
- Тип колонки `status` з `enum` до `string` в таблицях `orders` та `payments`.
- Назву класу `CartRepository` перейменовано на `ProductVariantRepository`.
- `CartService` який більше не працює через глобальну сесію а використовує `Repositories`, `Services` та `relationships`.
- Доступ до властивостей товару кошика в Blade-шаблонах.

### Видалено
- Колонку `price` з таблиці `cart_items`.

## [0.5.0] - 2026-05-14

### Додано
- Blade-шаблон `form-errors` для показу помилок форм в Blade-шаблонах.
- Неймінг полів в Blade-шаблонах для реєстрації та логіну.
- `RegisterRequest` та `LoginRequest` для валідації полів форм реєстрації та логіну.
- `RegisterController` та `LoginController` для автентифікації користувачів.
- `RateLimiterServiceProvider` для обмеження кількості спроб логіну.
- Кастомний `config` - `rate_limiter` щоб не прописувати значення в `RateLimiterServiceProvider` напряму.
- Нові маршрути для реєстрації, логіну, виходу з акаунта.
- `CategoryRepository` замість прямої роботи з моделлю в `CategoryController`.
- `ViewServiceProvider` для передачі спільних даних у Blade-шаблони.

### Змінено
- Стиль запису умови `with()` в `CartRepository`.
- Назви методів в `CartService`: `calculateCartTotal` перейменовано на `calculateTotal` а `calculateCartItemTotal` перейменовано на `getItemsCount`.
- Структуру поля `price` в `CartItemResource` з такими атрибутами як: `amount`, `formatted` та `currency`.
- `AppServiceProvider` - логіку передачі даних у Blade-шаблони перенесено до `ViewServiceProvider`.

## [0.6.0] - 2026-05-17

### Додано
- Прив'язку слухача `MergeGuestCart` до події `Login` в `AppServiceProvider`.
- Методи: `findCartByUserId` та `findCartBySessionId` в `CartRepository`.
- `MergeGuestCartAction` для обробки сценаріїв об'єднання гостьового кошика та кошика користувача.
- Слухач `MergeGuestCart`, який викликає `MergeGuestCartAction` під час автентифікації.
- Кастомні повідомлення помилки валідації для `RegisterRequest` та `LoginRequest`.
- Репозиторій `RegisterRepository` для логіки створення нового користувача в базі даних.

### Змінено
- У `CartController` замінено ін'єкцію `CartRepository` на `CurrentCartService`.
- Місце використання завантаження зв'язків через `load()` у методі `addItem` сервісу `CartService`.
- Логіку створення користувача перенесено з `RegisterController` до `RegisterRepository`.

### Виправлено
- Обмежено маршрути для `CartController` через `except()`, прибравши ті, що не використовуються.
- `ProductFactory` тепер генерує товари лише для підкатегорій (де колонка `parent_id` не є `null`).

### Видалено
- Виклик `UserFactory` в `DatabaseSeeder`.

## [0.7.0] - 2026-05-17

### Додано
- Бібліотеку `itsgoingd/clockwork` для моніторингу запитів до бази даних.
- Клас `RegisterData` (DTO) для безпечної та типізованої передачі даних для створення користувача. 
- Метод `toDTO()` у `RegisterRequest` для трансформації провалідованих даних запиту в об'єкт `RegisterData`.

### Змінено
- У `RegisterRepository` тепер приймає аргумент у вигляді об'єкту `RegisterData` замість звичайного масиву.
- У `RegisterController` змінено виклик `validated()` на `toDTO()`.

### Виправлено
- Помилку форматування ціни товару в Blade-шаблоні кошика (`cart`).
