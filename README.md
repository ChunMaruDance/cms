# CMS система


## Вступ
Проект передбачає створення інтернет-магазину аксесуарів,
який дозволить користувачам здійснювати онлайн-покупки,
переглядати товари та їхні деталі, додавати їх до кошика,
оформляти замовлення, а адміністраторам – ефективно керувати товарами, замовленнями та контентом сайту.

## Проектування системи

Система складається з кількох модулів, що забезпечують її гнучкість і можливість легкого розширення. Основні компоненти системи включають:

- Core: Ядро системи для ініціалізації всіх залежностей, таких як база даних, шаблони, розсилки та сесії.
- Template: Клас для роботи з шаблонами сторінок.
- Config: Клас для управління конфігураціями бази даних та системи розсилок.
- Controller: Клас для управління контролерами, що містить базові методи, такі як render та redirect.
- DB: Клас для виконання CRUD операцій з базою даних.
- Model: Клас для управління моделями даних.
- Router: Клас для направлення запитів на відповідні контролери та методи.

## Реалізація (кодинг)

Клієнтська частина:

Розроблено інтерфейс користувача з використанням HTML, CSS та JavaScript. Реалізовано функції для взаємодії з сервером за допомогою fetch-запитів(нище наведені деякі з них):
- toggleFeature() – встановлення видимості елементів.
- updateOrderStatus() – оновлення статусу замовлення.
- addToBasket() – додавання товарів у кошик.
- removeFromBasket() – видалення товарів із кошика.

Серверна частина:

Реалізовано основні контролери та функції для обробки запитів:

- UsersController: Робота з користувачами (реєстрація, авторизація, управління профілем).
- ProductsController: Управління товарами (перегляд, пошук, додавання в кошик).
- OrdersController: Обробка замовлень (створення, перегляд, оновлення статусу).
- ReviewsController: Управління відгуками користувачів.
- MailingController: Робота з електронною поштою (розсилка повідомлень).

Костилі і велосипеди наше все
