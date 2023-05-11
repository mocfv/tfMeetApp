# Track & Field Meet App

This app is going to be _awesome_.

## The Team
- Teacher: Mr. Joel Bundt - Math and Computer Science
- Industry Expert: [@dahlbyk](https://github.com/dahlbyk)
- Weirdo eating moss in the corner: Alex Nhan the peasant
- Knight: Dr. Sire Trey Knight Sr. Jr. LV of Papua New Guinea 
- Simeon Bundt is amazing

### Database Specifications
- schema name: tfmeets
    - tblmeets
        - ID
            - INT, Unsigned, Auto_increment, Primary Key
        - meetName
            - VARCHAR(45)
        - meetDate
            - DATE
        - location
            - VARCHAR(45)
    - tblevents
        - ID
            - CHAR(10), Primary Key
        - eventName
            - VARCHAR(45)
        - eventShort
            - VARCHAR(45)
        - hytekCode
            - VARCHAR(45)
    - months
        - num
            - VARCHAR(2)
        - month
            - VARCHAR(45)
    - tblentries
        - ID
            - INT, Unsigned, Auto_increment, Primary Key
        - nameLast
            - VARCHAR(45)
        - nameFirst
            - VARCHAR(45)
        - sex
            - CHAR(1)
        - teamCode
            - CHAR(6)
        - teamName
            - VARCHAR(45)
        - athleteGrade
            - CHAR(2)
        - combinedCode
            - CHAR(10)
        - hytekCode
            - VARCHAR(2)
        - eventCode
            - CHAR(6)
        - entryMark
            - VARCHAR(20)
        - division
            - INT, Unsigned
        - place
            - INT, Unsigned
        - points
            - double
        - measure
            - VARCHAR(10)
        - meetID
            - INT, Unsigned

