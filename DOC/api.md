# API Documentation

## Authentication

### JWT Authentication
All API endpoints require JWT authentication. Include the token in the Authorization header:

```
Authorization: Bearer {your_jwt_token}
```

### Obtaining a Token
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

Response:
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "token_type": "bearer",
    "expires_in": 3600
}
```

## API Endpoints

### Users

#### Get All Users
```http
GET /api/users
Authorization: Bearer {token}
```

Response:
```json
{
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

#### Get Single User
```http
GET /api/users/{id}
Authorization: Bearer {token}
```

#### Create User
```http
POST /api/users
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "New User",
    "email": "new@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

#### Update User
```http
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Name",
    "email": "updated@example.com"
}
```

#### Delete User
```http
DELETE /api/users/{id}
Authorization: Bearer {token}
```

### Products

#### Get All Products
```http
GET /api/products
Authorization: Bearer {token}
```

#### Get Single Product
```http
GET /api/products/{id}
Authorization: Bearer {token}
```

#### Create Product
```http
POST /api/products
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "New Product",
    "description": "Product description",
    "price": 99.99,
    "stock": 100
}
```

#### Update Product
```http
PUT /api/products/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Product",
    "price": 89.99
}
```

#### Delete Product
```http
DELETE /api/products/{id}
Authorization: Bearer {token}
```

## Error Responses

### Validation Error
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password field is required."
        ]
    }
}
```

### Authentication Error
```json
{
    "message": "Unauthenticated."
}
```

### Not Found Error
```json
{
    "message": "No query results for model [App\\Models\\User] 1"
}
```

## Rate Limiting

- 60 requests per minute per IP address
- Rate limit headers included in response:
  ```
  X-RateLimit-Limit: 60
  X-RateLimit-Remaining: 59
  X-RateLimit-Reset: 1612345678
  ```

## Pagination

All list endpoints support pagination with the following query parameters:
- `page`: Page number (default: 1)
- `per_page`: Items per page (default: 15, max: 100)

## Filtering

Supported filter parameters:
- `search`: Search in name and email fields
- `sort`: Sort by field (e.g., `sort=name` or `sort=-created_at` for descending)
- `filter`: Filter by specific fields (e.g., `filter[status]=active`)

## Response Format

All responses follow this structure:
```json
{
    "data": [],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "per_page": 15,
        "to": 1,
        "total": 1
    },
    "links": {
        "first": "http://api.example.com/resource?page=1",
        "last": "http://api.example.com/resource?page=1",
        "prev": null,
        "next": null
    }
}
``` 
