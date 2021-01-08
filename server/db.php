<?php

date_default_timezone_set("Asia/Calcutta");

function Createdb() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "examsystem";

    // Create connection

    $connection = mysqli_connect($servername, $username, $password);

    // check connection

    if(!$connection) {
        die("Connection Failed:".mysqli_connect_err());
    }

    // Create Database

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    // establish the Connection with Database

    if(mysqli_query($connection, $sql)) {
        $connection = mysqli_connect($servername, $username, $password, $dbname);
        
        return $connection;
    }
    else { 
        echo "Error while Creating the Database".mysqli_error($connection);
    }  
}

function createTables() {

    $connection = Createdb();

    $sql = "CREATE TABLE IF NOT EXISTS admin_table (
            admin_id VARCHAR(10) PRIMARY KEY,
            admin_Name VARCHAR(20) NOT NULL,
            admin_email VARCHAR(30) NOT NULL UNIQUE,
            admin_password VARCHAR(15) NOT NULL
            )";
    
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO admin_table (admin_id, admin_Name, admin_email, admin_password) VALUES ('AD_Uday', 'Uday Ingale', 'uday.ingale@vit.edu', 'UdayIngale@11')";

    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS branches (
            branch_Id VARCHAR(4) PRIMARY KEY,
            branch_Name VARCHAR(50)
    )";

    mysqli_query($connection, $sql);

    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('CS', 'Computer Science')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('ELE', 'Electronics')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO branches (branch_Id, branch_Name) VALUES ('MEC', 'Mechanical')";
    mysqli_query($connection, $sql);


    $sql = "CREATE TABLE IF NOT EXISTS students (
            GR_No VARCHAR(10) PRIMARY KEY,
            first_Name VARCHAR(20) NOT NULL,
            middle_Name VARCHAR(20) NOT NULL,
            last_Name VARCHAR(20) NOT NULL,
            Email VARCHAR(35) NOT NULL UNIQUE,
            Department VARCHAR(80) NOT NULL,
            Pswd VARCHAR(12) NOT NULL,
            branch_Id VARCHAR(4),
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
            Personal_Email VARCHAR(35) UNIQUE,
            C_address VARCHAR(60),
            P_addess VARCHAR(60),
            contact_No VARCHAR(13),
            guardians_contact_No VARCHAR(13),
            Year VARCHAR(6),
            Semister VARCHAR(25),
            Divison VARCHAR(10),
            Roll_No VARCHAR(3),
            Elective_1 VARCHAR(80),
            Elective_2 VARCHAR(80),
            Elective_3 VARCHAR(80),
            classroom_1 VARCHAR(80),
            classroom_2 VARCHAR(80),
            classroom_3 VARCHAR(80)
    )";

    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS teachers (
        Ref_ID VARCHAR(10) PRIMARY KEY,
        first_Name VARCHAR(20) NOT NULL,
        middle_Name VARCHAR(20) NOT NULL,
        last_Name VARCHAR(20) NOT NULL,
        Email VARCHAR(35) NOT NULL UNIQUE,
        Department VARCHAR(80) NOT NULL,
        Pswd VARCHAR(12) NOT NULL,
        branch_Id VARCHAR(4),
        FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
        verified BOOLEAN,
        classroom_1 VARCHAR(80),
        classroom_2 VARCHAR(80),
        classroom_3 VARCHAR(80)
        )";

    mysqli_query($connection, $sql);

    $sql = "CREATE TABLE IF NOT EXISTS subjects (
            subject_id VARCHAR(10) PRIMARY KEY,
            branch_Id VARCHAR(4) NOT NULL,
            FOREIGN KEY(branch_Id) REFERENCES branches(branch_Id),
            year VARCHAR(5) NOT NULL,
            Semister VARCHAR(2) NOT NULL,
            subject_Name VARCHAR(80) NOT NULL   
    )";
    mysqli_query($connection, $sql);


        // Computer Science

        
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1011', 'CS', 'FY', '1', 'Computer Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1012', 'CS', 'FY', '1', 'Calculus')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1013', 'CS', 'FY', '1', 'Electronics Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1014', 'CS', 'FY', '1', 'Electrical Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1015', 'CS', 'FY', '1', 'Biomedical Engineering')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1021', 'CS', 'FY', '2', 'Applied Physics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1022', 'CS', 'FY', '2', 'Linear Algebra')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1023', 'CS', 'FY', '2', 'Engineering Mechanics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1024', 'CS', 'FY', '2', 'Engineering Graphics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_1025', 'CS', 'FY', '2', 'Chemical Engineering')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2011', 'CS', 'SY', '1', 'Fundamentals of Computer Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2012', 'CS', 'SY', '1', 'Digital and Analog Electronics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2013', 'CS', 'SY', '1', 'Data Structures Algorithm')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2014', 'CS', 'SY', '1', 'Python')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2015', 'CS', 'SY', '1', 'Probability and Statistics')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2021', 'CS', 'SY', '2', 'Object Oriented Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2022', 'CS', 'SY', '2', 'Advanced Data Structures')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2023', 'CS', 'SY', '2', 'Computer Graphics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2024', 'CS', 'SY', '2', 'Web Development')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_2025', 'CS', 'SY', '2', 'Discrete Mathematical Structures')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3011', 'CS', 'TY', '1', 'Microprocessor')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3012', 'CS', 'TY', '1', 'Theory of Computation')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3013', 'CS', 'TY', '1', 'Advance Java Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3014', 'CS', 'TY', '1', 'Computer Architecture and Operating System Design')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3015', 'CS', 'TY', '1', 'Artificial Intelligence')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3021', 'CS', 'TY', '2', 'Compiler Construction')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3022', 'CS', 'TY', '2', 'Architecting of IoT ')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3023', 'CS', 'TY', '2', 'Information Technology')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3024', 'CS', 'TY', '2', 'Database Management System')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_3025', 'CS', 'TY', '2', 'Computer Organization')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4011', 'CS', 'FINAL', '1', 'Machine Learning')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4012', 'CS', 'FINAL', '1', 'Design and Analysis Of Algorithm')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4013', 'CS', 'FINAL', '1', 'Network Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4014', 'CS', 'FINAL', '1', 'Software Development life cycles')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4015', 'CS', 'FINAL', '1', 'Android Application Development')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4021', 'CS', 'FINAL', '2', 'Software Testing and Quality Assurance')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4022', 'CS', 'FINAL', '2', 'Cloud Computing')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4023', 'CS', 'FINAL', '2', 'Computer Networks')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4024', 'CS', 'FINAL', '2', 'Data Mining and Ware Housing')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('CS_4025', 'CS', 'FINAL', '2', 'Deep Learning')";
    mysqli_query($connection, $sql);

    
        // Electronics

    
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1011', 'ELE', 'FY', '1', 'Computer Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1012', 'ELE', 'FY', '1', 'Calculus')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1013', 'ELE', 'FY', '1', 'Electronics Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1014', 'ELE', 'FY', '1', 'Electrical Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1015', 'ELE', 'FY', '1', 'Biomedical Engineering')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1021', 'ELE', 'FY', '2', 'Applied Physics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1022', 'ELE', 'FY', '2', 'Linear Algebra')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1023', 'ELE', 'FY', '2', 'Engineering Mechanics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1024', 'ELE', 'FY', '2', 'Engineering Graphics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_1024', 'ELE', 'FY', '2', 'Chemical Engineering')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2011', 'ELE', 'SY', '1', 'Data Structures')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2012', 'ELE', 'SY', '1', 'Digital Electronics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2013', 'ELE', 'SY', '1', 'Signal and System')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2014', 'ELE', 'SY', '1', 'Network Theory')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2015', 'ELE', 'SY', '1', 'Probability and Statistics')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2021', 'ELE', 'SY', '2', 'Analog Electronics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2022', 'ELE', 'SY', '2', 'Control Systems')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2023', 'ELE', 'SY', '2', 'Object Oriented Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2024', 'ELE', 'SY', '2', 'Electronic Communication')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_2025', 'ELE', 'SY', '2', 'Discrete Structure and Graph Theory')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3011', 'ELE', 'TY', '1', 'Microcontroller Applications')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3012', 'ELE', 'TY', '1', 'Power Elecronics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3013', 'ELE', 'TY', '1', 'Digital Signal Processing')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3014', 'ELE', 'TY', '1', 'Computer Architecture and Operating System')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3015', 'ELE', 'TY', '1', 'Artificial Intelligence')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3021', 'ELE', 'TY', '2', 'Digital System Design')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3022', 'ELE', 'TY', '2', 'Internet Of Things')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3023', 'ELE', 'TY', '2', 'Microwaves Application')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3024', 'ELE', 'TY', '2', 'Database Management System')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_3025', 'ELE', 'TY', '2', 'Antenna and Wave Propagation')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4011', 'ELE', 'FINAL', '1', 'Machine Learning')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4012', 'ELE', 'FINAL', '1', 'Design and Analysis Of Algorithem')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4013', 'ELE', 'FINAL', '1', 'Embedded System')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4014', 'ELE', 'FINAL', '1', 'Digital Image Processing')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4015', 'ELE', 'FINAL', '1', 'AdHoC Networks')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4021', 'ELE', 'FINAL', '2', 'Advance Power Electronics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4022', 'ELE', 'FINAL', '2', 'Cloud Computing')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4023', 'ELE', 'FINAL', '2', 'Computer Networks')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4024', 'ELE', 'FINAL', '2', 'VLSI Design')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('ELE_4025', 'ELE', 'FINAL', '2', 'Deep Learning')";
    mysqli_query($connection, $sql);


        // Mechanical


    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1011', 'MEC', 'FY', '1', 'Basics of Computer Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1012', 'MEC', 'FY', '1', 'Calculus')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1013', 'MEC', 'FY', '1', 'Applied Thermodynamics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1014', 'MEC', 'FY', '1', 'Electrical Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1015', 'MEC', 'FY', '1', 'Biomedical Engineering')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1021', 'MEC', 'FY', '2', 'Applied Physics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1022', 'MEC', 'FY', '2', 'Linear Algebra')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1023', 'MEC', 'FY', '2', 'Engineering Mechanics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1024', 'MEC', 'FY', '2', 'Engineering Graphics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_1025', 'MEC', 'FY', '2', 'Chemical Engineering')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2011', 'MEC', 'SY', '1', 'Data Structures')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2012', 'MEC', 'SY', '1', 'Strength of Materials')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2013', 'MEC', 'SY', '1', 'Manufacturing Process')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2014', 'MEC', 'SY', '1', 'Machine Drawing')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2015', 'MEC', 'SY', '1', 'Probability and Statistics')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2021', 'MEC', 'SY', '2', 'Fluid Mechanics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2022', 'MEC', 'SY', '2', 'Theory of Machines')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2023', 'MEC', 'SY', '2', 'Object Oriented Programming')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2024', 'MEC', 'SY', '2', 'Basics of Electronics Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_2025', 'MEC', 'SY', '2', 'Discrete Structure and Graph Theory')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3011', 'MEC', 'TY', '1', 'Engineering Metallurgy')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3012', 'MEC', 'TY', '1', 'Design of Machine Elements')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3013', 'MEC', 'TY', '1', 'Heat Transfer')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3014', 'MEC', 'TY', '1', 'Hydraulics and Pneumatics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3015', 'MEC', 'TY', '1', 'Machine Tool Design')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3021', 'MEC', 'TY', '2', 'Dynamics of Machinery')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3022', 'MEC', 'TY', '2', 'Machine Tool Design')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3023', 'MEC', 'TY', '2', 'Industrial Engineering ')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3024', 'MEC', 'TY', '2', 'Database Management System')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_3025', 'MEC', 'TY', '2', 'Robotics')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4011', 'MEC', 'FINAL', '1', 'Computational Fluid Dynamics')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4012', 'MEC', 'FINAL', '1', 'Finite Element Analysis')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4013', 'MEC', 'FINAL', '1', 'Advanced Manufacturing Processes')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4014', 'MEC', 'FINAL', '1', 'Product Design and Development')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4015', 'MEC', 'FINAL', '1', 'Operation Research')";
    mysqli_query($connection, $sql);

    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4021', 'MEC', 'FINAL', '2', 'Energy Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4022', 'MEC', 'FINAL', '2', 'Mechanical System Design')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4023', 'MEC', 'FINAL', '2', 'Automobile Engineering')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4024', 'MEC', 'FINAL', '2', 'Solar & Wind Energy')";
    mysqli_query($connection, $sql);
    $sql = "INSERT INTO subjects (subject_id, branch_Id, year, Semister, subject_Name) VALUES ('MEC_4025', 'MEC', 'FINAL', '2', 'Heating Ventilation and Air Conditioning')";
    mysqli_query($connection, $sql);




    $sql = "CREATE TABLE IF NOT EXISTS classrooms (
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
    )";

    mysqli_query($connection, $sql);
    

}

createTables();
?>
