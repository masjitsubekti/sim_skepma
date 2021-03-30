<?php namespace App\Models;
use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table = "app_config";

    public function app_config()
    {
        $data = $this->table($this->table)
		->where('id', 'CONF1')
		->limit(1)
		->get()
		->getRowArray();
        return $data;
    }
}
?>