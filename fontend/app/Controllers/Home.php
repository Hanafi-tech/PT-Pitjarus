<?php

namespace App\Controllers;

use CodeIgniter\HTTP\CURLRequest;


class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }


    public function getArea()
    {
        $client = \Config\Services::curlrequest();

        $res = $client->request('get', 'http://localhost:5000/api/get-area', [
            'headers' => [
                'Accept'     => 'application/json',
                'x-no-authorization'      => '1',
            ],
        ]);

        echo json_encode(json_decode($res->getBody()));
    }

    public function getChart()
    {
        $client = \Config\Services::curlrequest();
        $request = \Config\Services::request();

        $res = $client->request('get', 'http://localhost:5000/api/data-chart?area=' . $request->getGet('area') . '&from=' . $request->getGet('from') . '&to=' . $request->getGet('to'), [
            'headers' => [
                'Accept'     => 'application/json',
                'x-no-authorization'      => '1',
            ],
        ]);

        echo json_encode(json_decode($res->getBody()));
    }

    public function getList()
    {
        $client = \Config\Services::curlrequest();
        $request = \Config\Services::request();

        $res = $client->request('get', 'http://localhost:5000/api/data-list?area=' . $request->getGet('area') . '&from=' . $request->getGet('from') . '&to=' . $request->getGet('to'), [
            'headers' => [
                'Accept'     => 'application/json',
                'x-no-authorization'      => '1',
            ],
        ]);

        $data = json_decode($res->getBody());

        $html = '';
        $htmlHead = '';
        $area_name = '';
        for ($i = 0; $i < count($data->brand); $i++) {
            $html .= '<tr>';
            $html .= '<td  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' . $data->brand[$i]->brand_name . '</td>';
            for ($j = 0; $j < count($data->list); $j++) {

                if ($data->list[$j]->brand_name == $data->brand[$i]->brand_name) {
                    if ($area_name != $data->list[$j]->area_name) {
                        $htmlHead .= '<th class="px-6 py-3">' . $data->list[$j]->area_name . '</th>';
                    }

                    $html .= '<td  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' . round($data->list[$j]->percent) . '</td>';
                }

                $area_name = $data->list[$j]->area_name;
            }
            $html .= '</tr>';
        }

        echo json_encode(['html' => $html, 'head' => $htmlHead]);
    }
}
