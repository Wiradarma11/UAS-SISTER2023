<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kabupaten>
 */
class KabupatenFactory extends Factory
{
    static $order = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // data api: https://www.emsifa.com/api-wilayah-indonesia/api/regencies/51.json
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

        // tentukan data json yang akan diambil
        $data = $json[self::$order];
        self::$order++;

        return [
            'nama_kabupaten' => $data['name'],
            'slug' => Str::slug($data['name']),
        ];
    }
}
