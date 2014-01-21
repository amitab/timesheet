<?php

namespace Timesheet\Group;

class Group {
    private $groupId;
	private $groupName;
	
	public static function make($data) {
	    $group = new self();
	    $group->setGroupId($data['group_id']);
	    $group->setGroupName($data['group_name']);
	    return $group;
	}
	
	public function getGroupId () { return $this->groupId; }
	public function getGroupName () { return $this->groupName; }
	public function setGroupId ($groupId) { $this->groupId = $groupId; }
	public function setGroupName ($groupName) { $this->groupName = $groupName; }
} 