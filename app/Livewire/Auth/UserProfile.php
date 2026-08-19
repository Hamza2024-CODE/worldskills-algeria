<?php

namespace App\Livewire\Auth;

use App\Models\DelegationMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class UserProfile extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $passport_number = '';
    public string $nin_number = '';
    public string $locale = 'ar';
    public $photo; // Uploaded temporary photo

    public string $suit_size = 'M';
    public string $shoe_size = '42';
    public string $height_cm = '175';

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';
    public string $successMessage = '';

    public function mount()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user) {
            $user->load(['country', 'wilaya', 'organization', 'roles', 'participant']);
            $this->name   = $user->name;
            $this->email  = $user->email;
            $this->locale = $user->locale ?? 'ar';

            $member = DelegationMember::where('user_id', $user->id)->first();
            $latestReg = $user->participant?->registrations()?->latest()->first();

            $this->suit_size = $latestReg?->suit_size ?? ($member?->suit_size ?? 'M');
            $this->shoe_size = $latestReg?->shoe_size ?? ($member?->shoe_size ?? '42');
            $this->height_cm = (string) ($latestReg?->height_cm ?? 175);

            if ($member) {
                $this->phone           = $member->phone ?? $user->participant?->phone ?? '';
                $this->passport_number = $member->passport_number ?? $user->participant?->passport_number ?? '';
                $this->nin_number      = $member->nin_number ?? $user->participant?->nin_number ?? '';
            } else if ($user->participant) {
                $this->phone           = $user->participant->phone ?? '';
                $this->passport_number = $user->participant->passport_number ?? '';
                $this->nin_number      = $user->participant->nin_number ?? '';
            }
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'nullable|string|max:50',
            'passport_number' => 'nullable|string|max:50',
            'nin_number'      => 'nullable|string|max:50',
            'suit_size'       => 'nullable|string|max:20',
            'shoe_size'       => 'nullable|string|max:20',
            'height_cm'       => 'nullable|numeric',
            'photo'           => 'nullable|image|max:5120',
            'locale'          => 'required|in:ar,fr,en',
        ]);

        /** @var User|null $user */
        $user = Auth::user();
        if ($user) {
            $data = [
                'name'   => $this->name,
                'email'  => $this->email,
                'locale' => $this->locale,
            ];

            if ($this->photo) {
                $path = $this->photo->store('avatars', 'public');
                $data['avatar_path'] = $path;

                if ($user->participant) {
                    if (\Illuminate\Support\Facades\Schema::hasColumn('participant_profiles', 'photo_path')) {
                        $user->participant->update(['photo_path' => $path]);
                    }

                    $latestReg = $user->participant->registrations()->latest()->first();
                    if ($latestReg) {
                        $existingPhotoDoc = $latestReg->documents()->whereIn('document_type', ['PHOTO', 'photo', 'official_photo'])->first();
                        if ($existingPhotoDoc) {
                            $existingPhotoDoc->update(['file_path' => $path]);
                        } else {
                            \App\Models\ParticipantDocument::create([
                                'registration_id' => $latestReg->id,
                                'document_type'   => 'PHOTO',
                                'file_path'       => $path,
                                'original_name'   => 'avatar.jpg',
                                'mime_type'       => 'image/jpeg',
                                'file_size'       => 0,
                            ]);
                        }
                    }
                }

                DelegationMember::where('user_id', $user->id)->update(['photo_path' => $path]);
            }

            $user->update($data);

            if ($user->participant) {
                $user->participant->update([
                    'phone'           => $this->phone,
                    'passport_number' => $this->passport_number,
                    'nin_number'      => $this->nin_number,
                ]);

                $latestReg = $user->participant->registrations()->latest()->first();
                if ($latestReg) {
                    $latestReg->update([
                        'suit_size' => $this->suit_size,
                        'shoe_size' => $this->shoe_size,
                        'height_cm' => (int) $this->height_cm,
                    ]);
                }
            }

            DelegationMember::where('user_id', $user->id)->update([
                'phone'           => $this->phone,
                'passport_number' => $this->passport_number,
                'nin_number'      => $this->nin_number,
                'suit_size'       => $this->suit_size,
                'shoe_size'       => $this->shoe_size,
            ]);

            session(['locale' => $this->locale]);
            app()->setLocale($this->locale);
            $this->reset('photo');
            $this->successMessage = app()->getLocale() === 'fr' 
                ? 'Profil et informations mis à jour avec succès.' 
                : (app()->getLocale() === 'en' ? 'Profile & account details updated successfully.' : 'تم تحديث البيانات الشخصية والصورة بنجاح.');
        }
    }

    public function removePhoto()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user) {
            $user->update(['avatar_path' => null]);
            $this->reset('photo');
            $this->successMessage = app()->getLocale() === 'fr' ? 'Photo supprimée.' : (app()->getLocale() === 'en' ? 'Photo removed.' : 'تم حذف الصورة الشخصية بنجاح.');
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        /** @var User|null $user */
        $user = Auth::user();
        if ($user && Hash::check($this->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($this->new_password),
            ]);
            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            $this->successMessage = app()->getLocale() === 'fr' 
                ? 'Mot de passe modifié avec succès.' 
                : (app()->getLocale() === 'en' ? 'Password changed successfully.' : 'تم تغيير كلمة المرور بنجاح.');
        } else {
            $this->addError('current_password', app()->getLocale() === 'fr' 
                ? 'Mot de passe actuel incorrect.' 
                : (app()->getLocale() === 'en' ? 'Incorrect current password.' : 'كلمة المرور الحالية غير صحيحة.'));
        }
    }

    public function render()
    {
        $user = Auth::user();
        if ($user) {
            $user->load(['country', 'wilaya', 'organization', 'roles', 'participant']);
        }

        return view('livewire.auth.user-profile', [
            'user' => $user,
        ]);
    }
}
