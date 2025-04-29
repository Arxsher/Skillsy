# Skillsy - Developer Community Platform

<br>

![Skillsy reveal](assets/images.skillsy-reveal.png)

<br>

Skillsy is a web-based platform designed to connect developers, foster collaboration, and build a vibrant tech community. Built with PHP, MySQL, and modern frontend tools, it provides a secure space for users to sign up, log in, and interact with others.

**Official APK available!** You can also access Skillsy as a secure Android app. The website and APK are hosted with an SSL certificate at [https://skillsy.wuaze.com](https://skillsy.wuaze.com).

## Features
- User authentication (sign up, log in)
- Responsive, modern UI (Tailwind CSS)
- Community features (expandable)
- Error handling and user feedback
- Secure hosting with SSL
- Android APK available for download

## Installation & Setup

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) or another Apache/PHP/MySQL stack
- PHP 7.4 or higher
- Composer (optional, if you want to manage PHP dependencies)

### Steps
1. **Clone or copy the repository** into your XAMPP `htdocs` directory:
   ```
   git clone https://github.com/Arxsher/skillsy.git hackathon
   ```
   Or copy the files directly to `/opt/lampp/htdocs/hackathon`.

2. **Start Apache and MySQL** from your XAMPP control panel.

3. **Database setup:**
   - Import the provided SQL file (if available) into your MySQL server.
   - Update database credentials in your PHP files if needed (usually in a config file).

4. **Access the application:**
   - Visit [http://localhost/hackathon/view/index.php](http://localhost/hackathon/view/index.php) in your browser.

## Project Structure
```
/opt/lampp/htdocs/hackathon
├── assets/           # CSS, images, JS, etc.
│   ├── css/
│   │   ├── home.css
│   │   └── test.css
│   ├── images/
│   └── js/
│       └── script.js
├── config/           # Configuration files (e.g., DB connection)
├── controller/       # PHP controllers
│   ├── forgot.php
│   ├── login.php
│   ├── logout.php
│   └── signin.php
├── model/            # Database models
│   └── mydb.php
├── view/             # PHP views (UI)
│   ├── home.php
│   └── index.php
├── README.md         # Project documentation
```

## Usage
- Open the main page in your browser.
- Register a new account or log in with existing credentials.
- Explore available features (community, profile, etc.).

## Contributing
Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## License
MIT License

---
