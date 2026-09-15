<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Edition;
use App\Models\Event;
use App\Models\EventScheduleItem;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsAndMediaSeeder extends Seeder
{
    public function run(): void
    {
        $edition = Edition::where('is_active', true)->first();

        // 1. Seed News Article
        NewsArticle::updateOrCreate(
            ['slug' => 'launch-of-worldskills-algeria-2026'],
            [
                'uuid' => (string) Str::uuid(),
                'title_ar' => 'الانطلاق الرسمي للتسجيلات والتصفيات الوطنية لأولمبياد المهن 2026',
                'title_fr' => 'Lancement officiel des inscriptions pour WorldSkills Algeria 2026',
                'title_en' => 'Official Launch of Registrations for WorldSkills Algeria 2026',
                'excerpt_ar' => 'أعلنت اللجنة الوطنية لأولمبياد المهن عن افتتاح باب التسجيل للمتربصين والشباب عبر 58 ولاية.',
                'excerpt_fr' => 'Le comité national annonce l\'ouverture des inscriptions à travers 58 wilayas.',
                'excerpt_en' => 'The national committee announces the opening of registrations across 58 wilayas.',
                'content_ar' => 'في إطار إستراتيجية تطوير التعليم والتكوين المهني بالجزائر، تم الإعلان رسمياً عن إطلاق أولمبياد المهن 2026.',
                'content_fr' => 'Dans le cadre de la stratégie de développement de la formation professionnelle, WorldSkills Algeria 2026 est lancé.',
                'content_en' => 'Within the strategy of vocational education development, WorldSkills Algeria 2026 is officially launched.',
                'edition_id' => $edition ? $edition->id : null,
                'category' => 'news',
                'status' => 'PUBLISHED',
                'published_at' => now(),
            ]
        );

        // 2. Seed Event & Timeline Schedule Items
        $event = Event::updateOrCreate(
            ['slug' => 'national-opening-ceremony-2026'],
            [
                'uuid' => (string) Str::uuid(),
                'edition_id' => $edition ? $edition->id : null,
                'title_ar' => 'حفل الافتتاح الرسمي والانطلاق الوطني للمنافسات',
                'title_fr' => 'Cérémonie Officielle d\'Ouverture et Lancement National',
                'title_en' => 'Official Opening Ceremony and National Competition Launch',
                'summary_ar' => 'تجمع الوفود الوطنية والدولية بالمركز الدولي للمؤتمرات بالجزائر العاصمة.',
                'summary_fr' => 'Rassemblement des délégations au Centre International des Conférences d\'Alger.',
                'summary_en' => 'Assembly of national and international delegations at CIC Algiers.',
                'start_at' => now()->addDays(30),
                'venue' => 'المركز الدولي للمؤتمرات عبد اللطيف رحال',
                'address' => 'بن عكنون - الجزائر العاصمة',
                'status' => 'PUBLISHED',
                'published_at' => now(),
            ]
        );

        EventScheduleItem::updateOrCreate(
            ['event_id' => $event->id, 'sort_order' => 1],
            [
                'title_ar' => 'استقبال وتأكيد تسجيل الوفود والمشاركين',
                'title_fr' => 'Accueil et vérification des délégations',
                'title_en' => 'Welcome and Delegation Registration Verification',
                'start_time' => '08:30',
                'end_time' => '10:00',
            ]
        );

        EventScheduleItem::updateOrCreate(
            ['event_id' => $event->id, 'sort_order' => 2],
            [
                'title_ar' => 'انطلاق المنافسات الفنية بورشات التكنولوجيا والمهن',
                'title_fr' => 'Début des épreuves techniques',
                'title_en' => 'Commencement of Skill Technical Competitions',
                'start_time' => '10:15',
                'end_time' => '13:00',
            ]
        );

        // 3. Seed Video
        Video::updateOrCreate(
            ['slug' => 'worldskills-algeria-official-teaser'],
            [
                'uuid' => (string) Str::uuid(),
                'title_ar' => 'الفيديو الترويجي الرسمي لأولمبياد المهن بالجزائر 2026',
                'title_fr' => 'Teaser Officiel WorldSkills Algeria 2026',
                'title_en' => 'WorldSkills Algeria 2026 Official Teaser',
                'description_ar' => 'استعرض مهارات الشباب الجزائري والتصفيات التنافسية بمختلف الولايات.',
                'video_type' => 'youtube',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'edition_id' => $edition ? $edition->id : null,
                'status' => 'PUBLISHED',
                'published_at' => now(),
            ]
        );

        // 4. Seed Photo Album
        Album::updateOrCreate(
            ['slug' => 'institutional-qualifications-gallery-2026'],
            [
                'uuid' => (string) Str::uuid(),
                'edition_id' => $edition ? $edition->id : null,
                'title_ar' => 'ألبوم الصور للتصفيات الأولية بمؤسسات التكوين والتعليم المهنيين',
                'title_fr' => 'Galerie photos des qualifications au niveau des établissements',
                'title_en' => 'Photo Gallery of Institutional Preliminary Qualifications',
                'description_ar' => 'صور توثيقية لاختبارات المتربصين بورشات التركيب الكهربائي، اللحام، وتطوير تقنيات الويب.',
                'status' => 'PUBLISHED',
                'published_at' => now(),
            ]
        );

        // 5. Seed Official Partners
        Partner::updateOrCreate(
            ['name_ar' => 'وزارة التكوين والتعليم المهنيين'],
            [
                'uuid' => (string) Str::uuid(),
                'name_fr' => 'Ministère de la Formation et de l\'Enseignement Professionnels',
                'name_en' => 'Ministry of Vocational Education',
                'website_url' => 'https://www.mfep.gov.dz',
                'partner_type' => 'organizer',
                'level' => 'platinum',
                'sort_order' => 1,
                'status' => 'active',
            ]
        );
    }
}
