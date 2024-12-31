<?php

namespace App\Services;

class StringAnalyser
{
    // teste la presence d'un mot dans un texte et retourne un boolean

    public function is_correspondant(String $word, String $mot_recherche): bool
    {
        $mot_recherche_length = strlen($mot_recherche);

        similar_text(strtolower(substr($word, 0, $mot_recherche_length)), strtolower($mot_recherche), $percent);
        if ($word > 3 && $mot_recherche_length > 3) {
            if (strlen($word) > 0 && $mot_recherche_length > 0) {
                if ($mot_recherche_length <= 5) {
                    return $percent >= 75;
                } else {
                    return $percent >= 70;
                }
            }
        }
        return false;
    }
}
