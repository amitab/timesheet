<?php

namespace Timesheet\Employee;

class EmployeeModel {
    private $employeeId;
    private $employeeName;
    private $employeeLocation;
    private $employeeProjects;
    private $employeeTimeSheets;
    private $employeeHours;
    private $employeeMail;
    
    public function setEmployeeId($employeeId) { $this->employeeId = $employeeId; }
    public function getEmployeeId() { return $this->employeeId; }
    public function setEmployeeName($employeeName) { $this->employeeName = $employeeName; }
    public function getEmployeeName() { return $this->employeeName; }
    public function setEmployeeLocation($employeeLocation) { $this->employeeLocation = $employeeLocation; }
    public function getEmployeeLocation() { return $this->employeeLocation; }
    public function setEmployeeProjects($employeeProjects) { $this->employeeProjects = $employeeProjects; }
    public function getEmployeeProjects() { return $this->employeeProjects; }
    public function setEmployeeTimesheets($employeeTimesheets) { $this->employeeTimesheets = $employeeTimesheets; }
    public function getEmployeeTimesheets() { return $this->employeeTimesheets; }
    public function setEmployeeHours($employeeHours) { $this->employeeHours = $employeeHours; }
    public function getEmployeeHours() { return $this->employeeHours; }
    public function setEmployeeMail($employeeMail) { $this->employeeMail = $employeeMail; }
    public function getEmployeeMail() { return $this->employeeMail; }
    
    // validation
    
    public static function validateEmail($email) {
        if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    
}