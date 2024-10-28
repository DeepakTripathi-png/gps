<?php

namespace App\Imports;

use App\Models\GpsDevice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;


class DevicesImport implements WithStartRow, SkipsEmptyRows, ToCollection
{
    use Importable;
   
    public function collection(Collection $rows)
    {
        $validationRules = [
            '*.0' => 'required|unique:gps_devices,device_id',
        ];

        $customMessages = [
            'unique' => 'Device id already exist',
            // Add custom messages for other rules here
        ];
        if (auth('admin')->user()->id){
            $admin_id = auth('admin')->id();
        } else {
            $admin_id = 0;
        }
        $validator = Validator::make($rows->toArray(), $validationRules, $customMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            // echo '<pre>';print_r($rows);die;
            foreach ($rows as $row) {
                GpsDevice::create([
                    'device_id' => $row[0],
                    'device_type' => $row[1],
                    'sim_no' => $row[2],
                    'sim_no_two' => $row[3],
                    'password' => $row[4],
                    'imei_no' => $row[5],
                    'swipe_cardone' => $row[6],
                    'swipe_cardtwo' => $row[7],
                    'asset_no' => '4324242',
                    // 'expiry_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $admin_id,
                    'created_by' => $admin_id,
                ]);
            }
            $notify[] = ['success', 'Excel file imported successfully!'];
            return redirect()->back()->withNotify($notify);
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'unique:gps_devices,device_id',
            '1' => 'required',
            '2' => 'required',
            '3' => 'imei',
            '4' => 'swipe_cardone',
            '5' => 'swipe_cardtwo',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
}
