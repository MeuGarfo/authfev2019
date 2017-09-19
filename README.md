# basicauth
:lock: Sistema básico de autenticação

## Composer
	composer require basicauth/basicauth
	
## Instalação
```
<?php
require 'vendor/autoload.php';
user BasicAuth\BasicAuth;
$db=[
	'server'=>'localhost',
	'name'=>'test',
	'user'=>'root',
	'password'=>''
];
$BasicAuth=new BasicAuth($db);
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
Retorna os dados do usuário ou um array com as mensagens de erro 

	$user=BasicAuth->signup();

## Mensagens de erro de signup
- invalid_name (apenas letras, números e espaços)
- invalid_email
- invalid_password (maior ou igual a 8 caracteres)

## Signin
Retorna os dados do usuário ou um array com as mensagens de erro 

	$user=$BasicAuth->signin();

## Mensagens de erro de signin
- invalid_email
- invalid_password

