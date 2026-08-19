<?php

namespace App\Livewire\Public;

use App\Enums\ParticipantStatus;
use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\Edition;
use App\Models\Organization;
use App\Models\ParticipantDocument;
use App\Models\ParticipantProfile;
use App\Models\Registration as RegistrationModel;
use App\Models\Skill;
use App\Models\SkillEquipment;
use App\Models\User;
use App\Models\Wilaya;
use App\Services\DocumentVerificationService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.public')]
class Registration extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public mixed $countryId = null;
    public bool $isAlgeria = true;

    // Step 1: Personal Info
    public string $firstNameAr = '';
    public string $lastNameAr = '';
    public string $firstNameLatin = '';
    public string $lastNameLatin = '';
    public string $dateOfBirth = '';
    public string $gender = 'male';
    public string $email = '';
    public string $phone = '';

    // Step 2: Official Photo & Identity Documents
    public mixed $photoFile = null;
    public string $identificationType = 'national_id';
    public string $nationalId = '';
    public string $passportNumber = '';
    public mixed $nationalIdFile = null;
    public mixed $passportFile = null;

    // Step 3: Suit & Clothing Sizing
    public string $suitSize = 'M';
    public string $shoeSize = '42';
    public int $heightCm = 175;

    // Step 4: Hierarchy & Skill Selection
    public mixed $wilayaId = null;
    public mixed $organizationId = null;
    public mixed $skillId = null;
    public ?Skill $selectedSkill = null;
    public mixed $skillEquipments = [];

    // Success Output
    public string $registrationNumber = '';
    public string $verificationToken = '';
    public bool $isSubmitted = false;

    public bool $isArabicCountry = true;
    public bool $registrationEnabled = true;

    public function mount(): void
    {
        $settings = app(\App\Services\SettingsEngine::class);
        $this->registrationEnabled = (bool) $settings->get('registration_competitors_enabled', true);

        $algeria = Country::where('iso2', 'DZ')->first();
        if ($algeria) {
            $this->countryId = $algeria->id;
            $this->isAlgeria = true;
            $this->isArabicCountry = true;
        }
        $this->dateOfBirth = date('Y-m-d', strtotime('-20 years'));
    }

    public function updatedCountryId(mixed $val): void
    {
        $arabicIsos = ['DZ', 'TN', 'MA', 'EG', 'LY', 'MR', 'SD', 'DJ', 'KM', 'SO'];
        $country = Country::find($val);
        $this->isAlgeria = $country ? (bool) $country->is_algeria : false;
        $this->isArabicCountry = $country ? in_array($country->iso2, $arabicIsos) : true;
        $this->identificationType = $this->isAlgeria ? 'national_id' : 'passport';
    }

    public function updatedWilayaId(mixed $val): void
    {
        $this->organizationId = null;
    }

    public function updatedSkillId(mixed $val): void
    {
        if ($val) {
            $this->selectedSkill = Skill::find($val);
            $this->skillEquipments = SkillEquipment::with('equipmentItem')->where('skill_id', $val)->get();
        } else {
            $this->selectedSkill = null;
            $this->skillEquipments = [];
        }
    }

    public function getPhonePlaceholderProperty(): string
    {
        $country = Country::find($this->countryId);
        $locale = app()->getLocale();
        if (!$country) {
            return $locale === 'fr' ? 'Ex: 0550123456 ou +213550123456' : ($locale === 'en' ? 'Ex: 0550123456 or +213550123456' : 'مثال: 0550123456 أو +213550123456');
        }

        $code = $country->phone_code ?: ($country->is_algeria ? '+213' : '');

        return match($country->iso2) {
            'DZ' => $locale === 'fr' ? 'Ex: 0550123456 ou +213550123456' : ($locale === 'en' ? 'Ex: 0550123456 or +213550123456' : 'مثال: 0550123456 أو +213550123456'),
            'TN' => "{$code} 20 123 456",
            'MA' => "{$code} 6 12 34 56 78",
            'EG' => "{$code} 10 1234 5678",
            'LY' => "{$code} 91 123 4567",
            'MR' => "{$code} 45 12 34 56",
            'SD' => "{$code} 91 234 5678",
            default => !empty($code) 
                ? ($locale === 'fr' ? "Ex: {$code} 55 000 0000" : ($locale === 'en' ? "Ex: {$code} 55 000 0000" : "مثال: {$code} 55 000 0000"))
                : ($locale === 'fr' ? 'Ex: +213 550 00 00 00' : ($locale === 'en' ? 'Ex: +213 550 00 00 00' : 'مثال: 0550000000 / +213'))
        };
    }

    public function validateAge(): bool
    {
        if (empty($this->dateOfBirth)) {
            return false;
        }

        $dob = Carbon::parse($this->dateOfBirth);
        $ageYears = $dob->diffInYears(Carbon::now());

        return $ageYears <= 26;
    }

    public function nextStep()
    {
        /** @var DocumentVerificationService $docVerifier */
        $docVerifier = app(DocumentVerificationService::class);

        if ($this->step === 1) {
            $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            
            $phoneRegex = $this->isAlgeria 
                ? '/^(?:(?:\+?213|00213|0)[567][0-9]{8})$/'
                : '/^(?:\+|00)?(?:213|216|212|237|221|225|234|254|249|251|218|220|233|255|256|260|263|264|267|268|266|250|257|235|236|242|243|241|240|238|239|224|245|232|231|228|229|227|223|222|253|252|261|230|248|269|265|258|244|262|290|247)[0-9]{6,12}$/';

            $rules = [
                'countryId'      => ['required', 'exists:countries,id'],
                'firstNameLatin' => ['required', 'min:2', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ]+$/'],
                'lastNameLatin'  => ['required', 'min:2', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ]+$/'],
                'email'          => ['required', 'email', 'regex:' . $emailRegex],
                'phone'          => ['required', 'regex:' . $phoneRegex],
                'dateOfBirth'    => ['required', 'date'],
            ];

            if ($this->isArabicCountry) {
                $rules['firstNameAr'] = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
                $rules['lastNameAr']  = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
            }

            $locale = app()->getLocale();

            $this->validate($rules, [
                'countryId.required'   => $locale === 'fr' ? 'Veuillez sélectionner le pays de la délégation.' : ($locale === 'en' ? 'Please select delegation country.' : 'يرجى اختيار دولة الوفد المشارك.'),
                'firstNameAr.required' => $locale === 'fr' ? 'Le prénom en arabe est requis.' : ($locale === 'en' ? 'First name in Arabic is required.' : 'الاسم الشخصي بالعربية مطلوب.'),
                'lastNameAr.required'  => $locale === 'fr' ? 'Le nom en arabe est requis.' : ($locale === 'en' ? 'Last name in Arabic is required.' : 'اللقب العائلي بالعربية مطلوب.'),
                'firstNameAr.regex'    => $locale === 'fr' ? 'Le prénom en arabe doit contenir uniquement des lettres arabes.' : ($locale === 'en' ? 'First name in Arabic must contain Arabic characters only.' : 'الاسم بالعربية يجب أن يتكون من أحرف عربية فقط.'),
                'lastNameAr.regex'     => $locale === 'fr' ? 'Le nom en arabe doit contenir uniquement des lettres arabes.' : ($locale === 'en' ? 'Last name in Arabic must contain Arabic characters only.' : 'اللقب بالعربية يجب أن يتكون من أحرف عربية فقط.'),
                'firstNameLatin.required' => $locale === 'fr' ? 'Le prénom en latin est requis.' : ($locale === 'en' ? 'First name in Latin characters is required.' : 'الاسم بالفرنسية/اللاتينية مطلوب.'),
                'lastNameLatin.required'  => $locale === 'fr' ? 'Le nom en latin est requis.' : ($locale === 'en' ? 'Last name in Latin characters is required.' : 'اللقب بالفرنسية/اللاتينية مطلوب.'),
                'firstNameLatin.regex' => $locale === 'fr' ? 'Le prénom doit contenir uniquement des lettres latines.' : ($locale === 'en' ? 'First name must contain Latin characters only.' : 'الاسم بالفرنسية/اللاتينية يجب أن يحتوي على أحرف لاتينية فقط.'),
                'lastNameLatin.regex'  => $locale === 'fr' ? 'Le nom doit contenir uniquement des lettres latines.' : ($locale === 'en' ? 'Last name must contain Latin characters only.' : 'اللقب بالفرنسية/اللاتينية يجب أن يحتوي على أحرف لاتينية فقط.'),
                'email.required'       => $locale === 'fr' ? 'L\'adresse email est requise.' : ($locale === 'en' ? 'Email address is required.' : 'البريد الإلكتروني مطلوب.'),
                'email.regex'          => $locale === 'fr' ? 'Veuillez saisir une adresse email valide.' : ($locale === 'en' ? 'Please enter a valid email address.' : 'يرجى إدخال بريد إلكتروني صحيح ومعتمد.'),
                'phone.required'       => $locale === 'fr' ? 'Le numéro de téléphone est requis.' : ($locale === 'en' ? 'Phone number is required.' : 'رقم الهاتف مطلوب.'),
                'phone.regex'          => $this->isAlgeria 
                                            ? ($locale === 'fr' ? 'Numéro algérien invalide. Doit comporter 10 chiffres et commencer par (05/06/07).' : ($locale === 'en' ? 'Invalid Algerian phone number. Must be 10 digits starting with 05/06/07.' : 'رقم الهاتف الجزائري غير صحيح. يجب أن يتكون من 10 أرقام ويبدأ بـ (05/06/07).'))
                                            : ($locale === 'fr' ? 'Numéro de téléphone invalide.' : ($locale === 'en' ? 'Invalid phone number.' : 'رقم الهاتف غير صحيح.')),
                'dateOfBirth.required' => $locale === 'fr' ? 'La date de naissance est requise.' : ($locale === 'en' ? 'Date of birth is required.' : 'تاريخ الميلاد مطلوب.'),
            ]);

            // Uniqueness Check for Email and Phone
            $check = $docVerifier->checkIdentityUniqueness(null, null, $this->email, $this->phone);
            if (!$check['is_valid']) {
                foreach ($check['errors'] as $field => $msg) {
                    if ($field === 'email') $this->addError('email', $msg);
                    if ($field === 'phone') $this->addError('phone', $msg);
                }
                return;
            }

            if (!$this->validateAge()) {
                $this->addError('dateOfBirth', $locale === 'fr' ? 'Désolé, le candidat ne doit pas dépasser 26 ans pour participer.' : ($locale === 'en' ? 'Sorry, candidate age must not exceed 26 years.' : 'عذراً، يجب ألا يتجاوز عمر المترشح 26 سنة للمشاركة في أولمبياد المهن (≤ 26 سنة).'));
                return;
            }
        } elseif ($this->step === 2) {
            $locale = app()->getLocale();
            $rules = [
                'photoFile' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            ];

            $messages = [
                'photoFile.required' => $locale === 'fr' ? 'Veuillez charger la photo officielle du candidat.' : ($locale === 'en' ? 'Please upload the candidate\'s official photo.' : 'يرجى تحميل الصورة الشخصية الرسمية للمترشح.'),
                'photoFile.image'    => $locale === 'fr' ? 'Le fichier photo doit être une image valide.' : ($locale === 'en' ? 'Uploaded photo file must be a valid image.' : 'الملف المرفق للصورة يجب أن يكون صورة بحجم مناسب.'),
            ];

            if ($this->isAlgeria) {
                $rules['nationalId'] = 'required|regex:/^[0-9]{18}$/';
                $rules['nationalIdFile'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240';
                $messages['nationalId.required'] = $locale === 'fr' ? 'Le numéro NIN (18 chiffres) est requis.' : ($locale === 'en' ? 'NIN number (18 digits) is required.' : 'رقم التعريف الوطني (18 رقماً) مطلوب.');
                $messages['nationalId.regex'] = $locale === 'fr' ? 'Le numéro NIN doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'National ID Number (NIN) must be exactly 18 digits.' : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط دون حروف.');
            } else {
                $rules['passportNumber'] = 'required|regex:/^[0-9]{18}$/';
                $rules['passportFile'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:10240';
                $messages['passportNumber.required'] = $locale === 'fr' ? 'Le numéro de passeport est requis.' : ($locale === 'en' ? 'Passport number is required.' : 'رقم جواز السفر مطلوب.');
                $messages['passportNumber.regex'] = $locale === 'fr' ? 'Le numéro de passeport doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'Passport number must be exactly 18 digits.' : 'يجب أن يتكون رقم جواز السفر من 18 رقماً بالضبط.');
            }

            $this->validate($rules, $messages);

            // 1. Check NIN / Passport Uniqueness
            $checkIdent = $docVerifier->checkIdentityUniqueness(
                $this->isAlgeria ? $this->nationalId : null,
                !$this->isAlgeria ? $this->passportNumber : null
            );
            if (!$checkIdent['is_valid']) {
                foreach ($checkIdent['errors'] as $field => $msg) {
                    if ($field === 'nin') $this->addError('nationalId', $msg);
                    if ($field === 'passport') $this->addError('passportNumber', $msg);
                }
                return;
            }

            // 2. Check Personal Photo Uniqueness (Prevent Photo Duplication)
            $checkPhoto = $docVerifier->checkPhotoUniqueness($this->photoFile);
            if (!$checkPhoto['is_unique']) {
                $this->addError('photoFile', $checkPhoto['message']);
                return;
            }

            // 3. Check Document Verification & Number Matching
            $docFile = $this->isAlgeria ? $this->nationalIdFile : $this->passportFile;
            $docNum  = $this->isAlgeria ? $this->nationalId : $this->passportNumber;
            $docType = $this->isAlgeria ? 'national_id' : 'passport';

            if ($docFile) {
                $docMatch = $docVerifier->verifyDocumentMatch($docFile, $docType, $docNum);
                if (!$docMatch['is_valid']) {
                    $fieldKey = $this->isAlgeria ? 'nationalIdFile' : 'passportFile';
                    $this->addError($fieldKey, $docMatch['message']);
                    return;
                }
            }
        } elseif ($this->step === 3) {
            $this->validate([
                'suitSize' => 'required|in:S,M,L,XL,XXL,3XL',
                'shoeSize' => 'required|numeric|between:35,50',
                'heightCm' => 'required|numeric|between:100,220',
            ]);
        }

        $this->step++;
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function submitRegistration()
    {
        $locale = app()->getLocale();
        $this->validate([
            'skillId' => 'required|exists:skills,id',
        ], [
            'skillId.required' => $locale === 'fr' ? 'Veuillez sélectionner le métier de compétition.' : ($locale === 'en' ? 'Please select competition skill.' : 'يرجى اختيار مهنة التنافس.'),
            'skillId.exists'   => $locale === 'fr' ? 'Le métier sélectionné est invalide.' : ($locale === 'en' ? 'Selected skill is invalid.' : 'المجال المختار غير موجود.'),
        ]);

        if (!$this->validateAge()) {
            $this->addError('dateOfBirth', $locale === 'fr' ? 'Désolé, le candidat ne doit pas dépasser 25 ans exactement.' : ($locale === 'en' ? 'Sorry, candidate age must not exceed 25 years.' : 'عذراً، يجب ألا يتجاوز عمر المترشح 25 سنة بالضبط للمشاركة في أولمبياد المهن (Age <= 25 years).'));
            return;
        }

        /** @var DocumentVerificationService $docVerifier */
        $docVerifier = app(DocumentVerificationService::class);

        $photoHash = $docVerifier->calculateFileHash($this->photoFile);
        $docFile = $this->isAlgeria ? $this->nationalIdFile : $this->passportFile;
        $docHash = $docVerifier->calculateFileHash($docFile);

        // 1. Store Official Candidate Photo
        $photoPath = null;
        if ($this->photoFile) {
            $photoPath = $this->photoFile->store('participants/photos', 'public');
        }

        // 2. Store Identity Documents
        $nationalIdPdfPath = null;
        if ($this->nationalIdFile) {
            $nationalIdPdfPath = $this->nationalIdFile->store('participants/documents', 'public');
        }

        $passportPdfPath = null;
        if ($this->passportFile) {
            $passportPdfPath = $this->passportFile->store('participants/documents', 'public');
        }

        // Create Candidate User Account
        $candidateUser = User::firstOrCreate(
            ['email' => $this->email],
            [
                'name'        => trim(($this->firstNameAr ?: $this->firstNameLatin) . ' ' . ($this->lastNameAr ?: $this->lastNameLatin)),
                'country_id'  => $this->countryId,
                'avatar_path' => $photoPath,
                'password'    => \Illuminate\Support\Facades\Hash::make('password123'),
                'locale'      => app()->getLocale(),
            ]
        );
        if ($photoPath && empty($candidateUser->avatar_path)) {
            $candidateUser->update(['avatar_path' => $photoPath, 'country_id' => $this->countryId]);
        }
        if (!$candidateUser->hasRole(RoleEnum::PARTICIPANT->value)) {
            $candidateUser->assignRole(RoleEnum::PARTICIPANT->value);
        }

        // Create Participant Profile
        $profile = ParticipantProfile::create([
            'user_id'         => $candidateUser->id,
            'first_name_ar'   => $this->firstNameAr,
            'last_name_ar'    => $this->lastNameAr,
            'first_name_fr'   => $this->firstNameLatin,
            'last_name_fr'    => $this->lastNameLatin,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'gender'          => $this->gender,
            'date_of_birth'   => $this->dateOfBirth,
            'country_id'      => $this->countryId,
            'wilaya_id'       => $this->wilayaId,
            'organization_id' => $this->organizationId,
            'skill_id'        => $this->skillId,
            'nin_number'      => $this->isAlgeria ? $this->nationalId : null,
            'passport_number' => !$this->isAlgeria ? $this->passportNumber : null,
            'suit_size'       => $this->suitSize,
            'shoe_size'       => $this->shoeSize,
            'height_cm'       => $this->heightCm,
            'photo_path'      => $photoPath,
            'photo_hash'      => $photoHash,
            'document_hash'   => $docHash,
            'status'          => ParticipantStatus::PENDING->value,
        ]);

        $activeEdition = Edition::where('is_active', true)->first();

        // Create Registration Record
        $reg = RegistrationModel::create([
            'participant_id' => $profile->id,
            'edition_id'     => $activeEdition?->id,
            'country_id'     => $this->countryId,
            'skill_id'       => $this->skillId,
            'suit_size'      => $this->suitSize,
            'shoe_size'      => $this->shoeSize,
            'height_cm'      => $this->heightCm,
            'status'         => ParticipantStatus::PENDING,
            'submitted_at'   => now(),
        ]);

        // Attach Documents
        if ($nationalIdPdfPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'national_id',
                'file_path'       => $nationalIdPdfPath,
                'original_name'   => $this->nationalIdFile ? $this->nationalIdFile->getClientOriginalName() : basename($nationalIdPdfPath),
                'mime_type'       => $this->nationalIdFile ? $this->nationalIdFile->getClientMimeType() : 'application/pdf',
                'file_size'       => $this->nationalIdFile ? $this->nationalIdFile->getSize() : 0,
            ]);
        }

        if ($passportPdfPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'passport',
                'file_path'       => $passportPdfPath,
                'original_name'   => $this->passportFile ? $this->passportFile->getClientOriginalName() : basename($passportPdfPath),
                'mime_type'       => $this->passportFile ? $this->passportFile->getClientMimeType() : 'application/pdf',
                'file_size'       => $this->passportFile ? $this->passportFile->getSize() : 0,
            ]);
        }

        $this->registrationNumber = $reg->registration_number;
        $this->verificationToken = $reg->verification_token ?? bin2hex(random_bytes(16));
        $this->isSubmitted = true;
    }

    public function render()
    {
        $countries = Country::where('is_active', true)->orderBy('name_ar')->get();
        $wilayas = $this->isAlgeria ? Wilaya::orderBy('code')->get() : collect();
        $organizations = Organization::where('is_active', true)
            ->when($this->wilayaId, fn($q) => $q->where('wilaya_id', $this->wilayaId))
            ->orderBy('name_ar')
            ->get();
        $skills = Skill::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.public.registration', [
            'countries'     => $countries,
            'wilayas'       => $wilayas,
            'organizations' => $organizations,
            'skills'        => $skills,
        ]);
    }
}
