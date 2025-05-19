<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUniversityCountry extends Seeder
{

    public function run(): void
    {
        University::all()->each(function ($university) {
            switch (strtoupper($university->country)) {
                case 'FRANTA':
                    $university->country = 'France';
                    break;
                case 'SPANIA':
                    $university->country = 'Spain';
                    break;
                case 'ITALIA':
                    $university->country = 'Italy';
                    break;
                case 'CIPRU':
                    $university->country = 'Cyprus';
                    break;
                case 'BELGIA':
                    $university->country = 'Belgium';
                    break;
                case 'POLONIA':
                    $university->country = 'Poland';
                    break;
                case 'OLANDA':
                    $university->country = 'Netherlands';
                    break;
                case 'PORTUGALIA':
                    $university->country = 'Portugal';
                    break;
                case 'CEHIA':
                    $university->country = 'Czech Republic';
                    break;
                case 'TURCIA':
                    $university->country = 'Turkey';
                    break;
                case 'FINLANDA':
                    $university->country = 'Finland';
                    break;
                case 'GERMANIA':
                    $university->country = 'Germany';
                    break;
                case 'BULGARIA':
                    $university->country = 'Bulgaria';
                    break;
                case 'DANEMARCA':
                    $university->country = 'Denmark';
                    break;
                case 'GRECIA':
                    $university->country = 'Greece';
                    break;
                case 'UNGARIA':
                    $university->country = 'Hungary';
                    break;
                case 'SERBIA':
                    $university->country = 'Serbia';
                    break;
                case 'AUSTRIA':
                    $university->country = 'Austria';
                    break;
                case 'ROMANIA':
                    $university->country = 'Romania';
                    break;
                case 'CROATIA':
                    $university->country = 'Croatia';
                    break;
                default:
                    $university->country = ucfirst(strtolower($university->country));
                    break;
            }
            $university->save();
        });
    }
}
