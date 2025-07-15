# Task FLow - Task Management System 

This is a Task Management System built with Vue js, Laravel and PostgreSQL as the database. 

## Table of Contents

- [Project Overview](#project-overview)
- [Setup Instructions](#setup-instructions)
- [API Endpoints Documentation](#api-endpoints-documentation)

## Project Overview

This system provides functionalities for user management (admin only), authentication, and task management. It supports two types of users: `admin` and `user`.

- **User Management (Admin only):** Admins can create, update, and delete users. Users have a name, email, and role (admin or user).
- **Authentication:** Uses Laravel Sanctum for API authentication. Both admins and regular users can log in.
- **Task Management:** Admins can create, assign, update, and delete tasks. Each task has a title, description, assigned user, deadline, and status (Pending, In Progress, or Completed).
- **User Interaction:** Regular users can only view and update the status of their assigned tasks. They cannot modify the title, description, deadline, or assignment.
- **Email Notifications:** An email notification is sent to a user when a new task is assigned.

## Setup Instructions

Follow these steps to set up and run the project locally:

### Backend Setup

1.  **Navigate to the backend directory:**
    ```bash
    cd backend
    ```

2.  **Install Composer dependencies:**
    ```bash
    composer install
    ```

3.  **Configure Environment Variables:**
    Create a `.env` `:
    
    Update the `.env` file with your  database credentials and Gmail SMTP details.

    ```dotenv
    
    DB_CONNECTION=pgsql
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=

    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=
    MAIL_FROM_NAME="${APP_NAME}"
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

### Frontend Setup

1.  **Navigate to the frontend directory:**
    ```bash
    cd frontend
    ```

2.  **Install NPM dependencies:**
    ```bash
    npm i
    ```

3.  **Start the Frontend Development Server:**
    ```bash
    npm run dev
    ```
    The frontend will be accessible at `http://localhost:5173`.


## API Endpoints Documentation

All API requests should include the `Accept: application/json` header. Authenticated endpoints require an `Authorization: Bearer YOUR_SANCTUM_TOKEN` header.

---

### Authentication

#### 1. Login User

-   **Description:** Authenticates a user and returns a Sanctum token.
-   **Endpoint:** `/api/login`
-   **Method:** `POST`
-   **Authentication:** Not required.

**Request Body:**

```json
{
    "email": "user@example.com",
    "password": "password"
}
```

**Body Parameters:**

-   `email` (string, required, email): The user's email address.
-   `password` (string, required): The user's password.

**Success Response (200 OK):**

```json
{
    "message": "Logged in successfully",
    "access_token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "token_type": "Bearer",
    "user": {
        "id": 2,
        "name": "Test User",
        "email": "user@example.com",
        "email_verified_at": null,
        "role": "user",
        "created_at": "2025-07-13T12:00:00.000000Z",
        "updated_at": "2025-07-13T12:00:00.000000Z"
    }
}
```

**Error Response (422 Unprocessable Entity):**

This response is returned if validation fails (e.g., missing fields) or credentials are incorrect.

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

---

#### 2. Logout User

-   **Description:** Invalidates the user's current Sanctum token.
-   **Endpoint:** `/api/logout`
-   **Method:** `POST`
-   **Authentication:** Required.

**Success Response (200 OK):**

```json
{
    "message": "Logged out successfully"
}
```

**Error Response (401 Unauthorized):**

```json
{
    "message": "Unauthenticated."
}
```

---

#### 3. Get Authenticated User

-   **Description:** Fetches the details of the currently authenticated user.
-   **Endpoint:** `/api/user`
-   **Method:** `GET`
-   **Authentication:** Required.

**Success Response (200 OK):**

Returns the authenticated user object.

```json
{
    "id": 1,
    "name": "Admin User",
    "email": "admin@example.com",
    "email_verified_at": null,
    "role": "admin",
    "created_at": "2025-07-13T12:00:00.000000Z",
    "updated_at": "2025-07-13T12:00:00.000000Z"
}
```

---

### User Management

**Note:** All user management endpoints require `admin` role.

#### 1. List All Users

-   **Description:** Retrieves a list of all users.
-   **Endpoint:** `/api/users`
-   **Method:** `GET`
-   **Authentication:** Required (`admin` role).

**Success Response (200 OK):**

```json
[
    {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "email_verified_at": null,
        "role": "admin",
        "created_at": "2025-07-13T12:00:00.000000Z",
        "updated_at": "2025-07-13T12:00:00.000000Z"
    },
    {
        "id": 2,
        "name": "Test User",
        "email": "user@example.com",
        "email_verified_at": null,
        "role": "user",
        "created_at": "2025-07-13T12:00:00.000000Z",
        "updated_at": "2025-07-13T12:00:00.000000Z"
    }
]
```

**Error Response (403 Forbidden):**

```json
{
    "message": "Unauthorized"
}
```

---

#### 2. Create New User

-   **Description:** Creates a new user.
-   **Endpoint:** `/api/users`
-   **Method:** `POST`
-   **Authentication:** Required (`admin` role).

**Request Body:**

```json
{
    "name": "New User",
    "email": "new.user@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "user"
}
```

**Body Parameters:**

-   `name` (string, required, max:255)
-   `email` (string, required, email, unique:users)
-   `password` (string, required, min:8, confirmed)
-   `role` (string, required, in:admin,user)

**Success Response (201 Created):**

Returns the newly created user object.

```json
{
    "id": 3,
    "name": "New User",
    "email": "new.user@example.com",
    "role": "user",
    "created_at": "2025-07-13T12:00:00.000000Z",
    "updated_at": "2025-07-13T12:00:00.000000Z"
}
```

**Error Response (422 Unprocessable Entity):**

```json
{
    "message": "The email has already been taken. (and 2 more errors)",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "password": [
            "The password confirmation does not match."
        ],
        "role": [
            "The selected role is invalid."
        ]
    }
}
```

---

#### 3. Get User Details

-   **Description:** Retrieves details for a specific user. An admin can view any user. A regular user can only view their own profile.
-   **Endpoint:** `/api/users/{user}`
-   **Method:** `GET`
-   **Authentication:** Required.

**URL Parameters:**

-   `user` (integer, required): The ID of the user to retrieve.

**Success Response (200 OK):**

Returns the user object.

```json
{
    "id": 2,
    "name": "Test User",
    "email": "user@example.com",
    "role": "user",
    "created_at": "2025-07-13T12:00:00.000000Z",
    "updated_at": "2025-07-13T12:00:00.000000Z"
}
```

**Error Response (403 Forbidden):**

Returned if a non-admin user tries to access another user's details.

```json
{
    "message": "Unauthorized"
}
```

---

#### 4. Update User

-   **Description:** Updates a user's details. An admin can update any user. A regular user can only update their own profile.
-   **Endpoint:** `/api/users/{user}`
-   **Method:** `PUT` / `PATCH`
-   **Authentication:** Required.

**Request Body (Admin):**

```json
{
    "name": "Updated User Name",
    "email": "updated.user@example.com",
    "role": "admin"
}
```

**Request Body (User):**

```json
{
    "name": "My Updated Name"
}
```

**Body Parameters:**

-   `name` (string, sometimes, required, max:255)
-   `email` (string, sometimes, required, email, unique:users)
-   `password` (string, sometimes, required, min:8, confirmed)
-   `role` (string, sometimes, required, in:admin,user) - **Admin only**

**Success Response (200 OK):**

Returns the updated user object.

---

#### 5. Delete User

-   **Description:** Deletes a user.
-   **Endpoint:** `/api/users/{user}`
-   **Method:** `DELETE`
-   **Authentication:** Required (`admin` role).

**Success Response (204 No Content):**

An empty response body.

---

### Task Management

#### 1. List Tasks

-   **Description:** Retrieves a list of tasks. Admins see all tasks. Regular users see only tasks assigned to them.
-   **Endpoint:** `/api/tasks`
-   **Method:** `GET`
-   **Authentication:** Required.

**Success Response (200 OK):**

Returns an array of task objects, including the assigned user details.

```json
[
    {
        "id": 1,
        "title": "Design new dashboard",
        "description": "A detailed description of the task.",
        "assigned_to": 2,
        "deadline": "2025-08-01",
        "status": "pending",
        "created_at": "2025-07-13T12:00:00.000000Z",
        "updated_at": "2025-07-13T12:00:00.000000Z",
        "assigned_user": {
            "id": 2,
            "name": "Test User",
            "email": "user@example.com",
            "email_verified_at": null,
            "role": "user",
            "created_at": "2025-07-13T12:00:00.000000Z",
            "updated_at": "2025-07-13T12:00:00.000000Z"
        }
    }
]
```

---

#### 2. Create Task

-   **Description:** Creates a new task and assigns it to a user.
-   **Endpoint:** `/api/tasks`
-   **Method:** `POST`
-   **Authentication:** Required (`admin` role).

**Request Body:**

```json
{
    "title": "Implement feature X",
    "description": "Detailed requirements for feature X.",
    "assigned_to": 2,
    "deadline": "2025-09-15",
    "status": "pending"
}
```

**Body Parameters:**

-   `title` (string, required, max:255)
-   `description` (string, nullable)
-   `assigned_to` (integer, required, exists:users,id)
-   `deadline` (date, required)
-   `status` (string, sometimes, in:pending,in_progress,completed) - Defaults to `pending`.

**Success Response (201 Created):**

Returns the newly created task object.

---

#### 3. Get Task Details

-   **Description:** Retrieves details for a specific task. An admin can view any task. A regular user can only view tasks assigned to them.
-   **Endpoint:** `/api/tasks/{task}`
-   **Method:** `GET`
-   **Authentication:** Required.

**URL Parameters:**

-   `task` (integer, required): The ID of the task.

**Success Response (200 OK):**

Returns the task object.

**Error Response (403 Forbidden):**

Returned if a user tries to access a task not assigned to them.

```json
{
    "message": "Unauthorized"
}
```

---

#### 4. Update Task

-   **Description:** Updates a task's details.
-   **Endpoint:** `/api/tasks/{task}`
-   **Method:** `PUT` / `PATCH`
-   **Authentication:** Required (`admin` role).

**Request Body:**

```json
{
    "title": "Updated Task Title",
    "deadline": "2025-10-01"
}
```

**Body Parameters:**

-   `title` (string, sometimes, required, max:255)
-   `description` (string, nullable)
-   `assigned_to` (integer, sometimes, required, exists:users,id)
-   `deadline` (date, sometimes, required)
-   `status` (string, sometimes, in:pending,in_progress,completed)

**Success Response (200 OK):**

Returns the updated task object.

---

#### 5. Update Task Status

-   **Description:** Allows the assigned user to update the status of their task.
-   **Endpoint:** `/api/tasks/{task}/status`
-   **Method:** `PATCH`
-   **Authentication:** Required.

**URL Parameters:**

-   `task` (integer, required): The ID of the task.

**Request Body:**

```json
{
    "status": "in_progress"
}
```

**Body Parameters:**

-   `status` (string, required, in:pending,in_progress,completed)

**Success Response (200 OK):**

Returns the updated task object.

**Error Response (403 Forbidden):**

Returned if a user tries to update the status of a task not assigned to them.

```json
{
    "message": "Unauthorized"
}
```

---

#### 6. Delete Task

-   **Description:** Deletes a task.
-   **Endpoint:** `/api/tasks/{task}`
-   **Method:** `DELETE`
-   **Authentication:** Required (`admin` role).

**Success Response (204 No Content):**

An empty response body.