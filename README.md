# auth
:lock: Sistema básico de autenticação

## Composer
	composer require basicauth/basicauth

## Instalação
```
<?php
require 'vendor/autoload.php';
user Basic\Auth;
$db=[
	'db_server'=>'localhost',
	'db_name'=>'test',
	'db_user'=>'root',
	'db_password'=>''
];
$BasicAuth=new Auth($db);
```

## Tabela user
```
id
email
name
password
token
token_expiration
```

## Dados do usuário
Retorna os dados do usuário ou false

	$user=$BasicAuth->isAuth();

## Logout
Retorna sempre true

	$user=$BasicAuth->logout();

## Signup
Campos $_POST requeridos:
```
name
email
password
```

Retorna os dados do usuário ou um array com as mensagens de erro

	$user=BasicAuth->signup();

## Mensagens de erro de signup
- invalid_name (apenas letras, números e espaços)
- invalid_email
- invalid_password (maior ou igual a 8 caracteres)

## Signin
Campos $_POST requeridos:
```
email
password
```

Retorna os dados do usuário ou um array com as mensagens de erro

	$user=$BasicAuth->signin();

## Mensagens de erro de signin
- invalid_email
- invalid_password
