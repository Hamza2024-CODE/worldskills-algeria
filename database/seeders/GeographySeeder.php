<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Region;
use App\Models\Wilaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GeographySeeder extends Seeder
{
    public function run(): void
    {
        // 54 Sovereign African Countries Dataset (Trilingual AR/FR/EN)
        $africanCountries = [
            ['code' => 'DZ', 'iso3' => 'DZA', 'en' => 'Algeria', 'fr' => 'Algérie', 'ar' => 'الجزائر', 'enNat' => 'Algerian', 'frNat' => 'Algérien', 'arNat' => 'جزائري', 'is_algeria' => true],
            ['code' => 'AO', 'iso3' => 'AGO', 'en' => 'Angola', 'fr' => 'Angola', 'ar' => 'أنغولا', 'enNat' => 'Angolan', 'frNat' => 'Angolais', 'arNat' => 'أنغولي', 'is_algeria' => false],
            ['code' => 'BJ', 'iso3' => 'BEN', 'en' => 'Benin', 'fr' => 'Bénin', 'ar' => 'بنين', 'enNat' => 'Beninese', 'frNat' => 'Béninois', 'arNat' => 'بنيني', 'is_algeria' => false],
            ['code' => 'BW', 'iso3' => 'BWA', 'en' => 'Botswana', 'fr' => 'Botswana', 'ar' => 'بوتسوانا', 'enNat' => 'Botswanan', 'frNat' => 'Botswanais', 'arNat' => 'بوتسواني', 'is_algeria' => false],
            ['code' => 'BF', 'iso3' => 'BFA', 'en' => 'Burkina Faso', 'fr' => 'Burkina Faso', 'ar' => 'بوركينا فاسو', 'enNat' => 'Burkinabe', 'frNat' => 'Burkinabè', 'arNat' => 'بوركيني', 'is_algeria' => false],
            ['code' => 'BI', 'iso3' => 'BDI', 'en' => 'Burundi', 'fr' => 'Burundi', 'ar' => 'بوروندي', 'enNat' => 'Burundian', 'frNat' => 'Burundais', 'arNat' => 'بوروندي', 'is_algeria' => false],
            ['code' => 'CV', 'iso3' => 'CPV', 'en' => 'Cape Verde', 'fr' => 'Cap-Vert', 'ar' => 'الرأس الأخضر', 'enNat' => 'Cape Verdean', 'frNat' => 'Cap-Verdien', 'arNat' => 'رأس أخضري', 'is_algeria' => false],
            ['code' => 'CM', 'iso3' => 'CMR', 'en' => 'Cameroon', 'fr' => 'Cameroun', 'ar' => 'الكاميرون', 'enNat' => 'Cameroonian', 'frNat' => 'Camerounais', 'arNat' => 'كاميروني', 'is_algeria' => false],
            ['code' => 'CF', 'iso3' => 'CAF', 'en' => 'Central African Republic', 'fr' => 'République centrafricaine', 'ar' => 'جمهورية أفريقيا الوسطى', 'enNat' => 'Central African', 'frNat' => 'Centrafricain', 'arNat' => 'أفريقي أوسطي', 'is_algeria' => false],
            ['code' => 'TD', 'iso3' => 'TCD', 'en' => 'Chad', 'fr' => 'Tchad', 'ar' => 'تشاد', 'enNat' => 'Chadian', 'frNat' => 'Tchadien', 'arNat' => 'تشادي', 'is_algeria' => false],
            ['code' => 'KM', 'iso3' => 'COM', 'en' => 'Comoros', 'fr' => 'Comores', 'ar' => 'جزر القمر', 'enNat' => 'Comorian', 'frNat' => 'Comorien', 'arNat' => 'قمري', 'is_algeria' => false],
            ['code' => 'CG', 'iso3' => 'COG', 'en' => 'Republic of the Congo', 'fr' => 'République du Congo', 'ar' => 'جمهورية الكونغو', 'enNat' => 'Congolese', 'frNat' => 'Congolais', 'arNat' => 'كونغولي', 'is_algeria' => false],
            ['code' => 'CD', 'iso3' => 'COD', 'en' => 'Democratic Republic of the Congo', 'fr' => 'République démocratique du Congo', 'ar' => 'جمهورية الكونغو الديمقراطية', 'enNat' => 'Congolese', 'frNat' => 'Congolais', 'arNat' => 'كونغولي', 'is_algeria' => false],
            ['code' => 'CI', 'iso3' => 'CIV', 'en' => "Côte d'Ivoire", 'fr' => "Côte d'Ivoire", 'ar' => 'ساحل العاج', 'enNat' => 'Ivoirian', 'frNat' => 'Ivoirien', 'arNat' => 'إيفواري', 'is_algeria' => false],
            ['code' => 'DJ', 'iso3' => 'DJI', 'en' => 'Djibouti', 'fr' => 'Djibouti', 'ar' => 'جيبوتي', 'enNat' => 'Djiboutian', 'frNat' => 'Djiboutien', 'arNat' => 'جيبوتي', 'is_algeria' => false],
            ['code' => 'EG', 'iso3' => 'EGY', 'en' => 'Egypt', 'fr' => 'Égypte', 'ar' => 'مصر', 'enNat' => 'Egyptian', 'frNat' => 'Égyptien', 'arNat' => 'مصري', 'is_algeria' => false],
            ['code' => 'GQ', 'iso3' => 'GNQ', 'en' => 'Equatorial Guinea', 'fr' => 'Guinée équatoriale', 'ar' => 'غينيا الاستوائية', 'enNat' => 'Equatorial Guinean', 'frNat' => 'Équato-guinéen', 'arNat' => 'غيني استوائي', 'is_algeria' => false],
            ['code' => 'ER', 'iso3' => 'ERI', 'en' => 'Eritrea', 'fr' => 'Érythrée', 'ar' => 'إريتريا', 'enNat' => 'Eritrean', 'frNat' => 'Érythréen', 'arNat' => 'إريتري', 'is_algeria' => false],
            ['code' => 'SZ', 'iso3' => 'SWZ', 'en' => 'Eswatini', 'fr' => 'Eswatini', 'ar' => 'إسواتيني', 'enNat' => 'Swazi', 'frNat' => 'Eswatinien', 'arNat' => 'إسواتيني', 'is_algeria' => false],
            ['code' => 'ET', 'iso3' => 'ETH', 'en' => 'Ethiopia', 'fr' => 'Éthiopie', 'ar' => 'إثيوبيا', 'enNat' => 'Ethiopian', 'frNat' => 'Éthiopien', 'arNat' => 'إثيوبي', 'is_algeria' => false],
            ['code' => 'GA', 'iso3' => 'GAB', 'en' => 'Gabon', 'fr' => 'Gabon', 'ar' => 'الغابون', 'enNat' => 'Gabonese', 'frNat' => 'Gabonais', 'arNat' => 'غابوني', 'is_algeria' => false],
            ['code' => 'GM', 'iso3' => 'GMB', 'en' => 'Gambia', 'fr' => 'Gambie', 'ar' => 'غامبيا', 'enNat' => 'Gambian', 'frNat' => 'Gambien', 'arNat' => 'غامبي', 'is_algeria' => false],
            ['code' => 'GH', 'iso3' => 'GHA', 'en' => 'Ghana', 'fr' => 'Ghana', 'ar' => 'غانا', 'enNat' => 'Ghanaian', 'frNat' => 'Ghanéen', 'arNat' => 'غاني', 'is_algeria' => false],
            ['code' => 'GN', 'iso3' => 'GIN', 'en' => 'Guinea', 'fr' => 'Guinée', 'ar' => 'غينيا', 'enNat' => 'Guinean', 'frNat' => 'Guinéen', 'arNat' => 'غيني', 'is_algeria' => false],
            ['code' => 'GW', 'iso3' => 'GNB', 'en' => 'Guinea-Bissau', 'fr' => 'Guinée-Bissau', 'ar' => 'غينيا بيساو', 'enNat' => 'Bissau-Guinean', 'frNat' => 'Bissau-Guinéen', 'arNat' => 'غيني بيساوي', 'is_algeria' => false],
            ['code' => 'KE', 'iso3' => 'KEN', 'en' => 'Kenya', 'fr' => 'Kenya', 'ar' => 'كينيا', 'enNat' => 'Kenyan', 'frNat' => 'Kényan', 'arNat' => 'كيني', 'is_algeria' => false],
            ['code' => 'LS', 'iso3' => 'LSO', 'en' => 'Lesotho', 'fr' => 'Lesotho', 'ar' => 'ليسوتو', 'enNat' => 'Basotho', 'frNat' => 'Lésothien', 'arNat' => 'ليسوتي', 'is_algeria' => false],
            ['code' => 'LR', 'iso3' => 'LBR', 'en' => 'Liberia', 'fr' => 'Libéria', 'ar' => 'ليبيريا', 'enNat' => 'Liberian', 'frNat' => 'Libérien', 'arNat' => 'ليبيري', 'is_algeria' => false],
            ['code' => 'LY', 'iso3' => 'LBY', 'en' => 'Libya', 'fr' => 'Libye', 'ar' => 'ليبيا', 'enNat' => 'Libyan', 'frNat' => 'Libyen', 'arNat' => 'ليبي', 'is_algeria' => false],
            ['code' => 'MG', 'iso3' => 'MDG', 'en' => 'Madagascar', 'fr' => 'Madagascar', 'ar' => 'مدغشقر', 'enNat' => 'Malagasy', 'frNat' => 'Malgache', 'arNat' => 'مدغشقري', 'is_algeria' => false],
            ['code' => 'MW', 'iso3' => 'MWI', 'en' => 'Malawi', 'fr' => 'Malawi', 'ar' => 'ملاوي', 'enNat' => 'Malawian', 'frNat' => 'Malawite', 'arNat' => 'ملاوي', 'is_algeria' => false],
            ['code' => 'ML', 'iso3' => 'MLI', 'en' => 'Mali', 'fr' => 'Mali', 'ar' => 'مالي', 'enNat' => 'Malian', 'frNat' => 'Malien', 'arNat' => 'مالي', 'is_algeria' => false],
            ['code' => 'MR', 'iso3' => 'MRT', 'en' => 'Mauritania', 'fr' => 'Mauritanie', 'ar' => 'موريتانيا', 'enNat' => 'Mauritanian', 'frNat' => 'Mauritanien', 'arNat' => 'موريتاني', 'is_algeria' => false],
            ['code' => 'MU', 'iso3' => 'MUS', 'en' => 'Mauritius', 'fr' => 'Maurice', 'ar' => 'موريشيوس', 'enNat' => 'Mauritian', 'frNat' => 'Mauricien', 'arNat' => 'موريشيوسي', 'is_algeria' => false],
            ['code' => 'MA', 'iso3' => 'MAR', 'en' => 'Morocco', 'fr' => 'Maroc', 'ar' => 'المغرب', 'enNat' => 'Moroccan', 'frNat' => 'Marocain', 'arNat' => 'مغربي', 'is_algeria' => false],
            ['code' => 'MZ', 'iso3' => 'MOZ', 'en' => 'Mozambique', 'fr' => 'Mozambique', 'ar' => 'موزمبيق', 'enNat' => 'Mozambican', 'frNat' => 'Mozambicain', 'arNat' => 'موزمبيقي', 'is_algeria' => false],
            ['code' => 'NA', 'iso3' => 'NAM', 'en' => 'Namibia', 'fr' => 'Namibie', 'ar' => 'ناميبيا', 'enNat' => 'Namibian', 'frNat' => 'Namibien', 'arNat' => 'ناميبي', 'is_algeria' => false],
            ['code' => 'NE', 'iso3' => 'NER', 'en' => 'Niger', 'fr' => 'Niger', 'ar' => 'النيجر', 'enNat' => 'Nigerien', 'frNat' => 'Nigérien', 'arNat' => 'نيجيري', 'is_algeria' => false],
            ['code' => 'NG', 'iso3' => 'NGA', 'en' => 'Nigeria', 'fr' => 'Nigéria', 'ar' => 'نيجيريا', 'enNat' => 'Nigerian', 'frNat' => 'Nigérian', 'arNat' => 'نيجيري', 'is_algeria' => false],
            ['code' => 'RW', 'iso3' => 'RWA', 'en' => 'Rwanda', 'fr' => 'Rwanda', 'ar' => 'رواندا', 'enNat' => 'Rwandan', 'frNat' => 'Rwandais', 'arNat' => 'رواندي', 'is_algeria' => false],
            ['code' => 'ST', 'iso3' => 'STP', 'en' => 'Sao Tome and Principe', 'fr' => 'Sao Tomé-et-Principe', 'ar' => 'ساو تومي وبرينسيبي', 'enNat' => 'São Toméan', 'frNat' => 'Santoméen', 'arNat' => 'ساو تومي', 'is_algeria' => false],
            ['code' => 'SN', 'iso3' => 'SEN', 'en' => 'Senegal', 'fr' => 'Sénégal', 'ar' => 'السنغال', 'enNat' => 'Senegalese', 'frNat' => 'Sénégalais', 'arNat' => 'سنغالي', 'is_algeria' => false],
            ['code' => 'SC', 'iso3' => 'SYC', 'en' => 'Seychelles', 'fr' => 'Seychelles', 'ar' => 'سيشل', 'enNat' => 'Seychellois', 'frNat' => 'Seychellois', 'arNat' => 'سيشيلي', 'is_algeria' => false],
            ['code' => 'SL', 'iso3' => 'SLE', 'en' => 'Sierra Leone', 'fr' => 'Sierra Leone', 'ar' => 'سيراليون', 'enNat' => 'Sierra Leonean', 'frNat' => 'Sierra-Léonais', 'arNat' => 'سيراليوني', 'is_algeria' => false],
            ['code' => 'SO', 'iso3' => 'SOM', 'en' => 'Somalia', 'fr' => 'Somalie', 'ar' => 'الصومال', 'enNat' => 'Somali', 'frNat' => 'Somalien', 'arNat' => 'صومالي', 'is_algeria' => false],
            ['code' => 'ZA', 'iso3' => 'ZAF', 'en' => 'South Africa', 'fr' => 'Afrique du Sud', 'ar' => 'جنوب أفريقيا', 'enNat' => 'South African', 'frNat' => 'Sud-Africain', 'arNat' => 'جنوب أفريقي', 'is_algeria' => false],
            ['code' => 'SS', 'iso3' => 'SSD', 'en' => 'South Sudan', 'fr' => 'Soudan du Sud', 'ar' => 'جنوب السودان', 'enNat' => 'South Sudanese', 'frNat' => 'Sud-Soudanais', 'arNat' => 'جنوب سوداني', 'is_algeria' => false],
            ['code' => 'SD', 'iso3' => 'SDN', 'en' => 'Sudan', 'fr' => 'Soudan', 'ar' => 'السودان', 'enNat' => 'Sudanese', 'frNat' => 'Soudanais', 'arNat' => 'سوداني', 'is_algeria' => false],
            ['code' => 'TZ', 'iso3' => 'TZA', 'en' => 'Tanzania', 'fr' => 'Tanzanie', 'ar' => 'تنزانيا', 'enNat' => 'Tanzanian', 'frNat' => 'Tanzanien', 'arNat' => 'تنزاني', 'is_algeria' => false],
            ['code' => 'TG', 'iso3' => 'TGO', 'en' => 'Togo', 'fr' => 'Togo', 'ar' => 'توغو', 'enNat' => 'Togolese', 'frNat' => 'Togolais', 'arNat' => 'توغولي', 'is_algeria' => false],
            ['code' => 'TN', 'iso3' => 'TUN', 'en' => 'Tunisia', 'fr' => 'Tunisie', 'ar' => 'تونس', 'enNat' => 'Tunisian', 'frNat' => 'Tunisien', 'arNat' => 'تونسي', 'is_algeria' => false],
            ['code' => 'UG', 'iso3' => 'UGA', 'en' => 'Uganda', 'fr' => 'Ouganda', 'ar' => 'أوغندا', 'enNat' => 'Ugandan', 'frNat' => 'Ougandais', 'arNat' => 'أوغندي', 'is_algeria' => false],
            ['code' => 'ZM', 'iso3' => 'ZMB', 'en' => 'Zambia', 'fr' => 'Zambie', 'ar' => 'زامبيا', 'enNat' => 'Zambian', 'frNat' => 'Zambien', 'arNat' => 'زامبي', 'is_algeria' => false],
            ['code' => 'ZW', 'iso3' => 'ZWE', 'en' => 'Zimbabwe', 'fr' => 'Zimbabwe', 'ar' => 'زيمبابوي', 'enNat' => 'Zimbabwean', 'frNat' => 'Zimbabwéen', 'arNat' => 'زيمبابوي', 'is_algeria' => false],
        ];

        $phoneCodes = [
            'DZ' => '+213', 'AO' => '+244', 'BJ' => '+229', 'BW' => '+267', 'BF' => '+226',
            'BI' => '+257', 'CV' => '+238', 'CM' => '+237', 'CF' => '+236', 'TD' => '+235',
            'KM' => '+269', 'CG' => '+242', 'CD' => '+243', 'CI' => '+225', 'DJ' => '+253',
            'EG' => '+20',  'GQ' => '+240', 'ER' => '+291', 'SZ' => '+268', 'ET' => '+251',
            'GA' => '+241', 'GM' => '+220', 'GH' => '+233', 'GN' => '+224', 'GW' => '+245',
            'KE' => '+254', 'LS' => '+266', 'LR' => '+231', 'LY' => '+218', 'MG' => '+261',
            'MW' => '+265', 'ML' => '+223', 'MR' => '+222', 'MU' => '+230', 'MA' => '+212',
            'MZ' => '+258', 'NA' => '+264', 'NE' => '+227', 'NG' => '+234', 'RW' => '+250',
            'ST' => '+239', 'SN' => '+221', 'SC' => '+248', 'SL' => '+232', 'SO' => '+252',
            'ZA' => '+27',  'SS' => '+211', 'SD' => '+249', 'TZ' => '+255', 'TG' => '+228',
            'TN' => '+216', 'UG' => '+256', 'ZM' => '+260', 'ZW' => '+263',
        ];

        foreach ($africanCountries as $c) {
            Country::updateOrCreate(
                ['iso2' => $c['code']],
                [
                    'uuid' => (string) Str::uuid(),
                    'iso3' => $c['iso3'],
                    'name_ar' => $c['ar'],
                    'name_fr' => $c['fr'],
                    'name_en' => $c['en'],
                    'nationality_ar' => $c['arNat'],
                    'nationality_fr' => $c['frNat'],
                    'nationality_en' => $c['enNat'],
                    'phone_code' => $phoneCodes[$c['code']] ?? '+213',
                    'flag' => strtolower($c['code']) . '.png',
                    'is_african' => true,
                    'is_algeria' => $c['is_algeria'],
                    'requires_passport' => !$c['is_algeria'],
                    'requires_national_id' => $c['is_algeria'],
                    'is_active' => true,
                ]
            );
        }

        // 2. Algerian Regions
        $regions = [
            'NORTH' => ['ar' => 'المنطقة الشمالية (الجزائر)', 'fr' => 'Région Nord'],
            'EAST' => ['ar' => 'المنطقة الشرقية (قسنطينة)', 'fr' => 'Région Est'],
            'WEST' => ['ar' => 'المنطقة الغربية (وهران)', 'fr' => 'Région Ouest'],
            'SOUTH' => ['ar' => 'المنطقة الجنوبية (غرداية / بشار)', 'fr' => 'Région Sud'],
        ];

        $regionModels = [];
        foreach ($regions as $code => $reg) {
            $regionModels[$code] = Region::updateOrCreate(
                ['code' => $code],
                ['name_ar' => $reg['ar'], 'name_fr' => $reg['fr']]
            );
        }

        // 3. 58 Wilayas of Algeria
        $wilayasList = [
            '01' => ['Adrar', 'أدرار', 'SOUTH'],
            '02' => ['Chlef', 'الشلف', 'WEST'],
            '03' => ['Laghouat', 'الأغواط', 'SOUTH'],
            '04' => ['Oum El Bouaghi', 'أم البواقي', 'EAST'],
            '05' => ['Batna', 'باتنة', 'EAST'],
            '06' => ['Béjaïa', 'بجاية', 'NORTH'],
            '07' => ['Biskra', 'بسكرة', 'SOUTH'],
            '08' => ['Béchar', 'بشار', 'SOUTH'],
            '09' => ['Blida', 'البليدة', 'NORTH'],
            '10' => ['Bouira', 'البويرة', 'NORTH'],
            '11' => ['Tamanrasset', 'تمنراست', 'SOUTH'],
            '12' => ['Tébessa', 'تبسة', 'EAST'],
            '13' => ['Tlemcen', 'تلمسان', 'WEST'],
            '14' => ['Tiaret', 'تيارت', 'WEST'],
            '15' => ['Tizi Ouzou', 'تيزي وزو', 'NORTH'],
            '16' => ['Alger', 'الجزائر', 'NORTH'],
            '17' => ['Djelfa', 'الجلفة', 'SOUTH'],
            '18' => ['Jijel', 'جيجل', 'EAST'],
            '19' => ['Sétif', 'سطيف', 'EAST'],
            '20' => ['Saïda', 'سعيدة', 'WEST'],
            '21' => ['Skikda', 'سكيكدة', 'EAST'],
            '22' => ['Sidi Bel Abbès', 'سيدي بلعباس', 'WEST'],
            '23' => ['Annaba', 'عنابة', 'EAST'],
            '24' => ['Guelma', 'قالمة', 'EAST'],
            '25' => ['Constantine', 'قسنطينة', 'EAST'],
            '26' => ['Médéa', 'المدية', 'NORTH'],
            '27' => ['Mostaganem', 'مستغانم', 'WEST'],
            '28' => ["M'Sila", 'المسيلة', 'EAST'],
            '29' => ['Mascara', 'معسكر', 'WEST'],
            '30' => ['Ouargla', 'ورقلة', 'SOUTH'],
            '31' => ['Oran', 'وهران', 'WEST'],
            '32' => ['El Bayadh', 'البيض', 'SOUTH'],
            '33' => ['Illizi', 'إليزي', 'SOUTH'],
            '34' => ['Bordj Bou Arréridj', 'برج بوعريريج', 'EAST'],
            '35' => ['Boumerdès', 'بومرداس', 'NORTH'],
            '36' => ['El Tarf', 'الطارف', 'EAST'],
            '37' => ['Tindouf', 'تندوف', 'SOUTH'],
            '38' => ['Tissemsilt', 'تيسمسيلت', 'WEST'],
            '39' => ['El Oued', 'الوادي', 'SOUTH'],
            '40' => ['Khenchela', 'خنشلة', 'EAST'],
            '41' => ['Souk Ahras', 'سوق أهراس', 'EAST'],
            '42' => ['Tipaza', 'تيبازة', 'NORTH'],
            '43' => ['Mila', 'ميلة', 'EAST'],
            '44' => ['Aïn Defla', 'عين الدفلى', 'NORTH'],
            '45' => ['Naâma', 'النعامة', 'SOUTH'],
            '46' => ['Aïn Témouchent', 'عين تموشنت', 'WEST'],
            '47' => ['Ghardaïa', 'غرداية', 'SOUTH'],
            '48' => ['Relizane', 'غليزان', 'WEST'],
            '49' => ['Timimoun', 'تيميمون', 'SOUTH'],
            '50' => ['Bordj Badji Mokhtar', 'برج باجي مختار', 'SOUTH'],
            '51' => ['Ouled Djellal', 'أولاد جلال', 'SOUTH'],
            '52' => ['Béni Abbès', 'بني عباس', 'SOUTH'],
            '53' => ['In Salah', 'عين صالح', 'SOUTH'],
            '54' => ['In Guezzam', 'عين قزام', 'SOUTH'],
            '55' => ['Touggourt', 'تقرت', 'SOUTH'],
            '56' => ['Djanet', 'جانت', 'SOUTH'],
            '57' => ['El M\'Ghair', 'المغير', 'SOUTH'],
            '58' => ['El Meniaa', 'المنيعة', 'SOUTH'],
        ];

        foreach ($wilayasList as $code => $data) {
            Wilaya::updateOrCreate(
                ['code' => $code],
                [
                    'name_fr' => $data[0],
                    'name_ar' => $data[1],
                    'region_id' => $regionModels[$data[2]]->id ?? null,
                ]
            );
        }
    }
}
