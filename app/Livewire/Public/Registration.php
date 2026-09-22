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
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Registration extends Component
{
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
    public string $phonePlaceholder = '0550123456';

    // Step 2: Official Photo & Identity Documents (Base64 Direct Storage)
    public ?string $photoData = null;
    public ?string $photoFileName = null;

    public string $identificationType = 'national_id';
    public string $nationalId = '';
    public string $passportNumber = '';
    public ?string $documentData = null;
    public ?string $documentFileName = null;
    public ?string $documentFileType = null;

    public function setPhotoData(string $base64Data, ?string $fileName = null): void
    {
        if (!preg_match('/^data:image\/(jpeg|png|webp|jpg);base64,/', $base64Data)) {
            $locale = app()->getLocale();
            $this->addError('photoFile', $locale === 'fr' 
                ? 'La photo personnelle doit être une image valide (PNG/JPG/WEBP).' 
                : ($locale === 'en' 
                    ? 'Personal photo must be a valid image file.' 
                    : 'حقل الصورة الشخصية يقبل الصور فقط (PNG, JPG, WEBP). لا يمكنك رفع ملف PDF هنا.'));
            return;
        }

        $this->photoData = $base64Data;
        $this->photoFileName = $fileName ?: 'candidate_photo_' . time() . '.jpg';
        $this->resetErrorBag('photoFile');
    }

    public function setDocumentData(string $base64Data, ?string $fileName = null): void
    {
        if (!preg_match('/^data:(image\/(jpeg|png|webp|jpg)|application\/pdf);base64,/', $base64Data)) {
            $locale = app()->getLocale();
            $msg = $locale === 'fr' 
                ? 'Le document doit être un fichier PDF ou une image (PNG/JPG).' 
                : ($locale === 'en' 
                    ? 'Document must be a PDF or image file.' 
                    : 'وثيقة الهوية تقبل ملفات PDF أو صور (PNG, JPG, WEBP).');
            $this->addError('nationalIdFile', $msg);
            $this->addError('passportFile', $msg);
            return;
        }

        $this->documentData = $base64Data;
        $this->documentFileName = $fileName ?: 'identity_document_' . time() . ($this->isAlgeria ? '.pdf' : '.jpg');
        $this->documentFileType = str_contains($base64Data, 'application/pdf') ? 'pdf' : 'image';
        $this->resetErrorBag('nationalIdFile');
        $this->resetErrorBag('passportFile');
    }

    public function clearPhotoData(): void
    {
        $this->photoData = null;
        $this->photoFileName = null;
        $this->resetErrorBag('photoFile');
    }

    public function clearDocumentData(): void
    {
        $this->documentData = null;
        $this->documentFileName = null;
        $this->documentFileType = null;
        $this->resetErrorBag('nationalIdFile');
        $this->resetErrorBag('passportFile');
    }

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
        $dz = Country::where('iso2', 'DZ')->orWhere('iso3', 'DZA')->first();
        if ($dz) {
            $this->countryId = $dz->id;
            $this->isAlgeria = true;
            $this->isArabicCountry = true;
        }
        $this->phonePlaceholder = $this->isAlgeria ? '0550123456' : '+213550123456';

        $activeEdition = Edition::where('is_active', true)->first();
        if ($activeEdition && $activeEdition->registration_start_date && $activeEdition->registration_end_date) {
            $now = Carbon::now();
            $start = Carbon::parse($activeEdition->registration_start_date)->startOfDay();
            $end = Carbon::parse($activeEdition->registration_end_date)->endOfDay();
            $this->registrationEnabled = $now->between($start, $end);
        }
    }

    public function updatedCountryId($value): void
    {
        $country = Country::find($value);
        if ($country) {
            $this->isAlgeria = ($country->iso2 === 'DZ' || $country->iso3 === 'DZA');
            $arabicCodes = ['DZ', 'TN', 'MA', 'EG', 'SA', 'AE', 'QA', 'KW', 'OM', 'BH', 'JO', 'LB', 'IQ', 'SY', 'LY', 'SD', 'YE', 'MR', 'SO', 'DJ', 'KM', 'PS'];
            $this->isArabicCountry = in_array(strtoupper($country->iso2 ?? $country->iso3 ?? ''), $arabicCodes);

            $this->phonePlaceholder = $this->isAlgeria ? '0550123456' : '+213550123456';
            if (!$this->isAlgeria) {
                $this->wilayaId = null;
                $this->organizationId = null;
                $this->identificationType = 'passport';
            } else {
                $this->identificationType = 'national_id';
            }
        }
    }

    public function updatedWilayaId($value): void
    {
        $this->organizationId = null;
    }

    public function updatedSkillId($value): void
    {
        if ($value) {
            $this->selectedSkill = Skill::find($value);
            $this->skillEquipments = SkillEquipment::where('skill_id', $value)->get();
        } else {
            $this->selectedSkill = null;
            $this->skillEquipments = [];
        }
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
                'gender'         => ['required', 'in:male,female'],
            ];

            if ($this->isArabicCountry) {
                $rules['firstNameAr'] = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
                $rules['lastNameAr']  = ['required', 'min:2', 'regex:/^[\x{0600}-\x{06FF}\s\-]+$/u'];
            } else {
                $rules['firstNameAr'] = ['nullable', 'regex:/^[\x{0600}-\x{06FF}\s\-]*$/u'];
                $rules['lastNameAr']  = ['nullable', 'regex:/^[\x{0600}-\x{06FF}\s\-]*$/u'];
            }

            $messages = [
                'countryId.required'      => app()->getLocale() === 'fr' ? 'Veuillez sélectionner le pays.' : (app()->getLocale() === 'en' ? 'Please select country.' : 'يرجى اختيار البلد.'),
                'firstNameLatin.required' => app()->getLocale() === 'fr' ? 'Le prénom (Latin) est obligatoire.' : (app()->getLocale() === 'en' ? 'First name (Latin) is required.' : 'الاسم الأول (بالأحرف اللاتينية) مطلوب.'),
                'firstNameLatin.regex'    => app()->getLocale() === 'fr' ? 'Le prénom latin ne doit contenir que des lettres latines.' : (app()->getLocale() === 'en' ? 'Latin first name must contain only Latin characters.' : 'الاسم الأول باللاتينية يجب أن يحتوي على أحرف لاتينية فقط.'),
                'lastNameLatin.required'  => app()->getLocale() === 'fr' ? 'Le nom (Latin) est obligatoire.' : (app()->getLocale() === 'en' ? 'Last name (Latin) is required.' : 'اللقب (بالأحرف اللاتينية) مطلوب.'),
                'lastNameLatin.regex'     => app()->getLocale() === 'fr' ? 'Le nom latin ne doit contenir que des lettres latines.' : (app()->getLocale() === 'en' ? 'Latin last name must contain only Latin characters.' : 'اللقب باللاتينية يجب أن يحتوي على أحرف لاتينية فقط.'),
                'firstNameAr.required'    => app()->getLocale() === 'fr' ? 'Le prénom en arabe est requis.' : (app()->getLocale() === 'en' ? 'First name in Arabic is required.' : 'الاسم الأول باللغة العربية مطلوب للمترشحين من الدول العربية.'),
                'firstNameAr.regex'       => app()->getLocale() === 'fr' ? 'Le prénom arabe doit contenir des lettres arabes uniquement.' : (app()->getLocale() === 'en' ? 'Arabic first name must contain Arabic characters.' : 'الاسم بالعربية يجب أن يحتوي على أحرف عربية فقط دون أرقام.'),
                'lastNameAr.required'     => app()->getLocale() === 'fr' ? 'Le nom en arabe est requis.' : (app()->getLocale() === 'en' ? 'Last name in Arabic is required.' : 'اللقب باللغة العربية مطلوب للمترشحين من الدول العربية.'),
                'lastNameAr.regex'        => app()->getLocale() === 'fr' ? 'Le nom arabe doit contenir des lettres arabes uniquement.' : (app()->getLocale() === 'en' ? 'Arabic last name must contain Arabic characters.' : 'اللقب بالعربية يجب أن يحتوي على أحرف عربية فقط دون أرقام.'),
                'email.required'          => app()->getLocale() === 'fr' ? 'L\'adresse email est requise.' : (app()->getLocale() === 'en' ? 'Email is required.' : 'البريد الإلكتروني مطلوب.'),
                'email.email'             => app()->getLocale() === 'fr' ? 'Veuillez saisir une adresse email valide.' : (app()->getLocale() === 'en' ? 'Please enter a valid email.' : 'يرجى كتابة بريد إلكتروني صحيح.'),
                'email.regex'             => app()->getLocale() === 'fr' ? 'Format email invalide.' : (app()->getLocale() === 'en' ? 'Invalid email format.' : 'صيغة البريد الإلكتروني غير صحيحة.'),
                'phone.required'          => app()->getLocale() === 'fr' ? 'Le numéro de téléphone est requis.' : (app()->getLocale() === 'en' ? 'Phone number is required.' : 'رقم الهاتف مطلوب.'),
                'phone.regex'             => app()->getLocale() === 'fr' ? 'Format de téléphone invalide.' : (app()->getLocale() === 'en' ? 'Invalid phone format.' : 'رقم الهاتف غير صحيح (يرجى إدخال 10 أرقام تبدأ بـ 05 أو 06 أو 07 في الجزائر).'),
                'dateOfBirth.required'    => app()->getLocale() === 'fr' ? 'La date de naissance est requise.' : (app()->getLocale() === 'en' ? 'Date of birth is required.' : 'تاريخ الميلاد مطلوب.'),
            ];

            $this->validate($rules, $messages);

            if (!$this->validateAge()) {
                $this->addError('dateOfBirth', app()->getLocale() === 'fr' ? 'Désolé, le candidat ne doit pas dépasser 25 ans exactement (Age <= 25 ans).' : (app()->getLocale() === 'en' ? 'Sorry, candidate age must not exceed 25 years.' : 'عذراً، يجب ألا يتجاوز عمر المترشح 25 سنة بالضبط للمشاركة في أولمبياد المهن (Age <= 25 years).'));
                return;
            }

            // Check Email & Phone Uniqueness
            $checkUser = $docVerifier->checkIdentityUniqueness(email: $this->email, phone: $this->phone);
            if (!$checkUser['is_valid']) {
                foreach ($checkUser['errors'] as $field => $msg) {
                    $this->addError($field, $msg);
                }
                return;
            }

        } elseif ($this->step === 2) {
            $locale = app()->getLocale();

            if (empty($this->photoData)) {
                $this->addError('photoFile', $locale === 'fr' 
                    ? 'Veuillez charger la photo officielle du candidat (visage).' 
                    : ($locale === 'en' 
                        ? 'Please upload the candidate\'s official photo (face).' 
                        : 'يرجى تحميل الصورة الشخصية الرسمية للمترشح (صورة الوجه).'));
                return;
            }

            if ($this->isAlgeria) {
                $rules = ['nationalId' => 'required|regex:/^[0-9]{18}$/'];
                $messages = [
                    'nationalId.required' => $locale === 'fr' ? 'Le numéro NIN (18 chiffres) est requis.' : ($locale === 'en' ? 'NIN number (18 digits) is required.' : 'رقم التعريف الوطني (18 رقماً) مطلوب.'),
                    'nationalId.regex'    => $locale === 'fr' ? 'Le numéro NIN doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'National ID Number (NIN) must be exactly 18 digits.' : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط دون حروف.'),
                ];
            } else {
                $rules = ['passportNumber' => 'required|regex:/^[0-9]{18}$/'];
                $messages = [
                    'passportNumber.required' => $locale === 'fr' ? 'Le numéro de passeport est requis.' : ($locale === 'en' ? 'Passport number is required.' : 'رقم جواز السفر مطلوب.'),
                    'passportNumber.regex'    => $locale === 'fr' ? 'Le numéro de passeport doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'Passport number must be exactly 18 digits.' : 'يجب أن يتكون رقم جواز السفر من 18 رقماً بالضبط.'),
                ];
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

            // 1.5. Prevent Uploading Same File for Photo and Document
            if (!empty($this->photoData) && !empty($this->documentData)) {
                if ($this->photoData === $this->documentData) {
                    $this->addError('photoFile', $locale === 'fr' 
                        ? "La photo personnelle (visage) et le document d'identité (CNI/Passeport) ne peuvent pas être le même fichier." 
                        : ($locale === 'en' 
                            ? 'Personal photo (face) and ID document (National ID/Passport) cannot be the same file.' 
                            : 'عذراً، يجب إرفاق الصورة الشخصية للمترشح (صورة الوجه) في حقل الصورة الأول، وإرفاق وثيقة الهوية (بطاقة التعريف / جواز السفر) في الحقل الثاني. لا يمكن إرفاق نفس الملف في الحقلين.'));
                    return;
                }
            }

            // Store temp files for uniqueness and document matching checks
            $tempPhotoPath = $this->storeBase64File($this->photoData, 'temp_photos', 'photo_val');
            $tempDocPath   = $this->storeBase64File($this->documentData, 'temp_docs', 'doc_val');

            // 2. Check Personal Photo Uniqueness
            if ($tempPhotoPath) {
                $checkPhoto = $docVerifier->checkPhotoUniqueness($tempPhotoPath);
                if (!$checkPhoto['is_unique']) {
                    $this->addError('photoFile', $checkPhoto['message']);
                    if ($tempPhotoPath) Storage::disk('public')->delete($tempPhotoPath);
                    if ($tempDocPath) Storage::disk('public')->delete($tempDocPath);
                    return;
                }
            }

            // 3. Check Document Verification & Number Matching
            $docNum  = $this->isAlgeria ? $this->nationalId : $this->passportNumber;
            $docType = $this->isAlgeria ? 'national_id' : 'passport';

            if ($tempDocPath) {
                $docMatch = $docVerifier->verifyDocumentMatch($tempDocPath, $docType, $docNum);
                if (!$docMatch['is_valid']) {
                    $fieldKey = $this->isAlgeria ? 'nationalIdFile' : 'passportFile';
                    $this->addError($fieldKey, $docMatch['message']);
                    if ($tempPhotoPath) Storage::disk('public')->delete($tempPhotoPath);
                    if ($tempDocPath) Storage::disk('public')->delete($tempDocPath);
                    return;
                }
            }

            // Cleanup temp files after validation
            if ($tempPhotoPath) Storage::disk('public')->delete($tempPhotoPath);
            if ($tempDocPath) Storage::disk('public')->delete($tempDocPath);

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

        // 1. Store Official Candidate Photo
        $photoPath = $this->storeBase64File($this->photoData, 'participants/photos', 'candidate_photo');
        $photoHash = $photoPath ? $docVerifier->calculateFileHash($photoPath) : null;

        // 2. Store Identity Document
        $docPath = $this->storeBase64File($this->documentData, 'participants/documents', $this->isAlgeria ? 'cni' : 'passport');
        $docHash = $docPath ? $docVerifier->calculateFileHash($docPath) : null;

        $nationalIdPdfPath = $this->isAlgeria ? $docPath : null;
        $passportPdfPath   = !$this->isAlgeria ? $docPath : null;

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
        if ($photoPath) {
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
            'wilaya_id'       => $this->wilayaId,
            'organization_id' => $this->organizationId,
            'national_id'     => $this->isAlgeria ? $this->nationalId : null,
            'passport_number' => !$this->isAlgeria ? $this->passportNumber : null,
            'photo_hash'      => $photoHash,
            'document_hash'   => $docHash,
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
        if ($photoPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'official_photo',
                'file_path'       => $photoPath,
                'original_name'   => $this->photoFileName ?: basename($photoPath),
                'mime_type'       => 'image/jpeg',
                'file_size'       => Storage::disk('public')->exists($photoPath) ? Storage::disk('public')->size($photoPath) : 0,
            ]);
        }

        if ($nationalIdPdfPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'national_id',
                'file_path'       => $nationalIdPdfPath,
                'original_name'   => $this->documentFileName ?: basename($nationalIdPdfPath),
                'mime_type'       => ($this->documentFileType === 'pdf') ? 'application/pdf' : 'image/jpeg',
                'file_size'       => Storage::disk('public')->exists($nationalIdPdfPath) ? Storage::disk('public')->size($nationalIdPdfPath) : 0,
            ]);
        }

        if ($passportPdfPath) {
            ParticipantDocument::create([
                'registration_id' => $reg->id,
                'document_type'   => 'passport',
                'file_path'       => $passportPdfPath,
                'original_name'   => $this->documentFileName ?: basename($passportPdfPath),
                'mime_type'       => ($this->documentFileType === 'pdf') ? 'application/pdf' : 'image/jpeg',
                'file_size'       => Storage::disk('public')->exists($passportPdfPath) ? Storage::disk('public')->size($passportPdfPath) : 0,
            ]);
        }

        $this->registrationNumber = $reg->registration_number;
        $this->verificationToken = $reg->verification_token ?? bin2hex(random_bytes(16));
        $this->isSubmitted = true;
    }

    protected function storeBase64File(?string $base64Data, string $folder, string $prefix = 'file'): ?string
    {
        if (empty($base64Data)) {
            return null;
        }

        if (!preg_match('/^data:(.*?);base64,(.*)$/', $base64Data, $matches)) {
            return null;
        }

        $mimeType = $matches[1];
        $base64Str = $matches[2];
        $binary = base64_decode($base64Str);

        if ($binary === false) {
            return null;
        }

        $extension = match ($mimeType) {
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'application/pdf' => 'pdf',
            default => 'bin',
        };

        $fileName = $folder . '/' . $prefix . '_' . uniqid() . '_' . time() . '.' . $extension;
        Storage::disk('public')->put($fileName, $binary);

        $pubPath = public_path('storage/' . $fileName);
        @mkdir(dirname($pubPath), 0755, true);
        @file_put_contents($pubPath, $binary);

        return $fileName;
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
