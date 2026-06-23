# Список змін (Changelog)

Усі помітні зміни в цьому проєкті будуть відображатися в цьому файлі.

Формат базується на [Keep a Changelog](https://keepachangelog.com/uk/1.1.0/),
і цей проєкт дотримується [Семантичного версіонування](https://semver.org/lang/uk/).

## [Unreleased]

### Додано

-

### Виправлено

-

### Змінено

-

### Видалено

-

## [0.24.0] - 2026-06-23

### Додано

- `UserData` (DTO), `StoreUserRequest` та `UpdateUserRequest` для типізації та валідації даних при створенні та оновленні користувача.
- Екшени `CreateUserAction`, `UpdateUserAction` та `DeleteUserAction` для CRUD операцій з користувачем.
- `CategoryData` (DTO), `StoreCategoryRequest` та `UpdateCategoryRequest` для типізації та валідації даних при створенні та оновленні категорії.
- Методи в `CategoryRepository` для пошуку категорії за ID, батьківською категорією та отримання всіх записів.
- Зв'язок `belongsTo` (`parent()`) у моделі `Category` для доступу до батьківських категорій.
- Екшени `CreateCategoryAction`, `UpdateCategoryAction` та `DeleteCategoryAction` для CRUD операцій з категорією.
- Контролер `UserController`, `CategoryController`, нові маршрути та Blade-шаблони `tables/users/*`, `tables/categories/tables` для роботи з користувачами та категоріями.

## [0.23.0] - 2026-06-22

### Додано

- Передачу ID авторизованого користувача через глобальний хелпер `auth()->id()` в `UpdateProfileAction` всередині `ProfileController`.
- Метод `isAdmin` у моделі `User` для перевірки ролі користувача.
- Мідлвар `EnsureIsAdmin` для блокування доступу до адмінської частини, якщо роль користувача `user` (глобальна реєстрація в `bootstrap/app.php`).
- Методи для отримання ID та `Timestamps` проміжної таблиці в моделі `User` для зв'язку `wishlistItems`.
- Репозиторій `BrandRepository` для отримання брендів та пошуку бренду за ID.
- `BrandData` (DTO), `StoreBrandRequest` та `UpdateBrandRequest` для типізації та валідації даних при створенні та оновленні бренду.
- Сервіс `SlugService` для генерації унікального слагу на основі назви запису.
- Екшени `CreateBrandAction`, `UpdateBrandAction` та `DeleteBrandAction` для CRUD операцій з брендом.
- Контролер `BrandController`, нові маршрути, CSS стилі, JS скрипти, Blade-шаблони для адмінського профілю та Blade-шаблони `tables/brands/*` для роботи з брендами.

### Змінено

- Назву сервісу `AvatarService`, перейменовано на `FileService`.
- Сервіс `FileService`, адаптовано під роботу з будь-якими сутностями та оновлено всі залежні класи.

## [0.22.0] - 2026-06-17

### Додано

- Чекбокс `remember` в Blade-шаблоні `auth/login.blade.php` для функціоналу `Remember Me` при авторизації.
- Файл `0005-move-stock-deductions-to-payment-confirmation.md` (ADR) з поясненням, чому обрані саме такі рішення щодо віднімання товарних залишків.
- Файл `0006-custom-emulation-payment-system` (ADR) з поясненням, чому обрані саме такі рішення щодо фейкової емуляції платіжної системи.

## [0.21.0] - 2026-06-16

### Додано

- Поля `avatar_path`, `phone` та `birthday` в таблиці `users` - [Migration](database/migrations/2026_06_15_162416_add_columns_to_users_table.php).
- Директорію `public/storage/avatars` для локального збереження аватарів користувачів.
- Контролер `OrderHistoryController` та метод `getHistory` репозиторію `OrderRepository` для передачі даних про історію замовлень авторизованих користувачів до Blade-шаблону.
- `UpdateProfileData` (DTO) та `UpdateProfileRequest` для типізації та валідації даних при оновленні профілю.
- Екшен `UpdateProfileAction` для того, щоб користувач міг оновлювати свій профіль.
- Реквест `UpdateProfileRequest` для валідації даних при оновленні профілю користувача.
- Контролер `ProfileController`, нові маршрути, CSS стилі та Blade-шаблони `profile/*` для профілю користувача.
- `UpdatePasswordData` (DTO) та `UpdatePasswordRequest` для типізації та валідації даних при оновленні пароля.
- Екшен `UpdateProfileAction` для того, щоб користувач міг оновлювати свій пароль.
- Контролер `PasswordController` та нові маршрути.
- Blade-шаблон `checkout/checkout-fail.blade.php` який містить інформацію про невдалу оплату замовлення.
- Сервіс `FakePaymentGateWayService` який емулює оплату замовлення та генерує шанс на успіх або невдачу.
- `ConfirmPaymentData` (DTO) та `ConfirmPaymentRequest` для типізації та валідації даних при заповненні даних для оплати.
- Перевірку в методі `complete` у контролері `OrderController` з результатом, куди перенаправити користувача залежно від результату платежу.
- Обмеження кількості спроб оплати замовлення в `RateLimiterServiceProvider` та підключено до маршруту оплати замовлення.
- Сервіс `AvatarService` з бізнес-логікою створення, оновлення та видалення аватару користувача.
- Репозиторій `UserRepository` для пошуку користувача за його ID.
- Репозиторій `PaymentRepository` для пошуку платежу за його ID.

### Змінено

- Назву зв'язку в моделі `OrderItem`, перейменовано з `variant` на `productVariant`.
- Розташування списання кількості товару зі складу, переміщено з `CreateOrderAction` до `ConfirmPaymentAction` та обгорнуто логіку створення платежу в транзакцію.
- Поля `card_last4`, `gateway_transaction_id` та `payload`, тепер вони можуть бути `nullable` - [Migration](database/migrations/2026_06_16_102322_change_columns_in_payments_table.php).

### Видалено

- Префікс `auth` для маршрутів реєстрації та логіну.

## [0.20.0] - 2026-06-15

### Додано

- Зв'язок "багато до багатьох" (`belongsToMany`) між моделями `User` та `ProductVariant`.
- Екшен `ToggleWishlistItemAction` для уніфікованого додавання та видалення товару зі списку бажаного.
- Сервіс `WishlistService` для розрахунку загальної кількості елементів у списку бажаного користувача.
- Глобальну передачу кількості елементів списку бажаного через `ViewServiceProvider` до головного Blade-шаблону `layouts/app.blade.php`.
- Відображення наявності товару в списку бажань в Blade-шаблоні `category.blade.php`.
- Контролер `WishlistController`, нові маршрути та Blade-шаблон `wishlist.blade.php` для переглдяну товарів списку бажаного.
- Перевірку авторизації користувача та відображення статусу товару (у списку / не в списку) всередині шаблону `category.blade.php`.
- JavaScript файл (`wishlist.js`) для динамічного оновлення лічильника списку бажаного та візуального перемикання стану елементів без перезавантаження сторінки.

## [0.19.1] - 2026-06-13

### Додано

- Ключове слово `final` до всіх класів контролерів для запобігання успадкування.

### Змінено

- Виклик методу `findBySlug` у методі `findRelatedBySlug` репозиторію `ProductRepository` на пошук товару без зайвих обчислень.
- Директорію `app/DTO` перейменовано на `app/Data`.
- Файли в `Actions`, згруповано за окремими директоріями відповідно до їхніх сутностей.
- Назву метода `toDTO()` перейменовано на `getData()` у класах `FormRequests`. 

### Видалено

- Базовий абстрактиний контролер `Controller`.
- `HTML` код з JavaScript файлу (`cart.js`).

## [0.19.0] - 2026-06-11

### Додано

- Екшен `CreateReviewAction` для ізольованої логіки створення відгуків про товар.
- `CreateReviewData` (DTO) та `StoreReviewRequest` для типізації та валідації даних при створенні відгуку.
- Репозиторій `ReviewRepository` для вибірки відгуків про товар.
- Контролер `ReviewController`, нові маршрути та Blade-шаблон `review.blade.php` з формою для залишення відгуку.
- Ін'єктовано `ReviewRepository` до `ProductController` для передачі списку відгуків на сторінку товару.
- Метод `getRatings` у `ProductRepository` для отримання рейтингів конкретного товару.
- Локальний `Scope` у моделі `Product` для фільтрації лише активних товарів у каталозі.

## [0.18.0] - 2026-06-10

### Додано

- Обробку параметра сортування товарів за ціною в `CategoryController` та його передачу до `ProductSearchFilterData` (DTO).
- Властивість `sortByPrice` та гетер в `ProductSearchFilterData` (DTO).
- Логіку сортування товарів за зростанням або спаданням ціни всередині `ProductRepository`.

## [0.17.0] - 2026-06-09

### Додано

- `ProductSearchFilterData` (DTO) для передачі типізованих даних у систему пошуку та фільтрації.
- Методи в `ProductRepository` для отримання доступних брендів, кольорів та розмірів.
- Пакет `propaganistas/laravel-phone` для зручної валідації телефонних номерів у `StoreCheckoutRequest`.
- Кастомний `config` - `pagination` для управління лімітами виведення товарів на сторінку.
- Відображення доступних фільтрів в Blade-шаблоні `category.blade.php`.
- Встановлення базового статусу замовлення під час його створення в `CreateOrderAction`.
- Файл `0004-custom-search-and-filter-system.md` (ADR) з поясненням чому обрані саме такі рішення щодо нової системи пошуку товарів та фільтрів.

### Змінено

- Файл `0003-laravel-scout-search-system.md`, оновлено статус на `Замінено`, з поясненням чому дане рішення було замінено на інше.

### Видалено

- Систему `Laravel Scout` та його пошукові методи з моделі `Product`.

## [0.16.0] - 2026-06-06

### Додано

- Blade-шаблон `checkout/checkout-success.blade.php` який містить інформацію про замовлення.
- Контролер `OrderController` для управління станом та відображення інформації про замовлення.
- Мідлвар `EnsureCartIsNotEmpty` для блокування доступу до сторінки оформлення замовлення, якщо кошик порожній (глобальна реєстрація в `bootstrap/app.php`).
- Мідлвар `EnsureOwnsOrder` для захисту сторінки замовлення від переглядну іншими користувачами за ID (глобальна реєстрація в `bootstrap/app.php`).
- Збереження унікального ідентифікатора замовлення в сесії всередині `CheckoutController` з метою його перевірки в мідлварі `EnsureOwnsOrder`.
- Метод `resolvePrice` в `CartService` для автоматичного визначення ціни товару з урахуванням можливої знижки.

### Змінено

- Найменування методів у контролерах: `ForgotPasswordController` та `ResetPasswordController` для кращої відповідності конвенціям Laravel.
- Переміщено методи: `show`, `complete` та `success` з `CheckoutController` до `OrderController`.
- Найменування маршрутів для системи замовлень у `routes/web.php`.

## [0.15.0] - 2026-06-05

### Додано

- Повернення розрахованої вартості позиції кошика з `AddCartItemAction` через `CartController` для динамічного оновлення інтерфейсу через JavaScript (`cart.js`).
- Файл `docs/database/orders.md` з детальним описом сутностей та логіки домену замовлення.
- Сценарій використання `docs/use-cases/orders.md` для системи оформлення замовлення.
- Систему `Laravel Scout` (із використанням драйвера `Database Engine`).
- Систему пошуку та пагінації товарів в `ProductRepository` та `CategoryController`.
- Метод `toSearchableArray` у моделі `Product` для точного визначення полів по яким буде відбуватись пошук.
- Файл `0003-laravel-scout-search-system.md` (ADR) з поясненням чому обрані саме такі рішення щодо системи пошуку товарів.

### Змінено

- Лоігку очищення кошика перенесено з процесу створення замовлення `CreateOrderAction` до етапу успішного підтвердження `ConfirmPaymentAction`.
- Оптимізовано вибірку в `category.blade.php`: реалізовано звернення від моделі `Category` до `Product` замість транзитного зв'язку через `ProductVariant`.

### Видалено

- Невикористовуваний Blade-шаблон `components/cart-item.blade.php`.

## [0.14.0] - 2026-06-03

### Додано

- Екшен `CreateOrderAction` для безпечного створення замовлення з використанням транзакцій БД.
- Екшен `ConfirmPaymentAction` для оновлення статусу замовлення після успішного підтвердження.
- DTO `CreateOrderData` та `StoreCheckoutRequest` для типізації та валідації даних при створенні замовлення.
- Контролер `CheckoutController` для реалізації системи замовлень.
- Сервіс `OrderService` для розрахунку фінальної суми замовлення та `OrderRepository` для пошуку замовлень за їх ID.
- Метод `calculateItemTotal` в `CartService` для розрахунку елемента кошика.
- Глобальну передачу загальної суми кошика через `ViewServiceProvider` до головного шаблону `layouts/app.blade.php`.
- Нові маршрути в `routes/web.php` для `CheckoutController`.
- Перевірку наявності акційної ціни на товар у Blade-шаблонах.
- Форми для створення замовлення в Blade-шаблонах `checkout`.
- Додаткові PHPDoc-коментарі властивостей у моделях.

### Змінено

- Переміщено розрахунок вартості елемнта кошика з `UpdateCartItemAction` до `CartService`.

### Видалено

- Невикористовуваний Blade-шаблон `checkout/checkout-shipping.blade.php`.

## [0.13.0] - 2026-06-01

### Додано

- Файл `docs/database/carts.md` з детальним описом сутностей та логіки домену кошика.
- Колонку `product_name` у таблиці `order_items` для збереження історичної назви товару на момент оформлення замовлення - [Migration](database/migrations/2026_06_01_173603_add_product_name_to_order_items_table.php).
- Колонку `last_name` (прізвище) в таблиці `orders` - [Migration](database/migrations/2026_06_01_181246_add_last_name_to_orders_table.php).  

### Змінено

- Згруповано директорію сервісів: класи для роботи з кошиком згруповано в `app/Services/Cart` та оновлено всі залежні класи.
- Назву колонки `name` на `first_name` (ім'я) у таблиці `orders` для роздільного збереження імені та прізвища користувача - [Migration](database/migrations/2026_06_01_181225_rename_name_to_first_name_in_orders_table.php).

## [0.12.3] - 2026-05-31

### Додано

- Файл `docs/database/products.md` з детальним описом сутностей домену продуктів.
- Зв'язок `hasMany` (`products()`) у моделі `Category` для доступу до товарів категорії.

### Видалено

- Невикористовувані моделі `ProductOption` та `WishlistItem` для `pivot` таблиць, тому що вони не мають складної логіки, також оновлено всі залежні класи.
- Поля `created_at` та `updated_at` з проміжної таблиці `product_options` - [Migration](database/migrations/2026_05_30_214928_drop_timestamps_from_product_options_table.php).

## [0.12.2] - 2026-05-29

### Додано

- Директорію `docs/database` для документації структури та зв'язків бази даних.
- Файл `users.md` з детальним описом сутностей домену користувачів (таблиці `users` та `wishlist_items`).

### Змінено

- Розташування моделей `Option` та `OptionValue`, переміщено з директорії `app/Models/Option` до `app/Models/Product`, оновлено їх простори імен та імпорти по проєкту.

## [0.12.1] - 2026-05-28

### Додано

- Директорію `docs/adr` для фіксації архітектурних рішень (Architectural Decision Records).
- Файли `0001-cart-system-architecture.md` та `0002-custom-reset-password.md` (ADR) з поясненням чому обрані саме такі рішення щодо кошика та системи скидання пароля.

## [0.12.0] - 2026-05-27

### Додано

- `ForgotPasswordRequest` та `ResetPasswordRequest` для валідації вхідних даних.
- `ForgotPasswordController` та `ResetPasswordController` для системи скидання пароля.
- Підтвердження пароля (`password_confirmation`) під час реєстрації в `RegisterRequest`.
- Нові маршрути для `ForgotPasswordController` та `ResetPasswordController`.
- Blade-шаблон `reset-password` який містить форму відновлення пароля.
- Кастомний виняток `ProductVariantOutOfStockException` для обробки випадків, коли товару немає в наявності.
- Сценарій використання `docs/use-cases/reset-password.md` для системи скидання пароля.
- Директорію `docs/assets` для збереження медіафайлів технічної документації проєкту.
- Директорію `docs/architecture` та файл `concepts.md` для опису базових архітектурних концепцій.

### Змінено

- Назву `RegisterData` перейменовано на `CreateUserData` та оновлено всі залежні класи.
- Оптимізовно логіку перевірки залишків товару на складі всередині `UpdateCartItemAction`.

## [0.11.1] - 2026-05-25

### Додано

- Директорію `docs/` для ведення технічної документації проєкту та сценарій використання (use-case) `cart.md` для кошика користувача.

## [0.11.0] - 2026-05-24

### Додано

- Екшени `AddCartItem`, `UpdateCartItem` та `RemoveCartItem` для ізольованої логіки управління кошиком.
- Екшени `CreateUser` для обробки процесу реєстрації користувачів.
- PHPDoc-коментарі до властивостей моделі для кращого розуміння контексту інших розробників.

### Змінено

- Структуровано розташування екшенів: класи для роботи з кошиком згруповано в `app/Actions/Cart`.
- Впроваджено пряме використання екшенів у `CartController` та `RegisterController`.

### Виправлено

- Зв'язок в моделі `User`: виправлено помилкову логіку з `hasMany` (на модель `CartItem`) на коректне відношення `hasOne` (на модель `Cart`).

### Видалено

- Репозиторії `ProductVariantRepository` та `RegisterRepository` через перехід на екшени.
- Методи `addItem`, `updateQuantity` та `removeItem` з сервісу `CartService`.

## [0.10.0] - 2026-05-24

### Додано

- Методи для зручної перевірки статусів в `OrderStatus` та `PaymentStatus`.

### Змінено

- Шари класів `Services`, `Actions` та `DTO` на модифікатор `readonly` для забезпечення незмінності даних.
- Змінено тип колонок статусів на `string` в таблицях: `orders`, `payments`.
- Змінено тип колонок цін та сум на `integer` в таблицях: `order_items`, `orders`, `payments` для збереження грошей у копійках.
- Тип колонки `role` на `string` в таблиці `users`.
- Директорію `app/Models`: моделі згруповано за контекстними папками, оновлено їх простори імен та імпорти по всьому проєкту.
- У таблиці `wishlist_items` зовнішній ключ з `product_id` на `product_variant_id` для прив'язки до конкретного варіанта товару.

## [0.9.0] - 2026-05-22

### Додано

- Blade-шаблон `cart-item` для відображення картки товару в кошика.
- Відображення опцій товару на сторінці кошика.
- Масив `options` з ключами: (`name` та `value`) до структури `CartItemResource`.
- Обробку та відображення опцій товару при додаванні в JavaScript (`cart.js`).

### Змінено

- Назву метода `findItem` перейменовано на `findItemByProductVariantId` в моделі `Cart` та оновлено всі залежні класи.
- Звернення до зв'язку колекції в методі `findItemByProductVariantId` моделі `Cart`.
- У репозиторіях впроваджено жадібне завантаження (Eager Loading) зв'язків для оптимізації запитів до БД та вирішення проблеми N+1.
- Логіку підрахунку кількості товарів в кошика в методі `getItemsCount` сервісу `CartService`.
- Використання `MoneyFormatterService` перенесено з шару `CartService` до `CartController`.

### Видалено

- Відображення опцій товару на сторінці категорії.

## [0.8.0] - 2026-05-20

### Додано

- Ідентифікатор варіанта продукту як query-параметр в URL (підготовка до динамічного відображення опцій).

### Змінено

- Уніфіковано назви методів у репозиторіях для кращої відповідності контексту та оновлено всі залежні класи.
- Спрощено логіку додавання товару в кошик у методі `addItem` сервісу `CartService`.
- Замінено статичні назви категорій на динамічне виведення з бази даних в Blade-шаблоні головної сторінки `index`.

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

## [0.2.0] - 2026-05-08

### Додано

- Бібліотеку `moneyphp/money` для кращої роботи з цінами.

### Змінено

- URL для пошуку продукту за `slug` тепер без `slug` категорії.
- Формат зберігання ціни, з цілих чисел до копійок.

## [0.1.0] - 2026-05-04

### Додано

- `OptionSeeder` для заповнення БД опціями.
- Встановлено значення за замовчуванням для status = pending у моделях замовлень.
- Типізацію повернення до міграційних методів.

### Змінено

- `ProductFactory` з генерацією варіантів продукту через декартовий добуток використовуючи опції.
- `DatabaseSeeder` з підключенням нового `Seeder` та `Factory`.
