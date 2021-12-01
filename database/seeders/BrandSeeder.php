<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [ 'company_name' => 'Alfa Gas Limited ','name' => 'Alfa Gas Limited '],
            [ 'company_name' => 'Aspam Energy Kenya Limited ','name' => 'Aspam Energy Kenya Limited '],
            [ 'company_name' => 'BOC Kenya Limited ','name' => 'BOC Kenya Limited '],
            [ 'company_name' => 'Capital Gas Consumer Co-operative Society Limited ','name' => 'Capital Gas Consumer Co-operative Society Limited '],
            [ 'company_name' => 'City Gas Limited ','name' => 'City Gas Limited '],
            [ 'company_name' => 'Depar Limited ','name' => 'Depar Limited '],
            [ 'company_name' => 'Eco –Energy (EA) Limited ','name' => 'Eco –Energy (EA) Limited '],
            [ 'company_name' => 'Fast Gas Limited ','name' => 'Fast Gas Limited '],
            [ 'company_name' => 'Fossil Fuels Limited ','name' => 'Fossil Fuels Limited '],
            [ 'company_name' => 'Galana Oil Kenya Limited ','name' => 'Galana Oil Kenya Limited '],
            [ 'company_name' => 'Green Energy Limited ','name' => 'Green Energy Limited '],
            [ 'company_name' => 'Green Gas Company Limited ','name' => 'Green Gas Company Limited '],
            [ 'company_name' => 'Hashi Energy Limited ','name' => 'Hashi Energy Limited '],
            [ 'company_name' => 'Hass Petroleum Kenya Limited ','name' => 'Hass Petroleum Kenya Limited '],
            [ 'company_name' => 'Hunkar Trading Co. Limited ','name' => 'Hunkar Trading Co. Limited '],
            [ 'company_name' => 'Jamii Gas Limited ','name' => 'Jamii Gas Limited '],
            [ 'company_name' => 'KenolKobil Limited ','name' => 'KenolKobil Limited '],
            [ 'company_name' => 'Kerry Gas Limited ','name' => 'Kerry Gas Limited '],
            [ 'company_name' => 'Lake Gas Limited ','name' => 'Lake Gas Limited '],
            [ 'company_name' => 'Libya Oil Kenya Limited ','name' => 'Libya Oil Kenya Limited '],
            [ 'company_name' => 'Megtraco Limited ','name' => 'Megtraco Limited '],
            [ 'company_name' => 'Midland Energy Limited ','name' => 'Midland Energy Limited '],
            [ 'company_name' => 'Moto Gas Company Limited ','name' => 'Moto Gas Company Limited '],
            [ 'company_name' => 'Multi Energy Limited ','name' => 'Multi Energy Limited '],
            [ 'company_name' => 'National Oil Corporation of Kenya ','name' => 'National Oil Corporation of Kenya '],
            [ 'company_name' => 'Oilcom (K) Limited ','name' => 'Oilcom (K) Limited '],
            [ 'company_name' => 'Orange Energy Limited ','name' => 'Orange Energy Limited '],
            [ 'company_name' => 'Oryx Energies (K) Limited ','name' => 'Oryx Energies (K) Limited '],
            [ 'company_name' => 'Safari Petroleum Limited ','name' => 'Safari Petroleum Limited '],
            [ 'company_name' => 'Safe Energy Limited ','name' => 'Safe Energy Limited '],
            [ 'company_name' => 'Salama Gas Limited ','name' => 'Salama Gas Limited '],
            [ 'company_name' => 'Solutions East Africa Limited ','name' => 'Solutions East Africa Limited '],
            [ 'company_name' => 'Spareman Trading Company Limited ','name' => 'Spareman Trading Company Limited '],
            [ 'company_name' => 'Syzo International Limited ','name' => 'Syzo International Limited '],
            [ 'company_name' => 'Tex Trading Limited ','name' => 'Tex Trading Limited '],
            [ 'company_name' => 'Tosha Petroleum Kenya Limited ','name' => 'Tosha Petroleum Kenya Limited '],
            [ 'company_name' => 'Total Kenya Limited ','name' => 'Total Kenya Limited '],
            [ 'company_name' => 'Tuangaze Limited ','name' => 'Tuangaze Limited '],
            [ 'company_name' => 'Venus Energy ','name' => 'Venus Energy '],
            [ 'company_name' => 'Vivo Energy Kenya Limited ','name' => 'Vivo Energy Kenya Limited '],
        ];

        DB::table('brands')->insert($brands);
    }
}
