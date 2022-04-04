
# api profile

simple project for profile


## API Reference

#### register new user

```http
  POST /api/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required** |
| `email` | `string` | **Required** | **unique**
| `password` | `string` | **Required** |
| `password_confirmation` | `string` | **Required** |

#### login user

```http
  POST /api/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required** |
| `password` | `string` | **Required** |

#### logout user

```http
  POST /api/logout
```

#### update user

```http
  POST /api/edit_user
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name` | `string` | **optional** |
| `email` | `string` | **optional** | **unique**
| `phone` | `string` | **optional** |
| `age` | `string` | **optional** |
| `password` | `string` | **optional** |
| `address` | `string` | **optional** |
| `image` | `string` | **optional** |

#### delete user

```http
  delete /api/user
```

#### show all users

```http
  get /api/users
```

#### show one user

```http
  get /api/user
```




