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
$user=$BasicAuth->isAuth();
if($user){
	print 'Olá '.$user['name'];
}
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

## Erros de signin
- invalid_email
- invalid_password

## Erros de signup
- invalid_name (apenas letras, números e espaços)
- invalid_email
- invalid_password (maior ou igual a 8 caracteres)