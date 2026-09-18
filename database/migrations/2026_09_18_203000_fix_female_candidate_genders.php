<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $femaleNames = [
            'خديجة', 'منال', 'عائشة', 'فاطمة', 'فرح', 'نسرين', 'حنان', 'ابتسام', 'زينب', 'سارة', 
            'مريم', 'أمينة', 'هدى', 'أسماء', 'سميرة', 'ليلى', 'شيماء', 'سعاد', 'أميرة', 'ندى', 
            'صفاء', 'وئام', 'وفاء', 'خيرة', 'مباركة', 'جميلة', 'سليمة', 'نجاة', 'إلهام', 'حسيبة', 
            'سمية', 'سهام', 'كوثر', 'رميساء', 'رحمة', 'فتيحة', 'سامية', 'نجوى', 'نادية', 'صابرين', 
            'رجاء', 'بشرى', 'زهرة', 'زهيرة', 'وردة', 'دليلة', 'حكيمة', 'نورة', 'فتحية', 'ياسمين', 
            'آمال', 'دنيا', 'ريم', 'مروة', 'إيمان', 'أحلام', 'كنزة', 'صونية', 'سفانة', 'وهيبة'
        ];

        foreach ($femaleNames as $name) {
            DB::table('participant_profiles')
                ->where(function($q) use ($name) {
                    $q->where('first_name_ar', 'like', "{$name}%")
                      ->orWhere('first_name_ar', 'like', "% {$name}%");
                })
                ->where('first_name_ar', 'not like', '%محمد%')
                ->where('first_name_ar', 'not like', '%أحمد%')
                ->where('first_name_ar', 'not like', '%عبد%')
                ->where('first_name_ar', 'not like', '%علي%')
                ->where('first_name_ar', 'not like', '%أنور%')
                ->update(['gender' => 'female']);
        }
    }

    public function down(): void
    {
    }
};
