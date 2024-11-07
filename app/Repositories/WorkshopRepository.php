<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Workshop;
use App\Repositories\Contracts\WorkshopRepositoryInterface;

class WorkshopRepository implements WorkshopRepositoryInterface
{
    public function getAllNewWorkshops()
    {
        return Workshop::where('is_new', true)->latest()->get();
    }

    public function getAllCategories()
    {
        return Category::latest()->get();
    }

    public function find($id)
    {
        return Workshop::find($id);
    }

    public function getPrice($workshopId)
    {
        $workshop = $this->find($workshopId);
        return $workshop ? $workshop->price : 0; // Pastikan kolom harga adalah 'price'
    }
}
