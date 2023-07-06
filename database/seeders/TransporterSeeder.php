<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransporterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transporters = [
            ['code' => '1','EPRA_licence_no' => 'ERC/LPG/1665','name' => 'ABDI AZIZ ALI SHIRE AGENCIES ','description' => 'KBT603A - ZE0572, KBS336H - ZE4248, KBS336H - ZE 0572','EPRA_licence_expiry_date' => '2020-03-24'],
            ['code' => '2','EPRA_licence_no' => 'ERC/LPG/1582','name' => 'AIVEO LIMITED ','description' => 'KBZ782W-ZE2712,KBZ791W-ZE7058,KBZ078X-ZE7059,KBA094Q-ZC8241','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '3','EPRA_licence_no' => 'ERC/LPG/1283','name' => 'ALFA GAS LIMITED ','description' => 'KBV 535L - ZE 3662, KBR 201K - ZD 0282, KBQ 368C - ZD 6567, KBV535L - ZE 3262, KBV438U - ZE3847, KBH 869Z - ZD1485, KBG 869M - ZD 2080','EPRA_licence_expiry_date' => '2019-12-20'],
            ['code' => '4','EPRA_licence_no' => 'ERC/LPG/1315','name' => 'AMEKEN MINEWEST COMPANY LIMITED ','description' => 'KCE 205X-ZD 2771, KAX 047B-ZC 8347','EPRA_licence_expiry_date' => '2019-12-21'],
            ['code' => '5','EPRA_licence_no' => 'ERC/LPG/1632','name' => 'APCO ENERGY LIMITED ','description' => 'KCG 117D - 1357, KCE 203L - ZE 6900, KBD 553F - KBD 553F','EPRA_licence_expiry_date' => '2020-11-02'],
            ['code' => '6','EPRA_licence_no' => 'ERC/LPG/1079','name' => 'AROUND THE GLOBE SERVICES LIMITED ','description' => 'KCE 157S - ZD 1363, KCH 483T - ZE 1480, KCA 921C - ZE 7052,KCU864C - ZC 1046','EPRA_licence_expiry_date' => '2020-04-02'],
            ['code' => '7','EPRA_licence_no' => 'ERC/LPG/1689','name' => 'ASHUR AHMED TRANSPORTERS LIMITED ','description' => 'KBS440Q, KCG440K, KBK440H, KBK440K, KBK440N, KBA622A, KAZ659B','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '8','EPRA_licence_no' => 'ERC/LPG/1515','name' => 'AWADH OMAR BAYUSUF AND SONS LIMITED ','description' => 'KCN 379X, KCQ 588S - ZD 7154, KCT 624X, KCT 609X, KCT 544D - ZE 1330, KCQ 583S - ZD 7896, KBR 202A - ZD 7154, KCN 025G - ZD 7661, KBR 204A - ZD 8021, KCN 027G - ZE 1381, KBR 208A - ZE 1330, KCK 511S - ZE 2315, KCN 028G - ZE 2325, KBY 856D - ZE 6183, KBY 857D - ZE 6184, KCG 235J - ZE 0164, KCG 283C - ZE 1329, KAT 600N, KBT 267R, KCT 622X','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '9','EPRA_licence_no' => 'ERC/LPG/1573','name' => 'BELSA ENERGY LIMITED ','description' => 'KBZ072Z-ZE7721, KBR793F-ZE7719','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '10','EPRA_licence_no' => 'ERC/LPG/1593','name' => 'BLUE GAS LIMITED ','description' => 'KBC 795W','EPRA_licence_expiry_date' => '2019-11-21'],
            ['code' => '12','EPRA_licence_no' => 'ERC/LPG/1533','name' => 'BRITS FREIGHTERS LIMITED ','description' => 'KBW120Z - ZE4247','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '13','EPRA_licence_no' => 'ERC/LPG/1722','name' => 'CHEMIGAS LIMITED ','description' => 'KAX 959S, KAW 926B, KAS 409M, KAU 085S, KAR 855H, KBL 811C - ZC 5083, KCP 443S - ZC 8243, KAX 670R - ZC 5083','EPRA_licence_expiry_date' => '2020-05-23'],
            ['code' => '14','EPRA_licence_no' => 'ERC/LPG/1629','name' => 'CHEV ENERGIES LIMITED ','description' => 'KCT 622H - ZF 6556, KAT 665F','EPRA_licence_expiry_date' => '2020-04-02'],
            ['code' => '15','EPRA_licence_no' => 'ERC/LPG/1435','name' => 'CITY GAS LIMITED ','description' => 'KBS 368L - ZC 8386, KBJ 711L - ZE 4638, KCL 899E - ZF 5859, KCN 637R - ZC 0704','EPRA_licence_expiry_date' => '2020-05-23'],
            ['code' => '16','EPRA_licence_no' => 'ERC/LPG/1432','name' => 'DAKAWOU TRANSPORT LIMITED ','description' => 'KAP 917W, KAT 066W, KBC 588Y, KAT 861R- - ZB 5983, KAV 189C - ZB 6117, KBJ 948K- - ZE 0460, KBK 560S - ZC 8199, KBL 512C - ZD 8270, KBD 846J - ZC 3996, KBD 463F - ZB 6118, KBR 911H - ZB 3622, KBS 677A - ZE 0461, KBT 243Y - ZD 0619, KBU 046R - ZC 2541, KBV 417G - ZD 5862, KBZ 172E - ZD 8301, KBH 274J - ZD 0620, KBU 887D - ZB 7013, KAW 676U, KBJ 880B - ZC 3813, KBR 140V - ZC 8025, KBR 153V - ZC 8259, KCQ 877M, KAT 861R - ZB 5983, KBT 241Y - ZC 8025','EPRA_licence_expiry_date' => '2020-09-05'],
            ['code' => '17','EPRA_licence_no' => 'ERC/LPG/1244','name' => 'DASH ENERGY LIMITED ','description' => 'KAZ 127M','EPRA_licence_expiry_date' => '2020-05-04'],
            ['code' => '18','EPRA_licence_no' => 'ERC/LPG/1508','name' => 'DASH ENERGY LIMITED ','description' => 'KBW 823Y','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '19','EPRA_licence_no' => 'ERC/LPG/1051','name' => 'DAYOW GAS COMPANY LTD ','description' => 'Transport of LPG in bulk:KBA 576A - ZE0276, KBT 247L - ZC0702, KBS 158J - ZD1118, KBQ 003L -ZE4849, KBY 639A - ZE5387','EPRA_licence_expiry_date' => '2019-10-29'],
            ['code' => '20','EPRA_licence_no' => 'ERC/LPG/1815','name' => 'DEPAR LIMITED ','description' => 'KCA 196W-ZD9315 - ZD 9315, KBW 260W-ZE3849 - ZE 3849','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '21','EPRA_licence_no' => 'ERC/LPG/1215','name' => 'DERDOLS PETROLEUM LIMITED ','description' => 'KBM 872F-ZD9589, KBU 467H-ZE0459, KBH 582Y-ZD9591, KBU 548G - ZC5925, KBU 541H - ZE 0458','EPRA_licence_expiry_date' => '2020-07-17'],
            ['code' => '22','EPRA_licence_no' => 'ERC/LPG/1291','name' => 'EXCELLENT LOGISTICS LTD ','description' => 'KBM 501B,KCP 417U - ZF7601, KCP 018N - ZF 3282, KCD 401D - ZF7601, KCD 402D - ZF 3282','EPRA_licence_expiry_date' => '2019-12-20'],
            ['code' => '23','EPRA_licence_no' => 'ERC/LPG/1740','name' => 'FAST GAS LIMITED ','description' => 'KCU 152R - ZG 0728','EPRA_licence_expiry_date' => '2020-06-18'],
            ['code' => '24','EPRA_licence_no' => 'ERC/LPG/1776','name' => 'FILBAK ENERGY SOLUTIONS LTD ','description' => 'KCV 390A - ZG 0773','EPRA_licence_expiry_date' => '2020-07-29'],
            ['code' => '25','EPRA_licence_no' => 'ERC/LPG/1571','name' => 'FIVE STAR GAS SUPPLIES ','description' => 'KCH167T-ZC6954','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '26','EPRA_licence_no' => 'ERC/LPG/1502','name' => 'FLEET LOGISTICS LTD ','description' => 'KBT 349R - ZD9640, KBT 350R - ZE4201, KBT 351R - ZE4203, KBT 352R - ZE4205, KBT 353R - ZE4206, KBX 693Y - ZE4207, KBX698Y - ZE4204','EPRA_licence_expiry_date' => '2020-12-08'],
            ['code' => '27','EPRA_licence_no' => 'ERC/LPG/1746','name' => 'FOSSIL SUPPLIES LIMITED ','description' => 'KBK 680J - ZB 4692, KBV469T - ZD 4892','EPRA_licence_expiry_date' => '2020-06-18'],
            ['code' => '28','EPRA_licence_no' => 'ERC/LPG/1701','name' => 'GARAAD TRANSPORTERS LIMITED ','description' => 'KBJ 126X - ZE 9230','EPRA_licence_expiry_date' => '2020-04-29'],
            ['code' => '29','EPRA_licence_no' => 'ERC/LPG/1580','name' => 'GAZLIN ENERGY LIMITED ','description' => 'KBH 266L-ZE6175, KBH 729L-ZD1763, KBJ 240D-ZE8246, KBL977V-ZE0573, KBS 687C-ZC8384, KBN 165NZC0093, KBR 853Y-ZE6182, KBX 829D-ZE7878, KBY 374Y-ZE6181, KBZ 906U-ZE8247, KBT 536C-ZC6647, KCK 155Q-ZF6301, KBT 733U, KBW365C - ZC1046, KBD 768Q - ZE6893, KAZ 143S - ZC6646, KAW 300L - ZC6648, KBE 544P - ZC5293, KBS 687C - ZE7361','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '30','EPRA_licence_no' => 'ERC/LPG/1570','name' => 'GOAL ENERGY LTD ','description' => 'KBU 159C-ZE2593','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '31','EPRA_licence_no' => 'ERC/LPG/1572','name' => 'GREATMOUNT LPG LIMITED ','description' => 'KBR 359Y-ZE 0154,KBS 188V-ZC 8842','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '32','EPRA_licence_no' => 'ERC/LPG/883','name' => 'GREEN GAS COMPANY ','description' => 'KBX 826D-ZE7877, KBX 827D-ZC 2881, KBX 831D- ZE 4637, KBZ 955R - ZF 6307, KBW 934M - ZE 7879, KBJ 177S - ZE2599','EPRA_licence_expiry_date' => '2020-03-17'],
            ['code' => '33','EPRA_licence_no' => 'ERC/LPG/1056','name' => 'GUMTREE CAPITAL LIMITED ','description' => 'KCB884U','EPRA_licence_expiry_date' => '2020-01-22'],
            ['code' => '34','EPRA_licence_no' => 'ERC/LPG/1529','name' => 'HANSLEY INVESTMENTS LIMITED ','description' => 'KBL 945D','EPRA_licence_expiry_date' => '2019-09-19'],
//            ['code' => '35','EPRA_licence_no' => 'ERC/LPG/1529','name' => 'HANSLEY INVESTMENTS LIMITED ','description' => 'KBL 945D','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '36','EPRA_licence_no' => 'ERC/LPG/1229','name' => 'HASHI LOGISTICS LIMITED ','description' => 'KBQ 275K-ZD8325, KBQ 274K-ZD8324, KBQ 396Q-ZD8323, KAY 523E-ZE1293,KAY 527E-ZE1392','EPRA_licence_expiry_date' => '2019-12-20'],
            ['code' => '37','EPRA_licence_no' => 'ERC/LPG/1535','name' => 'HUNKY ENERGY LIMITED ','description' => 'KBP022B-ZD0716, KBH100Z-ZD0718','EPRA_licence_expiry_date' => '2019-09-20'],
            ['code' => '38','EPRA_licence_no' => 'ERC/LPG/1274','name' => 'IGAL ENERGY KENYA LIMITED ','description' => 'KBU 884X - ZE7051','EPRA_licence_expiry_date' => '2019-12-11'],
            ['code' => '39','EPRA_licence_no' => 'ERC/LPG/947','name' => 'INTERTROPICS TRANSPORTERS ','description' => 'KCA 416D-ZE7057','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '40','EPRA_licence_no' => 'ERC/LPG/1827','name' => 'JIBCO KENYA LIMITED ','description' => 'KCJ 007V - ZE 0410','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '41','EPRA_licence_no' => 'ERC/LPG/1749','name' => 'JOPHIC GENERAL AGENCIES LIMITED ','description' => 'KAU 976P','EPRA_licence_expiry_date' => '2020-02-07'],
            ['code' => '42','EPRA_licence_no' => 'ERC/LPG/1672','name' => 'KERRY GAS LIMITED ','description' => 'KCG 338B - ZD 5070, KCG 845R - ZE 2597','EPRA_licence_expiry_date' => '2020-03-24'],
            ['code' => '43','EPRA_licence_no' => 'ERC/LPG/1713','name' => 'LAKE OIL LIMITED ','description' => 'KBY 005T, KCM 133X, KCM 132X, KBQ012L - ZD 7895','EPRA_licence_expiry_date' => '2020-09-05'],
            ['code' => '44','EPRA_licence_no' => 'ERC/LPG/1405','name' => 'LUNGA LUNGA ENERGY LTD ','description' => 'KBY 638A - ZE 8032','EPRA_licence_expiry_date' => '2020-04-28'],
            ['code' => '45','EPRA_licence_no' => 'ERC/LPG/1424','name' => 'LUNGA LUNGA TRANSPORTERS LTD ','description' => 'KCF 739C - ZD9639','EPRA_licence_expiry_date' => '2020-05-23'],
            ['code' => '46','EPRA_licence_no' => 'ERC/LPG/1262','name' => 'LYMS LTD ','description' => 'KBR127P-ZD8006, KBR367F-ZD8005','EPRA_licence_expiry_date' => '2019-06-12'],
            ['code' => '47','EPRA_licence_no' => 'ERC/LPG/1581','name' => 'MACKENZIE MARITIME (EA) LIMITED ','description' => 'KCG 508K - ZF 3986, KCG 510K - ZF 3988, KCG 507K - ZF 3985, KCG509K - ZF 3987, KCE 781B - ZF 3990, KCG527K - ZF 3989, KCF 981B - ZE8821, KCF 982B - ZE 8823, KCF 829C - ZF 1356','EPRA_licence_expiry_date' => '2019-10-19'],
            ['code' => '48','EPRA_licence_no' => 'ERC/LPG/1681','name' => 'MAPKA INVESTMENT LIMITED ','description' => 'KBQ 103J - ZF 5776, KBT 806C - ZC 4589','EPRA_licence_expiry_date' => '2020-04-04'],
            ['code' => '49','EPRA_licence_no' => 'ERC/LPG/1347','name' => 'MAX GAS AND PETROLEUM COMPANYLIMITED','description' => 'KAY 916F, KCK 381R - ZD4946, KBT 802C - ZD6104','EPRA_licence_expiry_date' => '2019-12-23'],
            ['code' => '50','EPRA_licence_no' => 'ERC/LPG/1702','name' => 'MENENGAI ENGINEERING & PETROLEUM SERVICES ','description' => 'KAQ610U, KBT447S - ZC6466, KBB962F - ZD8004, KAY366M - ZC3740, KAV617H - ZC6299, KAX478L, KAR811Z','EPRA_licence_expiry_date' => '2020-04-29'],
            ['code' => '51','EPRA_licence_no' => 'ERC/LPG/1673','name' => 'MOTO GAS COMPANY LIMITED ','description' => 'KCG 035Y - ZC 6371','EPRA_licence_expiry_date' => '2020-03-24'],
            ['code' => '52','EPRA_licence_no' => 'ERC/LPG/878','name' => 'MOTO GAS COMPANY LIMITED ','description' => 'KBS 317A - ZE 4851','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '53','EPRA_licence_no' => 'ERC/LPG/1404','name' => 'MULTIENEGY LTD ','description' => 'KBQ 880P-ZE6180, KBH 267J-ZD0836, KBP 555A-ZD1119, KBP870P - ZF8950','EPRA_licence_expiry_date' => '2020-08-04'],
            ['code' => '54','EPRA_licence_no' => 'ERC/LPG/1737','name' => 'MULTIPLE HAULIERS ( E.A) LTD ','description' => 'KCE004L - ZB9978, KCE007L - ZE6805, KCE008L - ZB9979','EPRA_licence_expiry_date' => '2020-06-18'],
            ['code' => '55','EPRA_licence_no' => 'ERC/LPG/1377','name' => 'MULTI-TRADE INTERNATIONAL LIMITED ','description' => 'KAZ 870Q - ZE 7951, KBM 693A - ZD 3359, KBL 641U - ZC 1711, KBM 901C - ZF 8482, KBN 019V - ZG 0776','EPRA_licence_expiry_date' => '2020-05-03'],
            ['code' => '56','EPRA_licence_no' => 'ERC/LPG/1446','name' => 'NORTHGAS ','description' => 'KCK 360F - ZF 6223, KCN 489H - ZF 6226','EPRA_licence_expiry_date' => '2020-06-18'],
            ['code' => '57','EPRA_licence_no' => 'ERC/LPG/1716','name' => 'ONG LOGISTICS LIMITED ','description' => 'KBJ228W - ZD9140, KBT246L - ZE1168, KBN585V - ZE7870, KBN217F - ZD7540, KBV409N - ZE7053','EPRA_licence_expiry_date' => '2020-09-05'],
            ['code' => '58','EPRA_licence_no' => 'ERC/LPG/1809','name' => 'OSALI ENERGY ENTERPRISES ','description' => 'KBQ 966S - ZD8244, KBJ 088G - ZD1762','EPRA_licence_expiry_date' => '2020-08-20'],
            ['code' => '59','EPRA_licence_no' => 'ERC/LPG/1602','name' => 'OXXENERGY LIMITED ','description' => 'KCP 220Z - ZF 6224','EPRA_licence_expiry_date' => '2019-12-19'],
            ['code' => '60','EPRA_licence_no' => 'ERC/LPG/1402','name' => 'PROTO ENERGY LIMITED ','description' => 'KCP 400A - ZF 5877, KCP 789G - ZF 5874, KCP 790G - ZF 5873, KCP 791G - ZF 5876, KCP 792G - ZF 8700, KCP 793G - ZF 5879, KCP 794G - ZF 5875, KCP 795G - ZF 5878, KCP 796G - ZF 5880, KCP 797G - ZF 8721, KCE 311E','EPRA_licence_expiry_date' => '2020-08-04'],
            ['code' => '62','EPRA_licence_no' => 'ERC/LPG/1527','name' => 'QUICKPOINT ENERGY LIMITED ','description' => 'KBY553S-ZC6952, KBL 784Z-ZD4097, KBR827W-ZC7219','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '63','EPRA_licence_no' => 'ERC/LPG/1829','name' => 'RAAD TRADERS LIMITED ','description' => 'KBT262P - ZE4636','EPRA_licence_expiry_date' => '2020-05-09'],
            ['code' => '64','EPRA_licence_no' => 'ERC/LPG/1544','name' => 'RAANLE TRANSPORTERS LTD ','description' => 'KCP 860N-ZF5857, KBR 447W-ZF5858& KBW 078J-ZD983','EPRA_licence_expiry_date' => '2019-09-28'],
            ['code' => '65','EPRA_licence_no' => 'ERC/LPG/1486','name' => 'RAGOS TRADING COMPANY LTD ','description' => 'KCN 267G, KCN 272G, KBK 020M - ZF 9605, KBQ 320C - ZF 9606, KCF 718J - ZF 9607','EPRA_licence_expiry_date' => '2020-07-31'],
            ['code' => '66','EPRA_licence_no' => 'ERC/LPG/1369','name' => 'RAPID HAULIERS LTD ','description' => 'KBJ 185X - ZD 2234','EPRA_licence_expiry_date' => '2020-04-02'],
            ['code' => '67','EPRA_licence_no' => 'ERC/LPG/1611','name' => 'RIHAL ENERGY COMPANY LIMITED ','description' => 'KBX 541C - ZD 1986, KBY 020V - ZE 6895, KBY 052V - ZE 6899, KCQ 155L - ZF 6225, KCT 004A','EPRA_licence_expiry_date' => '2019-12-20'],
            ['code' => '68','EPRA_licence_no' => 'ERC/LPG/1556','name' => 'RINTELL DISTRIBUTORS LIMITED ','description' => 'KCJ 793T','EPRA_licence_expiry_date' => '2019-10-15'],
            ['code' => '69','EPRA_licence_no' => 'ERC/LPG/1642','name' => 'ROY HAULIERS LIMITED ','description' => 'KBU 187S - ZE2598, KBU 171S - ZE2594, KCR 304M - ZE1551,KBU 174S - ZE1552, KBU196S - ZE1553, KBU 178S - ZE2595, KAY542F - ZC5216, KBU 658R, KCP 643Y, KCP 644Y, KCP 645Y','EPRA_licence_expiry_date' => '2020-02-14'],
            ['code' => '70','EPRA_licence_no' => 'ERC/LPG/1427','name' => 'ROY TRANSMOTORS LIMITED ','description' => 'KCH 209L - ZD 0088, KCH 228L - ZD 0087, KCH 234L - ZE 0173, KBR894S, KBR895S, KAT170Q - ZD7297, KBK876M - ZC8675, KBR405Y - ZD5661, KBT127A - ZC5178, KBT947A - ZD3360, KAT170Q - ZC3528, KAT170Q - ZC5177, KBZ148U - ZC8670, KCC798E - ZE0173, KCD069C - ZF5554, KCD070C - ZE0176, KCG370Q - ZD7377, KCG412R - ZE0172, KCG413R - ZE0175, KCH235L - ZE8820, KBZ805T - ZE2610, KCD987A - ZE0174, KBK870M - ZD3307, KBZ147U - ZD0089, KCJ 673C - ZC 5177, KCG 425R - ZE 0175, KCG 415R - ZC 8675','EPRA_licence_expiry_date' => '2020-05-16'],
            ['code' => '71','EPRA_licence_no' => 'ERC/LPG/1275','name' => 'SADE LOGISTICS ','description' => 'KBR 816K -ZD7539, KBY 748V-ZD1761','EPRA_licence_expiry_date' => '2019-10-30'],
            ['code' => '72','EPRA_licence_no' => 'ERC/LPG/1567','name' => 'SAFARI PETROLEUM LTD ','description' => 'KCG 301Y','EPRA_licence_expiry_date' => '2019-10-16'],
            ['code' => '73','EPRA_licence_no' => 'ERC/LPG/1251','name' => 'SHURIE TRUCKS LTD ','description' => 'KCK 808W - ZF 0189, KAY 696E - ZF 0190, KBK 087D - ZE 2711, KCD 454W - ZG 0412, KBA 422Q - ZE 3848, KBK 731K - ZF 5777, KBK 106W - ZF 0725','EPRA_licence_expiry_date' => '2019-05-11'],
            ['code' => '74','EPRA_licence_no' => 'ERC/LPG/1523','name' => 'SIBED TRANSPORT COMPANY LIMITED ','description' => 'KCA101J - ZF2266, KCA102J - ZF2265, KCA103J - ZD0011, KCA106J - ZE6898, KCG151R - ZE5390, KCG163R - ZD9834, KCJ206K - ZF4470, KCA282X - ZD2240, KCG156R - ZF5688, KCH801U, KCG 151R - ZE 5390, KCG 156R - ZF 5688, KCG 163R - ZF 9834, KCA 103J - ZD 0011, KCA 282X - ZD 2240, KCA 101J - ZF 2266, KCA 102J - ZF 2265, KCA 106J - ZE 6898, KCH 801U, KCJ','EPRA_licence_expiry_date' => '2019-10-16'],
            ['code' => '75','EPRA_licence_no' => 'ERC/LPG/1584','name' => 'SIEKE LIMITED ','description' => 'KBR 615L-ZD 4246','EPRA_licence_expiry_date' => '2019-10-29'],
            ['code' => '76','EPRA_licence_no' => 'ERC/LPG/1334','name' => 'SOLUTIONS EAST AFRICA LIMITED ','description' => 'KCB 608C - ZG 0708, KCE 845Q - ZE5388, KCL 225A - ZC0588,KCL 226W - ZC3492, KCM 227S - ZE7055, KBB791B, KBF229W,KCJ058H, KCT 223L - ZG 0413, KCT 224H - ZG 0414, KCT 228H -ZF 7847, KBZ 031Z - ZF 7848, KCV 220P - ZE 7055, KCV 221P - ZF 7817','EPRA_licence_expiry_date' => '2019-11-21'],
            ['code' => '77','EPRA_licence_no' => 'ERC/LPG/1383','name' => 'SPAREMAN TRADING LIMITED ','description' => 'KBH 186C - ZC8756, KBT 706X - ZC 3335','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '78','EPRA_licence_no' => 'ERC/LPG/1731','name' => 'STEGAM PETROLEUM ','description' => 'KCG 407L','EPRA_licence_expiry_date' => '2020-04-06'],
            ['code' => '79','EPRA_licence_no' => 'ERC/LPG/1695','name' => 'STEVE YOUNG DISTRIBUTION LIMITED ','description' => 'KBT 987F - ZD 1321','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '80','EPRA_licence_no' => 'ERC/LPG/910','name' => 'SYZO INTERNATIONAL LIMITED ','description' => 'KBV 016E-ZE 5053, KBV - ZE 4673, KCM 340Y','EPRA_licence_expiry_date' => '2020-04-15'],
            ['code' => '81','EPRA_licence_no' => 'ERC/LPG/1617','name' => 'TEJA HAULIERS ','description' => 'KAY 385Q - ZE7882, KBL 196K - ZD6912','EPRA_licence_expiry_date' => '2019-12-23'],
            ['code' => '82','EPRA_licence_no' => 'ERC/LPG/1307','name' => 'TEX TRADING LIMITED ','description' => 'KAX 716K - ZD 1624, KBV 322B - ZE 2596, KBP 566V - ZD 6589, KBE 623M - ZC 9804, KBJ 366L - ZC 2895, KBQ 305C - ZE 0518, KBP 217E - ZD 1477, KBQ 358A - ZC 8096, KBT 586Q - ZE 4246, KAU 124W - ZC 8757, KBT 211D - ZD 6103, KBE 544P - ZC 5293','EPRA_licence_expiry_date' => '2019-11-20'],
            ['code' => '83','EPRA_licence_no' => 'ERC/LPG/1551','name' => 'TOBENTO INVESTMENTS LTD ','description' => 'KCQ094D','EPRA_licence_expiry_date' => '2019-05-10'],
            ['code' => '84','EPRA_licence_no' => 'ERC/LPG/1587','name' => 'TOGAN TRANSPORTERS LTD ','description' => 'KBW209U-ZC0243, KCQ747B-ZE6821','EPRA_licence_expiry_date' => '2019-04-11'],
            ['code' => '85','EPRA_licence_no' => 'ERC/LPG/1468','name' => 'TOPLINE TRADERS LTD ','description' => 'KBK 085V - ZC 8384, KCG 427M - ZB 6564, KCL 184J - ZG 0310, KCL 185J - ZC 6110, KCH 055T - ZD 3041, KCJ 428L - ZB 8512','EPRA_licence_expiry_date' => '2020-07-21'],
            ['code' => '86','EPRA_licence_no' => 'ERC/LPG/1773','name' => 'TOWFIQ TRANSPORTERS ','description' => 'KBJ089G - ZB7350, KBB161R - ZC8213, KBT936J - ZC7168, KBR543H - ZC8220, KBJ653B - ZD3342, KBF845S - ZC8534, KBP792K - ZD4247','EPRA_licence_expiry_date' => '2020-07-17'],
            ['code' => '87','EPRA_licence_no' => 'ERC/LPG/1724','name' => 'TRINITY PETROLEUM LIMITED ','description' => 'KBL 313A, KBN 313N, KBS 313T, KCM 313Q','EPRA_licence_expiry_date' => '2020-05-23'],
            ['code' => '88','EPRA_licence_no' => 'ERC/LPG/1775','name' => 'TRIPLEA HAULIERS LIMITED ','description' => 'KBN 205T - ZD 5436, KBN 206T - ZD 5437, KBW 984T - ZF 0725, KBQ013L - ZD6931, KBK106W - ZF5777, KBK505T - ZF3867, KBQ014L - ZD6930','EPRA_licence_expiry_date' => '2020-07-18'],
            ['code' => '89','EPRA_licence_no' => 'ERC/LPG/1386','name' => 'TYDES GENERAL MERCHANTS LIMITED ','description' => 'KBL 543P - ZE5389, KCA 920C - ZE7056','EPRA_licence_expiry_date' => '2020-03-17'],
            ['code' => '90','EPRA_licence_no' => 'ERC/LPG/1800','name' => 'ULTRA EUREKA FARM LTD ','description' => 'KCH 719H - ZG0972, KCT 021B - ZG0971, KCU 502H - ZG0970, KCV165P - ZG0968','EPRA_licence_expiry_date' => '2020-08-20'],
            ['code' => '91','EPRA_licence_no' => 'ERC/LPG/1421','name' => 'UNIGAS KENYA LIMITED ','description' => 'KBT 162H, KCA 982P - ZE6897, KCB 062A - ZE6896','EPRA_licence_expiry_date' => '2020-05-23'],
            ['code' => '92','EPRA_licence_no' => 'ERC/LPG/1620','name' => 'WAJIJI INTERNATIONAL ','description' => 'KBL 244K, KBK 469V, KAX 421U','EPRA_licence_expiry_date' => '2020-01-14'],
            ['code' => '93','EPRA_licence_no' => 'ERC/LPG/1679','name' => 'WARSAME ENERGY LIMITED ','description' => 'KCT 365J - ZG 0439','EPRA_licence_expiry_date' => '2020-04-04'],
            ['code' => '94','EPRA_licence_no' => 'ERC/LPG/1248','name' => 'YAS INVESTMENTS (K) LIMITED ','description' => 'KBQ697R â€“ZC 0928','EPRA_licence_expiry_date' => '2019-11-20'],
            ['code' => '95','EPRA_licence_no' => 'ERC/LPG/1631','name' => 'ZTE GAZ SOLUTIONS LIMITED ','description' => 'KBH 375U - ZC5984','EPRA_licence_expiry_date' => '2020-11-02'],

        ];

        DB::table('transporters')->insert($transporters);
    }
}
