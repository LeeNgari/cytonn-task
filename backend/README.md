# Task Management System API Backend

This is a Task Management System API backend built with Laravel and Supabase (PostgreSQL) as the database. It follows best practices for coding, security, and RESTful API design.

## Table of Contents

- [Project Overview](#project-overview)
- [Setup Instructions](#setup-instructions)
- [API Endpoints Documentation](#api-endpoints-documentation)
- [Authentication Flow](#authentication-flow)
- [Assumptions and Limitations](#assumptions-and-limitations)

## Project Overview

This API provides functionalities for user management (admin only), authentication, and task management. It supports two types of users: `admin` and `user`.

- **User Management (Admin only):** Admins can create, update, and delete users. Users have a name, email, and role (admin or user).
- **Authentication:** Uses Laravel Sanctum for API authentication. Both admins and regular users can log in.
- **Task Management:** Admins can create, assign, update, and delete tasks. Each task has a title, description, assigned user, deadline, and status (Pending, In Progress, or Completed).
- **User Interaction:** Regular users can only view and update the status of their assigned tasks. They cannot modify the title, description, deadline, or assignment.
- **Email Notifications:** An email notification is sent to a user when a new task is assigned.
- **API Only:** All interactions are via JSON request/response, with appropriate validation, error handling, and HTTP status codes.

## Setup Instructions

Follow these steps to set up and run the project locally:

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd cytonntask-api
    ```

2.  **Install Composer dependencies:**
    ```bash
    composer install
    ```

3.  **Configure Environment Variables:**
    Create a `.env` file by copying `.env.example`:
    ```bash
    cp .env.example .env
    ```
    Update the `.env` file with your Supabase PostgreSQL database credentials and Gmail SMTP details. The provided credentials in the prompt are already set up in the `.env` file.

    ```dotenv
    APP_NAME="Laravel Task Management API"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    LOG_CHANNEL=stack
    LOG_DEPRECATIONS_CHANNEL=null
    LOG_LEVEL=debug

    DB_CONNECTION=pgsql
    DB_HOST=aws-0-ap-south-1.pooler.supabase.com
    DB_PORT=6543
    DB_DATABASE=postgres
    DB_USERNAME=postgres.hiyjbspvwdqmpjpjgvfr
    DB_PASSWORD=CQgGjz3wV3AmuFTS

    BROADCAST_DRIVER=log
    CACHE_DRIVER=file
    FILESYSTEM_DISK=local
    QUEUE_CONNECTION=sync
    SESSION_DRIVER=file
    SESSION_LIFETIME=120

    MEMCACHED_HOST=127.0.0.1

    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=leengari76@gmail.com
    MAIL_PASSWORD=bmhmfgglnrjzvkqo
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=leengari76@gmail.com
    MAIL_FROM_NAME="${APP_NAME}"

    AWS_ACCESS_KEY_ID=
    AWS_SECRET_ACCESS_KEY=
    AWS_DEFAULT_REGION=us-east-1
    AWS_BUCKET=
    AWS_USE_PATH_STYLE_ENDPOINT=false

    PUSHER_APP_ID=
    PUSHER_APP_KEY=
    PUSHER_APP_SECRET=
    PUSHER_APP_CLUSTER=mt1

    VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
    ```

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations and Seed the Database:**
    This will create the necessary tables and seed an `admin` user and a `regular` user.
    -   **Admin User:** `email: admin@example.com`, `password: password`
    -   **Regular User:** `email: user@example.com`, `password: password`

    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Start the Laravel Development Server:**
    ```bash
    php artisan serve
    ```
    The API will be accessible at `http://localhost:8000`.

## API Endpoints Documentation

All API requests should include the `Accept: application/json` header.

### Authentication



-   **Login User**
    -   **Endpoint:** `/api/login`
    -   **Method:** `POST`
    -   **Headers:** `Content-Type: application/json`
    -   **Request Body:**
        ```json
        {
            "email": "admin@example.com",
            "password": "password"
        }
        ```
    -   **Response (200 OK):**
        ```json
        {
            "message": "Logged in successfully",
            "access_token": "YOUR_SANCTUM_TOKEN",
            "token_type": "Bearer",
            "user": {
                "id": 1,
                "name": "Admin User",
                "email": "admin@example.com",
                "email_verified_at": null,
                "role": "admin",
                "created_at": "2023-10-27T10:00:00.000000Z",
                "updated_at": "2023-10-27T10:00:00.000000Z"
            }
        }
        ```
    -   **Error Example (422 Unprocessable Entity):**
        ```json
        {
            "message": "The provided credentials are incorrect.",
            "errors": {
                "email": [
                    "The provided credentials are incorrect."
                ]
            }
        }
        ```

-   **Logout User**
    -   **Endpoint:** `/api/logout`
    -   **Method:** `POST`
    -   **Headers:** `Authorization: Bearer YOUR_SANCTUM_TOKEN`
    -   **Response (200 OK):**
        ```json
        {
            "message": "Logged out successfully"
        }
        ```

-   **Get Authenticated User**
    -   **Endpoint:** `/api/user`
    -   **Method:** `GET`
    -   **Headers:** `Authorization: Bearer YOUR_SANCTUM_TOKEN`
    -   **Response (200 OK):** Returns the authenticated user's details.
        ```json
        {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "email_verified_at": null,
            "role": "admin",
            "created_at": "2023-10-27T10:00:00.000000Z",
            "updated_at": "2023-10-27T10:00:00.000000Z"
        }
        ```

### User Management (Admin Only)

All user management endpoints require an `admin` role and `Authorization: Bearer YOUR_ADMIN_TOKEN` header.

-   **List All Users**
    -   **Endpoint:** `/api/users`
    -   **Method:** `GET`
    -   **Response (200 OK):** Array of user objects.

-   **Create New User**
    -   **Endpoint:** `/api/users`
    -   **Method:** `POST`
    -   **Request Body:** Same as register, but also requires `role` field.
        ```json
        {
            "name": "New User",
            "email": "new.user@example.com",
            "password": "password",
            "password_confirmation": "password",
            "role": "user"
        }
        ```
    -   **Response (201 Created):** The created user object.

-   **Get User Details**
    -   **Endpoint:** `/api/users/{user}`
    -   **Method:** `GET`
    -   **Response (200 OK):** The user object.
    -   **Note:** Regular users can only view their own profile (`/api/users/{their_user_id}`). Admins can view any user's profile.

-   **Update User**
    -   **Endpoint:** `/api/users/{user}`
    -   **Method:** `PUT` (full update) or `PATCH` (partial update)
    -   **Request Body:** Fields to update (e.g., `name`, `email`, `password`, `role`).
    -   **Response (200 OK):** The updated user object.

-   **Delete User**
    -   **Endpoint:** `/api/users/{user}`
    -   **Method:** `DELETE`
    -   **Response (204 No Content):**

### Task Management

-   **List All Tasks**
    -   **Endpoint:** `/api/tasks`
    -   **Method:** `GET`
    -   **Headers:** `Authorization: Bearer YOUR_TOKEN`
    -   **Response (200 OK):**
        -   **Admin:** Returns all tasks.
        -   **Regular User:** Returns only tasks assigned to them.

-   **Create New Task (Admin Only)**
    -   **Endpoint:** `/api/tasks`
    -   **Method:** `POST`
    -   **Headers:** `Authorization: Bearer YOUR_ADMIN_TOKEN`
    -   **Request Body:**
        ```json
        {
            "title": "Develop API",
            "description": "Implement all API endpoints for task management.",
            "assigned_to": 2, // User ID
            "deadline": "2023-12-31 23:59:59",
            "status": "in_progress"
        }
        ```
    -   **Response (201 Created):** The created task object.

-   **Get Task Details**
    -   **Endpoint:** `/api/tasks/{task}`
    -   **Method:** `GET`
    -   **Headers:** `Authorization: Bearer YOUR_TOKEN`
    -   **Response (200 OK):** The task object.
    -   **Note:** Regular users can only view tasks assigned to them. Admins can view any task.

-   **Update Task (Admin Only)**
    -   **Endpoint:** `/api/tasks/{task}`
    -   **Method:** `PUT` (full update) or `PATCH` (partial update)
    -   **Headers:** `Authorization: Bearer YOUR_ADMIN_TOKEN`
    -   **Request Body:** Fields to update (e.g., `title`, `description`, `assigned_to`, `deadline`, `status`).
    -   **Response (200 OK):** The updated task object.

-   **Update Task Status (Assigned User or Admin)**
    -   **Endpoint:** `/api/tasks/{task}/status`
    -   **Method:** `PATCH`
    -   **Headers:** `Authorization: Bearer YOUR_TOKEN`
    -   **Request Body:**
        ```json
        {
            "status": "completed"
        }
        ```
    -   **Response (200 OK):** The updated task object.
    -   **Note:** Only the assigned user or an admin can update the status.

-   **Delete Task (Admin Only)**
    -   **Endpoint:** `/api/tasks/{task}`
    -   **Method:** `DELETE`
    -   **Headers:** `Authorization: Bearer YOUR_ADMIN_TOKEN`
    -   **Response (204 No Content):**

## Authentication Flow

1.  **Login:** Users log in using their email and password via the `/api/login` endpoint. Upon successful login, they receive a Sanctum API token.
3.  **Token Usage:** This token should be included in the `Authorization` header of subsequent requests as a Bearer token (e.g., `Authorization: Bearer YOUR_SANCTUM_TOKEN`).
4.  **Logout:** Users can invalidate their current token by sending a `POST` request to `/api/logout`.
5.  **Role-Based Access Control:**
    -   The `admin` middleware protects routes that should only be accessible by users with the `admin` role.
    -   Policies (implicitly handled in controllers for simplicity in this project) ensure that users can only interact with tasks assigned to them or perform actions based on their role.

## Assumptions and Limitations

-   **Email Sending:** Assumes the provided Gmail SMTP credentials are correct and the Gmail account allows less secure app access or has an app password generated.
-   **Database:** Relies on Supabase PostgreSQL. Ensure your Supabase project is correctly configured and accessible from your environment.
-   **Error Handling:** Basic validation and error handling are implemented. For a production system, more granular error codes and logging might be desired.
-   **User Roles:** Only `admin` and `user` roles are supported. Extending this would require modifying the `role` enum in the migration and relevant logic.
-   **Task Statuses:** Only `pending`, `in_progress`, and `completed` statuses are supported. This can be extended in the migration and controller logic.
-   **No Frontend:** This project is strictly an API backend. A separate frontend application would be needed to interact with these endpoints.
-   **No Password Reset:** Password reset functionality is not implemented.
-   **No Rate Limiting:** API rate limiting is not configured by default. Consider adding it for production environments.