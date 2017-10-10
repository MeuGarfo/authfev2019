<?php
/**
* User: Anderson Ismael
* Date: 19/set/2017
*/
namespace Basic;

use Medoo\Medoo;

class Auth
{
    private $db;

    function __construct($db){
        $this->set_db(($db));
    }
    private function set_db($db){
        $this->db = new Medoo([
            // required
            'database_type' => 'mysql',
            'database_name' => $db['name'],
            'server' => $db['server'],
            'username' => $db['user'],
            'password' => $db['password'],
            // [optional]
            'charset' => 'utf8',
            'port' => 3306
        ]);
    }
    public function is_auth(){
        if(!isset($_COOKIE['id'])){
            return false;
        }
        if(!isset($_COOKIE['token'])){
            return false;
        }
        $where['AND']=[
            'id'=>@$_COOKIE['id'],
            'token'=>@$_COOKIE['token']
        ];
        $user=$this->db->get('user','*', $where);
        if (isset($user['token_expiration'])) {
            if ($user['token_expiration']>time()) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function logout(){
        $user=$this->is_auth();
        setcookie("token", "", time()-3600,'/');
        setcookie("id", "", time()-3600,'/');
        if($user){
            $data=[
                'token_expiration'=>time()-3600
            ];
            $this->db->update('user', $data, ['id'=>$user['id']]);
        }
        return true;
    }
    public function signin(){
        $this->logout();
        $email=@$_POST['email'];
        $password=@$_POST['password'];
        $error=false;
        $where=[
            'email'=>$email
        ];
        $user=$this->db->get('user','*',$where);
        if(!$user){
            $error[]='invalid_email';
        }
        if (password_verify($password, $user['password'])) {
            $id=$user['id'];
            $min=60;
            $hora=60*$min;
            $dia=24*$hora;
            $ano=365*$dia;
            $limit=time()+(2*$ano);
            $token=bin2hex(openssl_random_pseudo_bytes(32));
            $data=[
                'token'=>$token,
                'token_expiration'=>$limit
            ];
            $this->db->update('user', $data, ['id'=>$id]);
            setcookie("id", $id, $limit,'/');
            setcookie("token", $token, $limit,'/');
            return $this->db->get("user","*",['id'=>$id]);
        } else {
            $error[]='invalid_password';
        }
        if($error){
            return ['error'=>$error];
        }
    }
    public function signup($user=false){
        $this->logout();
        $user['created_at']=time();
        if($user===false){
            $user=[
                'name'=>@$_POST['name'],
                'email'=>@$_POST['email'],
                'password'=>@$_POST['password']
            ];
        }
        $user['name']=trim($user['name']);
        $user['name']=strtolower($user['name']);
        $user['name']=ucfirst($user['name']);
        $user['name']=preg_replace('/\s+/', ' ',$user['name']);
        $error=false;
        if(preg_match('/^[a-z0-9 .\-]+$/i', $user['name']) && strlen($user['name'])>=3){
            if (filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
                if(strlen($user['password'])>=8){
                    $user['password']=password_hash($user['password'], PASSWORD_DEFAULT);
                    if ($this->db->get('user','*', ['email'=>$user['email']])) {
                        $error[]='invalid_email';
                    } else {
                        $data=[
                            'email'=>$user['email'],
                            'name'=>$user['name'],
                            'password'=>$user['password']
                        ];
                        if(isset($user['type'])){
                            $user['type']=trim(strtolower($user['type']));
                            if(
                                $user['type']=='admin' ||
                                $user['type']=='super' ||
                                $user['type']=='user'
                            ){
                                $data['type']=$user['type'];
                            }else{
                                $data['type']='user';
                            }
                        }
                        $this->db->insert('user', $data);
                        $id=$this->db->id();
                        if(is_numeric($id) && $id<>0){
                            if(isset($_POST['email']) && isset($_POST['password'])){
                                $this->signin();
                            }else{
                                return $id;
                            }
                        }else{
                            return false;
                        }
                    }
                }else{
                    $error[]='invalid_password';
                }
            }else{
                $error[]='invalid_email';
            }
        }else{
            $error[]='invalid_name';
        }
        if($error){
            return ['error'=>$error];
        }
    }
}
