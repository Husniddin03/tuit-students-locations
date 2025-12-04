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

class StudentsDormitoryExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return Student::with('dormitory')->whereHas('dormitory')->get()->map(function ($student, $index) {
            $locationUrl = 'N/A';
            if ($student->latitude && $student->longitude) {
                $locationUrl = "https://www.google.com/maps?q={$student->latitude},{$student->longitude}";
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
                $locationUrl,
                // Yotoqxona ma'lumotlari
                $student->dormitory->dormitory ?? 'N/A',
                $student->dormitory->room ?? 'N/A',
                $student->dormitory->privileged . '%' ?? '0%',
                number_format($student->dormitory->amount ?? 0, 2, '.', ' ') . ' so\'m',
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
            'Viloyat',
            'Tuman',
            'Manzil',
            'Joylashuv',
            // Yotoqxona
            'Yotoqxona',
            'Xona',
            'Imtiyoz',
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
                    'startColor' => ['rgb' => '8B4513']
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
            'N' => 15,  // Viloyat
            'O' => 15,  // Tuman
            'P' => 30,  // Manzil
            'Q' => 40,  // Joylashuv link
            'R' => 25,  // Yotoqxona
            'S' => 10,  // Xona
            'T' => 10,  // Imtiyoz
            'U' => 18,  // To'lov
            'V' => 18,  // Sana
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
                                'startColor' => ['rgb' => 'F5E6D3']
                            ],
                        ]);
                    }
                }

                // Joylashuv ustunini hyperlink qilish
                for ($i = 2; $i <= $highestRow; $i++) {
                    $cellValue = $sheet->getCell('Q' . $i)->getValue();
                    if ($cellValue !== 'N/A' && strpos($cellValue, 'https://') === 0) {
                        $sheet->getCell('Q' . $i)->getHyperlink()->setUrl($cellValue);
                        $sheet->getCell('Q' . $i)->setValue('📍 Xaritada ko\'rish');
                        $sheet->getStyle('Q' . $i)->applyFromArray([
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
