<?php

namespace App\Interfaces;

interface CarsInterface
{
    public function getCars();

    public function getCarById($id);

    public function store($data);

    public function update($data, $id);

    public function delete($id);
}
