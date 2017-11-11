# auth
Sistema básico de autenticação

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
$Auth=new Auth($db);
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

	$user=$Auth->isAuth();

## Logout
Retorna sempre true

	$user=$Auth->logout();

## Signup
Campos $_POST requeridos:
```
name
email
password
```

Retorna os dados do usuário ou um array com as mensagens de erro

	$user=$Auth->signup();

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

	$user=$Auth->signin();

## Mensagens de erro de signin
- invalid_email
- invalid_password
