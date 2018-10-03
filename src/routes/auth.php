<?php
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use Firebase\JWT\JWT;

$app->post('/auth/token', function(Request $request, Response $response, array $args){
    $data = $request->getParsedBody();
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    $user = User::where('email',$email)->first();
    var_dump($user->password);
    if(!is_null($user) and password_verify($password, $user->password)){
        $key = $this->get('settings')['secretKey'];

        return $response->withJson([
            'token' => JWT::encode($user, $key)
        ]);
    }

    return $response->withJson(['status' => 'error',401]);
});