# Il Mirto Apartment — sito web ufficiale

Applicazione **Laravel 12**, **Jetstream (Livewire)**, **Tailwind** (CDN di fallback o build Vite), **Livewire 3**, **Spatie Permission**, **mcamara/laravel-localization** (IT/EN/DE/FR/ES), **Intervention Image** per upload galleria in WebP.

Dominio di riferimento: **ilmirtoapartment.it**

## Requisiti

- PHP **8.2+** (consigliato **8.3+** in produzione)
- Estensioni: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd` o `imagick` (per ottimizzazione immagini)
- Composer
- MySQL/MariaDB (consigliato su cPanel) oppure SQLite in locale
- Node **18+** (solo in sviluppo per `npm run build` / Vite; in produzione si possono caricare gli asset già compilati)

## Installazione rapida (locale o VPS)

```bash
cd Sito
composer install
cp .env.example .env
php artisan key:generate
```

Configura `.env` (database, `APP_URL`, mail Brevo/SMTP).

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### Credenziali demo (solo dopo seed)

- Email: `admin@ilmirtoapartment.it`
- Password: `MirtoAdmin!2026`

Cambiare subito password e abilitare **2FA** dal profilo Jetstream (`/user/profile`).

## cPanel (hosting condiviso)

1. Carica i file nella cartella pubblica (es. `public_html` puntando il document root alla cartella `public/` del progetto, oppure sposta il contenuto di `public/` nella root web e aggiorna i path in `index.php` come da documentazione Laravel).
2. Crea database MySQL e utente; inserisci credenziali in `.env` (`DB_*`).
3. Da terminale SSH (se disponibile): `composer install --no-dev --optimize-autoloader`
4. `php artisan migrate --force` e `php artisan db:seed --force`
5. `php artisan storage:link`
6. Permessi cartelle `storage/` e `bootstrap/cache/` scrivibili (755/775).
7. **Cron** (ogni minuto): `php /percorso/artisan schedule:run` per code e scheduler.
8. Code: in `.env` usare `QUEUE_CONNECTION=database` e assicurarsi che la tabella `jobs` esista (migration inclusa). In hosting condiviso spesso si lancia un worker breve via cron oppure si usa `sync` solo per test (non consigliato in produzione per newsletter).

### Mail / Brevo

Imposta SMTP Brevo (`MAIL_*` in `.env`). Le email di conferma newsletter usano la coda: con `QUEUE_CONNECTION=database` assicurati che il worker o `schedule:run` elabori la coda.

### Asset frontend

Se è presente `public/build/manifest.json`, il layout Jetstream e il sito usano **Vite**. In assenza di build, il sito pubblico usa **Tailwind CDN** (fallback). Per produzione:

```bash
npm ci
npm run build
```

## Funzionalità principali

- Pagine pubbliche: home, appartamento, galleria (lightbox), servizi, promozioni, esperienze, dove siamo, recensioni (opzionale), contatti, newsletter (double opt-in), preventivo, calendario disponibilità, privacy, cookie, termini.
- **FAQ nascosta**: URL predefinito `/{lingua}/info/mirto-faq-7k2` (con default IT spesso senza prefisso `/it` se `hideDefaultLocaleInURL` è attivo). Non è nel menu.
- **Admin** (`/dashboard/...`, ruoli `admin` / `editor`): calendario prezzi stile tabella, impostazioni (prezzi base, tasse, contatti, mappa), preventivi salvati, iscritti newsletter, galleria con upload WebP, visibilità pagine (recensioni/blog).
- **SEO**: `sitemap.xml`, `robots.txt`, hreflang, JSON-LD `LodgingBusiness`.
- **Sicurezza**: CSRF Laravel, validazione Livewire, Fortify rate limit login, hash bcrypt, Jetstream 2FA pronta.

## Backup database

Usare dump pianificato da cPanel o:

```bash
mysqldump -u USER -p DATABASE > backup_mirto.sql
```

## Note legali e contenuti

I testi legali sono modelli: farli revisionare da un professionista prima della pubblicazione. Coordinate e numeri di telefono vanno aggiornati in **Impostazioni** nel pannello o direttamente nei record `site_settings`.

## Supporto tecnico

Stack documentato: [Laravel](https://laravel.com/docs), [Jetstream](https://jetstream.laravel.com), [Livewire](https://livewire.laravel.com), [Laravel Localization](https://github.com/mcamara/laravel-localization).
