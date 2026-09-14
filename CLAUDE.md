# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Initial setup (install, .env, key, migrate, npm, build)
composer setup

# Development (Laravel server + queue + logs + Vite, all concurrent)
composer dev

# Run all tests
composer test

# Run a single test file
php artisan test tests/Feature/ExampleTest.php

# Production build
npm run build

# Vite dev server only
npm run dev
```

## Architecture

**Stack:** Laravel 12 + Vue 3 + Inertia.js + Tailwind CSS 4 + Vite

**App name:** Pixelify — a multilingual image gallery.

### Routing & Locale

All routes live under `/{locale}/` prefix (e.g. `/en/`, `/ru/`). The `SetLocale` middleware extracts the locale from the route, sets `app()->setLocale()`, and stores it in session. Valid locales come from the `App\Enums\Language` enum (RU, EN, DE, FR).

### Multilingual Content

Images and Categories are translated via separate tables (`image_translations`, `category_translations`). Each model has a `translation(?string $locale)` method that falls back to the default locale. Client-side translations are injected as flattened dot-notation arrays via `HandleInertiaRequests` middleware and consumed through the `useLocale` composable (`resources/js/composables/useLocale.js`).

### Inertia Pages

- `Welcome` — gallery grid (used by both all-images and category-filtered views)
- `ImageDetail` — single image page

### Shared Inertia Props (via HandleInertiaRequests)

- `locale` — current locale string
- `languages` — array from `Language::toArray()`
- `translations` — flattened translations for the current locale
- `categories` — all categories with translations (lazy computed)

### Models

| Model | Key relations |
|---|---|
| `Image` | `hasMany(ImageTranslation)`, belongs to `Category` (nullable) |
| `Category` | `hasMany(CategoryTranslation)`, `hasMany(Image)` |

### Frontend Conventions

- Vue 3 Composition API with `<script setup>` throughout
- Tailwind CSS 4 for styling
- Pages resolved from `resources/js/Pages/`
- Components in `resources/js/Components/`

### Testing

PHPUnit with SQLite in-memory (`:memory:`). Test suites: `Unit` and `Feature`. Config/env overrides in `phpunit.xml`.
