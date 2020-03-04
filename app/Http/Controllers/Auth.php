<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users as user;
use App\RegisterUser;
use YandexCheckout\Client;

class Auth extends Controller
{
    private $secretKey = 'live_CoP04Q7AQymyr-6GxhyBwhOpSJ7VzFGZMx5iMfixb20';
    private $shopId = '516957';

    public function index(){
    	return view('login');
    }

    public function login(Request $request){
        $login = $request->input('login');
        $pass = $request->input('password');
        $user = user::where('login', $login)->first();
        if ($user != null){
            $createToken = hash('md5', $login.$user->sold.$pass);
            if (strcmp($createToken, $user->token) == 0){
                setcookie('token', $createToken);
                setcookie('login', $login);

                return redirect('/profile');
            }
            else{
                return redirect('/');
            }
        }
        return redirect('/');
    }

    public function register(Request $request)
    {
        $url = 'http://83.217.216.218:16732/test-connection';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if( curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200)
        {
            curl_close($ch);
            return view('service-unavailable');
        }
        curl_close($ch);

        if($request->method() == 'POST'){
            $client = new Client();
            $client->setAuth($this->shopId, $this->secretKey);
            $idempotenceKey = uniqid('', true);
            $response = $client->createPayment(
              array(
                  'amount' => array(
                      'value' => $request->input('price'),
                      'currency' => 'RUB',
                  ),
                  'confirmation' => array(
                      'type' => 'redirect',
                      'return_url' => 'https://pulsauto.ru/',
                  ),
                  'capture' => true,
                  'description' => 'Запись в автошколу',
              ),
              $idempotenceKey
            );

            $item = new RegisterUser();
            $item->fio = $request->input('fio');
            $item->phone = $request->input('phone');
            $item->email = $request->input('email');
            $item->group = $request->input('group');
            $item->price = $request->input('price');
            $item->notification = 0;
            $item->uuid = $response['id'];
            $item->order_info = '';
            $item->save();

            return redirect($response->confirmation->confirmation_url);
        }

        return view('register',[
            'price' => $request->price,
            'group' => $request->group,
        ]);
    }
    public function logout(){
        setcookie('token', '');
        setcookie('login', '');
        return redirect('/');
    }

}
