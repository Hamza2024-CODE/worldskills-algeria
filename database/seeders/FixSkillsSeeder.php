<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class FixSkillsSeeder extends Seeder
{
    public function run(): void
    {
        $skillsData = [
            'SKILL-01' => ['name_ar' => 'الميكانيكا الصناعية والمحركات', 'name_fr' => 'Polymécanique et Automatisation', 'name_en' => 'Industrial Mechanics & Automation', 'cat_id' => 1],
            'SKILL-02' => ['name_ar' => 'الميكاترونكس والأنظمة المؤتمتة', 'name_fr' => 'Mécatronique et Systèmes Automatisés', 'name_en' => 'Mechatronics & Automated Systems', 'cat_id' => 1],
            'SKILL-03' => ['name_ar' => 'التصميم الميكانيكي الرقمي CAD', 'name_fr' => 'Génie Mécanique CAO (CAD)', 'name_en' => 'Mechanical Engineering CAD', 'cat_id' => 1],
            'SKILL-04' => ['name_ar' => 'الخراطة بالتحكم الرقمي CNC', 'name_fr' => 'Tournage CNC', 'name_en' => 'CNC Turning', 'cat_id' => 1],
            'SKILL-05' => ['name_ar' => 'التفريز بالتحكم الرقمي CNC', 'name_fr' => 'Fraisage CNC', 'name_en' => 'CNC Milling', 'cat_id' => 1],
            'SKILL-06' => ['name_ar' => 'النحت والمعمار الحجري', 'name_fr' => 'Taille de Pierre Architecturales', 'name_en' => 'Architectural Stonemasonry', 'cat_id' => 3],
            'SKILL-07' => ['name_ar' => 'نمذجة معلومات المباني BIM', 'name_fr' => 'Modélisation des Informations du Bâtiment (BIM)', 'name_en' => 'Building Information Modeling (BIM)', 'cat_id' => 3],
            'SKILL-08' => ['name_ar' => 'تبليط الجدران والأرضيات', 'name_fr' => 'Carrelage Mural et de Sol', 'name_en' => 'Wall & Floor Tiling', 'cat_id' => 3],
            'SKILL-09' => ['name_ar' => 'حلول البرمجيات للأعمال', 'name_fr' => 'Solutions Logicielles pour l\'Entreprise', 'name_en' => 'IT Software Solutions for Business', 'cat_id' => 2],
            'SKILL-10' => ['name_ar' => 'اللحام والربط المعدني', 'name_fr' => 'Soudage et Assemblage Métallique', 'name_en' => 'Welding', 'cat_id' => 1],
            'SKILL-11' => ['name_ar' => 'صيانة وترميم هياكل السيارات', 'name_fr' => 'Réparation de Carrosserie Automobile', 'name_en' => 'Auto Body Repair', 'cat_id' => 4],
            'SKILL-12' => ['name_ar' => 'صيانة هياكل ومحركات الطائرات', 'name_fr' => 'Maintenance Aéronautique', 'name_en' => 'Aircraft Maintenance', 'cat_id' => 4],
            'SKILL-13' => ['name_ar' => 'تطوير تطبيقات الهاتف المحمول', 'name_fr' => 'Développement d\'Applications Mobiles', 'name_en' => 'Mobile Applications Development', 'cat_id' => 2],
            'SKILL-14' => ['name_ar' => 'الأمن السيبراني وحماية البيانات', 'name_fr' => 'Cybersécurité et Protection des Données', 'name_en' => 'Cybersecurity & Data Protection', 'cat_id' => 2],
            'SKILL-15' => ['name_ar' => 'الحوسبة السحابية وإدارة الخوادم', 'name_fr' => 'Informatique Nuagique (Cloud Computing)', 'name_en' => 'Cloud Computing', 'cat_id' => 2],
            'SKILL-16' => ['name_ar' => 'الميكاترونكس والتحكم الآلي', 'name_fr' => 'Mécatronique et Contrôle Automatisé', 'name_en' => 'Mechatronics Control', 'cat_id' => 1],
            'SKILL-17' => ['name_ar' => 'تكنولوجيا التصميم الجرافيكي', 'name_fr' => 'Technologie de Design Graphique', 'name_en' => 'Graphic Design Technology', 'cat_id' => 5],
            'SKILL-18' => ['name_ar' => 'التركيبات الكهربائية', 'name_fr' => 'Installations Électriques', 'name_en' => 'Electrical Installations', 'cat_id' => 3],
            'SKILL-19' => ['name_ar' => 'البناء التقليدي والمباني', 'name_fr' => 'Maçonnerie et Brique', 'name_en' => 'Bricklaying & Masonry', 'cat_id' => 3],
            'SKILL-20' => ['name_ar' => 'صناعة الأثاث والنجارة الفنية', 'name_fr' => 'Ébénisterie d\'Art et Mobilier', 'name_en' => 'Cabinetmaking', 'cat_id' => 3],
            'SKILL-21' => ['name_ar' => 'النجارة المعمارية والتركيبات', 'name_fr' => 'Menuiserie du Bâtiment et Assemblage', 'name_en' => 'Joinery & Carpentry', 'cat_id' => 3],
            'SKILL-22' => ['name_ar' => 'فن تنسيق الزهور والحدائق', 'name_fr' => 'Art Floral et Paysagisme', 'name_en' => 'Floristry & Landscape Gardening', 'cat_id' => 5],
            'SKILL-23' => ['name_ar' => 'تكنولوجيا الموضة وتصميم الأزياء', 'name_fr' => 'Technologie de la Mode et Couture', 'name_en' => 'Fashion Technology', 'cat_id' => 5],
            'SKILL-24' => ['name_ar' => 'فن المخبوزات والحلويات', 'name_fr' => 'Pâtisserie, Confiserie et Boulangerie', 'name_en' => 'Pâtisserie & Confectionery', 'cat_id' => 6],
            'SKILL-25' => ['name_ar' => 'فن الطبخ والطهي العصري', 'name_fr' => 'Cuisine et Art Culinaire', 'name_en' => 'Cooking & Culinary Art', 'cat_id' => 6],
            'SKILL-26' => ['name_ar' => 'خدمات المطاعم والفندقة', 'name_fr' => 'Service de Restaurant et Hôtellerie', 'name_en' => 'Restaurant Service', 'cat_id' => 6],
            'SKILL-27' => ['name_ar' => 'حلاقة وتصفيف الشعر', 'name_fr' => 'Coiffure et Style', 'name_en' => 'Hairdressing', 'cat_id' => 6],
            'SKILL-28' => ['name_ar' => 'العناية بالبشرة والتجميل', 'name_fr' => 'Soins Esthétiques et Beauté', 'name_en' => 'Beauty Therapy', 'cat_id' => 6],
            'SKILL-29' => ['name_ar' => 'طلاء السيارات ودهان الهياكل', 'name_fr' => 'Peinture Automobile et Finition', 'name_en' => 'Auto Painting', 'cat_id' => 4],
            'SKILL-30' => ['name_ar' => 'تكنولوجيا المركبات الثقيلة', 'name_fr' => 'Maintenance des Véhicules Lourds', 'name_en' => 'Heavy Vehicle Technology', 'cat_id' => 4],
            'SKILL-31' => ['name_ar' => 'الخدمات اللوجستية والشحن', 'name_fr' => 'Services Logistiques et Transport', 'name_en' => 'Freight Logistics Forwarding', 'cat_id' => 4],
            'SKILL-32' => ['name_ar' => 'التحكم الصناعي والأتمتة', 'name_fr' => 'Contrôle Industriel et Automatisme', 'name_en' => 'Industrial Control', 'cat_id' => 1],
            'SKILL-33' => ['name_ar' => 'تكنولوجيا السيارات', 'name_fr' => 'Technologie Automobile', 'name_en' => 'Automobile Technology', 'cat_id' => 4],
            'SKILL-34' => ['name_ar' => 'تمديد شبكات والألياف البصرية', 'name_fr' => 'Câblage de Réseaux d\'Information', 'name_en' => 'Information Network Cabling', 'cat_id' => 2],
            'SKILL-35' => ['name_ar' => 'التبريد والتكييف الصناعي', 'name_fr' => 'Réfrigération et Climatisation', 'name_en' => 'Refrigeration & Air Conditioning', 'cat_id' => 3],
            'SKILL-36' => ['name_ar' => 'الجبس وأنظمة البناء الجاف', 'name_fr' => 'Plâtre et Systèmes Séchés (Drywall)', 'name_en' => 'Plastering & Drywall Systems', 'cat_id' => 3],
            'SKILL-37' => ['name_ar' => 'الدهان والتزيين الديكوري', 'name_fr' => 'Peinture et Décoration', 'name_en' => 'Painting & Decorating', 'cat_id' => 3],
            'SKILL-38' => ['name_ar' => 'تهيئة الحدائق والمساحات الخضراء', 'name_fr' => 'Jardinage Paysager', 'name_en' => 'Landscape Gardening', 'cat_id' => 3],
            'SKILL-39' => ['name_ar' => 'تطوير تقنيات الويب', 'name_fr' => 'Technologies Web & Développement', 'name_en' => 'Web Technologies', 'cat_id' => 2],
            'SKILL-40' => ['name_ar' => 'التصميم الجرافيكي والاتصال البصري', 'name_fr' => 'Design Graphique et Communication', 'name_en' => 'Graphic Design Technology', 'cat_id' => 5],
            'SKILL-41' => ['name_ar' => 'عرض السلع والتسويق البصري', 'name_fr' => 'Visual Merchandising et Vitrines', 'name_en' => 'Visual Merchandising', 'cat_id' => 5],
            'SKILL-42' => ['name_ar' => 'التصنيع الإضافي والطباعة 3D', 'name_fr' => 'Fabrication Additive (Impression 3D)', 'name_en' => 'Additive Manufacturing (3D Printing)', 'cat_id' => 1],
            'SKILL-43' => ['name_ar' => 'تكنولوجيا التصميم الصناعي', 'name_fr' => 'Technologie de Design Industriel', 'name_en' => 'Industrial Design Technology', 'cat_id' => 1],
            'SKILL-44' => ['name_ar' => 'الروبوتات المتنقلة المستقلة', 'name_fr' => 'Robotique Mobile Autonome', 'name_en' => 'Mobile Robotics', 'cat_id' => 1],
            'SKILL-45' => ['name_ar' => 'تكنولوجيا المياه والمعالجة', 'name_fr' => 'Technologie de l\'Eau et Assainissement', 'name_en' => 'Water Technology', 'cat_id' => 1],
            'SKILL-46' => ['name_ar' => 'الطاقة المتجددة والألواح الشمسية', 'name_fr' => 'Énergies Renouvelables et Solaires', 'name_en' => 'Renewable Energy Systems', 'cat_id' => 1],
            'SKILL-47' => ['name_ar' => 'الثورة الصناعية 4.0 والأتمتة', 'name_fr' => 'Industrie 4.0 et Intégration', 'name_en' => 'Industry 4.0', 'cat_id' => 1],
            'SKILL-48' => ['name_ar' => 'تكنولوجيا الإلكترونيات البصرية', 'name_fr' => 'Technologie Optoélectronique', 'name_en' => 'Optoelectronic Technology', 'cat_id' => 1],
            'SKILL-49' => ['name_ar' => 'تكنولوجيا المختبرات الكيميائية', 'name_fr' => 'Technologie de Laboratoire Chimique', 'name_en' => 'Chemical Laboratory Technology', 'cat_id' => 1],
            'SKILL-50' => ['name_ar' => 'الرعاية الصحية والخدمات الاجتماعية', 'name_fr' => 'Soins de Santé et Assistance Sociale', 'name_en' => 'Health & Social Care', 'cat_id' => 6],
            'SKILL-51' => ['name_ar' => 'البناء الرقمي والمسح الهندسي', 'name_fr' => 'Construction Numérique (BIM)', 'name_en' => 'Digital Construction', 'cat_id' => 3],
            'SKILL-52' => ['name_ar' => 'تكامل الأنظمة الروبوتية الصناعية', 'name_fr' => 'Intégration des Systèmes Robotiques', 'name_en' => 'Robotic Systems Integration', 'cat_id' => 1],
            'SKILL-53' => ['name_ar' => 'الأنظمة السيبرانية الفيزيائية', 'name_fr' => 'Systèmes Cyber-Physiques', 'name_en' => 'Cyber-Physical Systems', 'cat_id' => 1],
            'SKILL-54' => ['name_ar' => 'الأمن السيبراني', 'name_fr' => 'Cybersécurité Avancée', 'name_en' => 'Cyber Security', 'cat_id' => 2],
            'SKILL-55' => ['name_ar' => 'تكنولوجيا وصيانة السكك الحديدية', 'name_fr' => 'Technologie des Véhicules Ferroviaires', 'name_en' => 'Rail Vehicle Technology', 'cat_id' => 4],
            'SKILL-56' => ['name_ar' => 'الطاقة الكهروضوئية الشمسية', 'name_fr' => 'Installations Photovoltaïques Solaires', 'name_en' => 'Solar Photovoltaic Systems', 'cat_id' => 1],
            'SKILL-57' => ['name_ar' => 'أعمال الخرسانة والتسليح', 'name_fr' => 'Construction Métallique et Béton', 'name_en' => 'Concrete Construction Works', 'cat_id' => 3],
            'SKILL-58' => ['name_ar' => 'استقبال الفنادق والخدمات الفندقية', 'name_fr' => 'Réception Hôtelière et Accueil', 'name_en' => 'Hotel Reception', 'cat_id' => 6],
            'SKILL-59' => ['name_ar' => 'الحلويات الفاخرة والشوكولاتة', 'name_fr' => 'Pâtisserie Fine et Chocolaterie', 'name_en' => 'Confectionery & Chocolaterie', 'cat_id' => 6],
            'SKILL-60' => ['name_ar' => 'الروبوتات الصناعية المتقدمة', 'name_fr' => 'Robotique Industrielle Avancée', 'name_en' => 'Advanced Industrial Robotics', 'cat_id' => 1],
            'SKILL-61' => ['name_ar' => 'نمذجة النماذج الأولية والتصنيع', 'name_fr' => 'Prototypage Industriel et Modélisation', 'name_en' => 'Prototype Modeling', 'cat_id' => 1],
            'SKILL-62' => ['name_ar' => 'تكنولوجيا الأمن الذكي والأنظمة', 'name_fr' => 'Domotique et Sécurité Intelligente', 'name_en' => 'Smart Home & Security Technology', 'cat_id' => 2],
            'SKILL-63' => ['name_ar' => 'الإلكترونيات والأنظمة المدمجة', 'name_fr' => 'Électronique et Systèmes Embarqués', 'name_en' => 'Electronics', 'cat_id' => 1],
            'SKILL-64' => ['name_ar' => 'الكراسة الفنية والمعايير الدولية', 'name_fr' => 'Normes Techniques et Standards Internationaux', 'name_en' => 'International Technical Standards', 'cat_id' => 1],
        ];

        foreach ($skillsData as $code => $data) {
            $num = null;
            if (preg_match('/(\d+)/', $code, $m)) {
                $num = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            }

            $pdfPath = null;
            if ($num && file_exists(public_path("docs/td/WSC2026_TD{$num}_en.pdf"))) {
                $pdfPath = "docs/td/WSC2026_TD{$num}_en.pdf";
            }

            Skill::where('code', $code)->update([
                'name_ar' => $data['name_ar'],
                'name_fr' => $data['name_fr'],
                'name_en' => $data['name_en'],
                'category_id' => $data['cat_id'],
                'pdf_path' => $pdfPath,
                'is_active' => true,
            ]);
        }
    }
}
