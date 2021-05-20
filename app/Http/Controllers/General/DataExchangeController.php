<?php

namespace App\Http\Controllers\General;

use App\DailyForm;
use App\Models\Minvodxoz\GvkObject;
use App\Models\Minvodxoz\Information;
use App\Models\Minvodxoz\ReservoirMonthlyDatas;
use App\Models\Gidromet\RejimGidropost;
use App\Models\Gidrogeologiya\GidrogeologiyaWellData;
use App\Models\Gidrogeologiya\GidrogeologiyaPlaceBirth;
use App\NewFormsModel;
use App\OperAmuForm;
use App\OperSirdForm;
use App\ReservoirForms;
use App\Models\Additional\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

class DataExchangeController extends Controller
{
    public function index(Request $request)
    {
        $postAttr = []; $result = []; $elements = [];  $r_month = [];  $formObjects = [];
        $r_days_in_month = ''; $r_year = '';  $form_id = null; $month = '';
        $unitsList = Unit::get();
        $forms = [
            '1' => trans('messages.Gidromet'),
            '2' => trans('messages.Minvodxoz'),
            '3' => trans('messages.Gidrogeologiya'),
        ];

        if(isset($request->form) && isset($request->month) && $request->elements){
            if($request->form == 1) {
                $elements = [
                    '1' => trans('messages.Operative Amu'),
                    '2' => trans('messages.Operative Sird'),
                    '3' => trans('messages.Rejim Gidro'),
                ];
            }
            if($request->form == 2) {
                $elements = [
                    '4' => trans('messages.Every Day Datas'),
                    '5' => trans('messages.Volume month reservoir'),
                ];
            }
            if($request->form == 3) {
                $elements = [
                    '6' => trans('messages.Place birth'),
                    '7' => trans('messages.Well'),
                ];
            }

            $postAttr = ['form' => $request->form, 'month' => $request->month, 'elements' => $request->elements];
            $r_year = date('Y',strtotime ($request->month));
            $r_month = date('n',strtotime ($request->month));
            $form_id = $request->form;
            $r_days_in_month = date('t',strtotime ($request->month));// shu oyda necha kun borligi
            $element = $request->elements;

            // 1) Оператив Амударё
            if($request->elements == 1) {

                $response = Curl::to(config('app.gidrometApiReport1'))
                    ->withData([
                        'api_token' => config('app.gidrometApiKey'),
                        'month' => $request->month,
                    ])
                    ->post();
                /*$response = '{
                    "success": true,
                    "message": "Оператив Амударё",
                    "data": {
                        "result": [
                            {
                                "date": "2019-10-01",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-01",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-02",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-02",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-03",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-03",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-04",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-04",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-05",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-05",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-06",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-06",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-07",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-07",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-08",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-08",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-09",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-09",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-10",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-10",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-11",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-11",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-12",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-12",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-13",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-13",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-14",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-14",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-15",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-15",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-16",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-16",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-17",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-17",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-18",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-18",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-19",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-19",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-20",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-20",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-21",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-21",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-22",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-22",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-23",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-23",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-24",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-24",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-25",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-25",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-26",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-26",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-27",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-27",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-28",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-28",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-29",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-29",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-30",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-30",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-31",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 2,
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-31",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 3,
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            }
                        ],
                        "formObjects": [
                            {
                                "id": 1,
                                "gvk_object_id": 2,
                                "order_number": "1",
                                "check": 1,
                                "year": 2019,
                                "created_at": "2021-03-02 14:39:31",
                                "updated_at": "2021-03-02 14:39:31",
                                "object": {
                                    "id": 2,
                                    "number": "1",
                                    "name": "Аму-Сурхон ИТҲБ,жами: (Сурхондарё)",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "id": 2,
                                "gvk_object_id": 3,
                                "order_number": "2",
                                "check": 1,
                                "year": 2019,
                                "created_at": "2021-03-02 14:39:31",
                                "updated_at": "2021-03-02 14:39:31",
                                "object": {
                                    "id": 3,
                                    "number": "2",
                                    "name": "    Суғоришга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            }
                        ]
                    }
                }';*/
                $response = json_decode($response, true);
                //dd($response);

                if($response['success']) {

                    Information::setOperAmuDatas($response['data'], $r_year, $r_month);
                    //$element = 1;
                    $month = $request->month;
                    $formObjects = $response['data']['formObjects'];
                    $objectId = [];
                    foreach($formObjects as $object) {
                        $objectId [] = $object['gvk_object_id'];
                    }

                    $allDatas = Information::whereIn('gvk_object_id', $objectId)
                        ->whereYear('date', $r_year)
                        ->whereMonth('date', $r_month)
                        ->orderByRaw("updated_at DESC, date ASC")
                        ->get();

                    foreach ($allDatas as $infor) {
                        $key = $infor->gvk_object_id . '_' . date('d_m_Y', strtotime($infor->date) );
                        $result[$key] = $infor->average;
                        $result[$key . '_sr' ] = $infor->value;
                        $result[$key . '_id'] = $infor->id;
                    }

                    return view('general.data-exchange.amu',compact (
                        'forms', 'elements', 'form_id', 'element', 'month', 'result', 'formObjects', 'r_days_in_month', 'r_month', 'r_year'
                    ));
                }
            }

            // 2) Оператив Сирдарё
            if($request->elements == 2) {

                $response = Curl::to(config('app.gidrometApiReport2'))
                    ->withData([
                        'api_token' => config('app.gidrometApiKey'),
                        'month' => $request->month,
                    ])
                    ->post();
                /*$response = '{
                    "success": true,
                    "message": "Оператив Сирдарё",
                    "data": {
                        "result": [
                            {
                                "date": "2019-10-16",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-17",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-18",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-19",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-20",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-21",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-22",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-23",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-24",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-25",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-26",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-27",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-28",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-29",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-30",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-31",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-01",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-01",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-02",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-02",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-03",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-03",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-04",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-04",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-05",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-05",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-06",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-06",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-07",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-07",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-08",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-08",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-09",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-09",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-10",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-10",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-11",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-11",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-12",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-12",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-13",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-13",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-14",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-14",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-15",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-15",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 5,
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-16",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-17",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-18",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-19",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-20",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-21",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-22",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-23",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-24",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-25",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-26",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-27",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-28",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-29",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-30",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "date": "2019-10-31",
                                "value": null,
                                "average": null,
                                "form_id": 1,
                                "gvk_object_id": 4,
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            }
                        ],
                        "formObjects": [
                            {
                                "id": 1,
                                "gvk_object_id": 4,
                                "order_number": "1",
                                "check": 1,
                                "year": 2019,
                                "created_at": "2021-03-02 14:39:31",
                                "updated_at": "2021-03-02 14:39:31",
                                "object": {
                                    "id": 4,
                                    "number": "3",
                                    "name": "    Бошқа эхтиёжларга",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            },
                            {
                                "id": 2,
                                "gvk_object_id": 5,
                                "order_number": "2",
                                "check": 1,
                                "year": 2019,
                                "created_at": "2021-03-02 14:39:31",
                                "updated_at": "2021-03-02 14:39:31",
                                "object": {
                                    "id": 5,
                                    "number": "4",
                                    "name": "Амударёдан, жами: +",
                                    "form_id": 1,
                                    "unit_id": 1,
                                    "type_id": 2,
                                    "created_at": "2019-09-27 18:05:50",
                                    "updated_at": "2019-09-27 18:05:50",
                                    "get": false,
                                    "set": false,
                                    "obj_id": null,
                                    "name_ru": null
                                }
                            }
                        ]
                    }
                }';*/
                $response = json_decode($response, true);

                if($response['success']) {

                    Information::setOperSirdDatas($response['data'], $r_year, $r_month);
                    //$element = 2;
                    $month = $request->month;
                    $formObjects = $response['data']['formObjects'];
                    $objectId = [];
                    foreach($formObjects as $object) {
                        $objectId [] = $object['gvk_object_id'];
                    }

                    $allDatas = Information::whereIn('gvk_object_id', $objectId)
                        ->whereYear('date', $r_year)
                        ->whereMonth('date', $r_month)
                        ->orderByRaw("updated_at DESC, date ASC")
                        ->get();

                    $result = [];
                    foreach ($allDatas as $infor) {
                        $key = $infor->gvk_object_id . '_' . date('d_m_Y', strtotime($infor->date) );
                        $result[$key] = $infor->average;
                        $result[$key . '_sr' ] = $infor->value;
                        $result[$key . '_id'] = $infor->id;
                    }

                    return view('general.data-exchange.sird-oper',compact (
                        'forms', 'elements', 'form_id', 'element', 'month', 'result', 'formObjects', 'r_days_in_month', 'r_month', 'r_year'
                    ));
                }
                else{
                    dd($response['message']);
                }
            }

            // 3) Режим гидропоста
            if($request->elements == 3) {
                $response = Curl::to(config('app.gidrometApiReport3'))
                    ->withData([
                        'api_token' => config('app.gidrometApiKey'),
                        'year' => $r_year,
                    ])
                    ->post();
                $response = json_decode($response, true);
                //dd($response);

                if($response['success']) {

                    RejimGidropost::setDatas($response['data'], $r_year);
                    $allDatas = $response['data'];
                    $year = $r_year;
                    //$element = 3;
                    $month = $request->month;

                    return view('general.data-exchange.gidro',compact (
                        'forms', 'elements', 'allDatas', 'year', 'form_id', 'element', 'month'
                    ));
                }
                else{
                    dd($response['message']);
                }
            }

            // 4) Ежедневные
            if($request->elements == 4) {

                $response = Curl::to(config('app.minvodxozApiReport4'))
                    ->withData([
                        'api_token' => config('app.minvodxozApiKey'),
                        'month' => $request->month,
                    ])
                    ->post();
                $response = json_decode($response, true);

                if($response['success']) {

                    Information::setDatas($response['data'], $r_year, $r_month);
                    $allDatas = $response['data'];
                    $year = $r_year;
                    //$element = 4;
                    $month = $request->month;
                    $day = date('d_m_Y', strtotime($request->month . '-01'));
                    $firstData = $allDatas[$day];

                    return view('general.data-exchange.daily',compact (
                        'forms', 'elements', 'allDatas', 'year', 'form_id', 'element', 'month', 'firstData'
                    ));
                }
                else{
                    dd($response['message']);
                }
            }

            // 5) Объемы в/х месячные
            if($request->elements == 5) {

                $response = Curl::to(config('app.minvodxozApiReport5'))
                    ->withData([
                        'api_token' => config('app.minvodxozApiKey'),
                        'year' => $r_year,
                    ])
                    ->post();
                $response = json_decode($response, true);

                if($response['success']) {

                    ReservoirMonthlyDatas::setDatas($response['data'], $r_year);
                    $allDatas = $response['data'];
                    $year = $r_year;
                    //$element = 5;
                    $month = $request->month;

                    return view('general.data-exchange.reservoir',compact (
                        'forms', 'elements', 'allDatas', 'year', 'form_id', 'element', 'month'
                    ));
                }
                else{
                    dd($response['message']);
                }
            }

            // 6) Место рождение
            if($request->elements == 6) {

                $response = Curl::to(config('app.gidrogeologiyaApiReport6'))
                    ->withData([
                        'api_token' => config('app.gidrogeologiyaApiKey'),
                        'year' => $r_year,
                    ])
                    ->post();
                // dd($response);
                /*$response = '{
                    "success": true,
                    "message": "Место рождение",
                    "data": [
                        {
                            "code": "6",
                            "name": "Ахангаранское",
                            "year": 2019,
                            "groundwater_resource": "1636.00",
                            "selection_from_approved_groundwater_reserves": "279.77",
                            "favcolor": "#b19cd8"
                        },
                        {
                            "code": "8",
                            "name": "Бухарское",
                            "year": 2019,
                            "groundwater_resource": "1964.00",
                            "selection_from_approved_groundwater_reserves": "1.69",
                            "favcolor": "#b3dfb5"
                        },
                        {
                            "code": "1",
                            "name": "Алмас-Варзыкское",
                            "year": 2019,
                            "groundwater_resource": "567.60",
                            "selection_from_approved_groundwater_reserves": "33.35",
                            "favcolor": "#80ffff"
                        },
                        {
                            "code": "9",
                            "name": "Верхнеплиоценовое",
                            "year": 2019,
                            "groundwater_resource": "397.40",
                            "selection_from_approved_groundwater_reserves": "5.10",
                            "favcolor": "#da6cd7"
                        },
                        {
                            "code": "2",
                            "name": "Алтыарык-Бешалышское",
                            "year": 2019,
                            "groundwater_resource": "2492.60",
                            "selection_from_approved_groundwater_reserves": "375.89",
                            "favcolor": "#32c83c"
                        },
                        {
                            "code": "3",
                            "name": "Амударьинское",
                            "year": 2019,
                            "groundwater_resource": "358.50",
                            "selection_from_approved_groundwater_reserves": "30.16",
                            "favcolor": "#7c4587"
                        },
                        {
                            "code": "5",
                            "name": "Арасайское",
                            "year": 2019,
                            "groundwater_resource": null,
                            "selection_from_approved_groundwater_reserves": "1.57",
                            "favcolor": "#db8a8a"
                        },
                        {
                            "code": "4",
                            "name": "Андижан-Шахриханское",
                            "year": 2019,
                            "groundwater_resource": "319.70",
                            "selection_from_approved_groundwater_reserves": "500.16",
                            "favcolor": "#ae3737"
                        },
                        {
                            "code": "45",
                            "name": "Нарынское",
                            "year": 2019,
                            "groundwater_resource": "882.40",
                            "selection_from_approved_groundwater_reserves": "15.71",
                            "favcolor": "#e6ec93"
                        },
                        {
                            "code": "46",
                            "name": "Нижне-Санзарское",
                            "year": 2019,
                            "groundwater_resource": "259.00",
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#ddaa3c"
                        },
                        {
                            "code": "47",
                            "name": "Нижнеамударьинское правобережное",
                            "year": 2019,
                            "groundwater_resource": "1895.60",
                            "selection_from_approved_groundwater_reserves": "2.40",
                            "favcolor": "#c29961"
                        },
                        {
                            "code": "50",
                            "name": "Ош-Араванское",
                            "year": 2019,
                            "groundwater_resource": "1684.80",
                            "selection_from_approved_groundwater_reserves": "82.06",
                            "favcolor": "#f28c54"
                        },
                        {
                            "code": "48",
                            "name": "Нижнеамударьинское левобережное",
                            "year": 2019,
                            "groundwater_resource": "1357.40",
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#f09642"
                        },
                        {
                            "code": "51",
                            "name": "Пашхуртское",
                            "year": 2019,
                            "groundwater_resource": "124.40",
                            "selection_from_approved_groundwater_reserves": "3.54",
                            "favcolor": "#f78282"
                        },
                        {
                            "code": "42",
                            "name": "Минбулакское",
                            "year": 2019,
                            "groundwater_resource": "166.70",
                            "selection_from_approved_groundwater_reserves": "22.35",
                            "favcolor": "#834d21"
                        },
                        {
                            "code": "36",
                            "name": "Кызылкакское",
                            "year": 2019,
                            "groundwater_resource": "19.90",
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#a98914"
                        },
                        {
                            "code": "37",
                            "name": "Левобережное",
                            "year": 2019,
                            "groundwater_resource": "92.50",
                            "selection_from_approved_groundwater_reserves": "0.18",
                            "favcolor": "#e83b89"
                        },
                        {
                            "code": "39",
                            "name": "Лякат-Саватское",
                            "year": 2019,
                            "groundwater_resource": "45.00",
                            "selection_from_approved_groundwater_reserves": "1.40",
                            "favcolor": "#7186a2"
                        },
                        {
                            "code": "40",
                            "name": "Лянгарское",
                            "year": 2019,
                            "groundwater_resource": "17.30",
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#569a9f"
                        },
                        {
                            "code": "41",
                            "name": "Майлисуйское",
                            "year": 2019,
                            "groundwater_resource": "884.70",
                            "selection_from_approved_groundwater_reserves": "14.66",
                            "favcolor": "#1c7273"
                        },
                        {
                            "code": "49",
                            "name": "Нуратинское",
                            "year": 2019,
                            "groundwater_resource": "247.10",
                            "selection_from_approved_groundwater_reserves": "42.48",
                            "favcolor": "#f3c396"
                        },
                        {
                            "code": "10",
                            "name": "Восточно-Кызылкумское",
                            "year": 2019,
                            "groundwater_resource": "95.00",
                            "selection_from_approved_groundwater_reserves": "5.91",
                            "favcolor": "#6a76d2"
                        },
                        {
                            "code": "7",
                            "name": "Бузаубайское",
                            "year": 2019,
                            "groundwater_resource": "64.80",
                            "selection_from_approved_groundwater_reserves": "0.50",
                            "favcolor": "#a5b814"
                        },
                        {
                            "code": "15",
                            "name": "Горные массивы",
                            "year": 2019,
                            "groundwater_resource": null,
                            "selection_from_approved_groundwater_reserves": "1.83",
                            "favcolor": "#8e2e8b"
                        },
                        {
                            "code": "18",
                            "name": "Гузарское",
                            "year": 2019,
                            "groundwater_resource": "136.50",
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#83b1b4"
                        },
                        {
                            "code": "28",
                            "name": "Караунгурское",
                            "year": 2019,
                            "groundwater_resource": "582.30",
                            "selection_from_approved_groundwater_reserves": "15.27",
                            "favcolor": "#9a60f0"
                        },
                        {
                            "code": "30",
                            "name": "Кафирниганское",
                            "year": 2019,
                            "groundwater_resource": "126.10",
                            "selection_from_approved_groundwater_reserves": "0.15",
                            "favcolor": "#76c7f9"
                        },
                        {
                            "code": "31",
                            "name": "Китабо-Шахрисабское",
                            "year": 2019,
                            "groundwater_resource": "919.30",
                            "selection_from_approved_groundwater_reserves": "429.90",
                            "favcolor": "#2ead87"
                        },
                        {
                            "code": "16",
                            "name": "Горные массивы Каратюбинских гор",
                            "year": 2019,
                            "groundwater_resource": null,
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#5a58da"
                        },
                        {
                            "code": "32",
                            "name": "Кокаральское",
                            "year": 2019,
                            "groundwater_resource": "88.00",
                            "selection_from_approved_groundwater_reserves": "5.07",
                            "favcolor": "#b1e0ec"
                        },
                        {
                            "code": "38",
                            "name": "Левобережное",
                            "year": 2019,
                            "groundwater_resource": null,
                            "selection_from_approved_groundwater_reserves": "62.35",
                            "favcolor": "#d03ae4"
                        },
                        {
                            "code": "27",
                            "name": "Каракульское",
                            "year": 2019,
                            "groundwater_resource": "459.60",
                            "selection_from_approved_groundwater_reserves": "0.02",
                            "favcolor": "#f29ce7"
                        },
                        {
                            "code": "43",
                            "name": "Наманганское",
                            "year": 2019,
                            "groundwater_resource": "578.90",
                            "selection_from_approved_groundwater_reserves": "8.33",
                            "favcolor": "#2bb6a6"
                        },
                        {
                            "code": "19",
                            "name": "Дальверзинское",
                            "year": 2019,
                            "groundwater_resource": "803.00",
                            "selection_from_approved_groundwater_reserves": "11.29",
                            "favcolor": "#e0da9a"
                        },
                        {
                            "code": "21",
                            "name": "Западно-Кашкадарьинское",
                            "year": 2019,
                            "groundwater_resource": "115.80",
                            "selection_from_approved_groundwater_reserves": "0.16",
                            "favcolor": "#3f51d9"
                        },
                        {
                            "code": "29",
                            "name": "Касансайское",
                            "year": 2019,
                            "groundwater_resource": "248.80",
                            "selection_from_approved_groundwater_reserves": "17.54",
                            "favcolor": "#0e7fe1"
                        },
                        {
                            "code": "44",
                            "name": "Нанайское",
                            "year": 2019,
                            "groundwater_resource": "90.70",
                            "selection_from_approved_groundwater_reserves": "4.69",
                            "favcolor": "#87c945"
                        },
                        {
                            "code": "17",
                            "name": "Горные массивы Южно-Нуратинских гор",
                            "year": 2019,
                            "groundwater_resource": null,
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#42aea7"
                        },
                        {
                            "code": "22",
                            "name": "Современная долина реки Зарафшан",
                            "year": 2019,
                            "groundwater_resource": "2151.10",
                            "selection_from_approved_groundwater_reserves": "907.59",
                            "favcolor": "#85ec83"
                        },
                        {
                            "code": "13",
                            "name": "Восточно-Северо-Восточное Кызылкумское N",
                            "year": 2019,
                            "groundwater_resource": null,
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#e641cb"
                        },
                        {
                            "code": "24",
                            "name": "Исфаринское",
                            "year": 2019,
                            "groundwater_resource": "719.70",
                            "selection_from_approved_groundwater_reserves": "27.80",
                            "favcolor": "#ed51f0"
                        },
                        {
                            "code": "14",
                            "name": "Галляаральское",
                            "year": 2019,
                            "groundwater_resource": "47.00",
                            "selection_from_approved_groundwater_reserves": "3.85",
                            "favcolor": "#901818"
                        },
                        {
                            "code": "12",
                            "name": "Восточно-Северо-Восточное Кызылкумское K",
                            "year": 2019,
                            "groundwater_resource": "99.40",
                            "selection_from_approved_groundwater_reserves": null,
                            "favcolor": "#af533c"
                        },
                        {
                            "code": "20",
                            "name": "Зааминское",
                            "year": 2019,
                            "groundwater_resource": "155.00",
                            "selection_from_approved_groundwater_reserves": "19.98",
                            "favcolor": "#7d4691"
                        },
                        {
                            "code": "23",
                            "name": "Исковат-Пишкаранское",
                            "year": 2019,
                            "groundwater_resource": "375.00",
                            "selection_from_approved_groundwater_reserves": "140.78",
                            "favcolor": "#fd3e1c"
                        },
                        {
                            "code": "26",
                            "name": "Каракатинское",
                            "year": 2019,
                            "groundwater_resource": "179.10",
                            "selection_from_approved_groundwater_reserves": "2.04",
                            "favcolor": "#b82e8c"
                        },
                        {
                            "code": "33",
                            "name": "Кокчинское",
                            "year": 2019,
                            "groundwater_resource": "323.00",
                            "selection_from_approved_groundwater_reserves": "0.38",
                            "favcolor": "#b3efb7"
                        },
                        {
                            "code": "11",
                            "name": "Восточно-Кызылкумское",
                            "year": 2019,
                            "groundwater_resource": "56.00",
                            "selection_from_approved_groundwater_reserves": "2.40",
                            "favcolor": "#cd5656"
                        },
                        {
                            "code": "34",
                            "name": "Кошрабадское",
                            "year": 2019,
                            "groundwater_resource": "139.10",
                            "selection_from_approved_groundwater_reserves": "7.76",
                            "favcolor": "#b5ed1d"
                        },
                        {
                            "code": "35",
                            "name": "Кукумбайское",
                            "year": 2019,
                            "groundwater_resource": "7.80",
                            "selection_from_approved_groundwater_reserves": "2.97",
                            "favcolor": "#d3f915"
                        }
                    ]
                }';*/
                $response = json_decode($response, true);

                if($response['success']) {


                    GidrogeologiyaPlaceBirth::setDatas($response['data'], $r_year);
                    $allDatas = $response['data'];
                    $year = $r_year;
                    //$element = 6;
                    $month = $request->month;

                    return view('general.data-exchange.place-birth',compact (
                        'forms', 'elements', 'allDatas', 'year', 'form_id', 'element', 'month'
                    ));
                }
                else{
                    dd($response['message']);
                }
            }

            // 7) Скважина
            if($request->elements == 7) {

                $response = Curl::to(config('app.gidrogeologiyaApiReport7'))
                    ->withData([
                        'api_token' => config('app.gidrogeologiyaApiKey'),
                        'year' => $r_year,
                    ])
                    ->post();
                /*$response = '{
                    "success": true,
                    "message": "Скважина",
                    "data": [
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "304",
                            "cadaster_number": "1726517",
                            "mineralization": "0.67"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "ПК-5М (2н)",
                            "cadaster_number": "1726563",
                            "mineralization": "0.69"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "ПК-3М (1н)",
                            "cadaster_number": "1726562",
                            "mineralization": "0.69"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "скв.20/4",
                            "cadaster_number": "1726560",
                            "mineralization": "0.69"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "20-з",
                            "cadaster_number": "1726537",
                            "mineralization": "0.41"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "303",
                            "cadaster_number": "1726516",
                            "mineralization": "0.38"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "18/132",
                            "cadaster_number": "1726559",
                            "mineralization": "0.69"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "1т(1н)",
                            "cadaster_number": "1726515",
                            "mineralization": "0.37"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "ПК-2М (1н)",
                            "cadaster_number": "1726561",
                            "mineralization": "0.69"
                        },
                        {
                            "wells_type_id": 5,
                            "type_name": "наблюдательный",
                            "year": 2020,
                            "number_auther": "8А",
                            "cadaster_number": "1726558",
                            "mineralization": "0.69"
                        }
                    ]
                }';*/
                $response = json_decode($response, true);

                if($response['success']) {
                    //dd($response['data']);

                    GidrogeologiyaWellData::setDatas($response['data'], $r_year);
                    $allDatas = $response['data'];
                    $year = $r_year;
                    //$element = 7;
                    $month = $request->month;

                    return view('general.data-exchange.well-data',compact (
                        'forms', 'elements', 'allDatas', 'year', 'form_id', 'element', 'month'
                    ));
                }
                else{
                    dd($response['message']);
                }
            }
        }

        return view('general.data-exchange.index',compact (
            'forms', 'result', 'elements', 'formObjects',  'postAttr',
            'r_days_in_month', 'r_month', 'r_year',  'unitsList', 'form_id', 'month'
        ));
    }


    public function SirdForm(Request $request)
    {
        $year = $request->year;
        if(!(bool)strtotime($year . '-01-01')) {
            return view('data-exchange.error_form',compact (
                'year'
            ));
        }
        $form = OperSirdForm::where('year', $year)->get()->first();
        $form_id = $request->form;
        $elements = $request->elements;
        $month = $request->month;

        if($form == null) {
            $form = OperSirdForm::orderBy('year', 'desc')->get()->first();
            if($form != null) {
                $forms = OperSirdForm::where('year', $form->year)->orderBy('order_number')->get();
                $i = 0;
                $array = array();
                foreach ($forms as $value) {
                    $i++;
                    $new = array(
                        'year' => $year,
                        'order_number' => $i,
                        'check' => 1,
                        'gvk_object_id' => $value->gvk_object_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $array [] = $new;
                }
                if(count($array) > 0) DB::table('oper_sird_forms')->insert($array);
                $forms = OperSirdForm::where('year', $year)->orderBy('order_number')->get();
            }
        }
        else{
            $forms = OperSirdForm::where('year', $year)->orderBy('order_number')->get();
        }

        $object_id = [];
        $objects = GvkObject::get();
        foreach ($objects as $object) {
            $is_yes = false;
            foreach ($forms as $value) {
                if($object->id == $value->stat_object_id) $is_yes = true;
            }
            if($is_yes == false) $object_id [] = $object->id;
        }
        $existObject = GvkObject::whereIn('id', $object_id)->get();
        $allForms = NewFormsModel::get();
        $unitsList = Unit::get();

        return view('general.data-exchange.sird_form',compact (
            'year',
            'existObject',
            'forms',
            'form_id',
            'allForms',
            'unitsList',
            'elements',
            'month'
        ));
    }

    public function deleteObjFromRes(Request $request)
    {
        $res = ReservoirForms::find($request->id);
        $res->delete();
        return back ();
    }

    public function deleteObjFromSird(Request $request)
    {
        $sird = OperSirdForm::find($request->id);
        $sird->delete();
        return back ();
    }

    public function deleteObjFromAmu(Request $request)
    {
        $amu = OperAmuForm::find($request->id);
        $amu->delete();
        return back ();
    }

    public function deleteObjFromDaily(Request $request)
    {
        $daily = DailyForm::find($request->id);
        $daily->delete();
        return back ();
    }

    public function AjaxChangeSird(Request $request)
    {
        if($request->page == 'sird') {
            $sird = OperSirdForm::find($request->id);
            if($request->field == 'name_ru') {
                $obj = GvkObject::where('id', $sird->gvk_object_id)->get()->first();
                $obj->name_ru = $request->value;
                $obj->save();
            }
            if($request->field == 'name') {
                $obj = GvkObject::where('id', $sird->gvk_object_id)->get()->first();
                $obj->name = $request->value;
                $obj->save();
            }
            if($request->field == 'order_number') $sird->order_number = $request->value;
            if($request->field == 'check') {
                if($request->value == '1') $sird->check = 1;
                else $sird->check = 0;
            }
            $sird->save();
            return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
        }
        if($request->page == 'amu') {
            $amu = OperAmuForm::find($request->id);
            if($request->field == 'name_ru') {
                $obj = GvkObject::where('id', $amu->gvk_object_id)->get()->first();
                $obj->name_ru = $request->value;
                $obj->save();
            }
            if($request->field == 'name') {
                $obj = GvkObject::where('id', $amu->gvk_object_id)->get()->first();
                $obj->name = $request->value;
                $obj->save();
            }
            if($request->field == 'order_number') $amu->order_number = $request->value;
            if($request->field == 'check') {
                if($request->value == '1') $amu->check = 1;
                else $amu->check = 0;
            }
            $amu->save();
            return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
        }

        if($request->page == 'reservoir') {
            $reservoir = ReservoirForms::find($request->id);
            if($request->field == 'name_ru') {
                $obj = GvkObject::where('id', $reservoir->gvk_object_id)->get()->first();
                $obj->name_ru = $request->value;
                $obj->save();
            }
            if($request->field == 'name') {
                $obj = GvkObject::where('id', $reservoir->gvk_object_id)->get()->first();
                $obj->name = $request->value;
                $obj->save();
            }
            if($request->field == 'order_number') $reservoir->order_number = $request->value;
            if($request->field == 'check') {
                if($request->value == '1') $reservoir->check = 1;
                else $reservoir->check = 0;
            }
            $reservoir->save();
            return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
        }

        if($request->page == 'daily') {
            $daily = DailyForm::find($request->id);
            if($request->field == 'name_ru') {
                $obj = GvkObject::where('id', $daily->gvk_object_id)->get()->first();
                $obj->name_ru = $request->value;
                $obj->save();
            }
            if($request->field == 'name') {
                $obj = GvkObject::where('id', $daily->gvk_object_id)->get()->first();
                $obj->name = $request->value;
                $obj->save();
            }
            if($request->field == 'order_number') $daily->order_number = $request->value;
            if($request->field == 'check') {
                if($request->value == '1') $daily->check = 1;
                else $daily->check = 0;
            }
            if($request->field == 'morning') {
                if($request->value == '1') $daily->morning = 1;
                else $daily->morning = 0;
            }
            if($request->field == 'present') {
                if($request->value == '1') $daily->present = 1;
                else $daily->present = 0;
            }
            $daily->save();
            return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
        }
    }

    public function AjaxSelectElement(Request $request)
    {
        if($request->value == '1') {
            echo '<option value="1">' . trans('messages.Operative Amu') . '</option>';
            echo '<option value="2">' . trans('messages.Operative Sird') . '</option>';
            echo '<option value="3">' . trans('messages.Rejim Gidro') . '</option>';
        }

        if($request->value == '2') {
            echo '<option value="4">' . trans('messages.Every Day Datas') . '</option>';
            echo '<option value="5">' . trans('messages.Volume month reservoir') . '</option>';
        }

        if($request->value == '3') {
            echo '<option value="6">' . trans('messages.Place birth') . '</option>';
            echo '<option value="7">' . trans('messages.Well') . '</option>';
        }
    }

    public function AmuForm(Request $request)
    {
        $year = $request->year;
        if(!(bool)strtotime($year . '-01-01')) {
            return view('general.data-exchange.error_form',compact (
                'year'
            ));
        }
        $form_id = $request->form;
        $elements = $request->elements;
        $month = $request->month;
        $form = OperAmuForm::where('year', $year)->get()->first();
        if($form == null) {
            $form = OperAmuForm::orderBy('year', 'desc')->get()->first();
            if($form != null) {
                $forms = OperAmuForm::where('year', $form->year)->orderBy('order_number')->get();
                $i = 0;
                $array = array();
                foreach ($forms as $value) {
                    $i++;
                    $new = array(
                        'year' => $year,
                        'order_number' => $i,
                        'check' => 1,
                        'gvk_object_id' => $value->gvk_object_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $array [] = $new;
                }
                if(count($array) > 0) DB::table('oper_amu_forms')->insert($array);
                $forms = OperAmuForm::where('year', $year)->orderBy('order_number')->get();
            }
        }
        else{
            $forms = OperAmuForm::where('year', $year)->orderBy('order_number')->get();
        }

        $object_id = [];
        $objects = GvkObject::get();
        foreach ($objects as $object) {
            $is_yes = false;
            foreach ($forms as $value) {
                if($object->id == $value->stat_object_id) $is_yes = true;
            }
            if($is_yes == false) $object_id [] = $object->id;
        }
        $existObject = GvkObject::whereIn('id', $object_id)->get();

        $allForms = NewFormsModel::get();
        $unitsList = Unit::get();
        return view('general.data-exchange.amu_form',compact (
            'year',
            'existObject',
            'forms',
            'form_id',
            'allForms',
            'unitsList',
            'elements',
            'month'
        ));
    }

    public function ReservoirForm(Request $request)
    {
        $year = $request->year;
        if(!(bool)strtotime($year . '-01-01')) {
            return view('general.data-exchange.error_form',compact (
                'year'
            ));
        }
        $form_id = $request->form;
        $elements = $request->elements;
        $month = $request->month;
        $form = ReservoirForms::where('year', $year)->get()->first();
        if($form == null) {
            $form = ReservoirForms::orderBy('year', 'desc')->get()->first();
            if($form != null) {
                $forms = ReservoirForms::where('year', $form->year)->orderBy('order_number')->get();
                $i = 0;
                $array = array();
                foreach ($forms as $value) {
                    $i++;
                    $new = array(
                        'year' => $year,
                        'order_number' => $i,
                        'check' => 1,
                        'gvk_object_id' => $value->gvk_object_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $array [] = $new;
                }
                if(count($array) > 0) DB::table('reservoir_forms')->insert($array);
                $forms = ReservoirForms::where('year', $year)->orderBy('order_number')->get();
            }
        }
        else{
            $forms = ReservoirForms::where('year', $year)->orderBy('order_number')->get();
        }

        $object_id = [];
        $objects = GvkObject::where('unit_id', 2)->where('type_id', 1)->get();
        foreach ($objects as $object) {
            $is_yes = false;
            foreach ($forms as $value) {
                if($object->id == $value->stat_object_id) $is_yes = true;
            }
            if($is_yes == false) $object_id [] = $object->id;
        }
        $existObject = GvkObject::whereIn('id', $object_id)->where('unit_id', 2)->get();

        $allForms = NewFormsModel::get();
        $unitsList = Unit::get();

        return view('general.data-exchange.reservoir_form',compact (
            'year',
            'existObject',
            'forms',
            'form_id',
            'allForms',
            'unitsList',
            'elements',
            'month'
        ));
    }

    public function AddObjectRes(Request $request)
    {
        if($request->is_new_object != 1){
            if($request->new_object != null || $request->new_object != '') {
                if($request->in_from == 'reservoir') {
                    $newForm = new ReservoirForms();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->gvk_object_id = $request->new_object;
                    $newForm->save();
                }

                if($request->in_from == 'amu') {
                    $newForm = new OperAmuForm();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->gvk_object_id = $request->new_object;
                    $newForm->save();
                }

                if($request->in_from == 'sird') {
                    $newForm = new OperSirdForm();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->gvk_object_id = $request->new_object;
                    $newForm->save();
                }

                if($request->in_from == 'daily') {
                    $newForm = new DailyForm();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->morning = 0;
                    $newForm->present = 1;
                    $newForm->gvk_object_id = $request->new_object;
                    $newForm->save();
                }
            }
        }
        else{
            if($request->name != null || $request->name != '') {
                $obj = new GvkObject();
                $obj->number = DB::table('gvk_objects')->max('number') + 1;
                $obj->name = $request->name;
                $obj->form_id = $request->allForms;
                $obj->unit_id = $request->unitsList;
                $obj->type_id = $request->type_id;
                $obj->obj_id = DB::table('gvk_objects')->max('obj_id') + 1;
                $obj->name_ru = $request->name_ru;
                $obj->save();

                if($request->in_from == 'reservoir') {
                    $newForm = new ReservoirForms();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->gvk_object_id = $obj->id;
                    $newForm->save();
                }

                if($request->in_from == 'amu') {
                    $newForm = new OperAmuForm();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->gvk_object_id = $obj->id;
                    $newForm->save();
                }

                if($request->in_from == 'sird') {
                    $newForm = new OperSirdForm();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->gvk_object_id = $obj->id;
                    $newForm->save();
                }

                if($request->in_from == 'daily') {
                    $newForm = new DailyForm();
                    $newForm->year = $request->year;
                    $newForm->order_number = 1;
                    $newForm->check = 1;
                    $newForm->morning = 0;
                    $newForm->present = 1;
                    $newForm->gvk_object_id = $obj->id;
                    $newForm->save();
                }
            }
        }
        return back ();
    }

    public function DailyForm(Request $request)
    {
        $year = $request->year;
        if(!(bool)strtotime($year . '-01-01')) {
            return view('general.data-exchange.error_form',compact (
                'year'
            ));
        }
        $form = DailyForm::where('year', $year)->get()->first();
        $form_id = $request->form;
        $elements = $request->elements;
        $month = $request->month;

        if($form == null) {
            $form = DailyForm::orderBy('year', 'desc')->get()->first();
            if($form != null) {
                $forms = DailyForm::where('year', $form->year)->orderBy('order_number')->get();
                $i = 0;
                $array = array();
                foreach ($forms as $value) {
                    $i++;
                    $new = array(
                        'year' => $year,
                        'order_number' => $i,
                        'morning' => 0,
                        'present' => 1,
                        'check' => 1,
                        'gvk_object_id' => $value->gvk_object_id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $array [] = $new;
                }
                if(count($array) > 0) DB::table('daily_forms')->insert($array);
                $forms = DailyForm::where('year', $year)->orderBy('order_number')->get();
            }
        }
        else{
            $forms = DailyForm::where('year', $year)->orderBy('order_number')->get();
        }

        $object_id = [];
        $objects = GvkObject::get();
        foreach ($objects as $object) {
            $is_yes = false;
            foreach ($forms as $value) {
                if($object->id == $value->stat_object_id) $is_yes = true;
            }
            if($is_yes == false) $object_id [] = $object->id;
        }
        $existObject = GvkObject::whereIn('id', $object_id)->get();
        $allForms = NewFormsModel::get();
        $unitsList = Unit::get();

        return view('general.data-exchange.daily_form',compact (
            'year',
            'existObject',
            'forms',
            'form_id',
            'allForms',
            'unitsList',
            'elements',
            'month'
        ));
    }

    public function AddValueAjax(Request $request)
    {
        $info = Information::find($request->id);
        if($request->field == 'present') $info->value = $request->value;
        if($request->field == 'morning') $info->average = $request->value;
        $info->save();
        return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
    }

    public function AddInfoAjax(Request $request)
    {
        $info = Information::find($request->id);
        $info->value = $request->value;
        $info->save();
        return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
    }
}
