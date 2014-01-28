CREATE TABLE user(
	user_id INT(20) PRIMARY KEY AUTO_INCREMENT,
	user_name VARCHAR(100),
    user_first_name VARCHAR(255),
    user_last_name VARCHAR(255),
	user_sex CHAR(1),
	user_email VARCHAR(100) UNIQUE,
	user_location VARCHAR(255),
    user_phone_number VARCHAR(13),
    user_image_url VARCHAR(255)
);

CREATE TABLE project(
	project_id INT(20) PRIMARY KEY AUTO_INCREMENT,
	project_name VARCHAR(100),
	project_about VARCHAR(100),
	project_description VARCHAR(255),
	project_status INT(1),
	project_time_alloted DATETIME,
	project_created_date DATETIME,
	project_manager_id INT(20),
	project_salary DOUBLE,
    project_state INT(1),
	FOREIGN KEY(project_manager_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE timesheet(
	timesheet_id INT(20) PRIMARY KEY AUTO_INCREMENT,
	timesheet_mark_time DATETIME,
    timesheet_date DATE,
	timesheet_project_name VARCHAR(100),
    timesheet_status INT(1)
);

CREATE TABLE task(
    task_id INT(20) PRIMARY KEY AUTO_INCREMENT,
    task_name VARCHAR(255),
    task_notes VARCHAR(255),
    task_timesheet_id INT(20),
	task_start_time DATETIME,
	task_end_time DATETIME,
	task_work_time FLOAT,
    task_location VARCHAR(255),
    task_status INT(1),
    FOREIGN KEY(task_timesheet_id) REFERENCES timesheet(timesheet_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE user_timesheet(
	user_id INT(20),
	timesheet_id INT(20),
	FOREIGN KEY(user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(timesheet_id) REFERENCES timesheet(timesheet_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE user_project(
	user_id INT(20),
	project_id INT(20),
	FOREIGN KEY(user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(project_id) REFERENCES project(project_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE project_timesheet(
	project_id INT(20),
	timesheet_id INT(20),
	FOREIGN KEY(timesheet_id) REFERENCES timesheet(timesheet_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(project_id) REFERENCES project(project_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE notification(
	notification_id INT(20) PRIMARY KEY AUTO_INCREMENT,
	notification_body VARCHAR(255),
	notification_priority INT(1),
	notification_read INT(1),
    notification_type INT(1),
    notification_subject_id INT(20)
);

CREATE TABLE user_notification(
	notification_id INT(20),
	from_user_id INT(20),
	to_user_id INT(20),
	FOREIGN KEY(to_user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(from_user_id) REFERENCES user(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(notification_id) REFERENCES notification(notification_id) ON DELETE CASCADE ON UPDATE CASCADE
);