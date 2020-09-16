<?php

namespace App\Repositories\API;

use App\Models\Car;
use App\Models\CarHasAttachment;

class CarsRepository
{
    protected $car, $car_has_attachment;

    public function __construct(Car $car, CarHasAttachment $car_has_attachment)
    {
        $this->car                = $car;
        $this->car_has_attachment = $car_has_attachment;
    }

    public function getCars()
    {
        return $this->car
            ->with('user', 'attachments')
            ->get();
    }

    public function getCarByKeyword($keyword = '')
    {
        return $this->car
            ->with('user', 'attachments')
            ->where('title', 'like', '%' . $keyword . '%')
            ->get();
    }

    public function getCarDetail($car_id = 0)
    {
        return $this->car->with('user', 'attachments')->findOrFail($car_id);
    }
}
