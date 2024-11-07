<?php

namespace App\Repositories\Contracts;

interface WorkshopRepositoryInterface
{
    public function getAllNewWorkshops();
    public function getAllCategories();
    public function find($id);
    public function getPrice($workshopId);
}
