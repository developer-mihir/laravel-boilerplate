<?php

namespace App\Repositories;

use App\Interfaces\CarsInterface;
use App\Models\Car;

class CarsRepository implements CarsInterface
{
    protected $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    public function getCars()
    {
        return $this->car->with(['user', 'attachments'])->get();
    }

    public function getCarById($id)
    {
        return $this->car->with(['user', 'attachments'])->findOrFail($id);
    }

    public function store($data)
    {
        return $this->car->create($data);
    }

    public function update($data, $id)
    {
        return $this->car->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->car->findOrFail($id)->delete();
    }
}
