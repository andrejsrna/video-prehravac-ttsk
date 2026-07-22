# Video prehrávač TTSK

Jednoduchá PHP appka na nahrávanie, správu a cyklické prehrávanie videí na TV obrazovkách. Pôvodne bežala ako súčasť skompromitovaného WordPress webu `video.trnavavuc.sk` — vyčistené a vymigrované do samostatnej appky.

## Štruktúra

- `/` — verejný prehrávač (bez loginu), loopuje videá s `noplay = 0` z DB, autoplay+muted pre TV
- `/sprava/` — admin panel (login, upload, úprava, mazanie videí) — presne zachované z pôvodného skriptu

## Potrebné env premenné (Coolify)

- `DB_HOST` — interný docker hostname MySQL databázy (napr. `lgckocw0ksco0g08goo48wo0`)
- `DB_USER` — `root`
- `DB_PASSWORD` — heslo k databáze
- `DB_NAME` — `video`
- `APP_PASSWORD` — heslo na prihlásenie do admin rozhrania (nahrádza pôvodné natvrdo zapísané heslo)

## Persistentné úložisko

Priečinok `video/` musí byť pripojený ako persistentný volume v Coolify (aby nahraté videá prežili redeploy). Existujúce videá treba skopírovať zo starého WordPress kontajnera.

## Zmeny oproti pôvodnému skriptu

- Prihlasovacie heslo a DB credentials presunuté z kódu do env premenných
- Upload akceptuje len video prípony/MIME typy (predtým bez akejkoľvek kontroly — pravdepodobná príčina kompromitácie pôvodného webu)
- Názvy nahrávaných súborov sa sanitizujú a prefixujú timestampom
- SQL dotazy v edit.php/delete.php prevedené na prepared statements (predtým SQL injection)
- `video/.htaccess` blokuje spúšťanie PHP v priečinku s videami (defense-in-depth)
- Odstránené: WordPress, `b24.php`, `64abafc4/about.php`, nefunkčný `upload2.php`

## Lokálne spustenie cez Docker Compose

1. Skopíruj `.env.example` ako `.env` a zmeň predvolené heslá.
2. Spusti `docker compose up -d --build`.
3. Aplikácia bude na `http://localhost:8080`, administrácia na
   `http://localhost:8080/sprava/` a phpMyAdmin na `http://localhost:8081`.

Do phpMyAdminu sa prihlás hodnotami `DB_USER` a `DB_PASSWORD` zo súboru `.env`.
MySQL dáta aj nahrané videá sú uložené v pomenovaných Docker volumes.
