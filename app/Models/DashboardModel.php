<?php namespace App\Models;
use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = "t_skepma";
    public function getDataDashboard(){
        $query  = $this->db->query("
            select 
            sum(case when status = '1' then 1 else 0 end) as proses_verifikasi,
            sum(case when status = '2' then 1 else 0 end) as diverifikasi,
            count(*) as total_kegiatan,
            (select count(*) as jml from m_kegiatan) as jenis_kegiatan
            from t_skepma 
        ");
        return $query;
    }

    public function getDashboardStatusKegiatan($tahun='2021'){
        $query  = $this->db->query("       
            select 
              (case 
              when status = '1' then 'Proses Verifikasi'
              when status = '2' then 'Diverifikasi'
              else '' end) as status,
              sum(case when EXTRACT(MONTH FROM created_at) = '01' then 1 else 0 end) as jan,
              sum(case when EXTRACT(MONTH FROM created_at) = '02' then 1 else 0 end) as feb,
              sum(case when EXTRACT(MONTH FROM created_at) = '03' then 1 else 0 end) as mar,
              sum(case when EXTRACT(MONTH FROM created_at) = '04' then 1 else 0 end) as apr,
              sum(case when EXTRACT(MONTH FROM created_at) = '05' then 1 else 0 end) as may,
              sum(case when EXTRACT(MONTH FROM created_at) = '06' then 1 else 0 end) as jun,
              sum(case when EXTRACT(MONTH FROM created_at) = '07' then 1 else 0 end) as jul,
              sum(case when EXTRACT(MONTH FROM created_at) = '08' then 1 else 0 end) as aug,
              sum(case when EXTRACT(MONTH FROM created_at) = '09' then 1 else 0 end) as sep,
              sum(case when EXTRACT(MONTH FROM created_at) = '10' then 1 else 0 end) as oct,
              sum(case when EXTRACT(MONTH FROM created_at) = '11' then 1 else 0 end) as nov,
              sum(case when EXTRACT(MONTH FROM created_at) = '12' then 1 else 0 end) as des
            from t_skepma
            where EXTRACT(YEAR FROM created_at) = '$tahun'
            group by status
        ");
        return $query;
    }
}
?>