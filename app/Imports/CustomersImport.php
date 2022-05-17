<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures, Importable;

    private $isActive;

    public function __construct(Bool $isActive)
    {
        $this->isActive = $isActive;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'name' => strtolower($row['ad']),
            'surname' => strtolower($row['soyad']),
            'phone' => strtolower($row['telefon']),
            'email' => strtolower($row['eposta']),
            'city' => strtolower($row['sehir']),
            'source' => strtolower($row['kaynak']),
            'category' => strtolower($row['kategori']),
            'is_active' => $this->isActive,
        ]);
    }


    public function rules() : array
    {
        return [
            "ad" => 'required|max:255',
            "soyad" => 'required|max:255',
            // "phone" => 'required|numeric|digits_between:10,14|unique:customers,phone',
            "telefon" => 'required|unique:customers,phone',
            // "is_active" => 'required|boolean',
            "eposta" => 'nullable|email|unique:customers,email',
            "sehir" => 'nullable|max:255',
            "kaynak" => 'nullable|max:255',
            "kategori" => 'nullable|max:255',
        ];
    }


    // public function headings(): array
    // {
    //     return [
    //         "ad",
    //         "soyad",
    //         "telefon",
    //         "eposta",
    //         "sehir",
    //         "kaynak",
    //         "kategori",
    //     ];
    // }
}
