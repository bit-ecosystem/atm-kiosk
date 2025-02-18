<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

class EmployeeHandbook extends Model
{
    use Sushi;

    protected $guarded = [];

    public function getRows()
    {
        $data = json_decode(Storage::disk('public')->get('policies/emp_handbook.json'), true);

        if (! empty($data)) {
            // Return a default row structure if the data is empty
            return [
                ['id' => 1, 'title' => 'Default Title', 'content' => 'Default Content'],
            ];
        }

        return $data;
    }

    public static function add($data)
    {
        $allData = self::all()->toArray();
        $data['id'] = max(array_column($allData, 'id')) + 1;
        $allData[] = $data;
        Storage::disk('public')->put('policies/emp_handbook.json', json_encode($allData, JSON_PRETTY_PRINT));
    }

    public static function updateData($id, $newData)
    {
        $allData = self::all()->toArray();
        foreach ($allData as $item) {
            if ($item['id'] == $id) {
                $item = array_merge($item, $newData);
                break;
            }
        }
        Storage::disk('public')->put('policies/emp_handbook.json', json_encode($allData, JSON_PRETTY_PRINT));
    }
}
