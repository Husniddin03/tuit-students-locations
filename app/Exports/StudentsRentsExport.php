<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentsRentsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return Student::with('rent')->whereHas('rent')->get()->map(function ($student, $index) {
            $studentLocationUrl = 'N/A';
            if ($student->latitude && $student->longitude) {
                $studentLocationUrl = "https://www.google.com/maps?q={$student->latitude},{$student->longitude}";
            }

            $rentLocationUrl = 'N/A';
            if ($student->rent && $student->rent->latitude && $student->rent->longitude) {
                $rentLocationUrl = "https://www.google.com/maps?q={$student->rent->latitude},{$student->rent->longitude}";
            }

            return [
                $index + 1,
                (string)$student->student_id,
                $student->first_name,
                $student->last_name,
                $student->middle_name ?? 'N/A',
                $student->faculty,
                $student->group,
                $student->phone ?? 'N/A',
                $student->coach ?? 'N/A',
                $student->father ?? 'N/A',
                $student->mather ?? 'N/A',
                $student->father_phone ?? 'N/A',
                $student->mather_phone ?? 'N/A',
                $student->province ?? 'N/A',
                $student->region ?? 'N/A',
                $student->address ?? 'N/A',
                $studentLocationUrl,
                // Ijara ma'lumotlari
                $student->rent->province ?? 'N/A',
                $student->rent->region ?? 'N/A',
                $student->rent->address ?? 'N/A',
                $rentLocationUrl,
                $student->rent->type ?? 'N/A',
                $student->rent->owner_name ?? 'N/A',
                $student->rent->owner_phone ?? 'N/A',
                $student->rent->category ?? 'N/A',
                number_format($student->rent->contract ?? 0, 2, '.', ' ') . ' so\'m',
                number_format($student->rent->amount ?? 0, 2, '.', ' ') . ' so\'m',
                $student->created_at ? $student->created_at->format('d.m.Y H:i') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            '№',
            'ID raqami',
            'Ism',
            'Familiya',
            'Otasining ismi',
            'Fakultet',
            'Guruh',
            'Telefon',
            'Murabbiy',
            'Otasi',
            'Onasi',
            'Ota telefoni',
            'Ona telefoni',
            'Viloyat (talaba)',
            'Tuman (talaba)',
            'Manzil (talaba)',
            'Joylashuv (talaba)',
            // Ijara
            'Viloyat (ijara)',
            'Tuman (ijara)',
            'Manzil (ijara)',
            'Joylashuv (ijara)',
            'Turi',
            'Mulkdor ismi',
            'Mulkdor telefoni',
            'Kategoriya',
            'Shartnoma',
            'To\'lov summasi',
            'Sana',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28A745']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // №
            'B' => 20,  // ID
            'C' => 15,  // Ism
            'D' => 15,  // Familiya
            'E' => 15,  // Otasining ismi
            'F' => 25,  // Fakultet
            'G' => 12,  // Guruh
            'H' => 15,  // Telefon
            'I' => 20,  // Murabbiy
            'J' => 20,  // Otasi
            'K' => 20,  // Onasi
            'L' => 15,  // Ota telefoni
            'M' => 15,  // Ona telefoni
            'N' => 15,  // Viloyat (talaba)
            'O' => 15,  // Tuman (talaba)
            'P' => 30,  // Manzil (talaba)
            'Q' => 40,  // Joylashuv (talaba)
            'R' => 15,  // Viloyat (ijara)
            'S' => 15,  // Tuman (ijara)
            'T' => 30,  // Manzil (ijara)
            'U' => 40,  // Joylashuv (ijara)
            'V' => 15,  // Turi
            'W' => 20,  // Mulkdor
            'X' => 15,  // Mulkdor telefoni
            'Y' => 15,  // Kategoriya
            'Z' => 18,  // Shartnoma
            'AA' => 18, // To'lov
            'AB' => 18, // Sana
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Border
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Markazlash
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getRowDimension(1)->setRowHeight(30);

                // Zebra ranglash
                for ($i = 2; $i <= $highestRow; $i++) {
                    if ($i % 2 == 0) {
                        $sheet->getStyle('A' . $i . ':' . $highestColumn . $i)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'D4EDDA']
                            ],
                        ]);
                    }
                }

                // Joylashuv ustunlarini hyperlink qilish
                for ($i = 2; $i <= $highestRow; $i++) {
                    // Talaba joylashuvi (Q ustuni)
                    $cellValueQ = $sheet->getCell('Q' . $i)->getValue();
                    if ($cellValueQ !== 'N/A' && strpos($cellValueQ, 'https://') === 0) {
                        $sheet->getCell('Q' . $i)->getHyperlink()->setUrl($cellValueQ);
                        $sheet->getCell('Q' . $i)->setValue('📍 Xaritada ko\'rish');
                        $sheet->getStyle('Q' . $i)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '0563C1'],
                                'underline' => true,
                            ],
                        ]);
                    }

                    // Ijara joylashuvi (U ustuni)
                    $cellValueU = $sheet->getCell('U' . $i)->getValue();
                    if ($cellValueU !== 'N/A' && strpos($cellValueU, 'https://') === 0) {
                        $sheet->getCell('U' . $i)->getHyperlink()->setUrl($cellValueU);
                        $sheet->getCell('U' . $i)->setValue('📍 Xaritada ko\'rish');
                        $sheet->getStyle('U' . $i)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '0563C1'],
                                'underline' => true,
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
