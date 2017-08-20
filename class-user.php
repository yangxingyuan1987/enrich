<?php
class user
{
    private $id;
    private $parentId;
    private $cost;
    private $benefit_direct;
    private $benefit_down;
    function __construct($id, $parentId)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->cost=0.0;
        $this->benefit_direct=0.0;
        $this->benefit_down=0.0;
    }
	public function addCost($cost)
	{
		$this->cost += $cost;
	}
	public function addBd($amount)
	{
		$this->benefit_direct += $amount;
	}
	public function addBdown($amount)
	{
		$this->benefit_down += $amount;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getParentId()
	{
		return $this->parentId;
	}
	public function getCost()
	{
		return $this->cost;
	}
	public function getBd()
	{
		return $this->benefit_direct;
	}
	public function getBdown()
	{
		return $this->benefit_down;
	}
	public function ureset()
	{
        $this->cost=0.0;
        $this->benefit_direct=0.0;
        $this->benefit_down=0.0;
	}
	public function toJSON()
	{
		return json_encode($this->toArray());
	}
	public function toArray()
	{
		return array('name'=>$this->id, 
					  'parentId'=>$this->parentId, 
					  'cost'=>$this->cost, 
					  'benefit_direct'=>$this->benefit_direct,
   		              'benefit_down'=>$this->benefit_down
					 );
	}
}
?>

