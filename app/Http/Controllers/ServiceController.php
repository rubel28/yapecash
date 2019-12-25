<?php

namespace App\Http\Controllers;

use App\Facades\HttpClient\Http;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('formSubmitted', [
            'only' => [
                'confirmInternationalTopUpServices',
                'confirmMoneyTransferServices',
                'confirmTopUpServices',
            ],
        ]);

        $this->middleware('purchase.can', [
            'only' => [
                'getPayments',
            ],
        ]);

        $this->middleware('firstTime', ['except' => ['getChangeLogin', 'postChangeLogin']]);
    }

    public function getServices()
    {
        $services = Http::get('services');
        $services = parseApiResponse($services);
        if ($services['message'] === 'success') {
            $services = $services['services'];
            return $this->loadView('services.index', compact('services'));
        }
        return redirect('/logout');
    }

    public function getServiceDetails($id)
    {
        $data = [];
        $inputs = [
            'service_id' => $id
        ];
        $result = Http::get('service-details',$inputs);
        $service = parseApiResponse($result);
        $service = $service['service'];
        session(['service_name' => $service['name']]);
        session(['service_code' => $service['short_code']]);
        session(['service_type' => $service['type']]);
        session(['service_id' => $id]);

        $inputs['short_code'] = $service['short_code'];
        $operators = Http::get('service-operators',$inputs);
        $operators = parseApiResponse($operators);
        $data['operators'] = $operators['operators'];
        $data['packages'] = $operators['packages'];
        $data['countries'] = $operators['countries'];
        $data['transfer_modes'] = $operators['transfer_modes'];
        $amounts = Http::get('amounts',$inputs);
        $amounts = parseApiResponse($amounts);
        $data['amounts'] = $amounts['amounts'];

        switch ($service['short_code']) {
            case 'sg':
                $page = 'services.singapore_topup';
                break;
            case 'my':
                $page = 'services.malaysia_topup';
                break;
            case 'bangladesh_reload':
                $page = 'services.bangladesh_reload';
                break;
            case 'nepal_reload':

                $page = 'services.nepal_reload';
                break;
            case 'bd_mb_reload':
                $page = 'services.bd_mb_reload';
                break;
            case 'indo_pulsa':
                $page = 'services.indo_pulsa';
                break;
            case 'metro':
                $page = 'services.recipient';
                break;
            case 'recipient_wallet':
                $page = 'services.recipient.recipient_wallet';
                break;
            default:
                $page = 'services.'.$service['type'];
        }
        if($service['is_verified']) {
            if (session('is_verified') == 1) {
                return $this->loadView($page . '.index', $data);
            } else {
                return $this->loadView('services.verify_msg')->withErrors('Please verify your profile to use this service');
            }
        }else{
            return $this->loadView($page . '.index', $data);
        }
    }
    public function getRates($keyword)
    {
        $inputs = ['keyword' => $keyword];
        $services = Http::get('local-operator-rates',$inputs);
        $result = parseApiResponse($services);
        return $result;
    }
    public function getPulsaPackages($key)
    {
        $services = Http::get('pulsa-package');
        $services = parseApiResponse($services);
        if ($services['message'] === 'success' && array_key_exists($key, $services['data'])) {
            return response()->json(['message' => false, 'data' => $services['data'][$key]]);
        }
        return ['message' => 'Package Not found', 'data' => false];
    }
}