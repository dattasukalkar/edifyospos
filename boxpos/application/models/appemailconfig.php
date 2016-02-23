<?php
class AppEmailConfig extends CI_Model 
{
	
	function exists( $protocol )
	{
		$this->db->from('email_config');
		$this->db->where('protocol',$protocol);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	function get( $protocol )
	{
		$this->db->from('email_config');
		$this->db->where('protocol',$protocol);
		$query = $this->db->get();
		return $query->row();
	}
	function get_all()
	{
		$this->db->from('email_config');
		return $this->db->get();		
	}
	
	function save($data)
	{

	if($this->exists($data['protocol']))
	{
		$this->db->where('protocol', $data['protocol']);
		return $this->db->update('email_config',$data);
		
	}else{
		
		return $this->db->insert('email_config',$data);	
	}
		
			
	}
	
		
}

?>