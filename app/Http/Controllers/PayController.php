<?php

namespace App\Http\Controllers;
use YandexCheckout\Client;
use App\Orders;
use App\Users;
use App\RegisterUser;
use App\InstructorsInfo;

use Illuminate\Http\Request;

class PayController extends Controller
{
	// private $secretKey = 'test_iaXZOuwxjtLPDIYVxjgFzgzB9LzIuEQYyXdadPremV4';
	// private $shopId = '518585';

    private $secretKey = 'live_CoP04Q7AQymyr-6GxhyBwhOpSJ7VzFGZMx5iMfixb20';
    private $shopId = '516957';

    public function index(Request $request)
    {
        $url = 'http://83.217.216.218:16732/test-connection';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);

        if( curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200)
        {
            curl_close($ch);
            return redirect('/technical-break');
        }
        curl_close($ch);

    	$client = new Client();
		$client->setAuth($this->shopId, $this->secretKey);
		$idempotenceKey = uniqid('', true);
		$response = $client->createPayment(
		  array(
		      'amount' => array(
		          'value' => 850,
		          'currency' => 'RUB',
		      ),
		      'confirmation' => array(
		          'type' => 'redirect',
		          'return_url' => 'https://lk.pulsauto.ru/',
		      ),
		      'capture' => true,
		      'description' => 'Оплата вождения в автошколе Пульс',
		  ),
		  $idempotenceKey
		);


		$order = new Orders();
		$order->data = $request->data;
		$order->time = $request->time;
        $order->week = $request->week;
		$order->order_data = "";
		$order->instructors_id = $request->instructor;
		$order->users_id = $request->user;
		$order->uuid = $response['id'];
		$order->order_status = "";
		$order->order_info = "";
		$order->notification = false;
		$order->save();

    	return redirect($response->confirmation->confirmation_url);
    }

    public function checkurl(Request $request)
    {
  		$source = file_get_contents('php://input');
  		$json = json_decode($source, true);

  		if($json['object']['status'] == 'succeeded'){
  			$order = Orders::where('uuid', $json['object']['id'])->first();
            if($order != null)
            {
                if($order->notification == 0)
                {
                    $order->order_info = json_encode($json);
                    $order->notification = true;
                    $order->order_status = "Оплаченно Яндекс";
                    $order->save();

                    $this->table_entry($order);

                    $user = Users::find($order->users_id);
                    $url = "http://83.217.216.218:16732/online-check?email=".$user->login."&sum=850";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    return $output;
                }
            }

            $useritem = RegisterUser::where('uuid', $json['object']['id'])->first();
            if($useritem != null)
            {
                if($useritem->notification == 0)
                {
                    $useritem->order_info = json_encode($json);
                    $useritem->notification = true;
                    $useritem->save();

                    $url = "http://email.pulsauto.ru/api?form=Запись%20в%20школу&phone=".str_replace(' ','%20',$useritem->phone)."&name=".str_replace(' ','%20',$useritem->fio)."&email=".$useritem->email."&group=".str_replace(' ','%20',$useritem->group)."&uuid=".str_replace(' ','%20',$useritem->uuid)."&price=".str_replace(' ','%20',$useritem->price);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $url = "http://email.pulsauto.ru/api/user?group=".str_replace(' ','%20',$useritem->group)."&name=".str_replace(' ','%20',$useritem->fio)."&email=".$useritem->email;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $url = "http://83.217.216.218:16732/online-check?email=".$useritem->email."&sum=".$useritem->price;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    return $output;
                }
            }
  		} 
    }


    public function table_entry($order)
    {
    	$instructor = InstructorsInfo::where('users_id', $order->instructors_id)->first();
    	$schedule = json_decode($instructor->instructors_worktime, true);

    	$date = $order->data;
    	$time = $order->time;
        $week = $order->week;

        for($i=0;$i<8;$i++)
        {
            for($j=0;$j<7;$j++)
            {
                if($schedule['arrDay'][$week-1][$j]['date'] == $date)
                {
                    if($schedule['arrDay'][$week-1][$j]['timeWork'][$i]['time'] == $time){
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status'] = "Занято";
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['user'] = Users::find($order->users_id)->name;
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['id_order'] = $order->id;
                        $schedule['arrDay'][$week-1][$j]['timeWork'][$i]['status_order'] = "Оплачено Яндекс";
                    }
                }
            }
        }
    	$instructor->instructors_worktime = json_encode($schedule);
    	$instructor->save();
    	return;
    }

    public function avisourl(Request $request)
    {

    	return;	
    }

    public function shopsuccessurl(Request $request)
    {

    	return view('pay_shopsuccessurl');	
    }

    public function shopfailurl(Request $request)
    {

    	return view('pay_shopfailurl');	
    }

    public function testOnlineKassa(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://83.217.216.218:16732/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function open_session()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://83.217.216.218:16732/open-session");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;                                                                                                              
                                                                                                                     
        $result = curl_exec($ch);
        return $result;
    }

    public function clouse_session()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://83.217.216.218:16732/clouse-session");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;                                                                                                              
                                                                                                                     
        $result = curl_exec($ch);
        return $result;
    }

    public function technical_break()
    {
        $token = $_COOKIE['token'];
        $user = Users::where('token', $token)->first();
        $role = $user->role;
        return view('technical_break',[
            'role'=>$role,
        ]);
    }
}