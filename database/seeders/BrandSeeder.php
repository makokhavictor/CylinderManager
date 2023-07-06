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
            [ 'company_name' => 'Alfa Gas Limited ','name' => 'Alfa Gas'],
            [ 'company_name' => 'Aspam Energy Kenya Limited ','name' => 'Gulf Petrochem'],
            [ 'company_name' => 'BOC Kenya Limited ','name' => 'Handi Gas'],
            [ 'company_name' => 'Capital Gas Consumer Co-operative Society Limited ','name' => 'Capital Gas'],
            [ 'company_name' => 'City Gas Limited ','name' => 'City Gas'],
            [ 'company_name' => 'Depar Limited ','name' => 'Gasky'],
            [ 'company_name' => 'Eco –Energy (EA) Limited ','name' => 'P-Gas'],
            [ 'company_name' => 'Fast Gas Limited ','name' => 'Fast Gas'],
            [ 'company_name' => 'Fossil Fuels Limited ','name' => 'Pet Gas'],
            [ 'company_name' => 'Galana Oil Kenya Limited ','name' => 'Delgas'],
            [ 'company_name' => 'Green Energy Limited ','name' => 'G-Gas'],
            [ 'company_name' => 'Green Gas Company Limited ','name' => 'Amaan Gas'],
            [ 'company_name' => 'Hashi Energy Limited ','name' => 'Hashi gas'],
            [ 'company_name' => 'Hass Petroleum Kenya Limited ','name' => 'Hass Gas'],
            [ 'company_name' => 'Hunkar Trading Co. Limited ','name' => 'Hunkar Gas'],
            [ 'company_name' => 'Jamii Gas Limited ','name' => 'Jamii Gas'],
            [ 'company_name' => 'KenolKobil Limited ','name' => 'K-Gas'],
            [ 'company_name' => 'Kerry Gas Limited ','name' => 'Kerry Gas'],
            [ 'company_name' => 'Lake Gas Limited ','name' => 'Lake Gas'],
            [ 'company_name' => 'Libya Oil Kenya Limited ','name' => 'Mpishi Gas'],
            [ 'company_name' => 'Megtraco Limited ','name' => 'Kapri Gas'],
            [ 'company_name' => 'Midland Energy Limited ','name' => 'Mid Gas'],
            [ 'company_name' => 'Moto Gas Company Limited ','name' => 'Moto Gas'],
            [ 'company_name' => 'Multi Energy Limited ','name' => 'Men Gas'],
            [ 'company_name' => 'National Oil Corporation of Kenya ','name' => 'Supa Gas'],
            [ 'company_name' => 'Oilcom (K) Limited ','name' => 'Oilcom Gas'],
            [ 'company_name' => 'Orange Energy Limited ','name' => 'Orange Gas'],
            [ 'company_name' => 'Oryx Energies (K) Limited ','name' => 'Oryx Gas'],
            [ 'company_name' => 'Safari Petroleum Limited ','name' => 'Safari Gas'],
            [ 'company_name' => 'Safe Energy Limited ','name' => 'Safe Gas'],
            [ 'company_name' => 'Salama Gas Limited ','name' => 'Salama Gas'],
            [ 'company_name' => 'Solutions East Africa Limited ','name' => 'Sea Gas'],
            [ 'company_name' => 'Spareman Trading Company Limited ','name' => 'Home Gas'],
            [ 'company_name' => 'Syzo International Limited ','name' => 'Future Gaz'],
            [ 'company_name' => 'Tex Trading Limited ','name' => 'Tex Gas'],
            [ 'company_name' => 'Tosha Petroleum Kenya Limited ','name' => 'Tosha Gas'],
            [ 'company_name' => 'Total Kenya Limited ','name' => 'Total Gaz'],
            [ 'company_name' => 'Tuangaze Limited ','name' => 'T- Gas'],
            [ 'company_name' => 'Venus Energy ','name' => 'Venn Gas'],
            [ 'company_name' => 'Vivo Energy Kenya Limited ','name' => 'Afri Gas'],
        ];

        DB::table('brands')->insert($brands);
    }
}
