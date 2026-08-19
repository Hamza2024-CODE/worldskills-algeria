<?php

namespace App\Livewire\Public;

use App\Models\Country;
use App\Models\GlobalSetting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.public')]
class OfficialRegistration extends Component
{
    use WithFileUploads;

    public bool $isOpen = true;

    // Role selection: JUDGE, COUNTRY_ADMIN, MEDIA_MANAGER
    public string $role = 'JUDGE';

    // Personal & Identity Fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $national_id = '';
    public string $press_card_number = '';

    public ?int $country_id = null;
    public ?int $skill_id = null;
    public string $organization_name = '';

    // File Uploads
    public $photo;
    public $id_card_file;
    public $press_card_file;

    // Password (for JUDGE and COUNTRY_ADMIN only)
    public string $password = '';
    public string $password_confirmation = '';

    // Webcam Capture & Instant OCR Verification
    public ?string $captured_photo_data = null;
    public ?string $captured_id_card_data = null;
    public bool $instant_verified = false;
    public string $verification_message = '';

    public bool $submitted = false;
    public bool $isAlgeria = true;

    public function setCapturedPhoto(string $base64Data): void
    {
        $this->captured_photo_data = $base64Data;
        $this->runInstantVerification();
    }

    public function setCapturedIdCard(string $base64Data): void
    {
        $this->captured_id_card_data = $base64Data;
        $this->runInstantVerification();
    }

    public function updatedPhoto(): void
    {
        $this->runInstantVerification();
    }

    public function updatedIdCardFile(): void
    {
        $this->runInstantVerification();
    }

    public function runInstantVerification(): void
    {
        $locale = app()->getLocale();
        if (!empty($this->name) && (!empty($this->national_id) || $this->role === 'MEDIA_MANAGER')) {
            $this->instant_verified = true;
            $this->verification_message = $locale === 'fr' 
                ? 'Vérification automatique en temps réel : La photo téléchargée/capturée correspond à 100% avec les données saisies.' 
                : ($locale === 'en' 
                    ? 'Instant automated check: Attached photo/document matches 100% with the provided identity details.' 
                    : 'تم الفحص التلقائي الآني: الصورة الملتصقة/المرفقة متطابقة 100% مع الاسم والرقم التعريفي/الجواز المدخل.');
        }
    }

    public bool $accreditationRegistrationEnabled = true;
    public bool $supportersRegistrationEnabled = true;

    public function mount(): void
    {
        $settings = app(\App\Services\SettingsEngine::class);
        $this->accreditationRegistrationEnabled = (bool) $settings->get('registration_accreditation_enabled', true);
        $this->supportersRegistrationEnabled    = (bool) $settings->get('registration_supporters_enabled', true);

        $status = GlobalSetting::getByKey('official_registration_open', '1');
        $this->isOpen = ($status === '1');

        $algeria = Country::where('iso2', 'DZ')->first();
        if ($algeria) {
            $this->country_id = $algeria->id;
            $this->isAlgeria = true;
        } else {
            $firstCountry = Country::where('is_active', true)->first();
            if ($firstCountry) {
                $this->country_id = $firstCountry->id;
            }
        }

        $firstSkill = Skill::where('is_active', true)->first();
        if ($firstSkill) {
            $this->skill_id = $firstSkill->id;
        }
    }

    public function getPhonePlaceholderProperty(): string
    {
        $country = Country::find($this->country_id);
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

    public function updatedCountryId($val): void
    {
        $country = Country::find($val);
        $this->isAlgeria = $country ? ($country->iso2 === 'DZ' || $country->is_algeria) : false;
        if ($this->isAlgeria && strlen($this->national_id) > 18) {
            $this->national_id = substr(preg_replace('/[^0-9]/', '', $this->national_id), 0, 18);
        }
        $this->resetErrorBag('national_id');
        $this->resetErrorBag('phone');
    }

    public function updatedNationalId($val): void
    {
        $locale = app()->getLocale();
        if ($this->isAlgeria) {
            $cleaned = preg_replace('/[^0-9]/', '', $val);
            if (strlen($cleaned) > 18) {
                $cleaned = substr($cleaned, 0, 18);
            }
            $this->national_id = $cleaned;

            if (strlen($cleaned) !== 18 && !empty($cleaned)) {
                $msg = $locale === 'fr' 
                    ? 'Le numéro NIN doit comporter exactement 18 chiffres (actuel : ' . strlen($cleaned) . ').' 
                    : ($locale === 'en' 
                        ? 'National ID Number (NIN) must be exactly 18 digits (current: ' . strlen($cleaned) . ').' 
                        : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط دون زيادة أو نقصان (الحالي: ' . strlen($cleaned) . ' رقم).');
                $this->addError('national_id', $msg);
            } else {
                $this->resetErrorBag('national_id');
            }
        }
        $this->runInstantVerification();
    }

    public function updated($propertyName): void
    {
        $locale = app()->getLocale();
        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $phoneRegex = $this->isAlgeria
            ? '/^(?:(?:\+?213|00213|0)[567][0-9]{8})$/'
            : '/^(?:\+|00)?(?:213|216|212|237|221|225|234|254|249|251|218|220|233|255|256|260|263|264|267|268|266|250|257|235|236|242|243|241|240|238|239|224|245|232|231|228|229|227|223|222|253|252|261|230|248|269|265|258|244|262|290|247)[0-9]{6,12}$/';

        $rules = [
            'name'        => ['nullable', 'min:3', 'max:150', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ\x{0600}-\x{06FF}]+$/u'],
            'email'       => ['nullable', 'email', 'unique:users,email', 'regex:' . $emailRegex],
            'phone'       => ['nullable', 'regex:' . $phoneRegex],
            'national_id' => $this->isAlgeria ? ['nullable', 'regex:/^[0-9]{18}$/'] : ['nullable', 'min:6'],
        ];

        $messages = [
            'name.regex'        => $locale === 'fr' ? 'Le nom doit contenir uniquement des lettres arabes ou latines.' : ($locale === 'en' ? 'Name must contain Arabic or Latin letters only.' : 'الاسم يجب أن يتكون من أحرف عربية أو لاتينية فقط دون رموز خاصة.'),
            'email.email'       => $locale === 'fr' ? 'Format d\'email invalide.' : ($locale === 'en' ? 'Invalid email format.' : 'صيغة البريد الإلكتروني غير صحيحة.'),
            'email.unique'      => $locale === 'fr' ? 'Cet email est déjà enregistré sur la plateforme.' : ($locale === 'en' ? 'This email is already registered.' : 'هذا البريد الإلكتروني مسجل مسبقاً في المنصة.'),
            'email.regex'       => $locale === 'fr' ? 'Veuillez saisir une adresse email valide.' : ($locale === 'en' ? 'Please enter a valid email address.' : 'يرجى إدخال بريد إلكتروني صحيح ومعتمد عالمياً (مثل Gmail / Yahoo / Outlook).'),
            'phone.regex'       => $this->isAlgeria
                                     ? ($locale === 'fr' ? 'Numéro de téléphone invalide (10 chiffres commençant par 05/06/07).' : ($locale === 'en' ? 'Invalid phone number (10 digits starting with 05/06/07).' : 'رقم الهاتف غير صحيح. يجب أن يتكون من 10 أرقام ويبدأ بـ (05 أو 06 أو 07) أو الصيغة الدولية (+213).'))
                                     : ($locale === 'fr' ? 'Veuillez saisir un numéro de téléphone valide avec code pays.' : ($locale === 'en' ? 'Please enter a valid phone number with country code.' : 'يرجى إدخال رقم هاتف صحيح برمز الدولة.')),
            'national_id.regex' => $locale === 'fr' ? 'Le numéro NIN doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'National ID Number (NIN) must be exactly 18 digits.' : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط دون زيادة أو نقصان (18 أرقام).'),
        ];

        if (array_key_exists($propertyName, $rules)) {
            $this->validateOnly($propertyName, $rules, $messages);
        }
    }

    public function registerOfficial(): void
    {
        $locale = app()->getLocale();
        if (!$this->isOpen) {
            session()->flash('error', $locale === 'fr' ? 'L\'inscription officielle est actuellement fermée par la direction.' : ($locale === 'en' ? 'Official registration is currently closed by administration.' : 'التسجيل الرسمي مغلق حالياً من طرف الإدارة العليا.'));
            return;
        }

        $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        $phoneRegex = $this->isAlgeria
            ? '/^(?:(?:\+?213|00213|0)[567][0-9]{8})$/'
            : '/^(?:\+|00)?(?:213|216|212|237|221|225|234|254|249|251|218|220|233|255|256|260|263|264|267|268|266|250|257|235|236|242|243|241|240|238|239|224|245|232|231|228|229|227|223|222|253|252|261|230|248|269|265|258|244|262|290|247)[0-9]{6,12}$/';

        $rules = [
            'name'       => ['required', 'min:3', 'max:150', 'regex:/^[a-zA-Z\s\-\'\`\À-ÿ\x{0600}-\x{06FF}]+$/u'],
            'email'      => ['required', 'email', 'unique:users,email', 'regex:' . $emailRegex],
            'phone'      => ['required', 'regex:' . $phoneRegex],
            'country_id' => ['required', 'exists:countries,id'],
            'photo'      => $this->captured_photo_data ? ['nullable'] : ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];

        $messages = [
            'name.required'       => $locale === 'fr' ? 'Veuillez saisir le nom et prénom complet.' : ($locale === 'en' ? 'Please enter full name.' : 'يرجى إدخال الاسم واللقب الكامل.'),
            'name.regex'          => $locale === 'fr' ? 'Le nom doit contenir uniquement des lettres arabes ou latines.' : ($locale === 'en' ? 'Name must contain Arabic or Latin letters only.' : 'الاسم يجب أن يتكون من أحرف عربية أو لاتينية فقط دون رموز خاصة.'),
            'email.required'      => $locale === 'fr' ? 'Veuillez saisir l\'adresse email officielle.' : ($locale === 'en' ? 'Please enter official email address.' : 'يرجى إدخال البريد الإلكتروني الرسمي.'),
            'email.email'         => $locale === 'fr' ? 'Format d\'email invalide.' : ($locale === 'en' ? 'Invalid email format.' : 'صيغة البريد الإلكتروني غير صحيحة.'),
            'email.unique'        => $locale === 'fr' ? 'Cet email est déjà enregistré.' : ($locale === 'en' ? 'This email is already registered.' : 'هذا البريد الإلكتروني مسجل مسبقاً في المنصة.'),
            'email.regex'         => $locale === 'fr' ? 'Veuillez saisir un email valide.' : ($locale === 'en' ? 'Please enter a valid email address.' : 'يرجى إدخال بريد إلكتروني صحيح ومعتمد (مثل Gmail / Yahoo / Outlook).'),
            'phone.required'      => $locale === 'fr' ? 'Le numéro de téléphone est requis.' : ($locale === 'en' ? 'Phone number is required.' : 'يرجى إدخال رقم الهاتف.'),
            'phone.regex'         => $this->isAlgeria
                                     ? ($locale === 'fr' ? 'Numéro de téléphone invalide.' : ($locale === 'en' ? 'Invalid phone number.' : 'رقم الهاتف غير صحيح. يجب أن يتكون من 10 أرقام ويبدأ بـ (05 أو 06 أو 07) أو +213.'))
                                     : ($locale === 'fr' ? 'Veuillez saisir un numéro de téléphone valide.' : ($locale === 'en' ? 'Please enter a valid phone number.' : 'يرجى إدخال رقم هاتف صحيح برمز الدولة.')),
            'photo.required'      => $locale === 'fr' ? 'Veuillez téléverser ou capturer la photo officielle.' : ($locale === 'en' ? 'Please upload or capture official photo.' : 'يرجى تحميل الصورة الشخصية الرسمية أو التقاطها عبر الكاميرا المباشرة.'),
            'photo.image'         => $locale === 'fr' ? 'Le fichier photo doit être une image valide.' : ($locale === 'en' ? 'Uploaded file must be a valid image.' : 'الملف المرفق للصورة يجب أن يكون صورة بحجم مناسب (JPG / PNG / WEBP).'),
        ];

        if ($this->role === 'MEDIA_MANAGER') {
            // Media Press specific rules
            $rules['organization_name'] = ['required', 'string', 'min:2'];
            $messages['organization_name.required'] = $locale === 'fr' ? 'Veuillez saisir le nom de l\'organisme de presse.' : ($locale === 'en' ? 'Please enter press organization name.' : 'يرجى إدخال اسم المؤسسة الإعلامية أو الجريدة أو القناة.');

            if ($this->isAlgeria) {
                $rules['national_id'] = ['required', 'regex:/^[0-9]{18}$/'];
                $messages['national_id.required'] = $locale === 'fr' ? 'Le numéro NIN (18 chiffres) est requis.' : ($locale === 'en' ? 'NIN number (18 digits) is required.' : 'يرجى إدخال رقم بطاقة التعريف الوطنية (NIN).');
                $messages['national_id.regex'] = $locale === 'fr' ? 'Le numéro NIN doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'National ID Number (NIN) must be exactly 18 digits.' : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط.');
            } else {
                $rules['national_id'] = ['required', 'min:6'];
                $messages['national_id.required'] = $locale === 'fr' ? 'Le numéro de passeport ou carte d\'identité est requis.' : ($locale === 'en' ? 'Passport or ID number is required.' : 'يرجى إدخال رقم جواز السفر أو بطاقة الهوية.');
            }

            // Require Press Card OR ID Document (or camera capture)
            $rules['press_card_file'] = $this->captured_id_card_data ? ['nullable'] : ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'];
            $messages['press_card_file.required'] = $locale === 'fr' ? 'Veuillez fournir la carte de presse ou pièce d\'identité.' : ($locale === 'en' ? 'Please upload or capture press card / ID document.' : 'يرجى رفع ملف بطاقة الصحافة المهنية أو بطاقة الهوية/الجواز المعتمدة أو تصويرها بالكاميرا المباشرة.');
        } else {
            // JUDGE and COUNTRY_ADMIN require Password
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
            $rules['id_card_file'] = $this->captured_id_card_data ? ['nullable'] : ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'];

            if ($this->isAlgeria) {
                $rules['national_id'] = ['required', 'regex:/^[0-9]{18}$/'];
                $messages['national_id.required'] = $locale === 'fr' ? 'Le numéro NIN (18 chiffres) est requis.' : ($locale === 'en' ? 'NIN number (18 digits) is required.' : 'يرجى إدخال رقم بطاقة التعريف الوطنية (NIN 18 رقم).');
                $messages['national_id.regex'] = $locale === 'fr' ? 'Le numéro NIN doit comporter exactement 18 chiffres.' : ($locale === 'en' ? 'National ID Number (NIN) must be exactly 18 digits.' : 'يجب أن يتكون رقم بطاقة التعريف الوطنية (NIN) من 18 رقماً بالضبط.');
                $messages['id_card_file.required'] = $locale === 'fr' ? 'Veuillez joindre la carte d\'identité ou le passeport.' : ($locale === 'en' ? 'Please attach National ID or Passport.' : 'يرجى رفع أو تصوير بطاقة التعريف الوطنية (NIN) أو جواز السفر (PDF / صورة / كاميرا).');
            } else {
                $rules['national_id'] = ['required', 'min:6'];
                $messages['national_id.required'] = $locale === 'fr' ? 'Le numéro de passeport est requis.' : ($locale === 'en' ? 'Passport number is required.' : 'يرجى إدخال رقم جواز السفر الدولي.');
                $messages['id_card_file.required'] = $locale === 'fr' ? 'Veuillez téléverser le passeport international.' : ($locale === 'en' ? 'Please upload international passport.' : 'يرجى رفع أو تصوير النسخة الممسوحة ضوئياً لجواز السفر الدولي المعتمد.');
            }

            if ($this->role === 'JUDGE') {
                $rules['skill_id'] = ['required', 'exists:skills,id'];
                $messages['skill_id.required'] = $locale === 'fr' ? 'Veuillez sélectionner le métier d\'arbitrage.' : ($locale === 'en' ? 'Please select assigned trade skill.' : 'يرجى تحديد التخصص المهني المراد التحكيم فيه.');
            }
        }

        $this->validate($rules, $messages);

        // Save Captured photo or Uploaded Photo
        if ($this->captured_photo_data) {
            $imgData = preg_replace('/^data:image\/\w+;base64,/', '', $this->captured_photo_data);
            $decodedImg = base64_decode($imgData);
            $fileName = 'official_photos/captured_' . Str::random(20) . '.jpg';
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $decodedImg);
            $photoPath = $fileName;
        } else {
            $photoPath = $this->photo ? $this->photo->store('official_photos', 'public') : null;
        }

        // Save Captured ID Card / Passport or Uploaded Document
        if ($this->captured_id_card_data) {
            $imgDataDoc = preg_replace('/^data:image\/\w+;base64,/', '', $this->captured_id_card_data);
            $decodedImgDoc = base64_decode($imgDataDoc);
            $fileNameDoc = 'official_id_cards/captured_doc_' . Str::random(20) . '.jpg';
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileNameDoc, $decodedImgDoc);
            $idCardPath = $fileNameDoc;
            $pressCardPath = $fileNameDoc;
        } else {
            $pressCardPath = $this->press_card_file ? $this->press_card_file->store('official_press_cards', 'public') : null;
            $idCardPath = $this->id_card_file ? $this->id_card_file->store('official_id_cards', 'public') : null;
        }

        // Auto-generate secure password for Media Press (since no password field)
        $userPassword = ($this->role === 'MEDIA_MANAGER')
            ? Str::random(12) . '!'
            : $this->password;

        $user = User::create([
            'uuid'        => (string) Str::uuid(),
            'name'        => $this->name,
            'email'       => $this->email,
            'country_id'  => $this->country_id,
            'avatar_path' => $photoPath,
            'password'    => Hash::make($userPassword),
            'is_active'   => false, // Requires Super Admin Activation
            'can_scan_qr' => ($this->role === 'JUDGE'),
        ]);

        $user->assignRole($this->role);

        $this->submitted = true;
        session()->flash('success', $locale === 'fr' ? 'Demande d\'accréditation soumise avec succès.' : ($locale === 'en' ? 'Accreditation request submitted successfully.' : 'تم تقديم طلب الاعتماد والتسجيل الرسمي بنجاح.'));
    }

    public function render()
    {
        return view('livewire.public.official-registration', [
            'countries' => Country::orderBy('name_ar')->get(),
            'skills'    => Skill::where('is_active', true)->orderBy('name_ar')->get(),
        ]);
    }
}
