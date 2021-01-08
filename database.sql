CREATE TABLE IF NOT EXISTS admin_table (
            admin_id VARCHAR(10) PRIMARY KEY,
            admin_Name VARCHAR(20) NOT NULL,
            admin_email VARCHAR(30) NOT NULL UNIQUE,
            admin_password VARCHAR(15) NOT NULL
        );

INSERT INTO admin_table (admin_id, admin_Name, admin_email, admin_password) 
VALUES ('AD_Uday', 'Uday Ingale', 'uday.ingale@vit.edu', 'UdayIngale@11');


CREATE TABLE IF NOT EXISTS students (
            GR_No VARCHAR(10) PRIMARY KEY,
            first_Name VARCHAR(20) NOT NULL,
            middle_Name VARCHAR(20) NOT NULL,
            last_Name VARCHAR(20) NOT NULL,
            Email VARCHAR(35) NOT NULL UNIQUE,
            Department VARCHAR(40) NOT NULL,
            Pswd VARCHAR(12) NOT NULL,
            FOREIGN KEY(branch_Id) REFERENCES Branches(branch_Id) ON DELETE SET NULL
            Personal_Email VARCHAR(35) UNIQUE,
            C_address VARCHAR(60),
            P_addess VARCHAR(60),
            contact_No VARCHAR(12),
            guardians_contact_No VARCHAR(12),
            Semister VARCHAR(20),
            Divison VARCHAR(10),
            Roll_No VARCHAR(3),
            Elective_1 VARCHAR(30),
            Elective_2 VARCHAR(30),
            Elective_3 VARCHAR(30),
            Elective_4 VARCHAR(30)
    );

CREATE TABLE IF NOT EXISTS Branches (
            branch_Id VARCHAR(5) PRIMARY KEY,
            branch_Name VARCHAR(50),
            subjects INT(2),
            teachers INT(2),
            hod_id VARCHAR(10)
    );

CREATE TABLE IF NOT EXISTS subjects (
            FOREIGN KEY(branch_Id) REFERENCES Branches(branch_Id) ON DELETE SET NULL,
            subject_id VARCHAR(10),
            subject_Name VARCHAR(20)
    );

CREATE TABLE IF NOT EXISTS Classrooms (
            FOREIGN KEY(branch_Id) REFERENCES Branches(branch_Id) ON DELETE SET NULL,
            classroom_id VARCHAR(10),
            classroom_Name VARCHAR(20)
    );

CREATE TABLE IF NOT EXISTS teachers (
            Ref_ID VARCHAR(10) PRIMARY KEY,
            first_Name VARCHAR(20) NOT NULL,
            middle_Name VARCHAR(20) NOT NULL,
            last_Name VARCHAR(20) NOT NULL,
            Email VARCHAR(35) NOT NULL UNIQUE,
            Department VARCHAR(40) NOT NULL,
            Subjects VARCHAR(20) NOT NULL,
            Pswd VARCHAR(12) NOT NULL
    );