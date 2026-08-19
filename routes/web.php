<?php

use App\Enums\RoleEnum;
use App\Livewire\Admin\AdminEventCenter;
use App\Livewire\Admin\AdminLogisticsCenter;
use App\Livewire\Admin\CmsHomepageManager;
use App\Livewire\Admin\MediaManagerDashboard;
use App\Livewire\Admin\ReadinessCenter;
use App\Livewire\Admin\SuperAdminDashboard;
use App\Livewire\Admin\AdminUserIndex;
use App\Livewire\Admin\AdminParticipantIndex;
use App\Livewire\Admin\AdminOrganizationIndex;
use App\Livewire\Admin\AdminCountryIndex;
use App\Livewire\Admin\AdminPartnerIndex;
use App\Livewire\Admin\AdminSkillIndex;
use App\Livewire\Admin\AdminWilayaIndex;
use App\Livewire\Admin\AdminEditionIndex;
use App\Livewire\Admin\AdminRegistrationIndex;
use App\Livewire\Admin\AdminJudgeIndex;
use App\Livewire\Admin\AdminEquipmentIndex;
use App\Livewire\Admin\AdminAccommodationIndex;
use App\Livewire\Admin\AdminTransportIndex;
use App\Livewire\Admin\AdminRestaurantIndex;
use App\Livewire\Admin\AdminMealScannerIndex;
use App\Livewire\Admin\AdminDietaryIndex;
use App\Livewire\Admin\DiplomaticCenter;
use App\Livewire\Admin\AdminNewsIndex;
use App\Livewire\Admin\AdminGalleryIndex;
use App\Livewire\Admin\AdminVideoIndex;
use App\Livewire\Admin\AdminAuditLogIndex;
use App\Livewire\Admin\AdminReportsIndex;
use App\Livewire\Admin\AdminCisEvaluationIndex;
use App\Livewire\Admin\AdminCertificateIndex;
use App\Livewire\Admin\AdminAccreditationIndex;
use App\Livewire\Admin\AdminTechnicalAppealsIndex;
use App\Livewire\Admin\AdminIntegrityAuditIndex;
use App\Livewire\Public\CertificateVerify;
use App\Livewire\Public\LiveTvDisplay;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\UserProfile;
use App\Livewire\Country\CountryDashboard;
use App\Livewire\Country\DelegationManager;
use App\Livewire\Country\DietaryManager;
use App\Livewire\Country\SkillSelectionManager;
use App\Livewire\Executive\ExecutiveDashboard;
use App\Livewire\Judge\JudgeDashboard;
use App\Livewire\Organization\OrganizationDashboard;
use App\Livewire\Participant\ParticipantDashboard;
use App\Livewire\Public\Contact;
use App\Livewire\Public\EventsIndex;
use App\Livewire\Public\Faq;
use App\Livewire\Public\GalleryIndex;
use App\Livewire\Public\GlobalSearch;
use App\Livewire\Public\Guide;
use App\Livewire\Public\Home;
use App\Livewire\Public\News;
use App\Livewire\Public\Partners;
use App\Livewire\Public\Privacy;
use App\Livewire\Public\Registration;
use App\Livewire\Public\Regulations;
use App\Livewire\Public\Results;
use App\Livewire\Public\Schedule;
use App\Livewire\Public\Skills;
use App\Livewire\Public\Terms;
use App\Livewire\Public\VideoCenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', Home::class)->name('home');
Route::get('/skills', Skills::class)->name('skills');
Route::get('/guide', Guide::class)->name('guide');
Route::get('/regulations', Regulations::class)->name('regulations');
Route::get('/guide-regulations', \App\Livewire\Public\GuideRegulations::class)->name('guide.regulations');
Route::get('/guide/td-viewer/{key}', [\App\Http\Controllers\Public\TechnicalDescriptionViewerController::class, 'show'])->name('td.viewer');
Route::get('/schedule', Schedule::class)->name('schedule');
Route::get('/results', Results::class)->name('results');
Route::get('/news', News::class)->name('news');
Route::get('/partners', Partners::class)->name('partners');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/faq', Faq::class)->name('faq');
Route::get('/registration', Registration::class)->middleware('throttle:registration')->name('registration');
Route::get('/registration/official', \App\Livewire\Public\OfficialRegistration::class)->name('official.registration');
Route::get('/login', Login::class)->middleware('throttle:login')->name('login');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');
Route::get('/profile', UserProfile::class)->middleware('auth')->name('profile');
Route::get('/notifications', \App\Livewire\User\UserNotifications::class)->middleware('auth')->name('user.notifications');

// Legal & CMS Public Routes
Route::get('/privacy', Privacy::class)->name('privacy');
Route::get('/terms', Terms::class)->name('terms');

Route::get('/gallery', GalleryIndex::class)->name('gallery');
Route::get('/events', EventsIndex::class)->name('events');
Route::get('/videos', VideoCenter::class)->name('videos');
Route::get('/search', GlobalSearch::class)->name('search');
Route::get('/verify', \App\Livewire\Public\Verification::class)->middleware('throttle:verify')->name('verify');
Route::get('/certificate/{number}', \App\Livewire\Public\Certificate::class)->middleware('throttle:certificate')->name('certificate');
Route::get('/certificate/official/{identifier}/{type?}', \App\Livewire\Public\OfficialCertificate::class)->name('official.certificate');
Route::get('/accreditation/badge/{identifier}', \App\Livewire\Public\AccreditationBadge::class)->name('accreditation.badge');
Route::get('/my-badge', function () {
    /** @var \App\Models\User|null $user */
    $user = \Illuminate\Support\Facades\Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }
    $reg = \App\Models\Registration::whereHas('participant', fn($p) => $p->where('user_id', $user->id))->first();
    $id = $reg?->registration_number ?? $user->uuid;
    return redirect()->route('accreditation.badge', ['identifier' => $id]);
})->middleware('auth')->name('my.badge');

Route::get('/my/notifications', \App\Livewire\User\UserNotifications::class)->middleware('auth')->name('my.notifications');

// PWA Routes
Route::get('/manifest.webmanifest', function () {
    return response(file_get_contents(public_path('manifest.webmanifest')), 200, [
        'Content-Type' => 'application/manifest+json'
    ]);
});
Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript'
    ]);
});
Route::get('/offline.html', function () {
    return response(file_get_contents(public_path('offline.html')), 200, [
        'Content-Type' => 'text/html'
    ]);
});

// Published Livewire Assets Fallback Route
Route::get('/vendor/livewire/{file}', function (string $file) {
    $path = public_path('vendor/livewire/' . $file);
    if (file_exists($path) && is_file($path)) {
        $mime = str_ends_with($file, '.css') ? 'text/css' : 'application/javascript';
        return response()->file($path, [
            'Content-Type'  => $mime . '; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
    return response('Livewire asset not found', 404);
});

// Language Switcher Route
Route::match(['get', 'post'], '/lang/{locale}', function (string $locale, \Illuminate\Http\Request $request) {
    if (in_array($locale, ['ar', 'fr', 'en'])) {
        session(['locale' => $locale]);
        session()->save();
        app()->setLocale($locale);
        if ($user = auth()->user()) {
            $user->update(['locale' => $locale]);
        }
    }

    $back = url()->previous();
    if (empty($back) || $back === $request->fullUrl()) {
        $back = route('home');
    }

    if ($request->expectsJson() || $request->header('X-Livewire')) {
        return response()->json(['status' => 'success', 'locale' => $locale, 'redirect' => $back]);
    }

    return redirect($back);
})->name('lang.switch');

// Shared CMS & Media Routes (Accessible by Super Admin & Media Manager)
Route::prefix('hamza')->middleware(['auth', 'role:' . RoleEnum::SUPER_ADMIN->value . '|' . RoleEnum::MEDIA_MANAGER->value])->name('admin.')->group(function () {
    Route::get('/media/dashboard', MediaManagerDashboard::class)->name('media.dashboard');
    Route::get('/cms/news',        AdminNewsIndex::class)->name('cms.news');
    Route::get('/cms/gallery',     AdminGalleryIndex::class)->name('cms.gallery');
    Route::get('/cms/videos',      AdminVideoIndex::class)->name('cms.videos');
    Route::get('/cms/homepage',    CmsHomepageManager::class)->name('cms.homepage');
    Route::get('/cms/guide', \App\Livewire\Admin\AdminGuideCmsManager::class)->name('cms.guide');
    Route::get('/appearance',      \App\Livewire\Admin\PlatformAppearanceManager::class)->name('appearance');
    Route::get('/live-tv',         \App\Livewire\Admin\LiveTvIndex::class)->name('live-tv');
});

// Smart Admin Dashboard Route — Handles all roles seamlessly without 403 Access Denied errors
Route::get('/hamza/dashboard', function () {
    /** @var \App\Models\User|null $user */
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
        return app(SuperAdminDashboard::class)();
    } elseif ($user->hasRole(RoleEnum::MEDIA_MANAGER->value)) {
        return redirect()->route('admin.media.dashboard');
    } elseif ($user->hasRole(RoleEnum::EXECUTIVE_VIEWER->value)) {
        return redirect()->route('executive.dashboard');
    } elseif ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
        return redirect()->route('country.dashboard');
    } elseif ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
        return redirect()->route('organization.dashboard');
    } elseif ($user->hasRole(RoleEnum::JUDGE->value) || $user->hasRole(RoleEnum::EXPERT->value)) {
        return redirect()->route('judge.dashboard');
    } elseif ($user->hasRole(RoleEnum::PARTICIPANT->value)) {
        return redirect()->route('participant.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth')->name('admin.dashboard');

// Super Admin Command Center Routes
Route::prefix('hamza')->middleware(['auth', 'role:' . RoleEnum::SUPER_ADMIN->value])->name('admin.')->group(function () {
    Route::get('/logistics/arrivals', \App\Livewire\Admin\ArrivalsCenter::class)->name('logistics.arrivals');
    Route::get('/users', AdminUserIndex::class)->name('users');
    Route::get('/participants', AdminParticipantIndex::class)->name('participants');
    Route::get('/organizations', AdminOrganizationIndex::class)->name('organizations');
    Route::get('/countries', AdminCountryIndex::class)->name('countries');
    Route::get('/delegation-invitations', \App\Livewire\Admin\DelegationInvitationsIndex::class)->name('delegation.invitations');
    Route::get('/delegation-invitations/print/{countryId}', [\App\Http\Controllers\Admin\DelegationInvitationPrintController::class, 'printSingle'])->name('delegation.invitations.print.single');
    Route::get('/partners', AdminPartnerIndex::class)->name('partners');
    Route::get('/skills',          AdminSkillIndex::class)->name('skills');
    Route::get('/wilayas',         AdminWilayaIndex::class)->name('wilayas');
    Route::get('/editions',        AdminEditionIndex::class)->name('editions');
    Route::get('/registrations',   AdminRegistrationIndex::class)->name('registrations');
    Route::get('/judges',          AdminJudgeIndex::class)->name('judges');
    Route::get('/equipment',       AdminEquipmentIndex::class)->name('equipment');
    Route::get('/accommodations',  AdminAccommodationIndex::class)->name('accommodations');
    Route::get('/transport',       AdminTransportIndex::class)->name('transport');
    Route::get('/restaurants',     AdminRestaurantIndex::class)->name('restaurants');
    Route::get('/meal-scanner',    AdminMealScannerIndex::class)->name('meal.scanner');
    Route::get('/dietary',         AdminDietaryIndex::class)->name('dietary');
    Route::get('/diplomatic',      DiplomaticCenter::class)->name('diplomatic');
    Route::get('/audit',           AdminAuditLogIndex::class)->name('audit');
    Route::get('/reports',         AdminReportsIndex::class)->name('reports');
    Route::get('/logistics', AdminLogisticsCenter::class)->name('logistics');
    Route::get('/readiness', ReadinessCenter::class)->name('readiness');
    Route::get('/events', AdminEventCenter::class)->name('events');
    Route::get('/cms/legal', \App\Livewire\Admin\LegalCmsManager::class)->name('cms.legal');

    // Communication & Notification Center (WSAP V8.3)
    Route::get('/notifications', \App\Livewire\Admin\Notifications\NotificationIndex::class)->name('notifications.index');
    Route::get('/notifications/create', \App\Livewire\Admin\Notifications\NotificationCreate::class)->name('notifications.create');
    Route::get('/schedule-engine', \App\Livewire\Admin\Schedule\MasterScheduleIndex::class)->name('schedule.index');
    Route::get('/operations', \App\Livewire\Admin\FieldOperationsDashboard::class)->name('operations');

    // Competition Governance Layer (V8.2)
    Route::get('/cis',              AdminCisEvaluationIndex::class)->name('cis');
    Route::get('/certificates',     AdminCertificateIndex::class)->name('certificates');
    Route::get('/accreditations',   AdminAccreditationIndex::class)->name('accreditations');
    Route::get('/accreditations/batch-print', \App\Livewire\Public\AccreditationBatchPrint::class)->name('accreditations.batch-print');
    Route::get('/scanner',          \App\Livewire\Admin\AdminQrScanner::class)->name('scanner');
    Route::get('/appeals',          AdminTechnicalAppealsIndex::class)->name('appeals');
    Route::get('/integrity',        AdminIntegrityAuditIndex::class)->name('integrity');
});

// Public: Certificate Verification & Live TV Display
Route::get('/verify-certificate/{token}', CertificateVerify::class)->name('certificate.verify');
Route::get('/live-tv', LiveTvDisplay::class)->name('live-tv');

// Executive Minister Read-Only Dashboard Routes
Route::prefix('executive')->middleware(['auth', 'role:' . RoleEnum::EXECUTIVE_VIEWER->value])->name('executive.')->group(function () {
    Route::get('/dashboard', ExecutiveDashboard::class)->name('dashboard');
    Route::get('/dietary', \App\Livewire\Executive\ExecutiveDietary::class)->name('dietary');
    Route::get('/diplomatic', \App\Livewire\Executive\ExecutiveDiplomatic::class)->name('diplomatic');
});

// Algerian Vocational Organization Institute Routes
Route::prefix('organization')->middleware(['auth', 'role:' . RoleEnum::ORGANIZATION_ADMIN->value])->name('organization.')->group(function () {
    Route::get('/dashboard', OrganizationDashboard::class)->name('dashboard');
});

// Judge Evaluation Portal Routes
Route::prefix('judge')->middleware(['auth', 'role:' . RoleEnum::JUDGE->value])->name('judge.')->group(function () {
    Route::get('/dashboard', JudgeDashboard::class)->name('dashboard');
});

// Participant Portal Routes
Route::prefix('participant')->middleware(['auth', 'role:' . RoleEnum::PARTICIPANT->value])->name('participant.')->group(function () {
    Route::get('/dashboard', ParticipantDashboard::class)->name('dashboard');
});

// Country Portal Routes
Route::prefix('country')->middleware(['auth', 'role:' . RoleEnum::COUNTRY_ADMIN->value])->name('country.')->group(function () {
    Route::get('/dashboard', CountryDashboard::class)->name('dashboard');
    Route::get('/delegation', DelegationManager::class)->name('delegation');
    Route::get('/participants', DelegationManager::class)->name('participants');
    Route::get('/judges', DelegationManager::class)->name('judges');
    Route::get('/press', DelegationManager::class)->name('press');
    Route::get('/supervisors', DelegationManager::class)->name('supervisors');
    Route::get('/vips', DelegationManager::class)->name('vips');
    Route::get('/appeals', CountryDashboard::class)->name('appeals');
    Route::get('/skills', SkillSelectionManager::class)->name('skills');
    Route::get('/dietary', DietaryManager::class)->name('dietary');
    Route::get('/arrivals', \App\Livewire\Country\DelegationArrivals::class)->name('arrivals');
    Route::get('/regulations', \App\Livewire\Public\GuideRegulations::class)->name('regulations');
});

// Dedicated REST Spatial API fallback
Route::prefix('api/venue')->group(function () {
    Route::get('/snapshot', [\App\Http\Controllers\Api\VenueApiController::class, 'snapshot']);
    Route::get('/pois', [\App\Http\Controllers\Api\VenueApiController::class, 'pois']);
    Route::get('/operations', [\App\Http\Controllers\Api\VenueApiController::class, 'operations']);
    Route::get('/analytics', [\App\Http\Controllers\Api\VenueApiController::class, 'analytics']);
    Route::get('/route', [\App\Http\Controllers\Api\VenueApiController::class, 'route']);
    Route::post('/poi/update-transform', [\App\Http\Controllers\Api\VenueApiController::class, 'updatePoiTransform']);
});
