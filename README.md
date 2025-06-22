

# 📝 EnglishDiary

**EnglishDiary** is a web application that supports English learning through personalized word cards, daily writing practice, quizzes by proficiency level, and interactive vocabulary games.

---

## 🚀 Features

- ✅ **User Registration & Login**
- 📚 **Flashcards**: Level-based vocabulary learning with known/unknown marking
- 📋 **Word List**: Separately view known and unknown words
- 🧠 **Mini Quizzes**: Grammar and vocabulary proficiency tests
- 🎮 **Word Games**: Matching, missing letters, and more fun activities
- 👤 **Profile & Settings**: Update user info, change password, delete account
- 🌐 **Modern Interface**: Responsive design with Bootstrap

---

## 🛠️ Setup Instructions

### 1. Clone the Project
```bash
git clone https://github.com/username/englishdiary.git
```

2. Import the Database
Use the SQL commands in *db_sql_codes.sql* to create the required MySQL database.

3. Configure Database Connection
Edit *config/db.php* to set your DB username, password, and database name.

💻 Running from a Custom Folder (Virtual Host)
1. Apache Virtual Host Setup
Edit httpd-vhosts.conf and add at the end:


```apache
<VirtualHost *:80>
    ServerName EnglishDiary.local
    DocumentRoot "C:\Users\havva\Desktop\EnglishDiary"

    <Directory "C:\Users\havva\Desktop\EnglishDiary">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Make sure to comment out any conflicting existing entries.

2. Edit Hosts File
Open the file located at:

```makefile
C:\Windows\System32\drivers\etc\hosts
```

Add this line at the bottom:

```bash
127.0.0.1    EnglishDiary.local
```
⚠️ Must be edited with a text editor running as Administrator.

3. Restart XAMPP (Apache & MySQL)
4. Open in Browser
```arduino
http://EnglishDiary.local
```
If index.php loads, the setup is successful ✅

📁 Project Structure
```java

EnglishDiary/
│
├── assets/          → CSS and images
├── config/          → Database connection settings
├── flashcards/      → Flashcard module
├── include/         → Common components (header, navbar, footer)
├── plays/           → Word games
├── index.php        → Main entry point
├── profile.php      → User profile page
├── quiz.php         → Quiz module
└── ...              → Other pages (login, register, settings)
```

🤝 Contributing
To contribute:

1) Fork the repo
2) Create a new branch
3) Make your changes
4) Submit a Pull Request

**EnglishDiary** aims to make English learning more fun, interactive, and personalized.
