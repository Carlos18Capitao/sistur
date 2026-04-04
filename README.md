# Sistur Angola 🇦🇴

Plataforma profissional de turismo em Angola, construída com Laravel 11. Descubra tours incríveis em Luanda, Benguela, Huíla, Malanje, Namibe e muito mais.

---

## Funcionalidades

### Área Pública
- **Página inicial** com tours em destaque e destinos populares
- **Catálogo de tours** com filtros por cidade, categoria, preço e ordenação
- **Página de tour** com galeria, detalhe, reserva integrada e avaliações

### Área do Utilizador (autenticado)
- **Reservas** — criar, visualizar e cancelar reservas
- **Avaliações** — avaliar tours após conclusão de reserva
- **Perfil** — editar dados pessoais e palavra-passe

### Painel de Administração
- **Dashboard** com estatísticas (tours, reservas, receita, avaliações pendentes)
- **Tours** — CRUD completo com upload de imagem, arrays dinâmicos (destaques, inclui, exclui)
- **Reservas** — listagem com filtros, confirmação e cancelamento
- **Avaliações** — moderação (aprovar/rejeitar)

---

## Tecnologias

| Componente     | Tecnologia                                  |
|----------------|---------------------------------------------|
| Backend        | Laravel 11 / PHP 8.3                        |
| Base de dados  | MySQL (produção) / SQLite in-memory (testes)|
| Frontend       | Blade + Tailwind CSS CDN + Alpine.js CDN    |
| Ícones         | Font Awesome 6 CDN                          |
| Autenticação   | Laravel Breeze (Blade)                      |
| Testes         | PHPUnit 46 testes (Feature + Unit)          |

---

## Arquitectura

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # DashboardController, TourController, BookingController, ReviewController
│   │   ├── Auth/           # Gerado pelo Breeze
│   │   ├── BookingController.php
│   │   ├── HomeController.php
│   │   ├── ReviewController.php
│   │   └── TourController.php
│   ├── Middleware/
│   │   └── AdminMiddleware.php
│   └── Requests/           # StoreBookingRequest, StoreTourRequest, StoreReviewRequest, ...
├── Models/
│   ├── Booking.php         # Auto-gera referência SIS-XXXXXXXX
│   ├── Review.php
│   ├── Tour.php            # Auto-gera slug, scopes, accessor preço formatado
│   └── User.php            # isAdmin(), relações bookings/reviews
├── Providers/
│   └── RepositoryServiceProvider.php
├── Repositories/
│   ├── Contracts/          # TourRepositoryInterface, BookingRepositoryInterface
│   └── Eloquent/           # TourRepository, BookingRepository
└── Services/
    ├── BookingService.php  # createBooking, cancelBooking, confirmBooking
    ├── ReviewService.php   # createReview, approveReview
    └── TourService.php     # createTour, updateTour, deleteTour, updateRating
```

---

## Instalação

### Pré-requisitos

- PHP 8.2+ com extensões: `mbstring`, `pdo_mysql`, `pdo_sqlite`
- Composer 2+
- MySQL 8+

### Passos

```bash
# 1. Clonar o repositório
git clone <url-do-repositório> sistur
cd sistur

# 2. Instalar dependências PHP
composer install

# 3. Configurar ambiente
cp .env.example .env
php artisan key:generate
```

Editar `.env` com as credenciais da base de dados:

```env
APP_NAME=Sistur
APP_URL=http://localhost:8000
APP_LOCALE=pt

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistur
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 4. Criar base de dados (MySQL)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sistur CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 5. Executar migrações e seeds
php artisan migrate --seed

# 6. Criar symlink para storage (imagens enviadas)
php artisan storage:link

# 7. Iniciar servidor de desenvolvimento
php artisan serve
```

Aceder em: **http://localhost:8000**

---

## Credenciais de Acesso

| Tipo           | Email             | Palavra-passe |
|----------------|-------------------|---------------|
| Administrador  | admin@sistur.ao   | password      |
| Utilizador     | joao@exemplo.ao   | password      |

---

## Testes

O projecto inclui 46 testes (Feature + Unit) com SQLite in-memory — sem necessidade de MySQL.

```bash
# Executar todos os testes
php artisan test

# Com detalhe por teste
php artisan test --verbose

# Apenas Feature tests
php artisan test --testsuite=Feature

# Apenas Unit tests
php artisan test --testsuite=Unit

# Filtrar por classe
php artisan test --filter BookingServiceTest
```

### Cobertura de testes

| Suite                        | Testes | Descrição                                      |
|------------------------------|--------|------------------------------------------------|
| `Feature/BookingTest`        | 8      | Criar reserva, cancelar, spots, permissões     |
| `Feature/TourTest`           | 5      | Listagem, detalhe, 404 inactivo, filtros       |
| `Unit/BookingServiceTest`    | 8      | Lógica de negócio: preço, vagas, estados       |
| `Feature/Auth/*`             | 14     | Autenticação, registo, reset palavra-passe     |
| `Feature/ProfileTest`        | 5      | Edição de perfil, eliminação de conta          |

---

## Entidades Principais

### Tour
- Campos: nome, slug (auto-gerado), cidade, província, categoria, dificuldade, preço em AOA, vagas
- JSON: imagens[], destaques[], inclui[], exclui[]
- Route key: `slug` (URLs amigáveis: `/tours/safari-kissama`)

### Booking (Reserva)
- Referência única: `SIS-XXXXXXXX` (auto-gerada no boot)
- Status: `pendente` → `confirmado` / `cancelado` / `concluido`
- Vagas: decrementadas ao criar, restauradas ao cancelar

### Review (Avaliação)
- Rating 1–5 estrelas; requer reserva concluída pelo utilizador
- Moderação: aprovação pelo admin recalcula média do tour

---

## Tours incluídos no Seed

| Tour                                 | Cidade   | Preço (AOA) | Dias |
|--------------------------------------|----------|-------------|------|
| Baía de Luanda ao Pôr do Sol         | Luanda   | 25.000      | 1    |
| Museu Nacional da Escravatura        | Luanda   | 8.500       | 1    |
| Cataratas de Calandula               | Malanje  | 85.000      | 2    |
| Praias Paradisíacas de Benguela      | Benguela | 45.000      | 1    |
| Safari no Parque Nacional do Kissama | Luanda   | 120.000     | 2    |
| Serra da Leba e Lubango              | Huíla    | 95.000      | 3    |
| Gastronomia Tradicional Luandense    | Luanda   | 32.000      | 1    |
| Fortaleza de São Miguel              | Luanda   | 12.000      | 1    |
| Lobito Histórico e Lagoa Restelo     | Benguela | 38.000      | 1    |
| Deserto do Namibe e Duna Rosa        | Namibe   | 180.000     | 3    |

---

## Estrutura de Rotas

```
GET  /                           HomeController@index           [home]
GET  /tours                      TourController@index           [tours.index]
GET  /tours/{slug}               TourController@show            [tours.show]

GET  /reservas                   BookingController@index        [auth]
POST /reservas                   BookingController@store        [auth]
GET  /reservas/{ref}             BookingController@show         [auth]
POST /reservas/{ref}/cancelar    BookingController@cancel       [auth]
POST /avaliacoes                 ReviewController@store         [auth]

GET  /admin                      Admin\DashboardController      [auth+admin]
     /admin/tours/...            Admin\TourController (resource)
     /admin/reservas/...         Admin\BookingController
     /admin/avaliacoes/...       Admin\ReviewController
```

---

## Contribuição

1. Fork do repositório
2. Criar branch: `git checkout -b feature/nome`
3. Commit: `git commit -m 'feat: descrição'`
4. Push: `git push origin feature/nome`
5. Abrir Pull Request

---

## Licença

Licenciado sob a [MIT License](LICENSE).

---

*Desenvolvido com ❤️ para Angola 🇦🇴*
