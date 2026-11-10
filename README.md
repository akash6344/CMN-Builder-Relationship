# CMNHousing · Builder Relationship Manager

Laravel BRM portal for relationship managers. Dashboard UI is complete; Projects reads the shared CMN-housing database. Project approve/reject is handled in **CMN-Admin**.

## Stack
- Laravel 13 + Blade + Vite
- Local SQLite for BRM auth
- Shared `housing` SQLite connection → `CMN-housing/database/database.sqlite`

## Setup
```bash
composer install
cp .env.example .env   # if needed
php artisan key:generate
# Ensure HOUSING_DB_DATABASE points at CMN-housing/database/database.sqlite (quoted path if it contains spaces)
php artisan migrate --seed
npm install
php artisan serve --port=8002
```

Open http://127.0.0.1:8002/login

Demo BRM user:
- Email: `anita.brm@cmnhousing.test`
- Password: `password`

## Interconnection
- Builders submit projects in **CMN-housing** (`status = under_review`)
- BRM **Project Approvals** (and Admin **Projects**) approve / send back against the shared DB
- Rejected projects return to the builder with `rejection_reason` so they can edit and resubmit
- BRM **Projects**, **Documents**, and **Dashboard** read shared `project_details` / `project_documents`
- BRM **Builders** uses local `builders` table (`database/sql/001_create_builders.sql` + seeder); synced with housing builder names when seeded
- **Analytics** mixes live portfolio counts with demo trend series; **Reports** exports CSV/Excel/PDF of live metrics

## Ports
- Builder portal (housing): `8000`
- Admin: `8001`
- BRM: `8002`
