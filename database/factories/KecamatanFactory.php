<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kecamatan>
 */
class KecamatanFactory extends Factory
{
    static $order = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $json = [
            [
                "id" => "5101",
                "province_id" => "51",
                "name" => "KAB JEMBRANA"
            ],
            [
                "id" => "5102",
                "province_id" => "51",
                "name" => "KAB TABANAN"

            ],
            [
                "id" => "5103",
                "province_id" => "51",
                "name" => "KAB BADUNG"

            ],
            [
                "id" => "5104",
                "province_id" => "51",
                "name" => "KAB GIANYAR"

            ],
            [
                "id" => "5105",
                "province_id" => "51",
                "name" => "KAB KLUNGKUNG"

            ],
            [
                "id" => "5106",
                "province_id" => "51",
                "name" => "KAB BANGLI"

            ],
            [
                "id" => "5107",
                "province_id" => "51",
                "name" => "KAB KARANG ASEM"

            ],
            [
                "id" => "5108",
                "province_id" => "51",
                "name" => "KAB BULELENG"

            ],
            [
                "id" => "5171",
                "province_id" => "51",
                "name" => "KOTA DENPASAR"
            ]
        ];

        $data = [];

        foreach ($json as $key => $value) {
            // take data from https://www.emsifa.com/api-wilayah-indonesia/api/districts/{id}.json

            $isi = request()->get('https://www.emsifa.com/api-wilayah-indonesia/api/districts/' . $value['id'] . '.json');

            // dd($isi);

            $data[] = [
                "id" => $isi['id'],
                "regency_id" => $isi['regency_id'],
                "name" => $isi['name'],
            ];
        }

        $data = $data[self::$order];
        $id = self::$order;
        self::$order++;

        return [
            //
            'kabupaten_id' => $id,
            'nama' => $data['name'],
            'slug' => Str::slug($data['name']),
        ];
    }
}
