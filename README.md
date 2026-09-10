# Prototype Hub — `proto.cu.ac.bd`

A landing page for **Prototypes of Chittagong University applications** — discover and access cutting-edge prototype applications built for Chittagong University.

---

## Overview

`proto.cu.ac.bd` serves as a central directory that lists all prototype applications built for Chittagong University. Each prototype is displayed as a card with its **title**, **logo**, and **link**. The entire page is driven by environment variables, so no code changes are needed to add, remove, or reorder apps.

---

## Features

- 🚀 **Zero-code app management** — apps are added/edited via environment variables
- 🎨 **Customizable branding** — site title and subtitle are configurable
- 🧩 **JSON-driven** — one JSON array can list all apps at once
- 🔄 **Fallback support** — individual `APP_N_*` variables if JSON is not provided
- 🖼️ **Logo support** — each app can have its own logo (SVG/PNG, any URL)

---

## Environment Configuration

All configuration is done through environment variables. Below is a complete `.env.example` you can copy into your deployment.

### `.env.example`

```bash
# Website Heading & Metadata
SITE_TITLE=Prototypes of Chittagong university applications
SITE_SUBTITLE=Discover and access cutting-edge prototype applications built for Chittagong University.

# All apps in a single JSON array (recommended)
APPS_JSON=[{"url":"/sam","title":"Student Accommodation Management","logo":"https://proto.cu.ac.bd/sam/static/images/logo.svg"},{"url":"https://proto.cu.ac.bd/imageprocessingarchitecture","title":"Image Processing Architecture","logo":"https://proto.cu.ac.bd/imageprocessingarchitecture/static/images/logo.svg"},{"url":"https://cu.ac.bd","title":"Chittagong University Portal","logo":"https://upload.wikimedia.org/wikipedia/en/thumb/f/f3/University_of_Chittagong_logo.svg/1200px-University_of_Chittagong_logo.svg.png"}]

# Fallback: Application 1
APP_1_URL=/sam
APP_1_TITLE=Student Accommodation Management
APP_1_LOGO=https://proto.cu.ac.bd/sam/static/images/logo.svg

# Fallback: Application 2 (Optional)
APP_2_URL=https://cu.ac.bd
APP_2_TITLE=Chittagong University Portal
APP_2_LOGO=https://upload.wikimedia.org/wikipedia/en/thumb/f/f3/University_of_Chittagong_logo.svg/1200px-University_of_Chittagong_logo.svg.png
```

---

## Configuration Reference

| Variable | Type | Description |
|---|---|---|
| `SITE_TITLE` | string | Main heading of the page |
| `SITE_SUBTITLE` | string | Subtitle/tagline shown under the heading |
| `APPS_JSON` | JSON array | **Recommended.** All apps as a JSON array of `{url, title, logo}` objects |
| `APP_N_URL` | string | URL of app *N* (relative like `/sam` or absolute like `https://...`) |
| `APP_N_TITLE` | string | Display title of app *N* |
| `APP_N_LOGO` | string | Logo image URL of app *N* |
| `APP_2_*` | string | Optional — second fallback app (add `APP_3_*`, `APP_4_*`, ... as needed) |

### Precedence

1. If `APPS_JSON` is set and valid → it is used (all apps in one place).
2. Otherwise, the app falls back to individual `APP_1_*`, `APP_2_*`, ... variables.
3. If neither is set → the page renders with placeholder/default content.

---

## Adding a New Prototype App

### Option A — via `APPS_JSON` (recommended)

Append a new object to the array:

```bash
APPS_JSON=[{"url":"/sam","title":"Student Accommodation Management","logo":"https://proto.cu.ac.bd/sam/static/images/logo.svg"},{"url":"/my-new-app","title":"My New App","logo":"https://proto.cu.ac.bd/my-new-app/static/images/logo.svg"}]
```

> ⚠️ Keep the JSON on a **single line** (no line breaks) when using `.env` files.

### Option B — via fallback variables

```bash
APP_3_URL=/my-new-app
APP_3_TITLE=My New App
APP_3_LOGO=https://proto.cu.ac.bd/my-new-app/static/images/logo.svg
```

Then **restart/redeploy** the service for changes to take effect.

---

## Notes & Tips

- **Relative vs absolute URLs:** Use relative paths (`/sam`) for apps hosted on the same domain; absolute URLs for external links.
- **Logos:** Prefer SVG logos served from the app's own `static/images/` directory for consistency.
- **JSON escaping:** If a title or URL contains quotes, escape them (`\"`) inside `APPS_JSON`.
- **Logo fallback:** If a logo fails to load, consider providing a default placeholder image in the frontend.

---

## Quick Start

```bash
# 1. Copy the example environment file
cp .env.example .env

# 2. Edit it with your apps
nano .env

# 3. Start the service (method depends on your stack, e.g.):
docker compose up -d
# or
npm run start
```

---

*Maintained for Chittagong University prototype applications.*
