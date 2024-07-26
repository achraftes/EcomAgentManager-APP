<?php
namespace App\Imports;

use App\Models\Lead;
use App\Models\Client;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class LeadsCSVImport implements ToModel, WithHeadingRow, WithChunkReading
{
    protected $mediaBuyerId;

    public function __construct($mediaBuyerId)
    {
        $this->mediaBuyerId = $mediaBuyerId;
    }

    public function headingRow(): int
    {
        return 1; // Assuming the actual headers start from the first row for CSV files
    }

    public function model(array $row)
    {
        // Map keys to match the format used in the script
        $row = [
            'Order ID' => $row['order_id'],
            'Order date' => $row['order_date'],
            'Nom complet' => $row['nom_complet'],
            'Adresse Mail' => $row['adresse_mail'],
            'Numéro de téléphone' => $row['numero_de_telephone'],
            'Adresse de livraison' => $row['adresse_de_livraison'],
            'Méthode de paiment préféré' => $row['methode_de_paiment_prefere'],
            'Préférences de produits' => $row['preferences_de_produits'],
            'Historique des achats' => $row['historique_des_achats'],
            'Comment' => $row['comment']
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
                'email' => $row['Adresse Mail'],
                'address' => $row['Adresse de livraison'],
            ]
        );

        // Check if the product exists
        $product = Product::where('name', $row['Préférences de produits'])->first();

        $amount = 0;

        if ($product) {
            // If the product exists, set the amount to the product's price
            $amount = $product->price;
        } else {
            // If the product doesn't exist, create a new product
            $product = Product::create([
                'name' => $row['Préférences de produits'],
                'category' => 'Unknown', // Adjust as needed
                'price' => 0, // Adjust as needed
            ]);
        }

        // Create the lead
        return new Lead([
            'order_id' => $row['Order ID'],
            'order_date' => $orderDate,
            'payment_method' => $row['Méthode de paiment préféré'],
            'client' => $row['Nom complet'],
            'phone' => $row['Numéro de téléphone'],
            'email' => $row['Adresse Mail'],
            'address' => $row['Adresse de livraison'],
            'product' => $product->name,
            'amount' => $amount,
            'status' => $row['Comment'],
            'media_buyer_id' => $this->mediaBuyerId, // Associe le Media Buyer ID à chaque lead importé
        ]);
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size based on your requirements
    }
}
