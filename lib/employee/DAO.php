<?php

namespace Timesheet\Eemployee;

interface DAO {
    // write only functions
    public function createEmployee($employeeDetails);
    public function editEmployee($employeeId);
    public function deleteEmployee($employeeId);

    // read only functions
    public function getAllEmployees();
    public function getEmployeeById($employeeId);
    public function getEmployeesUnderProjectId($projectId);
    public function getEmployeesUnderProjectName($projectName);
    public function getEmployeeByName($employeeName);
    public function getEmployeeProjects($employeeId);
    public function getEmployeeTimeSheets($employeeId);
    
}