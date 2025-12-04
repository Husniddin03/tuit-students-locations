<?php
namespace App\Exports;

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

class StudentsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return $this->students->map(function ($student, $index) {
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
                $student->province ?? 'N/A',
                $student->region ?? 'N/A',
                $student->address ?? 'N/A',
                $locationUrl,
                $student->father_phone ?? 'N/A',
                $student->mather_phone ?? 'N/A',
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
            'Viloyat',
            'Tuman',
            'Manzil',
            'Joylashuv',
            'Ota telefoni',
            'Ona telefoni',
            'Ro\'yxatdan o\'tgan',
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
                    'startColor' => ['rgb' => '4472C4']
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
            'A' => 5,
            'B' => 20,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 25,
            'G' => 12,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 15,
            'M' => 15,
            'N' => 30,
            'O' => 40,
            'P' => 15,
            'Q' => 15,
            'R' => 18,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A1:' . $highestColumn . $highestRow)
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                $sheet->getRowDimension(1)->setRowHeight(30);

                for ($i = 2; $i <= $highestRow; $i++) {
                    if ($i % 2 == 0) {
                        $sheet->getStyle('A' . $i . ':' . $highestColumn . $i)->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'E7E6E6']
                            ],
                        ]);
                    }
                }

                // Joylashuv ustunini hyperlink qilish
                for ($i = 2; $i <= $highestRow; $i++) {
                    $cellValue = $sheet->getCell('O' . $i)->getValue();
                    if ($cellValue !== 'N/A' && strpos($cellValue, 'https://') === 0) {
                        $sheet->getCell('O' . $i)->getHyperlink()->setUrl($cellValue);
                        $sheet->getCell('O' . $i)->setValue('📍 Xaritada ko\'rish');
                        $sheet->getStyle('O' . $i)->applyFromArray([
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