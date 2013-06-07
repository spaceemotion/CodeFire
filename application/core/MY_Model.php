<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public $table;

	function __construct($table = '', $database = null)
	{
		parent::__construct();

		$this->load->database($database);
		$this->table = $table;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	function find_id($id)
	{
		if ($id == NULL)
		{
			return NULL;
		}

		$this->db->where('id', $id);
		$query = $this->db->get($this->table);

		$result = $query->result();
		return (count($result) > 0 ? $result[0] : NULL);
	}

	function find_select()
	{
		$args = func_get_args();

		return $this->db->select(count($args) > 0 ? implode(', ', $args) : '*')->get($this->table)->result();
	}

	function find_all($sort = 'id', $order = 'asc')
	{
		$this->db->order_by($sort, $order);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	function update($id, $data)
	{
		return $this->updateWhere(array('id' => $id), $data);
	}

	function updateWhere($where, $data)
	{
		$this->db->where($where);
		$this->db->update($this->table, $data);
		
		return $this->db->affected_rows();
	}

	function delete($id)
	{
		if ($id != NULL)
		{
			$this->db->where('id', $id);
			$this->db->delete($this->table);
		}
	}

}

/* End of file MY_Model.php */
/* Location: ./application/models/MY_Model.php */