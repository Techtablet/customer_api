<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('customer_countries', function (Blueprint $table) {
            // Clé primaire
            $table->id('id_customer_country');
            
            // Noms du pays dans différentes langues
            $table->string('name', 200)->comment('Nom du pays en français');
            $table->string('name_en', 70)->comment('Nom du pays en anglais');
            $table->string('name_de', 70)->comment('Nom du pays en allemand');
            
            // Codes standards
            $table->string('isocode', 5)->comment('Code ISO du pays');
            $table->integer('ccn3')->nullable()->default(null)->comment('Code numérique du pays');
            $table->string('phone_code', 10)->nullable()->default(null)->comment('Indicatif téléphonique');
            
            // Flags métier
            $table->tinyInteger('is_intracom_vat')->default(0)->comment('Pays intracommunautaire pour TVA. Ancienne Table : apb_country_tva_intra');
            $table->tinyInteger('is_ue_export')->default(0)->comment('Pays UE pour export');
            
            // Index pour performances
            $table->index('isocode');
            $table->index(['is_intracom_vat', 'is_ue_export']);

            // Timestamps automatiques
            $table->timestamps();
        });

        // Données des pays TVA intracommunautaire
        $intracomCountries = [
            'Allemagne' => 1,
            'Autriche' => 1,
            'Belgique' => 1,
            'Bulgarie' => 1,
            'Chypre' => 0,
            'Croatie' => 1,
            'Danemark' => 1,
            'Espagne' => 1,
            'Estonie' => 1,
            'Finlande' => 1,
            'Grèce' => 1,
            'Hongrie' => 1,
            'Irlande' => 1,
            'Italie' => 1,
            'Lettonie' => 1,
            'Lituanie' => 1,
            'Luxembourg' => 1,
            'Malte' => 1,
            'Pays-Bas' => 1,
            'Pologne' => 1,
            'Portugal' => 1,
            'République Tchèque' => 1,
            'Roumanie' => 1,
            'Slovaquie' => 1,
            'Slovénie' => 1,
            'Suède' => 1,
            'Suisse' => 1,
            'Koweit' => 0,
            'Guadeloupe' => 0,
            'Israel' => 0
        ];

        $timestamp = Carbon::now();

        // Insertion des données
        $countriesData = [
            ['id_customer_country' => 1, 'name' => 'France', 'name_en' => 'France', 'name_de' => 'Frankreich', 'isocode' => 'FR', 'ccn3' => 250, 'phone_code' => '+33'],
            ['id_customer_country' => 2, 'name' => 'Luxembourg', 'name_en' => 'Luxembourg', 'name_de' => 'Luxemburg', 'isocode' => 'LU', 'ccn3' => 442, 'phone_code' => '+352'],
            ['id_customer_country' => 3, 'name' => 'U.S.A.', 'name_en' => 'U.S.A.', 'name_de' => 'U.S.A.', 'isocode' => 'US', 'ccn3' => 840, 'phone_code' => '+1'],
            ['id_customer_country' => 4, 'name' => 'United Kingdom', 'name_en' => 'United Kingdom', 'name_de' => 'United Kingdom', 'isocode' => 'GB', 'ccn3' => 826, 'phone_code' => '+44'],
            ['id_customer_country' => 5, 'name' => 'Suisse', 'name_en' => 'Switzerland', 'name_de' => 'Schweiz', 'isocode' => 'CH', 'ccn3' => 756, 'phone_code' => '+41'],
            ['id_customer_country' => 6, 'name' => 'Belgique', 'name_en' => 'Belgium', 'name_de' => 'Belgien', 'isocode' => 'BE', 'ccn3' => 56, 'phone_code' => '+32'],
            ['id_customer_country' => 7, 'name' => 'Allemagne', 'name_en' => 'Germany', 'name_de' => 'Deutschland', 'isocode' => 'DE', 'ccn3' => 276, 'phone_code' => '+49'],
            ['id_customer_country' => 8, 'name' => 'Espagne', 'name_en' => 'Spain', 'name_de' => 'Spanien', 'isocode' => 'ES', 'ccn3' => 724, 'phone_code' => '+34'],
            ['id_customer_country' => 9, 'name' => 'Italie', 'name_en' => 'Italy', 'name_de' => 'Italien', 'isocode' => 'IT', 'ccn3' => 380, 'phone_code' => '+39'],
            ['id_customer_country' => 10, 'name' => 'Pays-Bas', 'name_en' => 'Netherlands', 'name_de' => 'Niederlande', 'isocode' => 'NL', 'ccn3' => 528, 'phone_code' => '+31'],
            ['id_customer_country' => 11, 'name' => 'Grèce', 'name_en' => 'Greece', 'name_de' => 'Griechenland', 'isocode' => 'GR', 'ccn3' => 300, 'phone_code' => '+30'],
            ['id_customer_country' => 12, 'name' => 'Faroe Island', 'name_en' => 'Faroe Island', 'name_de' => 'Färöer-Inseln', 'isocode' => 'DK', 'ccn3' => 208, 'phone_code' => '+45'],
            ['id_customer_country' => 13, 'name' => 'Koweit', 'name_en' => 'Kuwait', 'name_de' => 'Kuwait', 'isocode' => 'KW', 'ccn3' => 414, 'phone_code' => '+965'],
            ['id_customer_country' => 14, 'name' => 'Israel', 'name_en' => 'Israel', 'name_de' => 'Israel', 'isocode' => 'IL', 'ccn3' => 376, 'phone_code' => '+972'],
            ['id_customer_country' => 15, 'name' => 'Autriche', 'name_en' => 'Austria', 'name_de' => 'Österreich', 'isocode' => 'AT', 'ccn3' => 40, 'phone_code' => '+43'],
            ['id_customer_country' => 16, 'name' => 'Irlande', 'name_en' => 'Ireland', 'name_de' => 'Irland', 'isocode' => 'IE', 'ccn3' => 372, 'phone_code' => '+353'],
            ['id_customer_country' => 17, 'name' => 'Polynesie francaise', 'name_en' => 'French Polynesia', 'name_de' => 'Französisch-Polynesien', 'isocode' => 'PF', 'ccn3' => 258, 'phone_code' => '+689'],
            ['id_customer_country' => 18, 'name' => 'Ukraine', 'name_en' => 'Ukraine', 'name_de' => 'Ukraine', 'isocode' => 'UA', 'ccn3' => 804, 'phone_code' => '+380'],
            ['id_customer_country' => 20, 'name' => 'Royaume-Uni', 'name_en' => 'United Kingdom', 'name_de' => 'Vereinigtes Königreich', 'isocode' => 'GB', 'ccn3' => 826, 'phone_code' => null],
            ['id_customer_country' => 21, 'name' => 'Pologne', 'name_en' => 'Poland', 'name_de' => 'Polen', 'isocode' => 'PL', 'ccn3' => 616, 'phone_code' => '+48'],
            ['id_customer_country' => 23, 'name' => 'Chypre', 'name_en' => 'Cyprus', 'name_de' => 'Zypern', 'isocode' => 'CY', 'ccn3' => 196, 'phone_code' => '+357'],
            ['id_customer_country' => 24, 'name' => 'République Tchèque', 'name_en' => 'Czech Republic', 'name_de' => 'Tschechische Republik', 'isocode' => 'CZ', 'ccn3' => 203, 'phone_code' => '+420'],
            ['id_customer_country' => 25, 'name' => 'Roumanie', 'name_en' => 'Romania', 'name_de' => 'Rumänien', 'isocode' => 'RO', 'ccn3' => 642, 'phone_code' => '+40'],
            ['id_customer_country' => 26, 'name' => 'Brésil', 'name_en' => 'Brazil', 'name_de' => 'Brasilien', 'isocode' => 'BR', 'ccn3' => 76, 'phone_code' => '+55'],
            ['id_customer_country' => 27, 'name' => 'Japan', 'name_en' => 'Japan', 'name_de' => 'Japan', 'isocode' => 'JP', 'ccn3' => 392, 'phone_code' => '+81'],
            ['id_customer_country' => 28, 'name' => 'Egypte', 'name_en' => 'Egypt', 'name_de' => 'Ägypten', 'isocode' => 'EG', 'ccn3' => 818, 'phone_code' => '+20'],
            ['id_customer_country' => 29, 'name' => 'Émirats Arabes Unis', 'name_en' => 'United Arab Emirates', 'name_de' => 'Vereinigte Arabische Emirate', 'isocode' => 'AE', 'ccn3' => 784, 'phone_code' => '+971'],
            ['id_customer_country' => 30, 'name' => 'Paraguay', 'name_en' => 'Paraguay', 'name_de' => 'Paraguay', 'isocode' => 'PY', 'ccn3' => 600, 'phone_code' => '+595'],
            ['id_customer_country' => 31, 'name' => 'Croatie', 'name_en' => 'Croatia', 'name_de' => 'Kroatien', 'isocode' => 'HR', 'ccn3' => 191, 'phone_code' => '+385'],
            ['id_customer_country' => 32, 'name' => 'Portugal', 'name_en' => 'Portugal', 'name_de' => 'Portugal', 'isocode' => 'PT', 'ccn3' => 620, 'phone_code' => '+351'],
            ['id_customer_country' => 33, 'name' => 'Danemark', 'name_en' => 'Denmark', 'name_de' => 'Dänemark', 'isocode' => 'DK', 'ccn3' => 208, 'phone_code' => null],
            ['id_customer_country' => 34, 'name' => 'Guadeloupe', 'name_en' => 'Guadeloupe', 'name_de' => 'Guadeloupe', 'isocode' => 'GP', 'ccn3' => 312, 'phone_code' => '+590'],
            ['id_customer_country' => 35, 'name' => 'Mayotte', 'name_en' => 'Mayotte', 'name_de' => 'Mayotte', 'isocode' => 'YT', 'ccn3' => 175, 'phone_code' => '+262'],
            ['id_customer_country' => 36, 'name' => 'La Réunion', 'name_en' => 'Réunion', 'name_de' => 'Réunion', 'isocode' => 'RE', 'ccn3' => 638, 'phone_code' => '+262'],
            ['id_customer_country' => 37, 'name' => 'Australie', 'name_en' => 'Australia', 'name_de' => 'Australien', 'isocode' => 'AU', 'ccn3' => 36, 'phone_code' => '+61'],
            ['id_customer_country' => 38, 'name' => 'Nouvelle Zélande', 'name_en' => 'New Zealand', 'name_de' => 'Neuseeland', 'isocode' => 'NZ', 'ccn3' => 554, 'phone_code' => '+64'],
            ['id_customer_country' => 39, 'name' => 'Suède', 'name_en' => 'Sweden', 'name_de' => 'Schweden', 'isocode' => 'SE', 'ccn3' => 752, 'phone_code' => '+46'],
            ['id_customer_country' => 40, 'name' => 'Bulgarie', 'name_en' => 'Bulgaria', 'name_de' => 'Bulgarien', 'isocode' => 'BG', 'ccn3' => 100, 'phone_code' => '+359'],
            ['id_customer_country' => 41, 'name' => 'Lituanie', 'name_en' => 'Lithuania', 'name_de' => 'Litauen', 'isocode' => 'LT', 'ccn3' => 440, 'phone_code' => '+370'],
            ['id_customer_country' => 42, 'name' => 'Andorre', 'name_en' => 'Andorra', 'name_de' => 'Andorra', 'isocode' => 'AD', 'ccn3' => 20, 'phone_code' => '+376'],
            ['id_customer_country' => 43, 'name' => 'Afghanistan', 'name_en' => 'Afghanistan', 'name_de' => 'Afghanistan', 'isocode' => 'AF', 'ccn3' => 4, 'phone_code' => '+93'],
            ['id_customer_country' => 44, 'name' => 'Antigua-Et-Barbuda', 'name_en' => 'Antigua and Barbuda', 'name_de' => 'Antigua und Barbuda', 'isocode' => 'AG', 'ccn3' => 28, 'phone_code' => '+1268'],
            ['id_customer_country' => 45, 'name' => 'Anguilla', 'name_en' => 'Anguilla', 'name_de' => 'Anguilla', 'isocode' => 'AI', 'ccn3' => 660, 'phone_code' => '+1264'],
            ['id_customer_country' => 46, 'name' => 'Albanie', 'name_en' => 'Albania', 'name_de' => 'Albanien', 'isocode' => 'AL', 'ccn3' => 8, 'phone_code' => '+355'],
            ['id_customer_country' => 47, 'name' => 'Arménie', 'name_en' => 'Armenia', 'name_de' => 'Armenien', 'isocode' => 'AM', 'ccn3' => 51, 'phone_code' => '+374'],
            ['id_customer_country' => 48, 'name' => 'Angola', 'name_en' => 'Angola', 'name_de' => 'Angola', 'isocode' => 'AO', 'ccn3' => 24, 'phone_code' => '+244'],
            ['id_customer_country' => 50, 'name' => 'Antarctique', 'name_en' => 'Antarctica', 'name_de' => 'Antarktis', 'isocode' => 'AQ', 'ccn3' => 10, 'phone_code' => '+672'],
            ['id_customer_country' => 51, 'name' => 'Argentine', 'name_en' => 'Argentina', 'name_de' => 'Argentinien', 'isocode' => 'AR', 'ccn3' => 32, 'phone_code' => '+54'],
            ['id_customer_country' => 52, 'name' => 'Samoa Américaines', 'name_en' => 'American Samoa', 'name_de' => 'Amerikanisch-Samoa', 'isocode' => 'AS', 'ccn3' => 16, 'phone_code' => '+1684'],
            ['id_customer_country' => 53, 'name' => 'Aruba', 'name_en' => 'Aruba', 'name_de' => 'Aruba', 'isocode' => 'AW', 'ccn3' => 533, 'phone_code' => '+297'],
            ['id_customer_country' => 54, 'name' => 'Îles Åland', 'name_en' => 'Åland Islands', 'name_de' => 'Åland', 'isocode' => 'AX', 'ccn3' => 248, 'phone_code' => '+358'],
            ['id_customer_country' => 55, 'name' => 'Azerbaïdjan', 'name_en' => 'Azerbaijan', 'name_de' => 'Aserbaidschan', 'isocode' => 'AZ', 'ccn3' => 31, 'phone_code' => '+994'],
            ['id_customer_country' => 56, 'name' => 'Bosnie-Herzégovine', 'name_en' => 'Bosnia and Herzegovina', 'name_de' => 'Bosnien und Herzegowina', 'isocode' => 'BA', 'ccn3' => 70, 'phone_code' => '+387'],
            ['id_customer_country' => 57, 'name' => 'Barbad', 'name_en' => 'Barbados', 'name_de' => 'Barbados', 'isocode' => 'BB', 'ccn3' => 52, 'phone_code' => '+1246'],
            ['id_customer_country' => 58, 'name' => 'Bangladesh', 'name_en' => 'Bangladesh', 'name_de' => 'Bangladesch', 'isocode' => 'BD', 'ccn3' => 50, 'phone_code' => '+880'],
            ['id_customer_country' => 59, 'name' => 'Burkina Faso', 'name_en' => 'Burkina Faso', 'name_de' => 'Burkina Faso', 'isocode' => 'BF', 'ccn3' => 854, 'phone_code' => '+226'],
            ['id_customer_country' => 60, 'name' => 'Bahreïn', 'name_en' => 'Bahrain', 'name_de' => 'Bahrain', 'isocode' => 'BH', 'ccn3' => 48, 'phone_code' => '+973'],
            ['id_customer_country' => 61, 'name' => 'Burundi', 'name_en' => 'Burundi', 'name_de' => 'Burundi', 'isocode' => 'BI', 'ccn3' => 108, 'phone_code' => '+257'],
            ['id_customer_country' => 62, 'name' => 'Bénin', 'name_en' => 'Benin', 'name_de' => 'Benin', 'isocode' => 'BJ', 'ccn3' => 204, 'phone_code' => '+229'],
            ['id_customer_country' => 63, 'name' => 'Saint-Barthélemy', 'name_en' => 'Saint Barthélemy', 'name_de' => 'Saint-Barthélemy', 'isocode' => 'BL', 'ccn3' => 652, 'phone_code' => '+590'],
            ['id_customer_country' => 64, 'name' => 'Bermudes', 'name_en' => 'Bermuda', 'name_de' => 'Bermuda', 'isocode' => 'BM', 'ccn3' => 60, 'phone_code' => '+1441'],
            ['id_customer_country' => 65, 'name' => 'Brunei Darussalam', 'name_en' => 'Brunei', 'name_de' => 'Brunei', 'isocode' => 'BN', 'ccn3' => 96, 'phone_code' => '+673'],
            ['id_customer_country' => 66, 'name' => 'État Plurinational De Bolivie', 'name_en' => 'Bolivia', 'name_de' => 'Bolivien', 'isocode' => 'BO', 'ccn3' => 68, 'phone_code' => '+591'],
            ['id_customer_country' => 67, 'name' => 'Bonaire, Saint-Eustache Et Saba', 'name_en' => 'Caribbean Netherlands', 'name_de' => 'Karibische Niederlande', 'isocode' => 'BQ', 'ccn3' => 535, 'phone_code' => null],
            ['id_customer_country' => 68, 'name' => 'Bahamas', 'name_en' => 'Bahamas', 'name_de' => 'Bahamas', 'isocode' => 'BS', 'ccn3' => 44, 'phone_code' => '+1242'],
            ['id_customer_country' => 69, 'name' => 'Bhoutan', 'name_en' => 'Bhutan', 'name_de' => 'Bhutan', 'isocode' => 'BT', 'ccn3' => 64, 'phone_code' => '+975'],
            ['id_customer_country' => 70, 'name' => 'Île Bouvet', 'name_en' => 'Bouvet Island', 'name_de' => 'Bouvetinsel', 'isocode' => 'BV', 'ccn3' => 74, 'phone_code' => null],
            ['id_customer_country' => 71, 'name' => 'Botswana', 'name_en' => 'Botswana', 'name_de' => 'Botswana', 'isocode' => 'BW', 'ccn3' => 72, 'phone_code' => '+267'],
            ['id_customer_country' => 72, 'name' => 'Biélorussie', 'name_en' => 'Belarus', 'name_de' => 'Weißrussland', 'isocode' => 'BY', 'ccn3' => 112, 'phone_code' => '+375'],
            ['id_customer_country' => 73, 'name' => 'Belize', 'name_en' => 'Belize', 'name_de' => 'Belize', 'isocode' => 'BZ', 'ccn3' => 84, 'phone_code' => '+501'],
            ['id_customer_country' => 74, 'name' => 'Canada', 'name_en' => 'Canada', 'name_de' => 'Kanada', 'isocode' => 'CA', 'ccn3' => 124, 'phone_code' => '+1'],
            ['id_customer_country' => 75, 'name' => 'Îles Cocos', 'name_en' => 'Cocos (Keeling) Islands', 'name_de' => 'Kokosinseln', 'isocode' => 'CC', 'ccn3' => 166, 'phone_code' => '+61'],
            ['id_customer_country' => 76, 'name' => 'République Démocratique Du Congo', 'name_en' => 'DR Congo', 'name_de' => 'Kongo (Dem. Rep.)', 'isocode' => 'CD', 'ccn3' => 180, 'phone_code' => '+243'],
            ['id_customer_country' => 77, 'name' => 'République Centrafricaine', 'name_en' => 'Central African Republic', 'name_de' => 'Zentralafrikanische Republik', 'isocode' => 'CF', 'ccn3' => 140, 'phone_code' => '+236'],
            ['id_customer_country' => 78, 'name' => 'Congo', 'name_en' => 'DR Congo', 'name_de' => 'Kongo (Dem. Rep.)', 'isocode' => 'CG', 'ccn3' => 178, 'phone_code' => '+242'],
            ['id_customer_country' => 79, 'name' => 'Côte D\'Ivoire', 'name_en' => 'Ivory Coast', 'name_de' => 'Elfenbeinküste', 'isocode' => 'CI', 'ccn3' => 384, 'phone_code' => '+225'],
            ['id_customer_country' => 80, 'name' => 'Îles Cook', 'name_en' => 'Cook Islands', 'name_de' => 'Cookinseln', 'isocode' => 'CK', 'ccn3' => 184, 'phone_code' => '+682'],
            ['id_customer_country' => 81, 'name' => 'Chili', 'name_en' => 'Chile', 'name_de' => 'Chile', 'isocode' => 'CL', 'ccn3' => 152, 'phone_code' => '+56'],
            ['id_customer_country' => 82, 'name' => 'Cameroun', 'name_en' => 'Cameroon', 'name_de' => 'Kamerun', 'isocode' => 'CM', 'ccn3' => 120, 'phone_code' => '+237'],
            ['id_customer_country' => 83, 'name' => 'Chine', 'name_en' => 'Hong Kong', 'name_de' => 'Hongkong', 'isocode' => 'CN', 'ccn3' => 156, 'phone_code' => '+86'],
            ['id_customer_country' => 84, 'name' => 'Colombie', 'name_en' => 'Colombia', 'name_de' => 'Kolumbien', 'isocode' => 'CO', 'ccn3' => 170, 'phone_code' => '+57'],
            ['id_customer_country' => 85, 'name' => 'Costa Rica', 'name_en' => 'Costa Rica', 'name_de' => 'Costa Rica', 'isocode' => 'CR', 'ccn3' => 188, 'phone_code' => '+506'],
            ['id_customer_country' => 86, 'name' => 'Cuba', 'name_en' => 'Cuba', 'name_de' => 'Kuba', 'isocode' => 'CU', 'ccn3' => 192, 'phone_code' => '+53'],
            ['id_customer_country' => 87, 'name' => 'Cap-Vert', 'name_en' => 'Cape Verde', 'name_de' => 'Kap Verde', 'isocode' => 'CV', 'ccn3' => 132, 'phone_code' => '+238'],
            ['id_customer_country' => 88, 'name' => 'Curaçao', 'name_en' => 'Curaçao', 'name_de' => 'Curaçao', 'isocode' => 'CW', 'ccn3' => 531, 'phone_code' => null],
            ['id_customer_country' => 89, 'name' => 'Île Christmas', 'name_en' => 'Christmas Island', 'name_de' => 'Weihnachtsinsel', 'isocode' => 'CX', 'ccn3' => 162, 'phone_code' => '+61'],
            ['id_customer_country' => 90, 'name' => 'Djibouti', 'name_en' => 'Djibouti', 'name_de' => 'Dschibuti', 'isocode' => 'DJ', 'ccn3' => 262, 'phone_code' => '+253'],
            ['id_customer_country' => 91, 'name' => 'Dominique', 'name_en' => 'Dominica', 'name_de' => 'Dominica', 'isocode' => 'DM', 'ccn3' => 212, 'phone_code' => '+1767'],
            ['id_customer_country' => 92, 'name' => 'République Dominicaine', 'name_en' => 'Dominican Republic', 'name_de' => 'Dominikanische Republik', 'isocode' => 'DO', 'ccn3' => 214, 'phone_code' => '+1849'],
            ['id_customer_country' => 93, 'name' => 'Algérie', 'name_en' => 'Algeria', 'name_de' => 'Algerien', 'isocode' => 'DZ', 'ccn3' => 12, 'phone_code' => '+213'],
            ['id_customer_country' => 94, 'name' => 'Équateur', 'name_en' => 'Ecuador', 'name_de' => 'Ecuador', 'isocode' => 'EC', 'ccn3' => 218, 'phone_code' => '+593'],
            ['id_customer_country' => 95, 'name' => 'Estonie', 'name_en' => 'Estonia', 'name_de' => 'Estland', 'isocode' => 'EE', 'ccn3' => 233, 'phone_code' => '+372'],
            ['id_customer_country' => 96, 'name' => 'Sahara Occidental', 'name_en' => 'Western Sahara', 'name_de' => 'Westsahara', 'isocode' => 'EH', 'ccn3' => 732, 'phone_code' => null],
            ['id_customer_country' => 97, 'name' => 'Érythrée', 'name_en' => 'Eritrea', 'name_de' => 'Eritrea', 'isocode' => 'ER', 'ccn3' => 232, 'phone_code' => '+291'],
            ['id_customer_country' => 98, 'name' => 'Éthiopie', 'name_en' => 'Ethiopia', 'name_de' => 'Äthiopien', 'isocode' => 'ET', 'ccn3' => 231, 'phone_code' => '+251'],
            ['id_customer_country' => 100, 'name' => 'Finlande', 'name_en' => 'Finland', 'name_de' => 'Finnland', 'isocode' => 'FI', 'ccn3' => 246, 'phone_code' => '+358'],
            ['id_customer_country' => 101, 'name' => 'Fidji', 'name_en' => 'Fiji', 'name_de' => 'Fidschi', 'isocode' => 'FJ', 'ccn3' => 242, 'phone_code' => '+679'],
            ['id_customer_country' => 102, 'name' => 'Îles Malouines', 'name_en' => 'Falkland Islands', 'name_de' => 'Falklandinseln', 'isocode' => 'FK', 'ccn3' => 238, 'phone_code' => '+500'],
            ['id_customer_country' => 103, 'name' => 'États Fédérés De Micronésie', 'name_en' => 'Micronesia', 'name_de' => 'Mikronesien', 'isocode' => 'FM', 'ccn3' => 583, 'phone_code' => '+691'],
            ['id_customer_country' => 104, 'name' => 'Îles Féroé', 'name_en' => 'Faroe Islands', 'name_de' => 'Färöer-Inseln', 'isocode' => 'FO', 'ccn3' => 234, 'phone_code' => '+298'],
            ['id_customer_country' => 105, 'name' => 'Gabon', 'name_en' => 'Gabon', 'name_de' => 'Gabun', 'isocode' => 'GA', 'ccn3' => 266, 'phone_code' => '+241'],
            ['id_customer_country' => 106, 'name' => 'Grenade', 'name_en' => 'Grenada', 'name_de' => 'Grenada', 'isocode' => 'GD', 'ccn3' => 308, 'phone_code' => '+1473'],
            ['id_customer_country' => 107, 'name' => 'Géorgie', 'name_en' => 'Georgia', 'name_de' => 'Georgien', 'isocode' => 'GE', 'ccn3' => 268, 'phone_code' => '+995'],
            ['id_customer_country' => 108, 'name' => 'Guyane', 'name_en' => 'French Guiana', 'name_de' => 'Französisch-Guayana', 'isocode' => 'GF', 'ccn3' => 254, 'phone_code' => '+594'],
            ['id_customer_country' => 109, 'name' => 'Guernesey', 'name_en' => 'Guernsey', 'name_de' => 'Guernsey', 'isocode' => 'GG', 'ccn3' => 831, 'phone_code' => '+44'],
            ['id_customer_country' => 110, 'name' => 'Ghana', 'name_en' => 'Ghana', 'name_de' => 'Ghana', 'isocode' => 'GH', 'ccn3' => 288, 'phone_code' => '+233'],
            ['id_customer_country' => 111, 'name' => 'Gibraltar', 'name_en' => 'Gibraltar', 'name_de' => 'Gibraltar', 'isocode' => 'GI', 'ccn3' => 292, 'phone_code' => '+350'],
            ['id_customer_country' => 112, 'name' => 'Groenland', 'name_en' => 'Greenland', 'name_de' => 'Grönland', 'isocode' => 'GL', 'ccn3' => 304, 'phone_code' => '+299'],
            ['id_customer_country' => 113, 'name' => 'Gambie', 'name_en' => 'Gambia', 'name_de' => 'Gambia', 'isocode' => 'GM', 'ccn3' => 270, 'phone_code' => '+220'],
            ['id_customer_country' => 114, 'name' => 'Guinée', 'name_en' => 'Guinea-Bissau', 'name_de' => 'Guinea-Bissau', 'isocode' => 'GN', 'ccn3' => 324, 'phone_code' => '+224'],
            ['id_customer_country' => 115, 'name' => 'Guinée Équatoriale', 'name_en' => 'Equatorial Guinea', 'name_de' => 'Äquatorialguinea', 'isocode' => 'GQ', 'ccn3' => 226, 'phone_code' => '+240'],
            ['id_customer_country' => 116, 'name' => 'Géorgie Du Sud-Et-Les Îles Sandwich Du Sud', 'name_en' => 'South Georgia', 'name_de' => 'Südgeorgien und die Südlichen Sandwichinseln', 'isocode' => 'GS', 'ccn3' => 239, 'phone_code' => '+500'],
            ['id_customer_country' => 117, 'name' => 'Guatemala', 'name_en' => 'Guatemala', 'name_de' => 'Guatemala', 'isocode' => 'GT', 'ccn3' => 320, 'phone_code' => '+502'],
            ['id_customer_country' => 118, 'name' => 'Guam', 'name_en' => 'Guam', 'name_de' => 'Guam', 'isocode' => 'GU', 'ccn3' => 316, 'phone_code' => '+1671'],
            ['id_customer_country' => 119, 'name' => 'Guinée-Bissau', 'name_en' => 'Guinea-Bissau', 'name_de' => 'Guinea-Bissau', 'isocode' => 'GW', 'ccn3' => 624, 'phone_code' => '+245'],
            ['id_customer_country' => 120, 'name' => 'Guyana', 'name_en' => 'Guyana', 'name_de' => 'Guyana', 'isocode' => 'GY', 'ccn3' => 328, 'phone_code' => '+595'],
            ['id_customer_country' => 121, 'name' => 'Hong Kong', 'name_en' => 'Hong Kong', 'name_de' => 'Hongkong', 'isocode' => 'HK', 'ccn3' => 344, 'phone_code' => '+852'],
            ['id_customer_country' => 122, 'name' => 'Îles Heard-Et-MacDonald', 'name_en' => 'Heard Island and McDonald Islands', 'name_de' => 'Heard und die McDonaldinseln', 'isocode' => 'HM', 'ccn3' => 334, 'phone_code' => null],
            ['id_customer_country' => 123, 'name' => 'Honduras', 'name_en' => 'Honduras', 'name_de' => 'Honduras', 'isocode' => 'HN', 'ccn3' => 340, 'phone_code' => '+504'],
            ['id_customer_country' => 124, 'name' => 'Haïti', 'name_en' => 'Haiti', 'name_de' => 'Haiti', 'isocode' => 'HT', 'ccn3' => 332, 'phone_code' => '+509'],
            ['id_customer_country' => 125, 'name' => 'Hongrie', 'name_en' => 'Hungary', 'name_de' => 'Ungarn', 'isocode' => 'HU', 'ccn3' => 348, 'phone_code' => '+36'],
            ['id_customer_country' => 126, 'name' => 'Indonésie', 'name_en' => 'Indonesia', 'name_de' => 'Indonesien', 'isocode' => 'ID', 'ccn3' => 360, 'phone_code' => '+62'],
            ['id_customer_country' => 127, 'name' => 'Île De Man', 'name_en' => 'Isle of Man', 'name_de' => 'Insel Man', 'isocode' => 'IM', 'ccn3' => 833, 'phone_code' => '+44'],
            ['id_customer_country' => 128, 'name' => 'Inde', 'name_en' => 'India', 'name_de' => 'India', 'isocode' => 'IN', 'ccn3' => 356, 'phone_code' => '+91'],
            ['id_customer_country' => 129, 'name' => 'Territoire Britannique De L\'océan Indien', 'name_en' => 'British Indian Ocean Territory', 'name_de' => 'Britisches Territorium im Indischen Ozean', 'isocode' => 'IO', 'ccn3' => 86, 'phone_code' => '+246'],
            ['id_customer_country' => 130, 'name' => 'Irak', 'name_en' => 'Iraq', 'name_de' => 'Irak', 'isocode' => 'IQ', 'ccn3' => 368, 'phone_code' => '+964'],
            ['id_customer_country' => 131, 'name' => 'République Islamique D\'Iran', 'name_en' => 'Iran', 'name_de' => 'Iran', 'isocode' => 'IR', 'ccn3' => 364, 'phone_code' => '+98'],
            ['id_customer_country' => 132, 'name' => 'Islande', 'name_en' => 'Iceland', 'name_de' => 'Island', 'isocode' => 'IS', 'ccn3' => 352, 'phone_code' => '+354'],
            ['id_customer_country' => 133, 'name' => 'Jersey', 'name_en' => 'Jersey', 'name_de' => 'Jersey', 'isocode' => 'JE', 'ccn3' => 832, 'phone_code' => '+44'],
            ['id_customer_country' => 134, 'name' => 'Jamaïque', 'name_en' => 'Jamaica', 'name_de' => 'Jamaika', 'isocode' => 'JM', 'ccn3' => 388, 'phone_code' => '+1876'],
            ['id_customer_country' => 135, 'name' => 'Jordanie', 'name_en' => 'Jordan', 'name_de' => 'Jordanien', 'isocode' => 'JO', 'ccn3' => 400, 'phone_code' => '+962'],
            ['id_customer_country' => 136, 'name' => 'Kenya', 'name_en' => 'Kenya', 'name_de' => 'Kenia', 'isocode' => 'KE', 'ccn3' => 404, 'phone_code' => '+254'],
            ['id_customer_country' => 137, 'name' => 'Kirghizistan', 'name_en' => 'Kyrgyzstan', 'name_de' => 'Kirgisistan', 'isocode' => 'KG', 'ccn3' => 417, 'phone_code' => '+996'],
            ['id_customer_country' => 138, 'name' => 'Cambodge', 'name_en' => 'Cambodia', 'name_de' => 'Kambodscha', 'isocode' => 'KH', 'ccn3' => 116, 'phone_code' => '+855'],
            ['id_customer_country' => 139, 'name' => 'Kiribati', 'name_en' => 'Kiribati', 'name_de' => 'Kiribati', 'isocode' => 'KI', 'ccn3' => 296, 'phone_code' => '+686'],
            ['id_customer_country' => 140, 'name' => 'Comores', 'name_en' => 'Comoros', 'name_de' => 'Komoren', 'isocode' => 'KM', 'ccn3' => 174, 'phone_code' => '+269'],
            ['id_customer_country' => 141, 'name' => 'Saint-Christophe-et-Niévès', 'name_en' => 'Saint Kitts and Nevis', 'name_de' => 'St. Kitts und Nevis', 'isocode' => 'KN', 'ccn3' => 659, 'phone_code' => '+1869'],
            ['id_customer_country' => 142, 'name' => 'République Populaire Démocratique De Corée', 'name_en' => 'North Korea', 'name_de' => 'Nordkorea', 'isocode' => 'KP', 'ccn3' => 408, 'phone_code' => '+850'],
            ['id_customer_country' => 143, 'name' => 'République De Corée', 'name_en' => 'South Korea', 'name_de' => 'Südkorea', 'isocode' => 'KR', 'ccn3' => 410, 'phone_code' => '+82'],
            ['id_customer_country' => 144, 'name' => 'Îles Caïmans', 'name_en' => 'Cayman Islands', 'name_de' => 'Kaimaninseln', 'isocode' => 'KY', 'ccn3' => 136, 'phone_code' => '+ 345'],
            ['id_customer_country' => 145, 'name' => 'Kazakhstan', 'name_en' => 'Kazakhstan', 'name_de' => 'Kasachstan', 'isocode' => 'KZ', 'ccn3' => 398, 'phone_code' => '+77'],
            ['id_customer_country' => 146, 'name' => 'République Démocratique Populaire Lao', 'name_en' => 'Laos', 'name_de' => 'Laos', 'isocode' => 'LA', 'ccn3' => 418, 'phone_code' => '+856'],
            ['id_customer_country' => 147, 'name' => 'Liban', 'name_en' => 'Lebanon', 'name_de' => 'Libanon', 'isocode' => 'LB', 'ccn3' => 422, 'phone_code' => '+961'],
            ['id_customer_country' => 148, 'name' => 'Sainte-Lucie', 'name_en' => 'Saint Lucia', 'name_de' => 'St. Lucia', 'isocode' => 'LC', 'ccn3' => 662, 'phone_code' => '+1758'],
            ['id_customer_country' => 149, 'name' => 'Liechtenstein', 'name_en' => 'Liechtenstein', 'name_de' => 'Liechtenstein', 'isocode' => 'LI', 'ccn3' => 438, 'phone_code' => '+423'],
            ['id_customer_country' => 150, 'name' => 'Sri Lanka', 'name_en' => 'Sri Lanka', 'name_de' => 'Sri Lanka', 'isocode' => 'LK', 'ccn3' => 144, 'phone_code' => '+94'],
            ['id_customer_country' => 151, 'name' => 'Liberia', 'name_en' => 'Liberia', 'name_de' => 'Liberia', 'isocode' => 'LR', 'ccn3' => 430, 'phone_code' => '+231'],
            ['id_customer_country' => 152, 'name' => 'Lesotho', 'name_en' => 'Lesotho', 'name_de' => 'Lesotho', 'isocode' => 'LS', 'ccn3' => 426, 'phone_code' => '+266'],
            ['id_customer_country' => 153, 'name' => 'Lettonie', 'name_en' => 'Latvia', 'name_de' => 'Lettland', 'isocode' => 'LV', 'ccn3' => 428, 'phone_code' => '+371'],
            ['id_customer_country' => 154, 'name' => 'Libye', 'name_en' => 'Libya', 'name_de' => 'Libyen', 'isocode' => 'LY', 'ccn3' => 434, 'phone_code' => '+218'],
            ['id_customer_country' => 155, 'name' => 'Maroc', 'name_en' => 'Morocco', 'name_de' => 'Marokko', 'isocode' => 'MA', 'ccn3' => 504, 'phone_code' => '+212'],
            ['id_customer_country' => 156, 'name' => 'Monaco', 'name_en' => 'Monaco', 'name_de' => 'Monaco', 'isocode' => 'MC', 'ccn3' => 492, 'phone_code' => '+377'],
            ['id_customer_country' => 157, 'name' => 'République De Moldavie', 'name_en' => 'Moldova', 'name_de' => 'Moldawien', 'isocode' => 'MD', 'ccn3' => 498, 'phone_code' => '+373'],
            ['id_customer_country' => 158, 'name' => 'Monténégro', 'name_en' => 'Montenegro', 'name_de' => 'Montenegro', 'isocode' => 'ME', 'ccn3' => 499, 'phone_code' => '+382'],
            ['id_customer_country' => 159, 'name' => 'Saint-Martin (Partie Française)', 'name_en' => 'Saint Martin', 'name_de' => 'Saint-Martin', 'isocode' => 'MF', 'ccn3' => 663, 'phone_code' => '+590'],
            ['id_customer_country' => 160, 'name' => 'Madagascar', 'name_en' => 'Madagascar', 'name_de' => 'Madagaskar', 'isocode' => 'MG', 'ccn3' => 450, 'phone_code' => '+261'],
            ['id_customer_country' => 161, 'name' => 'Îles Marshall', 'name_en' => 'Marshall Islands', 'name_de' => 'Marshallinseln', 'isocode' => 'MH', 'ccn3' => 584, 'phone_code' => '+692'],
            ['id_customer_country' => 162, 'name' => 'Macédoine', 'name_en' => 'North Macedonia', 'name_de' => 'Nordmazedonien', 'isocode' => 'MK', 'ccn3' => 807, 'phone_code' => '+389'],
            ['id_customer_country' => 163, 'name' => 'Mali', 'name_en' => 'Guatemala', 'name_de' => 'Guatemala', 'isocode' => 'ML', 'ccn3' => 466, 'phone_code' => '+223'],
            ['id_customer_country' => 164, 'name' => 'Birmanie', 'name_en' => 'Myanmar', 'name_de' => 'Myanmar', 'isocode' => 'MM', 'ccn3' => 104, 'phone_code' => '+95'],
            ['id_customer_country' => 165, 'name' => 'Mongolie', 'name_en' => 'Mongolia', 'name_de' => 'Mongolei', 'isocode' => 'MN', 'ccn3' => 496, 'phone_code' => '+976'],
            ['id_customer_country' => 166, 'name' => 'Macao', 'name_en' => 'Macau', 'name_de' => 'Macao', 'isocode' => 'MO', 'ccn3' => 446, 'phone_code' => '+853'],
            ['id_customer_country' => 167, 'name' => 'Îles Mariannes Du Nord', 'name_en' => 'Northern Mariana Islands', 'name_de' => 'Nördliche Marianen', 'isocode' => 'MP', 'ccn3' => 580, 'phone_code' => '+1670'],
            ['id_customer_country' => 168, 'name' => 'Martinique', 'name_en' => 'Martinique', 'name_de' => 'Martinique', 'isocode' => 'MQ', 'ccn3' => 474, 'phone_code' => '+596'],
            ['id_customer_country' => 169, 'name' => 'Mauritanie', 'name_en' => 'Mauritania', 'name_de' => 'Mauretanien', 'isocode' => 'MR', 'ccn3' => 478, 'phone_code' => '+222'],
            ['id_customer_country' => 170, 'name' => 'Montserrat', 'name_en' => 'Montserrat', 'name_de' => 'Montserrat', 'isocode' => 'MS', 'ccn3' => 500, 'phone_code' => '+1664'],
            ['id_customer_country' => 171, 'name' => 'Malte', 'name_en' => 'Malta', 'name_de' => 'Malta', 'isocode' => 'MT', 'ccn3' => 470, 'phone_code' => '+356'],
            ['id_customer_country' => 172, 'name' => 'Maurice', 'name_en' => 'Mauritius', 'name_de' => 'Mauritius', 'isocode' => 'MU', 'ccn3' => 480, 'phone_code' => '+230'],
            ['id_customer_country' => 173, 'name' => 'Maldives', 'name_en' => 'Maldives', 'name_de' => 'Malediven', 'isocode' => 'MV', 'ccn3' => 462, 'phone_code' => '+960'],
            ['id_customer_country' => 174, 'name' => 'Malawi', 'name_en' => 'Malawi', 'name_de' => 'Malawi', 'isocode' => 'MW', 'ccn3' => 454, 'phone_code' => '+265'],
            ['id_customer_country' => 175, 'name' => 'Mexique', 'name_en' => 'Mexico', 'name_de' => 'Mexiko', 'isocode' => 'MX', 'ccn3' => 484, 'phone_code' => '+52'],
            ['id_customer_country' => 176, 'name' => 'Malaisie', 'name_en' => 'Malaysia', 'name_de' => 'Malaysia', 'isocode' => 'MY', 'ccn3' => 458, 'phone_code' => '+60'],
            ['id_customer_country' => 177, 'name' => 'Mozambique', 'name_en' => 'Mozambique', 'name_de' => 'Mosambik', 'isocode' => 'MZ', 'ccn3' => 508, 'phone_code' => '+258'],
            ['id_customer_country' => 178, 'name' => 'Namibie', 'name_en' => 'Namibia', 'name_de' => 'Namibia', 'isocode' => 'NA', 'ccn3' => 516, 'phone_code' => '+264'],
            ['id_customer_country' => 179, 'name' => 'Nouvelle-Calédonie', 'name_en' => 'New Caledonia', 'name_de' => 'Neukaledonien', 'isocode' => 'NC', 'ccn3' => 540, 'phone_code' => '+687'],
            ['id_customer_country' => 180, 'name' => 'Niger', 'name_en' => 'Nigeria', 'name_de' => 'Nigeria', 'isocode' => 'NE', 'ccn3' => 562, 'phone_code' => '+227'],
            ['id_customer_country' => 181, 'name' => 'Île Norfolk', 'name_en' => 'Norfolk Island', 'name_de' => 'Norfolkinsel', 'isocode' => 'NF', 'ccn3' => 574, 'phone_code' => '+672'],
            ['id_customer_country' => 182, 'name' => 'Nigéria', 'name_en' => 'Nigeria', 'name_de' => 'Nigeria', 'isocode' => 'NG', 'ccn3' => 566, 'phone_code' => '+234'],
            ['id_customer_country' => 183, 'name' => 'Nicaragua', 'name_en' => 'Nicaragua', 'name_de' => 'Nicaragua', 'isocode' => 'NI', 'ccn3' => 558, 'phone_code' => '+505'],
            ['id_customer_country' => 184, 'name' => 'Norvège', 'name_en' => 'Norway', 'name_de' => 'Norwegen', 'isocode' => 'NO', 'ccn3' => 578, 'phone_code' => '+47'],
            ['id_customer_country' => 185, 'name' => 'Népal', 'name_en' => 'Nepal', 'name_de' => 'Nepal', 'isocode' => 'NP', 'ccn3' => 524, 'phone_code' => '+977'],
            ['id_customer_country' => 186, 'name' => 'Nauru', 'name_en' => 'Nauru', 'name_de' => 'Nauru', 'isocode' => 'NR', 'ccn3' => 520, 'phone_code' => '+674'],
            ['id_customer_country' => 187, 'name' => 'Niue', 'name_en' => 'Niue', 'name_de' => 'Niue', 'isocode' => 'NU', 'ccn3' => 570, 'phone_code' => '+683'],
            ['id_customer_country' => 188, 'name' => 'Oman', 'name_en' => 'Oman', 'name_de' => 'Oman', 'isocode' => 'OM', 'ccn3' => 512, 'phone_code' => '+968'],
            ['id_customer_country' => 189, 'name' => 'Panama', 'name_en' => 'Panama', 'name_de' => 'Panama', 'isocode' => 'PA', 'ccn3' => 591, 'phone_code' => '+507'],
            ['id_customer_country' => 190, 'name' => 'Pérou', 'name_en' => 'Peru', 'name_de' => 'Peru', 'isocode' => 'PE', 'ccn3' => 604, 'phone_code' => '+51'],
            ['id_customer_country' => 191, 'name' => 'Papouasie-Nouvelle-Guinée', 'name_en' => 'Papua New Guinea', 'name_de' => 'Papua-Neuguinea', 'isocode' => 'PG', 'ccn3' => 598, 'phone_code' => '+675'],
            ['id_customer_country' => 192, 'name' => 'Philippines', 'name_en' => 'Philippines', 'name_de' => 'Philippinen', 'isocode' => 'PH', 'ccn3' => 608, 'phone_code' => '+63'],
            ['id_customer_country' => 193, 'name' => 'Pakistan', 'name_en' => 'Pakistan', 'name_de' => 'Pakistan', 'isocode' => 'PK', 'ccn3' => 586, 'phone_code' => '+92'],
            ['id_customer_country' => 194, 'name' => 'Saint-Pierre-Et-Miquelon', 'name_en' => 'Saint Pierre and Miquelon', 'name_de' => 'St. Pierre und Miquelon', 'isocode' => 'PM', 'ccn3' => 666, 'phone_code' => '+508'],
            ['id_customer_country' => 195, 'name' => 'Pitcairn', 'name_en' => 'Pitcairn Islands', 'name_de' => 'Pitcairninseln', 'isocode' => 'PN', 'ccn3' => 612, 'phone_code' => '+872'],
            ['id_customer_country' => 196, 'name' => 'Porto Rico', 'name_en' => 'Puerto Rico', 'name_de' => 'Puerto Rico', 'isocode' => 'PR', 'ccn3' => 630, 'phone_code' => '+1939'],
            ['id_customer_country' => 197, 'name' => 'Territoires Palestiniens Occupés', 'name_en' => 'Palestine', 'name_de' => 'Palästina', 'isocode' => 'PS', 'ccn3' => 275, 'phone_code' => '+970'],
            ['id_customer_country' => 198, 'name' => 'Palaos', 'name_en' => 'Palau', 'name_de' => 'Palau', 'isocode' => 'PW', 'ccn3' => 585, 'phone_code' => '+680'],
            ['id_customer_country' => 199, 'name' => 'Qatar', 'name_en' => 'Qatar', 'name_de' => 'Katar', 'isocode' => 'QA', 'ccn3' => 634, 'phone_code' => '+974'],
            ['id_customer_country' => 200, 'name' => 'Serbie', 'name_en' => 'Serbia', 'name_de' => 'Serbien', 'isocode' => 'RS', 'ccn3' => 688, 'phone_code' => '+381'],
            ['id_customer_country' => 201, 'name' => 'Fédération De Russie', 'name_en' => 'Russia', 'name_de' => 'Russland', 'isocode' => 'RU', 'ccn3' => 643, 'phone_code' => '+7'],
            ['id_customer_country' => 202, 'name' => 'Rwanda', 'name_en' => 'Rwanda', 'name_de' => 'Ruanda', 'isocode' => 'RW', 'ccn3' => 646, 'phone_code' => '+250'],
            ['id_customer_country' => 203, 'name' => 'Arabie Saoudite', 'name_en' => 'Saudi Arabia', 'name_de' => 'Saudi-Arabien', 'isocode' => 'SA', 'ccn3' => 682, 'phone_code' => '+966'],
            ['id_customer_country' => 204, 'name' => 'Îles Salomon', 'name_en' => 'Solomon Islands', 'name_de' => 'Salomonen', 'isocode' => 'SB', 'ccn3' => 90, 'phone_code' => '+677'],
            ['id_customer_country' => 205, 'name' => 'Seychelles', 'name_en' => 'Seychelles', 'name_de' => 'Seychellen', 'isocode' => 'SC', 'ccn3' => 690, 'phone_code' => '+248'],
            ['id_customer_country' => 206, 'name' => 'Soudan', 'name_en' => 'South Sudan', 'name_de' => 'Südsudan', 'isocode' => 'SD', 'ccn3' => 729, 'phone_code' => '+249'],
            ['id_customer_country' => 207, 'name' => 'Singapour', 'name_en' => 'Singapore', 'name_de' => 'Singapur', 'isocode' => 'SG', 'ccn3' => 702, 'phone_code' => '+65'],
            ['id_customer_country' => 208, 'name' => 'Sainte-Hélène', 'name_en' => 'Saint Helena, Ascension and Tristan da Cunha', 'name_de' => 'St. Helena, Ascension und Tristan da Cunha', 'isocode' => 'SH', 'ccn3' => 654, 'phone_code' => '+290'],
            ['id_customer_country' => 209, 'name' => 'Slovénie', 'name_en' => 'Slovenia', 'name_de' => 'Slowenien', 'isocode' => 'SI', 'ccn3' => 705, 'phone_code' => '+386'],
            ['id_customer_country' => 210, 'name' => 'Svalbard Et Jan Mayen', 'name_en' => 'Svalbard and Jan Mayen', 'name_de' => 'Spitzbergen und Jan Mayen', 'isocode' => 'SJ', 'ccn3' => 744, 'phone_code' => '+47'],
            ['id_customer_country' => 211, 'name' => 'Slovaquie', 'name_en' => 'Slovakia', 'name_de' => 'Slowakei', 'isocode' => 'SK', 'ccn3' => 703, 'phone_code' => '+421'],
            ['id_customer_country' => 212, 'name' => 'Sierra Leone', 'name_en' => 'Sierra Leone', 'name_de' => 'Sierra Leone', 'isocode' => 'SL', 'ccn3' => 694, 'phone_code' => '+232'],
            ['id_customer_country' => 213, 'name' => 'Saint-Marin', 'name_en' => 'San Marino', 'name_de' => 'San Marino', 'isocode' => 'SM', 'ccn3' => 674, 'phone_code' => '+378'],
            ['id_customer_country' => 214, 'name' => 'Sénégal', 'name_en' => 'Senegal', 'name_de' => 'Senegal', 'isocode' => 'SN', 'ccn3' => 686, 'phone_code' => '+221'],
            ['id_customer_country' => 215, 'name' => 'Somalie', 'name_en' => 'Somalia', 'name_de' => 'Somalia', 'isocode' => 'SO', 'ccn3' => 706, 'phone_code' => '+252'],
            ['id_customer_country' => 216, 'name' => 'Suriname', 'name_en' => 'Suriname', 'name_de' => 'Suriname', 'isocode' => 'SR', 'ccn3' => 740, 'phone_code' => '+597'],
            ['id_customer_country' => 217, 'name' => 'Soudan Du Sud', 'name_en' => 'South Sudan', 'name_de' => 'Südsudan', 'isocode' => 'SS', 'ccn3' => 728, 'phone_code' => '+211'],
            ['id_customer_country' => 218, 'name' => 'Sao Tomé-Et-Principe', 'name_en' => 'São Tomé and Príncipe', 'name_de' => 'São Tomé und Príncipe', 'isocode' => 'ST', 'ccn3' => 678, 'phone_code' => '+239'],
            ['id_customer_country' => 219, 'name' => 'République Du Salvador', 'name_en' => 'El Salvador', 'name_de' => 'El Salvador', 'isocode' => 'SV', 'ccn3' => 222, 'phone_code' => '+503'],
            ['id_customer_country' => 220, 'name' => 'Saint-Martin (Partie Néerlandaise)', 'name_en' => 'Sint Maarten', 'name_de' => 'Sint Maarten', 'isocode' => 'SX', 'ccn3' => 534, 'phone_code' => null],
            ['id_customer_country' => 221, 'name' => 'République Arabe Syrienne', 'name_en' => 'Syria', 'name_de' => 'Syrien', 'isocode' => 'SY', 'ccn3' => 760, 'phone_code' => '+963'],
            ['id_customer_country' => 222, 'name' => 'Swaziland', 'name_en' => 'Eswatini', 'name_de' => 'Swasiland', 'isocode' => 'SZ', 'ccn3' => 748, 'phone_code' => '+268'],
            ['id_customer_country' => 223, 'name' => 'Îles Turks-Et-Caïcos', 'name_en' => 'Turks and Caicos Islands', 'name_de' => 'Turks-und Caicosinseln', 'isocode' => 'TC', 'ccn3' => 796, 'phone_code' => '+1649'],
            ['id_customer_country' => 224, 'name' => 'Tchad', 'name_en' => 'Chad', 'name_de' => 'Tschad', 'isocode' => 'TD', 'ccn3' => 148, 'phone_code' => '+235'],
            ['id_customer_country' => 225, 'name' => 'Terres Australes Françaises', 'name_en' => 'French Southern and Antarctic Lands', 'name_de' => 'Französische Süd- und Antarktisgebiete', 'isocode' => 'TF', 'ccn3' => 260, 'phone_code' => null],
            ['id_customer_country' => 226, 'name' => 'Togo', 'name_en' => 'Togo', 'name_de' => 'Togo', 'isocode' => 'TG', 'ccn3' => 768, 'phone_code' => '+228'],
            ['id_customer_country' => 227, 'name' => 'Thaïlande', 'name_en' => 'Thailand', 'name_de' => 'Thailand', 'isocode' => 'TH', 'ccn3' => 764, 'phone_code' => '+66'],
            ['id_customer_country' => 228, 'name' => 'Tadjikistan', 'name_en' => 'Tajikistan', 'name_de' => 'Tadschikistan', 'isocode' => 'TJ', 'ccn3' => 762, 'phone_code' => '+992'],
            ['id_customer_country' => 229, 'name' => 'Tokelau', 'name_en' => 'Tokelau', 'name_de' => 'Tokelau', 'isocode' => 'TK', 'ccn3' => 772, 'phone_code' => '+690'],
            ['id_customer_country' => 230, 'name' => 'Timor-Leste', 'name_en' => 'Timor-Leste', 'name_de' => 'Osttimor', 'isocode' => 'TL', 'ccn3' => 626, 'phone_code' => '+670'],
            ['id_customer_country' => 231, 'name' => 'Turkménistan', 'name_en' => 'Turkmenistan', 'name_de' => 'Turkmenistan', 'isocode' => 'TM', 'ccn3' => 795, 'phone_code' => '+993'],
            ['id_customer_country' => 232, 'name' => 'Tunisie', 'name_en' => 'Tunisia', 'name_de' => 'Tunesien', 'isocode' => 'TN', 'ccn3' => 788, 'phone_code' => '+216'],
            ['id_customer_country' => 233, 'name' => 'Tonga', 'name_en' => 'Tonga', 'name_de' => 'Tonga', 'isocode' => 'TO', 'ccn3' => 776, 'phone_code' => '+676'],
            ['id_customer_country' => 234, 'name' => 'Turquie', 'name_en' => 'Turkey', 'name_de' => 'Türkei', 'isocode' => 'TR', 'ccn3' => 792, 'phone_code' => '+90'],
            ['id_customer_country' => 235, 'name' => 'Trinité-Et-Tobago', 'name_en' => 'Trinidad and Tobago', 'name_de' => 'Trinidad und Tobago', 'isocode' => 'TT', 'ccn3' => 780, 'phone_code' => '+1868'],
            ['id_customer_country' => 236, 'name' => 'Tuvalu', 'name_en' => 'Tuvalu', 'name_de' => 'Tuvalu', 'isocode' => 'TV', 'ccn3' => 798, 'phone_code' => '+688'],
            ['id_customer_country' => 237, 'name' => 'Taïwan', 'name_en' => 'Taiwan', 'name_de' => 'Taiwan', 'isocode' => 'TW', 'ccn3' => 158, 'phone_code' => '+886'],
            ['id_customer_country' => 238, 'name' => 'République-Unie De Tanzanie', 'name_en' => 'Tanzania', 'name_de' => 'Tansania', 'isocode' => 'TZ', 'ccn3' => 834, 'phone_code' => '+255'],
            ['id_customer_country' => 239, 'name' => 'Ouganda', 'name_en' => 'Uganda', 'name_de' => 'Uganda', 'isocode' => 'UG', 'ccn3' => 800, 'phone_code' => '+256'],
            ['id_customer_country' => 240, 'name' => 'Îles Mineures Éloignées Des États-Unis', 'name_en' => 'United States Minor Outlying Islands', 'name_de' => 'Kleinere Inselbesitzungen der Vereinigten Staaten', 'isocode' => 'UM', 'ccn3' => 581, 'phone_code' => null],
            ['id_customer_country' => 241, 'name' => 'Uruguay', 'name_en' => 'Uruguay', 'name_de' => 'Uruguay', 'isocode' => 'UY', 'ccn3' => 858, 'phone_code' => '+598'],
            ['id_customer_country' => 242, 'name' => 'Ouzbékistan', 'name_en' => 'Uzbekistan', 'name_de' => 'Usbekistan', 'isocode' => 'UZ', 'ccn3' => 860, 'phone_code' => '+998'],
            ['id_customer_country' => 243, 'name' => 'Saint-Siège (État De La Cité Du Vatican)', 'name_en' => 'Vatican City', 'name_de' => 'Vatikanstadt', 'isocode' => 'VA', 'ccn3' => 336, 'phone_code' => '+379'],
            ['id_customer_country' => 244, 'name' => 'Saint-Vincent-Et-Les Grenadines', 'name_en' => 'Saint Vincent and the Grenadines', 'name_de' => 'St. Vincent und die Grenadinen', 'isocode' => 'VC', 'ccn3' => 670, 'phone_code' => '+1784'],
            ['id_customer_country' => 245, 'name' => 'Venezuela', 'name_en' => 'Venezuela', 'name_de' => 'Venezuela', 'isocode' => 'VE', 'ccn3' => 862, 'phone_code' => '+58'],
            ['id_customer_country' => 246, 'name' => 'Îles Vierges Britanniques', 'name_en' => 'British Virgin Islands', 'name_de' => 'Britische Jungferninseln', 'isocode' => 'VG', 'ccn3' => 92, 'phone_code' => '+1284'],
            ['id_customer_country' => 247, 'name' => 'Îles Vierges Des États-Unis', 'name_en' => 'United States Virgin Islands', 'name_de' => 'Amerikanische Jungferninseln', 'isocode' => 'VI', 'ccn3' => 850, 'phone_code' => '+1340'],
            ['id_customer_country' => 248, 'name' => 'Viet Nam', 'name_en' => 'Vietnam', 'name_de' => 'Vietnam', 'isocode' => 'VN', 'ccn3' => 704, 'phone_code' => '+84'],
            ['id_customer_country' => 249, 'name' => 'Vanuatu', 'name_en' => 'Vanuatu', 'name_de' => 'Vanuatu', 'isocode' => 'VU', 'ccn3' => 548, 'phone_code' => '+678'],
            ['id_customer_country' => 250, 'name' => 'Wallis Et Futuna', 'name_en' => 'Wallis and Futuna', 'name_de' => 'Wallis und Futuna', 'isocode' => 'WF', 'ccn3' => 876, 'phone_code' => '+681'],
            ['id_customer_country' => 251, 'name' => 'Samoa', 'name_en' => 'Samoa', 'name_de' => 'Samoa', 'isocode' => 'WS', 'ccn3' => 882, 'phone_code' => '+685'],
            ['id_customer_country' => 252, 'name' => 'Yémen', 'name_en' => 'Yemen', 'name_de' => 'Jemen', 'isocode' => 'YE', 'ccn3' => 887, 'phone_code' => '+967'],
            ['id_customer_country' => 253, 'name' => 'Afrique Du Sud', 'name_en' => 'South Africa', 'name_de' => 'Südafrika', 'isocode' => 'ZA', 'ccn3' => 710, 'phone_code' => '+27'],
            ['id_customer_country' => 254, 'name' => 'Zambie', 'name_en' => 'Zambia', 'name_de' => 'Sambia', 'isocode' => 'ZM', 'ccn3' => 894, 'phone_code' => '+260'],
            ['id_customer_country' => 255, 'name' => 'Zimbabwe', 'name_en' => 'Zimbabwe', 'name_de' => 'Simbabwe', 'isocode' => 'ZW', 'ccn3' => 716, 'phone_code' => '+263'],
        ];

        // Préparer les données finales avec les flags et timestamps
        $finalData = [];
        foreach ($countriesData as $country) {
            $countryName = $country['name'];
            
            // Déterminer is_intracom_vat et is_ue_export
            $isIntracomVat = 0;
            $isUeExport = 0;
            
            if (array_key_exists($countryName, $intracomCountries)) {
                $isIntracomVat = 1;
                $isUeExport = $intracomCountries[$countryName];
            }
            
            // Ajouter les champs calculés et les timestamps
            $finalData[] = array_merge($country, [
                'is_intracom_vat' => $isIntracomVat,
                'is_ue_export' => $isUeExport,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        // Insertion des données finales
        DB::table('customer_countries')->insert($finalData);
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_countries');
    }
};
