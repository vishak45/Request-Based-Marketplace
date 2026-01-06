
# Request-Based-Marketplace

A PHP marketplace application containerized with Docker for consistent development environments.

---

## 🧩 Overview

This repository contains a PHP application that is run using Docker containers.  
The setup includes:

- Apache + PHP container  
- MySQL container  
- A shared volume for the application code  
- Database initialization via SQL file  

This allows you to avoid installing WAMP/XAMPP locally and ensures consistent setups across machines.

---

## 🚀 Prerequisites

Before proceeding, make sure you have:

- Docker Desktop installed (Windows / Mac)  
- Docker Engine & Docker Compose (Linux)  
- Git (to clone this repository)

---

## 📁 Folder Structure

```

Request-Based-Marketplace/
├── app/                        # Application logic
├── database/                   # SQL initialization files
├── docker/
│   ├── Dockerfile              # PHP/Apache build config
│   └── docker-compose.yml      # Container definitions
├── public/                     # Web-served files
├── .gitignore
└── README.md

````

Note: The MySQL database runs directly from the official MySQL Docker image — no separate Dockerfile is used for MySQL.

---

## 🐳 How to Run with Docker

### 1️⃣ Clone the repository

```bash
git clone https://github.com/vishak45/Request-Based-Marketplace.git
cd Request-Based-Marketplace
````

---

### 2️⃣ Start containers

```bash
docker compose -f docker/docker-compose.yml up --build
```

This builds and starts all services defined in `docker/docker-compose.yml`.

---

### 3️⃣ Run in background (optional)

```bash
docker compose -f docker/docker-compose.yml up -d
```

---

### 4️⃣ Stop containers

```bash
docker compose -f docker/docker-compose.yml down
```

---

## 🌐 Accessing the App

Once the containers are running:

**Web Application:**

```
http://localhost:8080
```

**MySQL Database:**
If your system already has MySQL running (e.g., WAMP), Docker may fail to bind port **3306**.
You can change the mapped port in `docker/docker-compose.yml`:

```yaml
ports:
  - "3307:3306"
```

Then restart the containers.

---

## ❗ Common Issues

### Port 3306 already in use

This usually happens when:

* WAMP / XAMPP MySQL is running
* Another Docker container is already using the port

**Solution:** Stop the existing MySQL service or change the port mapping as shown above.

---

## ✨ Useful Docker Commands

Check running containers:

```bash
docker compose ps
```

View logs:

```bash
docker compose logs -f
```

---

## 🧠 Workflow Notes

This project follows a branch-based workflow:

1. Create a feature branch
2. Commit changes
3. Test locally with Docker
4. Merge into `main` once stable

---

## 🤝 Contributing

Contributions are welcome!
Feel free to open issues, suggest improvements, or submit pull requests.

Happy coding 🚀



Do you want me to make that version too?
```
