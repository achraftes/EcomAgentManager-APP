<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Client;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LeadsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    protected $mediaBuyerId;

    public function __construct($mediaBuyerId)
    {
        $this->mediaBuyerId = $mediaBuyerId;
    }

    public function headingRow(): int
    {
        return 3; // Assuming the actual headers start from the third row
    }

    public function model(array $row)
    {
        // Map keys to match the format used in the script
        $row = [
            'Order ID' => $row['order_id'],
            'Order date' => $row['order_date'],
            'Nom complet' => $row['nom_complet'],
            'City' => $row['city'],
            'Numéro de téléphone' => $row['numero_de_telephone'],
            'Adresse de livraison' => $row['adresse_de_livraison'],
            'Total charge' => $row['total_charge'],
            'SKU' => $row['sku'],
            'Status' => $row['status']
        ];

        // Convert the date if it is in Excel date format
        if (is_numeric($row['Order date'])) {
            $orderDate = Date::excelToDateTimeObject($row['Order date']);
        } else {
            $orderDate = date_create_from_format('Y-m-d', $row['Order date']);
        }

        // Create or update the client
        $client = Client::updateOrCreate(
            ['full_name' => $row['Nom complet']],
            [
                'phone' => $row['Numéro de téléphone'],
                'city' => $row['City'],
                'address' => $row['Adresse de livraison'],
            ]
        );

        // Check if the product exists
        $product = Product::where('name', $row['SKU'])->first();

        $amount = 0;

        if ($product) {
            // If the product exists, set the amount to the product's price
            $amount = $product->price;
        } else {
            // If the product doesn't exist, create a new product
            $product = Product::create([
                'name' => $row['SKU'],
                'category' => 'Unknown', // Adjust as needed
                'price' => 0, // Adjust as needed
            ]);
        }

        // Create the lead
        return new Lead([
            'order_id' => $row['Order ID'],
            'order_date' => $orderDate,
            'total_charge' => $row['Total charge'],
            'client' => $row['Nom complet'],
            'phone' => $row['Numéro de téléphone'],
            'city' => $row['City'],
            'address' => $row['Adresse de livraison'],
            'product' => $product->name,
            'amount' => $row['Total charge'],
            'status' => $row['Status'],
            'media_buyer_id' => $this->mediaBuyerId, // Associe le Media Buyer ID à chaque lead importé
        ]);
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size based on your requirements
    }
}