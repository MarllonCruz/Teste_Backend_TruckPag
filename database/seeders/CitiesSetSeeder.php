<?php

namespace Database\Seeders;

use App\Models\City;
use App\Services\IBGEAPI\Exceptions\IBGENotFound;
use Illuminate\Database\Seeder;
use App\Services\IBGEAPI\IBGEAPI;

class CitiesSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        try {
            $cities = (new IBGEAPI())->cities("33");
            
            foreach ($cities as $city) {
                $model = new City();
    
                $model->id   = $city['id'];
                $model->nome = $city['nome'];
                $model->save();
                unset($model);
            }
        } catch (IBGENotFound $exception) {
            return false;
        }
        
    }
}
