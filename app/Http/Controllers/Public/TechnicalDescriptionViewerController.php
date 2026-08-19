<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GuideSection;
use App\Models\Skill;
use Illuminate\Http\Request;

class TechnicalDescriptionViewerController extends Controller
{
    /**
     * Display official PDF documents (Skill TDs, Regulations, or Practical Guide).
     */
    public function show(string $key)
    {
        // 1. Try finding skill by id, uuid, or code
        $skill = Skill::where('code', $key)
            ->orWhere('uuid', $key)
            ->orWhere('id', is_numeric($key) ? (int)$key : 0)
            ->first();

        if ($skill && $skill->getPdfUrl()) {
            $pdfUrl = $skill->getPdfUrl();
            $path = parse_url($pdfUrl, PHP_URL_PATH);
            $localPath = public_path(ltrim($path, '/'));
            if (file_exists($localPath)) {
                return response()->file($localPath, [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($localPath) . '"',
                    'Cache-Control'       => 'public, max-age=3600',
                ]);
            }
        }

        // Try extracting TD number from key (e.g., td01_industrial_mechanics, SKILL-04, td04, 4)
        if (preg_match('/(?:td|skill[-_]?)?(\d+)/i', $key, $m)) {
            $num = (int)$m[1];
        }

        // 2. If it's a specific skill TD (1 to 64), serve WSC2026_TD{XX}_en.pdf
        if ($num && $num >= 1 && $num <= 64) {
            $numStr = sprintf('%02d', $num);
            $pdfPath = public_path("docs/td/WSC2026_TD{$numStr}_en.pdf");

            if (file_exists($pdfPath)) {
                return response()->file($pdfPath, [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="WSC2026_TD' . $numStr . '_en.pdf"',
                    'Cache-Control'       => 'public, max-age=3600',
                ]);
            }
        }

        // 2. If key is related to Rules / Reglement, serve Reglement.pdf!
        if (in_array(strtolower($key), ['rules', 'reglement', 'internal_rules', 'reglement_interieur'])) {
            $reglementPath = public_path("docs/Reglement.pdf");
            if (!file_exists($reglementPath) && file_exists(base_path("Reglement.pdf"))) {
                @copy(base_path("Reglement.pdf"), $reglementPath);
            }
            if (file_exists($reglementPath)) {
                return response()->file($reglementPath, [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="Reglement.pdf"',
                    'Cache-Control'       => 'public, max-age=3600',
                ]);
            }
        }

        // 3. For all other general guide sections (scoring, overview, structure, cards, etc.), serve GUIDE-PRATIQUE.pdf!
        $guidePdfPath = public_path("docs/GUIDE-PRATIQUE.pdf");
        if (!file_exists($guidePdfPath) && file_exists(base_path("GUIDE-PRATIQUE.pdf"))) {
            @copy(base_path("GUIDE-PRATIQUE.pdf"), $guidePdfPath);
        }

        if (file_exists($guidePdfPath)) {
            return response()->file($guidePdfPath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="GUIDE-PRATIQUE.pdf"',
                'Cache-Control'       => 'public, max-age=3600',
            ]);
        }

        // Fallback for general non-skill guide sections
        $guideSection = GuideSection::where('section_key', $key)->first();
        if (!$guideSection) {
            abort(404, 'المستند المطلوب غير موجود.');
        }

        return view('public.td-viewer', [
            'guideSection' => $guideSection,
            'key' => $key,
        ]);
    }
}
