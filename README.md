# tymheredd

## TODO

    1. Add more fields to submission
        - temp
        - wifi
        - id 
        - battery

    2. Add temp sensor
    3. Add prog ID (resistor array?)
    4. Test with multiple submissions
    5. Test battery lifetime
    6. Design PCB
    7. Design case

## MySQL

CREATE DATABASE db;
USE db;
CREATE USER 'esp'@'localhost' IDENTIFIED BY 'test';
GRANT CREATE, ALTER, DROP, INSERT, UPDATE, DELETE, SELECT, REFERENCES, RELOAD on *.* TO 'esp'@'localhost' WITH GRANT OPTION;

