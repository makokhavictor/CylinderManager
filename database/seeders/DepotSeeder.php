<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $depots = [
            ['code' => '1','EPRA_licence_no' => 'ERC/LPG/1770 ','name' => 'AULTIA INVESTMENT COMPANY LIMITED ','EPRA_licence_expiry_date' => '2020-07-17'],
            ['code' => '2','EPRA_licence_no' => 'ERC/LPG/1734 ','name' => 'CHEMIGAS LTD ','EPRA_licence_expiry_date' => '2020-06-06'],
            ['code' => '3','EPRA_licence_no' => 'ERC/LPG/1772 ','name' => 'DAGISAM COMPANY LIMITED ','EPRA_licence_expiry_date' => '2020-07-17'],
            ['code' => '4','EPRA_licence_no' => 'ERC/LPG/1816 ','name' => 'DARUUN ENERGY LIMITED ','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '5','EPRA_licence_no' => 'ERC/LPG/1621 ','name' => 'JAMAWA INVESTMENT ','EPRA_licence_expiry_date' => '2020-01-14'],
            ['code' => '6','EPRA_licence_no' => 'ERC/LPG/1820 ','name' => 'JOURNEY WORKS ENTERPRISES ','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '7','EPRA_licence_no' => 'ERC/LPG/1690 ','name' => 'MAMMA GAS & POWER LIMITED ','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '8','EPRA_licence_no' => 'ERC/LPG/1735 ','name' => 'MOUNTAINSIDE SERVICE STATION ','EPRA_licence_expiry_date' => '2020-06-06'],
            ['code' => '9','EPRA_licence_no' => 'ERC/LPG/1788 ','name' => 'MWAKECHA TRADERS ','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '10','EPRA_licence_no' => 'ERC/LPG/1610 ','name' => 'NAIBERI RIVER CAMPSITE AND RESORT LIMITED ','EPRA_licence_expiry_date' => '2019-11-20'],
            ['code' => '11','EPRA_licence_no' => 'ERC/LPG/1648 ','name' => 'NAJEEB VENTURES LIMITED ','EPRA_licence_expiry_date' => '2020-02-29'],
            ['code' => '12','EPRA_licence_no' => 'ERC/LPG/1777 ','name' => 'NEW TSAVO SERVICE STATION LTD ','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '13','EPRA_licence_no' => 'ERC/LPG/1819 ','name' => 'RAKIM GAS STOCKISTS ','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '14','EPRA_licence_no' => 'ERC/LPG/1696 ','name' => 'SAKA GAS CENTRE AND KITCHENWARE ','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '15','EPRA_licence_no' => 'ERC/LPG/1810 ','name' => 'SHREEJI PETROLEUM INVESTMENT ','EPRA_licence_expiry_date' => '2020-08-21'],
            ['code' => '16','EPRA_licence_no' => 'ERC/LPG/1787 ','name' => 'SHREEJI SERVICE STATION - Bungoma, Mumias Road ','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '17','EPRA_licence_no' => 'ERC/LPG/1785 ','name' => 'SHREEJI SERVICE STATION - Kakamega, Mumias Road ','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '18','EPRA_licence_no' => 'ERC/LPG/1784 ','name' => 'SHREEJI SERVICE STATION - Kanduyi ','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '19','EPRA_licence_no' => 'ERC/LPG/1786 ','name' => 'SHREEJI SERVICE STATION - Kisumu - Busia Road ','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '20','EPRA_licence_no' => 'ERC/LPG/1823 ','name' => 'SHRI HARI ENTERPRISES AND PETROL STATION ','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '21','EPRA_licence_no' => 'ERC/LPG/1645 ','name' => 'STREAM LAND COMPANY LIMITED ','EPRA_licence_expiry_date' => '2020-02-29'],
            ['code' => '22','EPRA_licence_no' => 'ERC/LPG/1758 ','name' => 'TROPICAL COOKING GAS LIMITED ','EPRA_licence_expiry_date' => '2020-03-07'],
            ['code' => '23','EPRA_licence_no' => 'ERC/LPG/1668 ','name' => 'URIM LIMITED ','EPRA_licence_expiry_date' => '2020-03-24'],
        ];

        DB::table('depots')->insert($depots);
    }
}

