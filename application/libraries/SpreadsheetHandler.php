<?php 

defined('START_UPPER') or define('START_UPPER', 65);
defined('END_UPPER') or define('END_UPPER', 90);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class SpreadsheetHandler
{
	private $reader;
	private $CI;

	public function __construct()
	{
		$this->reader = new Xlsx(); 
		$this->CI =& get_instance();
	}

	public function read($filepath)
	{
		$spreadsheet 	= $this->reader->load($filepath);
		$sheet 			= $spreadsheet->getActiveSheet();
		return $sheet;
	}

	public function writeReport($data, $month, $year, $filename = 'report.xlsx')
	{
		ini_set('max_execution_time', 1000);

		$spreadsheet = new Spreadsheet();
		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$spreadsheet->setActiveSheetIndex(0);

		$headerStyle = [
			'font'	=> [
				'size'	=> 14,
				'name'	=> 'Arial',
				'bold'	=> true
			],
			'alignment'	=> [
				'horizontal'	=> PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'		=> PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			]
		];

		$activeSheet = $spreadsheet->getActiveSheet();
		$activeSheet->getSheetView()->setZoomScale(85);
		$activeSheet->getColumnDimension('A')->setWidth(3);
		$activeSheet->getColumnDimension('B')->setWidth(3);
		$activeSheet->getColumnDimension('C')->setWidth(38);
		$activeSheet->getColumnDimension('D')->setWidth(25);
		$activeSheet->getColumnDimension('E')->setWidth(20);
		$activeSheet->getColumnDimension('F')->setWidth(20);
		$activeSheet->getColumnDimension('G')->setWidth(20);
		$activeSheet->getColumnDimension('H')->setWidth(20);
		$activeSheet->getColumnDimension('I')->setWidth(8);
		$activeSheet->getColumnDimension('J')->setWidth(8);
		$activeSheet->getColumnDimension('K')->setWidth(20);
		$activeSheet->getColumnDimension('L')->setWidth(10);
		$activeSheet->getColumnDimension('M')->setWidth(10);
		$activeSheet->getColumnDimension('N')->setWidth(10);
		$activeSheet->getColumnDimension('O')->setWidth(10);
		$activeSheet->getColumnDimension('P')->setWidth(20);

		$activeSheet->mergeCells('A1:P1');
		$activeSheet->mergeCells('A2:P2');

		// title 
		$activeSheet->setCellValue('A1', 'LAPORAN REALISASI FISIK DAN KEUANGAN');
		$activeSheet->getStyle('A1')->applyFromArray($headerStyle);
		
		// subtitle
		$activeSheet->setCellValue('A2', 'TAHUN ANGGARAN ' . $year);
		$activeSheet->getStyle('A2')->applyFromArray($headerStyle);

		$titleStyle = [
			'font'	=> [
				'size'	=> 10,
				'name'	=> 'Arial'
			],
			'alignment'	=> [
				'vertical'	=> PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
			]
		];

		$activeSheet->setCellValue('A4', 'SKPD: DINAS PU BINA MARGA DAN TATA RUANG PROVINSI SUMATERA SELATAN');
		$activeSheet->getStyle('A4')->applyFromArray($titleStyle);

		$activeSheet->setCellValue('A5', 'STATUS: ' . $month . ' ' . $year);
		$activeSheet->getStyle('A5')->applyFromArray($titleStyle);

		$this->setTableHeader($activeSheet);
		$this->setColumnIndexRow($activeSheet);

		$row = 12;
		
		$administrationTotal 			= 0;
		$constructionTotal 				= 0;
		$contractValueTotal 			= 0;
		$administrationRealizationTotal = 0;
		$constructionRealizationTotal 	= 0;
		$administrationRemainingTotal 	= 0;
		$constructionRemainingTotal 	= 0;

		$i = 0;
		$alphabet = range('a', 'z');
		foreach ($data as $type => $projects)
		{
			$startRow = $row - 1;
			$this->setProjectHeaderRow($activeSheet, $row, $this->numberToRoman($i + 1) . '.', $type);

			foreach ($projects as $j => $project)
			{
				$row += 2;
				$headerRow = $row;
				$projectValue = 0;

				foreach ($project->items as $k => $item)
				{
					$projectValue += $item->budget_ceiling;
					$row += 2;
					switch ($item->item_type)
					{
						case 'Financial':
							$realization = 0;
							if (count($item->financial_histories) > 0)
							{
								$realization = $item->financial_histories[0]->realization;
							}

							$this->setFinancialHistoryRow($activeSheet, $row, $alphabet[$k], $item->name, number_format($item->budget_ceiling, 2, ',', '.'), round(($realization / $item->budget_ceiling) * 100, 2), number_format($realization, 2, ',', '.'), number_format($item->budget_ceiling - $realization, 2, ',', '.'));

							$administrationTotal += $item->budget_ceiling;
							$administrationRealizationTotal += $realization;
							$administrationRemainingTotal += ($item->budget_ceiling - $realization);
							break;

						case 'Physical';
							$target 		= 0;
							$planning 		= 0;
							$realization 	= 0;

							if (count($item->physical_histories) > 0)
							{
								$target 		= $item->physical_histories[0]->target;
								$planning 		= $item->physical_histories[0]->planning;
								$realization 	= $item->physical_histories[0]->realization;
							}

							$percentageRealization = round(($realization / $item->budget_ceiling) * 100, 2);

							$this->setPhysicalHistoryRow($activeSheet, $row, $alphabet[$k], $item->name, number_format($item->budget_ceiling, 2, ',', '.'), $project->supervisor, '100', '100', number_format($realization, 2, ',', '.'), $target, $planning, $percentageRealization, $percentageRealization - $planning, number_format($item->budget_ceiling - $realization, 2, ',', '.'));

							$constructionTotal += $item->budget_ceiling;
							$constructionRealizationTotal += $realization;
							$constructionRemainingTotal += ($item->budget_ceiling - $realization);
							break;
					}
				}
				

				// $row += 3;
				// $this->setSupervisorCells($activeSheet, $row, 'Ir Bayazi', '5,00 KM', '38,00 KM');

				$row += 4;
				$this->setRowBorder($activeSheet, $startRow, $row);

				$this->setContractData($activeSheet, (int)($startRow + (($row - $startRow) / 2)), $project->contract_number, date('d F Y', strtotime($project->contract_date)), number_format($project->contract_value, 2, ',', '.'));


				$this->setProjectSubheaderRow($activeSheet, $headerRow, $j + 1, $project->project_name, number_format($projectValue, 2, ',', '.'));

				$contractValueTotal += $project->contract_value;
				$row += 2;
			}
			

			$i++;
		}

		$this->setProjectFooterRow($activeSheet, $row - 1, $administrationTotal + $constructionTotal, $administrationTotal, $constructionTotal, $contractValueTotal, $administrationRealizationTotal, $constructionRealizationTotal, $administrationRemainingTotal, $constructionRemainingTotal);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output', 'xlsx');
	}

	private function setColumnIndexRow($activeSheet)
	{
		$this->setCellValue($activeSheet, 'A10', '1');
		$this->setCellValue($activeSheet, 'C10', '2');
		$this->setCellValue($activeSheet, 'D10', '3');
		$this->setCellValue($activeSheet, 'E10', '4');
		$this->setCellValue($activeSheet, 'F10', '5');
		$this->setCellValue($activeSheet, 'G10', '6');
		$this->setCellValue($activeSheet, 'H10', '7');
		$this->setCellValue($activeSheet, 'I10', '8');
		$this->setCellValue($activeSheet, 'J10', '9');
		$this->setCellValue($activeSheet, 'K10', '10');
		$this->setCellValue($activeSheet, 'L10', '11');
		$this->setCellValue($activeSheet, 'M10', '12');
		$this->setCellValue($activeSheet, 'N10', '13');
		$this->setCellValue($activeSheet, 'O10', '14');
		$this->setCellValue($activeSheet, 'P10', '15');
	}

	private function setRowBorder($activeSheet, $startRow, $endRow)
	{
		$this->setCellBorders($activeSheet->getStyle('A' . $startRow . ':A' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('B' . $startRow . ':C' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('D' . $startRow . ':D' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('E' . $startRow . ':E' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('F' . $startRow . ':F' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('G' . $startRow . ':G' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('H' . $startRow . ':H' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('I' . $startRow . ':I' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('J' . $startRow . ':J' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('K' . $startRow . ':K' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('L' . $startRow . ':L' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('M' . $startRow . ':M' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('N' . $startRow . ':N' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('O' . $startRow . ':O' . $endRow . ''));
		$this->setCellBorders($activeSheet->getStyle('P' . $startRow . ':P' . $endRow . ''));
	}

	private function setProjectHeaderRow($activeSheet, $row, $bullet, $headerTitle)
	{
		$activeSheet->setCellValue('A' . $row, $bullet);
		$this->setCellFontStyle($activeSheet->getStyle('A' . $row), true);
		$this->setCellTextCenter($activeSheet->getStyle('A' . $row));

		$activeSheet->setCellValue('B' . $row, $headerTitle);
		$this->setCellFontStyle($activeSheet->getStyle('B' . $row), true);
	}

	private function setProjectFooterRow($activeSheet, $row, $total, $administrationTotal, $constructionTotal, $contractValueTotal, $administrationRealizationTotal, $constructionRealizationTotal, $administrationRemainingTotal, $constructionRemainingTotal)
	{
		$this->setCellBorders($activeSheet->getStyle('A' . $row));
		$this->setCellBorders($activeSheet->getStyle('A' . ($row + 1)));
		$this->setCellBorders($activeSheet->getStyle('A' . ($row + 2)));

		$this->setCellBorders($activeSheet->getStyle('B' . $row . ':C' . $row));
		$this->setCellBorders($activeSheet->getStyle('B' . ($row + 1) . ':C' . ($row + 1)));
		$this->setCellBorders($activeSheet->getStyle('B' . ($row + 2) . ':C' . ($row + 2)));

		$remainingColumnDimensions = range('D', 'P');
		foreach ($remainingColumnDimensions as $col)
		{
			$this->setCellBorders($activeSheet->getStyle($col . $row));
			$this->setCellBorders($activeSheet->getStyle($col . ($row + 1)));
			$this->setCellBorders($activeSheet->getStyle($col . ($row + 2)));
		}

		$this->setFooterSegment($activeSheet, $row, 'C', 'TOTAL', 'JUMLAH ADMINISTRASI', 'JUMLAH KONSTRUKSI');
		$this->setFooterSegment($activeSheet, $row, 'D', number_format($administrationTotal + $constructionTotal, 2, ',', '.'), number_format($administrationTotal, 2, ',', '.'), number_format($constructionTotal, 2, ',', '.'));
		$this->setFooterSegment($activeSheet, $row, 'G', number_format($contractValueTotal, 2, ',', '.'), '-', number_format($contractValueTotal, 2, ',', '.'));
		$this->setFooterSegment($activeSheet, $row, 'K', number_format($administrationRealizationTotal + $constructionRealizationTotal, 2, ',', '.'), number_format($administrationRealizationTotal, 2, ',', '.'), number_format($constructionRealizationTotal, 2, ',', '.'));
		$this->setFooterSegment($activeSheet, $row, 'P', number_format($administrationRemainingTotal + $constructionRemainingTotal, 2, ',', '.'), number_format($administrationRemainingTotal, 2, ',', '.'), number_format($constructionRemainingTotal, 2, ',', '.'));
	}

	private function setFooterSegment($activeSheet, $row, $col, $val1, $val2, $val3)
	{
		$activeSheet->setCellValue($col . $row, $val1);
		$activeSheet->getStyle($col . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle($col . $row));
		$this->setCellFontStyle($activeSheet->getStyle($col . $row), true);

		$activeSheet->setCellValue($col . ($row + 1), $val2);
		$activeSheet->getStyle($col . ($row + 1))->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle($col . ($row + 1)));
		$this->setCellFontStyle($activeSheet->getStyle($col . ($row + 1)), true);

		$activeSheet->setCellValue($col . ($row + 2), $val3);
		$activeSheet->getStyle($col . ($row + 2))->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle($col . ($row + 2)));
		$this->setCellFontStyle($activeSheet->getStyle($col . ($row + 2)), true);
	}

	private function setProjectSubheaderRow($activeSheet, $row, $numbering, $subheaderTitle, $budgetCeilingTotal)
	{
		$activeSheet->setCellValue('A' . $row, $numbering);
		$this->setCellFontStyle($activeSheet->getStyle('A' . $row));
		$this->setCellTextCenter($activeSheet->getStyle('A' . $row));

		$activeSheet->setCellValue('C' . $row, $subheaderTitle);
		$activeSheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
		$this->setCellFontStyle($activeSheet->getStyle('C' . $row));

		$activeSheet->setCellValue('D' . $row, $budgetCeilingTotal);
		$this->setCellFontStyle($activeSheet->getStyle('D' . $row), true);
		$this->setCellTextCenter($activeSheet->getStyle('D' . $row));
	}

	private function setFinancialHistoryRow($activeSheet, $row, $bullet, $title, $budgetCeiling, $percentange, $budgetRealization, $remainingBudget)
	{
		$activeSheet->setCellValue('B' . $row, $bullet);
		$this->setCellFontStyle($activeSheet->getStyle('B' . $row));

		$activeSheet->setCellValue('C' . $row, $title);
		$activeSheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
		$this->setCellFontStyle($activeSheet->getStyle('C' . $row));

		$activeSheet->setCellValue('D' . $row, $budgetCeiling);
		$activeSheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('D' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('D' . $row));

		$activeSheet->setCellValue('J' . $row, $percentange);
		$activeSheet->getStyle('J' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('J' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('J' . $row));

		$activeSheet->setCellValue('K' . $row, $budgetRealization);
		$activeSheet->getStyle('K' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('K' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('K' . $row));

		$activeSheet->setCellValue('P' . $row, $remainingBudget);
		$activeSheet->getStyle('P' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('P' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('P' . $row));
	}

	private function setPhysicalHistoryRow($activeSheet, $row, $bullet, $title, $budgetCeiling, $serviceProvider, $target, $percentange, $budgetRealization, $physicalTarget, $percentagePlan, $physicalRealization, $deviation, $remainingBudget)
	{
		$activeSheet->setCellValue('B' . $row, $bullet);
		$this->setCellFontStyle($activeSheet->getStyle('B' . $row));

		$activeSheet->setCellValue('C' . $row, $title);
		$activeSheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
		$this->setCellFontStyle($activeSheet->getStyle('C' . $row));

		$activeSheet->setCellValue('D' . $row, $budgetCeiling);
		$activeSheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('D' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('D' . $row));

		$activeSheet->setCellValue('H' . $row, $serviceProvider);
		$activeSheet->getStyle('H' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('H' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('H' . $row));

		$activeSheet->setCellValue('I' . $row, $target);
		$activeSheet->getStyle('I' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('I' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('I' . $row));

		$activeSheet->setCellValue('J' . $row, $percentange);
		$activeSheet->getStyle('J' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('J' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('J' . $row));

		$activeSheet->setCellValue('K' . $row, $budgetRealization);
		$activeSheet->getStyle('K' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('K' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('K' . $row));

		$activeSheet->setCellValue('L' . $row, $physicalTarget);
		$activeSheet->getStyle('L' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('L' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('L' . $row));

		$activeSheet->setCellValue('M' . $row, $percentagePlan);
		$activeSheet->getStyle('M' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('M' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('M' . $row));

		$activeSheet->setCellValue('N' . $row, $physicalRealization);
		$activeSheet->getStyle('N' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('N' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('N' . $row));

		$activeSheet->setCellValue('O' . $row, $deviation);
		$activeSheet->getStyle('O' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('O' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('O' . $row));

		$activeSheet->setCellValue('P' . $row, $remainingBudget);
		$activeSheet->getStyle('P' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('P' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('P' . $row));
	}

	private function setContractData($activeSheet, $row, $contractNumber, $contractDate, $contractValue)
	{
		$activeSheet->setCellValue('E' . $row, $contractNumber);
		$activeSheet->getStyle('E' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('E' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('E' . $row));

		$activeSheet->setCellValue('F' . $row, $contractDate);
		$activeSheet->getStyle('F' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('F' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('F' . $row));

		$activeSheet->setCellValue('G' . $row, $contractValue);
		$activeSheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('G' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('G' . $row));
	}

	private function setSupervisorCells($activeSheet, $row, $supervisor, $effective, $functional)
	{
		$activeSheet->setCellValue('C' . $row, 'Fungsional: ' . $functional);
		$activeSheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('C' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('C' . $row));

		$row++;

		$activeSheet->setCellValue('C' . $row, 'Efektif: ' . $effective);
		$activeSheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('C' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('C' . $row));

		$row += 2;

		$activeSheet->setCellValue('C' . $row, $supervisor);
		$activeSheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
		$this->setCellTextCenter($activeSheet->getStyle('C' . $row));
		$this->setCellFontStyle($activeSheet->getStyle('C' . $row), true);
	
		return $row;
	}

	private function setTableHeader($activeSheet)
	{
		$activeSheet->mergeCells('A7:A9');
		$activeSheet->setCellValue('A7', 'No');
		$this->setCellTextCenter($activeSheet->getStyle('A7:A9'));
		$this->setCellBorders($activeSheet->getStyle('A7:A9'));
		$this->setCellFontStyle($activeSheet->getStyle('A7:A9'));

		$activeSheet->mergeCells('B7:C9');
		$activeSheet->setCellValue('B7', 'Program/Kegiatan/PPTK');
		$this->setCellTextCenter($activeSheet->getStyle('B7:C9'));
		$this->setCellBorders($activeSheet->getStyle('B7:C9'));
		$this->setCellFontStyle($activeSheet->getStyle('B7:C9'));

		$activeSheet->mergeCells('D7:D9');
		$activeSheet->setCellValue('D7', 'Plafon Anggaran');
		$this->setCellTextCenter($activeSheet->getStyle('D7:D9'));
		$this->setCellBorders($activeSheet->getStyle('D7:D9'));
		$this->setCellFontStyle($activeSheet->getStyle('D7:D9'));

		$activeSheet->mergeCells('E7:H7');
		$activeSheet->setCellValue('E7', 'Data Kontrak');
		$this->setCellTextCenter($activeSheet->getStyle('E7:H7'));
		$this->setCellBorders($activeSheet->getStyle('E7:H7'));
		$this->setCellFontStyle($activeSheet->getStyle('E7:H7'));

		$activeSheet->mergeCells('E8:E9');
		$activeSheet->setCellValue('E8', 'Nomor Kontrak');
		$this->setCellTextCenter($activeSheet->getStyle('E8:E9'));
		$this->setCellBorders($activeSheet->getStyle('E8:E9'));
		$this->setCellFontStyle($activeSheet->getStyle('E8:E9'));

		$activeSheet->mergeCells('F8:F9');
		$activeSheet->setCellValue('F8', 'Tanggal Kontrak');
		$this->setCellTextCenter($activeSheet->getStyle('F8:F9'));
		$this->setCellBorders($activeSheet->getStyle('F8:F9'));
		$this->setCellFontStyle($activeSheet->getStyle('F8:F9'));

		$activeSheet->setCellValue('G8', 'Nilai Kontrak');
		$activeSheet->setCellValue('G9', '(Rp.)');
		$this->setCellTextCenter($activeSheet->getStyle('G8'));
		$this->setCellTextCenter($activeSheet->getStyle('G9'));
		$this->setCellFontStyle($activeSheet->getStyle('G8'));
		$this->setCellFontStyle($activeSheet->getStyle('G9'));
		$activeSheet->getStyle('G9')->applyFromArray([
			'borders'	=> [
				'bottom'	=> [
					'borderStyle'	=> PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' 		=> ['argb' => '00000000']
				]
			]
		]);

		$activeSheet->mergeCells('H8:H9');
		$activeSheet->setCellValue('H8', 'Penyedia Jasa');
		$this->setCellTextCenter($activeSheet->getStyle('H8:H9'));
		$this->setCellBorders($activeSheet->getStyle('H8:H9'));
		$this->setCellFontStyle($activeSheet->getStyle('H8:H9'));

		$activeSheet->mergeCells('I7:K7');
		$activeSheet->setCellValue('I7', 'Realisasi Keuangan');
		$this->setCellTextCenter($activeSheet->getStyle('I7:K7'));
		$this->setCellBorders($activeSheet->getStyle('I7:K7'));
		$this->setCellFontStyle($activeSheet->getStyle('I7:K7'));

		$activeSheet->setCellValue('I8', 'Target');
		$activeSheet->setCellValue('I9', '(%)');
		$this->setCellTextCenter($activeSheet->getStyle('I8'));
		$this->setCellTextCenter($activeSheet->getStyle('I9'));
		$this->setCellFontStyle($activeSheet->getStyle('I8'));
		$this->setCellFontStyle($activeSheet->getStyle('I9'));
		$activeSheet->getStyle('I9')->applyFromArray([
			'borders'	=> [
				'bottom'	=> [
					'borderStyle'	=> PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' 		=> ['argb' => '00000000']
				],
				'right'		=> [
					'borderStyle'	=> PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' 		=> ['argb' => '00000000']
				]
			]
		]);

		$activeSheet->mergeCells('J8:K8');
		$activeSheet->setCellValue('J8', 'Realisasi');
		$this->setCellTextCenter($activeSheet->getStyle('J8:K8'));
		$this->setCellBorders($activeSheet->getStyle('J8:K8'));
		$this->setCellFontStyle($activeSheet->getStyle('J8:K8'));

		$activeSheet->setCellValue('J9', '(%)');
		$this->setCellTextCenter($activeSheet->getStyle('J9'));
		$this->setCellBorders($activeSheet->getStyle('J9'));
		$this->setCellFontStyle($activeSheet->getStyle('J9'));

		$activeSheet->setCellValue('K9', '(Rp.)');
		$this->setCellTextCenter($activeSheet->getStyle('K9'));
		$this->setCellBorders($activeSheet->getStyle('K9'));
		$this->setCellFontStyle($activeSheet->getStyle('K9'));

		$activeSheet->mergeCells('L7:O7');
		$activeSheet->setCellValue('L7', 'Realisasi Fisik');
		$this->setCellTextCenter($activeSheet->getStyle('L7:O7'));
		$this->setCellBorders($activeSheet->getStyle('L7:O7'));
		$this->setCellFontStyle($activeSheet->getStyle('L7:O7'));

		$activeSheet->setCellValue('L8', 'Target');
		$activeSheet->setCellValue('L9', 'Kinerja');
		$this->setCellTextCenter($activeSheet->getStyle('L8'));
		$this->setCellTextCenter($activeSheet->getStyle('L9'));
		$this->setCellBorders($activeSheet->getStyle('L8:L9'));
		$this->setCellFontStyle($activeSheet->getStyle('L8:L9'));

		$activeSheet->setCellValue('M8', 'Rencana');
		$activeSheet->setCellValue('M9', '(%)');
		$this->setCellTextCenter($activeSheet->getStyle('M8'));
		$this->setCellTextCenter($activeSheet->getStyle('M9'));
		$this->setCellBorders($activeSheet->getStyle('M8:M9'));
		$this->setCellFontStyle($activeSheet->getStyle('M8:M9'));

		$activeSheet->setCellValue('N8', 'Realisasi');
		$activeSheet->setCellValue('N9', '(%)');
		$this->setCellTextCenter($activeSheet->getStyle('N8'));
		$this->setCellTextCenter($activeSheet->getStyle('N9'));
		$this->setCellBorders($activeSheet->getStyle('N8:N9'));
		$this->setCellFontStyle($activeSheet->getStyle('N8:N9'));

		$activeSheet->setCellValue('O8', 'Deviasi');
		$activeSheet->setCellValue('O9', '(%)');
		$this->setCellTextCenter($activeSheet->getStyle('O8'));
		$this->setCellTextCenter($activeSheet->getStyle('O9'));
		$this->setCellBorders($activeSheet->getStyle('O8:O9'));
		$this->setCellFontStyle($activeSheet->getStyle('O8:O9'));

		$activeSheet->setCellValue('P7', 'Sisa');
		$activeSheet->setCellValue('P8', 'Dana');
		$activeSheet->setCellValue('P9', '(Rp.)');
		$this->setCellTextCenter($activeSheet->getStyle('P7'));
		$this->setCellTextCenter($activeSheet->getStyle('P8'));
		$this->setCellTextCenter($activeSheet->getStyle('P9'));
		$this->setCellBorders($activeSheet->getStyle('P7:P9'));
		$this->setCellFontStyle($activeSheet->getStyle('P7:P9'));
	}

	private function setCellValue($activeSheet, $cell, $value, $border = true, $bold = false)
	{
		$activeSheet->setCellValue($cell, $value);
		$this->setCellTextCenter($activeSheet->getStyle($cell));
		if ($border)
		{
			$this->setCellBorders($activeSheet->getStyle($cell));
		}
		
		$this->setCellFontStyle($activeSheet->getStyle($cell), $bold);
	}

	private function setCellBorders($cellStyles)
	{
		$cellStyles->applyFromArray([
			'borders'	=> [
				'outline'	=> [
					'borderStyle'	=> PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' 		=> ['argb' => '00000000']
				]
			]
		]);
	}

	private function setCellTextCenter($cellStyles)
	{
		$cellStyles->applyFromArray([
			'alignment'	=> [
				'vertical'		=> PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
				'horizontal'	=> PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
			]
		]);
	}

	private function setCellFontStyle($cellStyles, $bold = false, $fontStyle = 'Arial', $fontSize = 9)
	{
		$cellStyles->applyFromArray([
			'font'	=> [
				'size'	=> $fontSize,
				'name'	=> $fontStyle,
				'bold'	=> $bold
			]
		]);
	}

	public function write($data, $filename = 'export.xlsx')
	{
		$spreadsheet = new Spreadsheet();
		$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

		for ($i = 0; $i < count($data['contents']) - 1; $i++)
		{
			$spreadsheet->createSheet();
		}
		
		for ($k = 0; $k < count($data['contents']); $k++)
		{
			$spreadsheet->setActiveSheetIndex($k);
			$activeSheet = $spreadsheet->getActiveSheet();
			foreach ($data['contents'][$k]['content'] as $i => $row)
			{
				foreach ($row as $j => $cell)
				{
					$activeSheet->setCellValue(chr(START_UPPER + $j) . ($i + 1), $cell);
					$activeSheet->getStyle(chr(START_UPPER + $j) . ($i + 1))->applyFromArray([
						'font' => [
							'size'	=> 12,
							'name'	=> 'Times New Roman'
						]
					]);
				}
			}	
		}
		

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output', 'xlsx');
	}

	private function serialize($sheet)
	{
		$data 		= [];
		$columns 	= [];
		foreach ($sheet->getRowIterator() as $i => $row)
		{
			if ($i == 0)
			{
				continue;
			}

			$cellIterator 	= $row->getCellIterator();
			$record 		= [];
			$j = 0;
			foreach ($cellIterator as $cell)
			{
				if ($i == 1)
				{
					$columns []= $cell->getValue();
				}
				else
				{
					$record[$columns[$j]] = $cell->getValue();
				}
				$j++;
			}

			if ($i > 1)
			{
				$data []= $record;
			}
		}

		return $data;
	}

	// A function to return the Roman Numeral, given an integer
	private function numberToRoman($num) 
	{
		// Make sure that we only use the integer portion of the value
		$n = intval($num);
		$result = '';

		// Declare a lookup array that we will use to traverse the number:
		$lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
			'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
			'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

		foreach ($lookup as $roman => $value) 
		{
			// Determine the number of matches
			$matches = intval($n / $value);

			// Store that many characters
			$result .= str_repeat($roman, $matches);

			// Substract that from the number
			$n = $n % $value;
		}

		// The Roman numeral should be built, return it
		return $result;
	}
}