# Yii2 Docker Starter

📦 Готовая сборка Yii2-приложения с использованием Docker:

- Nginx
- PHP 8.2 + FPM + GD + Xdebug + Composer
- PostgreSQL
- Настроен Xdebug для PHPStorm
- Поддержка `.env` и автоматическое подключение к БД

---

## 📁 Структура проекта
```.
├── docker/
│ ├── nginx/
│ │ └── default.conf
│ ├── php/
│ │ ├── Dockerfile
│ │ └── php.ini
├── src/ # Исходный код приложения Yii2
├── .env # Переменные окружения
├── docker-compose.yml
└── README.md
```

---

## ⚙️ Переменные `.env`

```env
COMPOSE_PROJECT_NAME=app
APP_PORT=80
XDEBUG_MODE=debug

DB_HOST=db
DB_NAME=yii2db
DB_USER=yii2user
DB_PASSWORD=secret
```

---
## 🚀 Запуск
- docker-compose up -d --build
- http://localhost