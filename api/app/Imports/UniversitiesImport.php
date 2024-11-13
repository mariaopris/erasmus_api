<?php
namespace App\Imports;

use App\Models\University;
use Faker\Core\Number;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class UniversitiesImport implements ToModel
{
    public function model(array $row)
    {
        // Skip rows without valid data
        if (!isset($row[1])) {
            return null;
        }
        if ($row[1] == 'UNIVERSITATEA') {
            return null;
        }

        $parsed_languages = array();
        $languages = explode('/', $row[8]);
        foreach ($languages as $language)
        {
            $name = '';
            switch ($language)
            {
                case 'EN':
                    $name = 'English';
                    break;
                case 'FR':
                    $name = 'French';
                    break;
                case 'IT':
                    $name = 'Italian';
                    break;
                case 'ES':
                    $name = 'Spanish';
                    break;
                case 'DE':
                    $name = 'German';
                    break;
                case 'GR':
                    $name = 'Greek';
                    break;
                case 'SK':
                    $name = 'Slovak';
                    break;
                case 'TR':
                    $name = 'Turkish';
                    break;
                case 'PL':
                    $name = 'Polish';
                    break;
            }
            $parsed_languages[] = [
              'id' => $language,
              'name' => $name
            ];
        }

        $years_parsed = array();
        $position = strpos($row[7], '(');
        if ($position !== false) {
            $years_string = substr($row[7], 0, $position);
            $years = explode(',', $years_string);

            $levels_string = substr($row[7], $position+1, strlen($row[7]) - ($position + 2));
            $levels = explode(',', $levels_string);

            foreach ($levels as $level) {
                $level = Str::replace(' ', '', $level);
                foreach ($years as $year) {
                    if(($level == 'MA' && (int)$year <= 2) || $level == 'BA')
                    {
                        $years_parsed[] = Str::replace(' ', '', $level . $year);
                    }
                }

                if($level == 'PhD')
                {
                    $years_parsed[] = $level;
                }
            }
        }

        return new University([
            'name' => $row[1],
            'email' => null,
            'country' => $row[3],
            'code' => $row[2],
            'coordinator' => $row[4],
            'mobility_period' => (int)$row[9] * (int)$row[10],
            'isced_codes' => json_encode(explode(',', $row[6])),
            'years' => json_encode($years_parsed),
            'languages' => json_encode($parsed_languages),
            'description' => null,
        ]);
    }
}
