<?php

namespace App\Services;

class PriceCalculator
{
    // Harga dasar per jenis layanan (Rupiah)
    private const BASE_PRICES = [
        'multiple_choice' => 5000,  // Per soal pilihan ganda
        'essay' => 15000,           // Per soal esai
        'calculation' => 12000,     // Per soal hitungan
        'project' => 50000,         // Per project
        'coding' => 75000,          // Per project coding
    ];

    // Bobot skor untuk setiap parameter (0-100)
    private const WEIGHTS = [
        'question_type' => [
            'multiple_choice' => 10,
            'essay' => 30,
            'calculation' => 25,
            'project' => 50,
            'coding' => 60,
        ],
        'subject_complexity' => [
            'low' => 5,      // Matematika SD, Bahasa Indonesia
            'medium' => 15,  // Fisika SMA, Kimia
            'high' => 25,    // Kalkulus, Pemrograman, Statistika
        ],
        'quantity' => [
            '1-5' => 5,
            '6-10' => 10,
            '11-20' => 15,
            '21+' => 20,
        ],
        'explanation' => [
            'no' => 0,
            'yes' => 15,
        ],
        'deadline' => [
            'relaxed' => 0,      // > 7 hari
            'normal' => 10,      // 3-7 hari
            'urgent' => 25,      // 1-2 hari
            'very_urgent' => 40, // < 24 jam
        ],
    ];

    // Pengali kesulitan
    private const DIFFICULTY_MULTIPLIERS = [
        'easy' => 1.0,    // Skor 0-33
        'medium' => 1.5,  // Skor 34-66
        'hard' => 2.2,    // Skor 67-100
    ];

    /**
     * Hitung harga otomatis berdasarkan parameter
     * 
     * @param string $questionType Jenis soal (multiple_choice, essay, calculation, project, coding)
     * @param string $subject Mata pelajaran
     * @param int $questionCount Jumlah soal/halaman
     * @param bool $needsExplanation Butuh penjelasan detail
     * @param int $deadlineHours Deadline dalam jam
     * @return array ['base_price' => int, 'difficulty_score' => int, 'difficulty_level' => string, 'multiplier' => float, 'final_price' => int]
     */
    public function calculate(
        string $questionType,
        string $subject,
        int $questionCount,
        bool $needsExplanation,
        int $deadlineHours
    ): array {
        // 1. Hitung skor kesulitan
        $score = $this->calculateDifficultyScore(
            $questionType,
            $subject,
            $questionCount,
            $needsExplanation,
            $deadlineHours
        );

        // 2. Tentukan level kesulitan
        $difficultyLevel = $this->getDifficultyLevel($score);

        // 3. Ambil harga dasar
        $basePrice = self::BASE_PRICES[$questionType] ?? 10000;

        // 4. Ambil pengali
        $multiplier = self::DIFFICULTY_MULTIPLIERS[$difficultyLevel];

        // 5. Hitung harga per unit
        $pricePerUnit = $basePrice * $multiplier;

        // 6. Hitung harga total
        $finalPrice = $pricePerUnit * $questionCount;

        // 7. Bulatkan ke ribuan terdekat
        $finalPrice = ceil($finalPrice / 1000) * 1000;

        return [
            'base_price' => $basePrice,
            'difficulty_score' => $score,
            'difficulty_level' => $difficultyLevel,
            'multiplier' => $multiplier,
            'calculated_price' => $finalPrice,
            'question_count' => $questionCount,
            'price_per_unit' => ceil($pricePerUnit / 1000) * 1000,
        ];
    }

    /**
     * Hitung total skor kesulitan (0-100)
     */
    private function calculateDifficultyScore(
        string $questionType,
        string $subject,
        int $questionCount,
        bool $needsExplanation,
        int $deadlineHours
    ): int {
        $score = 0;

        // 1. Skor dari jenis pertanyaan
        $score += self::WEIGHTS['question_type'][$questionType] ?? 0;

        // 2. Skor dari kompleksitas mata pelajaran
        $subjectComplexity = $this->getSubjectComplexity($subject);
        $score += self::WEIGHTS['subject_complexity'][$subjectComplexity];

        // 3. Skor dari jumlah
        $quantityRange = $this->getQuantityRange($questionCount);
        $score += self::WEIGHTS['quantity'][$quantityRange];

        // 4. Skor dari kebutuhan penjelasan
        $score += $needsExplanation ? self::WEIGHTS['explanation']['yes'] : self::WEIGHTS['explanation']['no'];

        // 5. Skor dari deadline
        $deadlineUrgency = $this->getDeadlineUrgency($deadlineHours);
        $score += self::WEIGHTS['deadline'][$deadlineUrgency];

        // Pastikan skor tidak lebih dari 100
        return min($score, 100);
    }

    /**
     * Tentukan kompleksitas mata pelajaran
     */
    private function getSubjectComplexity(string $subject): string
    {
        $subject = strtolower($subject);

        // Mata pelajaran kompleksitas tinggi
        $highComplexity = ['kalkulus', 'statistika', 'pemrograman', 'coding', 'algoritma', 'fisika kuantum', 'kimia organik'];
        foreach ($highComplexity as $keyword) {
            if (str_contains($subject, $keyword)) {
                return 'high';
            }
        }

        // Mata pelajaran kompleksitas sedang
        $mediumComplexity = ['fisika', 'kimia', 'matematika sma', 'akuntansi', 'ekonomi', 'biologi'];
        foreach ($mediumComplexity as $keyword) {
            if (str_contains($subject, $keyword)) {
                return 'medium';
            }
        }

        // Default: kompleksitas rendah
        return 'low';
    }

    /**
     * Tentukan range jumlah
     */
    private function getQuantityRange(int $count): string
    {
        if ($count >= 21) return '21+';
        if ($count >= 11) return '11-20';
        if ($count >= 6) return '6-10';
        return '1-5';
    }

    /**
     * Tentukan urgency deadline
     */
    private function getDeadlineUrgency(int $hours): string
    {
        if ($hours < 24) return 'very_urgent';
        if ($hours <= 48) return 'urgent';
        if ($hours <= 168) return 'normal'; // 7 hari
        return 'relaxed';
    }

    /**
     * Tentukan level kesulitan dari skor
     */
    private function getDifficultyLevel(int $score): string
    {
        if ($score >= 67) return 'hard';
        if ($score >= 34) return 'medium';
        return 'easy';
    }

    /**
     * Get detail breakdown kalkulasi untuk ditampilkan
     */
    public function getCalculationBreakdown(
        string $questionType,
        string $subject,
        int $questionCount,
        bool $needsExplanation,
        int $deadlineHours
    ): array {
        $result = $this->calculate($questionType, $subject, $questionCount, $needsExplanation, $deadlineHours);
        
        $subjectComplexity = $this->getSubjectComplexity($subject);
        $quantityRange = $this->getQuantityRange($questionCount);
        $deadlineUrgency = $this->getDeadlineUrgency($deadlineHours);

        return [
            'calculation' => $result,
            'breakdown' => [
                'question_type_score' => self::WEIGHTS['question_type'][$questionType] ?? 0,
                'subject_score' => self::WEIGHTS['subject_complexity'][$subjectComplexity],
                'quantity_score' => self::WEIGHTS['quantity'][$quantityRange],
                'explanation_score' => $needsExplanation ? self::WEIGHTS['explanation']['yes'] : 0,
                'deadline_score' => self::WEIGHTS['deadline'][$deadlineUrgency],
            ],
            'details' => [
                'question_type' => $questionType,
                'subject' => $subject,
                'subject_complexity' => $subjectComplexity,
                'question_count' => $questionCount,
                'quantity_range' => $quantityRange,
                'needs_explanation' => $needsExplanation,
                'deadline_hours' => $deadlineHours,
                'deadline_urgency' => $deadlineUrgency,
            ]
        ];
    }
}
