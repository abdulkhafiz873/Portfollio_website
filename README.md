# PHP Portfolio Website

## Structure
```
index.php            Home
about.php            About (skills, timeline)
portfolio.php        Filterable projects + modal
contact.php          Contact form, socials, map
contact-handler.php  Form validation, sanitizing, email
includes/            header.php, footer.php, projects.php (shared)
assets/css/style.css
assets/js/script.js
```

## Run locally
1. Install XAMPP/WAMP (or PHP 7.4+), copy folder into `htdocs/`.
2. Or run: `php -S localhost:8000` in this folder, open http://localhost:8000
3. Edit `RECIPIENT_EMAIL` and `FROM_EMAIL` in `contact-handler.php`.
4. `mail()` needs a mail server; on localhost messages are also saved to `storage/messages.log`.
   For production, use PHPMailer with SMTP. Block web access to `storage/`.
