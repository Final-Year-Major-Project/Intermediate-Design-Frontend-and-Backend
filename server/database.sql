CREATE TABLE IF NOT EXISTS admin_table (
            admin_id VARCHAR(10) PRIMARY KEY,
            admin_Name VARCHAR(20) NOT NULL,
            admin_email VARCHAR(30) NOT NULL UNIQUE,
            admin_password VARCHAR(15) NOT NULL
        );

INSERT INTO admin_table (admin_id, admin_Name, admin_email, admin_password) 
VALUES ('AD_Uday', 'Uday Ingale', 'uday.ingale@vit.edu', 'UdayIngale@11');

CREATE TABLE IF NOT EXISTS branches (
            branch_Id VARCHAR(4) PRIMARY KEY,
            branch_Name VARCHAR(50)
    );


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
    );

CREATE TABLE IF NOT EXISTS teachers (
        Ref_ID VARCHAR(10) PRIMARY KEY,
        first_Name VARCHAR(20) NOT NULL,
        middle_Name VARCHAR(20) NOT NULL,
        last_Name VARCHAR(20) NOT NULL,
        Email VARCHAR(35) NOT NULL UNIQUE,
        Department VARCHAR(80) NOT NULL,
        Pswd VARCHAR(12) NOT NULL,
        branch_Id VARCHAR(4),
        FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
        );


CREATE TABLE IF NOT EXISTS subjects (
            subject_id VARCHAR(10) PRIMARY KEY,
            branch_Id VARCHAR(4) NOT NULL,
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
            year VARCHAR(5) NOT NULL,
            Semister VARCHAR(2) NOT NULL,
            subject_Name VARCHAR(80) NOT NULL   
    );

CREATE TABLE IF NOT EXISTS classrooms (
            classroom_id VARCHAR(10) PRIMARY KEY,
            classroom_name VARCHAR(80),
            Year VARCHAR(5),
            branch_Id VARCHAR(4),
            semister VARCHAR(6),
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),           
            professor_Name VARCHAR(15),
            Prof_Ref_Id VARCHAR(10),
            FOREIGN KEY(Prof_Ref_Id) REFERENCES teachers(Ref_ID),
            class_Description VARCHAR(50)
    );

