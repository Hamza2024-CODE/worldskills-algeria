<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\User;

class DashboardNavigationService
{
    /**
     * Returns structured categorized navigation arrays for dashboard sidebars and mobile drawers.
     */
    public function getCategorizedNavigation(?User $user = null): array
    {
        // Default fallback to SUPER_ADMIN / NATIONAL_ADMIN
        if (!$user || $user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
            return [
                [
                    'category' => $this->t('التحكم والتوجيه الإستراتيجي', 'Commandement Central', 'Strategic Command'),
                    'category_icon' => 'home',
                    'items' => [
                        ['key' => 'dash',       'label' => $this->t('لوحة التحكم القيادية', 'Tableau de Bord', 'Main Dashboard'), 'icon' => 'home', 'route' => 'admin.dashboard'],
                        ['key' => 'operations', 'label' => $this->t('مركز العمليات والجهوزية الميدانية', 'Centre d'Opérations', 'Field Operations Center'), 'icon' => 'bolt', 'route' => 'admin.operations'],
                        ['key' => 'readiness',  'label' => $this->t('مؤشر الجهوزية الأولمبية', 'Indicateur de Préparation', 'Readiness Index'), 'icon' => 'chart-bar', 'route' => 'admin.readiness'],
                        ['key' => 'events',     'label' => $this->t('جدول التظاهرات والفعاليات', 'Événements & Agenda', 'Events & Ceremonies'), 'icon' => 'calendar', 'route' => 'admin.events'],
                    ]
                ],
                [
                    'category' => $this->t('إدارة المتنافسين والوفود', 'Compétiteurs & Délégations', 'Competitors & Delegations'),
                    'category_icon' => 'users',
                    'items' => [
                        ['key' => 'users',         'label' => $this->t('سجل وحسابات المستخدمين', 'Utilisateurs', 'Users & Accounts'), 'icon' => 'users', 'route' => 'admin.users'],
                        ['key' => 'registrations', 'label' => $this->t('سجل التسجيلات والطلبات', 'Inscriptions', 'Registrations Log'), 'icon' => 'clipboard-list', 'route' => 'admin.registrations'],
                        ['key' => 'participants',  'label' => $this->t('المتنافسون والمترشحون المعتمدون', 'Compétiteurs', 'Approved Competitors'), 'icon' => 'user', 'route' => 'admin.participants'],
                        ['key' => 'countries',     'label' => $this->t('الدول والوفود الوطنية المشاركة', 'Délégations Nationales', 'Participating Countries'), 'icon' => 'flag', 'route' => 'admin.countries'],
                        ['key' => 'diplomatic',    'label' => $this->t('الوفود الرسمية والدبلوماسية VIP', 'Délégations VIP', 'VIP & Diplomatic'), 'icon' => 'sparkles', 'route' => 'admin.diplomatic'],
                    ]
                ],
                [
                    'category' => $this->t('التخصصات والتحكيم والتنافس', 'Métiers & Évaluation', 'Skills & Assessment'),
                    'category_icon' => 'trophy',
                    'items' => [
                        ['key' => 'skills',        'label' => $this->t('التخصصات الأولمبية والمهن', 'Compétences Olympiques', 'Olympic Skills'), 'icon' => 'trophy', 'route' => 'admin.skills'],
                        ['key' => 'judges',        'label' => $this->t('المحكمون والخبراء ومجالس التحكيم', 'Jury & Experts', 'Judges & Experts'), 'icon' => 'scale', 'route' => 'admin.judges'],
                        ['key' => 'cis',           'label' => $this->t('نظام التقييم الميداني (CIS)', 'Système d'Évaluation CIS', 'CIS Evaluation System'), 'icon' => 'chart-bar', 'route' => 'admin.cis'],
                        ['key' => 'appeals',       'label' => $this->t('الطعون الفنية والاعتراضات', 'Recours Techniques', 'Technical Appeals'), 'icon' => 'scale', 'route' => 'admin.appeals'],
                        ['key' => 'equipment',     'label' => $this->t('المعدات والتجهيزات الفنية', 'Équipements Techniques', 'Technical Equipment'), 'icon' => 'wrench-screwdriver', 'route' => 'admin.equipment'],
                    ]
                ],
                [
                    'category' => $this->t('الاعتمادات والأمن والخدمات الميدانية', 'Accréditations & Services', 'Accreditation & Field Services'),
                    'category_icon' => 'shield-check',
                    'items' => [
                        ['key' => 'accreditations','label' => $this->t('بطاقات الاعتماد والمناطق الأمنية', 'Accréditations & Zones', 'Accreditations & Zones'), 'icon' => 'identification', 'route' => 'admin.accreditations'],
                        ['key' => 'certificates',  'label' => $this->t('الشهادات والتوثيق الإلكتروني QR', 'Certificats & QR', 'QR Certificates'), 'icon' => 'document-check', 'route' => 'admin.certificates'],
                        ['key' => 'scanner',       'label' => $this->t('ماسح الـ QR الأمني المباشر', 'Scanner QR Sécurité', 'Security QR Scanner'), 'icon' => 'camera', 'route' => 'admin.scanner'],
                        ['key' => 'accommodations','label' => $this->t('السكن والإقامة بالقرية', 'Hébergement', 'Accommodations'), 'icon' => 'building-office', 'route' => 'admin.accommodations'],
                        ['key' => 'logistics_arrivals', 'label' => $this->t('وصول الوفود وتذاكر الطيران', 'Arrivées & Vol', 'Arrivals & Flights'), 'icon' => 'truck', 'route' => 'admin.logistics.arrivals'],
                        ['key' => 'restaurants',   'label' => $this->t('المطاعم والإطعام والوجبات', 'Restauration & Repas', 'Catering & Meals'), 'icon' => 'cake', 'route' => 'admin.restaurants'],
                        ['key' => 'meal_scanner',  'label' => $this->t('ماسح شارة المطعم الإطعام', 'Scanner Repas', 'Meal Scanner'), 'icon' => 'qr-code', 'route' => 'admin.meal.scanner'],
                        ['key' => 'dietary',       'label' => $this->t('حساسيات الطعام والأنظمة الغذائية', 'Régimes Alimentaires', 'Dietary & Allergies'), 'icon' => 'sparkles', 'route' => 'admin.dietary'],
                    ]
                ],
                [
                    'category' => $this->t('محتوى المنصة والتواصل والإعدادات', 'CMS, Media & Système', 'CMS, Media & System'),
                    'category_icon' => 'newspaper',
                    'items' => [
                        ['key' => 'cms_homepage',  'label' => $this->t('إدارة الواجهة والصفحة الرئيسية (CMS)', 'CMS Page d'Accueil', 'CMS Homepage Manager'), 'icon' => 'home', 'route' => 'admin.cms.homepage'],
                        ['key' => 'live_tv',       'label' => $this->t('التحكم بالبث المباشر (Live TV)', 'Direct TV & Diffusion', 'Live TV Broadcast'), 'icon' => 'video-camera', 'route' => 'admin.live-tv'],
                        ['key' => 'cms_news',      'label' => $this->t('الأخبار والمقالات والتغطيات', 'Actualités & Articles', 'News & Articles'), 'icon' => 'newspaper', 'route' => 'admin.cms.news'],
                        ['key' => 'cms_videos',    'label' => $this->t('مكتبة الفيديو والتلفزيون', 'Vidéothèque', 'Video Library'), 'icon' => 'video-camera', 'route' => 'admin.cms.videos'],
                        ['key' => 'cms_gallery',   'label' => $this->t('معرض الصور والفعاليات', 'Galerie Photos', 'Photo Gallery'), 'icon' => 'photo', 'route' => 'admin.cms.gallery'],
                        ['key' => 'partners',      'label' => $this->t('الشركاء والرعاة الرسميون', 'Partenaires & Sponsors', 'Partners & Sponsors'), 'icon' => 'sparkles', 'route' => 'admin.partners'],
                        ['key' => 'legal',         'label' => $this->t('الشروط والسياسات القانونية', 'Mentions Légales', 'Legal & Terms'), 'icon' => 'document-text', 'route' => 'admin.cms.legal'],
                        ['key' => 'notifications', 'label' => $this->t('مركز التواصل والتنبيهات', 'Centre de Notifications', 'Notification Center'), 'icon' => 'bell', 'route' => 'admin.notifications.index'],
                        ['key' => 'reports',       'label' => $this->t('التقارير والإحصائيات الشاملة', 'Rapports & Statistiques', 'Reports & Analytics'), 'icon' => 'chart-bar', 'route' => 'admin.reports'],
                        ['key' => 'appearance',    'label' => $this->t('استوديو المظهر والهوية', 'Apparence & Style', 'Appearance Studio'), 'icon' => 'paint-brush', 'route' => 'admin.appearance'],
                        ['key' => 'editions',      'label' => $this->t('الدورات والطبعات الرسمية', 'Éditions Officielles', 'Official Editions'), 'icon' => 'calendar', 'route' => 'admin.editions'],
                        ['key' => 'security',      'label' => $this->t('الأمان وسجلات الرقابة التدقيقية', 'Sécurité & Traçabilité', 'Security Audit Trail'), 'icon' => 'shield-check', 'route' => 'admin.audit'],
                    ]
                ]
            ];
        }

        if ($user->hasRole(RoleEnum::EXECUTIVE_VIEWER->value)) {
            return [
                [
                    'category' => $this->t('اللوحة الوزارية التنفيذية', 'Aperçu Ministériel', 'Ministerial Overview'),
                    'category_icon' => 'building-office',
                    'items' => [
                        ['key' => 'exec_dash',   'label' => $this->t('اللوحة الوزارية المصغرة', 'Aperçu Ministériel', 'Ministerial Overview'), 'icon' => 'chart-bar', 'route' => 'executive.dashboard'],
                        ['key' => 'profile',     'label' => $this->t('الملف الشخصي والوزاري', 'Mon Profil', 'My Profile'), 'icon' => 'user', 'route' => 'profile'],
                        ['key' => 'dietary',     'label' => $this->t('الملف الغذائي والحساسيات', 'Régime Alimentaire', 'Dietary & Allergies'), 'icon' => 'sparkles', 'route' => 'executive.dietary'],
                        ['key' => 'diplomatic',  'label' => $this->t('حجز قاعات المباحثات', 'Réservation Salons', 'Lounge Booking'), 'icon' => 'building-office', 'route' => 'executive.diplomatic'],
                    ]
                ]
            ];
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return [
                [
                    'category' => $this->t('إدارة الوفد الوطني', 'Gestion de la Délégation', 'Delegation Management'),
                    'category_icon' => 'flag',
                    'items' => [
                        ['key' => 'country_dash','label' => $this->t('مركز الوفد الوطني', 'Centre Délégation', 'Delegation Dashboard'), 'icon' => 'flag', 'route' => 'country.dashboard'],
                        ['key' => 'delegation',  'label' => $this->t('كشف الوفد الموحد', 'Membres Délégation', 'Full Roster'), 'icon' => 'users', 'route' => 'country.delegation'],
                        ['key' => 'participants','label' => $this->t('المتنافسون والمترشحون', 'Compétiteurs', 'Competitors'), 'icon' => 'user', 'route' => 'country.participants'],
                        ['key' => 'judges',      'label' => $this->t('الحكام والخبراء', 'Juges & Experts', 'Judges & Experts'), 'icon' => 'scale', 'route' => 'country.judges'],
                        ['key' => 'press',       'label' => $this->t('الصحافة والإعلام', 'Presse & Médias', 'Press & Media'), 'icon' => 'newspaper', 'route' => 'country.press'],
                        ['key' => 'supervisors', 'label' => $this->t('المؤطرون وقادة الفرق', 'Encadrants', 'Supervisors'), 'icon' => 'academic-cap', 'route' => 'country.supervisors'],
                        ['key' => 'vips',        'label' => $this->t('الوفود الرسمية و VIP', 'Délégations & VIP', 'VIPs & Officials'), 'icon' => 'sparkles', 'route' => 'country.vips'],
                    ]
                ],
                [
                    'category' => $this->t('الخدمات واللوجستيات', 'Logistique & Services', 'Logistics & Services'),
                    'category_icon' => 'truck',
                    'items' => [
                        ['key' => 'appeals',     'label' => $this->t('الطعون الفنية', 'Recours Techniques', 'Technical Appeals'), 'icon' => 'document-text', 'route' => 'country.appeals'],
                        ['key' => 'dietary',     'label' => $this->t('حساسية الطعام والإطعام', 'Allergies & Restauration', 'Dietary & Food Allergies'), 'icon' => 'sparkles', 'route' => 'country.dietary'],
                        ['key' => 'arrivals',    'label' => $this->t('تذاكر الطيران وتوقيت الوصول', 'Billets d\'Avion & Arrivée', 'Flight Tickets & Arrival'), 'icon' => 'truck', 'route' => 'country.arrivals'],
                        ['key' => 'skills_sel',  'label' => $this->t('اختيار التخصصات', 'Sélection Métiers', 'Skill Selection'), 'icon' => 'check-circle', 'route' => 'country.skills'],
                        ['key' => 'regulations', 'label' => $this->t('الشروط واللوائح', 'Règlements', 'Rules & Regulations'), 'icon' => 'shield-check', 'route' => 'country.regulations'],
                    ]
                ]
            ];
        }

        if ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
            return [
                [
                    'category' => $this->t('مركز المؤسسة', 'Centre Institution', 'Institution Center'),
                    'category_icon' => 'building-office',
                    'items' => [
                        ['key' => 'org_dash',   'label' => $this->t('مركز المؤسسة', 'Centre Institution', 'Institution Center'), 'icon' => 'building-office', 'route' => 'organization.dashboard'],
                        ['key' => 'candidates', 'label' => $this->t('المترشحون', 'Candidats', 'Candidates'), 'icon' => 'users', 'route' => 'organization.dashboard'],
                        ['key' => 'trainers',   'label' => $this->t('المدربون', 'Formateurs', 'Trainers'), 'icon' => 'academic-cap', 'route' => 'organization.dashboard'],
                    ]
                ]
            ];
        }

        if ($user->hasRole(RoleEnum::JUDGE->value)) {
            return [
                [
                    'category' => $this->t('مركز التحكيم', 'Centre du Jury', 'Jury Center'),
                    'category_icon' => 'scale',
                    'items' => [
                        ['key' => 'judge_dash', 'label' => $this->t('مركز التحكيم', 'Centre du Jury', 'Jury Center'), 'icon' => 'scale', 'route' => 'judge.dashboard'],
                        ['key' => 'assigned',   'label' => $this->t('التخصصات المُسندة', 'Métiers Assignés', 'Assigned Skills'), 'icon' => 'clipboard-list', 'route' => 'judge.dashboard'],
                    ]
                ]
            ];
        }

        if ($user->hasRole(RoleEnum::PARTICIPANT->value)) {
            return [
                [
                    'category' => $this->t('فضائي الشخصي', 'Mon Espace', 'My Space'),
                    'category_icon' => 'user',
                    'items' => [
                        ['key' => 'part_space', 'label' => $this->t('فضائي الشخصي', 'Mon Espace', 'My Space'), 'icon' => 'user', 'route' => 'participant.dashboard'],
                        ['key' => 'reg_journey','label' => $this->t('مسار التسجيل', 'Parcours Inscription', 'Registration'), 'icon' => 'clipboard-list', 'route' => 'participant.dashboard'],
                    ]
                ]
            ];
        }

        if ($user->hasRole(RoleEnum::SPONSOR->value)) {
            return [
                [
                    'category' => $this->t('فضاء الراعي والشريك', 'Espace Partenaire', 'Sponsor Space'),
                    'category_icon' => 'sparkles',
                    'items' => [
                        ['key' => 'sponsor',    'label' => $this->t('فضاء الراعي', 'Espace Partenaire', 'Sponsor Space'), 'icon' => 'sparkles', 'route' => 'partners'],
                    ]
                ]
            ];
        }

        return [];
    }

    /**
     * Backward-compatibility helper returning flat list of navigation items.
     */
    public function getNavigation(?User $user = null): array
    {
        $categorized = $this->getCategorizedNavigation($user);
        $flat = [];
        foreach ($categorized as $group) {
            foreach ($group['items'] ?? [] as $item) {
                $flat[] = $item;
            }
        }
        return $flat;
    }

    private function t(string $ar, string $fr, string $en): string
    {
        return match(app()->getLocale()) {
            'fr'    => $fr,
            'en'    => $en,
            default => $ar,
        };
    }
}
