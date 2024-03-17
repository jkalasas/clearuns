CREATE TABLE IF NOT EXISTS users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(100) NOT NULL,
	last_name VARCHAR(100) NOT NULL,
	middle_initial VARCHAR(2),
	suffix VARCHAR(10),
	is_admin BOOLEAN DEFAULT FALSE,
	is_faculty BOOLEAN DEFAULT FALSE,
	is_student BOOLEAN DEFAULT FALSE,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS school_year (
	id INT AUTO_INCREMENT PRIMARY KEY,
	start_year INT UNIQUE,
	end_year INT UNIQUE
);

CREATE TABLE IF NOT EXISTS department (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) UNIQUE NOT NULL,
	short_name VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS course (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) UNIQUE NOT NULL,
	short_name VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS section (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(20) UNIQUE NOT NULL
	semester ENUM("FIRST", "SECOND", "SUMMER") NOT NULL,
	adviser_id INT,
	course_id INT NOT NULL,
	school_year_id INT NOT NULL,

	UNIQUE (name, semester, adviser_id, course_id, school_year_id),

	CONSTRAINT fk_sections_advisers
		FOREIGN KEY (adviser_id)
		REFERENCES faculty(id),
	
	CONSTRAINT fk_sections_courses
		FOREIGN KEY (course_id)
		REFERENCES course(id),

	CONSTRAINT fk_sections_school_years
		FOREIGN KEY (school_year_id)
		REFERENCES school_year(id)
);

CREATE TABLE IF NOT EXISTS faculty_profile (
	user_id INT PRIMARY KEY,
	is_adviser BOOLEAN DEFAULT FALSE,
	department_id INT NOT NULL,

	CONSTRAINT fk_faculty_profiles_users
		FOREIGN KEY (user_id)
		REFERENCES user(id),
	
	CONSTRAINT fk_faculty_profiles_departments
		FOREIGN KEY (id)
		REFERENCES department(id)
);

CREATE TABLE IF NOT EXISTS student_profile (
	user_id INT PRIMARY KEY,
	is_irregular BOOLEAN DEFAULT FALSE,
	year_level INT NOT NULL,
	course_id INT NOT NULL,

	CONSTRAINT fk_student_profiles_users
		FOREIGN KEY (user_id)
		REFERENCES user(id),

	CONSTRAINT fk_student_profiles_courses
		FOREIGN KEY (course_id)
		REFERENCES course(id)
);

CREATE TABLE IF NOT EXISTS student_section (
	student_id INT NOT NULL,
	section_id INT NOT NULL,

	PRIMARY KEY (student_id, section_id),

	CONSTRAINT fk_student_sections_students
		FOREIGN KEY (student_id)
		REFERENCES student_profile(id),

	CONSTRAINT fk_student_sections_sections
		FOREIGN KEY (section_id)
		REFERENCES section(id)
);
