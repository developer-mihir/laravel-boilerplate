<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\API\CarsRepository;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    protected $cars_repository;

    public function __construct(CarsRepository $cars_repository)
    {
        $this->cars_repository = $cars_repository;
    }

    public function getCars(Request $request)
    {
        try {
            $cars = $this->cars_repository->getCars();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Cars.',
                    'data'    => $cars->toArray()
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function getCarDetail(Request $request, $car_id)
    {
        try {
            $car = $this->cars_repository->getCarDetail($car_id);
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Car Detail.',
                    'data'    => $car->toArray()
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function getCarByKeyword(Request $request, $keyword)
    {
        try {
            $cars = $this->cars_repository->getCarByKeyword($keyword);
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Cars Search.',
                    'data'    => $cars->toArray()
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }
}
