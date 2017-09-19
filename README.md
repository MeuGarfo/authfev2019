# basicauth
:lock: Sistema básico de autenticação

## Tabela user
```
id
email
name
password
token
token_expiration
```

## Erros de signin
- invalid_email
- invalid_password

## Erros de signup
- invalid_name (letras, números e espaços)
- invalid_email
- invalid_password (maior ou igual a 8 caracteres)