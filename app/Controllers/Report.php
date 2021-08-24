<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\SkepmaModel;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Report extends BaseController
{	
	use ResponseTrait;
	private $nama_menu = 'Laporan';
	public function __construct()
	{
		$this->MSkepma = new SkepmaModel();
	}

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Laporan', 'javascript:;');
		$data['breadcrumbs'] = $this->breadcrumb->render();

		return view('sistem/report/index', $data);
	}

  public function export_laporan_skepma(){
        // Parameter Laporan menggunakan query string tgl_awal dan tgl_akhir
        $tgl_awal = $this->request->getGet('tgl_awal'); 
        $tgl_akhir = $this->request->getGet('tgl_akhir'); 

        $tgl_awal = format_tanggal($tgl_awal, 'Y-m-d');
        $tgl_akhir = format_tanggal($tgl_akhir, 'Y-m-d');
        $lap_skepma = $this->MSkepma->getLaporanSkepma($tgl_awal, $tgl_akhir);
        $narasi = "TANGGAL ".tgl_indo($tgl_awal). " S/D " .tgl_indo($tgl_akhir);

        $spreadsheet = new Spreadsheet();
        // Set document properties
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
        $alignment_left = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;

        $spreadsheet->getProperties()->setCreator('ITATS')
                    ->setLastModifiedBy('ITATS')
                    ->setTitle('Laporan SKEPMA')
                    ->setKeywords('Laporan SKEPMA');
        $spreadsheet->setActiveSheetIndex(0);

        $spreadsheet->getActiveSheet()->mergeCells('A1:J1');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN SKEPMA');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal($alignment_center);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12)->setBold(true);
        
        $spreadsheet->getActiveSheet()->mergeCells('A2:J2');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $narasi);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal($alignment_center);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(12)->setBold(true);

        $border = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '2D2D2D'],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(35);
        
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A4', 'NO')
                    ->setCellValue('B4', 'NAMA KEGIATAN')
                    ->setCellValue('C4', 'NAMA MAHASISWA')
                    ->setCellValue('D4', 'TGL KEGIATAN')
                    ->setCellValue('E4', 'SEMESTER')
					          ->setCellValue('F4', 'KELOMPOK KEGIATAN')
                    ->setCellValue('G4', 'JENIS KEGIATAN')
                    ->setCellValue('H4', 'KATEGORI')
                    ->setCellValue('I4', 'JENIS AKTIVITAS')
                    ->setCellValue('J4', 'KETERANGAN')
        ;

        $spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal('center');
        foreach (range('A', 'J') as $column){
            $spreadsheet->getActiveSheet()->getStyle($column.'4')->applyFromArray($border);
        }

        $i=5; 
        $no=0;
        foreach($lap_skepma->getResult() as $row) { $no++;
            $tgl_kegiatan = format_tanggal($row->tgl_awal, 'd-m-Y'). ' s/d ' .format_tanggal($row->tgl_awal, 'd-m-Y');
            $kategori = $row->kategori . ' ('. $row->deskripsi .')';

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A'.$i, $no)
                ->setCellValue('B'.$i, $row->nama_kegiatan)
                ->setCellValue('C'.$i, $row->nama_mahasiswa)
                ->setCellValue('D'.$i, $tgl_kegiatan)
                ->setCellValue('E'.$i, $row->semester)
                ->setCellValue('F'.$i, $row->nama_kelompok_kegiatan)
                ->setCellValue('G'.$i, $row->jenis_kegiatan)
                ->setCellValue('H'.$i, $kategori)
                ->setCellValue('I'.$i, $row->jenis_aktivitas)
                ->setCellValue('J'.$i, $row->keterangan)
            ;

            foreach (range('A', 'J') as $column){
                $spreadsheet->getActiveSheet()->getStyle($column.$i)->applyFromArray($border);
                $spreadsheet->getActiveSheet()->getStyle($column.$i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }   

            $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal('center');
            $i++;
		    }
	
        $spreadsheet->getActiveSheet()->setTitle('Laporan SKEPMA');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan SKEPMA.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
  }

  public function export_laporan_rekap_kegiatan(){
    // Parameter Laporan menggunakan query string tgl_awal dan tgl_akhir
    $tgl_awal = $this->request->getGet('tgl_awal'); 
    $tgl_akhir = $this->request->getGet('tgl_akhir'); 

    $tgl_awal = format_tanggal($tgl_awal, 'Y-m-d');
    $tgl_akhir = format_tanggal($tgl_akhir, 'Y-m-d');
    $lap_skepma = $this->MSkepma->getLaporanRekapKegiatan($tgl_awal, $tgl_akhir);
    $narasi = "TANGGAL ".tgl_indo($tgl_awal). " S/D " .tgl_indo($tgl_akhir);

    $spreadsheet = new Spreadsheet();
    // Set document properties
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
    $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

    $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
    $alignment_left = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT;

    $spreadsheet->getProperties()->setCreator('ITATS')
                ->setLastModifiedBy('ITATS')
                ->setTitle('Laporan Rekapitulasi Kegiatan')
                ->setKeywords('Laporan Rekapitulasi Kegiatan');
    $spreadsheet->setActiveSheetIndex(0);

    $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN REKAPITULASI KEGIATAN');
    $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal($alignment_center);
    $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(12)->setBold(true);
    
    $spreadsheet->getActiveSheet()->mergeCells('A2:F2');
    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $narasi);
    $spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal($alignment_center);
    $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(12)->setBold(true);

    $border = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '2D2D2D'],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ],
    ];

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    
    $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'NAMA KEGIATAN')
                ->setCellValue('C4', 'KELOMPOK KEGIATAN')
                ->setCellValue('D4', 'DISETUJUI')
                ->setCellValue('E4', 'BELUM DISETUJUI')
                ->setCellValue('F4', 'TOTAL')
    ;

    $spreadsheet->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal('center');
    $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal('center');
    foreach (range('A', 'F') as $column){
        $spreadsheet->getActiveSheet()->getStyle($column.'4')->applyFromArray($border);
    }

    $i=5; 
    $no=0;
    foreach($lap_skepma->getResult() as $row) { $no++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $no)
            ->setCellValue('B'.$i, $row->nama_kegiatan)
            ->setCellValue('C'.$i, $row->kelompok_kegiatan)
            ->setCellValue('D'.$i, $row->disetujui)
            ->setCellValue('E'.$i, $row->belum_disetujui)
            ->setCellValue('F'.$i, $row->total)
        ;

        foreach (range('A', 'F') as $column){
            $spreadsheet->getActiveSheet()->getStyle($column.$i)->applyFromArray($border);
            $spreadsheet->getActiveSheet()->getStyle($column.$i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }   

        $spreadsheet->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('E'.$i)->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('F'.$i)->getAlignment()->setHorizontal('center');
        $i++;
    }

    $spreadsheet->getActiveSheet()->setTitle('Rekap Kegiatan');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan Rekapitulasi Kegiatan.xlsx"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
  }
}
