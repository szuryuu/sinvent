# Sinvent

A modern, full-stack **Inventory Management System** built with **Laravel** (Backend) and **Vue 3** (Frontend). This application provides a seamless experience for tracking products, managing members, and visualizing stock data through interactive charts.

## Features

- **Product & Inventory Management**: Efficiently track stock levels, add new products, and update inventory details.
- **Member Administration**: Manage user roles and member profiles within the system.
- **Secure Authentication**: Robust login and registration system using JWT/Sanctum.
- **Interactive Analytics**: Visual data representation using Chart.js to monitor inventory trends.
- **Modern UI/UX**: Built with Tailwind CSS and reusable UI components for a clean, responsive interface.

## Tech Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: Vue 3, Vite, Tailwind CSS
- **Database**: MySQL (Default Laravel support)
- **State Management & Tooling**: Pinia, Bun, ESLint, Prettier

### Step 1: Backend Setup (Laravel)

Navigate to the backend directory and install dependencies.
1. **Navigate to the backend directory:**
    ```bash
    cd be
    ```

2. **Install PHP dependencies:**
    ```bash
    composer install
    ```

3. **Configure the Environment:**
    Duplicate the example environment file and configure your database settings.
    ```bash
    cp .env.example .env
    ```
    Open ```.env``` and set your ```DB_DATABASE```, ```DB_USERNAME```, and ```DB_PASSWORD```.

4. **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5. **Generate JWT Secret:**   
    ```bash
    php artisan jwt:secret
    ```

6. **Run Migrations:** 
    Create the necessary database tables.
    ```bash
    php artisan migrate
    ```

7. **Serve the Application:**
    ```bash
    php artisan serve
    ```
    
### Step 2: Frontend Setup (Vue 3)

Open a new terminal, navigate to the frontend directory, and start the development server.

1. **Navigate to the frontend folder:**
    ```bash
    cd fe
    ```
    
2. **Install Node dependencies:**
    ```bash
    bun install
    ```
    
3. **Compile and Hot-Reload for Development:**
    ```bash
    bun run dev
    ```
    
### Step 3: Access the Application

Once both servers are running, open your browser and navigate to the local URL provided by Vite (usually http://localhost:5173).

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
