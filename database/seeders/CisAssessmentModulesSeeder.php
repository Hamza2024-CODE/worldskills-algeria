<?php

namespace Database\Seeders;

use App\Models\CompetitionAssessmentCriterion;
use App\Models\CompetitionAssessmentModule;
use App\Models\Edition;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class CisAssessmentModulesSeeder extends Seeder
{
    public function run(): void
    {
        $edition = Edition::where('is_active', true)->first() 
            ?? Edition::firstOrCreate(['year' => 2026], ['name_ar' => 'أولمبياد المهن 2026', 'name_fr' => 'WorldSkills Algeria 2026', 'name_en' => 'WorldSkills Algeria 2026', 'is_active' => true]);

        $skills = Skill::where('is_active', true)->get();

        if ($skills->isEmpty()) {
            return;
        }

        $standardModules = [
            [
                'code'      => 'Module A',
                'title_ar'  => 'وحدة الإعداد والتنفيذ التقني (Module A)',
                'title_fr'  => 'Module A - Technical Preparation',
                'max_score' => 40.00,
                'criteria'  => [
                    ['title_ar' => 'السلامة وتنظيم مكان العمل (Safety & Work Organization)', 'title_fr' => 'Safety & Organization', 'type' => 'MEASUREMENT', 'max_score' => 10.00],
                    ['title_ar' => 'الدقة التقنية والامتثال للـ WSOS Standards', 'title_fr' => 'Technical Precision', 'type' => 'JUDGEMENT', 'max_score' => 30.00],
                ],
            ],
            [
                'code'      => 'Module B',
                'title_ar'  => 'وحدة الجودة والنتيجة النهائية (Module B)',
                'title_fr'  => 'Module B - Quality & Final Output',
                'max_score' => 60.00,
                'criteria'  => [
                    ['title_ar' => 'اختبارات الأداء الميدانية (Performance Measurements)', 'title_fr' => 'Performance Measurement', 'type' => 'MEASUREMENT', 'max_score' => 30.00],
                    ['title_ar' => 'تقييم الجودة والابتكار (Judgement Evaluation)', 'title_fr' => 'Quality & Innovation', 'type' => 'JUDGEMENT', 'max_score' => 30.00],
                ],
            ],
        ];

        foreach ($skills as $skill) {
            foreach ($standardModules as $modData) {
                $module = CompetitionAssessmentModule::updateOrCreate(
                    [
                        'skill_id'   => $skill->id,
                        'edition_id' => $edition->id,
                        'code'       => $modData['code'],
                    ],
                    [
                        'title_ar'  => $modData['title_ar'],
                        'title_fr'  => $modData['title_fr'],
                        'title_en'  => $modData['title_fr'],
                        'max_score' => $modData['max_score'],
                    ]
                );

                foreach ($modData['criteria'] as $critData) {
                    CompetitionAssessmentCriterion::updateOrCreate(
                        [
                            'module_id' => $module->id,
                            'title_ar'  => $critData['title_ar'],
                        ],
                        [
                            'title_fr'  => $critData['title_fr'],
                            'type'      => $critData['type'],
                            'max_score' => $critData['max_score'],
                        ]
                    );
                }
            }
        }
    }
}
